<?php /* Smarty version Smarty-3.1.13, created on 2013-08-26 17:48:19
         compiled from "C:\wamp\www\fp-v1\modules\feeder\feederHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32723521b78c31c3c09-94006810%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82b5ce17ff356e82e7413c0cb09af2b62a5b399f' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\feeder\\feederHeader.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32723521b78c31c3c09-94006810',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'meta_title' => 0,
    'feedUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521b78c31d83e3_16541150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521b78c31d83e3_16541150')) {function content_521b78c31d83e3_16541150($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<link rel="alternate" type="application/rss+xml" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'html', 'UTF-8');?>
" href="<?php echo $_smarty_tpl->tpl_vars['feedUrl']->value;?>
" /><?php }} ?>