# Welcome on Cocorico World !

[![Build Status](https://travis-ci.com/Eredost/marketplace.svg?branch=master)](https://travis-ci.com/Eredost/marketplace)

Cocorico World company wants to be an actor of the development of the local commerce on the French market, from producer to consumer, to contribute to the development of the French economy.

The website is intended to be a marketplace. Producers will be able to create and manage their own store and sell all kinds of food products. 
Customers will be able to order products from any producer in France with a very fast home delivery.

## Technologies used

- **Frontend :**
    - HTML / CSS
    - JQuery 3
    - Bootstrap 4
    
- **Backend :**
    - PHP 7.3
    - MySQL
    - Symfony 4
    
### Additional documentation

- [Data dictionary](docs/DD.md)

- [Conceptual data model](docs/MCD.md)

## Installation

Before you can download the project you must first have a PHP version at least 7.3X and a recent version of Composer.

To set up the project, follow the steps below :

1. Clone the repository
2. Move your current directory to the root of the project
3. Perform the command :

        composer install
4. Create a new file ``.env.local`` and add the line below by changing the user's name and password as well as the name of the database.

        DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
5. Finally, all you have to do is set up the database, associated tables and fixtures with the following commands :

        php bin/console doctrine:database:create
        php bin/console doctrine:migrations:migrate
        php bin/console doctrine:fixtures:load
6. Two choices are available to you to start the project locally. You can first go through the Apache server but you will need to download a dependency beforehand :

        composer require apache-pack
        
   Or you can go directly to the pre-installed symfony server and go to the localhost address it has indicated :
   
        php bin/console server:run
        
**And it's over !**

## Contributions

To contribute to the project, you will have to follow a set of rules so that the project progresses in the best conditions.

- It is strictly forbidden to push directly on the **master**. Any changes will have to be made through **branches** and **pull requests**.

- Name your branches so that they are easily traceable and identifiable for everyone (example: fixtures).

- Commits must be fully written in **English** and must be sufficiently explicit. An [Buzut article](https://buzut.net/git-bien-nommer-ses-commits/) to have some commit naming tips.

- The comments in the code aren't optional, without going overboard, try to find a happy medium. Same rule as for the commits, they will be named in **English** (as well as the variables, constants etc ...).

- The pull requests must be initiated when you are sure that you have finished all of your modifications, they will be examined before being merged on the **master** definitively.

## Contributors

- [SebMarc](https://github.com/SebMarc)
- [Ayshae](https://github.com/Ayshae)
- [So-maly](https://github.com/So-maly)
- [UniverseConqueror](https://github.com/UniverseConqueror)
- [Eredost](https://github.com/Eredost)
