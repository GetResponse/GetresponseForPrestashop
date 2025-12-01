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

use GetResponse\Contact\DomainModel\Customer;
use GetResponse\Ecommerce\Application\Adapter\CartAdapter;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\Ecommerce\DomainModel\Cart;
use GetResponse\Ecommerce\DomainModel\Line;
use GetResponse\SharedKernel\CartRecoveryHelper;
use GetResponse\Tests\Unit\BaseTestCase;

class CartAdapterTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider createCartDataProvider
     */
    public function shouldCreateCart($timeZone, Cart $expectedCart): void
    {
        Configuration::set('PS_TIMEZONE', $timeZone);

        $cartAdapter = new CartAdapter();
        $cartFromCommand = $cartAdapter->getCartById(1, null);

        self::assertEquals($expectedCart, $cartFromCommand);
    }

    public function createCartDataProvider(): array
    {
        $cart = new \Cart(1);

        $currency = new Currency($cart->id_currency);

        $customerAddress = new Address('home', 'Poland', 'John', 'Doe', 'Street 1', '', 'City', 'PostCode', 'State', '', '544 404 400', '');
        $customer = new Customer(
            1,
            'John',
            'Doe',
            'john.doe@example.com',
            $customerAddress,
            true,
            [
                'birthday' => '1987-09-04',
                'note' => 'note 1',
                'id_gender' => 3,
                'id_default_group' => 4,
                'language' => 'en',
            ]
        );

        $products = [
            new Line(
                $cart->products[0]['id_product'],
                1,
                $cart->products[0]['price'],
                $cart->products[0]['price_wt'],
                $cart->products[0]['quantity'],
                'product_combination_1'
            ),
        ];

        $cartRecoveryUrl = CartRecoveryHelper::getUrl((int) $cart->id);

        return [
            [
                'Europe/Warsaw',
                new Cart(
                    $cart->id,
                    $customer,
                    null,
                    $products,
                    $cart->getOrderTotal(false),
                    $cart->getOrderTotal(true),
                    $currency->iso_code,
                    $cartRecoveryUrl,
                    (new DateTime($cart->date_add, new DateTimeZone('Europe/Warsaw')))->format('c'),
                    (new DateTime($cart->date_upd, new DateTimeZone('Europe/Warsaw')))->format('c')
                ),
            ],
            [
                '',
                new Cart(
                    $cart->id,
                    $customer,
                    null,
                    $products,
                    $cart->getOrderTotal(false),
                    $cart->getOrderTotal(true),
                    $currency->iso_code,
                    $cartRecoveryUrl,
                    (new DateTime($cart->date_add, new DateTimeZone('UTC')))->format('c'),
                    (new DateTime($cart->date_upd, new DateTimeZone('UTC')))->format('c')
                ),
            ],
            [
                'ABC',
                new Cart(
                    $cart->id,
                    $customer,
                    null,
                    $products,
                    $cart->getOrderTotal(false),
                    $cart->getOrderTotal(true),
                    $currency->iso_code,
                    $cartRecoveryUrl,
                    (new DateTime($cart->date_add, new DateTimeZone('UTC')))->format('c'),
                    (new DateTime($cart->date_upd, new DateTimeZone('UTC')))->format('c')
                ),
            ],
        ];
    }
}
