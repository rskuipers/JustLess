JustLess
========

ZF2 module that allows automation of compiling your LESS with the extra of minifying the files.
A view helper is available which expects a .less file as a parameter and will compile and possibly minify it returning the filename of the compiled file.


Installation
------------

1. Add the module to your composer.json

    ```json
    "require": {
        "rickkuipers/justless": "dev-master"
    }
    ```
2. Run composer update: `php composer.phar update`
    
3. Enable the module in application.config.php

    ```php
    return array(
      'modules' => array(
        /*...*/
        'JustLess',
        /*...*/
      ),
    );
    ```
4. Copy the file from `/vendor/rickkuipers/justless/config/justless.global.php.dist` to `/config/autoload/justless.global.php`
5. Edit the config to match your preferred configuration
6. Make sure the `destination_dir` is writable (`chmod -R 0777 css/`).

Usage
------------
`$this->less($file, $minify)` first parameter is the .less file, second parameter is optional if you want to override the default configuration of minifying the css.
```php
<link href="<?php echo $this->basePath($this->less('less/style.less')) ?>" media="screen" rel="stylesheet" type="text/css">
```
