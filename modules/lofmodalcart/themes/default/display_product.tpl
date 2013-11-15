<div id="show-above">
  {$displayAbove}
</div>
<div id="show-product">
  {if $modalConfigs.summary_type == 2}
    <table width="100%" align="center">
      <tr>
        <td colspan="6" style="color:{$modalConfigs.title_color};font-size: {$modalConfigs.title_size}px">{l s='Shopping cart summary' mod='lofmodalcart'}</td>
      </tr>

      <tr>
        <td>{l s='Product Image' mod='lofmodalcart'}</td>
        <td>{l s='Product Name' mod='lofmodalcart'}</td>
        <td>{l s='Attributes' mod='lofmodalcart'}</td>
        <td>{l s='Price' mod='lofmodalcart'}</td>
        <td>{l s='Quantity' mod='lofmodalcart'}</td>
        <td>{l s='Total' mod='lofmodalcart'}</td>
      </tr>
        {foreach from=$productModal key=pro item=product}
          <tr>
            <td><a href="{$product.link}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, "{$modalConfigs.image_size}")}"/></a></td>

            <td><h4>{$product.name|escape:'htmlall':'UTF-8'}</h4></td>

            <td>{if $modalConfigs.show_attribute == 1}
                  {if isset($product.attributes)}
                    {$product.attributes|escape:'htmlall':'UTF-8'}
                  {else}<p>{l s='No attribute!' mod='lofmodalcart'}</p>{/if}
                {/if}
            </td>

            <td>{$product.price}</td>

            <td>{$product.cart_quantity|escape:'htmlall':'UTF-8'}</td>

            <td>{$product.total}</td>
          </tr>
        {/foreach}
    </table>

  {else}
    <table width="100%" align="center">
      <tr>
        <td colspan="6" style="color:{$modalConfigs.title_color};font-size: {$modalConfigs.title_size}px">{l s='The lastest product is added' mod='lofmodalcart'}</td>
      </tr>

      <tr>
        <td>{l s='Product Image' mod='lofmodalcart'}</td>
        <td>{l s='Product Name' mod='lofmodalcart'}</td>
        <td>{l s='Attributes' mod='lofmodalcart'}</td>
        <td>{l s='Price' mod='lofmodalcart'}</td>
        <td>{l s='Quantity' mod='lofmodalcart'}</td>
        <td>{l s='Total' mod='lofmodalcart'}</td>
      </tr>

      <tr>
        <td><a href="{$lastProductModal.link}"><img src="{$link->getImageLink($lastProductModal.link_rewrite, $lastProductModal.id_image, "{$modalConfigs.image_size}")}"/></a></td>

        <td><h4>{$lastProductModal.name|escape:'htmlall':'UTF-8'}</h4></td>

        <td>{if $modalConfigs.show_attribute == 1}
            {if isset($lastProductModal.attributes)}
              {$lastProductModal.attributes|escape:'htmlall':'UTF-8'}
            {else}<p>No attribute!</p>{/if}
          {/if}
        </td>

        <td>{$lastProductModal.price}</td>

        <td>{$lastProductModal.cart_quantity|escape:'htmlall':'UTF-8'}</td>

        <td>{$lastProductModal.total}</td>
      </tr>

    </table>
  {/if}
</div>

<div class="other">
  {if $modalConfigs.summary_type == 2}<p>{l s='Money need to pay :' mod='lofmodalcart'}<b>{$totalToPay}</b></p>{/if}
  {if $modalConfigs.summary_type == 2}<p>{l s='Shipping :' mod='lofmodalcart'}<b>{$shippingCost}</b></p>{/if}
  {if isset($modalConfigs.show_button) && $modalConfigs.show_button > 0}
    {if $modalConfigs.show_button == 1}
      <p><a href="javascript:continueShopping();" class="button_large nyroModalClose">{l s='Continue shopping' mod='lofmodalcart'}</a></p>
      <p><a href="{$link->getPageLink("$order_process", true)}" id="button_order_cart" class="exclusive{if $order_process == 'order-opc'}_large{/if}" title="{l s='Order now' mod='lofmodalcart'}" rel="nofollow"><span></span>{l s='Order now' mod='lofmodalcart'}</a></p>
    {elseif $modalConfigs.show_button == 2}
      <p><a href="{$link->getPageLink("$order_process", true)}" id="button_order_cart" class="exclusive{if $order_process == 'order-opc'}_large{/if}" title="{l s='Order now' mod='lofmodalcart'}" rel="nofollow"><span></span>{l s='Order now' mod='lofmodalcart'}</a></p>
    {elseif $modalConfigs.show_button == 3}
      <p><a href="javascript:continueShopping();" class="button_large nyroModalClose">{l s='Continue shopping' mod='lofmodalcart'}</a></p>
    {elseif $modalConfigs.show_button == 4}
      <p>No button to click!</p>
    {/if}
  {/if}
</div>
<div id="show-bellow">
  {$displayBellow}
</div>

