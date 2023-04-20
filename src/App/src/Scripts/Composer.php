<?php

declare(strict_types=1);

namespace Laminas\SendGrid\Scripts;

use Composer\Installer\PackageEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;

class Composer extends Command
{
    /**
     * This function will copy the default configuration file to the config/autoload directory
     * if the config/autoload directory exists in the project.
     */
    public static function postPackageInstall(PackageEvent $event, ?string $basePath = './'): void
    {
        $filesystem = new Filesystem();
        if ($filesystem->exists("{$basePath}config/autoload")) {
            $configFilePath = "config/autoload/sendgrid.global.php";
            $filesystem->copy(
                "{$basePath}vendor/settermjd/laminas-sendgrid-integration/{$configFilePath}",
                "{$basePath}{$configFilePath}"
            );
        }
    }
}