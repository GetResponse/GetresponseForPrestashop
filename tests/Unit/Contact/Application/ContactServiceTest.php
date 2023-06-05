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

namespace GetResponse\Tests\Unit\Contact\Application;

use GetResponse\Configuration\ReadModel\ConfigurationDto;
use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Contact\Application\Command\UpsertCustomer;
use GetResponse\Contact\Application\ContactService;
use GetResponse\Contact\DomainModel\Customer;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\MessageSender\Application\MessageSenderService;
use GetResponse\Tests\Unit\BaseTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class ContactServiceTest extends BaseTestCase
{
    /** @var MessageSenderService|PHPUnit_Framework_MockObject_MockObject */
    private $messageSenderServiceMock;
    /** @var ConfigurationReadModel|PHPUnit_Framework_MockObject_MockObject */
    private $configurationReadModelMock;

    /** @var ContactService */
    private $sut;

    public function setUp()
    {
        $this->messageSenderServiceMock = $this->getMockWithoutConstructing(MessageSenderService::class);
        $this->configurationReadModelMock = $this->getMockWithoutConstructing(ConfigurationReadModel::class);

        $this->sut = new ContactService($this->messageSenderServiceMock, $this->configurationReadModelMock);
    }

    /**
     * @test
     */
    public function shouldSendContactToGetResponse()
    {
        $liveSynchronizationUrl = 'https://app.getreponse.com/callback/ecommerce/33983';

        $configurationDTOMock = $this->getMockWithoutConstructing(ConfigurationDto::class);
        $configurationDTOMock
            ->expects(self::once())
            ->method('isContactLiveSynchronizationActive')
            ->willReturn(true);

        $configurationDTOMock
            ->expects(self::once())
            ->method('getLiveSynchronizationUrl')
            ->willReturn($liveSynchronizationUrl);

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

        $command = new UpsertCustomer(1, 1);

        $this->configurationReadModelMock
            ->expects(self::once())
            ->method('getConfigurationForShop')
            ->with(1)
            ->willReturn($configurationDTOMock);

        $this->messageSenderServiceMock
            ->expects(self::once())
            ->method('send')
            ->with($liveSynchronizationUrl, $customerMock);

        $this->sut->upsertCustomer($command);
    }

    /**
     * @test
     */
    public function shouldSkipWhenLiveSyncIsDisabled()
    {
        $configurationDTOMock = $this->getMockWithoutConstructing(ConfigurationDto::class);
        $configurationDTOMock
            ->expects(self::once())
            ->method('isContactLiveSynchronizationActive')
            ->willReturn(false);

        $command = new UpsertCustomer(1, 1, 'John', 'Doe', 'john.doe@example.com', true);

        $this->configurationReadModelMock
            ->expects(self::once())
            ->method('getConfigurationForShop')
            ->with(1)
            ->willReturn($configurationDTOMock);

        $this->messageSenderServiceMock
            ->expects(self::never())
            ->method('send');

        $this->sut->upsertCustomer($command);
    }
}
