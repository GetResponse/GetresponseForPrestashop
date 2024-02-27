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

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @param array $cart
     * @return self
     */
    public static function createFromArray($cart)
    {
        $products = [];

        foreach ($cart['products'] as $product) {
            $products[] = Product::createFromArray($product);
        }

        return new self($cart['id'], $cart['price'], $cart['currency'], $cart['url'], $products);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $products = [];

        foreach ($this->products as $product) {
            $products[] = $product->toArray();
        }

        return [
            'id' => $this->id,
            'price' => $this->price,
            'currency' => $this->currency,
            'url' => $this->url,
            'products' => $products
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return bool
     */
    public function isValuable()
    {
        return $this->id !== 0;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5(serialize($this->toArray()));
    }
}
