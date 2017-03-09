# DNS-O-Matic-PHP

This is a simple client for [DNS-O-Matic](https://www.dnsomatic.com/).

## What is DNS-O-Matic?

### For Users
DNS-O-Matic provides you a free and easy way to announce your dynamic IP changes to multiple services with a single update. Using DNS-O-Matic allows you to pick and choose what Dynamic DNS services you want to notify, all from one easy to use interface.

### For Developers
DNS-O-Matic provides a scalable and standardized solution for developers to easily provide support for all dynamic DNS / IP services in their software or platform with one simple and consistent API at no cost.

### For Dynamic DNS Providers
DNS-O-Matic will support dynamic DNS services without any work on your side. As more software clients and hardware vendors adopt the DNS-O-Matic API, the reach and ease of adoption for your service expands automatically.

## Examples

There are a few simple example scripts that can be used to get started with this library.

- [checker.php](example/checker.php): IP Resolution example;
- [cron.php](example/cron.php): Full DNS-O-Matic cronjob script that updates a single hostname;
- [updater.php](example/updater.php): DNS-O-Matic update example.

## Requirements

- PHP7.1+
- [Guzzle](https://github.com/guzzle/guzzle)

## Installing

The recommended way to install this library is through [Composer](http://getcomposer.org/).

```bash
# Install composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version:

```bash
php composer.phar require flavioheleno/dnsomatic-php
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php`;
```

## License

This library is released under the MIT license. See [LICENSE](LICENSE) for details.
