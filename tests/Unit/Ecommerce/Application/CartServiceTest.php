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
use GetResponse\Contact\DomainModel\Customer;
use GetResponse\Ecommerce\Application\CartService;
use GetResponse\Ecommerce\Application\Command\UpsertCart;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\Ecommerce\DomainModel\Cart;
use GetResponse\Ecommerce\DomainModel\Line;
use GetResponse\MessageSender\Application\MessageSenderService;
use GetResponse\Tests\Unit\BaseTestCase;

class CartServiceTest extends BaseTestCase
{
    /** @var MessageSenderService|\PHPUnit_Framework_MockObject_MockObject */
    private $messageSenderServiceMock;
    /** @var ConfigurationReadModel|\PHPUnit_Framework_MockObject_MockObject */
    private $configurationReadModelMock;
    /** @var CartService */
    private $sut;

    public function setUp()
    {
        $this->messageSenderServiceMock = $this->getMockWithoutConstructing(MessageSenderService::class);
        $this->configurationReadModelMock = $this->getMockWithoutConstructing(ConfigurationReadModel::class);

        $this->sut = new CartService($this->messageSenderServiceMock, $this->configurationReadModelMock);
    }

    /**
     * @test
     */
    public function shouldUpsertCart()
    {
        $shopId = 3;
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

        $address = new Address(
            'home',
            'Poland',
            'John',
            'Doe',
            'Street 1',
            '',
            'City',
            'PostCode',
            'State',
            '',
            '544 404 400',
            ''
        );

        $customerMock = new Customer(1, 'John', 'Doe', 'john.doe@example.com', $address, true, ['birthday' => '1987-09-04']);

        $line = new Line(1, 29.99, 34.43, 1, 'product_combination_1');

        $cartMock = new Cart(
            1,
            $customerMock,
            [$line],
            29.99,
            34.43,
            'eur',
            'https://my-prestashop.com/pl/koszyk?action=show',
            '2020-05-12 11:43:59',
            '2020-05-14 16:32:03'
        );

        $this->messageSenderServiceMock
            ->expects(self::once())
            ->method('send')
            ->with($liveSynchronizationUrl, $cartMock);

        $command = new UpsertCart(1, $shopId);

        $this->sut->upsertCart($command);
    }
}
