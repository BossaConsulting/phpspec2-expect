[![Build Status](https://travis-ci.org/BossaConsulting/phpspec2-expect.svg?branch=master)](https://travis-ci.org/BossaConsulting/phpspec2-expect)

phpspec2-expect
---------------

Installation
============

Install it using the `composer require` command:

```bash
   composer require --dev bossa/phpspec2-expect
```

Alternativelly you can add it to the `composer.json` file

```json
{
    "require-dev": {
         "bossa/phpspec2-expect": "^2.2"
    },
    "config": {
        "bin-dir": "bin"
    },
    "minimum-stability": "dev",
    "autoload": {
        "psr-0": {
            "spec": "",
            "": "src"
        }
    }
}
```

Usage
=====

Inside some example:

```php

       expect(file_exists('crazyfile.xtn'))->toBe(true);

```
