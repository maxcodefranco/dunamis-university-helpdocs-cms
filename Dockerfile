FROM wordpress:latest

# Copy custom theme and plugins
COPY --chown=www-data:www-data ./wp-content /var/www/html/wp-content

# Create uploads directory with correct permissions
# This ensures the volume mount point exists and has proper ownership
RUN mkdir -p /var/www/html/wp-content/uploads && \
    chown -R www-data:www-data /var/www/html/wp-content/uploads && \
    chmod -R 755 /var/www/html/wp-content/uploads
