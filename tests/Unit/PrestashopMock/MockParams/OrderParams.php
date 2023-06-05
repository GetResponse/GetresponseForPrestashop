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
        ],
    ];

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getOrderById($id)
    {
        return static::$order[$id];
    }
}
