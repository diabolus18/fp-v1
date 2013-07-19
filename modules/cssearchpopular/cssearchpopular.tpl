<!-- MODULE search popular -->
{if $searchList}
<div class="block_popular_word_search clearfix">
	<h4 class="title_block">{l s="Most popular top searches" mod="cssearchpopular"}</h4>
	<div class="block_content">
	{foreach from=$searchList item=search name=searchList}
	<a href="{$link->getPageLink('search', true, NULL, "search_query={$search.word|urlencode}")}">{$search.word}</a>
	{/foreach}
	</div>
</div>
{/if}
<!-- MODULE search popular -->