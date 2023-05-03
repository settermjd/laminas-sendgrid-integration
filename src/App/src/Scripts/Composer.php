<?php

declare(strict_types=1);

namespace Laminas\SendGrid\Scripts;

use Composer\Installer\PackageEvent;
use Symfony\Component\Filesystem\Filesystem;

use function sprintf;

class Composer
{
    public const CONFIG_FILE_PATH = "config/autoload/sendgrid.global.php";

    /**
     * This function will copy the default configuration file to the config/autoload directory
     * if the config/autoload directory exists in the project.
     */
    public static function onPostPackageInstall(PackageEvent $event, ?string $basePath = './'): void
    {
        $configFile = "config/autoload/sendgrid.global.php";

        $filesystem = new Filesystem();

        $consoleOutput = $event->getIO();

        if (! $filesystem->exists("{$basePath}config/autoload")) {
            $consoleOutput->write("config/autoload directory was not detected.");
            $consoleOutput->write("Cannot copy configuration file for laminas-sendgrid-integration.");
            return;
        }

        if (! $filesystem->exists("{$basePath}{$configFile}")) {
            $filesystem->copy(
                "{$basePath}vendor/settermjd/laminas-sendgrid-integration/{$configFile}",
                "{$basePath}{$configFile}"
            );
            $consoleOutput->write(
                "Copied configuration file for laminas-sendgrid-integration to config/autoload."
            );
        }
    }

    public static function onPostPackageUninstall(PackageEvent $event, ?string $basePath = './'): void
    {
        $consoleOutput = $event->getIO();
        $configFile    = sprintf("{$basePath}%s", self::CONFIG_FILE_PATH);

        $filesystem = new Filesystem();
        if ($filesystem->exists($configFile)) {
            $filesystem->remove($configFile);
            $consoleOutput->write(
                "Removed laminas-sendgrid-integration config file from config/autoload."
            );
        }
    }
}
