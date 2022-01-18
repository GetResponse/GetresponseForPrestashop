<?php
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author     Getresponse <grintegrations@getresponse.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
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
