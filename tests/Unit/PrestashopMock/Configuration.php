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
class Configuration extends ObjectModel
{
    private static $storage = [];

    public static function set($key, $value)
    {
        static::$storage[$key] = $value;
    }

    /**
     * Get a single configuration value (in one language only).
     *
     * @param string $key Key wanted
     * @param int $idLang Language ID
     *
     * @return string|false Value
     */
    public static function get($key, $idLang = null, $idShopGroup = null, $idShop = null, $default = false)
    {
        return isset(static::$storage[$key]) ? static::$storage[$key] : false;
    }

    /**
     * Delete a configuration key in database (with or without language management).
     *
     * @param string $key Key to delete
     *
     * @return bool Deletion result
     */
    public static function deleteByName($key)
    {
    }

    /**
     * Update configuration key and value into database (automatically insert if key does not exist).
     *
     * Values are inserted/updated directly using SQL, because using (Configuration) ObjectModel
     * may not insert values correctly (for example, HTML is escaped, when it should not be).
     *
     * @TODO Fix saving HTML values in Configuration model
     *
     * @param string $key Configuration key
     * @param mixed $values $values is an array if the configuration is multilingual, a single string else
     * @param bool $html Specify if html is authorized in value
     * @param int $idShopGroup
     * @param int $idShop
     *
     * @return bool Update result
     */
    public static function updateValue($key, $values, $html = false, $idShopGroup = null, $idShop = null)
    {
    }
}
