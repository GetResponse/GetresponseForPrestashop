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
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductAdapter
{
    const PRODUCT_STATUS_PUBLISH = 'publish';
    const PRODUCT_STATUS_DRAFT = 'draft';
    const SKU_PREFIX = 'sku_';

    /**
     * @param int $languageId
     * @param int $productId
     *
     * @return Product
     */
    public function getProductById(int $productId, int $languageId): Product
    {
        $imageAdapter = new ImageAdapter();
        $product = new \Product($productId);
        $link = new \Link();

        $variants = [];
        $images = [];
        $categories = [];
        $productType = Product::SINGLE_TYPE;

        $productLink = $link->getProductLink($product, null, null, null, $languageId);

        foreach ($product->getImages($languageId) as $image) {
            $images[] = $imageAdapter->getImageById((int) $image['id_image']);
        }

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
                    $product->active === '1' ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
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
                $product->active === '1' ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
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
            $product->date_add,
            $product->date_upd,
            $product->active === '1' ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
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

    /**
     * @param \Product $product
     * @param int $languageId
     *
     * @return mixed|null
     */
    private function getDescription(\Product $product, int $languageId)
    {
        $description = $product->description[$languageId];

        if (empty($description)) {
            return null;
        }

        return $description;
    }

    /**
     * @param \Product $product
     * @param int $languageId
     *
     * @return mixed|null
     */
    private function getShortDescription(\Product $product, int $languageId)
    {
        $description = $product->description_short[$languageId];

        if (empty($description)) {
            return null;
        }

        return $description;
    }

    /**
     * @param \Product $product
     * @param int $idProductAttribute
     *
     * @return int
     */
    private function getProductQuantity(\Product $product, int $idProductAttribute): int
    {
        if (empty($product->getWsStockAvailables())) {
            return 0;
        }

        if (!is_array($product->getWsStockAvailables())) {
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

    /**
     * @param \Product $product
     * @param int $idProductAttribute
     *
     * @return int|null
     */
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
}
