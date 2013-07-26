<?php /* Smarty version Smarty-3.1.13, created on 2013-07-26 13:42:37
         compiled from "C:\wamp\www\fp-v1\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3162951f260ade9ef27-33252483%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '3162951f260ade9ef27-33252483',
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
  'unifunc' => 'content_51f260adec27c5_54257969',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f260adec27c5_54257969')) {function content_51f260adec27c5_54257969($_smarty_tpl) {?>

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