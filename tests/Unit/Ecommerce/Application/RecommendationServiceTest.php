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

namespace GetResponse\Tests\Unit\Ecommerce\Application;

use GetResponse\Ecommerce\Application\Adapter\ProductAdapter;
use GetResponse\Ecommerce\Application\Command\RecommendedProductCommand;
use GetResponse\Ecommerce\Application\RecommendationService;
use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Image;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\RecommendedProduct;
use GetResponse\Ecommerce\DomainModel\Variant;
use GetResponse\Tests\Unit\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class RecommendationServiceTest extends BaseTestCase
{
    /** @var ProductAdapter|MockObject */
    private $productAdapterMock;

    public function setUp()
    {
        $this->productAdapterMock = $this->getMockWithoutConstructing(ProductAdapter::class);

        $this->sut = new RecommendationService($this->productAdapterMock);
    }

    /**
     * @test
     */
    public function shouldCreateRecommendedProduct()
    {
        $productId = 123;
        $languageId = 4;
        $productUrl = 'https://my-prestashop.com/product/2';
        $price = '19.99';
        $previousPrice = '25.99';
        $sku = 'test_product_1';

        $categories = [
            new Category(3, 1, 'Main category'),
            new Category(3, 1, 'Sub category'),
        ];

        $images = [
            new Image('https://my-prestashop.com/img/p/2.jpg', 2),
        ];

        $variants = [
            new Variant(
                12,
                'Size - Size L',
                $sku,
                $price,
                $price,
                $previousPrice,
                $previousPrice,
                10,
                $productUrl,
                null,
                null,
                'description short2',
                'description2',
                $images
            ),
        ];

        $productMock = new Product(
            $productId,
            'Test Product2',
            Product::CONFIGURABLE_TYPE,
            $productUrl,
            'VendorName',
            $categories,
            $variants,
            '2023-06-01 12:00:01',
            '2023-06-01 12:00:05'
        );

        $this->productAdapterMock
            ->expects(self::once())
            ->method('getProductById')
            ->with($productId, $languageId)
            ->willReturn($productMock);


        $command = new RecommendedProductCommand($productId, $languageId);

        $product = $this->sut->createRecommendedProduct($command);

        self::assertInstanceOf(RecommendedProduct::class, $product);
        self::assertEquals($productUrl, $product->getUrl());
        self::assertEquals($productId, $product->getExternalId());
        self::assertEquals($price, $product->getPrice());
        self::assertEquals($previousPrice, $product->getPreviousPrice());
        self::assertEquals($sku, $product->getSku());
    }

    /**
     * @test
     * @dataProvider pageTypeProvider
     */
    public function shouldReturnPageType($pageId, $expectedPageType)
    {
        $pageType = $this->sut->getPageType($pageId);
        self::assertEquals($expectedPageType, $pageType);
    }

    public function pageTypeProvider()
    {
        return [
            ['index', 'home'],
            ['cart', 'cart'],
            ['category', 'category'],
            ['pagenotfound', 'error'],
            ['product', 'product'],
            ['notExistedPage', null],
            [null, null],
        ];
    }
}
