<!-- Module Lof Slideshow  -->
{if isset($lofmodalcart)}
<div class="lof-moderslider clearfix">
	<div class="lof-kwicks-wrapper clearfix">
		<div id="lof-kwicks-{$mod_id}" class="moderslider-wrapper" style='width:{$lofmodalcart.modwidth}px; height:{$lofmodalcart.modheight}px'>
           {foreach from=$lofmodalcart_slides item=slide name=lof_slide}
				<div id="panel-{$smarty.foreach.lof_slide.index + 1}">
					<div class="ei-title">
						{if $lofmodalcart.show_title}
						<h2><a href="{$slide.link}" title="{$slide.title}">{$slide.title}</a></h2>
						{/if}
						<div class="sub-desc">
							{if $lofmodalcart.show_desc}
								{$slide.description}
							{/if}
							{if $lofmodalcart.show_viewnow}
								<p><a href="{$slide.link}" title="{$slide.title}">{l s='View Now' mod='lofmodalcart'}</a></p>
							{/if}
						</div>
						<div class="lof-price">
							{if $lofmodalcart.show_price}
								{l s='From' mod='lofmodalcart'}&nbsp{convertPrice price=$slide.price}
							{/if}
						</div>
					</div>
					<div class="lof-img">
						<a href="{$slide.link}" title="{$slide.title}"><img src="{$slide.mainimage}"/></a>
					</div>
				</div>
            {/foreach}
        </div> 
	</div>
</div>
{/if}
<!-- /Module Lof Slideshow  -->
