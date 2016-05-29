# AndroIRC (Android IRC Client)

Tracis CI :

* Master  : [![Build Status](https://secure.travis-ci.org/androirc/website.png?branch=master)](http://travis-ci.org/androirc/website)
* Develop : [![Build Status](https://secure.travis-ci.org/androirc/website.png?branch=develop)](http://travis-ci.org/androirc/website)

Team :

* Julien Brochet <mewt@androirc.com>
* Sébastien Brochet <blinkseb@androirc.com>

## Prepare environment

 1. Install composer: https://getcomposer.org/download/
 2. Create and edit the `parameters.yml` file: `cp app/config/parameters.yml.test app/config/parameters.yml`
 2. Install dependencies:

```bash
php composer.phar install
```

 3. Setup database, and load some fixtures:

```bash
php app/console --env=test doctrine:database:drop --force
php app/console --env=test doctrine:database:create
php app/console --env=test doctrine:schema:create
php app/console --env=test doctrine:fixtures:load --no-interaction
```

 4. Setup nginx: see https://www.wanadev.fr/9-kit-de-survie-symfony2-et-nginx/
 5. Setup Symfony cache

```bash
cd app/
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX cache
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX cache
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX logs
cd ..
```

## Deployment

AndroIRC use `capifony` for deployment (http://capifony.org/)

```bash
sudo gem install capifony
```

 1. Initialize capifony: `capifony .`
