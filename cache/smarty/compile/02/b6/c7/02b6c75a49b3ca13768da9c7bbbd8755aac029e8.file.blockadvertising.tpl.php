<?php /* Smarty version Smarty-3.1.13, created on 2013-09-04 14:32:54
         compiled from "C:\wamp\www\fp-v1\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:970552272876ad66c8-66396067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02b6c75a49b3ca13768da9c7bbbd8755aac029e8' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1374231326,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '970552272876ad66c8-66396067',
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
  'unifunc' => 'content_52272876af55c5_52917835',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52272876af55c5_52917835')) {function content_52272876af55c5_52917835($_smarty_tpl) {?>

<!-- MODULE Block advertising -->
<div class="advertising_block">
	<a href="<?php echo $_smarty_tpl->tpl_vars['adv_link']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" width="155"  height="163" /></a>
</div>
<!-- /MODULE Block advertising -->
<?php }} ?>