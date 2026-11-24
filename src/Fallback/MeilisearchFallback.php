<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Fallback;

use CoachBasket\Ffbb\Search\Index;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;

/**
 * Reconstitution des données Directus depuis Meilisearch quand Directus est coupé
 * par le WAF BunnyCDN (miroir de helpers/meilisearch_fallback.py).
 */
final class MeilisearchFallback
{
    public function __construct(
        private readonly MeilisearchSearcher $searcher,
        private readonly PouleCompetitionRegistry $registry,
    ) {}

    /**
     * Organisme et ses engagements, appariés sur `id` et `codeClub` exacts.
     *
     * @return array<string, mixed>|null
     */
    public function organisme(string|int $organismeId): ?array
    {
        $oid = trim((string) $organismeId);

        $hits = $this->searcher->searchIndex(Index::Organismes, [
            'q' => '"'.$oid.'"',
            'attributesToSearchOn' => ['id'],
            'limit' => 5,
        ]);

        $organisme = $this->firstWithId($hits, $oid);

        if ($organisme === null) {
            return null;
        }

        $code = $organisme['code'] ?? null;

        if (is_string($code) && $code !== '') {
            $engagements = $this->searcher->searchIndex(Index::Engagements, [
                'q' => '"'.$code.'"',
                'attributesToSearchOn' => ['codeClub'],
                'limit' => 1000,
            ]);

            $organisme['engagements'] = array_values(array_filter(
                $engagements,
                static fn (array $e): bool => ($e['codeClub'] ?? null) === $code,
            ));

            $this->registry->registerFromOrganisme($organisme);
        }

        return $organisme;
    }

    /**
     * Compétition reconstruite depuis l'index ffbbserver_competitions.
     *
     * @return array<string, mixed>|null
     */
    public function competition(string|int $competitionId): ?array
    {
        $cid = trim((string) $competitionId);

        if ($cid === '') {
            return null;
        }

        $hits = $this->searcher->searchIndex(Index::Competitions, [
            'q' => $cid,
            'attributesToSearchOn' => ['id'],
            'limit' => 50,
        ]);

        $competition = $this->firstWithId($hits, $cid);

        if ($competition === null) {
            return null;
        }

        $this->registry->registerFromCompetition($competition, $cid);

        // Dans Meilisearch, `phases` est une liste de chaînes : on la vide comme en Python.
        $phases = $competition['phases'] ?? null;

        if (is_array($phases) && array_filter($phases, static fn (mixed $p): bool => ! is_array($p)) !== []) {
            $competition['phases'] = [];
        }

        if (is_array($competition['saison'] ?? null)) {
            $saison = $competition['saison'];
            $competition['saison'] = ($saison['code'] ?? null) ?: (string) ($saison['id'] ?? '');
        }

        return $competition;
    }

    /**
     * Reconstitue une poule (rencontres + classement) depuis Meilisearch.
     *
     * Si la compétition n'expose pas les engagements, le classement est recalculé
     * à partir des rencontres jouées (2 pts victoire, 1 pt défaite).
     *
     * @return array<string, mixed>|null
     */
    public function poule(string|int $pouleId, string|int|null $competitionId = null): ?array
    {
        $pid = trim((string) $pouleId);

        if ($pid === '') {
            return null;
        }

        $meta = $this->registry->get($pid);
        $cid = $competitionId !== null && (string) $competitionId !== ''
            ? trim((string) $competitionId)
            : ($meta['competitionId'] ?? '');
        $pouleNom = $meta['pouleNom'] ?? '';

        $pouleEntry = null;

        if ($cid !== '') {
            $competition = $this->competition($cid);

            foreach ((array) ($competition['poules'] ?? []) as $poule) {
                if (is_array($poule) && (string) ($poule['id'] ?? '') === $pid) {
                    $pouleEntry = $poule;
                    $pouleNom = (string) ($poule['nom'] ?? '') ?: $pouleNom;
                    break;
                }
            }
        }

        if ($cid === '' && $pouleEntry === null) {
            return null;
        }

        $rencontresRaw = [];

        if ($cid !== '' && $pouleNom !== '') {
            $rencontresRaw = $this->searcher->searchIndex(Index::Rencontres, [
                'q' => '',
                'filter' => sprintf('competitionId.id = "%s" AND idPoule.nom = "%s"', $cid, str_replace('"', '\\"', $pouleNom)),
                'limit' => 500,
            ]);
        } elseif ($cid !== '') {
            $all = $this->searcher->searchIndex(Index::Rencontres, [
                'q' => '',
                'filter' => sprintf('competitionId.id = "%s"', $cid),
                'limit' => 500,
            ]);

            $rencontresRaw = array_values(array_filter(
                $all,
                static fn (array $r): bool => (string) (is_array($r['idPoule'] ?? null) ? ($r['idPoule']['id'] ?? '') : '') === $pid,
            ));
        }

        $rencontres = [];

        foreach ($rencontresRaw as $r) {
            $poule = $r['idPoule'] ?? [];
            $rPid = (string) (is_array($poule) ? ($poule['id'] ?? '') : $poule);

            if ($rPid !== '' && $rPid !== $pid) {
                continue;
            }

            if ($pouleNom === '' && is_array($poule) && ! empty($poule['nom'])) {
                $pouleNom = (string) $poule['nom'];
            }

            $rencontres[] = [
                'id' => (string) ($r['id'] ?? ''),
                'numero' => (string) ($r['numero'] ?? ''),
                'numeroJournee' => (string) ($r['numeroJournee'] ?? ''),
                'idPoule' => $pid,
                'competitionId' => $cid,
                'resultatEquipe1' => (string) ($r['resultatEquipe1'] ?? ''),
                'resultatEquipe2' => (string) ($r['resultatEquipe2'] ?? ''),
                'joue' => in_array($r['joue'] ?? null, [true, 1, '1'], true) ? 1 : 0,
                'nomEquipe1' => (string) ($r['nomEquipe1'] ?? ''),
                'nomEquipe2' => (string) ($r['nomEquipe2'] ?? ''),
                'logoEquipe1' => $this->logo($r['idOrganismeEquipe1'] ?? null),
                'logoEquipe2' => $this->logo($r['idOrganismeEquipe2'] ?? null),
                'date_rencontre' => (string) (($r['date_rencontre'] ?? null) ?: (($r['date'] ?? null) ?: '1970-01-01')),
            ];
        }

        $classements = [];
        $position = 0;

        foreach ((array) ($pouleEntry['engagements'] ?? []) as $engagement) {
            if (! is_array($engagement)) {
                continue;
            }

            $position++;
            $nom = (string) ($engagement['nom'] ?? '');

            $classements[] = $this->classementRow($pid, $cid, $position, (string) ($engagement['id'] ?? ''), $nom);
        }

        if ($classements === [] && $rencontres !== []) {
            $classements = $this->classementFromRencontres($pid, $cid, $rencontres);
        }

        return [
            'id' => $pid,
            'nom' => $pouleNom !== '' ? $pouleNom : "Poule {$pid}",
            'rencontres' => $rencontres,
            'classements' => $classements,
        ];
    }

    /**
     * Rencontres d'un club (l'index ne couvre qu'une fenêtre glissante d'environ 2 semaines).
     *
     * @return list<array<string, mixed>>
     */
    public function clubRencontres(string $clubCode): array
    {
        if (! ctype_alnum($clubCode)) {
            return [];
        }

        return $this->searcher->searchIndex(Index::Rencontres, [
            'q' => '',
            'filter' => sprintf('idOrganismeEquipe1.code = "%1$s" OR idOrganismeEquipe2.code = "%1$s"', $clubCode),
            'limit' => 1000,
        ]);
    }

    /**
     * @param  list<array<string, mixed>>  $rencontres
     * @return list<array<string, mixed>>
     */
    private function classementFromRencontres(string $pid, string $cid, array $rencontres): array
    {
        $teams = [];

        foreach ($rencontres as $r) {
            foreach (['nomEquipe1', 'nomEquipe2'] as $key) {
                $name = $r[$key];

                if ($name !== '' && ! isset($teams[$name])) {
                    $teams[$name] = ['nom' => $name, 'matchJoues' => 0, 'gagnes' => 0, 'perdus' => 0, 'points' => 0, 'paniersMarques' => 0, 'paniersEncaisses' => 0];
                }
            }

            if ($r['joue'] !== 1 || ! is_numeric($r['resultatEquipe1'] ?: '0') || ! is_numeric($r['resultatEquipe2'] ?: '0')) {
                continue;
            }

            $s1 = (int) ($r['resultatEquipe1'] ?: 0);
            $s2 = (int) ($r['resultatEquipe2'] ?: 0);
            $t1 = $r['nomEquipe1'];
            $t2 = $r['nomEquipe2'];

            if ($t1 === '' || $t2 === '' || ($s1 <= 0 && $s2 <= 0)) {
                continue;
            }

            foreach ([[$t1, $s1, $s2], [$t2, $s2, $s1]] as [$team, $for, $against]) {
                $teams[$team]['matchJoues']++;
                $teams[$team]['paniersMarques'] += $for;
                $teams[$team]['paniersEncaisses'] += $against;
            }

            if ($s1 !== $s2) {
                [$winner, $loser] = $s1 > $s2 ? [$t1, $t2] : [$t2, $t1];
                $teams[$winner]['gagnes']++;
                $teams[$winner]['points'] += 2;
                $teams[$loser]['perdus']++;
                $teams[$loser]['points'] += 1;
            }
        }

        $sorted = array_values($teams);

        // Tri stable décroissant sur (points, différence), comme sorted(..., reverse=True).
        usort($sorted, static fn (array $a, array $b): int => [$b['points'], $b['paniersMarques'] - $b['paniersEncaisses']]
            <=> [$a['points'], $a['paniersMarques'] - $a['paniersEncaisses']]);

        $rows = [];

        foreach ($sorted as $i => $team) {
            $position = $i + 1;
            $row = $this->classementRow($pid, $cid, $position, "meili_{$pid}_{$position}", $team['nom']);

            $rows[] = array_merge($row, [
                'points' => $team['points'],
                'matchJoues' => $team['matchJoues'],
                'gagnes' => $team['gagnes'],
                'perdus' => $team['perdus'],
                'paniersMarques' => $team['paniersMarques'],
                'paniersEncaisses' => $team['paniersEncaisses'],
                'difference' => $team['paniersMarques'] - $team['paniersEncaisses'],
                'quotient' => $team['paniersEncaisses'] > 0 ? round($team['paniersMarques'] / $team['paniersEncaisses'], 3) : 0.0,
            ]);
        }

        return $rows;
    }

    /**
     * @return array<string, mixed>
     */
    private function classementRow(string $pid, string $cid, int $position, string $engagementId, string $nom): array
    {
        return [
            'id' => "{$pid}_{$position}",
            'position' => $position,
            'idEngagement' => ['id' => $engagementId, 'nom' => $nom],
            'organisme' => ['id' => '', 'nom' => $nom],
            'idCompetition' => $cid,
            'idPoule' => ['id' => $pid],
            'points' => 0,
            'matchJoues' => 0,
            'gagnes' => 0,
            'perdus' => 0,
            'paniersMarques' => 0,
            'paniersEncaisses' => 0,
            'difference' => 0,
            'quotient' => 0.0,
        ];
    }

    private function logo(mixed $organisme): string
    {
        if (! is_array($organisme)) {
            return '';
        }

        $logo = $organisme['logo'] ?? '';

        return (string) (is_array($logo) ? ($logo['id'] ?? '') : $logo);
    }

    /**
     * @param  list<array<string, mixed>>  $hits
     * @return array<string, mixed>|null
     */
    private function firstWithId(array $hits, string $id): ?array
    {
        foreach ($hits as $hit) {
            if ((string) ($hit['id'] ?? '') === $id) {
                return $hit;
            }
        }

        return null;
    }
}
