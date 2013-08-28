<!-- CS Home Tab module -->
<div class="home_top_tab">
{if count($tabs) > 0}
<div id="tabs">
	{if $option->js_tab == "true"}
	<ul id="ul_cs_tab">
		{foreach from=$tabs item=tab name=tabs}
			<li class="{if $smarty.foreach.tabs.last}last{/if} refreshCarousel">
				<a href="#tabs-{$smarty.foreach.tabs.iteration}" {if $option->scrollPanel == "true"} onclick="return updateCarousel({$smarty.foreach.tabs.iteration});" {else}onclick="return updateNotCarousel({$smarty.foreach.tabs.iteration});"{/if}>{$tab->title[(int)$cookie->id_lang]}</a>
			</li>
		{/foreach}
	</ul>
	{/if}
	{foreach from=$tabs item=tab name=tabs}
		{if $option->js_tab == "false"}
			<div class="title_tab">{$tab->title[(int)$cookie->id_lang]}</div>
		{/if}
		<div class="title_tab_hide_show" style="display:none">
			{$tab->title[(int)$cookie->id_lang]}
			<input type='hidden' value='{$smarty.foreach.tabs.iteration}' />
		</div>
	<div class="tabs-carousel" id="tabs-{$smarty.foreach.tabs.iteration}">
		<div class="cycleElementsContainer" id="cycle-{$smarty.foreach.tabs.iteration}">
			
			<div id="elements-{$smarty.foreach.tabs.iteration}">
				{if count($tab->product_list)>0}
				<div class="list_carousel responsive">
					<div class="view_more_link"><a href="{$tab->view_more}"><span>{l s="View more" mod='cshometab'}</span></a></div>
					<ul id="carousel{$smarty.foreach.tabs.iteration}" class="product-list">
					{foreach from=$tab->product_list item=product name=product_list}
						<li class="ajax_block_product {if $smarty.foreach.product_list.first}first_item{elseif $smarty.foreach.product_list.last}last_item{/if}{if $smarty.foreach.product_list.iteration%$option->show == 0} last_item_of_line{/if}">
						<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'p_menu_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
						
						<h3><a href="{$product.link}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}</a></h3>
						<p class="category_name">{$product.category|escape:'htmlall':'UTF-8'}</p>
						
						<!-- MISE EN COMMENTAIRE AFFICHAGE ETOILES EVALUATION
						<div class="star_content clearfix">
							{section name="i" start=0 loop=5 step=1}
								{if $product.ratting le $smarty.section.i.index}
									<div class="star"></div>
								{else}
									<div class="star star_on"></div>
								{/if}
							{/section}
						</div>
						-->
						
						
						<div class="products_list_price">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
								{if $priceDisplay && $product.reduction}<span class="price-discount">{displayWtPrice p=$product.price_without_reduction}</span>{/if}
								<span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>
							{/if}
						</div>
						<br/>
						
						<a href="{$product.link}" title="{$product.name|escape:'htmlall':'UTF-8'}" class="button" style="margin:auto;">{l s='See this knife ' mod='cshometab'}</a>
						
						
					</li>
					{/foreach}
					</ul>
					<div class="cclearfix"></div>
					{if $option->scrollPanel == "true"}
					<a id="prev{$smarty.foreach.tabs.iteration}" class="prev" href="#">&lt;</a>
					<a id="next{$smarty.foreach.tabs.iteration}" class="next" href="#">&gt;</a>
					{/if}
				</div>
				{/if}
			</div>
		</div>
	</div>
	{/foreach}
</div>
<script type="text/javascript">
	$(document).ready(function() {
		cs_resize();
		if(!isMobile())
		{
			initCarousel();
		}
		if(getWidthBrowser() < 767)
		{
			$('#tabs').on('click', '.title_tab_hide_show', function() {
				var id = $(this).find('input').val();
				
				if($(this).hasClass('selected')) {
					$(this).removeClass('selected');
					$('#tabs-'+id).hide();
				} else {
					
					$('#tabs .title_tab_hide_show').removeClass('selected');
					$('#tabs .tabs-carousel').hide();
					
					$(this).addClass('selected');	
					$('#tabs-'+id).show();
					initCarouselMobile();
				}
			});
		}
	});

	$(window).resize(function() {
		if(!isMobile())
		{
			cs_resize();
		}
	});
	function cs_resize()	{
		if(getWidthBrowser() < 767){ 
		{if $option->js_tab == "true"}
			$('#tabs').tabs('destroy');
			initCarousel();
		{/if}
			{if $option->js_tab == "false"}
				$('.title_tab').hide();
			{/if}
			$('.tabs-carousel').hide();
			$('#ul_cs_tab').hide();
			$('#tabs div.title_tab_hide_show').show();
		} else {
			{if $option->js_tab == "true"}
				$('#tabs').tabs();
			{/if}
			{if $option->js_tab == "false"}
				$('.title_tab').show();
			{/if}
			$('.tabs-carousel').show();
			
			$('#ul_cs_tab').show();
			$('#tabs div.title_tab_hide_show').hide();
			
		}
	}
	
	function initCarousel() {
		{if $option->scrollPanel == "true"}
			{foreach from=$tabs item=tab name=tabs}
			//	Responsive layout, resizing the items
			$('#carousel{$smarty.foreach.tabs.iteration}').carouFredSel({
				responsive: true,
				width: '100%',
				prev: '#prev{$smarty.foreach.tabs.iteration}',
				next: '#next{$smarty.foreach.tabs.iteration}',
				auto: false,
				swipe: {
					onTouch : true
				},
				items: {
					width: 155,
					height: 280,	//	optionally resize item-height
					visible: {
						min: 1,
						max: {$option->show}
					}
				},
				scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
			});
			{/foreach}
		{/if}
	}
	
	function initCarouselMobile() {
		{if $option->scrollPanel == "true"}
			{foreach from=$tabs item=tab name=tabs}
			//	Responsive layout, resizing the items
			$('#carousel{$smarty.foreach.tabs.iteration}').carouFredSel({
				responsive: true,
				width: '100%',
				prev: '#prev{$smarty.foreach.tabs.iteration}',
				next: '#next{$smarty.foreach.tabs.iteration}',
				auto: true,
				swipe: {
					onTouch : true
				},
				items: {
					width: 155,
					height: 280,	//	optionally resize item-height
					visible: {
						min: 1,
						max:{$option->show}
					}
				},
				scroll: {
					items:1,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
			});
			{/foreach}
		{/if}
	}
	
	function updateNotCarousel(idx){
		jQuery(".tabs-carousel").hide();
		jQuery("#tabs-"+idx).show();
	}

	function updateCarousel(idx){
		$('#carousel'+idx).trigger("destroy", true);
		jQuery(".tabs-carousel").hide();
		jQuery("#tabs-"+idx).show();
		
		$('#carousel'+idx).carouFredSel({
			responsive: true,
			width: '100%',
			prev: '#prev'+idx,
			next: '#next'+idx,
			auto: false,
			swipe: {
				onTouch : true
			},
			items: {
				width: 155,
				height: 280,	//	optionally resize item-height
				visible: {
					min: 1,
					max: {$option->show}
				}
			},
			scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
		});
	}
	
	function isMobile() {
		if(navigator.userAgent.match(/iPod/i)){
				return true;
		}
		return false;
	}

</script>
{/if}
</div>
<!-- /CS Home Tab module -->
