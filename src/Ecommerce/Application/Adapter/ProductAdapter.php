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

use Category as PrestashopCategory;
use GetResponse\Ecommerce\DomainModel\Category;
use GetResponse\Ecommerce\DomainModel\Product;
use GetResponse\Ecommerce\DomainModel\Variant;
use Link;
use Manufacturer;
use Product as PrestashopProduct;

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
    public function getProductById($productId, $languageId)
    {
        $imageAdapter = new ImageAdapter();
        $product = new PrestashopProduct($productId);
        $link = new Link();

        $variants = [];
        $images = [];
        $categories = [];
        $productType = Product::SINGLE_TYPE;

        $productLink = $link->getProductLink($product, false, false, false, $languageId);

        foreach ($product->getImages($languageId) as $image) {
            $images[] = $imageAdapter->getImageById($image['id_image']);
        }

        foreach ($product->getCategories() as $productCategory) {
            $category = new PrestashopCategory($productCategory, $languageId);
            $categories[] = new Category($category->id, $category->id_parent, $category->name);
        }

        if ($product->hasAttributes()) {
            $productType = Product::CONFIGURABLE_TYPE;
            $combinations = $this->prepareCombinations(
                $product->getAttributeCombinations($languageId)
            );

            foreach ($combinations as $combination) {
                $variant = new Variant(
                    (int) $combination['id_product_attribute'],
                    $combination['name'],
                    $this->getProductConfigurableSku($combination),
                    $product->getPrice(false, $combination['id_product_attribute']),
                    $product->getPrice(true, $combination['id_product_attribute']),
                    $product->getPriceWithoutReduct(true),
                    $product->getPriceWithoutReduct(false),
                    $this->getProductQuantity($product, (int) $combination['id_product_attribute']),
                    $productLink,
                    null,
                    null,
                    $this->getShortDescription($product, $languageId),
                    $this->getDescription($product, $languageId),
                    $images,
                    $product->active === '1' ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
                );

                $variants[] = $variant;
            }
        } else {
            $variants[] = new Variant(
                $product->id,
                $product->name[$languageId],
                $this->getProductSimpleSku($product),
                $product->getPrice(false),
                $product->getPrice(),
                $product->getPriceWithoutReduct(true),
                $product->getPriceWithoutReduct(false),
                $this->getProductQuantity($product, 0),
                $productLink,
                null,
                null,
                $this->getShortDescription($product, $languageId),
                $this->getDescription($product, $languageId),
                $images,
                $product->active === '1' ? self::PRODUCT_STATUS_PUBLISH : self::PRODUCT_STATUS_DRAFT
            );
        }

        $manufacture = new Manufacturer($product->id_manufacturer);

        return new Product(
            $product->id,
            $product->name[$languageId],
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
     * @param array $combinations
     *
     * @return array
     */
    private function prepareCombinations(array $combinations)
    {
        $uniqueCombinations = [];

        foreach ($combinations as $combination) {
            if (array_key_exists($combination['id_product_attribute'], $uniqueCombinations)) {
                $combination['name'] = $combination['group_name'] . ' - ' . $combination['attribute_name'];
                $uniqueCombinations[$combination['id_product_attribute']]['name'] .= ', ' . $combination['name'];
            } else {
                $combination['name'] = $combination['group_name'] . ' - ' . $combination['attribute_name'];
                $uniqueCombinations[$combination['id_product_attribute']] = $combination;
            }
        }

        return $uniqueCombinations;
    }

    /**
     * @param PrestashopProduct $product
     * @param $languageId
     *
     * @return mixed|null
     */
    private function getDescription(PrestashopProduct $product, $languageId)
    {
        $description = $product->description[$languageId];

        if (empty($description)) {
            return null;
        }

        return $description;
    }

    /**
     * @param PrestashopProduct $product
     * @param $languageId
     *
     * @return mixed|null
     */
    private function getShortDescription(PrestashopProduct $product, $languageId)
    {
        $description = $product->description_short[$languageId];

        if (empty($description)) {
            return null;
        }

        return $description;
    }

    private function getProductQuantity(PrestashopProduct $product, int $idProductAttribute)
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

    private function getProductConfigurableSku(array $combination)
    {
        if (!empty($combination['reference'])) {
            return $combination['reference'];
        }

        return self::SKU_PREFIX . $combination['id_product_attribute'];
    }

    private function getProductSimpleSku(PrestashopProduct $product)
    {
        if (!empty($product->reference)) {
            return $product->reference;
        }

        return self::SKU_PREFIX . $product->id;
    }

    private function getStockAvailableId(PrestashopProduct $product, int $idProductAttribute)
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
