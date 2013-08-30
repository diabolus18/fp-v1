<?php /* Smarty version Smarty-3.1.13, created on 2013-08-30 17:24:14
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:132095220b91e73f574-31274770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '519812a2074ae8c42d71330ab51f169d96047da4' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\layout.tpl',
      1 => 1374235091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132095220b91e73f574-31274770',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'display_header' => 0,
    'HOOK_HEADER' => 0,
    'template' => 0,
    'display_footer' => 0,
    'live_edit' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5220b91e77d604_60382590',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5220b91e77d604_60382590')) {function content_5220b91e77d604_60382590($_smarty_tpl) {?>
<?php if (!empty($_smarty_tpl->tpl_vars['display_header']->value)){?><?php echo $_smarty_tpl->getSubTemplate ('./header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('HOOK_HEADER'=>$_smarty_tpl->tpl_vars['HOOK_HEADER']->value), 0);?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['template']->value)){?><?php echo $_smarty_tpl->tpl_vars['template']->value;?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['display_footer']->value)){?><?php echo $_smarty_tpl->getSubTemplate ('./footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?>
<?php if (!empty($_smarty_tpl->tpl_vars['live_edit']->value)){?><?php echo $_smarty_tpl->tpl_vars['live_edit']->value;?>
<?php }?><?php }} ?>