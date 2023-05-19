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

namespace GetResponse\Ecommerce\DomainModel;

use JsonSerializable;

class Line implements JsonSerializable
{
    /** @var int */
    private $variantId;
    /** @var float */
    private $price;
    /** @var float */
    private $priceTax;
    /** @var int */
    private $quantity;
    /** @var string */
    private $sku;

    public function __construct(
        $variantId,
        $price,
        $priceTax,
        $quantity,
        $sku
    ) {
        $this->variantId = $variantId;
        $this->price = $price;
        $this->priceTax = $priceTax;
        $this->quantity = $quantity;
        $this->sku = $sku;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'variant_id' => $this->variantId,
            'price' => $this->price,
            'price_tax' => $this->priceTax,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
        ];
    }
}
