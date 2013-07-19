<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:25
         compiled from "C:\wamp\www\fp-V1\admin\themes\default\template\helpers\list\list_action_removestock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2421951d1877da5f9f0-68016510%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6b2b37e2d3aab93bca9a759247725e6568432f2' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\admin\\themes\\default\\template\\helpers\\list\\list_action_removestock.tpl',
      1 => 1372670583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2421951d1877da5f9f0-68016510',
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
  'unifunc' => 'content_51d1877da7b590_11802769',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d1877da7b590_11802769')) {function content_51d1877da7b590_11802769($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/remove_stock.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a>
<?php }} ?>