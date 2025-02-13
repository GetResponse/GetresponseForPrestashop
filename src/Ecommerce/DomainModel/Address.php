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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Address implements \JsonSerializable
{
    /** @var string */
    private $name;
    /** @var string */
    private $country;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $address1;
    /** @var string|null */
    private $address2;
    /** @var string */
    private $city;
    /** @var string */
    private $zip;
    /** @var string|null */
    private $province;
    /** @var string|null */
    private $provinceCode;
    /** @var string|null */
    private $phone;
    /** @var string|null */
    private $company;

    public function __construct(
        string $name,
        string $country,
        string $firstName,
        string $lastName,
        string $address1,
        ?string $address2,
        string $city,
        string $zip,
        ?string $province,
        ?string $provinceCode,
        ?string $phone,
        ?string $company
    ) {
        $this->name = $name;
        $this->country = $country;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->zip = $zip;
        $this->province = $province;
        $this->provinceCode = $provinceCode;
        $this->phone = $phone;
        $this->company = $company;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return self
     */
    public static function createFromArray(array $params): self
    {
        return new self(
            isset($params['alias']) ? (string) $params['alias'] : '',
            isset($params['country']) ? (string) $params['country'] : '',
            isset($params['firstname']) ? (string) $params['firstname'] : '',
            isset($params['lastname']) ? (string) $params['lastname'] : '',
            isset($params['address1']) ? (string) $params['address1'] : '',
            isset($params['address2']) ? (string) $params['address2'] : null,
            isset($params['city']) ? (string) $params['city'] : '',
            isset($params['postcode']) ? (string) $params['postcode'] : '',
            isset($params['state']) ? (string) $params['state'] : null,
            '',
            isset($params['phone']) ? (string) $params['phone'] : null,
            isset($params['company']) ? (string) $params['company'] : null
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'country_code' => $this->country,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'zip' => $this->zip,
            'province' => $this->province,
            'province_code' => $this->provinceCode,
            'phone' => $this->phone,
            'company' => $this->company,
        ];
    }
}
