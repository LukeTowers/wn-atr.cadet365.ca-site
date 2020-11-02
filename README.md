# About

Repository for the OctoberCMS-powered CadetFlying.Site.
Active development in develop branch; features in feature branches.
Develop locally using [Homestead](https://laravel.com/docs/6.x/homestead).
Pushes to develop are automatically deployed on the [dev server](https://cadetflying.site/).

## Local Setup

1. Clone the repo
2. Copy .env.example to .env and configure accordingly (APP_URL and DB credentials)
3. Run the local setup script
4. Ensure that the scheduler is properly configured by following https://octobercms.com/docs/setup/installation#crontab-setup (add `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1` to the crontab)

## Setup Script

```shell
# Install dependencies from composer.lock
composer install &&

# Generate a local application key
php artisan key:generate &&

# Trigger Laravel package discovery
php artisan package:discover &&

# Run any pending migrations
php artisan october:up &&

# Remove and regenerate the symlinked public directory for whitelist approach to clean out
# any references that may have been removed and add any new ones that may have been added
rm -rf public &&
php artisan october:mirror public --relative &&
```

The setup script should also be run after pulling down changes from the remote repository, with the exception of `php artisan key:generate`.

## Automated Deployment Script (Atomic Blue-Green deployment strategy)
```shell
# Make the storage directories if they don't already exsit
mkdir -p $SHARED/storage/app/media &&
mkdir -p $SHARED/storage/app/resized &&
mkdir -p $SHARED/storage/app/uploads/public &&
mkdir -p $SHARED/storage/cms/cache &&
mkdir -p $SHARED/storage/cms/combiner &&
mkdir -p $SHARED/storage/cms/twig &&
mkdir -p $SHARED/storage/framework/cache &&
mkdir -p $SHARED/storage/framework/sessions &&
mkdir -p $SHARED/storage/framework/views &&
mkdir -p $SHARED/storage/temp/public &&
mkdir -p $SHARED/storage/logs &&
mkdir -p $SHARED/storage/temp/public &&

# Remove the current storage directory
rm -rf $RELEASE/storage &&

# Link the application storage directory to this
ln -s $SHARED/storage $RELEASE/storage &&

# Install dependencies from composer.lock - remove --no-dev for local environments
composer install --no-dev &&

# Trigger Laravel package discovery
php artisan package:discover &&

# Enable maintenance mode
php artisan down &&

# Run any pending migrations
php artisan october:up &&

# Remove and regenerate the symlinked public directory for whitelist approach to clean out
# any references that may have been removed and add any new ones that may have been added
rm -rf public &&
php artisan october:mirror public --relative &&

# Disable maintenance mode
php artisan up;
```