<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Search;

/**
 * Filtrage des hits côté client (miroir des méthodes `is_valid_for_query`
 * de chaque *Hit Python) : un hit est gardé seulement si la requête
 * apparaît dans un de ses champs « nom ».
 */
final class HitMatcher
{
    /**
     * @param  array<string, mixed>  $hit
     */
    public static function matches(Index $index, array $hit, ?string $lowerQuery): bool
    {
        if ($lowerQuery === null || $lowerQuery === '') {
            return true;
        }

        return match ($index) {
            Index::Organismes => self::any($hit, $lowerQuery, ['nom', 'nomClubPro', 'engagements_noms'])
                || self::communeMatches($hit, $lowerQuery),
            Index::Rencontres => self::any($hit, $lowerQuery, ['gsId', 'id', 'nomEquipe1', 'nomEquipe2'])
                || self::officielsMatch($hit, $lowerQuery)
                || self::any(self::sub($hit, 'salle'), $lowerQuery, ['adresse', 'adresseComplement', 'libelle']),
            // Le SDK Python inverse les règles terrains / tournois (TerrainsHit modélise les tournois) :
            // on les applique ici aux bons index.
            Index::Terrains => self::any($hit, $lowerQuery, ['nom', 'rue'])
                || self::communeMatches($hit, $lowerQuery),
            Index::Salles => self::any($hit, $lowerQuery, ['adresse', 'adresseComplement', 'libelle', 'libelle2'])
                || self::communeMatches($hit, $lowerQuery),
            Index::Tournois => self::any($hit, $lowerQuery, ['nom', 'adresse', 'description', 'code', 'nomOrganisateur', 'siteChoisi'])
                || self::communeMatches($hit, $lowerQuery),
            Index::Pratiques => self::any($hit, $lowerQuery, [
                'titre', 'adresse', 'description', 'site_web', 'action',
                'adresse_salle', 'adresse_structure', 'nom_salle', 'nom_structure', 'ville_salle',
            ]),
            Index::Engagements => self::any($hit, $lowerQuery, ['nom', 'nomClub', 'nomEquipe', 'nomOrganisme']),
            Index::Formations => self::any($hit, $lowerQuery, ['title', 'domain', 'theme']),
            Index::Competitions => self::any($hit, $lowerQuery, ['nom', 'code', 'id', 'competition_origine', 'competition_origine_nom']),
            // Index de contenu (news, vidéos, RSS, galeries) : recherche dans tout le document.
            Index::News, Index::YoutubeVideos, Index::Rss, Index::Galeries => str_contains(
                mb_strtolower((string) json_encode($hit, JSON_UNESCAPED_UNICODE)),
                $lowerQuery,
            ),
        };
    }

    /**
     * Applique le filtre à un résultat Meilisearch et corrige estimatedTotalHits
     * (miroir de MultiSearchQuery.filter_result).
     *
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    public static function filterResult(MultiSearchQuery $query, array $result): array
    {
        $lower = $query->lowerQ();
        $hits = $result['hits'] ?? null;

        if ($lower === null || ! is_array($hits) || $hits === []) {
            return $result;
        }

        $valid = array_values(array_filter(
            $hits,
            static fn (mixed $hit): bool => is_array($hit) && self::matches($query->index, $hit, $lower),
        ));

        $removed = count($hits) - count($valid);

        if ($removed > 0) {
            if (isset($result['estimatedTotalHits']) && is_int($result['estimatedTotalHits'])) {
                $result['estimatedTotalHits'] -= $removed;
            }

            $result['hits'] = $valid;
        }

        return $result;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $keys
     */
    private static function any(array $data, string $needle, array $keys): bool
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;

            if ((is_string($value) || is_int($value)) && (string) $value !== ''
                && str_contains(mb_strtolower((string) $value), $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $hit
     */
    private static function communeMatches(array $hit, string $needle): bool
    {
        return self::any(self::sub($hit, 'commune'), $needle, ['libelle', 'departement']);
    }

    /**
     * Officiels : liste de chaînes (ancien format) ou de {"officiel": {"nom", "prenom"}}.
     *
     * @param  array<string, mixed>  $hit
     */
    private static function officielsMatch(array $hit, string $needle): bool
    {
        $officiels = $hit['officiels'] ?? null;

        if (! is_array($officiels)) {
            return false;
        }

        foreach ($officiels as $officiel) {
            if (is_string($officiel)) {
                $name = $officiel;
            } elseif (is_array($officiel)) {
                $o = is_array($officiel['officiel'] ?? null) ? $officiel['officiel'] : [];
                $name = trim(($o['nom'] ?? '').' '.($o['prenom'] ?? ''));
            } else {
                continue;
            }

            if (str_contains(mb_strtolower($name), $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function sub(array $data, string $key): array
    {
        return is_array($data[$key] ?? null) ? $data[$key] : [];
    }
}
