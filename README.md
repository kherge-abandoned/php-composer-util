Composer Utilities
==================

[![Build Status](https://travis-ci.org/herrera-io/php-composer-util.png?branch=master)](https://travis-ci.org/herrera-io/php-composer-util)

A library consisting of Composer utility functions.

Installation
------------

Add it to your list of Composer dependencies:

```sh
$ composer require herrera-io/composer-util=1.*
```

Usage
-----

```php
<?php

user Herrera\Composer\Util\Util;

$path = Util::getComposerPath(__DIR__); // "/path/to/composer.json"
$loader = Util::getClassLoader($path); // "Composer\Autoload\ClassLoader"
```