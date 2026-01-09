FROM wordpress:latest

# Copy custom entrypoint
COPY docker-entrypoint.sh /usr/local/bin/custom-entrypoint.sh
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

# Copy wp-content
COPY --chown=www-data:www-data ./wp-content /var/www/html/wp-content

ENTRYPOINT ["/usr/local/bin/custom-entrypoint.sh"]
