<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 15:31:08
         compiled from "C:\wamp\www\fp-v1\modules\creditcardofflinepayment\views\templates\hook\admin_form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1770751e93f9cca2c23-77701326%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bbf6d1efbb1128441422580b086814806657c2f1' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\creditcardofflinepayment\\views\\templates\\hook\\admin_form.tpl',
      1 => 1374240595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1770751e93f9cca2c23-77701326',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'displayName' => 0,
    'errors' => 0,
    'error' => 0,
    'success' => 0,
    'workingMode' => 0,
    'this_path' => 0,
    'adminMail' => 0,
    'deleteInfo' => 0,
    'states' => 0,
    'state' => 0,
    'id_os_initial' => 0,
    'requireIssuerName' => 0,
    'requiredIssuerName' => 0,
    'requireCedule' => 0,
    'requiredCedule' => 0,
    'requireAddress' => 0,
    'requiredAddress' => 0,
    'requireZipCode' => 0,
    'requiredZipCode' => 0,
    'requireCardNumber' => 0,
    'requiredCardNumber' => 0,
    'requireCVC' => 0,
    'requiredCVC' => 0,
    'requireExpiration' => 0,
    'requiredExpiration' => 0,
    'requireIssuer' => 0,
    'requiredIssuer' => 0,
    'issuers' => 0,
    'issuer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e93f9d09f574_10065909',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e93f9d09f574_10065909')) {function content_51e93f9d09f574_10065909($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?><!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->
<script type="text/javascript">

function showWM(value) {
	if (value == '1')
	{
		document.getElementById('bymail').style.display = '';
		document.getElementById('mail').style.display = '';
		document.getElementById('maillabel').style.display = '';
		document.getElementById('indatabase').style.display = 'none';
	}
	else
	{
		document.getElementById('bymail').style.display = 'none';
		document.getElementById('mail').style.display = 'none';
		document.getElementById('maillabel').style.display = 'none';
		document.getElementById('indatabase').style.display = '';
	}
}

</script>
<h2><?php echo $_smarty_tpl->tpl_vars['displayName']->value;?>
 - <?php echo smartyTranslate(array('s'=>'Configuration','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</h2>

<?php if (count($_smarty_tpl->tpl_vars['errors']->value)>0){?>
	<div class="alert error">
		<h3><?php echo smartyTranslate(array('s'=>'There are errors:','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</h3>
		<ol>
			<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
				<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
			<?php } ?>
		</ol>
	</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['success']->value){?>
	<?php echo $_smarty_tpl->tpl_vars['success']->value;?>

<?php }?>

<br />
<div style="clear: both"></div>

<form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="post" class="half_form">
	
	<fieldset>
		<legend>
			<img src="../img/admin/edit.gif" />
			<?php echo smartyTranslate(array('s'=>'Module configuration','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

		</legend>

		<label><?php echo smartyTranslate(array('s'=>'Working mode','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" onchange="javascript:showWM('1')" name="workingMode" value="1" <?php if ($_smarty_tpl->tpl_vars['workingMode']->value==1){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Send info by email','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>
			<input type="radio" onchange="javascript:showWM('2')" name="workingMode" value="2" <?php if ($_smarty_tpl->tpl_vars['workingMode']->value==2){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Store in database','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>
			<br />
			<span><?php echo smartyTranslate(array('s'=>'- If you set "Send info by email", part of the credit card number will be stored in database and the other half sent by email. You will have to match information received from email with the one from Backoffice. This way you also follow','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
 <a href="https://www.pcisecuritystandards.org/security_standards/" target="_blank">PCI DSS</a> <?php echo smartyTranslate(array('s'=>'law.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
			<br />
			<span><?php echo smartyTranslate(array('s'=>'- If you set "Store in database", whole credit card number will be stored in database and you will be able to check it from BackOffice. You can delete the card info afterwards.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
			<br /><br />
			<span><b><?php echo smartyTranslate(array('s'=>'How you will see the credit card info:','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</b></span>
			<div id="bymail"><img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
img/bymail.png" /></div>
			<div id="indatabase"><img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
img/indatabase.png" /></div>
		</div>

		<label id="maillabel"><?php echo smartyTranslate(array('s'=>'Mail address','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div id="mail" class="margin-form">
			<input type="text" name="adminMail" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['adminMail']->value, 'htmlall', 'UTF-8');?>
" size="35"/>
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Mail address where credit card information will be sent if you select "Send info by email" working mode','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>	

		<label><?php echo smartyTranslate(array('s'=>'Delete credit card info when the status change','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="checkbox" name="deleteInfo" <?php if ($_smarty_tpl->tpl_vars['deleteInfo']->value){?>checked="checked"<?php }?> />
			<br />
			<span><?php echo smartyTranslate(array('s'=>'If enabled, the credit card data stored in database will be deleted automatically when you change an order from its initial status.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Order initial status','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">			
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<th style="width: 200px;font-weight: bold;"><?php echo smartyTranslate(array('s'=>'Status name','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['state']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['states']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value){
$_smarty_tpl->tpl_vars['state']->_loop = true;
?>
					<tr style="background-color: <?php echo $_smarty_tpl->tpl_vars['state']->value['color'];?>
;">
						<td><?php echo $_smarty_tpl->tpl_vars['state']->value['name'];?>
</td>
						<td style="text-align:center"><input type="radio" name="id_os_initial" <?php if ($_smarty_tpl->tpl_vars['state']->value['id_order_state']==$_smarty_tpl->tpl_vars['id_os_initial']->value){?>checked="checked"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['state']->value['id_order_state'];?>
"/></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<span><?php echo smartyTranslate(array('s'=>'When a customer choose this payment method, the order will be left in this status.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>
	</fieldset>
	
	<div style="clear: both"></div>

	<br/>

	<fieldset>
		<legend>
			<img src="../img/admin/cog.gif" />
			<?php echo smartyTranslate(array('s'=>'Credit card configuration','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:
		</legend>

		<label><?php echo smartyTranslate(array('s'=>'Request for Card Holder Name?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireIssuerName" value="1" <?php if ($_smarty_tpl->tpl_vars['requireIssuerName']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireIssuerName" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireIssuerName']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredIssuerName" <?php if ($_smarty_tpl->tpl_vars['requiredIssuerName']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers must enter their name.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request for ID Card/Passport?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireCedule" value="1" <?php if ($_smarty_tpl->tpl_vars['requireCedule']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCedule" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireCedule']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCedule" <?php if ($_smarty_tpl->tpl_vars['requiredCedule']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers must enter their identifity card.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request for address?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireAddress" value="1" <?php if ($_smarty_tpl->tpl_vars['requireAddress']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireAddress" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireAddress']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredAddress" <?php if ($_smarty_tpl->tpl_vars['requiredAddress']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers should enter an address.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request for zip code?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireZipCode" value="1" <?php if ($_smarty_tpl->tpl_vars['requireZipCode']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireZipCode" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireZipCode']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredZipCode" <?php if ($_smarty_tpl->tpl_vars['requiredZipCode']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customer should enter a zip code.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request for credit card number?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireCardNumber" value="1" <?php if ($_smarty_tpl->tpl_vars['requireCardNumber']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCardNumber" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireCardNumber']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCardNumber" <?php if ($_smarty_tpl->tpl_vars['requiredCardNumber']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers should enter their credit card number.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request CVC number?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireCVC" value="1" <?php if ($_smarty_tpl->tpl_vars['requireCVC']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCVC" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireCVC']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCVC" <?php if ($_smarty_tpl->tpl_vars['requiredCVC']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers should enter the card CVC number.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>		
		
		<label><?php echo smartyTranslate(array('s'=>'Request for credit card expiration date?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireExpiration" value="1" <?php if ($_smarty_tpl->tpl_vars['requireExpiration']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireExpiration" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireExpiration']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredExpiration" <?php if ($_smarty_tpl->tpl_vars['requiredExpiration']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers should enter month and year card expiration.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Request card issuer?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>
		<div class="margin-form">
			<input type="radio" name="requireIssuer" value="1" <?php if ($_smarty_tpl->tpl_vars['requireIssuer']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireIssuer" value="0" <?php if (!$_smarty_tpl->tpl_vars['requireIssuer']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<img title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredIssuer" <?php if ($_smarty_tpl->tpl_vars['requiredIssuer']->value){?>checked="checked"<?php }?> />
			<label class="t">
				<?php echo smartyTranslate(array('s'=>'Required','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

			</label>			
			<br />
			<span><?php echo smartyTranslate(array('s'=>'Customers should introduce the card issuer.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>

		<label><?php echo smartyTranslate(array('s'=>'Card issuers','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
:</label>

		<div class="margin-form">
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<th style="width: 200px;font-weight: bold;"><?php echo smartyTranslate(array('s'=>'Card issuer','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</th>
						<th><?php echo smartyTranslate(array('s'=>'Enabled?','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars['issuer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['issuer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['issuers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['issuer']->key => $_smarty_tpl->tpl_vars['issuer']->value){
$_smarty_tpl->tpl_vars['issuer']->_loop = true;
?>
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['issuer']->value['name'];?>
</td>
						<td style="text-align: center;"><input type="checkbox" name="issuers[]" value="<?php echo $_smarty_tpl->tpl_vars['issuer']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['issuer']->value['authorized']){?>checked="checked"<?php }?> /></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<span><?php echo smartyTranslate(array('s'=>'Card issuers enabled to choose when making payment.','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>
		</div>
			

	</fieldset>	
	
	<div style="clear: both;"></div>
	<br />

	<center>
		<input type="submit" name="btnSubmit" value="<?php echo smartyTranslate(array('s'=>'Update settings','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
" class="button" />
	</center>
	<hr />
</form>

<script type="text/javascript">
	javascript:showWM('<?php echo $_smarty_tpl->tpl_vars['workingMode']->value;?>
');
</script><?php }} ?>