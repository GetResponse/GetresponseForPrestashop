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

use GetResponse\SharedKernel\CartRecoveryHelper;
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
        $currency = new \Currency((int) $prestashopCart->id_currency);
        $cartRecoveryUrl = CartRecoveryHelper::getUrl((int) $prestashopCart->id);

        $products = [];

        foreach ($prestashopCart->getProducts(true) as $product) {
            $products[] = new Product(
                (int) $product['id_product'],
                (float) $product['price_wt'],
                (string) $currency->iso_code,
                (int) $product['quantity']
            );
        }

        return new Cart(
            (int) $prestashopCart->id,
            (float) $prestashopCart->getOrderTotal(true),
            (string) $currency->iso_code,
            (string) $cartRecoveryUrl,
            $products
        );
    }
}
