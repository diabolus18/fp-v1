<?php /* Smarty version Smarty-3.1.13, created on 2013-09-04 17:28:52
         compiled from "C:\wamp\www\fp-v1\modules\creditcardofflinepayment\views\templates\hook\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14776522751b4aa4a34-78071083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64e9c16b4badd529fbd45b3dcb9f26fddcac1e69' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\creditcardofflinepayment\\views\\templates\\hook\\payment.tpl',
      1 => 1374240595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14776522751b4aa4a34-78071083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currency_authorized' => 0,
    'this_path_ssl' => 0,
    'link' => 0,
    'this_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_522751b4b0c340_34058634',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_522751b4b0c340_34058634')) {function content_522751b4b0c340_34058634($_smarty_tpl) {?><!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<?php if ($_smarty_tpl->tpl_vars['currency_authorized']->value){?>
<p class="payment_module">
	<a href="<?php if (version_compare(@constant('_PS_VERSION_'),'1.5','<')){?><?php echo $_smarty_tpl->tpl_vars['this_path_ssl']->value;?>
payment.php<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('creditcardofflinepayment','payment',array(),true);?>
<?php }?>" title="<?php echo smartyTranslate(array('s'=>'Pay with credit card','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
creditcardofflinepayment.jpg" alt="<?php echo smartyTranslate(array('s'=>'Pay with credit card','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" width="86px" height="57px"/>
		<?php echo smartyTranslate(array('s'=>'Pay with credit card','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

	</a>
</p>
<?php }else{ ?>
<p class="payment_module">
	<a href="#" style="cursor:not-allowed;" title="<?php echo smartyTranslate(array('s'=>'Pay with credit card','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
creditcardofflinepayment.jpg" alt="<?php echo smartyTranslate(array('s'=>'Pay with credit card','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" />
		<?php echo smartyTranslate(array('s'=>'Payment with credit card is not enabled with this currency','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

	</a>
</p>
<?php }?><?php }} ?>