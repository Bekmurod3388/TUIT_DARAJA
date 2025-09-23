#!/usr/bin/env sh
set -e

APP_DIR=/var/www/TUIT_DARAJA
cd "$APP_DIR"

echo "[entrypoint] PHP starting in $APP_DIR"

# 0) .env bo'lmasa .env.example'dan ko'chirib olamiz (dev qulayligi)
if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

# 1) (ixtiyoriy) vendor yo'q bo'lsa install (dev uchun qulay)
if [ ! -d vendor ]; then
  echo "[entrypoint] composer install (vendor not found)"
  COMPOSER_MEMORY_LIMIT=-1 composer install --no-interaction --prefer-dist
fi

# 2) DB tayyor bo'lguncha kutish (socket ping emas, TCP port check)
DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-3306}"
echo "[entrypoint] waiting for DB at ${DB_HOST}:${DB_PORT} ..."
i=0
# 60 urinish * 2s = 120s
until php -r 'exit(@fsockopen(getenv("DB_HOST")?: "db", (int)(getenv("DB_PORT")?:3306)) ? 0 : 1);'; do
  i=$((i+1))
  [ "$i" -ge 60 ] && echo "[entrypoint] DB wait timeout, continue..." && break
  sleep 2
done

# 3) Keshlarni tozalash: eski 'db' rezolv xotirasi qolib ketmasin
php artisan optimize:clear || true

# 4) Migratsiyalarni retry bilan ishga tushirish
echo "[entrypoint] running migrations with retry..."
n=0
until php artisan migrate --force; do
  n=$((n+1))
  [ "$n" -ge 10 ] && echo "[entrypoint] migrate failed after retries, continuing..." && break
  echo "[entrypoint] migrate failed, retrying in 3s ($n/10) ..."
  sleep 3
done

# Agar SESSION_DRIVER=database bo'lsa va sessions jadvali kerak bo'lsa,
# loyihada migratsiyasi mavjud bo'lmasligi mumkin. Shunda bitta marta publish qilib yuboramiz:
if [ "${SESSION_DRIVER}" = "database" ]; then
  php artisan migrate:status | grep -q "create_sessions_table" || {
    echo "[entrypoint] publishing session table migration..."
    php artisan session:table || true
    php artisan migrate --force || true
  }
fi

echo "[entrypoint] start php-fpm"
exec php-fpm
