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

namespace GetResponse\Ecommerce\Application;

use GetResponse\Ecommerce\Application\Command\RecommendedProductCommand;
use GetResponse\Ecommerce\DomainModel\RecommendedProduct;
use GetResponse\Ecommerce\DomainModel\Variant;

if (!defined('_PS_VERSION_')) {
    exit;
}

class RecommendationService
{
    private $productAdapter;

    public function __construct($productAdapter)
    {
        $this->productAdapter = $productAdapter;
    }

    /**
     * @return RecommendedProduct|null
     */
    public function createRecommendedProduct(RecommendedProductCommand $command)
    {
        $product = $this->productAdapter->getProductById($command->getProductId(), $command->getLanguageId());
        /** @var Variant $variant */
        $variant = !empty($product->getVariants()) ? $product->getVariants()[0] : null;

        if (null === $variant) {
            return null;
        }

        $imageUrl = !empty($variant->getImages()) ? $variant->getImages()[0]->getSrc() : null;

        return new RecommendedProduct(
            $product->getUrl(),
            $product->getId(),
            $product->getName(),
            $variant->getPriceTax(),
            $imageUrl,
            $variant->getDescription(),
            $this->getCategories($product),
            $variant->getSku(),
            $variant->getPreviousPriceTax()
        );
    }

    /**
     * @return string|null
     */
    public function getPageType($pageId)
    {
        $mapping = [
            'index' => 'home',
            'cart' => 'cart',
            'category' => 'category',
            'pagenotfound' => 'error',
            'product' => 'product',
        ];

        return isset($mapping[$pageId]) ? $mapping[$pageId] : null;
    }

    /**
     * @return array
     */
    public function getCategories($product)
    {
        return array_map(static function ($category) {
            return $category->getName();
        }, $product->getCategories());
    }
}
