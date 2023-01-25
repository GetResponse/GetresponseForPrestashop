<script type="text/javascript">

    GrTracking('importScript', 'ec');
    GrTracking(
        'viewItems',
        {
            "shop_id": "{$shop_id}",
            "product": {
                "id": "{$product.id}",
                "name": "{$product.name}",
                "sku": "{if $product.reference}{$product.reference}{else}{$product.id}{/if}",
                "vendor": {if $product_manufacturer->name}"{$product_manufacturer->name|escape:'html':'UTF-8'}"{else}null{/if},
                "price": "{$product.price_without_reduction_without_tax}",
                "currency": "{$currency.iso_code}"
            },
            "categories": []
        }
    );

</script>