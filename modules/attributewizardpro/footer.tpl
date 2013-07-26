<script>
var awp_disable_atc = "";
$('a.ajax_add_to_cart_button').each(function(){ldelim}
	awp_disable_atc += (awp_disable_atc == ""?"":",")+$(this).attr('rel').replace('ajax_id_product_','');
{rdelim});
$.ajax({ldelim}
	type: 'POST',
	url: baseDir + 'modules/attributewizardpro/disable_json.php',
	async: false,
	cache: false,
	dataType : "json",
	data: {ldelim}'products':awp_disable_atc{rdelim},
	success:function(feed)
	{ldelim} 
       // Do something with the response
        if (feed.awp_disable)
        {ldelim}
       		var disable_arr = feed.awp_disable.split(',');
          	for (awp_id in disable_arr)
          	{ldelim}
          		if ($('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').attr('class'))
          		{ldelim}
          			{if $awp_disable_hide == "1"}
          			$('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').hide();
          			{else}
          			var awp_class = $('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').attr('class').replace("ajax_add_to_cart_button","");
          			var awp_add_text = $('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').html();
          			$('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').replaceWith('<span class="'+awp_class+'">'+awp_add_text+'</span>');
          			{/if}
          		{rdelim}
          	{rdelim}
          {rdelim}
	{rdelim}
{rdelim});
</script>