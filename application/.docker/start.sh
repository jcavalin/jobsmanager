#!/bin/sh

php composer.phar install
php ./app/consumer.php 2>&1 &
apache2-foreground