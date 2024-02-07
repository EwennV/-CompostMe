# Bloc 3 - développer un site web et son application mobile
Bloc du CESI

## Installation du projet

Assurez-vous d'avoir [Composer](https://getcomposer.org/download/), [Symfony 6.4](https://symfony.com/download) et [PHP 8.1](https://www.php.net/downloads)

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

Et voilà ! Il ne vous reste plus qu'à lancer votre serveur :

````shell
symfony server:start
````

## Auteurs
[Noé BROGNARD](https://github.com/xenS14)\
[Ewenn VALLOIS](https://github.com/EwennV)