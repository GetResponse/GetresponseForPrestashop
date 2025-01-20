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

namespace GetResponse\Contact\DomainModel;

use GetResponse\Ecommerce\DomainModel\Address;
use GetResponse\SharedKernel\CallbackType;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Customer implements \JsonSerializable
{
    /** @var int */
    private $id;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $email;
    /** @var Address|null */
    private $address;
    /** @var bool */
    private $marketingConsent;
    /** @var array<string, mixed> */
    private $customFields;

    /**
     * @param array<string, mixed> $customFields
     */
    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        ?Address $address,
        bool $marketingConsent,
        array $customFields
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->address = $address;
        $this->marketingConsent = $marketingConsent;
        $this->customFields = $customFields;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return bool
     */
    public function getMarketingConsent(): bool
    {
        return $this->marketingConsent;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'callback_type' => CallbackType::CUSTOMER_UPDATE,
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'accepts_marketing' => (bool) $this->marketingConsent,
            'address' => null !== $this->address ? $this->address->jsonSerialize() : [],
            'tags' => [],
            'customFields' => $this->customFields,
        ];
    }
}
