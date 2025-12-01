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
class Customer extends ObjectModel
{
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
    /** @var string */
    public $note;
    /** @var int */
    public $id_gender = 0;
    /** @var int */
    public $id_default_group;

    /**
     * @param int $id
     */
    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
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
        $this->note = $params['note'];
        $this->id_gender = $params['id_gender'];
        $this->id_default_group = $params['id_default_group'];
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

    /**
     * Updates the current Customer in the database.
     *
     * @param bool $nullValues Whether we want to use NULL values instead of empty quotes values
     *
     * @return bool Indicates whether the Customer has been successfully updated
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function update($nullValues = false)
    {
    }
}
