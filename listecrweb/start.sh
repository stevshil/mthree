#!/bin/bash

# Variable ECRREPO not working correctly, so writing file
sed -i "s/\$ECRREPO/$ECRREPO/g" /var/www/html/index.php

[[ ! -d /run/php-fpm ]] && mkdir /run/php-fpm
php-fpm

httpd -d /etc/httpd -D FOREGROUND -k start
