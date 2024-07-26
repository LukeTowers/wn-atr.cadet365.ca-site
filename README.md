# About

Unofficial Electronic Aircrew Training Records proof of concept for the Air Cadet Flying Program.

Active development on `main` branch; features in feature branches.
Develop locally using [Homestead](https://laravel.com/docs/9.x/homestead).
Pushes to develop are automatically deployed on the [dev server](https://atr.cadet365.ca/).

## Local Setup

1. Clone the repo
2. Copy .env.example to .env and configure accordingly (APP_URL and DB credentials)
3. Run the local setup script
4. Ensure that the scheduler is properly configured by following https://wintercms.com/docs/setup/installation#crontab-setup (add `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1` to the crontab)

## Setup Script

```shell
# Install dependencies from composer.lock
composer install &&

# Generate a local application key
php artisan key:generate &&

# Trigger Laravel package discovery
php artisan package:discover &&

# Run any pending migrations
php artisan migrate &&

# Remove and regenerate the symlinked public directory for whitelist approach to clean out
# any references that may have been removed and add any new ones that may have been added
rm -rf public &&
php artisan winter:mirror public --relative &&
```

The setup script should also be run after pulling down changes from the remote repository, with the exception of `php artisan key:generate`.

## Automated Deployment Script (Atomic Blue-Green deployment strategy)

See [.scripts/deploy.sh](.scripts/deploy.sh) for the deployment script.

## @TODO:

- Update branding for login page (tagline, logo, image)
- Add signup form to login page
- Add admin account to live site
- Implement main data models & forms
- Implement main roles & permissions
- User / Member factories to populate the system with testing data
- Setup Sentry
- Timesheet app data import (sqlite)
