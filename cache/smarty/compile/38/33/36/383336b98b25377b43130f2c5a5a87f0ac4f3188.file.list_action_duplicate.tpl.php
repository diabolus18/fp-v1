<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:59
         compiled from "C:\wamp\www\fp-v1\admin\themes\default\template\helpers\list\list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1002851d1890733a055-35595146%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '383336b98b25377b43130f2c5a5a87f0ac4f3188' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin\\themes\\default\\template\\helpers\\list\\list_action_duplicate.tpl',
      1 => 1372670583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1002851d1890733a055-35595146',
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
  'unifunc' => 'content_51d189073903c6_71571003',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d189073903c6_71571003')) {function content_51d189073903c6_71571003($_smarty_tpl) {?>
<a class="pointer" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')) document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ok']->value;?>
'; else document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ko']->value;?>
';">
	<img src="../img/admin/duplicate.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>