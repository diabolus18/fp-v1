<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:25
         compiled from "C:\wamp\www\fp-V1\admin\themes\default\template\helpers\list\list_action_addstock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:796851d1877d8530f4-15285791%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f0bfab8e4cb585472dbf6d6adfa10d7c0634a24' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\admin\\themes\\default\\template\\helpers\\list\\list_action_addstock.tpl',
      1 => 1372670583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '796851d1877d8530f4-15285791',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d1877d866350_18351625',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d1877d866350_18351625')) {function content_51d1877d866350_18351625($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/add_stock.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a>
<?php }} ?>