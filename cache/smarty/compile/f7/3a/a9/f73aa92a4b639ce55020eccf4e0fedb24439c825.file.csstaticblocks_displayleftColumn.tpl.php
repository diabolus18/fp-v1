<?php /* Smarty version Smarty-3.1.13, created on 2013-08-30 17:24:13
         compiled from "C:\wamp\www\fp-v1\modules\csstaticblocks\views\templates\hook\csstaticblocks_displayleftColumn.tpl" */ ?>
<?php /*%%SmartyHeaderCode:146895220b91db2b3b1-54244538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f73aa92a4b639ce55020eccf4e0fedb24439c825' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csstaticblocks\\views\\templates\\hook\\csstaticblocks_displayleftColumn.tpl',
      1 => 1374235261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '146895220b91db2b3b1-54244538',
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
  'unifunc' => 'content_5220b91db700b9_34779827',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5220b91db700b9_34779827')) {function content_5220b91db700b9_34779827($_smarty_tpl) {?><!-- Static Block module -->
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