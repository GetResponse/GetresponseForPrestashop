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

namespace GetResponse\Tests\Unit\Ecommerce\Application\Adapter;

use GetResponse\Ecommerce\Application\Adapter\ProductAdapter;
use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Image;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;
use GetResponse\Tests\Unit\BaseTestCase;

class ProductAdapterTest extends BaseTestCase
{
    /** @var ProductAdapter */
    private $sut;

    public function setUp()
    {
        $this->sut = new ProductAdapter();
    }

    /**
     * @test
     */
    public function shouldCreateSimpleProduct()
    {
        $productId = 1;
        $languageId = 1;

        $product = $this->sut->getProductById($productId, $languageId);

        $categories = [
            new Category(3, 1, 'Default category'),
        ];

        $images = [
            new Image('https://my-prestashop.com/img/p/2.jpg', 2),
        ];

        $variants = [
            new Variant(
                1,
                'Test Product',
                'test_product_1',
                19.99,
                19.99,
                29.99,
                29.99,
                100,
                'https://my-prestashop.com/product/1',
                null,
                null,
                'description short',
                'description',
                $images,
                'publish'
            ),
        ];

        self::assertEquals($productId, $product->getId());
        self::assertEquals('Test Product', $product->getName());
        self::assertEquals(Product::SINGLE_TYPE, $product->getType());
        self::assertEquals('https://my-prestashop.com/product/1', $product->getUrl());
        self::assertEquals('VendorName', $product->getVendor());
        self::assertEquals($categories, $product->getCategories());
        self::assertEquals($variants, $product->getVariants());
        self::assertEquals('2020-01-05 12:45:22', $product->getCreatedAt());
        self::assertEquals('2020-01-06 12:34:12', $product->getUpdatedAt());
    }

    /**
     * @test
     */
    public function shouldCreateConfigurableProduct()
    {
        $productId = 2;
        $languageId = 1;

        $product = $this->sut->getProductById($productId, $languageId);

        $categories = [
            new Category(3, 1, 'Default category'),
        ];

        $images = [
            new Image('https://my-prestashop.com/img/p/2.jpg', 2),
        ];

        $variants = [
            new Variant(
                12,
                'Size - Size L',
                'test_product_1',
                19.99,
                19.99,
                29.99,
                29.99,
                100,
                'https://my-prestashop.com/product/2',
                null,
                null,
                'description short',
                'description',
                $images,
                'publish'
            ),
        ];

        self::assertEquals($productId, $product->getId());
        self::assertEquals('Test Product', $product->getName());
        self::assertEquals(Product::CONFIGURABLE_TYPE, $product->getType());
        self::assertEquals('https://my-prestashop.com/product/2', $product->getUrl());
        self::assertEquals('VendorName', $product->getVendor());
        self::assertEquals($categories, $product->getCategories());
        self::assertEquals($variants, $product->getVariants());
        self::assertEquals('2020-01-05 12:45:22', $product->getCreatedAt());
        self::assertEquals('2020-01-06 12:34:12', $product->getUpdatedAt());
    }
}
