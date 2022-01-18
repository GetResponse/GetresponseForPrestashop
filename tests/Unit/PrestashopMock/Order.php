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
class Order
{
    /** @var int */
    public $id;
    /** @var int */
    public $id_address_delivery;
    /** @var int */
    public $id_address_invoice;
    /** @var int */
    public $id_customer;
    /** @var int */
    public $id_currency;
    /** @var string */
    public $reference;
    /** @var int */
    public $id_cart;
    /** @var array */
    public $products;
    /** @var float */
    public $total_paid_tax_excl;
    /** @var float */
    public $total_paid_tax_incl;
    /** @var float */
    public $total_shipping_tax_incl;
    /** @var int */
    public $current_state;
    /** @var int */
    public $id_lang;
    /** @var string */
    public $date_add;
    /** @var string */
    public $date_upd;

    public function __construct($id)
    {
        $params = OrderParams::getOrderById($id);
        $this->id = $params['id'];
        $this->id_customer = $params['id_customer'];
        $this->id_address_delivery = $params['id_address_delivery'];
        $this->id_address_invoice = $params['id_address_invoice'];
        $this->id_currency = $params['id_currency'];
        $this->reference = $params['reference'];
        $this->id_cart = $params['id_cart'];
        $this->products = $params['products'];
        $this->total_paid_tax_excl = $params['total_paid_tax_excl'];
        $this->total_shipping_tax_incl = $params['total_shipping_tax_incl'];
        $this->current_state = $params['current_state'];
        $this->id_lang = $params['id_lang'];
        $this->date_add = $params['date_add'];
        $this->date_upd = $params['date_upd'];
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return int
     */
    public function getCurrentState()
    {
        return $this->current_state;
    }
}
