#!/bin/bash

root_dir="/var/www/project"

echo "Installing Vendor Files.."
docker-compose exec php  bash -c "cd $root_dir && composer install"


echo "Fixing  permissions for $root_dir"

docker-compose exec php  bash -c "chown -R www-data:www-data $root_dir/bootstrap"
docker-compose exec php  bash -c "chown -R www-data:www-data $root_dir/storage"

