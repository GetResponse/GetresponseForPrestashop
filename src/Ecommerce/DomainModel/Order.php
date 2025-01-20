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

namespace GetResponse\Ecommerce\DomainModel;

use GetResponse\Contact\DomainModel\Customer;
use GetResponse\SharedKernel\CallbackType;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Order implements \JsonSerializable
{
    /** @var int */
    private $id;
    /** @var string */
    private $orderNumber;
    /** @var int */
    private $cartId;
    /** @var string */
    private $contactEmail;
    /** @var Customer */
    private $customer;
    /** @var Line[] */
    private $lines;
    /** @var string|null */
    private $url;
    /** @var float */
    private $totalPrice;
    /** @var float */
    private $totalPriceTax;
    /** @var float */
    private $shippingPrice;
    /** @var string */
    private $currency;
    /** @var string */
    private $status;
    /** @var Address|null */
    private $shippingAddress;
    /** @var Address|null */
    private $billingAddress;
    /** @var string */
    private $createdAt;
    /** @var string|null */
    private $updatedAt;

    /**
     * @param Line[] $lines
     */
    public function __construct(
        int $id,
        string $orderNumber,
        int $cartId,
        string $contactEmail,
        Customer $customer,
        array $lines,
        ?string $url,
        float $totalPrice,
        ?float $totalPriceTax,
        float $shippingPrice,
        string $currency,
        string $status,
        ?Address $shippingAddress,
        ?Address $billingAddress,
        string $createdAt,
        ?string $updatedAt
    ) {
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->cartId = $cartId;
        $this->contactEmail = $contactEmail;
        $this->customer = $customer;
        $this->lines = $lines;
        $this->url = $url;
        $this->totalPrice = $totalPrice;
        $this->totalPriceTax = $totalPriceTax;
        $this->shippingPrice = $shippingPrice;
        $this->currency = $currency;
        $this->status = $status;
        $this->shippingAddress = $shippingAddress;
        $this->billingAddress = $billingAddress;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $lines = [];
        foreach ($this->lines as $line) {
            $lines[] = $line->jsonSerialize();
        }

        return [
            'callback_type' => CallbackType::ORDER_UPDATE,
            'id' => $this->id,
            'order_number' => $this->orderNumber,
            'cart_id' => $this->cartId,
            'contact_email' => $this->contactEmail,
            'customer' => $this->customer->jsonSerialize(),
            'lines' => $lines,
            'url' => $this->url,
            'total_price' => $this->totalPrice,
            'total_price_tax' => $this->totalPriceTax,
            'shipping_price' => $this->shippingPrice,
            'currency' => $this->currency,
            'status' => $this->status,
            'billing_status' => $this->status,
            'shipping_address' => null !== $this->shippingAddress ? $this->shippingAddress->jsonSerialize() : [],
            'billing_address' => null !== $this->billingAddress ? $this->billingAddress->jsonSerialize() : [],
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
