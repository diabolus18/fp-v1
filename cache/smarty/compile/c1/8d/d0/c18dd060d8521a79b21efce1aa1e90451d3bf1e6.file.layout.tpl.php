<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 13:19:25
         compiled from "C:\wamp\www\fp-v1\themes\default\layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2004751dc38973f72d5-88250711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c18dd060d8521a79b21efce1aa1e90451d3bf1e6' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\default\\layout.tpl',
      1 => 1374231338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2004751dc38973f72d5-88250711',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51dc3897430f91_39436663',
  'variables' => 
  array (
    'display_header' => 0,
    'HOOK_HEADER' => 0,
    'template' => 0,
    'display_footer' => 0,
    'live_edit' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51dc3897430f91_39436663')) {function content_51dc3897430f91_39436663($_smarty_tpl) {?>
<?php if (!empty($_smarty_tpl->tpl_vars['display_header']->value)){?><?php echo $_smarty_tpl->getSubTemplate ('./header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('HOOK_HEADER'=>$_smarty_tpl->tpl_vars['HOOK_HEADER']->value), 0);?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['template']->value)){?><?php echo $_smarty_tpl->tpl_vars['template']->value;?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['display_footer']->value)){?><?php echo $_smarty_tpl->getSubTemplate ('./footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['live_edit']->value)){?><?php echo $_smarty_tpl->tpl_vars['live_edit']->value;?>
<?php }?><?php }} ?>