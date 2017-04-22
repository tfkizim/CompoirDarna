# comptoirapp

# Get vendor file
php composer update

# Configuration File
app/config/parameters.yml

# Clear cache
php app/console cache:clear
php app/console cache:clear --env=prod

# Compile Css + Js
php app/console assetic:dump --env=prod --no-debug

# Change mods 
chmod -R 0777 app/logs/
chmod -R 0777 app/cache/

