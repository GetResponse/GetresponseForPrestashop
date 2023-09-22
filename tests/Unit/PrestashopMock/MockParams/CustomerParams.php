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
                    'company' => '',
                ],
            ],
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
                    'company' => '',
                ],
            ],
        ],
    ];

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getCustomerById($id)
    {
        return static::$customer[$id];
    }
}
