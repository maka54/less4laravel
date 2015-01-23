Less4Laravel Alternative
============

This is an alternative issue to use oyejorge/less.php instead of leafo/lessphp with this package jtgrimes/less4laravel https://github.com/jtgrimes/less4laravel

Usage is same

All Changes here :

Installation
============

Add `maka\less4laravel` as a requirement to composer.json:

```javascript
{
    "require": {
        "Maka/less4laravel": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

Once Composer has installed or updated your packages you need to register 
Less4Laravel with Laravel itself. Open up `app/config/app.php` and 
find the providers key towards the bottom and add:

```php
'Maka\Less4laravel\LessServiceProvider'
```

In the aliases section, add:

```php
'Less'	=>	'Maka\Less4laravel\LessFacade'
```

Configuration
=============

In order to work with the configuration file, you're best off publishing a copy
with Artisan:

```
$ php artisan config:publish maka/less4laravel
```



