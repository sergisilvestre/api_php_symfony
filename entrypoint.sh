#!/bin/sh
set -e

echo "⏳ Waiting for MySQL..."

while ! nc -z db 3306; do
  sleep 1
done

echo "✅ MySQL is ready!"

# Reset database (DEV ONLY)
if [ "$APP_ENV" = "dev" ]; then
    echo "🗑 Dropping database..."
    php bin/console doctrine:database:drop --force --if-exists

    echo "🆕 Creating database..."
    php bin/console doctrine:database:create --if-not-exists
fi

# Run migrations
echo "📦 Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

# Load fixtures (development only)
if [ "$APP_ENV" = "dev" ]; then
    echo "🌱 Loading fixtures..."
    php bin/console doctrine:fixtures:load --no-interaction --append
fi

# Clear and warm up cache
php bin/console cache:clear --env=$APP_ENV
php bin/console cache:warmup --env=$APP_ENV

# Start application
exec php -S 0.0.0.0:8000 -t public