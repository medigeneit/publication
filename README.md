# Book Store

## Table of Contents

* [Package and Version](#package-and-version)
* [Installation](#installation)

## Package and Version

|PHP|Laravel|Inertia js|Vue|tailwindcss
|:-:|:-:|:-:|:-:|:-:|
|^7.3|^8.65|^0.4.3|^3.0.5|^2.1.2

## Installation

``` bash
# clone the repo
$ git clone https://github.com/msisaif/book-store.git

# go into app's directory
$ cd book-store

# install app's dependencies
$ composer install

# Copy file ".env.example", and change its name to ".env".

# Linux
$ cp .env.example .env

# windows
$ copy .env.example .env
```

Then in file ".env" setup database configuration:
* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306
* DB_DATABASE=book_store
* DB_USERNAME=root
* DB_PASSWORD=

### Next step

``` bash
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate

# install app's dependencies
$ npm install

# and repeat generate mixing
$ npm run dev

# start server
$ php artisan serve
```
