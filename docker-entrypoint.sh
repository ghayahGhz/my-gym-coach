#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear config cache
php artisan config:clear

# Run migrations
php artisan migrate --force

# Link storage
php artisan storage:link 2>/dev/null || true

# Start Apache
exec apache2-foreground
