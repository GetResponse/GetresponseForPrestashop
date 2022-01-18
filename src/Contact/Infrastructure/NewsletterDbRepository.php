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
namespace GetResponse\Contact\Infrastructure;

use Customer;
use Db;
use GetResponse\Contact\DomainModel\NewsletterRepository;

class NewsletterDbRepository implements NewsletterRepository
{
    public function removeSubscriberFromNewsletter($shopId, $email)
    {
        $sql = 'UPDATE `'._DB_PREFIX_.'newsletter` SET `active` = 0 WHERE `id_shop` = '.$shopId.' AND `email` = \''.$email.'\'';
        Db::getInstance()->execute($sql);
    }

    public function removeCustomerFromNewsletter($shopId, $email)
    {
        $customers = Customer::getCustomersByEmail($email);

        foreach ($customers as $row) {
            if ($shopId === (int) $row['id_shop']) {
                $customer = new Customer($row['id_customer']);
                $customer->newsletter = (int)!$customer->newsletter;
                $customer->update();
            }
        }
    }
}
