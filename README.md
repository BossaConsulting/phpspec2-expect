phpspec2-expect
---------------

Installation
============

Add `"bossa/phpspec2-expect": "*"` to `composer.json`

```json
{
    "require-dev": {
         "phpspec/phpspec": "dev-master",
         "bossa/phpspec2-expect": "*"
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
