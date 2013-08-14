<!-- CS catalog popular -->
{if isset($category_list)}
{$col=2}
	<h4>{l s='more way to shopping...' mod='cscatalogpopular'}</h4>
	<div class="cat_popular">
	<ul class="ul_cat_popular">
		{$i=0}
	{foreach from=$category_list item=category name=category_list}
		{$i=$i+1}
		<li class="cat_group{if $smarty.foreach.category_list.iteration%$col==0} even {else} odd{/if}{if $smarty.foreach.category_list.iteration.last} last{/if}{if $i<=2} first{/if}">
		<div  class="cat-content">	
			<h3 class="cs-cat-title">
				<a href="{$link->getCategoryLink($category.id_category, $category.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$category.name|escape:'htmlall':'UTF-8'}">{$category.name}</a>
			</h3>
			
			<!-- MISE EN COMMENTAIRE AFFICHAGE SOUS CATEGORIES PAGE ACCUEIL
			<ul class="sub_cat">
				{foreach from=$category.subs item=sub name=subs}
					<li ><a href="{$link->getCategoryLink($sub.id_category, $sub.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$sub.name|escape:'htmlall':'UTF-8'}">{$sub.name}</a></li>
				{/foreach}				
			</ul>
			-->
			
		</div>
		<div class="product-latest">
			{foreach from=$category.product_latest item=product name=product_latest}
				<a href="{$link->getCategoryLink($category.id_category, $category.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$category.name|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
			{/foreach}
			
			{foreach from=$category.product_latest item=product name=product_latest}
				<a href="{$link->getCategoryLink($category.id_category, $category.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$category.name|escape:'htmlall':'UTF-8'}">Voir la gamme {$category.name}</a>
			{/foreach}
		</div>
		
		<!-- MISE EN COMMENTAIRE REDIRECTION VERS UN PRODUIT AU HASARD DE LA CATEGORIE
		<div class="product-latest">
			{foreach from=$category.product_latest item=product name=product_latest}
				<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
			{/foreach}
		</div>
		-->
		</li>
	{/foreach}
	<li class="last view-all"><a href="{$link->getCategoryLink(2)}" title="View All"><span>{l s="View All" mod='cscatalogpopular'}</span></a></li>
	</ul>
	</div>
{/if}
<!-- CS catalog popular -->