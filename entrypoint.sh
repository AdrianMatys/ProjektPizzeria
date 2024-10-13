#!/usr/bin/bash
chmod -Rf 0777 storage
service nginx start
php-fpm