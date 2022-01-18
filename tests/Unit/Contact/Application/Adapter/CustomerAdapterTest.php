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

namespace GetResponse\Tests\Unit\Contact\Application\Adapter;

use GetResponse\Contact\Application\Adapter\CustomerAdapter;
use GetResponse\Tests\Unit\BaseTestCase;

class CustomerAdapterTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCreateCommandWithSubscribedToNewsletter()
    {
        $prestashopCustomer = new \Customer(1);

        $adapter = new CustomerAdapter();
        $customer = $adapter->getCustomerById(1);

        self::assertEquals($prestashopCustomer->firstname, $customer->getFirstName());
        self::assertEquals($prestashopCustomer->lastname, $customer->getLastName());
        self::assertEquals($prestashopCustomer->email, $customer->getEmail());
        self::assertTrue($customer->getMarketingConsent());
    }

    /**
     * @test
     */
    public function shouldCreateCommandWithNotSubscribedToNewsletter()
    {
        $prestashopCustomer = new \Customer(2);

        $adapter = new CustomerAdapter();
        $customer = $adapter->getCustomerById(2);

        self::assertEquals($prestashopCustomer->firstname, $customer->getFirstName());
        self::assertEquals($prestashopCustomer->lastname, $customer->getLastName());
        self::assertEquals($prestashopCustomer->email, $customer->getEmail());
        self::assertFalse($customer->getMarketingConsent());
    }
}
