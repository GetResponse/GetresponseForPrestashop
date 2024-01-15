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

namespace GetResponse\TrackingCode\DomainModel;

use GetResponse\SharedKernel\SessionStorage;

class TrackingCodeBufferService
{
    const CART_HASH_COOKIE_NAME = 'gr4prestashop_cart_hash';
    const CART_COOKIE_NAME = 'gr4prestashop_cart';
    const ORDER_COOKIE_NAME = 'gr4prestashop_order';

    /** @var SessionStorage */
    private $sessionStorage;

    public function __construct($sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    public function addCartToBuffer(Cart $cart)
    {
        if ($this->sessionStorage->exists(self::CART_HASH_COOKIE_NAME)) {
            $lastCartHash = $this->sessionStorage->get(self::CART_HASH_COOKIE_NAME);

            if ($lastCartHash === $cart->getHash()) {
                return;
            }
        }

        $this->sessionStorage->set(self::CART_COOKIE_NAME, serialize($cart->toArray()));
        $this->sessionStorage->set(self::CART_HASH_COOKIE_NAME, $cart->getHash());
    }

    /**
     * @return Cart|null
     */
    public function getCartFromBuffer()
    {
        if (false === $this->sessionStorage->exists(self::CART_COOKIE_NAME)) {
            return null;
        }

        $cart = $this->sessionStorage->get(self::CART_COOKIE_NAME);

        if (null === $cart) {
            return null;
        }

        $this->sessionStorage->remove(self::CART_COOKIE_NAME);
        return Cart::createFromArray(unserialize($cart));
    }

    public function addOrderToBuffer(Order $order)
    {
        $this->sessionStorage->set(self::ORDER_COOKIE_NAME, serialize($order->toArray()));
    }

    /**
     * @return Order|null
     */
    public function getOrderFromBuffer()
    {
        if (false === $this->sessionStorage->exists(self::ORDER_COOKIE_NAME)) {
            return null;
        }

        $order = $this->sessionStorage->get(self::ORDER_COOKIE_NAME);

        if (null === $order) {
            return null;
        }

        $this->sessionStorage->remove(self::ORDER_COOKIE_NAME);
        return Order::createFromArray(unserialize($order));
    }
}
