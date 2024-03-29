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

{if isset($web_connect)}
    {include file='modules/grprestashop/views/templates/front/_partials/web_connect.tpl'}
{/if}

<!-- getresponse start -->
<script type="text/javascript">

    {if $facebook_pixel_snippet}
        {$facebook_pixel_snippet|cleanHtml nofilter}
    {/if}

    {if $facebook_ads_pixel_snippet}
        {$facebook_ads_pixel_snippet|cleanHtml nofilter}
    {/if}

    {if $facebook_business_extension_snippet}
        {$facebook_business_extension_snippet|cleanHtml nofilter}
    {/if}

    {if $getresponse_chat_snippet}
        {$getresponse_chat_snippet|cleanHtml nofilter}
    {/if}

    {if isset($getresponse_recommendation_object)}
        const recommendationPayload = {$getresponse_recommendation_object|cleanHtml nofilter}
    {/if}

</script>

{if isset($getresponse_recommendation_snippet)}
    <script src="{$getresponse_recommendation_snippet|cleanHtml nofilter}" async></script>
{/if}
<!-- getresponse end -->
