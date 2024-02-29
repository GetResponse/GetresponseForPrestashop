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

class Order
{
    /** @var int */
    private $id;
    /** @var int */
    private $cartId;
    /** @var float */
    private $price;
    /** @var string */
    private $currency;
    /** @var array<Product> */
    private $products;

    public function __construct($id, $cartId, $price, $currency, $products)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->price = $price;
        $this->currency = $currency;
        $this->products = $products;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCartId()
    {
        return $this->cartId;
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
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
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
            'id' => (string) $this->id,
            'cartId' => (string) $this->cartId,
            'price' => (float) $this->price,
            'currency' => $this->currency,
            'products' => $products,
        ];
    }

    /**
     * @param array $order
     *
     * @return self
     */
    public static function createFromArray($order)
    {
        $products = [];

        foreach ($order['products'] as $product) {
            $products[] = Product::createFromArray($product);
        }

        return new self($order['id'], $order['cartId'], $order['price'], $order['currency'], $products);
    }

    /**
     * @return bool
     */
    public function isValuable()
    {
        return $this->id !== 0;
    }
}
