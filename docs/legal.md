# Cadre juridique : à lire avant tout usage public ou commercial

> Ceci n'est pas un avis juridique. Pour un projet commercial, fais valider ton montage par un avocat
> spécialisé en propriété intellectuelle / droit du sport.

## Ce que fait ce SDK

Il interroge l'API Directus et le Meilisearch **de l'application mobile FFBB** en se présentant comme elle
(User-Agent de l'app, en-têtes `Origin`/`Referer` du site, jetons publiés par `items/configuration`) et en
contournant les blocages du WAF BunnyCDN (rotation de User-Agent). Ce n'est pas une API ouverte ni documentée
par la FFBB.

## Les textes en jeu (droit français)

1. **Droit d'exploitation des compétitions** (Code du sport, art. L333-1) : les fédérations sont propriétaires
   du droit d'exploitation des compétitions qu'elles organisent. La jurisprudence considère comme exploitation
   toute activité économique à but lucratif qui n'existerait pas sans la compétition.
   Une API payante de calendriers / résultats / classements FFBB entre très probablement dans ce cadre.

2. **Droit du producteur de base de données** (CPI, art. L341-1 et suivants) : la FFBB peut interdire
   l'extraction et la réutilisation d'une partie substantielle de sa base. La reprise des données au profit
   d'un service concurrent a été jugée illicite. L'atteinte est un délit (CPI, art. L343-1).

3. **Données personnelles (RGPD)** : `getClubContacts()`, `getEngagementContacts()` et les collections
   `membres`, `entraineurs`, `officiels` contiennent des noms, téléphones et e-mails de personnes, souvent
   bénévoles. Les redistribuer, a fortiori contre paiement, demande une base légale et une information des
   personnes que tu n'as pas.

4. **Contournement de mesures techniques** : le WAF et le filtrage par User-Agent sont des mesures de la FFBB
   pour limiter l'accès. Les contourner pour un service commercial aggrave ta position.

## En pratique

| Usage | Risque |
|---|---|
| Usage perso / ton club, faible volume, avec cache | faible en pratique (toléré de fait) |
| Outil gratuit public (ex. coach-basket.com) affichant résultats et classements | modéré : reste sur des extraits non substantiels, cite la FFBB, n'expose aucune donnée personnelle |
| **API publique payante** revendant les données FFBB | **élevé** sans accord de la FFBB |

**Recommandation** : si tu vises une API publique (et surtout payante), contacte la FFBB pour obtenir une
licence ou un partenariat avant de lancer. Fais payer ta valeur ajoutée (outils pour coachs, statistiques,
analyse vidéo…) plutôt que l'accès brut aux données. Et sépare techniquement l'accès FFBB derrière une
interface, pour pouvoir basculer sur une source officielle le jour où elle existera.
