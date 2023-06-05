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
class Product
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var array */
    public $images;
    /** @var array */
    public $categories;
    /** @var int */
    public $hasAttributes;
    /** @var array */
    public $attributeCombinations;
    /** @var string */
    public $link_rewrite;
    /** @var float */
    public $price;
    /** @var float */
    public $priceWithoutReduct;
    /** @var string */
    public $reference;
    /** @var int */
    public $quantity;
    /** @var string */
    public $description_short;
    /** @var string */
    public $description;
    /** @var string */
    public $date_add;
    /** @var string */
    public $date_upd;
    /** @var string */
    public $id_manufacturer;

    public function __construct($id)
    {
        $params = ProductParams::getProductById($id);
        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->images = $params['images'];
        $this->categories = $params['categories'];
        $this->hasAttributes = $params['hasAttributes'];
        $this->attributeCombinations = $params['attributeCombinations'];
        $this->link_rewrite = $params['link_rewrite'];
        $this->price = $params['price'];
        $this->priceWithoutReduct = $params['priceWithoutReduct'];
        $this->reference = $params['reference'];
        $this->quantity = $params['quantity'];
        $this->description_short = $params['description_short'];
        $this->description = $params['description'];
        $this->date_add = $params['date_add'];
        $this->date_upd = $params['date_upd'];
        $this->id_manufacturer = $params['id_manufacturer'];
    }

    public function getImages($languageId)
    {
        return $this->images;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function hasAttributes()
    {
        return $this->hasAttributes;
    }

    public function getAttributeCombinations()
    {
        return $this->attributeCombinations;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPriceWithoutReduct($withTax = false)
    {
        return $this->priceWithoutReduct;
    }
}
