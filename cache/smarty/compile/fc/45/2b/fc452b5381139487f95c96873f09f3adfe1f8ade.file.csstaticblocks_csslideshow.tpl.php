<?php /* Smarty version Smarty-3.1.13, created on 2013-07-31 08:17:48
         compiled from "C:\wamp\www\fp-v1\modules\csstaticblocks\views\templates\hook\csstaticblocks_csslideshow.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1897151f8ac0cbfc0e2-77909961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc452b5381139487f95c96873f09f3adfe1f8ade' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csstaticblocks\\views\\templates\\hook\\csstaticblocks_csslideshow.tpl',
      1 => 1374235261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1897151f8ac0cbfc0e2-77909961',
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
  'unifunc' => 'content_51f8ac0cc285d0_87306055',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f8ac0cc285d0_87306055')) {function content_51f8ac0cc285d0_87306055($_smarty_tpl) {?><!-- Static Block module -->
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