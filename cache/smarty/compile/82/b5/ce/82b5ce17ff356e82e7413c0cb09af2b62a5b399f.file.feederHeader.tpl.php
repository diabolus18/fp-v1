<?php /* Smarty version Smarty-3.1.13, created on 2013-08-02 16:14:18
         compiled from "C:\wamp\www\fp-v1\modules\feeder\feederHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1600951fbbeba3e5959-09917512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '1600951fbbeba3e5959-09917512',
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
  'unifunc' => 'content_51fbbeba3fddb6_44910748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fbbeba3fddb6_44910748')) {function content_51fbbeba3fddb6_44910748($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<link rel="alternate" type="application/rss+xml" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'html', 'UTF-8');?>
" href="<?php echo $_smarty_tpl->tpl_vars['feedUrl']->value;?>
" /><?php }} ?>