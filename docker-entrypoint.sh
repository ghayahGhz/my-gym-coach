#!/bin/bash

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear config and use runtime env vars
php artisan config:clear
php artisan cache:clear 2>/dev/null || true

# Run migrations (retry up to 3 times)
for i in 1 2 3; do
    php artisan migrate --force && break
    echo "Migration attempt $i failed, retrying in 5s..."
    sleep 5
done

# Seed exercises if not already seeded
php artisan db:seed --class=ExerciseSeeder --force 2>/dev/null || true

# Link storage
php artisan storage:link 2>/dev/null || true

# Start Apache
exec apache2-foreground
