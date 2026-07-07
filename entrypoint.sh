#!/bin/sh
set -e

echo "⏳ Waiting for MySQL..."

while ! nc -z db 3306; do
  sleep 1
done

echo "✅ MySQL is ready!"

# Run database migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Load fixtures (development only)
if [ "$APP_ENV" = "dev" ]; then
    echo "🌱 Loading fixtures..."
    php bin/console doctrine:fixtures:load --no-interaction --append
fi

# Clear and warm up cache
php bin/console cache:clear --env=$APP_ENV
php bin/console cache:warmup --env=$APP_ENV

# Start the application
exec php -S 0.0.0.0:8000 -t public