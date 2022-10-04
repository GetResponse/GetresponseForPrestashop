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

namespace GetResponse\Ecommerce\Application\Adapter;

use Cart as PrestashopCart;
use Combination;
use Context;
use Currency;
use GetResponse\Contact\Application\Adapter\CustomerAdapter;
use GetResponse\Ecommerce\DomainModel\Cart;
use GetResponse\Ecommerce\DomainModel\Line;

class CartAdapter
{
    /**
     * @return Cart
     *
     * @param $cartId
     */
    public function getCartById($cartId)
    {
        $prestashopCart = new PrestashopCart($cartId);
        $customerAdapter = new CustomerAdapter();
        $customer = $customerAdapter->getCustomerById($prestashopCart->id_customer);

        $currency = new Currency($prestashopCart->id_currency);
        $lines = array();

        foreach ($prestashopCart->getProducts(true) as $product) {
            if ((int) $product['id_product_attribute'] > 0) {
                $combination = new Combination($product['id_product_attribute']);
                $variantId = $combination->id;
                $variantReference = $combination->reference;
            } else {
                $variantId = $product['id_product'];
                $variantReference = $product['reference'];
            }

            $lines[] = new Line(
                $variantId,
                $product['price'],
                $product['price_wt'],
                $product['quantity'],
                $variantReference
            );
        }

        $shopCartUrl = version_compare(_PS_VERSION_, '1.7', '>=')
            ? Context::getContext()->link->getPageLink('cart', null, null, array('action' => 'show'))
            : Context::getContext()->link->getPageLink('order');

        return new Cart(
            $prestashopCart->id,
            $customer,
            $lines,
            $prestashopCart->getOrderTotal(false),
            $prestashopCart->getOrderTotal(true),
            $currency->iso_code,
            $shopCartUrl,
            $prestashopCart->date_add,
            $prestashopCart->date_upd
        );
    }
}
