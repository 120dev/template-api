Template-API
===========

## Requirements

**This project allows to create posts, categories via an interface API type**

The following dependencies needs to be previously installed :
* PHP 5.6
* Laravel 5.4
* Composer

## Installation

1. Clone this github repository on your local computer

  ```bash
  $ git clone https://github.com/120dev/template-api
  ```

2. Install dependencies

  ```bash
  $ composer install
  ```

3. Copy `.env.sample` to `.env` and change it's content according to your environment.

  ```bash
  $ cp .env.sample .env
  ```

4. Generate an application key

  ```bash
  $ php artisan key:generate
  ```

5. Create a databases (prod & testing) with the name used in `.env` (`DB_DATABASE`).

6. Run the following command to create tables

  ```bash
  $ php artisan migrate
  ```

7. Invoke the `seeder` to insert some data

  ```bash
  $ php artisan db:seed
  ```
## Server
  ```bash
  $ php artisan serve
  ```
## Test

```bash
  $ phpunit
```

## Usage / Demo
##### For : Create Read Update Delete on post

#### POST `/`
```curl
$ curl -X POST \
    http://localhost:8000/api/posts/ \
    -H 'accept: application/vnd.templateApi.v1+json' \
    -H 'cache-control: no-cache' \
    -F title=test \
    -F body=body \
    -F active=1 \
    -F category_id=1
```

#### GET `/`
```curl
$ curl -X GET http://localhost:8000/api/posts/ \
        -H 'accept: application/vnd.templateApi.v1+json' \
        -H 'cache-control: no-cache'
```

#### GET `/id`
```curl
$ curl -X GET http://localhost:8000/api/posts/1 \
        -H 'accept: application/vnd.templateApi.v1+json' \
        -H 'cache-control: no-cache'
```

#### PATCH `/1`
```curl
$ curl -X PATCH \
      http://localhost:8000/api/posts/1 \
      -H 'accept: application/vnd.templateApi.v1+json' \
      -H 'cache-control: no-cache' \
      -H 'content-type: application/x-www-form-urlencoded' \
      -d 'title=title&body=body&category_id=1&active=1'
```

#### DELETE `/1`
```curl
$ curl -X DELETE \
    http://localhost:8000/api/posts/1 \
    -H 'accept: application/vnd.templateApi.v1+json' \
    -H 'cache-control: no-cache'
```

