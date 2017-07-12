#!/bin/sh

# Prep the container (php & zip needed to install composer)
apt-get install -y php zip

# Install composer
cd ../
wget https://raw.githubusercontent.com/Erdiko/docker/master/php/scripts/composer.sh
chmod 770 composer.sh
./composer.sh

# Install erdiko
composer create erdiko/erdiko erdiko dev-master --keep-vcs

# Swap out with latest code to be tested
rm -rf ./erdiko/vendor/erdiko/core
cp -R ./code ./erdiko/vendor/erdiko/core

cd erdiko
echo $CIRCLE_BRANCH

# decide which docker environment to bring up
if [ "$CIRCLE_BRANCH" == "release" ]; then
    docker-compose -f docker-compose.travis.regression.yml up -d
else
    docker-compose up -d
fi

docker-compose ps
ls -lah
