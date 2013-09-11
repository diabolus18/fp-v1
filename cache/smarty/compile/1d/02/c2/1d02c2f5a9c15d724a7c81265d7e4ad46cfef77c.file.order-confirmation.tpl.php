<?php /* Smarty version Smarty-3.1.13, created on 2013-09-11 11:32:26
         compiled from "C:\wamp\www\fp-v1\modules\creditcardofflinepayment\views\templates\hook\order-confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15720523038aabc8376-28206530%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d02c2f5a9c15d724a7c81265d7e4ad46cfef77c' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\creditcardofflinepayment\\views\\templates\\hook\\order-confirmation.tpl',
      1 => 1374240595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15720523038aabc8376-28206530',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'success' => 0,
    'shop_name' => 0,
    'total_to_pay' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523038aac4c437_89146128',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523038aac4c437_89146128')) {function content_523038aac4c437_89146128($_smarty_tpl) {?><!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<br />
<?php if ($_smarty_tpl->tpl_vars['success']->value==true){?>
	<p><?php echo smartyTranslate(array('s'=>'Your order in','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</span> <?php echo smartyTranslate(array('s'=>'is completed.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

		<br /><br />
		<?php echo smartyTranslate(array('s'=>'When your order is verified and the payment accepted, your order will be sent.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

		<br /><br />- <?php echo smartyTranslate(array('s'=>'Order total amount:','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <span class="price"><?php echo $_smarty_tpl->tpl_vars['total_to_pay']->value;?>
</span>
		<br /><br /><?php echo smartyTranslate(array('s'=>'If you have any issue, please contact our','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
contact-form.php"><?php echo smartyTranslate(array('s'=>'Customer Service','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</a>.
	</p>
<?php }else{ ?>
	<p class="warning">
		<?php echo smartyTranslate(array('s'=>'There has been a problem with your order. Please contact our','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
contact-form.php"><?php echo smartyTranslate(array('s'=>'Customer Service','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</a>.
	</p>
<?php }?><?php }} ?>