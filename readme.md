# RepositoryPattern

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require morshadun/repositorypattern
```

## Usage
Via PHP Artisan

``` bash
$ php artisan morshadun:controller <Controller Name>
```

This command will create files into app directory with related folders.
#### For Controller
- App\Http\Controllers
#### For Repositories
- App\Repositories
#### For Services
- App\Services
#### For Transformers
- App\Transformers

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit --filter new_controller_is_created
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/morshadun/repositorypattern.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/morshadun/repositorypattern.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/morshadun/repositorypattern/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/morshadunnur/repositorypattern
[link-downloads]: https://packagist.org/packages/morshadunnur/repositorypattern
[link-travis]: https://travis-ci.org/morshadun/repositorypattern
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/morshadunnur
[link-contributors]: ../../contributors
