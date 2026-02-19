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

namespace GetResponse\Ecommerce\Application\Adapter;

use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Image;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;
use GetResponse\SharedKernel\DateTimeNormalizer;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductAdapter
{
    use DateTimeNormalizer;

    const PRODUCT_STATUS_PUBLISH = 'publish';
    const PRODUCT_STATUS_DRAFT = 'draft';
    const SKU_PREFIX = 'sku_';
    const MAX_DESC_LENGTH = 1000;

    /**
     * @param int $languageId
     * @param int $productId
     *
     * @return Product
     */
    public function getProductById(int $productId, int $languageId): Product
    {
        $product = new \Product($productId);
        $link = new \Link();

        $variants = [];
        $categories = [];
        $productType = Product::SINGLE_TYPE;

        $productLink = $link->getProductLink($product, null, null, null, $languageId);

        $images = $this->getImages($product->getImages($languageId));

        foreach ($product->getCategories() as $productCategory) {
            $category = new \Category($productCategory, $languageId);
            $categories[] = new Category(
                (int) $category->id,
                (int) $category->id_parent,
                (string) $category->name
            );
        }

        if ($product->hasAttributes()) {
            $productType = Product::CONFIGURABLE_TYPE;
            $combinations = $this->prepareCombinations(
                $product->getAttributeCombinations($languageId)
            );

            foreach ($combinations as $combination) {
                $variant = new Variant(
                    (int) $combination['id_product_attribute'],
                    (int) $product->id,
                    (string) $combination['name'],
                    $this->getProductConfigurableSku($combination),
                    $product->getPrice(false, (int) $combination['id_product_attribute']),
                    $product->getPrice(true, (int) $combination['id_product_attribute']),
                    $product->getPriceWithoutReduct(true),
                    $product->getPriceWithoutReduct(false),
                    $this->getProductQuantity($product, (int) $combination['id_product_attribute']),
                    $productLink,
                    null,
                    null,
                    (string) $this->getShortDescription($product, $languageId),
                    (string) $this->getDescription($product, $languageId),
                    $images,
                    $product->active ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
                );

                $variants[] = $variant;
            }
        } else {
            $variants[] = new Variant(
                (int) $product->id,
                (int) $product->id,
                (string) $product->name[$languageId],
                $this->getProductSimpleSku($product),
                $product->getPrice(false),
                $product->getPrice(),
                $product->getPriceWithoutReduct(true),
                $product->getPriceWithoutReduct(false),
                $this->getProductQuantity($product, 0),
                $productLink,
                null,
                null,
                (string) $this->getShortDescription($product, $languageId),
                (string) $this->getDescription($product, $languageId),
                $images,
                $product->active ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
            );
        }

        $manufacture = new \Manufacturer($product->id_manufacturer);

        return new Product(
            (int) $product->id,
            (string) $product->name[$languageId],
            $productType,
            $productLink,
            $manufacture->name,
            $categories,
            $variants,
            $this->getDateWithTimeZone($product->date_add),
            $this->getDateWithTimeZone($product->date_upd),
            $product->active ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
        );
    }

    /**
     * @param array<int, array<string, mixed>> $combinations
     *
     * @return array<int, array<string, mixed>>
     */
    private function prepareCombinations(array $combinations): array
    {
        $uniqueCombinations = [];

        foreach ($combinations as $combination) {
            if (array_key_exists((int) $combination['id_product_attribute'], $uniqueCombinations)) {
                $combination['name'] = $combination['group_name'] . ' - ' . $combination['attribute_name'];
                $uniqueCombinations[(int) $combination['id_product_attribute']]['name'] .= ', ' . $combination['name'];
            } else {
                $combination['name'] = $combination['group_name'] . ' - ' . $combination['attribute_name'];
                $uniqueCombinations[(int) $combination['id_product_attribute']] = $combination;
            }
        }

        return $uniqueCombinations;
    }

    private function getDescription(\Product $product, int $languageId): ?string
    {
        $description = $product->description[$languageId];

        if (empty($description)) {
            return null;
        }

        return $this->sanitizeDescription($description, self::MAX_DESC_LENGTH);
    }

    private function getShortDescription(\Product $product, int $languageId): ?string
    {
        $description = $product->description_short[$languageId];

        if (empty($description)) {
            return null;
        }

        return $this->sanitizeDescription($description, self::MAX_DESC_LENGTH);
    }

    private function getProductQuantity(\Product $product, int $idProductAttribute): int
    {
        if (empty($product->getWsStockAvailables())) {
            return 0;
        }

        $stockAvailableId = $this->getStockAvailableId($product, $idProductAttribute);

        if ($stockAvailableId === null) {
            return 0;
        }

        if (class_exists('StockAvailable')) {
            return (new \StockAvailable($stockAvailableId))->quantity;
        }

        return (new \StockAvailableCore($stockAvailableId))->quantity;
    }

    /**
     * @param array<string, mixed> $combination
     *
     * @return string
     */
    private function getProductConfigurableSku(array $combination): string
    {
        if (!empty($combination['reference'])) {
            return (string) $combination['reference'];
        }

        return self::SKU_PREFIX . (int) $combination['id_product_attribute'];
    }

    /**
     * @param \Product $product
     *
     * @return string
     */
    private function getProductSimpleSku(\Product $product): string
    {
        if (!empty($product->reference)) {
            return (string) $product->reference;
        }

        return self::SKU_PREFIX . (int) $product->id;
    }

    private function getStockAvailableId(\Product $product, int $idProductAttribute): ?int
    {
        foreach ($product->getWsStockAvailables() as $stockAvailable) {
            if (!is_array($stockAvailable)) {
                continue;
            }
            if (!isset($stockAvailable['id_product_attribute'])) {
                continue;
            }
            if (is_numeric($stockAvailable['id_product_attribute'])
                && (int) $stockAvailable['id_product_attribute'] === $idProductAttribute) {
                return (int) $stockAvailable['id'];
            }
        }

        return null;
    }

    /**
     * @param array<int, array{id_image:string}> $productImages
     *
     * @return array<int, Image>
     */
    private function getImages(array $productImages): array
    {
        if (empty($productImages)) {
            return [];
        }

        $images = [];
        $imageAdapter = new ImageAdapter();
        foreach ($productImages as $productImage) {
            $image = $imageAdapter->getImageById((int) $productImage['id_image']);
            $images[$image->getPosition()] = $image;
        }

        ksort($images);

        return [reset($images)];
    }

    private function sanitizeDescription(string $description, int $maxLength): string
    {
        $cleanDescription = (string) preg_replace('#<style(.*?)>(.*?)</style>#is', '', $description);
        $cleanDescription = (string) preg_replace('#<script(.*?)>(.*?)</script>#is', '', $cleanDescription);
        $cleanDescription = html_entity_decode($cleanDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cleanDescription = html_entity_decode($cleanDescription, ENT_COMPAT);
        $cleanDescription = strip_tags($cleanDescription);
        $cleanDescription = trim($cleanDescription);
        $cleanDescription = (string) preg_replace('/\s+/', ' ', $cleanDescription);

        if (mb_strlen($cleanDescription) <= $maxLength) {
            return $cleanDescription;
        }

        return mb_substr($cleanDescription, 0, $maxLength - 3) . '...';
    }
}
