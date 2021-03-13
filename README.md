# Sommaire 
## Toggle 
https://gist.github.com/joyrexus/16041f2426450e73f5df9391f7f7ae5f

# Création du projet
    composer create-project symfony/website-skeleton MyProject

# Création du fichier ./README.md


# Configuration des environnements
    .env.dev.local
    .env.test.local
    .env.prod.local

## Contenu des fichiers .env.{env}.local
    DATABASE_URL=mysql://root@127.0.0.1:3306/database_name
    

---
# Git : push des fichiers sur git
    git init
    git add .
    git commit -m "initial commit"
    git remote add origin https://github.com/steveldev/symfony-dev.git
    git push -u origin master

---
# Création du fichier MakeFile
    Voir fichier Makefile (https://github.com/steveldev/src/blob/master/symfony/Makefile)

Exemple: https://github.com/TBoileau/key-privilege/blob/develop/Makefile
...


---
# Configuration du projet
## Configuration de la langue
    config/packages/translation.yaml

## Configuration du format des dates
https://symfony.com/blog/new-in-symfony-2-7-default-date-and-number-format-configuration

## Configuration des formulaires (bootstrap)
    Fichier : config/packages/twig.yaml
    twig:
        form_themes:
            - 'bootstrap_4_layout.html.twig'


---
## Création du controller principal
    php bin/console make:controller Default

# Démarrage du serveur local 
    php -S localhost:8000 -t public


---
# Création du module user
    php bin/console make:user
    php bin/console make:auth
    php bin/console make:registration-form
## Reset password
    composer require symfonycasts/reset-password-bundle    
    php bin/console make:reset-password

## Modules user optionnels 
### Vérification par email
    composer require symfonycasts/verify-email-bundle

## Configuration du fichier config/packages/security.yaml
    access_control:
        - { path: ^/account, roles: ROLE_USER }
        #- { path: ^/admin, roles: ROLE_ADMIN }

---
# Création des fixtures
    composer require orm-fixtures --dev
    php bin/console doctrine:fixtures:load   
    voir : ./src/DataFixtures/UserFixtures.php
...


---
# Création des tests

## Initialisation des tests
php bin/phpunit
php bin/phpunit --coverage-html ./coverage


---
# Front-end


## Installation de Webpack Encore
    composer require symfony/webpack-encore-bundle
    yarn install

## Installation de Bootstrap
    yarn add bootstrap --dev

## Installation de FontAwesome
    yarn add --dev @fortawesome/fontawesome-free

---
# Front : configuration de webpack 
## Importation de bootstrap et fontawesome
...

--- 
# Back-end 
## Installation de EasyAdmin
    composer require easycorp/easyadmin-bundle
### Configuration de EasyAdmin


---
# Configuration pour le déploiement

## Installation de Apache-pack
    composer require symfony/apache-pack

## Générer le fichier d'environnement 
    composer dump-env prod

## Build des assets Webpack Encore
    yarn run encore production


---
# Configuration de l'intégration continue avec Github
https://github.com/TBoileau/key-privilege/actions/workflows/continuous_integration.yml

--- 
# More : 

## Upload files
https://www.youtube.com/watch?v=apWjiEuDS0k

## Slug automatiques
https://reseau-net.fr/documentation/symfony/slug-automatique

## Intégration de Ckeditor

    <script src="{{ asset('bundles/ckeditor/ckeditor.js') }} "></script>
    <script type="text/javascript">          
        if(document.getElementById('article_content')) {
            CKEDITOR.replace( 'article_content' );
        }
    </script>