<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 15:35:31
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20704521370a39be258-66914306%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e4181e0174923a534ba67d2465d043f15a872e9' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20704521370a39be258-66914306',
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
  'unifunc' => 'content_521370a3a1a2f8_69019349',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521370a3a1a2f8_69019349')) {function content_521370a3a1a2f8_69019349($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/edit.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>