<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Data\CompetitionsItem;
use CoachBasket\Ffbb\Data\EngagementsItem;
use CoachBasket\Ffbb\Data\OrganismesItem;
use CoachBasket\Ffbb\Exceptions\FfbbHttpException;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Exceptions\FfbbTransportException;
use CoachBasket\Ffbb\Fields\FieldSet;
use CoachBasket\Ffbb\Fields\QueryFields;
use CoachBasket\Ffbb\Models\ClubContacts;
use CoachBasket\Ffbb\Models\EngagementContacts;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Support\ContactExtractor;
use CoachBasket\Ffbb\Support\Json;
use Throwable;

/**
 * Organismes (clubs, comités, ligues), équipes et contacts (miroir de OrganismeMixin).
 */
trait ManagesOrganismes
{
    /**
     * Détail d'un organisme : club, comité ou ligue (77 champs par défaut).
     *
     * Sur erreur (hors 404), l'organisme est reconstruit depuis Meilisearch.
     *
     * @param  list<string>|null  $fields
     */
    public function getOrganisme(int|string $organismeId, ?array $fields = null): ?OrganismesItem
    {
        return self::hydrateOne($this->fetchOrganisme($organismeId, $fields), OrganismesItem::class);
    }

    /**
     * Version allégée de getOrganisme() pour les contextes de recherche (31 champs).
     */
    public function getOrganismeForSearch(int|string $organismeId): ?OrganismesItem
    {
        return $this->getOrganisme($organismeId, QueryFields::organismeSearch());
    }

    /**
     * Uniquement les équipes engagées d'un club, avec leur compétition et leur poule.
     *
     * @return list<EngagementsItem>|null
     */
    public function getEquipes(int|string $organismeId): ?array
    {
        $organisme = $this->fetchOrganisme($organismeId, QueryFields::equipes());

        if ($organisme === null) {
            return null;
        }

        return EngagementsItem::collect(array_filter((array) ($organisme['engagements'] ?? []), 'is_array'));
    }

    /**
     * Liste de compétitions (par défaut : id et nom).
     *
     * @param  list<string>|null  $fields
     * @return list<CompetitionsItem>
     */
    public function listCompetitions(int $limit = 10, ?array $fields = null): array
    {
        return CompetitionsItem::collect($this->listDirectusItems(
            Config::ENDPOINT_COMPETITIONS,
            limit: $limit,
            fields: $fields !== null && $fields !== [] ? $fields : ['id', 'nom'],
            timeout: 3.0,
        ));
    }

    /**
     * Contacts d'un club : contact du club et membres (dirigeants).
     *
     * Contient des données personnelles : voir docs/legal.md.
     */
    public function getClubContacts(int|string $organismeId): ?ClubContacts
    {
        $organisme = $this->fetchOrganisme($organismeId);

        if ($organisme === null) {
            return null;
        }

        return new ClubContacts(
            organisme: OrganismesItem::fromArray($organisme),
            clubContact: ContactExtractor::clubInfo($organisme),
            membres: ContactExtractor::membres($organisme),
        );
    }

    /**
     * Contacts d'une équipe engagée : correspondant, entraîneur et adjoint.
     *
     * Contient des données personnelles : voir docs/legal.md.
     */
    public function getEngagementContacts(int|string $id): ?EngagementContacts
    {
        $engagement = $this->getDirectusItem(Config::ENDPOINT_ENGAGEMENTS, $id);

        if ($engagement === null) {
            return null;
        }

        $entraineurId = ContactExtractor::relatedId($engagement, ['idEntraineur', 'entraineur', 'id_entraineur']);
        $adjointId = ContactExtractor::relatedId($engagement, ['idEntraineurAdjoint', 'entraineurAdjoint', 'id_entraineur_adjoint', 'entraineur_adjoint']);

        $entraineur = $entraineurId !== null ? $this->getDirectusItem(Config::ENDPOINT_ENTRAINEURS, $entraineurId) : null;
        $adjoint = $adjointId !== null ? $this->getDirectusItem(Config::ENDPOINT_ENTRAINEURS, $adjointId) : null;

        return new EngagementContacts(
            engagement: EngagementsItem::fromArray($engagement),
            correspondant: ContactExtractor::correspondant($engagement),
            entraineur: ContactExtractor::entraineur($entraineur, 'entraineur'),
            entraineurAdjoint: ContactExtractor::entraineur($adjoint, 'entraineur_adjoint'),
        );
    }

    /**
     * Organisme brut Directus, ou reconstruit depuis Meilisearch si Directus échoue.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    protected function fetchOrganisme(int|string $organismeId, ?array $fields = null): ?array
    {
        $fields = $fields !== null && $fields !== [] ? $fields : QueryFields::organisme(FieldSet::Default);

        try {
            $data = Json::unwrapData($this->sendDirectus(
                new GetItem(Config::ENDPOINT_ORGANISMES, $organismeId, $fields, timeout: 3.0),
            ));
        } catch (FfbbNotFoundException) {
            return null;
        } catch (FfbbHttpException|FfbbTransportException) {
            try {
                return $this->fallback->organisme($organismeId);
            } catch (Throwable) {
                return null;
            }
        }

        if (! is_array($data) || $data === []) {
            return null;
        }

        $this->registry->registerFromOrganisme($data);

        return $data;
    }
}
