<?php /* Smarty version Smarty-3.1.13, created on 2013-08-22 15:27:05
         compiled from "C:\wamp\www\fp-v1\modules\csstaticblocks\views\templates\hook\csstaticblocks_homeright.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16851521611a91583e2-17301227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb98cc032f42417c80df4918feb12b9b7c8649b5' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csstaticblocks\\views\\templates\\hook\\csstaticblocks_homeright.tpl',
      1 => 1374235261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16851521611a91583e2-17301227',
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
  'unifunc' => 'content_521611a918f792_45622075',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521611a918f792_45622075')) {function content_521611a918f792_45622075($_smarty_tpl) {?><!-- Static Block module -->
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