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

namespace GetResponse\TrackingCode\Presenter;

use GetResponse\TrackingCode\DomainModel\Cart;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartPresenter extends EcommercePresenter
{
    /** @var Cart */
    private $cart;

    /**
     * @param Cart $cart
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return array<string, mixed>
     */
    public function present()
    {
        $products = [];

        foreach ($this->cart->getProducts() as $product) {
            $products[] = [
                'product' => $this->getProduct($product),
                'quantity' => $product->getQuantity(),
                'categories' => $this->getProductCategories($product->getId()),
            ];
        }

        return [
            'price' => $this->cart->getPrice(),
            'cartId' => (string) $this->cart->getId(),
            'currency' => $this->cart->getCurrency(),
            'cartUrl' => $this->cart->getUrl(),
            'products' => $products,
        ];
    }
}
