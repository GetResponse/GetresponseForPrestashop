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


namespace GetResponse\Tests\Unit\Ecommerce\DomainModel;

use GetResponse\Ecommerce\DomainModel\RecommendedProduct;
use GetResponse\Tests\Unit\BaseTestCase;

class RecommendedProductTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider recommendedProductProvider
     */
    public function shouldReturnRecommendedProduct(
        $url,
        $externalId,
        $name,
        $price,
        $imageUrl,
        $description,
        $category1,
        $category2,
        $sku,
        $previousPrice
    ) {
        $expectedProductArray = [
            'productUrl' => 'https://my-prestashop.com/product/1',
            'pageUrl' => 'https://my-prestashop.com/product/1',
            'productExternalId' => 3,
            'productName' => 'Test Product',
            'price' => 12.99,
            'imageUrl' => 'https://my-prestashop.com/product/image/1.jpg',
            'description' => 'This is productDescription',
            'category' => "FirstCategory > SecondCategory",
            'available' => true,
            'sku' => 'product-sku',
            'attribute1' => 19.99,
            'attribute2' => null,
            'attribute3' => null,
            'attribute4' => null
        ];

        $product = new RecommendedProduct($url, $externalId, $name, $price, $imageUrl, $description, [$category1, $category2], $sku, $previousPrice);
        self::assertEquals($expectedProductArray, $product->toArray());
    }

    public function recommendedProductProvider()
    {
        return [
            [
                'https://my-prestashop.com/product/1',
                3,
                'Test Product',
                12.99,
                'https://my-prestashop.com/product/image/1.jpg',
                'This is productDescription',
                'FirstCategory',
                'SecondCategory',
                'product-sku',
                19.99
            ],
            [
                'https://my-prestashop.com/product/1',
                3,
                'Test Product',
                12.98989,
                'https://my-prestashop.com/product/image/1.jpg',
                'This is <p>productDescription</p>\n',
                'FirstCategory',
                'SecondCategory',
                'product-sku',
                19.99000001
            ]
        ];
    }
}
