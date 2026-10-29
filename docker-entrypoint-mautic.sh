#!/bin/sh
set -eu

# Ensure required directories exist.
mkdir -p \
    /var/www/html/var/cache \
    /var/www/html/var/logs

# Repair permissions on every container start.
chown -R www-data:www-data \
    /var/www/html/var/cache \
    /var/www/html/var/logs

# Start the original container command, normally Apache.
exec "$@"
