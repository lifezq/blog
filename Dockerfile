from docker.io/richarvey/nginx-php-fpm:latest
RUN rm -f /etc/nginx/sites-enabled/default.conf
ADD default.conf /etc/nginx/sites-enabled/
COPY . /var/www/html