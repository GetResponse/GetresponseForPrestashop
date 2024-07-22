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

use GetResponse\Configuration\ReadModel\ConfigurationDto;
use GetResponse\Configuration\ReadModel\ConfigurationReadModel;
use GetResponse\Ecommerce\Application\Command\UpsertProduct;
use GetResponse\Ecommerce\Application\ProductService;
use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Image;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;
use GetResponse\MessageSender\Application\MessageSenderService;
use GetResponse\Tests\Unit\BaseTestCase;

class ProductServiceTest extends BaseTestCase
{
    /** @var MessageSenderService|\PHPUnit_Framework_MockObject_MockObject */
    private $messageSenderMock;
    /** @var ConfigurationReadModel|\PHPUnit_Framework_MockObject_MockObject */
    private $configurationReadModelMock;
    /** @var ProductService */
    private $sut;

    public function setUp()
    {
        $this->messageSenderMock = $this->getMockWithoutConstructing(MessageSenderService::class);
        $this->configurationReadModelMock = $this->getMockWithoutConstructing(ConfigurationReadModel::class);

        $this->sut = new ProductService($this->messageSenderMock, $this->configurationReadModelMock);
    }

    /**
     * @test
     */
    public function shouldUpsertProduct()
    {
        $shopId = 1;
        $productId = 2;
        $languageId = 2;
        $createdOn = '2020-01-05 12:45:22';
        $updatedOn = '2020-01-06 12:34:12';
        $status = 'publish';

        $categories = [
            new Category(3, 1, 'Default category'),
        ];

        $images = [
            new Image('https://my-prestashop.com/img/p/2.jpg', 2),
        ];

        $variants = [
            new Variant(
                12,
                2,
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
                'description short2',
                'description2',
                $images,
                $status
            ),
        ];

        $productMock = new Product(
            $productId,
            'Test Product2',
            Product::CONFIGURABLE_TYPE,
            'https://my-prestashop.com/product/2',
            'VendorName',
            $categories,
            $variants,
            $createdOn,
            $updatedOn,
            $status
        );

        $liveSynchronizationUrl = 'https://app.getreponse.com/callback/ecommerce/33983';

        $configurationDTOMock = $this->getMockWithoutConstructing(ConfigurationDto::class);

        $configurationDTOMock
            ->expects(self::once())
            ->method('isProductLiveSynchronizationActive')
            ->willReturn(true);

        $configurationDTOMock
            ->expects(self::once())
            ->method('getLiveSynchronizationUrl')
            ->willReturn($liveSynchronizationUrl);

        $this->configurationReadModelMock
            ->expects(self::once())
            ->method('getConfigurationForShop')
            ->with($shopId)
            ->willReturn($configurationDTOMock);

        $this->messageSenderMock
            ->expects(self::once())
            ->method('send')
            ->with($liveSynchronizationUrl, $productMock);

        $command = new UpsertProduct($shopId, $productId, $languageId);
        $this->sut->upsertProduct($command);
    }
}
