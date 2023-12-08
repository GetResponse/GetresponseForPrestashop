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

namespace GetResponse\TrackingCode\DomainModel;

class Cart
{
    /** @var int */
    private $id;
    /** @var float */
    private $price;
    /** @var string */
    private $currency;
    /** @var string */
    private $url;
    /** @var array<Product> */
    private $products;

    public function __construct($id, $price, $currency, $url, $products)
    {
        $this->id = $id;
        $this->price = $price;
        $this->currency = $currency;
        $this->url = $url;
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $products = [];

        foreach ($this->products as $product) {
            $categories = [];

            foreach ($product->getCategories() as $category) {
                $categories[] = $category->toArray();
            }

            $products[] = [
                'product' => $product->toArray(),
                'quantity' => $product->getQuantity(),
                'categories' => $categories
            ];
        }

        return [
            'price' => $this->price,
            'cartId' => (string) $this->id,
            'currency' => $this->currency,
            'cartUrl' => $this->url,
            'products' => $products
        ];
    }

    /**
     * @return bool
     */
    public function isValuable()
    {
        return $this->id !== 0;
    }

    public function getHash()
    {
        return md5(serialize($this->toArray()));
    }

}