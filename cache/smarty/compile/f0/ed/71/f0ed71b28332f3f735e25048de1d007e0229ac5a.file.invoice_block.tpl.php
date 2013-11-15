<?php /* Smarty version Smarty-3.1.13, created on 2013-11-05 16:54:20
         compiled from "C:\wamp\www\fp-v1\modules\creditcardofflinepayment\views\templates\hook\invoice_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:839525fb2fe8edda0-12540199%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0ed71b28332f3f735e25048de1d007e0229ac5a' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\creditcardofflinepayment\\views\\templates\\hook\\invoice_block.tpl',
      1 => 1383666858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '839525fb2fe8edda0-12540199',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525fb2ff1fca36_96955090',
  'variables' => 
  array (
    'id_order' => 0,
    'token' => 0,
    'this_path' => 0,
    'nombre_titular' => 0,
    'cedula' => 0,
    'direccion' => 0,
    'tipo_tarjeta' => 0,
    'cp' => 0,
    'pan' => 0,
    'mes_caducidad' => 0,
    'ano_caducidad' => 0,
    'cvc' => 0,
    'importe' => 0,
    'moneda' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525fb2ff1fca36_96955090')) {function content_525fb2ff1fca36_96955090($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
if (!is_callable('smarty_modifier_spacify')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.spacify.php';
?><!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<script type="text/javascript">
	//when document is loaded...
	$(document).ready(function(){
		/*if (typeof baseUri === "undefined" && typeof baseDir !== "undefined")
		baseUri = baseDir;*/
		//Function to delete credit card data from order
		$('#deleteInfo').click(function(){
			$.ajax({
				type: 'POST',
				url: '../modules/creditcardofflinepayment/creditcardofflinepaymentfunctions.php',
				async: true,
				cache: false,
				dataType : "json",
				data: 'id_order=' + '<?php echo $_smarty_tpl->tpl_vars['id_order']->value;?>
' + '&token=' + '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
',
				success: function() {$('#invoice_block').hide();},
				error: function(data) {alert('ERROR: unable to delete the info' + data);}
			})
		})
	});
</script>


<br />
<fieldset id="invoice_block" <?php if (version_compare(@constant('_PS_VERSION_'),'1.5','<')){?>style="width:400px"<?php }?>>
    <legend>
    	<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
logo.gif"/> <?php echo smartyTranslate(array('s'=>'Credit card payment information','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>

    </legend>
	<div style="float:left">
		<?php if (isset($_smarty_tpl->tpl_vars['nombre_titular']->value)&&$_smarty_tpl->tpl_vars['nombre_titular']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Card holder name','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['nombre_titular']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['cedula']->value)&&$_smarty_tpl->tpl_vars['cedula']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'ID Card/Passport','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cedula']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['direccion']->value)&&$_smarty_tpl->tpl_vars['direccion']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Address','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['direccion']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tipo_tarjeta']->value)&&$_smarty_tpl->tpl_vars['tipo_tarjeta']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Card holder issuer','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['tipo_tarjeta']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['cp']->value)&&$_smarty_tpl->tpl_vars['cp']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Zip Code','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cp']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['pan']->value)&&$_smarty_tpl->tpl_vars['pan']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Credit card number','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <span style="color:red; background-image:url(http://www.fontenille-pataud.com/img/cms/Back%20office/background-cb%20copie_5.jpg);"><b><?php echo smarty_modifier_spacify($_smarty_tpl->tpl_vars['pan']->value);?>
</b></span><br/>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['mes_caducidad']->value)&&$_smarty_tpl->tpl_vars['mes_caducidad']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Expiry Month/Year','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['mes_caducidad']->value, 'htmlall', 'UTF-8');?>
/<?php if (isset($_smarty_tpl->tpl_vars['ano_caducidad']->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['ano_caducidad']->value, 'htmlall', 'UTF-8');?>
<?php }?></b></br>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['cvc']->value)&&$_smarty_tpl->tpl_vars['cvc']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'CVC','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cvc']->value, 'htmlall', 'UTF-8');?>
</b></br>
		<?php }?>
		
		
		
		<?php if (isset($_smarty_tpl->tpl_vars['importe']->value)&&$_smarty_tpl->tpl_vars['importe']->value!=''){?>
			<?php echo smartyTranslate(array('s'=>'Amount','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
: <b><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['importe']->value, 'htmlall', 'UTF-8');?>
 <?php if (isset($_smarty_tpl->tpl_vars['moneda']->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['moneda']->value, 'htmlall', 'UTF-8');?>
<?php }?></b></br>
		<?php }?>
	</div>
	<div style="float:right;cursor:pointer" id="deleteInfo">
		<img src="../img/admin/disabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
">
		<span><?php echo smartyTranslate(array('s'=>'Delete info','mod'=>'creditcardofflinepayment'),$_smarty_tpl);?>
</span>		
	</div>
</fieldset><?php }} ?>