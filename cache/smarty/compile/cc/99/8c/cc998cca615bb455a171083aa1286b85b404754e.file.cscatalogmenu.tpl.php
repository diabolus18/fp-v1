<?php /* Smarty version Smarty-3.1.13, created on 2013-11-13 17:55:00
         compiled from "C:\wamp\www\fp-v1\modules\cscatalogmenu\cscatalogmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155525283aee4368c56-44831316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc998cca615bb455a171083aa1286b85b404754e' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\cscatalogmenu\\cscatalogmenu.tpl',
      1 => 1374235263,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155525283aee4368c56-44831316',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'js_dir' => 0,
    'isDhtml' => 0,
    'blockCategTree' => 0,
    'branche_tpl_path' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5283aee44062a7_90420578',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5283aee44062a7_90420578')) {function content_5283aee44062a7_90420578($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'){?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
tools/treeManagement.js"></script>
<!-- Block catalog menu module -->
<div id="categories_block_left" class="block">
	<h4><?php echo smartyTranslate(array('s'=>"Categories"),$_smarty_tpl);?>
</h4>
	<div class="block_content">
		<ul class="tree <?php if ($_smarty_tpl->tpl_vars['isDhtml']->value){?>dhtml<?php }?>">
		<?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blockCategTree']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['child']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['child']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
 $_smarty_tpl->tpl_vars['child']->iteration++;
 $_smarty_tpl->tpl_vars['child']->last = $_smarty_tpl->tpl_vars['child']->iteration === $_smarty_tpl->tpl_vars['child']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['blockCategTree']['last'] = $_smarty_tpl->tpl_vars['child']->last;
?>
			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['blockCategTree']['last']){?>
				<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['branche_tpl_path']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('node'=>$_smarty_tpl->tpl_vars['child']->value,'last'=>'true'), 0);?>

			<?php }else{ ?>
				<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['branche_tpl_path']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('node'=>$_smarty_tpl->tpl_vars['child']->value), 0);?>

			<?php }?>
		<?php } ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
// <![CDATA[
	// we hide the tree only if JavaScript is activated
	$('div#categories_block_left ul.dhtml').hide();
// ]]>
</script>
<!-- /Block catalog menu module -->
<?php }?>
<?php }} ?>