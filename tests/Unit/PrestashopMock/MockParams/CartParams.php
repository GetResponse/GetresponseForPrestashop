<?php

/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author     Getresponse <grintegrations@getresponse.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
class CartParams
{
    /**
     * @var array
     */
    private static $cart = [
        1 => [
            'id' => 1 ,
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
                    'quantity' => 1,
                    'price' => 29.99,
                    'price_wt' => 34.43,
                    'reference' => 'product_34',
                    'id_product_attribute' => 1
                ]
            ]
        ]
    ];

    /**
     * @param int $id
     * @return array
     */
    public static function getCartById($id)
    {
        return static::$cart[$id];
    }
}
