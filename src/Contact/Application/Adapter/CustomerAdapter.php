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

namespace GetResponse\Contact\Application\Adapter;

use Customer as PrestashopCustomer;
use GetResponse\Contact\DomainModel\Customer;
use GetResponse\Ecommerce\DomainModel\Address;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomerAdapter
{
    /**
     * @param int $customerId
     *
     * @return Customer
     */
    public function getCustomerById(int $customerId): Customer
    {
        $customer = new PrestashopCustomer($customerId);

        $address = null;
        $addresses = $customer->getAddresses($customer->id_lang);
        if (!empty($addresses)) {
            $address = Address::createFromArray(reset($addresses));
        }

        return new Customer(
            (int) $customer->id,
            (string) $customer->firstname,
            (string) $customer->lastname,
            (string) $customer->email,
            $address,
            (bool) $customer->newsletter,
            ['birthday' => (string) $customer->birthday]
        );
    }
}
