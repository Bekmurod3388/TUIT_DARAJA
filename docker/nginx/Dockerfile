FROM nginx:1.27-alpine

WORKDIR /var/www/TUIT_DARAJA

COPY public /var/www/TUIT_DARAJA/public
COPY docker/nginx/laravel.prod.conf /etc/nginx/conf.d/default.conf
