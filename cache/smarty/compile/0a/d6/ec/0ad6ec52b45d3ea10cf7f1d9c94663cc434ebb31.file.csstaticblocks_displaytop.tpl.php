<?php /* Smarty version Smarty-3.1.13, created on 2013-07-30 15:04:39
         compiled from "C:\wamp\www\fp-v1\modules\csstaticblocks\views\templates\hook\csstaticblocks_displaytop.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2014051f7b9e7152593-40458973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ad6ec52b45d3ea10cf7f1d9c94663cc434ebb31' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csstaticblocks\\views\\templates\\hook\\csstaticblocks_displaytop.tpl',
      1 => 1374235261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2014051f7b9e7152593-40458973',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'block_list' => 0,
    'cookie' => 0,
    'block' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51f7b9e718c406_73996066',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f7b9e718c406_73996066')) {function content_51f7b9e718c406_73996066($_smarty_tpl) {?><!-- Static Block module -->
<?php  $_smarty_tpl->tpl_vars['block'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['block']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['block_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['block']->key => $_smarty_tpl->tpl_vars['block']->value){
$_smarty_tpl->tpl_vars['block']->_loop = true;
?>
	<?php if (isset($_smarty_tpl->tpl_vars['block']->value->content[(int)$_smarty_tpl->tpl_vars['cookie']->value->id_lang])){?>
		<?php echo $_smarty_tpl->tpl_vars['block']->value->content[(int)$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>

	<?php }?>
<?php } ?>
<!-- /Static block module --><?php }} ?>