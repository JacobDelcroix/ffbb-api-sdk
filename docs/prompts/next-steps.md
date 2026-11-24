# Prompt : reprendre le développement du SDK

À coller dans Claude Code, ouvert à la racine de `ffbb-php-sdk`.

---

Lis `CLAUDE.md`, `README.md` et `docs/maintenance.md`. Ce SDK a été écrit sans pouvoir lancer Composer
(Packagist inaccessible) : il a été vérifié contre les sources de Saloon v4.5.2 et cache-plugin v3.3.0
avec un lanceur de tests minimal, pas avec le vrai Pest.

1. `composer install`, puis `vendor/bin/pest`. Corrige ce qui échoue (probablement des détails propres à Pest
   ou PHPUnit, la logique ayant déjà été testée). Puis `vendor/bin/pint` et `composer analyse` (PHPStan niveau 6) :
   corrige les erreurs sans changer les comportements.
2. Vérifie en conditions réelles, avec mon accord pour chaque appel réseau :
   `FfbbDataClient::create()->searchOrganismes('Ostrevent')` doit renvoyer l'organisme `10238` (code `HDF0059038`),
   puis `getEquipes(10238)` les équipes du club.
3. Lance `php bin/discover --dry-run` pour voir l'écart entre les instantanés enregistrés et l'API actuelle.
4. Initialise le dépôt GitHub, pousse, et vérifie que les 3 workflows passent (`tests`, `FFBB discovery` en manuel,
   `Upstream sync` en manuel).

Ensuite, pistes d'amélioration (à me proposer avant de les faire) :
- requêtes concurrentes avec `Saloon\Http\Pool` pour `listAll*`, `*ByPoules` et la pagination Meilisearch
  (le Python les parallélise) ;
- méthodes « métier » au-dessus de la parité Python, utiles pour une API : calendrier d'une équipe,
  prochain match, dernier résultat, classement avec mise en avant d'une équipe ;
- DTOs pour les résultats Meilisearch (hits par index), à partir de `resources/discovery/indexes.json`.
