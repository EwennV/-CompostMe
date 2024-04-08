
# Bloc 3 - développer un site web et son application mobile
Bloc 3 du CESI

## Table des matières
- [Documentation de l'API](/DOCUMENTATION_APi.yaml)
- [Installation du projet](#installation-du-projet)
- [Auteurs](#auteurs)

## Installation du projet

Assurez-vous d'avoir [Composer](https://getcomposer.org/download/), [Symfony 6.4](https://symfony.com/download), [PHP 8.1](https://www.php.net/downloads) et [Node.js](https://nodejs.org/en/download/) installés sur votre machine.

Assurez-vous également d'avoir activer les extensions suivantes dans votre fichier php.ini :
- mysqli
- sodium



```shell
git clone git@github.com:EwennV/CompostMe.git
cd CompostMe
composer install
```

Ajoutez ensuite vos variables d'environnement dans un nouveau fichier .env.local à la racine du fichier

Modifiez la connexion à la base de données et éxécutez les migrations :

````shell
php bin/console doctrine:migrations:migrate
````

Installez Bootstrap et lancez le build :
````shell
npm install
npm run build
````

Et voilà ! Il ne vous reste plus qu'à lancer votre serveur :

````shell
symfony server:start
````

## Documentation

    

## Auteurs
[Noé BROGNARD](https://github.com/xenS14)\
[Ewenn VALLOIS](https://github.com/EwennV)