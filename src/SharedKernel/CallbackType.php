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

namespace GetResponse\SharedKernel;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CallbackType
{
    const CHECKOUT_CREATE = 'checkouts/create';
    const CHECKOUT_UPDATE = 'checkouts/update';
    const CUSTOMER_CREATE = 'customers/create';
    const CUSTOMER_UPDATE = 'customers/update';
    const ORDER_CREATE = 'orders/create';
    const ORDER_UPDATE = 'orders/update';
    const PRODUCT_CREATE = 'products/create';
    const PRODUCT_UPDATE = 'products/update';
    const SUBSCRIBERS_CREATE = 'subscribers/create';
    const SUBSCRIBERS_UPDATE = 'subscribers/update';
}
