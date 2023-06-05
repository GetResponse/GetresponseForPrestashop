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
class AddressParams
{
    /**
     * @var array
     */
    private static $address = [
        1 => [
            'id' => 1,
            'alias' => 'home',
            'id_address_delivery' => 1,
            'id_address_invoice' => 1,
            'id_state' => 1,
            'id_country' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'address1' => 'address1',
            'address2' => 'address2',
            'city' => 'city',
            'postcode' => 'postcode',
            'phone' => '544404400',
            'company' => 'company',
        ],
    ];

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getAddressById($id)
    {
        return static::$address[$id];
    }
}
