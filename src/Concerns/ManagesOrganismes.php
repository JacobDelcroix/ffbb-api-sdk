<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
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
     * Détail d'un organisme (77 champs par défaut).
     *
     * Sur erreur (hors 404), l'organisme est reconstruit depuis Meilisearch.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getOrganisme(int|string $organismeId, ?array $fields = null): ?array
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

    /**
     * Version allégée de getOrganisme() pour les contextes de recherche (31 champs).
     *
     * @return array<string, mixed>|null
     */
    public function getOrganismeForSearch(int|string $organismeId): ?array
    {
        return $this->getOrganisme($organismeId, QueryFields::organismeSearch());
    }

    /**
     * Uniquement les équipes engagées d'un club.
     *
     * @return list<array<string, mixed>>|null
     */
    public function getEquipes(int|string $organismeId): ?array
    {
        $organisme = $this->getOrganisme($organismeId, QueryFields::equipes());

        if ($organisme === null) {
            return null;
        }

        return array_values(array_filter((array) ($organisme['engagements'] ?? []), 'is_array'));
    }

    /**
     * Liste de compétitions (par défaut : id + nom).
     *
     * @param  list<string>|null  $fields
     * @return list<array<string, mixed>>
     */
    public function listCompetitions(int $limit = 10, ?array $fields = null): array
    {
        return $this->listDirectusItems(
            Config::ENDPOINT_COMPETITIONS,
            limit: $limit,
            fields: $fields !== null && $fields !== [] ? $fields : ['id', 'nom'],
            timeout: 3.0,
        );
    }

    /**
     * Contacts d'un club : contact du club + membres (dirigeants).
     */
    public function getClubContacts(int|string $organismeId): ?ClubContacts
    {
        $organisme = $this->getOrganisme($organismeId);

        if ($organisme === null) {
            return null;
        }

        return new ClubContacts(
            organisme: $organisme,
            clubContact: ContactExtractor::clubInfo($organisme),
            membres: ContactExtractor::membres($organisme),
        );
    }

    /**
     * Contacts d'une équipe engagée : correspondant, entraîneur et adjoint.
     */
    public function getEngagementContacts(int|string $id): ?EngagementContacts
    {
        $engagement = $this->getEngagement($id);

        if ($engagement === null) {
            return null;
        }

        $entraineurId = ContactExtractor::relatedId($engagement, ['idEntraineur', 'entraineur', 'id_entraineur']);
        $adjointId = ContactExtractor::relatedId($engagement, ['idEntraineurAdjoint', 'entraineurAdjoint', 'id_entraineur_adjoint', 'entraineur_adjoint']);

        return new EngagementContacts(
            engagement: $engagement,
            correspondant: ContactExtractor::correspondant($engagement),
            entraineur: ContactExtractor::entraineur($entraineurId !== null ? $this->getEntraineur($entraineurId) : null, 'entraineur'),
            entraineurAdjoint: ContactExtractor::entraineur($adjointId !== null ? $this->getEntraineur($adjointId) : null, 'entraineur_adjoint'),
        );
    }
}
