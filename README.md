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
    APP_SECRET=d673b72c1e6161b3ba8867a665809781
    
# Démarrage du serveur local 
    php -S localhost:8000 -t public
---
# Création du fichier MakeFile
    Voir fichier Makefile (https://github.com/steveldev/src/blob/master/symfony/Makefile)

Exemple: https://github.com/TBoileau/key-privilege/blob/develop/Makefile
...

---
# Création des fixtures
    composer require orm-fixtures --dev
    php bin/console make:fixtures    
    php bin/console doctrine:fixtures:load   

---
# Configuration du projet
## Configuration de la langue
    config/packages/translation.yaml

## Configuration du format des dates
...

## Configuration des formulaires (bootstrap)
    Fichier : config/packages/twig.yaml
    twig:
        form_themes:
            - 'bootstrap_4_layout.html.twig'



---
# Création du module user
    php bin/console make:user
    php bin/console make:auth
    php bin/console make:registration-form
    php bin/console make:reset-password

## Modules user optionnels 
### Vérification par email
    composer require symfonycasts/verify-email-bundle

### Mise à jour de la base de données
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate


## Configuration du fichier config/packages/security.yaml
    access_control:
        - { path: ^/mon-compte, roles: ROLE_USER }
        - { path: ^/admin, roles: ROLE_ADMIN }
...

---
# Création des tests

## Initialisation des tests
php bin/phpunit
php bin/phpunit --coverage-html ./coverage


---
# Front-end

## Création du controller principal
    php bin/console make:controller Default

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
# Git : push des fichiers sur git
    git init
    git add .
    git commit -m "initial commit"
    git remote add origin https://github.com/username/nom_depot.git
    git push -u origin main

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