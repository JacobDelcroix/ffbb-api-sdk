<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Fallback;

/**
 * Correspondance poule → (compétition, nom de poule), alimentée au fil des
 * appels get_organisme / get_competition (miroir de _POULE_TO_COMP_CACHE).
 *
 * Sert à reconstruire une poule via Meilisearch quand Directus est bloqué.
 */
final class PouleCompetitionRegistry
{
    /** @var array<string, array{competitionId: string, pouleNom: string}> */
    private array $map = [];

    public function register(string|int|null $pouleId, string|int|null $competitionId, ?string $pouleNom = ''): void
    {
        $pid = trim((string) $pouleId);
        $cid = trim((string) $competitionId);

        if ($pid !== '' && $cid !== '') {
            $this->map[$pid] = ['competitionId' => $cid, 'pouleNom' => trim((string) $pouleNom)];
        }
    }

    /**
     * @return array{competitionId: string, pouleNom: string}|null
     */
    public function get(string|int $pouleId): ?array
    {
        return $this->map[trim((string) $pouleId)] ?? null;
    }

    /**
     * Enregistre les poules des engagements d'un organisme Directus/Meilisearch.
     *
     * @param  array<string, mixed>  $organisme
     */
    public function registerFromOrganisme(array $organisme): void
    {
        foreach ((array) ($organisme['engagements'] ?? []) as $engagement) {
            if (! is_array($engagement)) {
                continue;
            }

            $poule = $engagement['idPoule'] ?? [];
            $competition = $engagement['idCompetition'] ?? [];

            $this->register(
                is_array($poule) ? ($poule['id'] ?? null) : $poule,
                is_array($competition) ? ($competition['id'] ?? null) : $competition,
                is_array($poule) ? (string) ($poule['nom'] ?? '') : '',
            );
        }
    }

    /**
     * @param  array<string, mixed>  $competition
     */
    public function registerFromCompetition(array $competition, string|int $fallbackId): void
    {
        $cid = (string) ($competition['id'] ?? $fallbackId);

        foreach ((array) ($competition['poules'] ?? []) as $poule) {
            if (is_array($poule) && ! empty($poule['id'])) {
                $this->register($poule['id'], $cid, (string) ($poule['nom'] ?? ''));
            }
        }
    }
}
