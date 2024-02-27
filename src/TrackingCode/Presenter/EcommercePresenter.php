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


namespace GetResponse\TrackingCode\Presenter;

use GetResponse\TrackingCode\DomainModel\Product;

if (!defined('_PS_VERSION_')) {
    exit;
}

class EcommercePresenter
{
    /**
     * @param int $productId
     * @return array
     */
    protected function getProductCategories($productId)
    {
        $categories = [];

        $product = new \Product($productId);

        foreach ($product->getCategories() as $productCategory) {
            $category = new \Category($productCategory);
            $categoryName = is_array($category->name) ? reset($category->name) : $category->name;
            $categories[] = ['id' => (string) $category->id, 'name' => $categoryName];
        }

        return $categories;
    }

    /**
     * @param Product $product
     * @return array
     */
    protected function getProduct( $product)
    {
        $prestashopProduct = new \Product($product->getId());

        $productName = is_array($prestashopProduct->name) ? reset($prestashopProduct->name) : $prestashopProduct->name;

        return [
            'id' => (string) $product->getId(),
            'name' => $productName,
            'price' => number_format($product->getPrice(), 2),
            'sku' => $prestashopProduct->reference,
            'currency' => $product->getCurrency()
        ];
    }
}
