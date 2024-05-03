
# Bloc 3 - développer un site web et son application mobile
Bloc 3 du CESI

## Table des matières
- [Installation du projet](#installation-du-projet)
- [Documentation de l'API](https://ewennv.github.io/CompostMe/)
- [Auteurs](#auteurs)

## Installation du projet

### Prérequis
- [Composer](https://getcomposer.org/download/)
- [Symfony 6.4](https://symfony.com/download)
- [PHP 8.1](https://www.php.net/downloads)
- [Node.js](https://nodejs.org/en/download/) 
- [OpenSSL (Windows)](https://community.chocolatey.org/packages/openssl)
- [OpenSSL (Linux)](https://www.openssl.org/source/)

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

Vous devrez installer une pair de clés SSH pour pouvoir utiliser les fonctionnalités de sécurité de l'API. Pour cela, exécutez la commande suivante :

````shell
php bin/console lexik:jwt:generate-keypair
````

Et voilà ! Il ne vous reste plus qu'à lancer votre serveur :

````shell
symfony server:start
````

## Documentation de l'Api

La documentation de l'API est disponible ici : [https://ewennv.github.io/CompostMe/](https://ewennv.github.io/CompostMe/)

## Auteurs
[Noé BROGNARD](https://github.com/xenS14)\
[Ewenn VALLOIS](https://github.com/EwennV)