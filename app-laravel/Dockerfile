FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
  libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.12

# Install GMP
# RUN apt-get update -y
# RUN apt-get install -y libgmp-dev re2c libmhash-dev libmcrypt-dev file
# RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/
# RUN docker-php-ext-configure gmp 
# RUN docker-php-ext-install gmp

# Install Opcache
RUN docker-php-ext-install opcache

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Instll Imagick
# RUN apt-get update \
#     && apt-get -y install \
#             libmagickwand-dev \
#         --no-install-recommends \
#     && pecl install imagick \
#     && docker-php-ext-enable imagick \
#     && rm -r /var/lib/apt/lists/*

# Copy existing application directory contents
#COPY ./laravel /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Copy runner
COPY docker-start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["/usr/local/bin/start"]