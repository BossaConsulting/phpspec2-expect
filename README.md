[![Build Status](https://travis-ci.org/BossaConsulting/phpspec2-expect.svg?branch=master)](https://travis-ci.org/BossaConsulting/phpspec2-expect)

phpspec2-expect
---------------

Installation
============

Install it using the `composer require` command:

```bash
composer require --dev bossa/phpspec2-expect
```

Usage
=====

Inside some example:

```php

       expect(file_exists('crazyfile.xtn'))->toBe(true);

```
