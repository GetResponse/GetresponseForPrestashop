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
class CustomerParams
{
    /**
     * @var array
     */
    private static $customer = [
        1 => [
            'id' => 1,
            'id_shop' => 2,
            'id_lang' => 2,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'newsletter' => true,
            'birthday' => '1987-09-04',
            'addresses' => [
                [
                    'alias' => 'home',
                    'country' => 'Poland',
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                    'address1' => 'Street 1',
                    'address2' => '',
                    'city' => 'City',
                    'postcode' => 'PostCode',
                    'state' => 'State',
                    'phone' => '544 404 400',
                    'company' => ''
                ]
            ]
        ],
        2 => [
            'id' => 2,
            'id_shop' => 1,
            'id_lang' => 1,
            'firstname' => 'Mark',
            'lastname' => 'Smith',
            'email' => 'mark.smith@example.com',
            'newsletter' => false,
            'birthday' => '1992-04-21',
            'addresses' => [
                [
                    'alias' => 'home',
                    'country' => 'Poland',
                    'firstname' => 'Mark',
                    'lastname' => 'Smith',
                    'address1' => 'Street 1',
                    'address2' => '',
                    'city' => 'City',
                    'postcode' => 'PostCode',
                    'state' => 'State',
                    'phone' => '544 404 400',
                    'company' => ''
                ]
            ]
        ]
    ];

    /**
     * @param int $id
     * @return array
     */
    public static function getCustomerById($id)
    {
        return static::$customer[$id];
    }

}
