<!-- CS Manufacturer module -->
<div class="manufacturerContainer">
	<div class="list_manufacturer responsive">
		<ul id="scroller">
		{$i=0}
		{foreach from=$manufacs item=manufacturer name=manufacturer_list}
			{if file_exists($ps_manu_img_dir|cat:$manufacturer.id_manufacturer|cat:'.jpg')}
			{$i=$i+1}
			{if $i%2==1}
			<li class="{if $smarty.foreach.product_list.first}first_item{elseif $smarty.foreach.product_list.last}last_item{/if}">
			{/if}
				{if $i%2==1}
				<div class="menufacture-1">
					<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)}" title="{$manufacturer.name|escape:'htmlall':'UTF-8'}">
					<img src="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}-mf_default.jpg" alt="{$manufacturer.name|escape:'htmlall':'UTF-8'}" /></a>
				</div>
				{/if}
				{if $i%2==0}
				<div class="menufacture-1">
					<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)}" title="{$manufacturer.name|escape:'htmlall':'UTF-8'}">
					<img src="{$img_manu_dir}{$manufacturer.id_manufacturer|escape:'htmlall':'UTF-8'}.jpg" alt="{$manufacturer.name|escape:'htmlall':'UTF-8'}" /></a>
				</div>
				{/if}
				{if $i%2==0 || $i==count($manufacs)}
					</li>
				{/if}
			{/if}
		{/foreach}
		</ul>
			<a id="prev_cs_manu" class="prev btn" href="javascript:void(0)">&lt;</a>
			<a id="next_cs_manu" class="next btn" href="javascript:void(0)">&gt;</a>
	</div>
</div>
<script type="text/javascript">
	$(window).load(function(){
		$("#scroller").carouFredSel({
			auto: false,
			responsive: true,
				width: '100%',
				height : 'variable',
				prev: '#prev_cs_manu',
				next: '#next_cs_manu',
				swipe: {
					onTouch : true
				},
				items: {
					width: 140,
					height: 'variable',
					visible: {
						min: 1,
						max: 6
					}
				},
				scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 500   //  The duration of the transition.
				}

		});
	});
</script>
<!-- /CS Manufacturer module -->

