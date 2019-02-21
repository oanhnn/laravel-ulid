# Laravel ULID

[![Latest Version](https://img.shields.io/packagist/v/oanhnn/laravel-ulid.svg)](https://packagist.org/packages/oanhnn/laravel-ulid)
[![Software License](https://img.shields.io/github/license/oanhnn/laravel-ulid.svg)](LICENSE)
[![Build Status](https://img.shields.io/travis/oanhnn/laravel-ulid/master.svg)](https://travis-ci.org/oanhnn/laravel-ulid)
[![Coverage Status](https://img.shields.io/coveralls/github/oanhnn/laravel-ulid/master.svg)](https://coveralls.io/github/oanhnn/laravel-ulid?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/oanhnn/laravel-ulid.svg)](https://packagist.org/packages/oanhnn/laravel-ulid)
[![Requires PHP](https://img.shields.io/travis/php-v/oanhnn/laravel-ulid.svg)](https://travis-ci.org/oanhnn/laravel-ulid)

A Laravel package skeleton.

## TODO

- [ ] Make repository on [Github](https://github.com)
- [ ] Make repository on [Travis](https://travis.org)
- [ ] Make repository on [Coveralls](https://coveralls.io)
- [ ] Make repository on [Packagist](https://packagist.org)
- [x] Write logic classes
- [ ] Write test scripts
- [ ] Write README & documents

## Requirements

* php >=7.1.3
* Laravel 5.5+

## Installation

Begin by pulling in the package through Composer.

```bash
$ composer require oanhnn/laravel-ulid
```

## Usage

To let a model make use of ULIDs, you must add a ulid field as the primary field in the table.

```php
Schema::create('table_name', function (Blueprint $table) {
    $table->ulid('id');
    $table->primary('id');

    // other fields
});
```

To get your model to work with the encoded ULID (i.e. to use ulid as a primary key), you must let your model use the `Laravel\Ulid\HasUlid` trait.

```php
use Illuminate\Database\Eloquent\Model;
use Laravel\Ulid\HasUlid;

class TestModel extends Model
{
    use HasUlid;

    // other logic codes
}
```

### Creating a model
The UUID of a model will automatically be generated upon save.

$model = MyModel::create();

## Changelog

See all change logs in [CHANGELOG](CHANGELOG.md)

## Testing

```bash
$ git clone git@github.com/oanhnn/laravel-ulid.git /path
$ cd /path
$ composer install
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email to [Oanh Nguyen](mailto:oanhnn.bk@gmail.com) instead of 
using the issue tracker.

## Credits

- [Oanh Nguyen](https://github.com/oanhnn)
- [All Contributors](../../contributors)

## License

This project is released under the MIT License.   
Copyright © [Oanh Nguyen](https://oanhnn.github.io).
