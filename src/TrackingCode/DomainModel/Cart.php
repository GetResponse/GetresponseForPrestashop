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
    /** @var array<int, Product> */
    private $products;

    /**
     * @param array<int, Product> $products
     */
    public function __construct(int $id, float $price, string $currency, string $url, array $products)
    {
        $this->id = $id;
        $this->price = $price;
        $this->currency = $currency;
        $this->url = $url;
        $this->products = $products;
    }

    /**
     * @return array<string, int|float|string|array<int, array<string, int|float|string>>>
     */
    public function toArray(): array
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
            'products' => $products,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array<int, Product>
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function isValuable(): bool
    {
        return $this->id !== 0;
    }

    public function getHash(): string
    {
        return md5(serialize($this->toArray()));
    }
}
