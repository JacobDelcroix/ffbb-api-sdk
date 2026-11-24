<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Directus;

use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Data\Item;
use CoachBasket\Ffbb\Data\ItemMap;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Directus\ListItems;
use CoachBasket\Ffbb\Support\Json;
use CoachBasket\Ffbb\Support\Transport;
use Generator;

/**
 * Query builder Directus complet, pour aller au-delà des méthodes reprises du SDK Python.
 *
 * Couvre tous les paramètres de l'API Items de Directus :
 * fields, filter, search, sort, limit, offset, page, aggregate, groupBy, deep, alias, meta.
 *
 *     $ffbb->directus('ffbbserver_rencontres')
 *         ->fields(['id', 'date_rencontre', 'nomEquipe1', 'nomEquipe2', 'resultatEquipe1', 'resultatEquipe2'])
 *         ->where('idPoule', '_eq', 200000002901234)
 *         ->where('joue', '_eq', 1)
 *         ->sort('-date_rencontre')
 *         ->limit(50)
 *         ->get();
 *
 * Les résultats sont des DTOs (RencontresItem…), ou des Item génériques pour une collection sans DTO.
 * Les variantes *Raw() renvoient les tableaux Directus, utiles pour les agrégats.
 *
 * @template T of object
 */
final class QueryBuilder
{
    /** @var list<string> */
    private array $fields = [];

    /** @var array<string, mixed> */
    private array $filter = [];

    private ?string $rawFilter = null;

    private ?string $search = null;

    /** @var list<string> */
    private array $sort = [];

    private ?int $limit = null;

    private ?int $offset = null;

    private ?int $page = null;

    /** @var array<string, list<string>> */
    private array $aggregate = [];

    /** @var list<string> */
    private array $groupBy = [];

    /** @var array<string, mixed> */
    private array $deep = [];

    /** @var array<string, string> */
    private array $alias = [];

    private ?string $meta = null;

    private readonly string $collection;

    /** @var class-string */
    private readonly string $dtoClass;

    /**
     * @param  class-string<T>|string  $collection  nom de collection (« ffbbserver_rencontres ») ou classe DTO
     */
    public function __construct(
        private readonly ApiFfbbConnector $connector,
        string $collection,
    ) {
        if (class_exists($collection) && defined($collection.'::COLLECTION')) {
            $this->dtoClass = $collection;
            $this->collection = (string) constant($collection.'::COLLECTION');
        } else {
            $this->collection = $collection;
            $this->dtoClass = ItemMap::for($collection) ?? Item::class;
        }
    }

    /**
     * Champs à renvoyer, notation pointée pour les relations ("idPoule.nom", "engagements.*", "*").
     *
     * @param  string|list<string>  $fields
     */
    public function fields(string|array $fields): self
    {
        array_push($this->fields, ...(array) $fields);

        return $this;
    }

    /**
     * Filtre Directus complet, en tableau ou en JSON ({"idPoule": {"_eq": 123}}).
     *
     * @param  array<string, mixed>|string  $filter
     */
    public function filter(array|string $filter): self
    {
        if (is_string($filter)) {
            $this->rawFilter = $filter;
            $this->filter = [];
        } else {
            $this->rawFilter = null;
            $this->filter = $filter;
        }

        return $this;
    }

    /**
     * Ajoute une condition (combinée en _and avec les précédentes).
     *
     * Opérateurs : _eq, _neq, _lt, _lte, _gt, _gte, _in, _nin, _null, _nnull,
     * _contains, _icontains, _starts_with, _ends_with, _between, _empty, _nempty…
     * Le champ peut être pointé : "idCompetition.categorie.code".
     */
    public function where(string $field, string $operator, mixed $value = true): self
    {
        $condition = [];
        $cursor = &$condition;

        foreach (explode('.', $field) as $segment) {
            $cursor[$segment] = [];
            $cursor = &$cursor[$segment];
        }

        $cursor[$operator] = $value;
        unset($cursor);

        if ($this->rawFilter !== null) {
            $this->filter = (array) Json::decode($this->rawFilter);
            $this->rawFilter = null;
        }

        $this->filter = $this->filter === []
            ? $condition
            : ['_and' => [...($this->filter['_and'] ?? [$this->filter]), $condition]];

        return $this;
    }

    /**
     * Recherche plein texte Directus sur tous les champs texte de la collection.
     */
    public function search(string $search): self
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Tri ; préfixer par "-" pour un tri décroissant ("-date_rencontre").
     *
     * @param  string|list<string>  $fields
     */
    public function sort(string|array $fields): self
    {
        array_push($this->sort, ...(array) $fields);

        return $this;
    }

    /**
     * -1 = tous les éléments (si l'instance Directus l'autorise).
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Nombre d'éléments à sauter.
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Numéro de page (à combiner avec limit(), alternative à offset()).
     */
    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Agrégat Directus : count, countDistinct, countAll, sum, sumDistinct, avg, avgDistinct, min, max.
     *
     * @param  string|list<string>  $fields
     */
    public function aggregate(string $function, string|array $fields = '*'): self
    {
        $this->aggregate[$function] = array_values(array_unique([...($this->aggregate[$function] ?? []), ...(array) $fields]));

        return $this;
    }

    /**
     * Regroupe les résultats (avec aggregate()), ex. groupBy('idPoule').
     *
     * @param  string|list<string>  $fields
     */
    public function groupBy(string|array $fields): self
    {
        array_push($this->groupBy, ...(array) $fields);

        return $this;
    }

    /**
     * Paramètres appliqués à une relation imbriquée, ex. deep('rencontres', ['_limit' => 1000, '_sort' => ['-date_rencontre']]).
     *
     * @param  array<string, mixed>  $query
     */
    public function deep(string $relation, array $query): self
    {
        $cursor = &$this->deep;

        foreach (explode('.', $relation) as $segment) {
            $cursor[$segment] ??= [];
            $cursor = &$cursor[$segment];
        }

        $cursor = array_merge($cursor, $query);
        unset($cursor);

        return $this;
    }

    /**
     * Renomme un champ dans la réponse, ex. alias('equipe', 'nomEquipe1').
     */
    public function alias(string $alias, string $field): self
    {
        $this->alias[$alias] = $field;

        return $this;
    }

    /**
     * Métadonnées : "total_count", "filter_count" ou "*".
     */
    public function withMeta(string $meta = '*'): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Paramètres de requête tels qu'envoyés à Directus.
     *
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        $query = [];

        if ($this->fields !== []) {
            $query['fields'] = implode(',', array_unique($this->fields));
        }

        $filter = $this->rawFilter ?? ($this->filter !== [] ? Json::encode($this->filter) : null);

        if ($filter !== null) {
            $query['filter'] = $filter;
        }

        if ($this->search !== null) {
            $query['search'] = $this->search;
        }

        if ($this->sort !== []) {
            $query['sort'] = implode(',', $this->sort);
        }

        foreach (['limit' => $this->limit, 'offset' => $this->offset, 'page' => $this->page] as $key => $value) {
            if ($value !== null) {
                $query[$key] = (string) $value;
            }
        }

        foreach ($this->aggregate as $function => $fields) {
            $query["aggregate[{$function}]"] = implode(',', $fields);
        }

        if ($this->groupBy !== []) {
            $query['groupBy'] = implode(',', $this->groupBy);
        }

        if ($this->deep !== []) {
            $query['deep'] = Json::encode($this->deep);
        }

        if ($this->alias !== []) {
            $query['alias'] = Json::encode($this->alias);
        }

        if ($this->meta !== null) {
            $query['meta'] = $this->meta;
        }

        return $query;
    }

    /**
     * Les éléments correspondant à la requête, hydratés dans le DTO de la collection.
     *
     * @return list<T>
     */
    public function get(): array
    {
        return $this->dtoClass::collect($this->getRaw());
    }

    /**
     * Les éléments correspondant à la requête, en tableaux Directus (ex. lignes d'agrégat).
     *
     * @return list<array<string, mixed>>
     */
    public function getRaw(): array
    {
        $data = $this->raw()['data'] ?? [];

        return is_array($data) && array_is_list($data) ? array_values(array_filter($data, 'is_array')) : [];
    }

    /**
     * Réponse brute Directus : ['data' => [...], 'meta' => [...]].
     *
     * @return array<string, mixed>
     */
    public function raw(): array
    {
        try {
            $response = Transport::guard(fn () => $this->connector->send(
                new ListItems($this->endpoint(), null, extraQuery: $this->toQuery()),
            ));
        } catch (FfbbNotFoundException) {
            return ['data' => []];
        }

        $payload = Json::decode($response->body());

        return is_array($payload) ? $payload : ['data' => []];
    }

    /**
     * Le premier élément correspondant à la requête (limit 1).
     *
     * @return T|null
     */
    public function first(): ?object
    {
        $item = $this->firstRaw();

        return $item === null ? null : $this->dtoClass::fromArray($item);
    }

    /**
     * Le premier élément correspondant à la requête, en tableau Directus.
     *
     * @return array<string, mixed>|null
     */
    public function firstRaw(): ?array
    {
        $previous = $this->limit;
        $this->limit = 1;

        try {
            return $this->getRaw()[0] ?? null;
        } finally {
            $this->limit = $previous;
        }
    }

    /**
     * Un élément par identifiant, hydraté dans son DTO (seuls fields, deep et alias s'appliquent).
     *
     * @return T|null
     */
    public function find(string|int $id): ?object
    {
        $item = $this->findRaw($id);

        return $item === null ? null : $this->dtoClass::fromArray($item);
    }

    /**
     * Un élément par identifiant, en tableau Directus.
     *
     * @return array<string, mixed>|null
     */
    public function findRaw(string|int $id): ?array
    {
        $query = array_intersect_key($this->toQuery(), array_flip(['fields', 'deep', 'alias']));

        try {
            $response = Transport::guard(fn () => $this->connector->send(
                new GetItem($this->endpoint(), $id, extraQuery: $query),
            ));
        } catch (FfbbNotFoundException) {
            return null;
        }

        $data = Json::unwrapData(Json::decode($response->body()));

        return is_array($data) && $data !== [] ? $data : null;
    }

    /**
     * Nombre d'éléments correspondant au filtre (aggregate[count]=*).
     */
    public function count(): int
    {
        $clone = clone $this;
        $clone->fields = [];
        $clone->sort = [];
        $clone->limit = null;
        $clone->offset = null;
        $clone->page = null;
        $clone->aggregate = ['count' => ['*']];

        $row = $clone->raw()['data'][0] ?? [];
        $count = is_array($row) ? ($row['count'] ?? 0) : 0;

        return (int) (is_array($count) ? ($count['*'] ?? 0) : $count);
    }

    /**
     * Itère sur tous les résultats (DTOs), page par page.
     *
     * @return Generator<int, T>
     */
    public function cursor(int $pageSize = 100): Generator
    {
        $offset = $this->offset ?? 0;

        while (true) {
            $clone = clone $this;
            $clone->limit = $pageSize;
            $clone->offset = $offset;
            $clone->page = null;
            $batch = $clone->getRaw();

            foreach ($batch as $item) {
                yield $this->dtoClass::fromArray($item);
            }

            if (count($batch) < $pageSize) {
                return;
            }

            $offset += $pageSize;
        }
    }

    private function endpoint(): string
    {
        return str_starts_with($this->collection, 'items/') ? $this->collection : 'items/'.$this->collection;
    }
}
