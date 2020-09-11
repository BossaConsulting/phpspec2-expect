[![Build Status](https://travis-ci.org/BossaConsulting/phpspec-expect.svg?branch=3.x)](https://travis-ci.org/BossaConsulting/phpspec-expect)

phpspec-expect
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
         "bossa/phpspec-expect": "^3.0"
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

Roadmap
=======

Version `2.x` supports PhpSpec 3 and PHP 5.6.

Version `3.0.x` requires PhpSpec 4, and therefore requires PHP 7.

Version `3.1.x` requires PhpSpec 5 and PHP 7.

These versions are all under active support.
