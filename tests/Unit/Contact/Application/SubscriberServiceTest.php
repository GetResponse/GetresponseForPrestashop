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

use GetResponse\Contact\Application\Command\UnsubscribeContact;
use GetResponse\Contact\Application\SubscriberService;
use GetResponse\Contact\DomainModel\NewsletterRepository;
use GetResponse\Tests\Unit\BaseTestCase;

class SubscriberServiceTest extends BaseTestCase
{
    /** @var NewsletterRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $newsletterRepositoryMock;

    /** @var SubscriberService */
    private $sut;

    public function setUp()
    {
        $this->newsletterRepositoryMock = $this->getMockWithoutConstructing(NewsletterRepository::class);

        $this->sut = new SubscriberService($this->newsletterRepositoryMock);
    }

    /**
     * @test
     */
    public function shouldUnsubscribeContact()
    {
        $shopId = 3;
        $email = 'some@email.com';

        $this->newsletterRepositoryMock
            ->expects(self::once())
            ->method('removeSubscriberFromNewsletter')
            ->with($shopId, $email);

        $this->newsletterRepositoryMock
            ->expects(self::once())
            ->method('removeCustomerFromNewsletter')
            ->with($shopId, $email);

        $this->sut->unsubscribe(
            new UnsubscribeContact($shopId, $email)
        );
    }
}
