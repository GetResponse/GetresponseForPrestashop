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

use GetResponse\TrackingCode\DomainModel\Order;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderPresenter extends EcommercePresenter
{
    /** @var Order */
    private $order;

    /**
     * @param Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * @return array
     */
    public function present()
    {
        $products = [];

        foreach ($this->order->getProducts() as $product) {
            $products[] = [
                'product' => $this->getProduct($product),
                'quantity' => (int) $product->getQuantity(),
                'categories' => $this->getProductCategories($product->getId()),
            ];
        }

        return [
            'price' => (float) $this->order->getPrice(),
            'cartId' => (string) $this->order->getCartId(),
            'orderId' => (string) $this->order->getId(),
            'currency' => $this->order->getCurrency(),
            'products' => $products,
        ];
    }
}
