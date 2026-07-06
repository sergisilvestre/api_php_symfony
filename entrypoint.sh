#!/bin/sh
set -e

echo "⏳ Waiting for MySQL..."

while ! nc -z db 3306; do
  sleep 1
done

echo "✅ MySQL is ready!"

# Run database migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Clear and warm up cache
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

# Start the application
exec php -S 0.0.0.0:8000 -t public