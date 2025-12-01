<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
class Cookie
{
    /**
     * Magic method wich return cookie data from _content array.
     *
     * @param string $key key wanted
     *
     * @return string value corresponding to the key
     */
    public function __get($key)
    {
    }

    /**
     * Magic method which check if key exists in the cookie.
     *
     * @param string $key key wanted
     *
     * @return bool key existence
     */
    public function __isset($key)
    {
    }

    /**
     * Magic method which adds data into _content array.
     *
     * @param string $key Access key for the value
     * @param mixed $value Value corresponding to the key
     *
     * @throws Exception
     */
    public function __set($key, $value)
    {
    }

    /**
     * Magic method which delete data into _content array.
     *
     * @param string $key key wanted
     */
    public function __unset($key)
    {
    }
}
