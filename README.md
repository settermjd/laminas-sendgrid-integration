# laminas sendgrid integration

This is a small package that simplifies integrating SendGrid into Laminas and Mezzio projects.

## Installation

Install this package using Composer:

```bash
composer require settermjd/laminas-sendgrid-integration
```

## Configuration

If you're using the package with Mezzio, copy the default configuration file, _config/autoload/sendgrid.global.php_, to _config/autoload_ in your project.
Then, either ensure that the `SENDGRID_API_KEY` environment variable is set, or change the value of `api_key` in _config/autoload/sendgrid.global.php_ as appropriate.
I recommend using [PHP Dotenv](https://github.com/vlucas/phpdotenv) to set environment variables during development and your deployment tool otherwise.