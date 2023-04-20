<?php

declare(strict_types=1);

namespace Laminas\SendGrid\Factory;

use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use SendGrid;

use function array_key_exists;
use function is_array;

/**
 * This class simplifies instantiating a SendGrid class from the application's configuration provided
 *
 * The __invoke method expects the application's conrfiguration to have at least the following structure:
 *
 * [
 *     'sendgrid' => [
 *         'api_key' => $apiKey
 *     ]
 * ]
 */
class SendGridFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): SendGrid
    {
        if (! $container->has('config')) {
            throw new InvalidArgumentException('Application configuration is missing.');
        }

        $configuration = $container->get('config');

        if (
            ! is_array($configuration)
            || ! array_key_exists('sendgrid', $configuration)
        ) {
            throw new InvalidArgumentException('SendGrid configuration is missing.');
        }

        if (
            ! is_array($configuration['sendgrid'])
            || ! array_key_exists('api_key', $configuration['sendgrid'])
            || empty($configuration['sendgrid']['api_key'])
        ) {
            throw new InvalidArgumentException('SendGrid configuration is missing an API key.');
        }

        ['api_key' => $apiKey] = $configuration['sendgrid'];

        return new SendGrid((string) $apiKey);
    }
}
