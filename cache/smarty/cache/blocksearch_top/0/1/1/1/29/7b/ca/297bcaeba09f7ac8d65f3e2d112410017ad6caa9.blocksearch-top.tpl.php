<?php /*%%SmartyHeaderCode:829751d18c401aaf15-89432740%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '297bcaeba09f7ac8d65f3e2d112410017ad6caa9' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1372670645,
      2 => 'file',
    ),
    '4da5b0548e06212d95c7891bc6680cb8b04a18e6' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocksearch\\blocksearch-instantsearch.tpl',
      1 => 1372670645,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '829751d18c401aaf15-89432740',
  'variables' => 
  array (
    'hook_mobile' => 0,
    'link' => 0,
    'ENT_QUOTES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18c403690f7_83292634',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c403690f7_83292634')) {function content_51d18c403690f7_83292634($_smarty_tpl) {?><!-- block seach mobile -->
<!-- Block search module TOP -->
<div id="search_block_top">

	<form method="get" action="http://localhost/fp-v1/index.php?controller=search" id="searchbox">
		<p>
			<label for="search_query_top"><!-- image on background --></label>
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<input class="search_query" type="text" id="search_query_top" name="search_query" value="" />
			<input type="submit" name="submit_search" value="Rechercher" class="button" />
	</p>
	</form>
</div>
	<script type="text/javascript">
	// <![CDATA[
		$('document').ready( function() {
			$("#search_query_top")
				.autocomplete(
					'http://localhost/fp-v1/index.php?controller=search', {
						minChars: 3,
						max: 10,
						width: 500,
						selectFirst: false,
						scroll: false,
						dataType: "json",
						formatItem: function(data, i, max, value, term) {
							return value;
						},
						parse: function(data) {
							var mytab = new Array();
							for (var i = 0; i < data.length; i++)
								mytab[mytab.length] = { data: data[i], value: data[i].cname + ' > ' + data[i].pname };
							return mytab;
						},
						extraParams: {
							ajaxSearch: 1,
							id_lang: 1
						}
					}
				)
				.result(function(event, data, formatted) {
					$('#search_query_top').val(data.pname);
					document.location.href = data.product_link;
				})
		});
	// ]]>
	</script>

<!-- /Block search module TOP -->
<?php }} ?>