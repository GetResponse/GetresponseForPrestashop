{$web_connect|cleanHtml nofilter}

{if $user_email}
    GrTracking('setUserId', '{$user_email|escape:'htmlall':'UTF-8'}');
{/if}

{if isset($include_view_item)}
    {include file='modules/grprestashop//views/templates/front/_partials/event_view_item.tpl'}
{/if}

{if isset($include_view_category)}
    {include file='modules/grprestashop//views/templates/front/_partials/event_view_category.tpl'}
{/if}