<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 16:02:33
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\controllers\products\multishop\check_fields.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31153521376f94541a4-40345984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3f8f42bb2f204383f1c111166cfb2dbabbdee18' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\controllers\\products\\multishop\\check_fields.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31153521376f94541a4-40345984',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'display_multishop_checkboxes' => 0,
    'product_tab' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521376f95881e2_33552495',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521376f95881e2_33552495')) {function content_521376f95881e2_33552495($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['display_multishop_checkboxes']->value)&&$_smarty_tpl->tpl_vars['display_multishop_checkboxes']->value){?>
	<label style="float: none">
		<input type="checkbox" style="vertical-align: text-bottom" onclick="$('#product-tab-content-<?php echo $_smarty_tpl->tpl_vars['product_tab']->value;?>
 input[name^=\'multishop_check[\']').attr('checked', this.checked); ProductMultishop.checkAll<?php echo $_smarty_tpl->tpl_vars['product_tab']->value;?>
()" />
		<?php echo smartyTranslate(array('s'=>'Check/uncheck all. (If you are editing this page for several shops, some fields like "name" or "price" are may be disabled. You will need check these fields in order to edit them)'),$_smarty_tpl);?>

	</label>
<?php }?><?php }} ?>