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
class AddressParams
{
    /**
     * @var array
     */
    private static $address = [
        1 => [
            'id'=>1,
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
        ]
    ];

    /**
     * @param int $id
     * @return array
     */
    public static function getAddressById($id)
    {
        return static::$address[$id];
    }
}
