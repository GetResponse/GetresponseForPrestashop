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

use JsonSerializable;

class Address implements JsonSerializable
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
        $name,
        $country,
        $firstName,
        $lastName,
        $address1,
        $address2,
        $city,
        $zip,
        $province,
        $provinceCode,
        $phone,
        $company
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
     * @param array $params
     * @return self
     */
    public static function createFromArray($params)
    {
        return new self(
            $params['alias'],
            $params['country'],
            $params['firstname'],
            $params['lastname'],
            $params['address1'],
            $params['address2'],
            $params['city'],
            $params['postcode'],
            $params['state'],
            '',
            $params['phone'],
            $params['company']
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
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
