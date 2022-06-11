
# laravel 9 CRUD , Role (repository pattern)

Basic CRUD , AUTH system and Role mangment system Operation with Laravel 9 and bootstrap 5


## What's this repo about

Simply, it's a basic create, read, update and delete operation with Laravel 9 and Bootstrap 5. 

## Features

- Role management

- User management

- Account settings 

- Category management

## Tech

- BOOTSRAP 5

- LARAVEL 9

- PHP8


## Requirements

- PHP >= 8.0.0

- PDO PHP Extension

- Mysql 

- Composer >= 2.2.3


# Installation
Just clone the project to anywhere in your computer.
```bash
git clone https://github.com/halimhmairi/laravel-9-roles-and-crud.git
``` 

Then do a composer require laravel/ui

```bash
composer require laravel/ui
``` 

Then create a environment file using this command

```bash
cp .env.example .env
``` 

```bash
php artisan key:generate
``` 

Then edit .env file with appropriate credential for your database server. Just edit these two parameter(```DB_USERNAME``` , ```DB_PASSWORD``` ).

and

```bash 
php artisan migrate
``` 

```bash
php artisan db:seed 
``` 

Now you are done.

```bash
php artisan serve
``` 
and open the project on the browser.
## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
