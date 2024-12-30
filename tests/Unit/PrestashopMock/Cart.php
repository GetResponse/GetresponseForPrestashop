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
class Cart
{
    /** @var int */
    public $id;
    /** @var int */
    public $id_shop;
    /** @var int */
    public $id_customer;
    /** @var int */
    public $id_currency;
    /** @var float */
    public $total;
    /** @var float */
    public $total_tax;
    /** @var string */
    public $date_add;
    /** @var string */
    public $date_upd;
    /** @var array */
    public $products;

    public function __construct($id)
    {
        $params = CartParams::getCartById($id);
        $this->id = $params['id'];
        $this->id_shop = $params['id_shop'];
        $this->id_customer = $params['id_customer'];
        $this->id_currency = $params['id_currency'];
        $this->total = $params['total'];
        $this->total_tax = $params['total_tax'];
        $this->date_add = $params['date_add'];
        $this->date_upd = $params['date_upd'];
        $this->products = $params['products'];
    }

    /**
     * @param bool $withTax
     *
     * @return float
     */
    public function getOrderTotal($withTax)
    {
        if ($withTax) {
            return $this->total_tax;
        }

        return $this->total;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}
