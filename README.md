# laminas sendgrid integration

This is a small package that simplifies integrating SendGrid into Laminas and Mezzio projects.

## Installation

Install this package using Composer:

```bash
composer require settermjd/laminas-sendgrid-integration
```

During installation, the default configuration file, _config/autoload/sendgrid.global.php_, will be copied to _config/autoload_, if used within a Mezzio project.
Otherwise, you will need to copy the default configuration file to the applicable directory in your project.

## Configuration

In the configuration file, replace `<<SENDGRID_API_KEY>>` with your [SendGrid API key](https://docs.sendgrid.com/ui/account-and-settings/api-keys).
I recommend using an [environment variable](https://www.twilio.com/blog/working-with-environment-variables-in-php), as in the following example, perhaps set using [PHP Dotenv](https://github.com/vlucas/phpdotenv).

```php
<?php

return [
    'sendgrid' => [
        'api_key' => $_SERVER['SENDGRID_API_KEY']
    ]
];
```