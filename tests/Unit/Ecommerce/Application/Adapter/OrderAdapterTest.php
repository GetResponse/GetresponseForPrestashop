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

namespace GetResponse\Tests\Unit\Ecommerce\Application\Adapter;

use GetResponse\Contact\DomainModel\Customer;
use GetResponse\Ecommerce\Application\Adapter\OrderAdapter;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\Ecommerce\DomainModel\Order;
use GetResponse\Tests\Unit\BaseTestCase;

class OrderAdapterTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCreateOrderFromCommand()
    {
        $order = new \Order(1);

        $orderUrl = 'https://my-prestashop.com/?controller=order-detail&id_order=' . $order->id;

        $productLines = [];
        $currency = new \Currency($order->id_currency);
        $orderStatus = new \OrderState($order->getCurrentState());

        $customerAddress = new Address('home', 'Poland', 'John', 'Doe', 'Street 1', '', 'City', 'PostCode', 'State', '', '544 404 400', '');
        $customer = new Customer(1, 'John', 'Doe', 'john.doe@example.com', $customerAddress, 1, ['birthday' => '1987-09-04']);

        $address = new Address('home', 'pl', 'John', 'Doe', 'address1', 'address2', 'city', 'postcode', 'state', '', '544404400', 'company');

        $expectedOrder = new Order(
            $order->id,
            $order->reference,
            $order->id_cart,
            'john.doe@example.com',
            $customer,
            $productLines,
            $orderUrl,
            $order->total_paid_tax_excl,
            $order->total_paid_tax_incl,
            $order->total_shipping_tax_incl,
            $currency->iso_code,
            $orderStatus->name,
            $address,
            $address,
            $order->date_add,
            $order->date_upd
        );

        $orderAdapter = new OrderAdapter();
        $orderFromCommand = $orderAdapter->getOrderById($order->id);

        self::assertEquals($expectedOrder, $orderFromCommand);
    }
}
