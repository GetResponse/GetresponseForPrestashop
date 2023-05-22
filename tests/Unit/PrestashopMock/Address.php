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
class Address
{
    /** @var int */
    public $id;
    /** @var int */
    public $id_address_delivery;
    /** @var int */
    public $id_address_invoice;
    /** @var int */
    public $id_country;
    /** @var int */
    public $id_state;
    /** @var string */
    public $alias;
    /** @var string */
    public $firstname;
    /** @var string */
    public $lastname;
    /** @var string */
    public $address1;
    /** @var string */
    public $address2;
    /** @var string */
    public $city;
    /** @var string */
    public $postcode;
    /** @var string */
    public $phone;
    /** @var string */
    public $company;

    public function __construct($id)
    {
        $params = AddressParams::getAddressById($id);
        $this->id = $params['id'];
        $this->id_address_delivery = $params['id_address_delivery'];
        $this->id_address_invoice = $params['id_address_invoice'];
        $this->id_country = $params['id_country'];
        $this->id_state = $params['id_state'];
        $this->alias = $params['alias'];
        $this->firstname = $params['firstname'];
        $this->lastname = $params['lastname'];
        $this->address1 = $params['address1'];
        $this->address2 = $params['address2'];
        $this->city = $params['city'];
        $this->postcode = $params['postcode'];
        $this->phone = $params['phone'];
        $this->company = $params['company'];
    }
}
