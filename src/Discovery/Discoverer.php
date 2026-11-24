<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Discovery;

use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Requests\Meilisearch\SearchIndex;
use CoachBasket\Ffbb\Search\Index;
use CoachBasket\Ffbb\Support\Json;
use Throwable;

/**
 * Instantané de l'API FFBB (miroir de scripts/discover_endpoints.py) :
 * spec OpenAPI Directus + attributs observés sur un échantillon de chaque index Meilisearch.
 */
final class Discoverer
{
    /** Index sondés en plus de ceux utilisés par le SDK. */
    public const array EXTRA_INDEXES = [
        'ffbbserver_sessions',
        'genius_sport_matches',
        'genius_sports_live_logs',
        'rematch_videos',
        'edf_matches',
        'edf_players',
        'edf_teams',
    ];

    public function __construct(private readonly FfbbDataClient $ffbb) {}

    /**
     * Spec OpenAPI normalisée (clés triées, métadonnées volatiles retirées), ou null si inaccessible.
     *
     * @return array<string, mixed>|null
     */
    public function openApi(): ?array
    {
        $spec = $this->ffbb->getOpenapiSpec();

        return $spec === null ? null : self::normalize($spec);
    }

    /**
     * @return array<string, array{available: bool, attributes: list<string>, estimatedTotalHits: ?int}>
     */
    public function indexes(): array
    {
        $uids = array_values(array_unique([...array_map(static fn (Index $i): string => $i->value, Index::cases()), ...self::EXTRA_INDEXES]));
        sort($uids);

        $out = [];

        foreach ($uids as $uid) {
            $out[$uid] = $this->probe($uid);
        }

        return $out;
    }

    /**
     * @return array{available: bool, attributes: list<string>, estimatedTotalHits: ?int}
     */
    private function probe(string $uid): array
    {
        try {
            $response = $this->ffbb->search->connector()->send(new SearchIndex($uid, ['q' => '', 'limit' => 20]));
            $result = Json::decode($response->body());
        } catch (Throwable) {
            return ['available' => false, 'attributes' => [], 'estimatedTotalHits' => null];
        }

        if (! is_array($result)) {
            return ['available' => false, 'attributes' => [], 'estimatedTotalHits' => null];
        }

        $keys = [];

        foreach ((array) ($result['hits'] ?? []) as $hit) {
            if (is_array($hit)) {
                $keys += array_flip(array_map('strval', array_keys($hit)));
            }
        }

        $attributes = array_keys($keys);
        sort($attributes);

        return [
            'available' => true,
            'attributes' => $attributes,
            'estimatedTotalHits' => is_int($result['estimatedTotalHits'] ?? null) ? $result['estimatedTotalHits'] : null,
        ];
    }

    /**
     * @param  array<mixed>  $payload
     * @return array<mixed>
     */
    public static function normalize(array $payload): array
    {
        unset($payload['timestamp']);

        if (isset($payload['info']) && is_array($payload['info'])) {
            unset($payload['info']['version']);
        }

        foreach ($payload as $key => $value) {
            if (is_array($value)) {
                $payload[$key] = self::normalize($value);
            }
        }

        if (! array_is_list($payload)) {
            ksort($payload);
        }

        return $payload;
    }
}
