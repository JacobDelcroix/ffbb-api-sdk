# 09 — Laravel

## Installation

```bash
composer require jacobdelcroix/ffbb-api-sdk
php artisan vendor:publish --tag=ffbb-config
```

Le service provider est découvert automatiquement. Il enregistre `FfbbDataClient` en **singleton**, branché
sur le cache de l'application.

## Configuration (`config/ffbb.php`)

```php
return [
    'api_token' => env('API_FFBB_APP_BEARER_TOKEN'),        // null = résolution automatique
    'meilisearch_token' => env('MEILISEARCH_BEARER_TOKEN'),
    'api_base_url' => env('API_FFBB_BASE_URL', 'https://api.ffbb.com/'),
    'meilisearch_base_url' => env('MEILISEARCH_URL', 'https://meilisearch-prod.ffbb.app/'),
    'cache' => [
        'store' => env('FFBB_CACHE_STORE'),                  // null = store par défaut
        'ttl' => (int) env('FFBB_CACHE_TTL', 1800),          // 0 = pas de cache HTTP
    ],
];
```

## Utilisation

Par injection (recommandé) :

```php
use CoachBasket\Ffbb\FfbbDataClient;

final class ClassementController
{
    public function __invoke(FfbbDataClient $ffbb, int $pouleId)
    {
        return view('classement', ['lignes' => $ffbb->getClassement($pouleId) ?? []]);   // list<PoulesClassementsItem>
    }
}
```

Ou par la façade :

```php
use CoachBasket\Ffbb\Laravel\Facades\Ffbb;

$equipes = Ffbb::getEquipes(10238);
```

## Avec le pattern Action

Isoler chaque usage du SDK dans une Action garde le reste de l'appli indépendant de la source FFBB :

```php
namespace App\Actions\Ffbb;

use CoachBasket\Ffbb\Data\PoulesClassementsItem;
use CoachBasket\Ffbb\FfbbDataClient;

final readonly class GetTeamStanding
{
    public function __construct(private FfbbDataClient $ffbb) {}

    /**
     * Ligne de classement d'un club dans une poule, ou null.
     */
    public function handle(int $pouleId, int $organismeId): ?PoulesClassementsItem
    {
        foreach ($this->ffbb->getClassement($pouleId) ?? [] as $ligne) {
            if ((int) $ligne->organisme?->id === $organismeId) {
                return $ligne;
            }
        }

        return null;
    }
}
```

## Préchauffer le cache avec le scheduler

```php
// routes/console.php
use CoachBasket\Ffbb\FfbbDataClient;
use Illuminate\Support\Facades\Schedule;

Schedule::call(fn (FfbbDataClient $ffbb) => $ffbb->warmOrganismeCache(10238))
    ->hourly()
    ->between('8:00', '22:00');
```

## Tester son code avec Pest

Le SDK s'appuie sur Saloon : on remplace les réponses FFBB par un `MockClient`, sans aucun appel réseau.

```php
use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Connectors\MeilisearchConnector;
use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;
use App\Actions\Ffbb\GetTeamStanding;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $tokens = TokenManager::withTokens('test-api-token', 'test-meili-token');

    $ffbb = (new FfbbDataClient(
        new ApiFfbbConnector($tokens),
        new MeilisearchSearcher(new MeilisearchConnector($tokens)),
    ))->withMockClient(new MockClient([
        GetItem::class => MockResponse::make(['data' => [
            'id' => '900',
            'classements' => [
                ['position' => 1, 'points' => 12, 'organisme' => ['id' => '10238', 'nom' => 'OSTREVENT']],
            ],
        ]]),
    ]));

    $this->app->instance(FfbbDataClient::class, $ffbb);
});

it('trouve la ligne de classement du club', function () {
    $ligne = app(GetTeamStanding::class)->handle(900, 10238);

    expect($ligne->position)->toBe(1);
});
```

Dans un test, on décrit les réponses FFBB en tableaux (comme l'API les renvoie) : le SDK les hydrate en DTOs.
Les classes de requêtes à simuler : `GetItem`, `ListItems`, `GetLives`, `GetConfiguration`, `GetOpenApiSpec`
(Directus), `MultiSearch`, `SearchIndex` (Meilisearch). `Saloon\Config::preventStrayRequests()` garantit
qu'aucune requête réelle ne part pendant les tests.
