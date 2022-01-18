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
class OrderParams
{
    /**
     * @var array
     */
    private static $order = [
        1 => [
            'id' => 1,
            'id_customer' => 1,
            'id_currency' => 1,
            'id_address_delivery' => 1,
            'id_address_invoice' => 1,
            'reference' => 'WD32X98',
            'id_cart' => 1,
            'products' => [],
            'total_paid_tax_excl' => 9.99,
            'total_paid_tax_incl' => 12.33,
            'total_shipping_tax_incl' => 5.00,
            'current_state' => 2,
            'id_lang' => 1,
            'date_add' => '2020-03-12',
            'date_upd' => '2020-03-15',
        ]
    ];

    /**
     * @param int $id
     * @return array
     */
    public static function getOrderById($id)
    {
        return static::$order[$id];
    }
}
