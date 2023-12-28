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

use Context;

class TrackingCodeBufferService
{
    const CART_HASH_COOKIE_NAME = 'gr4prestashop_cart_hash';
    const CART_COOKIE_NAME = 'gr4prestashop_cart';
    const ORDER_COOKIE_NAME = 'gr4prestashop_order';

    public function addCartToBuffer(Cart $cart)
    {
        $context = Context::getContext();

        if ($context->cookie->__isset(self::CART_HASH_COOKIE_NAME)) {
            $lastCartHash = $context->cookie->__get(self::CART_HASH_COOKIE_NAME);

            if ($lastCartHash === $cart->getHash()) {
                return;
            }
        }

        $context->cookie->__set(self::CART_COOKIE_NAME, serialize($cart->toArray()));
        $context->cookie->__set(self::CART_HASH_COOKIE_NAME, $cart->getHash());
    }

    public function getCartFromBuffer()
    {
        $context = Context::getContext();

        if (false === $context->cookie->__isset(self::CART_COOKIE_NAME)) {
            return null;
        }

        $cart = $context->cookie->__get(self::CART_COOKIE_NAME);
        $context->cookie->__unset(self::CART_COOKIE_NAME);

        return (array) unserialize($cart);
    }

    public function addOrderToBuffer(Order $order)
    {
        $context = Context::getContext();
        $context->cookie->__set(self::ORDER_COOKIE_NAME, serialize($order->toArray()));
    }

    public function getOrderFromBuffer()
    {
        $context = Context::getContext();

        if (false === $context->cookie->__isset(self::ORDER_COOKIE_NAME)) {
            return null;
        }

        $order = $context->cookie->__get(self::ORDER_COOKIE_NAME);
        $context->cookie->__unset(self::ORDER_COOKIE_NAME);

        return (array) unserialize($order);
    }
}
