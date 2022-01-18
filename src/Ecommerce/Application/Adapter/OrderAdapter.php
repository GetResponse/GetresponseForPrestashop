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

use Combination;
use Country;
use Currency;
use Customer as PrestashopCustomer;
use GetResponse\Contact\Application\Adapter\CustomerAdapter;
use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\Ecommerce\DomainModel\Line;
use GetResponse\Ecommerce\DomainModel\Order;
use Order as PrestashopOrder;
use OrderState;
use State;
use Tools;

class OrderAdapter
{
    public function getOrderById($orderId)
    {
        $customerAdapter = new CustomerAdapter();
        $prestashopOrder = new PrestashopOrder($orderId);
        $customer = new PrestashopCustomer($prestashopOrder->id_customer);
        $orderUrl = Tools::getHttpHost(true) . __PS_BASE_URI__ . '?controller=order-detail&id_order=' . $prestashopOrder->id;

        $currency = new Currency($prestashopOrder->id_currency);

        $shippingAddress = null;
        $billingAddress = null;

        if ($prestashopOrder->id_address_delivery) {
            $address = new \Address($prestashopOrder->id_address_delivery);
            $country = new Country($address->id_country);
            $state = new State($address->id_state);

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
            $country = new Country($address->id_country);
            $state = new State($address->id_state);

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
            $prestashopOrder->id,
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

    private function getProducts(PrestashopOrder $order)
    {
        $lines = [];

        foreach ($order->getProducts() as $product) {

            if ((int) $product['product_attribute_id'] > 0) {
                $combination = new Combination($product['product_attribute_id']);
                $variantId = $combination->id;
                $variantReference = $combination->reference;
            } else {
                $variantId = $product['product_id'];
                $variantReference = $product['reference'];
            }

            $lines[] = new Line(
                $variantId,
                $product['product_price'],
                $product['product_price_wt'],
                $product['product_quantity'],
                $variantReference
            );
        }

        return $lines;
    }

    private function getOrderStatus(PrestashopOrder $order)
    {
        $status = (new OrderState($order->getCurrentState(), $order->id_lang))->name;

        return empty($status) ? 'new' : $status;
    }
}
