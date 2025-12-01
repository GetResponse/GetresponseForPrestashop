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

use DateTime;
use GetResponse\Ecommerce\Application\Adapter\ProductAdapter;
use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Image;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;
use GetResponse\Tests\Unit\BaseTestCase;
use ImageParams;
use ProductParams;

class ProductAdapterTest extends BaseTestCase
{
    /** @var ProductAdapter */
    private $sut;

    public function setUp(): void
    {
        $this->sut = new ProductAdapter();

        // Backup original state
        $this->originalProductParams = ProductParams::$product;
        $this->originalImageParams = ImageParams::$image;
    }

    public function tearDown(): void
    {
        ProductParams::$product = $this->originalProductParams;
        ImageParams::$image = $this->originalImageParams;
    }

    /**
     * @test
     */
    public function shouldReturnOnlyImageWithLowestPositionForSimpleProduct(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - set multiple images with different positions
        ProductParams::$product[$productId]['images'] = [
            ['id_image' => 3, 'position' => 3],
            ['id_image' => 1, 'position' => 1], // This has the lowest position
            ['id_image' => 2, 'position' => 2],
        ];

        // Add images to ImageParams
        ImageParams::$image[1] = ['id' => 1, 'position' => 1];
        ImageParams::$image[2] = ['id' => 2, 'position' => 2];
        ImageParams::$image[3] = ['id' => 3, 'position' => 3];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variants = $product->getVariants();
        $variantImages = $variants[0]->getImages();

        self::assertCount(1, $variantImages, 'Variant should have exactly one image');
        self::assertEquals(1, $variantImages[0]->getPosition(), 'Should return image with lowest position (1)');
        self::assertEquals('https://my-prestashop.com/img/p/1.jpg', $variantImages[0]->getSrc());
    }

    /**
     * @test
     */
    public function shouldReturnOnlyImageWithLowestPositionForConfigurableProduct(): void
    {
        $productId = 2;
        $languageId = 1;

        // Arrange - set multiple images with different positions
        ProductParams::$product[$productId]['images'] = [
            ['id_image' => 5, 'position' => 5],
            ['id_image' => 2, 'position' => 2], // This has the lowest position
            ['id_image' => 4, 'position' => 4],
            ['id_image' => 3, 'position' => 3],
        ];

        // Add images to ImageParams
        ImageParams::$image[2] = ['id' => 2, 'position' => 2];
        ImageParams::$image[3] = ['id' => 3, 'position' => 3];
        ImageParams::$image[4] = ['id' => 4, 'position' => 4];
        ImageParams::$image[5] = ['id' => 5, 'position' => 5];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variants = $product->getVariants();
        $variantImages = $variants[0]->getImages();

        self::assertCount(1, $variantImages, 'Variant should have exactly one image');
        self::assertEquals(2, $variantImages[0]->getPosition(), 'Should return image with lowest position (2)');
        self::assertEquals('https://my-prestashop.com/img/p/2.jpg', $variantImages[0]->getSrc());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenProductHasNoImages(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - product without images
        ProductParams::$product[$productId]['images'] = [];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variants = $product->getVariants();
        $variantImages = $variants[0]->getImages();

        $assertionMessage = 'Variant should have no images when prestashop product has no images';
        self::assertCount(0, $variantImages, $assertionMessage);
    }

    /**
     * @test
     */
    public function shouldCreateSimpleProduct(): void
    {
        $productId = 1;
        $languageId = 1;

        $product = $this->sut->getProductById($productId, $languageId);

        $categories = [new Category(3, 1, 'Default category')];
        $images = [new Image('https://my-prestashop.com/img/p/2.jpg', 2)];

        $variants = [
            new Variant(
                1,
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

        $dateTimeCreated = (new DateTime('2020-01-05 12:45:22'))->format('c');
        $dateTimeUpdated = (new DateTime('2020-01-06 12:34:12'))->format('c');

        self::assertEquals($productId, $product->getId());
        self::assertEquals('Test Product', $product->getName());
        self::assertEquals(Product::SINGLE_TYPE, $product->getType());
        self::assertEquals('https://my-prestashop.com/product/1', $product->getUrl());
        self::assertEquals('VendorName', $product->getVendor());
        self::assertEquals($categories, $product->getCategories());
        self::assertEquals($variants, $product->getVariants());
        self::assertEquals($dateTimeCreated, $product->getCreatedAt());
        self::assertEquals($dateTimeUpdated, $product->getUpdatedAt());
    }

    /**
     * @test
     */
    public function shouldCreateConfigurableProduct(): void
    {
        $productId = 2;
        $languageId = 1;

        $product = $this->sut->getProductById($productId, $languageId);

        $categories = [new Category(3, 1, 'Default category')];
        $images = [new Image('https://my-prestashop.com/img/p/2.jpg', 2)];

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
                'description short',
                'description',
                $images,
                'publish'
            ),
        ];

        $dateTimeCreated = (new DateTime('2020-01-05 12:45:22'))->format('c');
        $dateTimeUpdated = (new DateTime('2020-01-06 12:34:12'))->format('c');

        self::assertEquals($productId, $product->getId());
        self::assertEquals('Test Product', $product->getName());
        self::assertEquals(Product::CONFIGURABLE_TYPE, $product->getType());
        self::assertEquals('https://my-prestashop.com/product/2', $product->getUrl());
        self::assertEquals('VendorName', $product->getVendor());
        self::assertEquals($categories, $product->getCategories());
        self::assertEquals($variants, $product->getVariants());
        self::assertEquals($dateTimeCreated, $product->getCreatedAt());
        self::assertEquals($dateTimeUpdated, $product->getUpdatedAt());
    }

    /**
     * @test
     */
    public function shouldRemoveHtmlTagsFromDescription(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description with HTML tags
        ProductParams::$product[$productId]['description'] = [
            1 => '<p>This is a <strong>product</strong> with <em>HTML</em> tags</p>',
        ];
        ProductParams::$product[$productId]['description_short'] = [
            1 => '<div>Short <b>description</b> with <a href="#">link</a></div>',
        ];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        self::assertEquals('This is a product with HTML tags', $variant->getDescription());
        self::assertEquals('Short description with link', $variant->getShortDescription());
    }

    /**
     * @test
     */
    public function shouldTruncateDescriptionTo1000CharactersWithEllipsis(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description longer than 1000 characters
        $longText = str_repeat('A', 1600);
        ProductParams::$product[$productId]['description'] = [1 => $longText];
        ProductParams::$product[$productId]['description_short'] = [1 => $longText];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        $description = $variant->getDescription();
        $shortDescription = $variant->getShortDescription();

        self::assertEquals(1000, mb_strlen($description), 'Description should be exactly 1000 characters');
        self::assertEquals(1000, mb_strlen($shortDescription), 'Short description should be exactly 1000 characters');
        self::assertStringEndsWith('...', $description, 'Description should end with ellipsis');
        self::assertStringEndsWith('...', $shortDescription, 'Short description should end with ellipsis');
        self::assertEquals(str_repeat('A', 997) . '...', $description);
    }

    /**
     * @test
     */
    public function shouldNotTruncateDescriptionShorterThan1000Characters(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description shorter than 1000 characters
        $shortText = 'This is a short description with exactly 50 chars!';
        ProductParams::$product[$productId]['description'] = [1 => $shortText];
        ProductParams::$product[$productId]['description_short'] = [1 => $shortText];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        self::assertEquals($shortText, $variant->getDescription());
        self::assertEquals($shortText, $variant->getShortDescription());
        self::assertStringEndsNotWith('...', $variant->getDescription());
    }

    /**
     * @test
     */
    public function shouldRemoveExtraWhitespaceFromDescription(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description with multiple spaces, tabs, and newlines
        ProductParams::$product[$productId]['description'] = [
            1 => "This   has    multiple\n\nspaces\t\tand    tabs",
        ];
        ProductParams::$product[$productId]['description_short'] = [
            1 => "Short   description\n\nwith   whitespace",
        ];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        self::assertEquals('This has multiple spaces and tabs', $variant->getDescription());
        self::assertEquals('Short description with whitespace', $variant->getShortDescription());
    }

    /**
     * @test
     */
    public function shouldHandleDescriptionWithHtmlAndExcessiveLength(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - long description with HTML tags
        $htmlContent = '<p>' . str_repeat('Lorem ipsum dolor sit amet. ', 500) . '</p>';
        ProductParams::$product[$productId]['description'] = [1 => $htmlContent];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        $description = $variant->getDescription();

        self::assertEquals(1000, mb_strlen($description));
        self::assertStringEndsWith('...', $description);
        self::assertStringNotContainsString('<p>', $description);
        self::assertStringNotContainsString('</p>', $description);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyForEmptyDescription(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - empty descriptions
        ProductParams::$product[$productId]['description'] = [1 => ''];
        ProductParams::$product[$productId]['description_short'] = [1 => ''];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        self::assertEmpty($variant->getDescription());
        self::assertEmpty($variant->getShortDescription());
    }

    /**
     * @test
     */
    public function shouldHandleMultibyteCharactersCorrectly(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description with multibyte characters (Polish, emoji)
        $multibyteText = str_repeat('ąćęłńóśźż🎉', 110); // 1000 characters (multibyte)
        ProductParams::$product[$productId]['description'] = [1 => $multibyteText];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        $description = $variant->getDescription();

        self::assertEquals(1000, mb_strlen($description), 'Should count multibyte characters correctly');
        self::assertStringEndsWith('...', $description);
    }

    /**
     * @test
     */
    public function shouldTrimWhitespaceBeforeAndAfterDescription(): void
    {
        $productId = 1;
        $languageId = 1;

        // Arrange - description with leading and trailing whitespace
        ProductParams::$product[$productId]['description'] = [
            1 => '   Product description with spaces   ',
        ];
        ProductParams::$product[$productId]['description_short'] = [
            1 => "\n\tShort description\n\t",
        ];

        // Act
        $product = $this->sut->getProductById($productId, $languageId);

        // Assert
        $variant = $product->getVariants()[0];
        self::assertEquals('Product description with spaces', $variant->getDescription());
        self::assertEquals('Short description', $variant->getShortDescription());
    }


}
