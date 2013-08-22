<?php /* Smarty version Smarty-3.1.13, created on 2013-08-22 15:27:07
         compiled from "C:\wamp\www\fp-v1\modules\attributewizardpro\attributewizardpro.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30922521611ab8c7ca3-50876558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96dafc33662f979d6f670c65a1f789cdb70e1a55' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\attributewizardpro\\attributewizardpro.tpl',
      1 => 1375351752,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30922521611ab8c7ca3-50876558',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'groups' => 0,
    'this_wizard_path' => 0,
    'awp_product_image' => 0,
    'awp_converted_price' => 0,
    'awp_no_tax_impact' => 0,
    'awp_psv' => 0,
    'awp_psv3' => 0,
    'awp_stock' => 0,
    'awp_reload_page' => 0,
    'awp_display_qty' => 0,
    'awp_ajax' => 0,
    'awp_is_edit' => 0,
    'awp_qty_edit' => 0,
    'awp_popup_top' => 0,
    'awp_adc_no_attribute' => 0,
    'awp_popup' => 0,
    'awp_pi_display' => 0,
    'awp_currency' => 0,
    'awp_no_customize' => 0,
    'attributeImpacts' => 0,
    'attributeImpact' => 0,
    'awp_fade' => 0,
    'awp_opacity_fraction' => 0,
    'awp_opacity' => 0,
    'awp_popup_width' => 0,
    'product' => 0,
    'awp_ins' => 0,
    'awp_ipa' => 0,
    'awp_add_to_cart' => 0,
    'awp_second_add' => 0,
    'group' => 0,
    'default_impact' => 0,
    'group_attribute' => 0,
    'id_attribute' => 0,
    'col_img_dir' => 0,
    'img_col_dir' => 0,
    'awp_out_of_stock' => 0,
    'awp_pi' => 0,
    'awp_edit_special_values' => 0,
    'id_attribute_file' => 0,
    'img_dir' => 0,
    'awp_currency_rate' => 0,
    'converted' => 0,
    'awp_last_select' => 0,
    'awp_popup_left' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521611adce93d0_17737439',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521611adce93d0_17737439')) {function content_521611adce93d0_17737439($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
if (!is_callable('smarty_function_math')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\function.math.php';
?><!-- MODULE Attribute Wizard Pro-->
<?php if (isset($_smarty_tpl->tpl_vars['groups']->value)){?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['this_wizard_path']->value;?>
js/ajaxupload.js"></script>
<script type="text/javascript">
<?php if (isset($_smarty_tpl->tpl_vars['awp_product_image']->value)&&'awp_popup'){?>
	var awp_layered_img_id = 'awp_product_image';
<?php }else{ ?> 
	var awp_layered_img_id = 'bigpic';
<?php }?>
awp_selected_attribute = "";
awp_selected_group = "";
var awp_converted_price = <?php echo $_smarty_tpl->tpl_vars['awp_converted_price']->value;?>
;
var awp_tmp_arr = new Array()
productHasAttributes = false;
$('#quantityAvailable').css('display','none');
var awp_no_tax_impact = <?php if ($_smarty_tpl->tpl_vars['awp_no_tax_impact']->value){?>true<?php }else{ ?>false<?php }?>;
var awp_psv = "<?php echo $_smarty_tpl->tpl_vars['awp_psv']->value;?>
";
var awp_psv3 = "<?php echo $_smarty_tpl->tpl_vars['awp_psv3']->value;?>
";
var awp_stock = "<?php echo $_smarty_tpl->tpl_vars['awp_stock']->value;?>
";
var awp_reload_page = "<?php echo $_smarty_tpl->tpl_vars['awp_reload_page']->value;?>
";
var awp_display_qty = <?php if ($_smarty_tpl->tpl_vars['awp_display_qty']->value){?>true<?php }else{ ?>false<?php }?>;
$('#availability_statut').css('display','none');
$('#quantityAvailable').css('display','none');
$('#quantityAvailableTxt').css('display','none');
$('#quantityAvailableTxtMultiple').css('display','none');
$('#last_quantities').css('display','none');
<?php if ($_smarty_tpl->tpl_vars['awp_ajax']->value){?>
	var awp_ajax = true;
<?php }else{ ?>
	var awp_ajax = false;
<?php }?>

$(document).ready(function(){
	if (typeof ajaxCart == 'undefined')
		awp_ajax = false;
	if (awp_is_quantity_group.length > 0)
	{
		$("#quantity_wanted_p").css('display','none');
		
		$("div.awp_quantity_additional").css('display', 'none');
	}
	else
	{
		$("#quantity_wanted_p").css('display','block');
	}
	$('#quantity_wanted').keyup(function() {
		if ($('#awp_q1').length)
			$('#awp_q1').val($('#quantity_wanted').val());
		if ($('#awp_q2').length)
			$('#awp_q2').val($('#quantity_wanted').val());
	});
	<?php if ($_smarty_tpl->tpl_vars['awp_is_edit']->value){?>
		<?php if ($_smarty_tpl->tpl_vars['awp_qty_edit']->value>0){?>
			$('#quantity_wanted').val('<?php echo $_smarty_tpl->tpl_vars['awp_qty_edit']->value;?>
');
			if ($('#awp_q1').length)
				$('#awp_q1').val($('#quantity_wanted').val());
			if ($('#awp_q2').length)
				$('#awp_q2').val($('#quantity_wanted').val());
		<?php }?>
		if (!$('#awp_edit').length)
		{
			$('#awp_add_to_cart').before('<p class="buttons_bottom_block" id="awp_edit"><input type="button" class="exclusive awp_edit" value="<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" name="Submit"  onclick="$(this).attr(\'disabled\', true);$(\'.awp_edit\').fadeOut();awp_add_to_cart(true);" /></p>');
		}
	<?php }?>
});

function awp_do_customize()
{
	$('#awp_add_to_cart input').val(awp_customize);
	$('#awp_add_to_cart').show();
	$('#awp_add_to_cart input').unbind('click').click(function(){
		awp_do_popup();
		return false;
	});
}

function awp_do_popup()
{
	$("#awp_background").fadeIn(1000);
	$("#awp_container").fadeIn(1000);
	var awp_popup_height = Math.max($("#product").height(), $("#awp_container").height()) + parseInt(<?php echo $_smarty_tpl->tpl_vars['awp_popup_top']->value;?>
);
	$("#awp_background").css('height', awp_popup_height+'px');
	$('#awp_add_to_cart input').val(awp_add_cart);
	$('#awp_add_to_cart input').unbind('click').click(function(){
		$('#awp_add_to_cart input').attr('disabled', 'disabled');
		awp_add_to_cart();
		awp_customize_func();
		$('#awp_add_to_cart input').attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);
		return false;
	});
}

var awp_customize = "<?php echo smartyTranslate(array('s'=>'Customize Product','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_add_cart = "<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_add = "<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_sub = "<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_minimal_1 = "<?php echo smartyTranslate(array('s'=>'(Min:','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_minimal_2 = "<?php echo smartyTranslate(array('s'=>')','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_min_qty_text = "<?php echo smartyTranslate(array('s'=>'The minimum quantity for this product is','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_ext_err = "<?php echo smartyTranslate(array('s'=>'Error: invalid file extension, use only ','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_adc_no_attribute = <?php if ($_smarty_tpl->tpl_vars['awp_adc_no_attribute']->value){?>true<?php }else{ ?>false<?php }?>;
var awp_popup = <?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>true<?php }else{ ?>false<?php }?>;
var awp_pi_display = '<?php echo $_smarty_tpl->tpl_vars['awp_pi_display']->value;?>
';
var awp_currency = <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
;
var awp_is_required = "<?php echo smartyTranslate(array('s'=>'is a required field!','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_select_attributes = "<?php echo smartyTranslate(array('s'=>'You must select at least 1 product option','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
var awp_oos_alert = "<?php echo smartyTranslate(array('s'=>'This combination is out of stock, please choose another','mod'=>'attributewizardpro','js'=>1),$_smarty_tpl);?>
";
$('#color_picker').attr({id:'awp_color_picker'});
$('#awp_color_picker').css('display','none');
<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
	<?php if ($_smarty_tpl->tpl_vars['awp_is_edit']->value){?>
		$(document).ready(function () {
		$('#add_to_cart').attr({'id':'awp_add_to_cart'});
		awp_do_popup();
		});
	<?php }else{ ?>
		$('#add_to_cart').attr({'id':'awp_add_to_cart'});
		awp_do_customize();
	<?php }?>
<?php }else{ ?>
	$('#add_to_cart').attr({'id':'awp_add_to_cart'});
	<?php if ($_smarty_tpl->tpl_vars['awp_no_customize']->value=='1'){?>
		$('#awp_add_to_cart').show();
		$('#awp_add_to_cart input').unbind('click').click(function(){
			$('#awp_add_to_cart input').attr('disabled', 'disabled');
			awp_add_to_cart();
			$('#awp_add_to_cart input').attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);
			return false;
		});
	<?php }else{ ?>
		if ($('#awp_add_to_cart a').length)
		{
			$('#awp_add_to_cart a').html(awp_customize);
			$('#awp_add_to_cart input').hide();
		}
		else
			$('#awp_add_to_cart input').val(awp_customize);
		$('#awp_add_to_cart').show();
		$('#awp_add_to_cart input').unbind('click').click(function(){
			$.scrollTo( '#awp_container', 1200 );
			if (awp_add_to_cart_display != "bottom")
			{
				if ($('#awp_add_to_cart a').length)
				{
					$('#awp_add_to_cart a').html(awp_add_cart);
					$('#awp_add_to_cart input').hide();
				}
				else
					$('#awp_add_to_cart input').val(awp_add_cart);
				$('#awp_add_to_cart input').unbind('click').click(function(){
					$('#awp_add_to_cart input').attr('disabled', 'disabled');
					awp_add_to_cart();
					$('#awp_add_to_cart input').attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);
					return false;
				});
			}
			return false;
		});
	<?php }?>
<?php }?>

var awp_file_ext = new Array();
var awp_file_list = new Array();
var awp_required_list = new Array();
var awp_required_list_name = new Array();
var awp_qty_list = new Array();
var awp_attr_to_group = new Array();
var awp_selected_groups = new Array();
var awp_group_impact = new Array();
var awp_group_order = new Array();
var awp_group_type = new Array();
var awp_min_qty = new Array();
var awp_impact_list = new Array();
var awp_impact_only_list = new Array();
var awp_weight_list = new Array();
var awp_is_quantity_group = new Array();
var awp_hin = new Array();
var awp_multiply_list = new Array();
var awp_layered_image_list = new Array();
var awp_selected_attribute_default = false;

<?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['attributeImpact']->value['price']>0){?>awp_impact_only_list[<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute'];?>
] = '<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['price'];?>
';<?php }?>awp_min_qty[<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute'];?>
] = '<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['minimal_quantity'];?>
';awp_impact_list[<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute'];?>
] = '<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['price'];?>
';awp_weight_list[<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute'];?>
] = '<?php echo $_smarty_tpl->tpl_vars['attributeImpact']->value['weight'];?>
';<?php } ?>
if (awp_add_to_cart_display == "bottom")
{
	$("#quantity_wanted_p").attr("id","awp_quantity_wanted_p");
    $("#awp_quantity_wanted_p").css("display","none");
}
</script>
<?php if ($_smarty_tpl->tpl_vars['awp_fade']->value){?>
	<div id="awp_background" style="position: fixed; top:0;opacity:<?php echo $_smarty_tpl->tpl_vars['awp_opacity_fraction']->value;?>
;filter:alpha(opacity=<?php echo $_smarty_tpl->tpl_vars['awp_opacity']->value;?>
);left:0;width:100%;height:100%;z-index:1999;display:none;background-color:black"> </div>
<?php }?>

<div id="awp_container" <?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>style="position: absolute; z-index:2000;top:-5000px;display:block;width:<?php echo $_smarty_tpl->tpl_vars['awp_popup_width']->value;?>
px;margin:auto"<?php }?>>
	<div class="awp_box">
		<b class="xtop"><b class="xb1"></b><b class="xb2 xbtop"></b><b class="xb3 xbtop"></b><b class="xb4 xbtop"></b></b>
		<div class="awp_header">
			<b style="font-size:14px"><?php echo smartyTranslate(array('s'=>'Product Options','mod'=>'attributewizardpro'),$_smarty_tpl);?>
</b>
			<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
				<div class="awp_pop_close" style="margin: -15px 0 0 <?php echo $_smarty_tpl->tpl_vars['awp_popup_width']->value-38;?>
px">
					<img src="<?php echo $_smarty_tpl->tpl_vars['this_wizard_path']->value;?>
img/close.png" style="cursor: pointer" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
				</div>
			<?php }?>
		</div>
		<div class="awp_content">
			<?php if (isset($_smarty_tpl->tpl_vars['awp_product_image']->value)&&$_smarty_tpl->tpl_vars['awp_popup']->value){?>
				<div id="awp_product_image" style="width:<?php echo $_smarty_tpl->tpl_vars['awp_product_image']->value['width'];?>
px;height:<?php echo $_smarty_tpl->tpl_vars['awp_product_image']->value['height'];?>
px;margin:auto">
					<img src="<?php echo $_smarty_tpl->tpl_vars['awp_product_image']->value['src'];?>
"	title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value->name, 'htmlall', 'UTF-8');?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value->name, 'htmlall', 'UTF-8');?>
" id="awp_bigpic" width="<?php echo $_smarty_tpl->tpl_vars['awp_product_image']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['awp_product_image']->value['height'];?>
" />
				</div>
			<?php }?>
			<form name="awp_wizard" id="awp_wizard">
			<input type="hidden" name="awp_p_impact" id="awp_p_impact" value="" />
			<input type="hidden" name="awp_p_weight" id="awp_p_weight" value="" />
			<input type="hidden" name="awp_ins" id="awp_ins" value="<?php echo $_smarty_tpl->tpl_vars['awp_ins']->value;?>
" />
			<input type="hidden" name="awp_ipa" id="awp_ipa" value="<?php echo $_smarty_tpl->tpl_vars['awp_ipa']->value;?>
" />
			<?php if (($_smarty_tpl->tpl_vars['awp_add_to_cart']->value=="both"||$_smarty_tpl->tpl_vars['awp_add_to_cart']->value=="bottom")&&count($_smarty_tpl->tpl_vars['groups']->value)>=$_smarty_tpl->tpl_vars['awp_second_add']->value){?>
				<div class="awp_stock_container awp_sct">
					<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
						<div class="awp_stock_btn">
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Close','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="button_small" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
						</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['awp_is_edit']->value){?>
					
					<!-- MISE EN COMMENTAIRE BOUTON EDITER FICHE PRODUIT
						<div class="awp_stock_btn">
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="exclusive awp_edit" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart(true);$(this).attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);" />&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						-->
						
						
					<?php }?>
					<div class="awp_stock_btn">
						<input type="button" value="<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="exclusive" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart();<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>awp_customize_func();<?php }?>$(this).attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);" />
					</div>
					<div class="awp_quantity_additional awp_stock">
						&nbsp;&nbsp;<?php echo smartyTranslate(array('s'=>'Quantity','mod'=>'attributewizardpro'),$_smarty_tpl);?>
: <input type="text" style="width:30px;padding:0;margin:0" id="awp_q1" onkeyup="$('#quantity_wanted').val(this.value);$('#awp_q2').val(this.value);" value="1" />
						<span class="awp_minimal_text"></span>
					</div>
					<div class="awp_stock">
							&nbsp;&nbsp;<b class="price our_price_display" id="awp_second_price"></b>
					</div>
					<div id="awp_in_stock_second"></div>
				</div>
			<?php }?>
			<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attribute_group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_groups']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attribute_group']->value = $_smarty_tpl->tpl_vars['group']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_groups']['index']++;
?>
			<script type="text/javascript">awp_selected_groups[<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
] = 0;awp_group_type[<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
] = '<?php echo $_smarty_tpl->tpl_vars['group']->value['group_type'];?>
';awp_group_order[<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
] = <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['awp_groups']['index'];?>
;awp_hin[<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
] = '<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])){?><?php echo $_smarty_tpl->tpl_vars['group']->value['group_hide_name'];?>
<?php }else{ ?>0<?php }?>';<?php $_smarty_tpl->tpl_vars['default_impact'] = new Smarty_variable('', null, 0);?><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['attributeImpact']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['attributeImpact']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
 $_smarty_tpl->tpl_vars['attributeImpact']->iteration++;
 $_smarty_tpl->tpl_vars['attributeImpact']->last = $_smarty_tpl->tpl_vars['attributeImpact']->iteration === $_smarty_tpl->tpl_vars['attributeImpact']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_attributeImpact']['last'] = $_smarty_tpl->tpl_vars['attributeImpact']->last;
?><?php if ((count($_smarty_tpl->tpl_vars['group']->value['default'])>0&&in_array($_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute'],$_smarty_tpl->tpl_vars['group']->value['default']))||($_smarty_tpl->tpl_vars['awp_pi_display']->value=='diff'&&$_smarty_tpl->tpl_vars['attributeImpact']->value['price']>0&&($_smarty_tpl->tpl_vars['group']->value['group_type']=='textbox'||$_smarty_tpl->tpl_vars['group']->value['group_type']=='checkbox'||$_smarty_tpl->tpl_vars['group']->value['group_type']=='textarea'||$_smarty_tpl->tpl_vars['group']->value['group_type']=='file'))||($_smarty_tpl->tpl_vars['group']->value['group_type']=='quantity'&&$_smarty_tpl->tpl_vars['default_impact']->value==''&&$_smarty_tpl->getVariable('smarty')->value['foreach']['awp_attributeImpact']['last'])){?><?php $_smarty_tpl->tpl_vars['default_impact'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?>$(document).ready(function () {if ('<?php echo $_smarty_tpl->tpl_vars['awp_pi_display']->value;?>
' != 'diff' || awp_attr_to_group[<?php echo intval($_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']);?>
] == <?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
){awp_selected_attribute = <?php echo intval($_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']);?>
;/*alert (awp_selected_attribute);*/awp_selected_group = <?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
;$('.awp_box .awp_attribute_selected').each(function(){if (($(this).attr('type') != 'radio' || $(this).attr('checked')) &&($(this).attr('type') != 'checkbox' || $(this).attr('checked')) &&($(this).attr('type') != 'text' || $(this).val() != "0") && $(this).val() != ""){awp_tmp_arr = $(this).attr('name').split('_');if (awp_selected_group == awp_tmp_arr[2]){if (awp_group_type[awp_tmp_arr[2]] != "quantity" && awp_tmp_arr.length == 4 && awp_tmp_arr[3] != awp_selected_attribute)awp_selected_attribute = awp_tmp_arr[3];else if (awp_group_type[awp_tmp_arr[2]] != "quantity" && awp_group_type[awp_tmp_arr[2]] != "textbox" &&awp_group_type[awp_tmp_arr[2]] != "textarea" && awp_group_type[awp_tmp_arr[2]] != "file" &&awp_group_type[awp_tmp_arr[2]] != "calculation" && awp_selected_attribute != $(this).val())awp_selected_attribute = $(this).val();}}});awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
', awp_selected_attribute, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, true);awp_selected_attribute_default = awp_selected_attribute;};});<?php $_smarty_tpl->tpl_vars['awp_last_select'] = new Smarty_variable('awp_select_image(awp_selected_attribute_default);', null, 0);?><?php }?>
				<?php } ?>
				<?php if ($_smarty_tpl->tpl_vars['default_impact']->value==''){?>
					<?php $_smarty_tpl->tpl_vars['default_impact'] = new Smarty_variable(0, null, 0);?>
				<?php }?>
				<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
?>
				<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_required'])&&$_smarty_tpl->tpl_vars['group']->value['group_required']){?>awp_required_list[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = 1;<?php }else{ ?>awp_required_list[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = 0;<?php }?>awp_layered_image_list[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = '<?php echo AttributeWizardPro::getLayeredImageTag(array('id_attribute'=>$_smarty_tpl->tpl_vars['id_attribute']->value,'v'=>$_smarty_tpl->tpl_vars['group_attribute']->value[3]),$_smarty_tpl);?>
';<?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="file"){?>awp_file_list.push(<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
);awp_file_ext.push(/^(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_file_ext'];?>
)$/);<?php }?>awp_multiply_list[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = '<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_calc_multiply'])){?><?php echo $_smarty_tpl->tpl_vars['group']->value['group_calc_multiply'];?>
<?php }?>';awp_qty_list[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = '<?php echo $_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value];?>
';awp_required_list_name[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
';awp_attr_to_group[<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
] = '<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
';
				<?php } ?>
				</script>
				<div class="awp_group_image_container">
					<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_url'])&&$_smarty_tpl->tpl_vars['group']->value['group_url']){?><a href="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_url'];?>
" target="_blank" alt="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_url'];?>
"><?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['image_upload'])){?><?php echo AttributeWizardPro::getGroupImageTag(array('id_group'=>$_smarty_tpl->tpl_vars['group']->value['id_group'],'alt'=>smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['name'], 'htmlall', 'UTF-8'),'v'=>$_smarty_tpl->tpl_vars['group']->value['image_upload']),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_url'])&&$_smarty_tpl->tpl_vars['group']->value['group_url']){?></a><?php }?><?php }?>
				</div>
				<div class="awp_box awp_box_inner">
					<b class="xtop"><b class="xb1"></b><b class="xb2 xbtop"></b><b class="xb3 xbtop"></b><b class="xb4 xbtop"></b></b>
					<div class="awp_header">
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_header'])&&$_smarty_tpl->tpl_vars['group']->value['group_header']){?>
							<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['group_header'], 'htmlspecialchars', 'UTF-8');?>

						<?php }else{ ?>
							<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['name'], 'htmlspecialchars', 'UTF-8');?>

						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_description'])&&$_smarty_tpl->tpl_vars['group']->value['group_description']!=''){?>
							
							<!--  MISE EN COMMENTAITE DE LA DIV POUR AFFICHER TITRE ET DESCRIPTION SUR MEME LIGNE
							<div class="awp_description">
							-->
							
								<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group']->value['group_description'], 'htmlspecialchars', 'UTF-8');?>

							
							<!--
							</div>
							-->
							
							
						<?php }?>
					</div>
					<div class="awp_content">
					<?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="dropdown"){?>
	               		<div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 awp_clear">
    						<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']==1){?>
								<div id="awp_select_colors_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>class="awp_left"<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])&&$_smarty_tpl->tpl_vars['group']->value['group_width']){?>style="width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?>>
									<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
?>
									<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_group_div_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>display:<?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?>block<?php }else{ ?>none<?php }?>;"><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_resize'])&&$_smarty_tpl->tpl_vars['group']->value['group_resize']&&isset($_smarty_tpl->tpl_vars['group']->value['group_width'])&&$_smarty_tpl->tpl_vars['group']->value['group_width']){?>style="width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }else{ ?><div id="awp_group_div_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;display:<?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?>block<?php }else{ ?>none<?php }?>;"></div><?php }?>
          							<?php } ?>
           						</div>
   							<?php }?>
   							<div id="awp_sel_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_sel_conth<?php }else{ ?>awp_sel_contv<?php }?>">
	                   			<select class="awp_attribute_selected" onmousedown="if($.browser.msie){this.style.width='auto'}" onblur="this.style.position='';" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" onchange="awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
', this.options[this.selectedIndex].value, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
,false);this.style.position='';$('#awp_select_colors_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 div').each(function() {$(this).css('display','none')});$('#awp_group_div_'+this.value).fadeIn(1000);">
								<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
?>
								<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><option value="<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0){?><?php if ($_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?> class="awp_oos"<?php }?><?php if ($_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?> disabled="disabled"<?php }?><?php }?> <?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?>selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
<?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['attributeImpact']->value['price'],'y'=>$_smarty_tpl->tpl_vars['default_impact']->value,'assign'=>'awp_pi'),$_smarty_tpl);?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?><?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }?><?php }?><?php } ?></option>
                    			<?php } ?>
                   				</select>
							</div>
           					<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>
		           				<script type="text/javascript">
		           				$("#awp_sel_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               					</script>
           					<?php }?>
						</div>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="radio"||$_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['iteration']%$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1||$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?> style="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']!=1){?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?><?php }?>" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]>0||$_smarty_tpl->tpl_vars['awp_out_of_stock']->value!='disable'){?>onclick="$('#awp_radio_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
').attr('checked','checked');<?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?>awp_toggle_img(<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
);<?php }?>awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, false)<?php }?>"><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><div id="awp_radio_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_rrla<?php }else{ ?>awp_rrca<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?> awp_none<?php }?>"><input type="radio" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> class="awp_attribute_selected awp_clean" id="awp_radio_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
" <?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?>checked="checked"<?php }?> />&nbsp;<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['first']){?><input type="hidden" name="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['default_impact']->value;?>
" /><?php }?></div><div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
</div><?php }?><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->tpl_vars['attributeImpact']->value['price'],'y'=>$_smarty_tpl->tpl_vars['default_impact']->value,'assign'=>'awp_pi'),$_smarty_tpl);?>
<div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }else{ ?>&nbsp;<?php }?></div><?php }?><?php } ?></div><script type="text/javascript">$(document).ready(function() {awp_center_images(<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
);});<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>$("#awp_radio_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);<?php }?></script></div></div>                    		
						<?php } ?>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="textbox"){?>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?>
							<script type="text/javascript">
								var awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 = 0;
							</script>
						<?php }?>
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['iteration']%$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1||$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?>><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div id="awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_text_length_group awp_text_length_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>" ><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
&nbsp;</div><?php }?><div id="awp_textbox_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><input type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value])){?><?php echo $_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value];?>
<?php }?>" style="margin:0;padding:0;<?php if ($_smarty_tpl->tpl_vars['group']->value['group_width']){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?>" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> class="awp_attribute_selected awp_group_class_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="awp_textbox_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" onkeyup="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?>awp_max_limit_check('<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
',<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
);<?php }?>awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, false);" onblur="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?>awp_max_limit_check('<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
',<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
);<?php }?>awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, false);" />&nbsp;<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['first']){?><input type="hidden" name="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['default_impact']->value;?>
" /><?php }?></div><!-- MISE EN COMMENTAIRE AJOUT X € A DROITE BOITE TEXTE GRAVURE<div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php $_smarty_tpl->tpl_vars['awp_pi'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value!=''){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"><?php }else{ ?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" style="display:none"></div><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php }?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }?></div><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_required'])&&$_smarty_tpl->tpl_vars['group']->value['group_required']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?> awp_red">* <?php echo smartyTranslate(array('s'=>'Required','mod'=>'attributewizardpro'),$_smarty_tpl);?>
</div><?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?> awp_red"><?php echo smartyTranslate(array('s'=>'Characters left:','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <span id="awp_max_limit_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_max_limit" awp_limit="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
</span></div><?php }?><?php }?>
   	              						<?php } ?>
               						</div>      -->
									
									
       								<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>
		           						<script type="text/javascript">
           								$("#awp_textbox_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
          								$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
	              						$("#awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
           								</script>
       								<?php }?>
               					</div>
               					<?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?>
               						<script type="text/javascript">
               							awp_max_limit_check('<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
',<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
);
	                  				</script>
               					<?php }?>
               				</div>
                  		
						<?php } ?>
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?>
							<script type="text/javascript">
							$(document).ready(function (){
							<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
								$('#awp_container').show();
							<?php }?>
							$('.awp_text_length_group').each(function () {
								awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 = Math.max(awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
, $(this).width());
							});
							$('.awp_text_length_group').width(awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
);
							<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
								$('#awp_container').hide();
							<?php }?>
						});
						</script>
						<?php }?>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="textarea"){?>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?>
							<script type="text/javascript">
								var awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 = 0;
							</script>
						<?php }?>
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?> style="width:100%"><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!'awp_popup'){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div id="awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_text_length_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
&nbsp;</div><script type="text/javascript">awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 = Math.max(awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
, $('#awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
').width());</script><?php }?><div id="awp_textarea_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><textarea <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> style="margin:0;padding:0;<?php if ($_smarty_tpl->tpl_vars['group']->value['group_width']){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_height']){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>" class="awp_attribute_selected awp_group_class_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="awp_textarea_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" onkeyup="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?>awp_max_limit_check('<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
',<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
);<?php }?>awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, false);" onblur="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?>awp_max_limit_check('<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
',<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
);<?php }?>awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
, false);"><?php if (isset($_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value])){?><?php echo $_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value];?>
<?php }?></textarea>&nbsp;<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['first']){?><input type="hidden" name="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['default_impact']->value;?>
" /><?php }?></div><div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php $_smarty_tpl->tpl_vars['awp_pi'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value!=''){?><div id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php }else{ ?><div id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" style="display:none"></div><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php }?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }?></div><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_required'])&&$_smarty_tpl->tpl_vars['group']->value['group_required']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?> awp_red">* <?php echo smartyTranslate(array('s'=>'Required','mod'=>'attributewizardpro'),$_smarty_tpl);?>
</div><?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_max_limit']>0){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?> awp_red"><?php echo smartyTranslate(array('s'=>'Characters left:','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <span id="awp_max_limit_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_max_limit" awp_limit="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_max_limit'];?>
</span></div><?php }?><?php }?>
   		               					<?php } ?>
                   					</div>
           							<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>
		           						<script type="text/javascript">
               							$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							$("#awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							</script>
           							<?php }?>
                   				</div>
                   			</div>
                    		
						<?php } ?>
						<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?>
							<script type="text/javascript">
							$('.awp_text_length_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
').width(awp_max_text_length_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
);
							</script>
						<?php }?>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="file"){?>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><?php $_smarty_tpl->tpl_vars['id_attribute_file'] = new Smarty_variable(($_smarty_tpl->tpl_vars['group_attribute']->value[0]).('_file'), null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['iteration']%$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1||$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?> style="width:100%"><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']!="image"&&!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image awp_gi_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?><?php if ($_smarty_tpl->tpl_vars['group']->value['group_type']=="image"){?><?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?> awp_image_sel<?php }else{ ?> awp_image_nosel<?php }?><?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div id="awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
</div><?php }?><div id="awp_file_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><input id="upload_button_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> class="button" style="margin:0;padding:0;cursor:pointer" value="<?php echo smartyTranslate(array('s'=>'Upload File','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" type="button"><input type="hidden"  class="awp_attribute_selected awp_group_class_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="awp_file_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute_file']->value])){?>value=""<?php }?> />&nbsp;<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['first']){?><input type="hidden" name="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="pi_default_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['default_impact']->value;?>
" /><?php }?></div><div id="awp_image_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_tbla"><?php if (isset($_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value])){?><?php echo $_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value];?>
<?php }?></div><div id="awp_image_delete_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_tbla" style="display:<?php if (isset($_smarty_tpl->tpl_vars['awp_edit_special_values']->value[$_smarty_tpl->tpl_vars['id_attribute']->value])){?>block<?php }else{ ?>none<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/delete.gif" style="cursor: pointer" onclick="$('#awp_image_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
').html('');$('#awp_image_delete_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
').css('display','none');$('#awp_file_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
').val('');awp_price_update();" /></div><div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php $_smarty_tpl->tpl_vars['awp_pi'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value!=''){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"><?php }else{ ?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" style="display:none"></div><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php }?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }?></div><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_required'])&&$_smarty_tpl->tpl_vars['group']->value['group_required']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?> awp_red">* <?php echo smartyTranslate(array('s'=>'Required','mod'=>'attributewizardpro'),$_smarty_tpl);?>
</div><?php }?><?php }?>
   		               					<?php } ?>
                   					</div>
           							<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>
		           						<script type="text/javascript">
               							$("#awp_textbox_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							$("#awp_file_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							$("#awp_image_delete_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							$("#awp_text_length_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
               							</script>
           							<?php }?>
                    			</div>
                    		</div>
                    	
						<?php } ?>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="checkbox"){?>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['iteration']%$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1||$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?> style="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']!=1){?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?><?php }?>" onclick="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']==100){?>updateColorSelect(<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
)<?php }?>;"><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><div id="awp_checkbox_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> class="awp_attribute_selected awp_group_class_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
 awp_clean" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" id="awp_checkbox_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" onclick="awp_select('<?php echo intval($_smarty_tpl->tpl_vars['group']->value['id_group']);?>
',<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
, <?php echo $_smarty_tpl->tpl_vars['awp_currency']->value['id_currency'];?>
,false);" value="<?php echo intval($_smarty_tpl->tpl_vars['group_attribute']->value[0]);?>
" <?php if (is_array($_smarty_tpl->tpl_vars['group']->value['default'])&&in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])){?>checked<?php }?> />&nbsp;</div><div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
</div><?php }?><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php $_smarty_tpl->tpl_vars['awp_pi'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value!=''){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"><?php }else{ ?><span class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>" id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" style="display:none"></span><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php }?><?php echo smarty_function_math(array('equation'=>"x * y",'x'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'y'=>$_smarty_tpl->tpl_vars['awp_currency_rate']->value,'assign'=>'converted'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['converted']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['converted']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }?></div><?php }?><?php } ?></div><?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?><script type="text/javascript">$("#awp_checkbox_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);</script><?php }?></div></div>
						<?php } ?>
					<?php }elseif($_smarty_tpl->tpl_vars['group']->value['group_type']=="quantity"){?>
						<script type="text/javascript">
							awp_is_quantity_group.push(<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
);
						</script>
						<input type="hidden" id="awp_group_layout_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_layout'];?>
" />
						<input type="hidden" id="awp_group_per_row_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_per_row'];?>
" />
						<?php  $_smarty_tpl->tpl_vars['group_attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group_attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group_attribute']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group_attribute']->key => $_smarty_tpl->tpl_vars['group_attribute']->value){
$_smarty_tpl->tpl_vars['group_attribute']->_loop = true;
 $_smarty_tpl->tpl_vars['group_attribute']->index++;
 $_smarty_tpl->tpl_vars['group_attribute']->first = $_smarty_tpl->tpl_vars['group_attribute']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['first'] = $_smarty_tpl->tpl_vars['group_attribute']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['awp_loop']['iteration']++;
?>
						<?php $_smarty_tpl->tpl_vars['id_attribute'] = new Smarty_variable($_smarty_tpl->tpl_vars['group_attribute']->value[0], null, 0);?><div id="awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_cell_cont awp_cell_cont_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['awp_loop']['iteration']%$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1||$_smarty_tpl->tpl_vars['group']->value['group_per_row']==1){?> awp_clear<?php }?>"><div id="awp_cell_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='hide'){?>class="awp_oos"<?php }?> style="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']!=1){?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?><?php }?>" onclick="<?php if ($_smarty_tpl->tpl_vars['group']->value['group_color']==100){?>updateColorSelect(<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
)<?php }?>;"><?php if (file_exists((($_smarty_tpl->tpl_vars['col_img_dir']->value).($_smarty_tpl->tpl_vars['id_attribute']->value)).('.jpg'))){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" border="0" class="thickbox"><?php }?><img <?php if ($_smarty_tpl->tpl_vars['group']->value['group_resize']){?>style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>"<?php }?> src="<?php echo $_smarty_tpl->tpl_vars['img_col_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
" /><?php if (!$_smarty_tpl->tpl_vars['awp_popup']->value){?></a><?php }?></div><?php }elseif($_smarty_tpl->tpl_vars['group_attribute']->value[2]!=''){?><div id="awp_tc_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_group_image<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?> awp_left<?php }?>" style="<?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_width'])){?>width:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_width'];?>
px;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_height'])){?>height:<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
px;<?php }?>background-color:<?php echo $_smarty_tpl->tpl_vars['group_attribute']->value[2];?>
;">&nbsp;</div><?php }?><div id="awp_quantity_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="awp_quantity_cell <?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php echo smartyTranslate(array('s'=>'Quantity','mod'=>'attributewizardpro'),$_smarty_tpl);?>
: <input type="text" <?php if ($_smarty_tpl->tpl_vars['group']->value['attributes_quantity'][$_smarty_tpl->tpl_vars['id_attribute']->value]==0&&$_smarty_tpl->tpl_vars['awp_out_of_stock']->value=='disable'){?>disabled="disabled"<?php }?> class="awp_attribute_selected awp_qty_box" onchange="awp_add_to_cart_func()" name="awp_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" id="awp_quantity_group_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"  value="<?php if (in_array($_smarty_tpl->tpl_vars['id_attribute']->value,$_smarty_tpl->tpl_vars['group']->value['default'])&&!$_smarty_tpl->tpl_vars['group']->value['group_quantity_zero']){?>1<?php }else{ ?>0<?php }?>" /></div><div id="awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
" class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_nila<?php }else{ ?>awp_nica<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['group']->value['group_hide_name'])&&!$_smarty_tpl->tpl_vars['group']->value['group_hide_name']){?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['group_attribute']->value[1], 'htmlall', 'UTF-8');?>
</div><?php }?><?php  $_smarty_tpl->tpl_vars['attributeImpact'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attributeImpact']->_loop = false;
 $_smarty_tpl->tpl_vars['id_attributeImpact'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attributeImpacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attributeImpact']->key => $_smarty_tpl->tpl_vars['attributeImpact']->value){
$_smarty_tpl->tpl_vars['attributeImpact']->_loop = true;
 $_smarty_tpl->tpl_vars['id_attributeImpact']->value = $_smarty_tpl->tpl_vars['attributeImpact']->key;
?><?php if ($_smarty_tpl->tpl_vars['id_attribute']->value==$_smarty_tpl->tpl_vars['attributeImpact']->value['id_attribute']){?><?php $_smarty_tpl->tpl_vars['awp_pi'] = new Smarty_variable($_smarty_tpl->tpl_vars['attributeImpact']->value['price'], null, 0);?><div class="<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']){?>awp_tbla<?php }else{ ?>awp_tbca<?php }?>"  id="price_change_<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['awp_pi_display']->value==''){?>&nbsp;<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value>0){?>[<?php echo smartyTranslate(array('s'=>'Add','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPriceWithCurrency'][0][0]->convertPriceWithCurrency(array('price'=>$_smarty_tpl->tpl_vars['awp_pi']->value,'currency'=>$_smarty_tpl->tpl_vars['awp_currency']->value),$_smarty_tpl);?>
]<?php }elseif($_smarty_tpl->tpl_vars['awp_pi']->value<0){?>[<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'attributewizardpro'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>abs($_smarty_tpl->tpl_vars['awp_pi']->value)),$_smarty_tpl);?>
]<?php }?></div><?php }?>
    		               					<?php } ?>
                    					</div>
               							<?php if (!$_smarty_tpl->tpl_vars['group']->value['group_layout']&&$_smarty_tpl->tpl_vars['group']->value['group_height']){?>
	                   						<script type="text/javascript">
                   							$("#awp_quantity_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
                   							$("#awp_impact_cell<?php echo $_smarty_tpl->tpl_vars['id_attribute']->value;?>
").css('margin-top',(<?php echo $_smarty_tpl->tpl_vars['group']->value['group_height'];?>
/2) - 8);
                   							</script>
              							<?php }?>
                    			</div>
                    		</div>
                    	
						<?php } ?>
					
					<?php }?>						
					</div>
					<b class="xbottom"><b class="xb4 xbbot"></b><b class="xb3 xbbot"></b><b class="xb2 xbbot"></b><b class="xb1"></b></b>
				</div>
			
			<?php } ?>
			<?php if ($_smarty_tpl->tpl_vars['awp_add_to_cart']->value=="both"||$_smarty_tpl->tpl_vars['awp_add_to_cart']->value=="bottom"){?>
				<div class="awp_stock_container awp_sct">
					<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
						<div class="awp_stock_btn">
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Close','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="button_small" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
						</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['awp_is_edit']->value){?>
					
					<!-- MISE EN COMMENTAIRE DU BOUTON EDITER DU BAS DE LA PAGE PRODUIT
						<div class="awp_stock_btn">
							<input type="button" value="<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="exclusive awp_edit" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart(true);$(this).attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);" />&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					-->	
						
					<?php }?>	
					<div class="awp_stock_btn">
						<input type="button" value="<?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'attributewizardpro'),$_smarty_tpl);?>
" class="exclusive" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart();<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>awp_customize_func();<?php }?>$(this).attr('disabled', <?php if ($_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.9'||$_smarty_tpl->tpl_vars['awp_psv3']->value=='1.4.10'||$_smarty_tpl->tpl_vars['awp_psv']->value=='1.5'){?>false<?php }else{ ?>''<?php }?>);" />
					</div>
					<div class="awp_quantity_additional awp_stock">
						&nbsp;&nbsp;<?php echo smartyTranslate(array('s'=>'Quantity','mod'=>'attributewizardpro'),$_smarty_tpl);?>
: <input type="text" style="width:30px;padding:0;margin:0" id="awp_q2" onkeyup="$('#quantity_wanted').val(this.value);$('#awp_q2').val(this.value);" value="1" />
						<span class="awp_minimal_text"></span>
					</div>
					<div class="awp_stock">
						&nbsp;&nbsp;<b class="price our_price_display" id="awp_price"></b>
					</div>
					<div id="awp_in_stock"></div>
				</div>
				<script type="text/javascript">
				<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
					$('#awp_container').show();
				<?php }?>
				awp_scw = $('.awp_sct').width() + $('#our_price_display').width() + 4;
				$('.awp_sct').css('float','none');
				$('.awp_sct').width(awp_scw);
				<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
					$('#awp_container').hide();
				<?php }?>
				</script>
			<?php }?>
			</form>
		</div>
		<b class="xbottom"><b class="xb4 xbbot"></b><b class="xb3 xbbot"></b><b class="xb2 xbbot"></b><b class="xb1"></b></b>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	if (awp_selected_attribute_default)
	{
		<?php echo $_smarty_tpl->tpl_vars['awp_last_select']->value;?>

	}
});
/* Javascript used to align certain elements in the wizard */
<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
	$('#awp_container').show();
<?php }?>
awp_max_gi = 0;
$('.awp_gi').each(function () {
	if ($(this).width() > awp_max_gi)
		awp_max_gi = $(this).width();
});
if 	(awp_max_gi > 0)
	$('.awp_box_inner').width($('.awp_content').width() - awp_max_gi - 18);
<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
	$('#awp_container').hide();
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['awp_popup']->value){?>
	var awp_pop_center = ((document.body.clientWidth?document.body.clientWidth:window.innerWidth)/2) - $("#awp_container").width();
	$("#awp_container").css('display','none');
	$("#awp_container").css('left','<?php echo $_smarty_tpl->tpl_vars['awp_popup_left']->value;?>
px');
	$("#awp_container").css('top','<?php echo $_smarty_tpl->tpl_vars['awp_popup_top']->value;?>
px');
<?php }?>
if (awp_layered_image_list.length > 0)
	$('#view_full_size .span_link').css('display', 'none'); 

</script>
<?php }?>
<!-- /MODULE AttributeWizardPro --><?php }} ?>