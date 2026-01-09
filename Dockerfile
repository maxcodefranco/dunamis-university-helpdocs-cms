FROM wordpress:6.4-apache

# Copy PHP config
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Copy custom wp-content
COPY --chown=www-data:www-data ./wp-content /var/www/html/wp-content

# Set permissions
RUN chown -R www-data:www-data /var/www/html/wp-content

EXPOSE 80
