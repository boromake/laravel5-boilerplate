# Laravel 5 Boilerplate
A boilerplate for Laravel 5.3 applications.

## Installed Packages
  * [SweetAlert](https://github.com/uxweb/sweet-alert) - A simple PHP package to show [SweetAlerts2](https://limonte.github.io/sweetalert2/) with the Laravel Framework
  * [Forms & HTML](https://laravelcollective.com/docs/5.3/html) from LaravelCollective - Adds Form-Model binding
  * [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) - Integrates [PHP Debugbar](http://phpdebugbar.com/) with Laravel
  * [dwightwatson/validating](https://github.com/dwightwatson/validating) - Adds Model validation
  * [Intervention Image](http://image.intervention.io/) - An open source PHP image handling and manipulation library
  * [ramsey/uuid](https://github.com/ramsey/uuid) - A library for generating UUIDs

## Other
  * [UuidModel Trait](http://humaan.com/using-uuids-with-eloquent-in-laravel/) - A trait to help manage UUID fields on a Model
  * [Font Awesome](http://fontawesome.io/) plus custom `@icon()` Blade directive
  * [Foundation 6](http://foundation.zurb.com/sites/docs/) (SASS)

## Settings
  * Uses mysql database
  * Uses database session storage
  * Assumes Mailgun as the email handler

## Features
  * Configurable, cascading logging to file, database, and email
  * Log-in, Log-out, Registration, Forget/Reset password flows are complete
  * Basic admin dashboard is set up
  * Very basic image resizer class (built on the include Intervention Image package)
```
<img src="{{asset('storage/' . \App\Classes\ImageResizer::fit('sub-folder-to-save-in', 'http://lorempixel.com/400/200/', 200, 0))}}" />
```

## Getting Set Up
  *  Follow the [set up instructions](https://github.com/boromake/laravel-5-boilerplate/wiki/Getting-Set-Up)
