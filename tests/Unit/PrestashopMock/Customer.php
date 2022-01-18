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
class Customer
{
    /** @var int */
    public $id;
    /** @var int */
    public $id_shop;
    /** @var int */
    public $id_lang;
    /** @var string */
    public $firstname;
    /** @var string */
    public $lastname;
    /** @var string */
    public $email;
    /** @var bool */
    public $newsletter;
    /** @var array */
    public $addresses;
    /** @var string */
    public $birthday;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $params = CustomerParams::getCustomerById($id);
        $this->id = $params['id'];
        $this->id_lang = $params['id_lang'];
        $this->id_shop = $params['id_shop'];
        $this->firstname = $params['firstname'];
        $this->lastname = $params['lastname'];
        $this->email = $params['email'];
        $this->newsletter = $params['newsletter'];
        $this->addresses = $params['addresses'];
        $this->birthday = $params['birthday'];
    }

    public function getAddresses($id_lang = null)
    {
        return $this->addresses;
    }

    public static function getCustomersByEmail($email)
    {
        $customer = new self(1);
        return [$customer];
    }
}
