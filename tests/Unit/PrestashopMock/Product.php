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
class Product extends ObjectModel
{
    /** @var string|array Name or array of names by id_lang */
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
    /** @var int Manufacturer identifier */
    public $id_manufacturer;
    /** @var string */
    public $active;
    /** @var array */
    private $wsStockAvailables;

    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
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
        $this->active = $params['active'];
        $this->wsStockAvailables = $params['wsStockAvailables'];
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

    /**
     * Get all available product attributes combinations.
     *
     * @param int|null $id_lang Language identifier
     * @param bool $groupByIdAttributeGroup
     *
     * @return array Product attributes combinations
     */
    public function getAttributeCombinations($id_lang = null, $groupByIdAttributeGroup = true)
    {
        return $this->attributeCombinations;
    }

    /**
     * Get product price
     * Same as static function getPriceStatic, no need to specify product id.
     *
     * @param bool $tax With taxes or not (optional)
     * @param int|null $id_product_attribute Attribute identifier
     * @param int $decimals Number of decimals
     * @param int|null $divisor Util when paying many time without fees
     * @param bool $only_reduc
     * @param bool $usereduc
     * @param int $quantity
     *
     * @return float Product price in euros
     */
    public function getPrice(
        $tax = true,
        $id_product_attribute = null,
        $decimals = 6,
        $divisor = null,
        $only_reduc = false,
        $usereduc = true,
        $quantity = 1
    ) {
        return $this->price;
    }

    public function getWsStockAvailables()
    {
        return $this->wsStockAvailables;
    }

    public function getPriceWithoutReduct($withTax = false)
    {
        return $this->priceWithoutReduct;
    }
}
