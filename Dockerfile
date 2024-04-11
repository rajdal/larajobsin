FROM alpine:3
MAINTAINER Harikrushna Adiecha <adiechahari@gmail.com>

################## INSTALLATION STARTS ##################

# Install OS Dependencies
RUN set -ex
RUN apk add --no-cache --virtual .build-deps \
    gmp-dev tar

RUN apk add curl nodejs npm

# PHP and extensions
RUN apk add  \
    php php-apcu php-bcmath php-dom php-ctype php-curl php-exif php-fileinfo \
    php-fpm php-gd php-gmp php-iconv php-intl php-json php-mbstring  \
    php-mysqlnd php-mysqli php-opcache php-openssl php-pcntl php-pdo php-pdo_mysql \
    php-phar php-posix php-session php-simplexml php-sockets php-sqlite3 php-tidy \
    php-tokenizer php-xml php-xmlwriter php-zip php-zlib php-redis php-soap \
    php-pdo_pgsql php-xmlreader 

# Other dependencies
RUN apk add  \
    mariadb-client sudo

# Miscellaneous packages
RUN apk add  \
    bash ca-certificates dialog git libjpeg libmcrypt-dev libpng-dev openssh-client supervisor vim wget

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php --install-dir=/usr/bin --filename=composer \
  && php -r "unlink('composer-setup.php');"


# Cleanup
RUN apk del .build-deps

##################  INSTALLATION ENDS  ##################

RUN mkdir /app

WORKDIR /app

COPY . .

RUN rm -rf vendor node_modules

RUN ls -la

RUN cp .env.example .env

##################  APP SETUP START  ##################

RUN composer install && php artisan key:generate 
RUN npm install && npm run build

##################  APP SETUP ENDS   ##################

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
