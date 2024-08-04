# Laravel URL Shortener

Laravel URL Shortener is a simple and useful package that allows you to shorten URLs within the Laravel framework.

## Features

- Shorten long URLs into short URLs
- Resolve short URLs back to their original URLs
- User-friendly interface

## Installation

### Requirements

- PHP 8.0 or higher
- Laravel 7.x or higher

### Step 1: Install the Package

You can install this package via Composer:

```bash
composer require cuneytsenturk/laravel-url-shortener
```

### Step 2: Configuration

To configure the package, publish the `config` file using the following command:

```bash
php artisan vendor:publish --provider="CuneytSenturk\UrlShortener\Provider"
```

Add alias if you want to use the facade.

```php
'UrlShortener' => CuneytSenturk\UrlShortener\Facade::class,
```

### Step 3: Database Migrations

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

## Usage

You can use the package's functions to perform URL shortening operations.

### Shortening a URL

To shorten a URL:

```php
use Cuneytsenturk\UrlShortener\Facade;

$shortUrl = UrlShortener::encode('https://example.com/very/long/url');
echo $shortUrl;
```

### Resolving a Short URL

To resolve a short URL back to its original URL:

```php
use Cuneytsenturk\UrlShortener\Facade;

$originalUrl = UrlShortener::decode($shortUrl);
echo $originalUrl;
```

## Testing

To run the tests that come with the package:

```bash
vendor/bin/phpunit
```

## Contributing

If you would like to contribute, please send a pull request. All contributions are welcome.

## License

This project is licensed under the MIT License. For more information, see the [LICENSE](LICENSE) file.

## Contact

For questions or feedback, please contact [Cüneyt Şentürk](https://github.com/cuneytsenturk).
