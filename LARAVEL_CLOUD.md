# Deploiement Laravel Cloud

Ce projet est pret a etre deploye sur Laravel Cloud depuis le depot GitHub :

```text
https://github.com/Teuguia/agenda-familial.git
```

## Reglages recommandes

Dans Laravel Cloud, cree une application depuis ce depot et choisis :

- Branch: `main`
- PHP version: `8.4`
- Node version: `22` ou `24`
- Push to deploy: active

PHP `8.4` est recommande parce que le `composer.lock` actuel contient au moins une dependance qui demande PHP `>=8.4`.

## Build Commands

A mettre dans l'environnement Laravel Cloud, section Deployments > Build Commands :

```bash
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan optimize
```

## Deploy Commands

A mettre dans Deployments > Deploy Commands :

```bash
php artisan migrate --force
```

N'ajoute pas `php artisan storage:link` dans les commandes de deploiement Laravel Cloud. Le filesystem d'environnement est ephemere ; pour les fichiers persistants, utilise plutot un stockage objet compatible S3.

## Variables d'environnement

Ne pousse jamais le fichier `.env` local. Dans Laravel Cloud, renseigne les variables dans Environment Variables.

Tu peux utiliser `.env.laravel-cloud.example` comme base, puis adapter :

- `APP_KEY`: genere une cle avec `php artisan key:generate --show`, puis colle la valeur dans Laravel Cloud.
- `APP_URL`: remplace par le domaine Laravel Cloud ou ton domaine final.
- `APP_DEBUG`: garde `false` en production.
- Database: attache une base de donnees Laravel Cloud ; Cloud injectera les credentials necessaires.
- `CACHE_DRIVER`, `QUEUE_CONNECTION`, `SESSION_DRIVER`: les valeurs `database` evitent de dependre du disque local.

Si tu veux utiliser Redis / KV Store plus tard, remplace ces drivers par `redis` et attache une ressource KV dans Laravel Cloud.

## Premiere mise en ligne

1. Connecte Laravel Cloud a GitHub.
2. Selectionne `Teuguia/agenda-familial`.
3. Selectionne la branche `main`.
4. Configure les variables d'environnement.
5. Configure les Build Commands et Deploy Commands ci-dessus.
6. Lance Deploy.

## Deploy Hook optionnel

Laravel Cloud declenche deja un deploiement a chaque push sur la branche configuree. La workflow `.github/workflows/laravel-cloud-deploy.yml` est optionnelle : utilise-la seulement si tu actives un Deploy Hook dans Laravel Cloud.

Dans GitHub, ajoute un secret Actions nomme :

```text
LARAVEL_CLOUD_DEPLOY_HOOK
```

avec l'URL du deploy hook Laravel Cloud.
