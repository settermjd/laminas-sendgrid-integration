<?php

declare(strict_types=1);

namespace Laminas\SendGrid;

use Laminas\SendGrid\Factory\SendGridFactory;
use SendGrid;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                SendGrid::class => SendGridFactory::class,
            ],
        ];
    }
}
