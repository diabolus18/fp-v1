<?php /* Smarty version Smarty-3.1.13, created on 2013-09-17 09:12:19
         compiled from "C:\wamp\www\fp-v1\modules\paypal\views\templates\hook\express_checkout_payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8047523800d3749045-00692546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02df13cf9f5f2244ba030540ac2c2d0fd112ef07' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\paypal\\views\\templates\\hook\\express_checkout_payment.tpl',
      1 => 1378365142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8047523800d3749045-00692546',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'use_mobile' => 0,
    'base_dir_ssl' => 0,
    'PayPal_lang_code' => 0,
    'logos' => 0,
    'PayPal_payment_method' => 0,
    'PayPal_integral' => 0,
    'PayPal_content' => 0,
    'fee' => 0,
    'PayPal_payment_type' => 0,
    'PayPal_current_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523800d37eb916_09941779',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523800d37eb916_09941779')) {function content_523800d37eb916_09941779($_smarty_tpl) {?>

<p class="payment_module">
	<a href="javascript:void(0)" onclick="$('#paypal_payment_form').submit();" id="paypal_process_payment" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
">
		<?php if (isset($_smarty_tpl->tpl_vars['use_mobile']->value)&&$_smarty_tpl->tpl_vars['use_mobile']->value){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/paypal/img/logos/express_checkout_mobile/CO_<?php echo $_smarty_tpl->tpl_vars['PayPal_lang_code']->value;?>
_orange_295x43.png" />
		<?php }else{ ?>
			<?php if (isset($_smarty_tpl->tpl_vars['logos']->value['LocalPayPalHorizontalSolutionPP'])&&$_smarty_tpl->tpl_vars['PayPal_payment_method']->value==$_smarty_tpl->tpl_vars['PayPal_integral']->value){?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['logos']->value['LocalPayPalHorizontalSolutionPP'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['PayPal_content']->value['payment_choice'];?>
" height="48px" />
			<?php }else{ ?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['logos']->value['LocalPayPalLogoMedium'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['PayPal_content']->value['payment_choice'];?>
" />
			<?php }?>
			<?php echo $_smarty_tpl->tpl_vars['PayPal_content']->value['payment_choice'];?>

			<br /><?php echo smartyTranslate(array('s'=>'Additional cost','mod'=>'paypal'),$_smarty_tpl);?>
: <span style="font-weight:bold"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['fee']->value),$_smarty_tpl);?>
</span>
		<?php }?>
		
	</a>
</p>

<form id="paypal_payment_form" action="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/paypal/express_checkout/payment.php" data-ajax="false" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" method="post">
	<input type="hidden" name="express_checkout" value="<?php echo $_smarty_tpl->tpl_vars['PayPal_payment_type']->value;?>
"/>
	<input type="hidden" name="current_shop_url" value="<?php echo $_smarty_tpl->tpl_vars['PayPal_current_page']->value;?>
" />
</form>
<?php }} ?>