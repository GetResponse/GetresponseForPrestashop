
<!-- getresponse start -->
<script type="text/javascript">

    {if isset($web_connect)}
        {include file='modules/grprestashop//views/templates/front/_partials/web_connect.tpl'}
    {/if}

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


</script>
<!-- getresponse end -->
