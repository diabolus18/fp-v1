<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 16:02:00
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\helpers\list\list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8138521376d83dec75-48256241%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '911a796ce074b423ef373c809bf90acea0ec14f1' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\helpers\\list\\list_action_duplicate.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8138521376d83dec75-48256241',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'confirm' => 0,
    'location_ok' => 0,
    'location_ko' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521376d842fd96_59456923',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521376d842fd96_59456923')) {function content_521376d842fd96_59456923($_smarty_tpl) {?>
<a class="pointer" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')) document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ok']->value;?>
'; else document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ko']->value;?>
';">
	<img src="../img/admin/duplicate.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>