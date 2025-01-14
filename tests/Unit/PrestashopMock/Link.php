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
class Link
{
    public function getProductLink($product)
    {
        return __PS_BASE_URI__ . 'product/' . $product->id;
    }

    public function getImageLink($name, $ids, $type = null)
    {
        return 'my-prestashop.com/product/1/images/default.jpg';
    }

    public function getPageLink($controllerName, $ssl = null, $id_lang = null, $request = null)
    {
        return 'https://my-prestashop.com/pl/koszyk?action=show';
    }

    public function getModuleLink($module, $controllerName, $params, $ssl = null, $id_lang = null, $idShop = null, $relativeProtocol = false)
    {
        return 'https://prestashop.com/en/module/grprestashop/CartRecovery?cart_id=123&cart_token=54321';
    }
}
