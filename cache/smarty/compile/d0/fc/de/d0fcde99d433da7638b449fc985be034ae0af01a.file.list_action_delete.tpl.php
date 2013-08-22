<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 15:35:31
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\helpers\list\list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24473521370a3a2f6d2-20847591%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0fcde99d433da7638b449fc985be034ae0af01a' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\helpers\\list\\list_action_delete.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24473521370a3a2f6d2-20847591',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'confirm' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521370a3a55200_46376453',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521370a3a55200_46376453')) {function content_521370a3a55200_46376453($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="delete" <?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)){?>onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){ return true; }else{ event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/delete.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>