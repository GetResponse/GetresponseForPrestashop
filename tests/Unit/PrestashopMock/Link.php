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
    /**
     * Create a link to a product.
     *
     * @param Product|array|int $product Product object (can be an ID product, but deprecated)
     * @param string|null $alias
     * @param string|null $category
     * @param string|null $ean13
     * @param int|null $idLang
     * @param int|null $idShop (since 1.5.0) ID shop need to be used when we generate a product link for a product in a cart
     * @param int|null $idProductAttribute ID product attribute
     * @param bool $force_routes
     * @param bool $relativeProtocol
     * @param bool $withIdInAnchor
     * @param array $extraParams
     * @param bool $addAnchor
     *
     * @return string
     *
     * @throws PrestaShopException
     */
    public function getProductLink(
        $product,
        $alias = null,
        $category = null,
        $ean13 = null,
        $idLang = null,
        $idShop = null,
        $idProductAttribute = null,
        $force_routes = false,
        $relativeProtocol = false,
        $withIdInAnchor = false,
        $extraParams = [],
        bool $addAnchor = true
    ) {
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
