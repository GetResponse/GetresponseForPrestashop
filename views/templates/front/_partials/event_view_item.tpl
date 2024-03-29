{**
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
 *}

GrTracking('importScript', 'ec');
GrTracking(
    'viewItem',
    {
        "shop": {
            "id": "{$shop_id|cleanHtml nofilter}"
        },
        "product": {
            "id": "{$product.id|cleanHtml nofilter}",
            "name": "{$product.name|cleanHtml nofilter}",
            "sku": "{if $product.reference}{$product.reference|cleanHtml nofilter}{else}{$product.id|cleanHtml nofilter}{/if}",
            "vendor": {if $product_manufacturer->name}"{$product_manufacturer->name|escape:'html':'UTF-8'}"{else}null{/if},
            "price": "{$product.price_without_reduction_without_tax|cleanHtml nofilter}",
            "currency": "{$currency.iso_code|cleanHtml nofilter}"
        },
        "categories": [
            {
                "id": "{$product.id_category_default|cleanHtml nofilter}",
                "name": "{$product.category_name|escape:'html':'UTF-8'}"
            }
        ]
    }
);