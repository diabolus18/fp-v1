<!-- MODULE Block specials -->
<div class="block products_block exclusive blockspecials clearfix">
	<h4><a href="{$link->getPageLink('prices-drop.php')}" title="{l s='Specials' mod='csspecials'}">{l s='Specials' mod='csspecials'}</a></h4>
	<div class="block_content list_pecials responsive">
	{if $myspecial}
		{$i=0}
		<ul class="products" id="list_pecial">
			{foreach from=$myspecial item=product name=myspecial}
			{$i=$i+1}
			{if $i%3==1}
			<li class="product_image {if $smarty.foreach.myspecial.first}first_item{elseif $smarty.foreach.myspecial.last}last_item{else}item{/if} clearfix">
			{/if}
				{if $i%3==1}
					<div class="prod_item">
						<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'medium_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
						<h3><a href="{$product.link}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:25:'...'|escape:'htmlall':'UTF-8'}</a></h3>
						<p class="category_name">{$product.category|escape:'htmlall':'UTF-8'}</p>
						<div class="products_list_price">
							
							{if !$PS_CATALOG_MODE}
								{if $product.specific_prices}
									{assign var='specific_prices' value=$product.specific_prices}
									{if $specific_prices.reduction_type == 'percentage' && ($specific_prices.from == $specific_prices.to OR ($smarty.now|date_format:'%Y-%m-%d %H:%M:%S' <= $specific_prices.to && $smarty.now|date_format:'%Y-%m-%d %H:%M:%S' >= $specific_prices.from))}
										<span class="reduction"><span>-{$specific_prices.reduction*100|floatval}%</span></span>
									{/if}
								{/if}
							{/if}
							{if isset($product.price_without_reduction) || isset($priceWithoutReduction_tax_excl)}
								<span class="price-discount">{if !$priceDisplay}{displayWtPrice p=$product.price_without_reduction}{else}{displayWtPrice p=$priceWithoutReduction_tax_excl}{/if}</span>
							{/if}
							
							<span class="price">{if !$priceDisplay}{displayWtPrice p=$product.price}{else}{displayWtPrice p=$product.price_tax_exc}{/if}</span>
						</div>
					</div>
				{/if}
				{if $i%3==2}
					<div class="prod_item">
						<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'medium_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
						<h3><a href="{$product.link}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:25:'...'|escape:'htmlall':'UTF-8'}</a></h3>
						<p class="category_name">{$product.category|escape:'htmlall':'UTF-8'}</p>
						<div class="products_list_price">
							<span class="price-discount">{if !$priceDisplay}{displayWtPrice p=$product.price_without_reduction}{else}{displayWtPrice p=$priceWithoutReduction_tax_excl}{/if}</span>
							<span class="price">{if !$priceDisplay}{displayWtPrice p=$product.price}{else}{displayWtPrice p=$product.price_tax_exc}{/if}</span>
						</div>
					</div>
				{/if}
				{if $i%3==0}
					<div class="prod_item">
						<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'medium_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
						<h3><a href="{$product.link}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:25:'...'|escape:'htmlall':'UTF-8'}</a></h3>
						<p class="category_name">{$product.category|escape:'htmlall':'UTF-8'}</p>
						<div class="products_list_price">
							<span class="price-discount">{if !$priceDisplay}{displayWtPrice p=$product.price_without_reduction}{else}{displayWtPrice p=$priceWithoutReduction_tax_excl}{/if}</span>
							<span class="price">{if !$priceDisplay}{displayWtPrice p=$product.price}{else}{displayWtPrice p=$product.price_tax_exc}{/if}</span>
						</div>
					</div>
				{/if}
			{if $i%3==0 || $i==count($myspecial)}
			</li>
			{/if}
			{/foreach}
		</ul>
			<a id="prev_cs_spec" class="prev btn" href="javascript:void(0)">&lt;</a>
			<a id="next_cs_spec" class="next btn" href="javascript:void(0)">&gt;</a>
	{else}
		<p>{l s='No specials at this time' mod='csspecials'}</p>
	{/if}
	</div>
</div>
<script type="text/javascript">
	$(window).load(function(){
		$("#list_pecial").carouFredSel({
			auto: false,
			responsive: true,
				width: '100%',
				height : 'variable',
				prev: '#prev_cs_spec',
				next: '#next_cs_spec',
				swipe: {
					onTouch : true
				},
				items: {
					width: 200,
					height: 'variable',
					visible: {
						min: 1,
						max: 1
					}
				},
				scroll: {
					direction : 'left',    //  The direction of the transition.
					duration  : 400   //  The duration of the transition.
				}

		});
	});
</script>
<!-- /MODULE Block specials -->