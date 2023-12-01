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

class Product
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var float */
    private $price;
    /** @var string */
    private $sku;
    /** @var string */
    private $currency;
    /** @var int */
    private $quantity;
    /** @var array<Category> */
    private $categories;

    public function __construct($id, $name, $price, $sku, $currency, $quantity, $categories)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
        $this->currency = $currency;
        $this->quantity = $quantity;
        $this->categories = $categories;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function toArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'price' => number_format($this->price, 2),
            'sku' => $this->sku,
            'currency' => $this->currency
        ];
    }


}
