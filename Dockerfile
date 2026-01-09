# Use WordPress official image with PHP 8.2 and Apache
FROM wordpress:6.4-php8.2-apache

# Install additional PHP extensions and tools
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# Configure PHP settings
RUN { \
    echo 'upload_max_filesize = 64M'; \
    echo 'post_max_size = 64M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 300'; \
    echo 'max_input_time = 300'; \
    } > /usr/local/etc/php/conf.d/uploads.ini

# Copy custom wp-content
COPY --chown=www-data:www-data ./wp-content /var/www/html/wp-content

# Create uploads directory with correct permissions
RUN mkdir -p /var/www/html/wp-content/uploads && \
    chown -R www-data:www-data /var/www/html/wp-content && \
    chmod -R 755 /var/www/html/wp-content

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

# Start Apache
CMD ["apache2-foreground"]
