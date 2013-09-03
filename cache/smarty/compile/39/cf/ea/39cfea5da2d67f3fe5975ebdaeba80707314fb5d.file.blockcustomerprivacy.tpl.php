<?php /* Smarty version Smarty-3.1.13, created on 2013-09-03 13:26:50
         compiled from "C:\wamp\www\fp-v1\modules\blockcustomerprivacy\blockcustomerprivacy.tpl" */ ?>
<?php /*%%SmartyHeaderCode:292725225c77a5532c6-85328675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39cfea5da2d67f3fe5975ebdaeba80707314fb5d' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockcustomerprivacy\\blockcustomerprivacy.tpl',
      1 => 1374231327,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '292725225c77a5532c6-85328675',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'privacy_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5225c77a568e64_81707293',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5225c77a568e64_81707293')) {function content_5225c77a568e64_81707293($_smarty_tpl) {?>

<div class="error_customerprivacy" style="color:red;"></div>
<fieldset class="account_creation customerprivacy">
	<h3><?php echo smartyTranslate(array('s'=>'Customer data privacy','mod'=>'blockcustomerprivacy'),$_smarty_tpl);?>
</h3>
	<p class="required">
		<input type="checkbox" value="1" id="customer_privacy" name="customer_privacy" style="float:left;margin: 15px;" />				
	</p>
	<label for="customer_privacy"><?php echo $_smarty_tpl->tpl_vars['privacy_message']->value;?>
</label>		
</fieldset><?php }} ?>