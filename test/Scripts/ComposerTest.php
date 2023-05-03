<?php

declare(strict_types=1);

namespace LaminasTest\SendGrid\Scripts;

use Composer\Installer\PackageEvent;
use Laminas\SendGrid\Scripts\Composer;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

use function file_exists;

class ComposerTest extends TestCase
{
    /** @var array|array[][] */
    private array $structure;
    private vfsStreamDirectory $root;

    public function testWillCopyTheDefaultConfigurationFileIfTheConfigAutoloadDirectoryExists()
    {
        $this->structure = [
            'config' => [
                'autoload' => [],
            ],
            'vendor' => [
                'settermjd' => [
                    'laminas-sendgrid-integration' => [
                        'config' => [
                            'autoload' => [
                                'sendgrid.global.php' => 'some file content',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $this->root      = vfsStream::setup('root', null, $this->structure);

        Composer::onPostPackageInstall(
            $this->createMock(PackageEvent::class),
            vfsStream::url('root/'),
        );

        $this->assertTrue(
            file_exists(
                vfsStream::url('root/') . 'config/autoload/sendgrid.global.php'
            )
        );
    }
}
