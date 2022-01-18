<?php
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author     Getresponse <grintegrations@getresponse.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
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
     * @param bool $refresh
     * @return array
     */
    public function getProducts($refresh)
    {
        return $this->products;
    }
}
