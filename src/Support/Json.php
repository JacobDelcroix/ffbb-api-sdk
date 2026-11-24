<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use CoachBasket\Ffbb\Exceptions\FfbbResponseValidationException;
use JsonException;

/**
 * Décodage JSON tolérant (miroir de http_requests_utils.to_json_from_response).
 *
 * Certains endpoints FFBB renvoient un JSON légèrement corrompu
 * (virgule finale, tableaux concaténés « ][ », préfixe « "" », marqueur « KO »).
 */
final class Json
{
    public static function decode(string $body): mixed
    {
        $data = trim($body);

        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            // On tente une réparation ci-dessous.
        }

        if (str_ends_with($data, ',')) {
            $data = substr($data, 0, -1);
        }

        $data = str_replace(['][', 'KO'], [',', ''], $data);

        if (str_starts_with($data, '""')) {
            $data = substr($data, 2);
        }

        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new FfbbResponseValidationException('FFBB service returned invalid JSON', 0, $e);
        }
    }

    /**
     * Renvoie `data` si la réponse est enveloppée façon Directus ({"data": ...}).
     */
    public static function unwrapData(mixed $payload): mixed
    {
        if (is_array($payload) && array_key_exists('data', $payload)) {
            return $payload['data'];
        }

        return $payload;
    }

    public static function encode(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
