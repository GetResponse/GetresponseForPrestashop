<?php

declare(strict_types=1);

namespace GetResponse\TrackingCode\Presenter;

use GetResponse\TrackingCode\DomainModel\Product;

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
            $categories[] = [$category->id, $category->name];
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

        return [
            'id' => (string) $product->getId(),
            'name' => $prestashopProduct->name,
            'price' => number_format($product->getPrice(), 2),
            'sku' => $prestashopProduct->reference,
            'currency' => $product->getCurrency()
        ];
    }
}
