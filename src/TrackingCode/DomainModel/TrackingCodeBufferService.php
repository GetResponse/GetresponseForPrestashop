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

use GetResponse\SharedKernel\Session\Storage;

if (!defined('_PS_VERSION_')) {
    exit;
}

class TrackingCodeBufferService
{
    const CART_HASH_COOKIE_NAME = 'gr4prestashop_cart_hash';
    const CART_COOKIE_NAME = 'gr4prestashop_cart';
    const ORDER_COOKIE_NAME = 'gr4prestashop_order';

    /** @var Storage */
    private $sessionStorage;

    public function __construct(Storage $sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    /**
     * @param Cart $cart
     *
     * @return void
     */
    public function addCartToBuffer(Cart $cart): void
    {
        if ($this->sessionStorage->exists(self::CART_HASH_COOKIE_NAME)) {
            $lastCartHash = $this->sessionStorage->get(self::CART_HASH_COOKIE_NAME);

            if ($lastCartHash === $cart->getHash()) {
                return;
            }
        }

        $this->sessionStorage->set(self::CART_COOKIE_NAME, json_encode($cart->toArray()));
        $this->sessionStorage->set(self::CART_HASH_COOKIE_NAME, $cart->getHash());
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function addOrderToBuffer(Order $order): void
    {
        $this->sessionStorage->set(self::ORDER_COOKIE_NAME, json_encode($order->toArray()));
    }

    /**
     * @return ?Order
     */
    public function getOrderFromBuffer(): ?Order
    {
        if ($this->sessionStorage->exists(self::ORDER_COOKIE_NAME)) {
            $json = $this->sessionStorage->get(self::ORDER_COOKIE_NAME);
            if (is_string($json)) {
                /** @var array{id: int, cart_id: int, price: float, currency: string, products: array<int, array<string, int|float|string>>}|false $data */
                $data = json_decode($json, true);
                if (is_array($data)) {
                    return Order::createFromArray($data);
                }
            }
        }

        return null;
    }

    /**
     * @return ?Cart
     */
    public function getCartFromBuffer(): ?Cart
    {
        if ($this->sessionStorage->exists(self::CART_COOKIE_NAME)) {
            $json = $this->sessionStorage->get(self::CART_COOKIE_NAME);
            if (is_string($json)) {
                /** @var array{id: int, price: float, currency: string, url: string, products: array<int, array<string, int|float|string>>}|false $data */
                $data = json_decode($json, true);
                if (is_array($data)) {
                    return Cart::createFromArray($data);
                }
            }
        }

        return null;
    }
}
