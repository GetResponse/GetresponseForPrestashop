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

class Cart implements \JsonSerializable
{
    /** @var int */
    private $id;
    /** @var Customer */
    private $customer;
    /** @var ?string */
    private $visitorUuid;
    /** @var Line[] */
    private $lines;
    /** @var float */
    private $totalPrice;
    /** @var float */
    private $totalTaxPrice;
    /** @var string */
    private $currency;
    /** @var string */
    private $url;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function __construct(
        $id,
        Customer $customer,
        $visitorUuid,
        $lines,
        $totalPrice,
        $totalTaxPrice,
        $currency,
        $url,
        $createdAt,
        $updatedAt
    ) {
        $this->id = $id;
        $this->customer = $customer;
        $this->visitorUuid = $visitorUuid;
        $this->lines = $lines;
        $this->totalPrice = $totalPrice;
        $this->totalTaxPrice = $totalTaxPrice;
        $this->currency = $currency;
        $this->url = $url;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getVisitorUuid()
    {
        return $this->visitorUuid;
    }

    /**
     * @return Line[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return float
     */
    public function getTotalTaxPrice()
    {
        return $this->totalTaxPrice;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $lines = [];
        foreach ($this->lines as $line) {
            $lines[] = $line->jsonSerialize();
        }

        return [
            'callback_type' => CallbackType::CHECKOUT_UPDATE,
            'id' => $this->id,
            'contact_email' => $this->customer->getEmail(),
            'customer' => $this->customer->jsonSerialize(),
            'visitor_uuid' => $this->visitorUuid,
            'lines' => $lines,
            'total_price' => $this->totalPrice,
            'total_price_tax' => $this->totalTaxPrice,
            'currency' => $this->currency,
            'url' => $this->url,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return bool
     */
    public function isValuable()
    {
        return $this->id !== 0 && ($this->customer->getEmail() !== null || $this->visitorUuid !== null);
    }
}
