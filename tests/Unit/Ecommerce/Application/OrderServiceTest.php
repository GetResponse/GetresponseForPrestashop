<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
namespace GetResponse\Tests\Unit\Ecommerce\Application;

use GetResponse\Configuration\ReadModel\ConfigurationDto;
use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Ecommerce\Application\Command\UpsertOrder;
use GetResponse\Ecommerce\Application\OrderService;
use GetResponse\MessageSender\Application\MessageSenderService;
use GetResponse\Tests\Unit\BaseTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class OrderServiceTest extends BaseTestCase
{
    /** @var MessageSenderService|PHPUnit_Framework_MockObject_MockObject */
    private $messageSenderServiceMock;
    /** @var ConfigurationReadModel|PHPUnit_Framework_MockObject_MockObject */
    private $configurationReadModelMock;
    /** @var OrderService() */
    private $sut;

    public function setUp()
    {
        $this->messageSenderServiceMock = $this->getMockWithoutConstructing(MessageSenderService::class);
        $this->configurationReadModelMock = $this->getMockWithoutConstructing(ConfigurationReadModel::class);

        $this->sut = new OrderService($this->messageSenderServiceMock, $this->configurationReadModelMock);
    }

    /**
     * @test
     */
    public function shouldUpsertOrder()
    {
        $shopId = 1;
        $orderId = 1;
        $liveSynchronizationUrl = 'https://app.getreponse.com/callback/ecommerce/33983';

        $configurationDTOMock = $this->getMockWithoutConstructing(ConfigurationDto::class);

        $configurationDTOMock
            ->expects(self::once())
            ->method('isEcommerceLiveSynchronizationActive')
            ->willReturn(true);

        $configurationDTOMock
            ->expects(self::once())
            ->method('getLiveSynchronizationUrl')
            ->willReturn($liveSynchronizationUrl);

        $this->configurationReadModelMock
            ->expects(self::once())
            ->method('getConfigurationForShop')
            ->with($shopId)
            ->willReturn($configurationDTOMock);

        $this->messageSenderServiceMock
            ->expects(self::once())
            ->method('send');

        $command = new UpsertOrder($orderId, $shopId);
        $this->sut->upsertOrder($command);
    }

    /**
     * @test
     */
    public function shouldNotUpsertOrderWhenConfigurationIsNotActive()
    {
        $orderId = 1;
        $shopId = 1;

        $configurationDTOMock = $this->getMockWithoutConstructing(ConfigurationDto::class);

        $configurationDTOMock
            ->expects(self::once())
            ->method('isEcommerceLiveSynchronizationActive')
            ->willReturn(false);

        $configurationDTOMock
            ->expects(self::never())
            ->method('getLiveSynchronizationUrl');

        $this->configurationReadModelMock
            ->expects(self::once())
            ->method('getConfigurationForShop')
            ->with($shopId)
            ->willReturn($configurationDTOMock);

        $this->messageSenderServiceMock
            ->expects(self::never())
            ->method('send');

        $command = new UpsertOrder($orderId, $shopId);
        $this->sut->upsertOrder($command);
    }

}
