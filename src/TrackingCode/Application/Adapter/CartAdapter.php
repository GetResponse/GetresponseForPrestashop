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

namespace GetResponse\TrackingCode\Application\Adapter;

use GetResponse\TrackingCode\DomainModel\Cart;
use GetResponse\TrackingCode\DomainModel\Product;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartAdapter
{
    /**
     * @param int $cartId
     *
     * @return Cart
     *
     * @throws \Exception
     */
    public function getCartById(int $cartId): Cart
    {
        $prestashopCart = new \Cart($cartId);
        $currency = new \Currency($prestashopCart->id_currency);
        $shopCartUrl = \Context::getContext()->link->getPageLink('cart', null, null, ['action' => 'show']);

        $products = [];

        foreach ($prestashopCart->getProducts(true) as $product) {
            $products[] = new Product(
                $product['id_product'],
                $product['price_wt'],
                $currency->iso_code,
                $product['quantity']
            );
        }

        return new Cart(
            $prestashopCart->id,
            $prestashopCart->getOrderTotal(true),
            $currency->iso_code,
            $shopCartUrl,
            $products
        );
    }
}
