#!/bin/sh
set -e

PORT_TO_USE="${PORT:-80}"

echo "Listen ${PORT_TO_USE}" > /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT_TO_USE}>/g" /etc/apache2/sites-enabled/000-default.conf

apache2-foreground
