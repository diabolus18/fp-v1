<?php /* Smarty version Smarty-3.1.13, created on 2013-08-23 22:47:17
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96945217ca55472175-85311414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3437a6bd987d95e5d68f75cba7cb8e7195be70c' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1374235095,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96945217ca55472175-85311414',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'adv_link' => 0,
    'adv_title' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5217ca5548d930_35258802',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5217ca5548d930_35258802')) {function content_5217ca5548d930_35258802($_smarty_tpl) {?>

<!-- MODULE Block advertising -->
<div class="advertising_block">
	<a href="<?php echo $_smarty_tpl->tpl_vars['adv_link']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" /></a>
</div>
<!-- /MODULE Block advertising -->
<?php }} ?>