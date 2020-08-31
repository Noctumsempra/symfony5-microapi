## Setup
#### After you clone the project...
* Install Symfony CLI:
    * `wget https://get.symfony.com/cli/installer -O - | bash`
* Run `echo 'CREATE DATABASE symfony-5-microapi /*!40100 DEFAULT CHARACTER SET utf8 */' | mysql -u root -p`
* Run `composer install`
* Change DB's root password in .ENV file accordingly.
* Run `bin/console doctrine:migrations:migrate`
* Run `symfony server:start`
* Hit endpoints at `localhost:8000` with your preferred API tester (Postman, Insomnia, etc)
* Endpoints:
    * `/get_ford_cars` (GET)
    * `/create_user` (POST)
    * `/delete_user/{id}` (DELETE)
    * `/get_users` (GET)