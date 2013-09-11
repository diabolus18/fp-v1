<?php /* Smarty version Smarty-3.1.13, created on 2013-09-11 11:31:48
         compiled from "C:\wamp\www\fp-v1\modules\creditcardofflinepayment\views\templates\front\payment_execution.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2797252303884244199-19641188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ee0d6a680d09fd552d76364d6d95c7e51ac0a12' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\creditcardofflinepayment\\views\\templates\\front\\payment_execution.tpl',
      1 => 1374240595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2797252303884244199-19641188',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mobile_device' => 0,
    'this_path' => 0,
    'nbProducts' => 0,
    'link' => 0,
    'id_currency' => 0,
    'issuers' => 0,
    'issuer' => 0,
    'errores' => 0,
    'base_dir' => 0,
    'error' => 0,
    'requireIssuerName' => 0,
    'requiredIssuerName' => 0,
    'card' => 0,
    'cookie' => 0,
    'requireCedule' => 0,
    'requiredCedule' => 0,
    'requireAddress' => 0,
    'requireZipCode' => 0,
    'requiredZipCode' => 0,
    'requireCardNumber' => 0,
    'requiredCardNumber' => 0,
    'requireCVC' => 0,
    'requiredCVC' => 0,
    'requireIssuer' => 0,
    'requiredIssuer' => 0,
    'requireExpiration' => 0,
    'requiredExpiration' => 0,
    'i' => 0,
    'total' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5230388485bf51_53528007',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5230388485bf51_53528007')) {function content_5230388485bf51_53528007($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.date_format.php';
?><!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<script type="text/javascript">
	
	function procesando()
	{
		$('*').css('cursor', 'wait');
		document.getElementById('buttons').style.display = "none";
		document.getElementById('procesando').style.display = "block";

	}
	
</script>

<?php if (!$_smarty_tpl->tpl_vars['mobile_device']->value){?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
js/shadowbox.css">
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
js/shadowbox.js"></script>
<script type="text/javascript">
	
	Shadowbox.init();
	
</script>
<?php }?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Credit card payment','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<h2><?php echo smartyTranslate(array('s'=>'Order summary','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</h2>

<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['nbProducts']->value<=0){?>
	<p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</p>
<?php }else{ ?>
	<h3><?php echo smartyTranslate(array('s'=>'Credit card payment','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</h3>
	<form action="<?php if (version_compare(@constant('_PS_VERSION_'),'1.5','<')){?><?php echo smarty_modifier_escape($_SERVER['REQUEST_URI'], 'htmlall', 'UTF-8');?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('creditcardofflinepayment','validation',array(),true);?>
<?php }?>" method="post" id="creditForm" name="creditForm" class="std">
		<fieldset>
			<input type="hidden" name="id_currency" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['id_currency']->value, 'htmlall', 'UTF-8');?>
"/>

			<div id="payment_form">
				<h3 style="align: center;text-align: center;">
					<?php echo smartyTranslate(array('s'=>'You can use the following card issuers:','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

					<br /><br />
					<?php  $_smarty_tpl->tpl_vars['issuer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['issuer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['issuers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['issuer']->key => $_smarty_tpl->tpl_vars['issuer']->value){
$_smarty_tpl->tpl_vars['issuer']->_loop = true;
?>
					<?php if ($_smarty_tpl->tpl_vars['issuer']->value['authorized']){?>
					<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
img/<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['issuer']->value['imgName'], 'htmlall', 'UTF-8');?>
" />
					<?php }?>
					<?php } ?>
				</h3>
				<?php if (count($_smarty_tpl->tpl_vars['errores']->value)>0){?>
				<div class="alert error" id="errorDiv">
					<img alt="<?php echo smartyTranslate(array('s'=>'Error','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
img/admin/forbbiden.gif" />
					<?php echo smartyTranslate(array('s'=>'There are errors','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:
					<ol>
						<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errores']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
						<li><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['error']->value, 'htmlall', 'UTF-8');?>
</li>
						<?php } ?>
					</ol>
				</div>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireIssuerName']->value){?>
				<p class="required text">
					<label for="card[name]">
						<?php echo smartyTranslate(array('s'=>'Card holder name','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredIssuerName']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" maxlength="150" name="card[name]" id="cardName" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['name'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['name'], 'htmlall', 'UTF-8');?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cookie']->value->customer_firstname, 'htmlall', 'UTF-8');?>
 <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cookie']->value->customer_lastname, 'htmlall', 'UTF-8');?>
<?php }?>"/>
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireCedule']->value){?>
				<p class="required text">
					<label for="card[cedula]">
						<?php echo smartyTranslate(array('s'=>'ID Card/Passport','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredCedule']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" name="card[cedula]" id="cardCVC" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['cedula'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['cedula'], 'htmlall', 'UTF-8');?>
<?php }?>" size="20" maxlength="20"/>
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireAddress']->value){?>
				<p class="required text">
					<label for="card[address]">
						<?php echo smartyTranslate(array('s'=>'Address','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredCedule']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" name="card[address]" id="cardAddress" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['address'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['address'], 'htmlall', 'UTF-8');?>
<?php }?>" size="20" maxlength="20"/>
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireZipCode']->value){?>
				<p class="required text">
					<label for="card[zipcode]">
						<?php echo smartyTranslate(array('s'=>'Zip code','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredZipCode']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" name="card[zipcode]" id="cardZipCode" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['zipcode'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['zipcode'], 'htmlall', 'UTF-8');?>
<?php }?>" size="5" />
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireCardNumber']->value){?>
				<p class="required text">
					<label for="card[number]">
						<?php echo smartyTranslate(array('s'=>'Credit card number','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredCardNumber']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" name="card[number]" id="cardNumber" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['number'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['number'], 'htmlall', 'UTF-8');?>
<?php }?>" size="20" maxlength="16" />
				</p>
				<?php }?>
				
				<?php if ($_smarty_tpl->tpl_vars['requireCVC']->value){?>
				<p class="required text">
					<label for="card[cvc]">
						<?php echo smartyTranslate(array('s'=>'CVC (card security code)','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredCVC']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<input type="text" name="card[cvc]" id="cardCVC" value="<?php if (isset($_smarty_tpl->tpl_vars['card']->value['cvc'])){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['card']->value['cvc'], 'htmlall', 'UTF-8');?>
<?php }?>" size="4" maxlength="4"/>
					<?php if (!$_smarty_tpl->tpl_vars['mobile_device']->value){?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
img/CVC.png" alt="<?php echo smartyTranslate(array('s'=>'Where is the CVC number?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" class="thickbox shown" rel="shadowbox">
						<img style="vertical-align:middle" src="/img/admin/help.png" width="16" height="16" alt="<?php echo smartyTranslate(array('s'=>'Where is the CVC number?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
"/>
					</a>
					<?php }?>
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireIssuer']->value){?>
				<p class="required text">
					<label for="card[issuer]">
						<?php echo smartyTranslate(array('s'=>'Card issuer','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredIssuer']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<select name="card[issuer]">
						<option value="" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['issuer'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['issuer']==''){?>selected="selected"<?php }?><?php }?>></option>
						<?php  $_smarty_tpl->tpl_vars['issuer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['issuer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['issuers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['issuer']->key => $_smarty_tpl->tpl_vars['issuer']->value){
$_smarty_tpl->tpl_vars['issuer']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['issuer']->value['authorized']){?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['issuer']->value['name'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['issuer'])){?><?php if (($_smarty_tpl->tpl_vars['card']->value['issuer']==$_smarty_tpl->tpl_vars['issuer']->value['name'])){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->tpl_vars['issuer']->value['name'];?>
</option>
						<?php }?>
						<?php } ?>
					</select>
				</p>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['requireExpiration']->value){?>
				<p class="required text">
					<label>
						<?php echo smartyTranslate(array('s'=>'Card expiry date','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['requiredExpiration']->value){?>
							<sup>*</sup>
						<?php }?>
					</label>
					<select name="card[mes_caducidad]">
						<option value="" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']==''){?>selected="selected"<?php }?><?php }?>></option>
						<option value="01" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='01'){?>selected="selected"<?php }?><?php }?>>01</option>
						<option value="02" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='02'){?>selected="selected"<?php }?><?php }?>>02</option>
						<option value="03" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='03'){?>selected="selected"<?php }?><?php }?>>03</option>
						<option value="04" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='04'){?>selected="selected"<?php }?><?php }?>>04</option>
						<option value="05" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='05'){?>selected="selected"<?php }?><?php }?>>05</option>
						<option value="06" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='06'){?>selected="selected"<?php }?><?php }?>>06</option>
						<option value="07" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='07'){?>selected="selected"<?php }?><?php }?>>07</option>
						<option value="08" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='08'){?>selected="selected"<?php }?><?php }?>>08</option>
						<option value="09" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='09'){?>selected="selected"<?php }?><?php }?>>09</option>
						<option value="10" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='10'){?>selected="selected"<?php }?><?php }?>>10</option>
						<option value="11" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='11'){?>selected="selected"<?php }?><?php }?>>11</option>
						<option value="12" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['mes_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['mes_caducidad']=='12'){?>selected="selected"<?php }?><?php }?>>12</option>
					</select>
					<select name="card[ano_caducidad]" width="150px">
						<option value=""  <?php if (isset($_smarty_tpl->tpl_vars['card']->value['ano_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['ano_caducidad']==''){?> selected="selected"<?php }?><?php }?>></option>
						
						<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (smarty_modifier_date_format(time(),"%Y"))+5+1 - (smarty_modifier_date_format(time(),"%Y")) : smarty_modifier_date_format(time(),"%Y")-((smarty_modifier_date_format(time(),"%Y"))+5)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = smarty_modifier_date_format(time(),"%Y"), $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['card']->value['ano_caducidad'])){?><?php if ($_smarty_tpl->tpl_vars['card']->value['ano_caducidad']==$_smarty_tpl->tpl_vars['i']->value){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
						<?php }} ?>
					</select>
				</p>
				<?php }?>

				<br />
				<b><?php echo smartyTranslate(array('s'=>'Confirm your order of','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <b class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['total']->value,'currency'=>$_smarty_tpl->tpl_vars['currency']->value),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'by clicking the button "Confirm my order":','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</b>
				<p class="cart_navigation" id="buttons" style="padding-bottom: 0px">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,"step=3");?>
" class="button_large hideOnSubmit"><?php echo smartyTranslate(array('s'=>'Other payment methods','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</a>
					<input type="submit" name="paymentSubmit" value="<?php echo smartyTranslate(array('s'=>'Confirm my order','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" class="exclusive hideOnSubmit" onclick="procesando();" />
				</p>
				<p id="procesando" style="text-align:center;font-weight:bold;display:none;margin:20px 0 0 0;"><i><?php echo smartyTranslate(array('s'=>'Processing...','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</i>&nbsp;&nbsp;&nbsp;<img src="/img/loadingAnimation.gif" width="208" height="13" vertical-align="middle" />
			</div>

		</fieldset>
	</form>
<?php }?><?php }} ?>