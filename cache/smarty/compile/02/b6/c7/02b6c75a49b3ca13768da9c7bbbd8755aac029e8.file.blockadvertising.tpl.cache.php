<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 16:03:44
         compiled from "C:\wamp\www\fp-v1\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2090751d18c40cd90f2-79660565%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02b6c75a49b3ca13768da9c7bbbd8755aac029e8' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1372670641,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2090751d18c40cd90f2-79660565',
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
  'unifunc' => 'content_51d18c40d5dbf3_76286104',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c40d5dbf3_76286104')) {function content_51d18c40d5dbf3_76286104($_smarty_tpl) {?>

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