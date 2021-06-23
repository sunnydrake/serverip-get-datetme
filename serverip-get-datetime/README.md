# SunnyDrake's Server IP Get DateTime PHP Lib with worldtimeapi.org API #

## Requirements ##

This module has no external dependencies.
Needs allow_url_fopen set to true in php.ini or code. 

## Install via Composer ##

We recommend installing this package with [Composer](http://getcomposer.org/).

### Download Composer ###

To download Composer, run in the root directory of your project:

```bash
curl -sS https://getcomposer.org/installer | php
```

You should now have the file `composer.phar` in your project directory.

### Install Dependencies ###

Run in your project root:

```
php composer.phar require sunnydrake/serverip-get-datetime
```

You should now have the files `composer.json` and `composer.lock` as well as
the directory `vendor` in your project directory. If you use a version control
system, `composer.json` should be added to it.

### Require Autoloader ###

After installing the dependencies, you need to require the Composer autoloader
from your code:

```php
require 'vendor/autoload.php';
```

## Install without Composer ##

Place the 'ServerGetDateTime.php' file in the `include_path` as specified in your
`php.ini` file or place it in the same directory as your PHP scripts.


## Usage ##

Gets DateTime for current IP :

```php
<?php

require 'vendor/autoload.php';
var_dump (ServerGetDateTime::getDateTime());
```

## Copyright and License ##

This software is Copyright (c) 2021 by Oleh Marychev.

This is free software, licensed under the GNU Lesser General Public License
version 3 or later.

## Thanks ##

Thanks to Oleksandr Roslov oleksandr.roslov@1648factory.com for task.
