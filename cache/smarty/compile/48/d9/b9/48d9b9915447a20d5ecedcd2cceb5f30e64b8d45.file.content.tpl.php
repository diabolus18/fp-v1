<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:43
         compiled from "C:\wamp\www\fp-v1\admin\themes\default\template\controllers\cms_content\content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3046451d188f76e54c4-78087092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48d9b9915447a20d5ecedcd2cceb5f30e64b8d45' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin\\themes\\default\\template\\controllers\\cms_content\\content.tpl',
      1 => 1372670578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3046451d188f76e54c4-78087092',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_breadcrumb' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d188f7765273_79773066',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d188f7765273_79773066')) {function content_51d188f7765273_79773066($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['cms_breadcrumb']->value)){?>
	<div class="cat_bar">
		<span style="color: #3C8534;"><?php echo smartyTranslate(array('s'=>'Current category'),$_smarty_tpl);?>
 :</span>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['cms_breadcrumb']->value;?>

	</div>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }} ?>