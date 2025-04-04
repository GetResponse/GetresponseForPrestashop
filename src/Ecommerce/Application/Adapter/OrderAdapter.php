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

use GetResponse\Contact\Application\Adapter\CustomerAdapter;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\Ecommerce\DomainModel\Line;
use GetResponse\Ecommerce\DomainModel\Order;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderAdapter
{
    public function getOrderById(int $orderId): Order
    {
        $customerAdapter = new CustomerAdapter();
        $prestashopOrder = new \Order($orderId);
        $customer = new \Customer($prestashopOrder->id_customer);
        $prestashopBaseUrl = \Tools::getHttpHost(true) . __PS_BASE_URI__;
        $orderUrl = $prestashopBaseUrl . '?controller=order-detail&id_order=' . $prestashopOrder->id;

        $currency = new \Currency($prestashopOrder->id_currency);

        $shippingAddress = null;
        $billingAddress = null;

        if ($prestashopOrder->id_address_delivery) {
            $address = new \Address($prestashopOrder->id_address_delivery);
            $country = new \Country($address->id_country);
            $state = new \State($address->id_state);

            $shippingAddress = new Address(
                $address->alias,
                $country->iso_code,
                $address->firstname,
                $address->lastname,
                $address->address1,
                $address->address2,
                $address->city,
                $address->postcode,
                $state->name,
                '',
                $address->phone,
                $address->company
            );
        }

        if ($prestashopOrder->id_address_invoice) {
            $address = new \Address($prestashopOrder->id_address_invoice);
            $country = new \Country($address->id_country);
            $state = new \State($address->id_state);

            $billingAddress = new Address(
                $address->alias,
                $country->iso_code,
                $address->firstname,
                $address->lastname,
                $address->address1,
                $address->address2,
                $address->city,
                $address->postcode,
                $state->name,
                '',
                $address->phone,
                $address->company
            );
        }

        return new Order(
            (int) $prestashopOrder->id,
            $prestashopOrder->reference,
            $prestashopOrder->id_cart,
            $customer->email,
            $customerAdapter->getCustomerById($prestashopOrder->id_customer),
            $this->getProducts($prestashopOrder),
            $orderUrl,
            $prestashopOrder->total_paid_tax_excl,
            $prestashopOrder->total_paid_tax_incl,
            $prestashopOrder->total_shipping_tax_incl,
            $currency->iso_code,
            $this->getOrderStatus($prestashopOrder),
            $shippingAddress,
            $billingAddress,
            $prestashopOrder->date_add,
            $prestashopOrder->date_upd
        );
    }

    /**
     * @param \Order $order
     *
     * @return array<int, Line>
     */
    private function getProducts(\Order $order): array
    {
        $lines = [];

        foreach ($order->getProducts() as $product) {
            if ((int) $product['product_attribute_id'] > 0) {
                $combination = new \Combination($product['product_attribute_id']);
                $variantId = $combination->id;
                $variantReference = $combination->reference;
            } else {
                $variantId = $product['product_id'];
                $variantReference = $product['reference'];
            }

            $lines[] = new Line(
                $product['product_id'],
                $variantId,
                $product['product_price'],
                $product['product_price_wt'],
                $product['product_quantity'],
                $variantReference
            );
        }

        return $lines;
    }

    /**
     * @param \Order $order
     *
     * @return string
     */
    private function getOrderStatus(\Order $order): string
    {
        $status = (new \OrderState($order->getCurrentState(), $order->id_lang))->name;
        if (is_array($status)) {
            $status = implode(', ', $status);
        }

        return empty($status) ? 'new' : $status;
    }
}
