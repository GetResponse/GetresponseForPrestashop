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
                    'position' => 1,
                ],
            ],
            'categories' => [3],
            'hasAttributes' => false,
            'link_rewrite' => [1 => 'link_rewrite', 2 => 'link_rewrite2'],
            'price' => 19.99,
            'priceWithoutReduct' => 29.99,
            'attributeCombinations' => [
                [
                    'id_product_attribute' => 12,
                    'group_name' => 'Size',
                    'attribute_name' => 'Size L',
                    'quantity' => 10,
                    'reference' => 'test_product_1',
                ],
            ],
            'reference' => 'test_product_1',
            'quantity' => 10,
            'description_short' => [1 => 'description short', 2 => 'description short2'],
            'description' => [1 => 'description', 2 => 'description2'],
            'date_add' => '2020-01-05 12:45:22',
            'date_upd' => '2020-01-06 12:34:12',
            'id_manufacturer' => 1,
            'active' => '1',
            'wsStockAvailables' => [
                ['id' => '12', 'id_product_attribute' => '0'],
                ['id' => '13', 'id_product_attribute' => '12'],
            ],
        ],
        2 => [
            'id' => 2,
            'name' => [1 => 'Test Product', 2 => 'Test Product2'],
            'images' => [
                [
                    'id_image' => 2,
                    'position' => 1,
                ],
            ],
            'categories' => [3],
            'hasAttributes' => true,
            'link_rewrite' => [1 => 'link_rewrite', 2 => 'link_rewrite2'],
            'price' => 19.99,
            'priceWithoutReduct' => 29.99,
            'attributeCombinations' => [
                [
                    'id_product_attribute' => 12,
                    'group_name' => 'Size',
                    'attribute_name' => 'Size L',
                    'quantity' => 10,
                    'reference' => 'test_product_1',
                ],
            ],
            'reference' => 'test_product_1',
            'quantity' => 10,
            'description_short' => [1 => 'description short', 2 => 'description short2'],
            'description' => [1 => 'description', 2 => 'description2'],
            'date_add' => '2020-01-05 12:45:22',
            'date_upd' => '2020-01-06 12:34:12',
            'id_manufacturer' => 1,
            'active' => '1',
            'wsStockAvailables' => [
                ['id' => '12', 'id_product_attribute' => '0'],
                ['id' => '13', 'id_product_attribute' => '12'],
            ],
        ],
    ];

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getProductById($id)
    {
        return static::$product[$id];
    }
}
