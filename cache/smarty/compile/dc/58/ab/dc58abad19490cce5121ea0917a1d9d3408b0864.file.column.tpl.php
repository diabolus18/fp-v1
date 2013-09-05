<?php /* Smarty version Smarty-3.1.13, created on 2013-09-05 14:54:00
         compiled from "C:\wamp\www\fp-v1\modules\paypal\views\templates\hook\column.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2710552287ee8ef1ed6-59087949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc58abad19490cce5121ea0917a1d9d3408b0864' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\paypal\\views\\templates\\hook\\column.tpl',
      1 => 1378365142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2710552287ee8ef1ed6-59087949',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir_ssl' => 0,
    'logo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52287ee8f05009_16560900',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52287ee8f05009_16560900')) {function content_52287ee8f05009_16560900($_smarty_tpl) {?>

<div id="paypal-column-block">
	<p><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/paypal/about.php" rel="nofollow"><img src="<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
" alt="PayPal" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" style="max-width: 100%" /></a></p>
</div>
<?php }} ?>