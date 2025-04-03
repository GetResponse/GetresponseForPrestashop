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

class Product
{
    /** @var int */
    private $id;
    /** @var float */
    private $price;
    /** @var string */
    private $currency;
    /** @var int */
    private $quantity;

    public function __construct(int $id, float $price, string $currency, int $quantity)
    {
        $this->id = $id;
        $this->price = $price;
        $this->currency = $currency;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return array<string, int|float|string>
     */
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'price' => $this->price,
            'currency' => $this->currency,
            'quantity' => (int) $this->quantity,
        ];
    }

    /**
     * @param array<string, int|float|string> $product
     *
     * @return self
     */
    public static function createFromArray(array $product): self
    {
        return new self(
            (int) $product['id'],
            (float) $product['price'],
            (string) $product['currency'],
            (int) $product['quantity']
        );
    }
}
