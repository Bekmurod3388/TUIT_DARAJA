#!/usr/bin/env sh
set -eu

APP_DIR=/var/www/TUIT_DARAJA
cd "$APP_DIR"

echo "[entrypoint] PHP starting in $APP_DIR"

APP_ENV="${APP_ENV:-local}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-auto}"
DB_CONNECTION="${DB_CONNECTION:-mysql}"

# 0) .env bo'lmasa .env.example'dan ko'chirib olamiz (faqat local/dev)
if [ ! -f .env ] && [ -f .env.example ] && [ "$APP_ENV" != "production" ]; then
  cp .env.example .env
fi

# 1) Prod'da APP_KEY majburiy
if [ "$APP_ENV" = "production" ] && [ -z "${APP_KEY:-}" ]; then
  echo "[entrypoint] APP_KEY is required in production"
  exit 1
fi

# 2) Kerakli writable papkalar
mkdir -p \
  storage/app/private \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rw storage bootstrap/cache || true

# 3) Vendor yo'q bo'lsa local/dev'da install, prod'da fail-fast
if [ ! -d vendor ]; then
  if [ "$APP_ENV" = "production" ]; then
    echo "[entrypoint] vendor directory is missing in production image"
    exit 1
  fi

  echo "[entrypoint] composer install (vendor not found)"
  COMPOSER_MEMORY_LIMIT=-1 composer install --no-interaction --prefer-dist
fi

# 4) DB tayyor bo'lguncha kutish
if [ "$DB_CONNECTION" != "sqlite" ]; then
  DB_HOST="${DB_HOST:-db}"
  DB_PORT="${DB_PORT:-3306}"
  echo "[entrypoint] waiting for DB at ${DB_HOST}:${DB_PORT} ..."
  i=0
  until php -r 'exit(@fsockopen(getenv("DB_HOST") ?: "db", (int) (getenv("DB_PORT") ?: 3306)) ? 0 : 1);'; do
    i=$((i+1))
    [ "$i" -ge 60 ] && echo "[entrypoint] DB wait timeout, continue..." && break
    sleep 2
  done
fi

# 5) Stale cache'larni tozalash
php artisan optimize:clear || true

should_run_migrations() {
  case "$RUN_MIGRATIONS" in
    1|true|TRUE|yes|YES|on|ON)
      return 0
      ;;
    0|false|FALSE|no|NO|off|OFF)
      return 1
      ;;
    auto)
      [ "$APP_ENV" != "production" ]
      return
      ;;
    *)
      return 1
      ;;
  esac
}

if should_run_migrations; then
  echo "[entrypoint] running migrations with retry..."
  n=0
  until php artisan migrate --force; do
    n=$((n+1))
    [ "$n" -ge 10 ] && echo "[entrypoint] migrate failed after retries, continuing..." && break
    echo "[entrypoint] migrate failed, retrying in 3s ($n/10) ..."
    sleep 3
  done
fi

# 6) Prod optimizatsiyasi
php artisan storage:link || true

if [ "$APP_ENV" = "production" ]; then
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
fi

echo "[entrypoint] start php-fpm"
exec php-fpm
