FROM php:8.2-fpm

# Instalando ferramentas
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Configurando extensões
RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    pdo pdo_mysql mysqli gd

# Crie um usuário do sistema para executar os comandos Composer e Artisan
RUN useradd -G www-data,root -u 1000 -d /home/application_user application_user
RUN mkdir -p /home/application_user/.composer && \
    chown -R application_user:application_user /home/application_user

# Adicionando debug
RUN pecl --no-cache $PHPIZE_DEPS \
	&& pecl install xdebug-3.2.1 \
	&& docker-php-ext-enable xdebug

# Copiando composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER application_user

EXPOSE 9000

ENTRYPOINT [ "/usr/local/bin/docker-php-entrypoint" ]
CMD [ "php-fpm" ]
