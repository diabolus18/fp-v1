<?php /*%%SmartyHeaderCode:2307751d18c40a07221-16547486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c984f7b8923c90cd6ef483997aa1ca95170f53f' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\default\\modules\\blockcategories\\blockcategories.tpl',
      1 => 1374231351,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2307751d18c40a07221-16547486',
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e920ba00e169_28480240',
  'variables' => 
  array (
    'isDhtml' => 0,
    'blockCategTree' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e920ba00e169_28480240')) {function content_51e920ba00e169_28480240($_smarty_tpl) {?>
<!-- Block categories module -->
<div id="categories_block_left" class="block">
	<p class="title_block">Catégories</p>
	<div class="block_content">
		<ul class="tree dhtml">
				</ul>
		
		<script type="text/javascript">
		// <![CDATA[
			// we hide the tree only if JavaScript is activated
			$('div#categories_block_left ul.dhtml').hide();
		// ]]>
		</script>
	</div>
</div>
<!-- /Block categories module -->
<?php }} ?>