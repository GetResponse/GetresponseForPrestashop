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
class CartParams
{
    /**
     * @var array
     */
    private static $cart = [
        1 => [
            'id' => 1,
            'id_shop' => 3,
            'id_customer' => 1,
            'id_currency' => 2,
            'total' => 29.99,
            'total_tax' => 34.43,
            'date_add' => '2020-05-12 11:43:59',
            'date_upd' => '2020-05-14 16:32:03',
            'products' => [
                [
                    'id_product' => 34,
                    'variant_id' => 1,
                    'quantity' => 1,
                    'price' => 29.99,
                    'price_wt' => 34.43,
                    'reference' => 'product_34',
                    'id_product_attribute' => 1,
                ],
            ],
        ],
    ];

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getCartById($id)
    {
        return static::$cart[$id];
    }
}
