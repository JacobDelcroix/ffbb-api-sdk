<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Objet imbriqué DocumentFlyer (modèle Python, document_flyer.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class DocumentFlyer
{
    public function __construct(
        public ?string $charset = null,
        public ?string $credits = null,
        public ?string $description = null,
        public ?int $duration = null,
        public ?string $embed = null,
        public ?string $filename_disk = null,
        public ?string $filename_download = null,
        public ?int $filesize = null,
        public ?float $focal_point_x = null,
        public ?float $focal_point_y = null,
        public ?Folder $folder = null,
        public ?string $gradient_color = null,
        public ?int $height = null,
        public ?string $id = null,
        public ?string $location = null,
        public ?string $md5 = null,
        public mixed $metadata = null,
        public ?string $modified_by = null,
        public ?DateTimeImmutable $modified_on = null,
        /** @var list<mixed>|null */
        public ?array $newsbridge_labels = null,
        public ?string $newsbridge_media_id = null,
        public ?string $newsbridge_metadatas = null,
        public ?string $newsbridge_mission = null,
        public ?string $newsbridge_name = null,
        /** @var list<mixed>|null */
        public ?array $newsbridge_persons = null,
        public ?DateTimeImmutable $newsbridge_recorded_at = null,
        public ?string $source = null,
        public ?string $storage = null,
        public ?string $tags = null,
        public ?string $title = null,
        public ?string $type = null,
        public ?string $uploaded_by = null,
        public ?DateTimeImmutable $uploaded_on = null,
        public ?int $width = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            charset: Cast::string($data['charset'] ?? null),
            credits: Cast::string($data['credits'] ?? null),
            description: Cast::string($data['description'] ?? null),
            duration: Cast::int($data['duration'] ?? null),
            embed: Cast::string($data['embed'] ?? null),
            filename_disk: Cast::string($data['filename_disk'] ?? null),
            filename_download: Cast::string($data['filename_download'] ?? null),
            filesize: Cast::int($data['filesize'] ?? null),
            focal_point_x: Cast::float($data['focal_point_x'] ?? null),
            focal_point_y: Cast::float($data['focal_point_y'] ?? null),
            folder: Cast::object($data['folder'] ?? null, Folder::class),
            gradient_color: Cast::string($data['gradient_color'] ?? null),
            height: Cast::int($data['height'] ?? null),
            id: Cast::string($data['id'] ?? null),
            location: Cast::string($data['location'] ?? null),
            md5: Cast::string($data['md5'] ?? null),
            metadata: $data['metadata'] ?? null,
            modified_by: Cast::string($data['modified_by'] ?? null),
            modified_on: Cast::dateTime($data['modified_on'] ?? null),
            newsbridge_labels: Cast::listOf($data['newsbridge_labels'] ?? null, 'raw'),
            newsbridge_media_id: Cast::string($data['newsbridge_media_id'] ?? null),
            newsbridge_metadatas: Cast::string($data['newsbridge_metadatas'] ?? null),
            newsbridge_mission: Cast::string($data['newsbridge_mission'] ?? null),
            newsbridge_name: Cast::string($data['newsbridge_name'] ?? null),
            newsbridge_persons: Cast::listOf($data['newsbridge_persons'] ?? null, 'raw'),
            newsbridge_recorded_at: Cast::dateTime($data['newsbridge_recorded_at'] ?? null),
            source: Cast::string($data['source'] ?? null),
            storage: Cast::string($data['storage'] ?? null),
            tags: Cast::string($data['tags'] ?? null),
            title: Cast::string($data['title'] ?? null),
            type: Cast::string($data['type'] ?? null),
            uploaded_by: Cast::string($data['uploaded_by'] ?? null),
            uploaded_on: Cast::dateTime($data['uploaded_on'] ?? null),
            width: Cast::int($data['width'] ?? null),
            raw: $data,
        );
    }

    /**
     * @param  iterable<array<string, mixed>>  $items
     * @return list<self>
     */
    public static function collect(iterable $items): array
    {
        $out = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                $out[] = self::fromArray($item);
            }
        }

        return $out;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
