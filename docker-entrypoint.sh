#!/bin/bash
set -e

# Railway passes PORT env var - Apache needs to listen on it
if [ ! -z "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
fi

# Call original WordPress entrypoint
exec docker-entrypoint.sh apache2-foreground
