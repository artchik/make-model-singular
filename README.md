# Laravel Singular Table Name "Make Model" Artisan Command

## Problem
By default, Laravel assumes that the table names are in the plural. But, lets assume that we want to generate a model and a migration based on a singular table name. This is possible, but in three steps.
1. Generate the Model
    ```bash
    php artisan make:model Post
    ```
2. Tell the model that we'll be using the singular table name
    ```php
    protected $table = 'post';
    ```
3. Generate the migration
    ```bash
    php artisan make:migration create_post_table --table=post
    ```
It would be nice to have a single command do all of the above.

## Solution

*This package* will allow you run a single command to accomplish all three of these steps:
```bash
php artisan make:model-singular Post -m
```
You can utilize any of the regular **make:model** options, e.g.
```bash
php artisan make:model-singular Post -a
```
You can also specify a custom table if you wish:
```bash
php artisan make:model-singular Post --table=my_post
```
You can also specify a **sub-directory for a controller**:
```bash
php artisan make:model-singular Post --cdir=API
```
## Installing

```bash
composer require artchik/make-model-singular --dev
```

## License

MIT

## Acknowledgements

* [Laravel Modding: Generating Models with singular table names by Peter Fox](https://medium.com/@SlyFireFox/laravel-modding-generating-models-with-singular-table-names-8c8f28589d6b)
* [Build Your Own Laravel Package in 10 Minutes Using Composer by Francis Macugay](https://medium.com/simplex-internet-blog/build-your-own-laravel-package-in-10-minutes-using-composer-867e8ef875dd)
* [Create and Publish a Laravel Package on Packagist by Samuel Ogundipe](https://pusher.com/tutorials/publish-laravel-packagist)