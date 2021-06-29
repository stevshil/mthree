#!/bin/bash

[[ ! -d /run/php-fpm ]] && mkdir /run/php-fpm
php-fpm

httpd -d /etc/httpd -D FOREGROUND -k start
