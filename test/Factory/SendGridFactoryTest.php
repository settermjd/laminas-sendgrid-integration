<?php

declare(strict_types=1);

namespace LaminasTest\SendGrid\Factory;

use Faker\Factory;
use InvalidArgumentException;
use Laminas\SendGrid\Factory\SendGridFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class SendGridFactoryTest extends TestCase
{
    private ContainerInterface&MockObject $container;

    public function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testCanInstantiateSendGridObjectWhenCorrectConfigurationIsAvailabl(): void
    {
        $faker  = Factory::create();
        $apiKey = $faker->word();

        $this->container
            ->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([
                'sendgrid' => [
                    'api_key' => $apiKey,
                ],
            ]);

        $this->container
            ->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $factory  = new SendGridFactory();
        $sendGrid = $factory($this->container);

        $headers = $sendGrid->client->getHeaders();
        $this->assertContains("Authorization: Bearer {$apiKey}", $headers);
    }

    /**
     * @dataProvider invalidConfigurationDataProvider
     */
    public function testCannotInstantiateSendGridObjectWithoutAValidConfiguration(?array $configuration = null): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->container
            ->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn($configuration);

        $this->container
            ->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $factory = new SendGridFactory();
        $factory($this->container);
    }

    public static function invalidConfigurationDataProvider(): array
    {
        return [
            [
                [],
            ],
            [
                null,
            ],
            [
                ['sendgrid' => null],
            ],
            [
                ['sendgrid' => []],
            ],
            [
                [
                    'sendgrid' => [
                        'api_key' => null,
                    ],
                ],
            ],
            [
                [
                    'sendgrid' => [
                        'api_key_' => '',
                    ],
                ],
            ],
        ];
    }

    public function testCannotInstantiateSendGridObjectIfApplicationConfigurationIsMissing(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->container
            ->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(false);

        $factory = new SendGridFactory();
        $factory($this->container);
    }
}
