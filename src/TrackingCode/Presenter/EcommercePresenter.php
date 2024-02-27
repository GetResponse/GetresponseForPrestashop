<?php

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
