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
class ProductParams
{
    /**
     * @var array
     */
    private static $product = [
        1 => [
            'id' => 1,
            'name' => [1 => 'Test Product', 2 => 'Test Product2'],
            'images' => [
                [
                    'id_image' => 2,
                    'position' => 1
                ]
            ],
            'categories' => [3],
            'hasAttributes' => false,
            'link_rewrite' => [1 => 'link_rewrite', 2 => 'link_rewrite2'],
            'price' => 19.99,
            'attributeCombinations' => [
                [
                    'id_product_attribute' => 12,
                    'group_name' => 'Size',
                    'attribute_name' => 'Size L',
                    'quantity' => 10,
                ]
            ],
            'reference' => 'test_product_1',
            'quantity' => 10,
            'description_short' => [1 => 'description short', 2 => 'description short2'],
            'description' => [1 => 'description', 2 => 'description2'],
            'date_add' => '2020-01-05 12:45:22',
            'date_upd' => '2020-01-06 12:34:12',
            'id_manufacturer' => 1,
            'active' => '1',
        ],
        2 => [
            'id' => 2,
            'name' => [1 => 'Test Product', 2 => 'Test Product2'],
            'images' => [
                [
                    'id_image' => 2,
                    'position' => 1
                ]
            ],
            'categories' => [3],
            'hasAttributes' => true,
            'link_rewrite' => [1 => 'link_rewrite', 2 => 'link_rewrite2'],
            'price' => 19.99,
            'attributeCombinations' => [
                [
                    'id_product_attribute' => 12,
                    'group_name' => 'Size',
                    'attribute_name' => 'Size L',
                    'quantity' => 10,
                ]
            ],
            'reference' => 'test_product_1',
            'quantity' => 10,
            'description_short' => [1 => 'description short', 2 => 'description short2'],
            'description' => [1 => 'description', 2 => 'description2'],
            'date_add' => '2020-01-05 12:45:22',
            'date_upd' => '2020-01-06 12:34:12',
            'id_manufacturer' => 1,
            'active' => '1',
        ],
    ];

    /**
     * @param int $id
     * @return array
     */
    public static function getProductById($id)
    {
        return static::$product[$id];
    }

}
