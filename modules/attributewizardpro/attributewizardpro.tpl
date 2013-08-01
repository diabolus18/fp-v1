<!-- MODULE Attribute Wizard Pro-->
{if isset($groups)}
<script type="text/javascript" src="{$this_wizard_path}js/ajaxupload.js"></script>
<script type="text/javascript">
{if isset($awp_product_image) && awp_popup}
	var awp_layered_img_id = 'awp_product_image';
{else} 
	var awp_layered_img_id = 'bigpic';
{/if}
awp_selected_attribute = "";
awp_selected_group = "";
var awp_converted_price = {$awp_converted_price};
var awp_tmp_arr = new Array()
productHasAttributes = false;
$('#quantityAvailable').css('display','none');
var awp_no_tax_impact = {if $awp_no_tax_impact}true{else}false{/if};
var awp_psv = "{$awp_psv}";
var awp_psv3 = "{$awp_psv3}";
var awp_stock = "{$awp_stock}";
var awp_reload_page = "{$awp_reload_page}";
var awp_display_qty = {if $awp_display_qty}true{else}false{/if};
$('#availability_statut').css('display','none');
$('#quantityAvailable').css('display','none');
$('#quantityAvailableTxt').css('display','none');
$('#quantityAvailableTxtMultiple').css('display','none');
$('#last_quantities').css('display','none');
{if $awp_ajax}
	var awp_ajax = true;
{else}
	var awp_ajax = false;
{/if}

$(document).ready(function(){ldelim}
	if (typeof ajaxCart == 'undefined')
		awp_ajax = false;
	if (awp_is_quantity_group.length > 0)
	{ldelim}
		$("#quantity_wanted_p").css('display','none');
		
		$("div.awp_quantity_additional").css('display', 'none');
	{rdelim}
	else
	{ldelim}
		$("#quantity_wanted_p").css('display','block');
	{rdelim}
	$('#quantity_wanted').keyup(function() {ldelim}
		if ($('#awp_q1').length)
			$('#awp_q1').val($('#quantity_wanted').val());
		if ($('#awp_q2').length)
			$('#awp_q2').val($('#quantity_wanted').val());
	{rdelim});
	{if $awp_is_edit}
		{if $awp_qty_edit > 0}
			$('#quantity_wanted').val('{$awp_qty_edit}');
			if ($('#awp_q1').length)
				$('#awp_q1').val($('#quantity_wanted').val());
			if ($('#awp_q2').length)
				$('#awp_q2').val($('#quantity_wanted').val());
		{/if}
		if (!$('#awp_edit').length)
		{ldelim}
			$('#awp_add_to_cart').before('<p class="buttons_bottom_block" id="awp_edit"><input type="button" class="exclusive awp_edit" value="{l s='Edit' mod='attributewizardpro'}" name="Submit"  onclick="$(this).attr(\'disabled\', true);$(\'.awp_edit\').fadeOut();awp_add_to_cart(true);" /></p>');
		{rdelim}
	{/if}
{rdelim});

function awp_do_customize()
{ldelim}
	$('#awp_add_to_cart input').val(awp_customize);
	$('#awp_add_to_cart').show();
	$('#awp_add_to_cart input').unbind('click').click(function(){ldelim}
		awp_do_popup();
		return false;
	{rdelim});
{rdelim}

function awp_do_popup()
{ldelim}
	$("#awp_background").fadeIn(1000);
	$("#awp_container").fadeIn(1000);
	var awp_popup_height = Math.max($("#product").height(), $("#awp_container").height()) + parseInt({$awp_popup_top});
	$("#awp_background").css('height', awp_popup_height+'px');
	$('#awp_add_to_cart input').val(awp_add_cart);
	$('#awp_add_to_cart input').unbind('click').click(function(){ldelim}
		$('#awp_add_to_cart input').attr('disabled', 'disabled');
		awp_add_to_cart();
		awp_customize_func();
		$('#awp_add_to_cart input').attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});
		return false;
	{rdelim});
{rdelim}

var awp_customize = "{l s='Customize Product' mod='attributewizardpro' js=1}";
var awp_add_cart = "{l s='Add to cart' mod='attributewizardpro' js=1}";
var awp_add = "{l s='Add' mod='attributewizardpro' js=1}";
var awp_sub = "{l s='Subtract' mod='attributewizardpro' js=1}";
var awp_minimal_1 = "{l s='(Min:' mod='attributewizardpro' js=1}";
var awp_minimal_2 = "{l s=')' mod='attributewizardpro' js=1}";
var awp_min_qty_text = "{l s='The minimum quantity for this product is' mod='attributewizardpro' js=1}";
var awp_ext_err = "{l s='Error: invalid file extension, use only ' mod='attributewizardpro' js=1}";
var awp_adc_no_attribute = {if $awp_adc_no_attribute}true{else}false{/if};
var awp_popup = {if $awp_popup}true{else}false{/if};
var awp_pi_display = '{$awp_pi_display}';
var awp_currency = {$awp_currency.id_currency};
var awp_is_required = "{l s='is a required field!' mod='attributewizardpro' js=1}";
var awp_select_attributes = "{l s='You must select at least 1 product option' mod='attributewizardpro' js=1}";
var awp_oos_alert = "{l s='This combination is out of stock, please choose another' mod='attributewizardpro' js=1}";
$('#color_picker').attr({ldelim}id:'awp_color_picker'{rdelim});
$('#awp_color_picker').css('display','none');
{if $awp_popup}
	{if $awp_is_edit}
		$(document).ready(function () {ldelim}
		$('#add_to_cart').attr({ldelim}'id':'awp_add_to_cart'{rdelim});
		awp_do_popup();
		{rdelim});
	{else}
		$('#add_to_cart').attr({ldelim}'id':'awp_add_to_cart'{rdelim});
		awp_do_customize();
	{/if}
{else}
	$('#add_to_cart').attr({ldelim}'id':'awp_add_to_cart'{rdelim});
	{if $awp_no_customize == '1'}
		$('#awp_add_to_cart').show();
		$('#awp_add_to_cart input').unbind('click').click(function(){ldelim}
			$('#awp_add_to_cart input').attr('disabled', 'disabled');
			awp_add_to_cart();
			$('#awp_add_to_cart input').attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});
			return false;
		{rdelim});
	{else}
		if ($('#awp_add_to_cart a').length)
		{ldelim}
			$('#awp_add_to_cart a').html(awp_customize);
			$('#awp_add_to_cart input').hide();
		{rdelim}
		else
			$('#awp_add_to_cart input').val(awp_customize);
		$('#awp_add_to_cart').show();
		$('#awp_add_to_cart input').unbind('click').click(function(){ldelim}
			$.scrollTo( '#awp_container', 1200 );
			if (awp_add_to_cart_display != "bottom")
			{ldelim}
				if ($('#awp_add_to_cart a').length)
				{ldelim}
					$('#awp_add_to_cart a').html(awp_add_cart);
					$('#awp_add_to_cart input').hide();
				{rdelim}
				else
					$('#awp_add_to_cart input').val(awp_add_cart);
				$('#awp_add_to_cart input').unbind('click').click(function(){ldelim}
					$('#awp_add_to_cart input').attr('disabled', 'disabled');
					awp_add_to_cart();
					$('#awp_add_to_cart input').attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});
					return false;
				{rdelim});
			{rdelim}
			return false;
		{rdelim});
	{/if}
{/if}

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

{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}{strip}
	{if $attributeImpact.price > 0}
		awp_impact_only_list[{$attributeImpact.id_attribute}] = '{$attributeImpact.price}';
	{/if}
	awp_min_qty[{$attributeImpact.id_attribute}] = '{$attributeImpact.minimal_quantity}';
	awp_impact_list[{$attributeImpact.id_attribute}] = '{$attributeImpact.price}';
	awp_weight_list[{$attributeImpact.id_attribute}] = '{$attributeImpact.weight}';
{/strip}{/foreach}
if (awp_add_to_cart_display == "bottom")
{ldelim}
	$("#quantity_wanted_p").attr("id","awp_quantity_wanted_p");
    $("#awp_quantity_wanted_p").css("display","none");
{rdelim}
</script>
{if $awp_fade}
	<div id="awp_background" style="position: fixed; top:0;opacity:{$awp_opacity_fraction};filter:alpha(opacity={$awp_opacity});left:0;width:100%;height:100%;z-index:1999;display:none;background-color:black"> </div>
{/if}

<div id="awp_container" {if $awp_popup}style="position: absolute; z-index:2000;top:-5000px;display:block;width:{$awp_popup_width}px;margin:auto"{/if}>
	<div class="awp_box">
		<b class="xtop"><b class="xb1"></b><b class="xb2 xbtop"></b><b class="xb3 xbtop"></b><b class="xb4 xbtop"></b></b>
		<div class="awp_header">
			<b style="font-size:14px">{l s='Product Options' mod='attributewizardpro'}</b>
			{if $awp_popup}
				<div class="awp_pop_close" style="margin: -15px 0 0 {$awp_popup_width-38}px">
					<img src="{$this_wizard_path}img/close.png" style="cursor: pointer" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
				</div>
			{/if}
		</div>
		<div class="awp_content">
			{if isset($awp_product_image) && $awp_popup}
				<div id="awp_product_image" style="width:{$awp_product_image.width}px;height:{$awp_product_image.height}px;margin:auto">
					<img src="{$awp_product_image.src}"	title="{$product->name|escape:'htmlall':'UTF-8'}" alt="{$product->name|escape:'htmlall':'UTF-8'}" id="awp_bigpic" width="{$awp_product_image.width}" height="{$awp_product_image.height}" />
				</div>
			{/if}
			<form name="awp_wizard" id="awp_wizard">
			<input type="hidden" name="awp_p_impact" id="awp_p_impact" value="" />
			<input type="hidden" name="awp_p_weight" id="awp_p_weight" value="" />
			<input type="hidden" name="awp_ins" id="awp_ins" value="{$awp_ins}" />
			<input type="hidden" name="awp_ipa" id="awp_ipa" value="{$awp_ipa}" />
			{if ($awp_add_to_cart == "both" || $awp_add_to_cart == "bottom") && $groups|@count >= $awp_second_add}
				<div class="awp_stock_container awp_sct">
					{if $awp_popup}
						<div class="awp_stock_btn">
							<input type="button" value="{l s='Close' mod='attributewizardpro'}" class="button_small" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
						</div>
					{/if}
					{if $awp_is_edit}
					
					<!-- MISE EN COMMENTAIRE BOUTON EDITER FICHE PRODUIT
						<div class="awp_stock_btn">
							<input type="button" value="{l s='Edit' mod='attributewizardpro'}" class="exclusive awp_edit" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart(true);$(this).attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});" />&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						-->
						
						
					{/if}
					<div class="awp_stock_btn">
						<input type="button" value="{l s='Add to cart' mod='attributewizardpro'}" class="exclusive" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart();{if $awp_popup}awp_customize_func();{/if}$(this).attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});" />
					</div>
					<div class="awp_quantity_additional awp_stock">
						&nbsp;&nbsp;{l s='Quantity' mod='attributewizardpro'}: <input type="text" style="width:30px;padding:0;margin:0" id="awp_q1" onkeyup="$('#quantity_wanted').val(this.value);$('#awp_q2').val(this.value);" value="1" />
						<span class="awp_minimal_text"></span>
					</div>
					<div class="awp_stock">
							&nbsp;&nbsp;<b class="price our_price_display" id="awp_second_price"></b>
					</div>
					<div id="awp_in_stock_second"></div>
				</div>
			{/if}
			{foreach from=$groups key=id_attribute_group item=group name=awp_groups}
			{strip}
				<script type="text/javascript">
				awp_selected_groups[{$group.id_group}] = 0;
				awp_group_type[{$group.id_group}] = '{$group.group_type}';
				awp_group_order[{$group.id_group}] = {$smarty.foreach.awp_groups.index};
				awp_hin[{$group.id_group}] = '{if isset($group.group_hide_name)}{$group.group_hide_name}{else}0{/if}';
				{assign var='default_impact' value=''}
				{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact name=awp_attributeImpact}
				{strip}
					{if ($group.default|@count > 0 && $attributeImpact.id_attribute|in_array:$group.default) ||
						($awp_pi_display == 'diff' && $attributeImpact.price > 0 && ($group.group_type == 'textbox' || $group.group_type == 'checkbox' || $group.group_type == 'textarea' || $group.group_type == 'file')) || 
						($group.group_type == 'quantity' && $default_impact == '' && $smarty.foreach.awp_attributeImpact.last)}
						{assign var='default_impact' value=$attributeImpact.price}
						$(document).ready(function () {ldelim}
							if ('{$awp_pi_display}' != 'diff' || awp_attr_to_group[{$attributeImpact.id_attribute|intval}] == {$group.id_group})
							{ldelim}
								awp_selected_attribute = {$attributeImpact.id_attribute|intval};
								/*alert (awp_selected_attribute);*/
								awp_selected_group = {$group.id_group|intval};
								$('.awp_box .awp_attribute_selected').each(function()
								{ldelim}
									if (($(this).attr('type') != 'radio' || $(this).attr('checked')) &&
										($(this).attr('type') != 'checkbox' || $(this).attr('checked')) &&
										($(this).attr('type') != 'text' || $(this).val() != "0") && $(this).val() != "")
									{ldelim}
										awp_tmp_arr = $(this).attr('name').split('_');
										if (awp_selected_group == awp_tmp_arr[2])
										{ldelim}
											if (awp_group_type[awp_tmp_arr[2]] != "quantity" && awp_tmp_arr.length == 4 && awp_tmp_arr[3] != awp_selected_attribute)
												awp_selected_attribute = awp_tmp_arr[3];
											else if (awp_group_type[awp_tmp_arr[2]] != "quantity" && awp_group_type[awp_tmp_arr[2]] != "textbox" &&
							  					awp_group_type[awp_tmp_arr[2]] != "textarea" && awp_group_type[awp_tmp_arr[2]] != "file" &&
							  				awp_group_type[awp_tmp_arr[2]] != "calculation" && awp_selected_attribute != $(this).val())
											awp_selected_attribute = $(this).val();
										{rdelim}
									{rdelim}
								{rdelim});
								awp_select('{$group.id_group|intval}', awp_selected_attribute, {$awp_currency.id_currency}, true);
								awp_selected_attribute_default = awp_selected_attribute;
							{rdelim};
						{rdelim});
						{assign var='awp_last_select' value='awp_select_image(awp_selected_attribute_default);'}
					{/if}
				{/strip}
				{/foreach}
				{if $default_impact == ''}
					{assign var='default_impact' value=0}
				{/if}
				{foreach from=$group.attributes item=group_attribute}
				{strip}
					{assign var='id_attribute' value=$group_attribute.0}
					{if isset($group.group_required) && $group.group_required}
						awp_required_list[{$id_attribute}] = 1;
					{else}
						awp_required_list[{$id_attribute}] = 0;
					{/if}
					awp_layered_image_list[{$id_attribute}] = '{getLayeredImageTag id_attribute=$id_attribute v=$group_attribute.3}';
					{if $group.group_type == "file"}
						awp_file_list.push({$id_attribute});
						awp_file_ext.push(/^({$group.group_file_ext})$/);
					{/if}
					awp_multiply_list[{$id_attribute}] = '{if isset($group.group_calc_multiply)}{$group.group_calc_multiply}{/if}';
					awp_qty_list[{$id_attribute}] = '{$group.attributes_quantity.$id_attribute}';
					awp_required_list_name[{$id_attribute}] = '{$group_attribute.1|escape:'htmlall':'UTF-8'}';
					awp_attr_to_group[{$id_attribute}] = '{$group.id_group}';
				{/strip}
				{/foreach}
				</script>
				<div class="awp_group_image_container">
					{if isset($group.group_url) && $group.group_url}<a href="{$group.group_url}" target="_blank" alt="{$group.group_url}">{/if}{if isset($group.image_upload)}{getGroupImageTag id_group=$group.id_group alt=$group.name|escape:'htmlall':'UTF-8' v=$group.image_upload}{if isset($group.group_url) && $group.group_url}</a>{/if}{/if}
				</div>
				<div class="awp_box awp_box_inner">
					<b class="xtop"><b class="xb1"></b><b class="xb2 xbtop"></b><b class="xb3 xbtop"></b><b class="xb4 xbtop"></b></b>
					<div class="awp_header">
						{if isset($group.group_header) && $group.group_header}
							{$group.group_header|escape:'htmlspecialchars':'UTF-8'}
						{else}
							{$group.name|escape:'htmlspecialchars':'UTF-8'}
						{/if}
						{if isset($group.group_description) && $group.group_description != ""}
							
							<!--  MISE EN COMMENTAITE DE LA DIV POUR AFFICHER TITRE ET DESCRIPTION SUR MEME LIGNE
							<div class="awp_description">
							-->
							
								{$group.group_description|escape:'htmlspecialchars':'UTF-8'}
							
							<!--
							</div>
							-->
							
							
						{/if}
					</div>
					<div class="awp_content">
					{if $group.group_type == "dropdown"}
	               		<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group} awp_clear">
    						{if $group.group_color == 1}
								<div id="awp_select_colors_{$group.id_group}" {if !$group.group_layout}class="awp_left"{/if} {if isset($group.group_width) && $group.group_width}style="width:{$group.group_width}px;{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if}>
									{foreach from=$group.attributes item=group_attribute}
									{strip}
										{assign var='id_attribute' value=$group_attribute.0}
										{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
											<div id="awp_group_div_{$id_attribute}" class="awp_group_image" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}display:{if $id_attribute|in_array:$group.default}block{else}none{/if};">
												{if !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if isset($group.group_resize) && $group.group_resize && isset($group.group_width) && $group.group_width}style="width:{$group.group_width}px;{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if !$awp_popup}</a>{/if}
           									</div>
           								{else}
											<div id="awp_group_div_{$id_attribute}" class="awp_group_image" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};display:{if $id_attribute|in_array:$group.default}block{else}none{/if};">
           									</div>
           								{/if}
           							{/strip}
          							{/foreach}
           						</div>
   							{/if}
   							<div id="awp_sel_cont_{$id_attribute}" class="{if !$group.group_layout}awp_sel_conth{else}awp_sel_contv{/if}">
	                   			<select class="awp_attribute_selected" onmousedown="if($.browser.msie){ldelim}this.style.width='auto'{rdelim}" onblur="this.style.position='';" name="awp_group_{$group.id_group}" id="awp_group_{$group.id_group}" onchange="awp_select('{$group.id_group|intval}', this.options[this.selectedIndex].value, {$awp_currency.id_currency},false);this.style.position='';$('#awp_select_colors_{$group.id_group} div').each(function() {ldelim}$(this).css('display','none'){rdelim});$('#awp_group_div_'+this.value).fadeIn(1000);">
								{foreach from=$group.attributes item=group_attribute}
								{strip}
								{assign var='id_attribute' value=$group_attribute.0}
	                   				<option value="{$id_attribute}"{if $group.attributes_quantity.$id_attribute == 0}{if $awp_out_of_stock == 'hide'} class="awp_oos"{/if}{if $awp_out_of_stock == 'disable'} disabled="disabled"{/if}{/if} {if $id_attribute|in_array:$group.default}selected="selected"{/if}>{$group_attribute.1|escape:'htmlall':'UTF-8'}
			                    	{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
	                      				{if $id_attribute == $attributeImpact.id_attribute}
											{math equation="x - y" x=$attributeImpact.price y=$default_impact assign='awp_pi'}
                       						&nbsp;
	                       					{if $awp_pi_display == ""}
                      						{elseif $awp_pi > 0}
                       							[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
                      						{elseif $awp_pi < 0}
		                       					[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
                      						{/if}
                       					{/if}
                   					{/foreach}
                   					</option>
                   				{/strip}
                    			{/foreach}
                   				</select>
							</div>
           					{if !$group.group_layout && $group.group_height}
		           				<script type="text/javascript">
		           				$("#awp_sel_cont_{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               					</script>
           					{/if}
						</div>
					{elseif $group.group_type == "radio" || $group.group_type == "image"}
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
						{assign var='id_attribute' value=$group_attribute.0}
	                   		<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if $smarty.foreach.awp_loop.iteration % $group.group_per_row == 1 || $group.group_per_row == 1} awp_clear{/if}">
                   				<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="{if $group.group_color != 1}{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}{/if}" {if $group.attributes_quantity.$id_attribute > 0 || $awp_out_of_stock != 'disable'}onclick="$('#awp_radio_group_{$id_attribute}').attr('checked','checked');{if $group.group_type == "image"}awp_toggle_img({$group.id_group|intval},{$group_attribute.0|intval});{/if}awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false){/if}">
	                   				{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
                   						<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
		                    				{if $group.group_type != "image" && !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if $group.group_type != "image" && !$awp_popup}</a>{/if}
                   						</div>
                   					{elseif $group_attribute.2 != ""}
	                   					<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
                   							&nbsp;
	                   					</div>
                   					{/if}
                   					<div id="awp_radio_cell{$id_attribute}" class="{if !$group.group_layout}awp_rrla{else}awp_rrca{/if}{if $group.group_type == "image"} awp_none{/if}">
	                   					<input type="radio" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="awp_attribute_selected awp_clean" id="awp_radio_group_{$id_attribute}" name="awp_group_{$group.id_group}" value="{$group_attribute.0|intval}" {if $id_attribute|in_array:$group.default}checked="checked"{/if} />&nbsp;
                   						{if $smarty.foreach.awp_loop.first}
                 								<input type="hidden" name="pi_default_{$group.id_group}" id="pi_default_{$group.id_group}" value="{$default_impact}" />
               							{/if}
               						</div>
               						<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
										{if isset($group.group_hide_name) && !$group.group_hide_name}
											<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">{$group_attribute.1|escape:'htmlall':'UTF-8'}</div>
										{/if}
                   						{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
	                   						{if $id_attribute == $attributeImpact.id_attribute}
												{math equation="x - y" x=$attributeImpact.price y=$default_impact assign='awp_pi'}
           										<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}">
                   								{if $awp_pi_display == ""}
	                   								&nbsp;
               									{elseif $awp_pi > 0}
	                   								[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
			                   					{elseif $awp_pi < 0}
	                   								[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
                   								{else}
	    	           								&nbsp;
	              								{/if}
                  								</div>
	                   						{/if}
    	              					{/foreach}
                   					</div>
               						<script type="text/javascript">
               						$(document).ready(function() {ldelim}
	       							awp_center_images({$group.id_group});
               						{rdelim});
               						{if !$group.group_layout && $group.group_height}
	                   					$("#awp_radio_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   						$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
              						{/if}
	               					</script>
                  				</div>
                  			</div>
						{/strip}                    		
						{/foreach}
					{elseif $group.group_type == "textbox"}
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{if isset($group.group_hide_name) && !$group.group_hide_name}
							<script type="text/javascript">
								var awp_max_text_length_{$group.id_group} = 0;
							</script>
						{/if}
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
							{assign var='id_attribute' value=$group_attribute.0}
                  			<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if $smarty.foreach.awp_loop.iteration % $group.group_per_row == 1 || $group.group_per_row == 1} awp_clear{/if}">
                   				<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if}>
	               					{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
                   						<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
		                					{if $group.group_type != "image" && !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if $group.group_type != "image" && !$awp_popup}</a>{/if}
                   						</div>
                   					{elseif $group_attribute.2 != ""}
	               						<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
		                   					&nbsp;
                   						</div>
		                   			{/if}
                   					{if isset($group.group_hide_name) && !$group.group_hide_name}
                   						<div id="awp_text_length_{$id_attribute}" class="awp_text_length_group awp_text_length_group_{$group.id_group} {if !$group.group_layout}awp_nila{else}awp_nica{/if}" >{$group_attribute.1|escape:'htmlall':'UTF-8'}&nbsp;</div>
                   					{/if}
		                    		<div id="awp_textbox_cell{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
                						<input type="text" value="{if isset($awp_edit_special_values.$id_attribute)}{$awp_edit_special_values.$id_attribute}{/if}" style="margin:0;padding:0;{if $group.group_width}width:{$group.group_width}px;{/if}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="awp_attribute_selected awp_group_class_{$group.id_group}" id="awp_textbox_group_{$id_attribute}" name="awp_group_{$group.id_group}_{$id_attribute}" onkeyup="{if $group.group_max_limit > 0}awp_max_limit_check('{$group_attribute.0|intval}',{$group.group_max_limit});{/if}awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false);" onblur="{if $group.group_max_limit > 0}awp_max_limit_check('{$group_attribute.0|intval}',{$group.group_max_limit});{/if}awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false);" />&nbsp;
                   						{if $smarty.foreach.awp_loop.first}
               								<input type="hidden" name="pi_default_{$group.id_group}" id="pi_default_{$group.id_group}" value="{$default_impact}" />
               							{/if}
               						</div>
									
									
               						<!-- MISE EN COMMENTAIRE AJOUT X € A DROITE BOITE TEXTE GRAVURE
									<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
                   						{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
										{strip}
                   							{if $id_attribute == $attributeImpact.id_attribute}
               									{assign var='awp_pi' value=$attributeImpact.price}
												{if $awp_pi_display  != ""}
			                    					<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}">
												{else}
				                   					<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}" style="display:none"></div><div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
												{/if}
                   								{if $awp_pi_display == ""}
                   									&nbsp;
               									{elseif $awp_pi > 0}
	               									[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
               									{elseif $awp_pi < 0}
	               									[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
	           									{/if}
           										</div>
												{if isset($group.group_required) && $group.group_required}<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if} awp_red">* {l s='Required' mod='attributewizardpro'}</div>{/if}
												{if $group.group_max_limit > 0}<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if} awp_red">{l s='Characters left:' mod='attributewizardpro'} <span id="awp_max_limit_{$id_attribute}" class="awp_max_limit" awp_limit="{$group.group_max_limit}">{$group.group_max_limit}</span></div>{/if}
                   							{/if}
                   						{/strip}
   	              						{/foreach}
               						</div>      -->
									
									
       								{if !$group.group_layout && $group.group_height}
		           						<script type="text/javascript">
           								$("#awp_textbox_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
          								$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
	              						$("#awp_text_length_{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
           								</script>
       								{/if}
               					</div>
               					{if $group.group_max_limit > 0}
               						<script type="text/javascript">
               							awp_max_limit_check('{$group_attribute.0|intval}',{$group.group_max_limit});
	                  				</script>
               					{/if}
               				</div>
                  		{/strip}
						{/foreach}
						{if isset($group.group_hide_name) && !$group.group_hide_name}
							<script type="text/javascript">
							$(document).ready(function (){ldelim}
							{if $awp_popup}
								$('#awp_container').show();
							{/if}
							$('.awp_text_length_group').each(function () {ldelim}
								awp_max_text_length_{$group.id_group} = Math.max(awp_max_text_length_{$group.id_group}, $(this).width());
							{rdelim});
							$('.awp_text_length_group').width(awp_max_text_length_{$group.id_group});
							{if $awp_popup}
								$('#awp_container').hide();
							{/if}
						{rdelim});
						</script>
						{/if}
					{elseif $group.group_type == "textarea"}
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{if isset($group.group_hide_name) && !$group.group_hide_name}
							<script type="text/javascript">
								var awp_max_text_length_{$group.id_group} = 0;
							</script>
						{/if}
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
							{assign var='id_attribute' value=$group_attribute.0}
                 			<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if !$group.group_layout} awp_clear{/if}">
	                   			<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="width:100%">
		               				{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
                   						<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
			                				{if $group.group_type != "image" && !awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if $group.group_type != "image" && !$awp_popup}</a>{/if}
                   						</div>
                   					{elseif $group_attribute.2 != ""}
		               					<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
                   							&nbsp;
                   						</div>
                   					{/if}
									{if isset($group.group_hide_name) && !$group.group_hide_name}
	                   					<div id="awp_text_length_{$id_attribute}" class="awp_text_length_group_{$group.id_group} {if !$group.group_layout}awp_nila{else}awp_nica{/if}">{$group_attribute.1|escape:'htmlall':'UTF-8'}&nbsp;</div>
										<script type="text/javascript">
											awp_max_text_length_{$group.id_group} = Math.max(awp_max_text_length_{$group.id_group}, $('#awp_text_length_{$id_attribute}').width());
										</script>
									{/if}
                    				<div id="awp_textarea_cell{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
	                  					<textarea {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} style="margin:0;padding:0;{if $group.group_width}width:{$group.group_width}px;{/if}{if $group.group_height}height:{$group.group_height}px;{/if}" class="awp_attribute_selected awp_group_class_{$group.id_group}" id="awp_textarea_group_{$id_attribute}" name="awp_group_{$group.id_group}_{$id_attribute}" onkeyup="{if $group.group_max_limit > 0}awp_max_limit_check('{$group_attribute.0|intval}',{$group.group_max_limit});{/if}awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false);" onblur="{if $group.group_max_limit > 0}awp_max_limit_check('{$group_attribute.0|intval}',{$group.group_max_limit});{/if}awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false);">{if isset($awp_edit_special_values.$id_attribute)}{$awp_edit_special_values.$id_attribute}{/if}</textarea>&nbsp;
                   						{if $smarty.foreach.awp_loop.first}
	               							<input type="hidden" name="pi_default_{$group.id_group}" id="pi_default_{$group.id_group}" value="{$default_impact}" />
               							{/if}
               						</div>
               						<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
	                   					{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
                   						{strip}
	                   						{if $id_attribute == $attributeImpact.id_attribute}
               									{assign var='awp_pi' value=$attributeImpact.price}
												{if $awp_pi_display != ""}
				                      				<div id="price_change_{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
												{else}
					                      			<div id="price_change_{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" style="display:none"></div><div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
												{/if}	
                   								{if $awp_pi_display == ""}
                   									&nbsp;
               									{elseif $awp_pi > 0}
	                  								[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
               									{elseif $awp_pi < 0}
	                   								[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
               									{/if}
                   								</div>
												{if isset($group.group_required) && $group.group_required}<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if} awp_red">* {l s='Required' mod='attributewizardpro'}</div>{/if}
												{if $group.group_max_limit > 0}<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if} awp_red">{l s='Characters left:' mod='attributewizardpro'} <span id="awp_max_limit_{$id_attribute}" class="awp_max_limit" awp_limit="{$group.group_max_limit}">{$group.group_max_limit}</span></div>{/if}
                       						{/if}
	                       				{/strip}
   		               					{/foreach}
                   					</div>
           							{if !$group.group_layout && $group.group_height}
		           						<script type="text/javascript">
               							$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							$("#awp_text_length_{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							</script>
           							{/if}
                   				</div>
                   			</div>
                    	{/strip}	
						{/foreach}
						{if isset($group.group_hide_name) && !$group.group_hide_name}
							<script type="text/javascript">
							$('.awp_text_length_group_{$group.id_group}').width(awp_max_text_length_{$group.id_group});
							</script>
						{/if}
					{elseif $group.group_type == "file"}
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
							{assign var='id_attribute' value=$group_attribute.0}
							{assign var='id_attribute_file' value=$group_attribute.0|cat:'_file'}
                  			<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if $smarty.foreach.awp_loop.iteration % $group.group_per_row == 1 || $group.group_per_row == 1} awp_clear{/if}">
	                    		<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="width:100%">
	               					{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
	                   					<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
		                					{if $group.group_type != "image" && !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if $group.group_type != "image" && !$awp_popup}</a>{/if}
                   						</div>
                   					{elseif $group_attribute.2 != ""}
		               					<div id="awp_tc_{$id_attribute}" class="awp_group_image awp_gi_{$group.id_group}{if !$group.group_layout} awp_left{/if}{if $group.group_type == "image"}{if $id_attribute|in_array:$group.default} awp_image_sel{else} awp_image_nosel{/if}{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
                   							&nbsp;
                   						</div>
                   					{/if}
               						{if isset($group.group_hide_name) && !$group.group_hide_name}
	               						<div id="awp_text_length_{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
	               							{$group_attribute.1|escape:'htmlall':'UTF-8'}
               							</div>
               						{/if}
                   					<div id="awp_file_cell{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
										<input id="upload_button_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="button" style="margin:0;padding:0;cursor:pointer" value="{l s='Upload File' mod='attributewizardpro'}" type="button">
	               						<input type="hidden"  class="awp_attribute_selected awp_group_class_{$group.id_group}" id="awp_file_group_{$id_attribute}" name="awp_group_{$group.id_group}_{$id_attribute}" {if isset($awp_edit_special_values.$id_attribute_file)}value=""{/if} />&nbsp;
		               						{if $smarty.foreach.awp_loop.first}
               								<input type="hidden" name="pi_default_{$group.id_group}" id="pi_default_{$group.id_group}" value="{$default_impact}" />
               							{/if}
               						</div>
	               					<div id="awp_image_cell_{$id_attribute}" class="awp_tbla">
	              						{if isset($awp_edit_special_values.$id_attribute)}{$awp_edit_special_values.$id_attribute}{/if}
               						</div>
               						<div id="awp_image_delete_cell_{$id_attribute}" class="awp_tbla" style="display:{if isset($awp_edit_special_values.$id_attribute)}block{else}none{/if}">
	               						<img src="{$img_dir}icon/delete.gif" style="cursor: pointer" onclick="$('#awp_image_cell_{$id_attribute}').html('');$('#awp_image_delete_cell_{$id_attribute}').css('display','none');$('#awp_file_group_{$id_attribute}').val('');awp_price_update();" /> 
               						</div>
               						<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
		               					{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
	               						{strip}
	                   						{if $id_attribute == $attributeImpact.id_attribute}
               									{assign var='awp_pi' value=$attributeImpact.price}
												{if $awp_pi_display != ""}
				                      				<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}">
												{else}
					                      			<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}" style="display:none"></div><div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
												{/if}
                   								{if $awp_pi_display == ""}
	                   								&nbsp;
                								{elseif $awp_pi > 0}
		               								[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
                								{elseif $awp_pi < 0}
		               								[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
	                							{/if}	
                  								</div>
												{if isset($group.group_required) && $group.group_required}<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if} awp_red">* {l s='Required' mod='attributewizardpro'}</div>{/if}
	                   						{/if}
                       					{/strip}
   		               					{/foreach}
                   					</div>
           							{if !$group.group_layout && $group.group_height}
		           						<script type="text/javascript">
               							$("#awp_textbox_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							$("#awp_file_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							$("#awp_image_delete_cell_{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							$("#awp_text_length_{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
               							</script>
           							{/if}
                    			</div>
                    		</div>
                    	{/strip}
						{/foreach}
					{elseif $group.group_type == "checkbox"}
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
							{assign var='id_attribute' value=$group_attribute.0}
                 			<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if $smarty.foreach.awp_loop.iteration % $group.group_per_row == 1 || $group.group_per_row == 1} awp_clear{/if}">
	                   			<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="{if $group.group_color != 1}{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}{/if}" onclick="{if $group.group_color == 100}updateColorSelect({$id_attribute}){/if};">
									{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
										<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
											{if !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if !$awp_popup}</a>{/if}
										</div>
									{elseif $group_attribute.2 != ""}
										<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
											&nbsp;
										</div>
									{/if}
									<div id="awp_checkbox_cell{$id_attribute}" class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
		            					<input type="checkbox" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="awp_attribute_selected awp_group_class_{$group.id_group} awp_clean" name="awp_group_{$group.id_group}" id="awp_checkbox_group_{$id_attribute}" onclick="awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency},false);" value="{$group_attribute.0|intval}" {if $group.default|is_array && $id_attribute|in_array:$group.default}checked{/if} />&nbsp;
									</div>
									<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
										{if isset($group.group_hide_name) && !$group.group_hide_name}
											<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">{$group_attribute.1|escape:'htmlall':'UTF-8'}</div>
										{/if}
										{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
											{if $id_attribute == $attributeImpact.id_attribute}
												{assign var='awp_pi' value=$attributeImpact.price}
												{if $awp_pi_display != ""}
						                   			<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}">
												{else}	
					                    			<span class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}" id="price_change_{$id_attribute}" style="display:none"></span><div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">
												{/if}
												{math equation="x * y" x=$awp_pi y=$awp_currency_rate assign=converted}
                   								{if $awp_pi_display == ""}
		                   							&nbsp;
                   								{elseif $awp_pi > 0}
		                   							[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$converted currency=$awp_currency}]
                   								{elseif $awp_pi < 0}
		                   							[{l s='Subtract' mod='attributewizardpro'} {convertPriceWithCurrency price=$converted currency=$awp_currency}]
                   								{/if}
	                     						</div>
											{/if}	
    		               				{/foreach}
                    				</div>
               						{if !$group.group_layout && $group.group_height}
	                   					<script type="text/javascript">
                   						$("#awp_checkbox_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   						$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   						</script>
              						{/if}
                    			</div>
                    		</div>
                    	{/strip}
						{/foreach}
					{elseif $group.group_type == "quantity"}
						<script type="text/javascript">
							awp_is_quantity_group.push({$group.id_group});
						</script>
						<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
						<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
						{foreach from=$group.attributes name=awp_loop item=group_attribute}
						{strip}
						{assign var='id_attribute' value=$group_attribute.0}
	                   		<div id="awp_cell_cont_{$id_attribute}" class="awp_cell_cont awp_cell_cont_{$group.id_group}{if $smarty.foreach.awp_loop.iteration % $group.group_per_row == 1 || $group.group_per_row == 1} awp_clear{/if}">
                   				<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="{if $group.group_color != 1}{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}{/if}" onclick="{if $group.group_color == 100}updateColorSelect({$id_attribute}){/if};">
									{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
										<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
											{if !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if !$awp_popup}</a>{/if}
										</div>
										{elseif $group_attribute.2 != ""}
										<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
											&nbsp;
										</div>	
										{/if}
										<div id="awp_quantity_cell{$id_attribute}" class="awp_quantity_cell {if !$group.group_layout}awp_nila{else}awp_nica{/if}">
				            				{l s='Quantity' mod='attributewizardpro'}: <input type="text" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="awp_attribute_selected awp_qty_box" onchange="awp_add_to_cart_func()" name="awp_group_{$group.id_group}_{$id_attribute}" id="awp_quantity_group_{$id_attribute}"  value="{if $id_attribute|in_array:$group.default && !$group.group_quantity_zero}1{else}0{/if}" />
										</div>
										<div id="awp_impact_cell{$id_attribute}" class="{if !$group.group_layout}awp_nila{else}awp_nica{/if}">
											{if isset($group.group_hide_name) && !$group.group_hide_name}
												<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}">{$group_attribute.1|escape:'htmlall':'UTF-8'}</div>
											{/if}
											{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
											{strip}
												{if $id_attribute == $attributeImpact.id_attribute}
													{assign var='awp_pi' value=$attributeImpact.price}
			                      					<div class="{if !$group.group_layout}awp_tbla{else}awp_tbca{/if}"  id="price_change_{$id_attribute}">
    	                   								{if $awp_pi_display == ""}
	                    	   								&nbsp;
			                   							{elseif $awp_pi > 0}
            			       								[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
                   										{elseif $awp_pi < 0}
                   											[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
                   										{/if}
                     								</div>
												{/if}
											{/strip}
    		               					{/foreach}
                    					</div>
               							{if !$group.group_layout && $group.group_height}
	                   						<script type="text/javascript">
                   							$("#awp_quantity_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   							$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   							</script>
              							{/if}
                    			</div>
                    		</div>
                    	{/strip}
						{/foreach}
					{*elseif $group.group_type == "calculation"}
					<input type="hidden" id="awp_group_layout_{$group.id_group}" value="{$group.group_layout}" />
					<input type="hidden" id="awp_group_per_row_{$group.id_group}" value="{$group.group_per_row}" />
					<table cellpadding="6" border=0>
               		<tr style="height:20px">
					{foreach from=$group.attributes name=awp_loop item=group_attribute}
					{strip}
					{assign var='id_attribute' value=$group_attribute.0}
                   		<td align="center" {if $group.group_layout}valign="top"{/if}>
                   			<div id="awp_cell_{$id_attribute}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'hide'}class="awp_oos"{/if} style="{if $group.group_color != 1}{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}{/if}" onclick="{if $group.group_color == 100}updateColorSelect({$id_attribute}){/if};">
								{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
									{if $group.group_per_row > 1}<center>{/if}
									<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}">
										{if !$awp_popup}<a href="{$img_col_dir}{$id_attribute}.jpg" border="0" class="thickbox">{/if}<img {if $group.group_resize}style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}"{/if} src="{$img_col_dir}{$id_attribute}.jpg" alt="{$group_attribute.1|escape:'htmlall':'UTF-8'}" title="{$group_attribute.1|escape:'htmlall':'UTF-8'}" />{if !$awp_popup}</a>{/if}
									</div>
									{if $group.group_per_row > 1}</center>{/if}
									{elseif $group_attribute.2 != ""}
									{if $group.group_per_row > 1}<center>{/if}
									<div id="awp_tc_{$id_attribute}" class="awp_group_image{if !$group.group_layout} awp_left{/if}" style="{if isset($group.group_width)}width:{$group.group_width}px;{/if}{if isset($group.group_height)}height:{$group.group_height}px;{/if}background-color:{$group_attribute.2};">
										&nbsp;
									</div>
									{if $group.group_per_row > 1}</center>{/if}
									{/if}
									{if $group.group_per_row > 1}<center>{/if}
									<div id="awp_quantity_cell{$id_attribute}" style="{if !$group.group_layout}float:left;{else}width:100%;clear:left;{/if}">
                    					{if $group.group_per_row > 1}<center>{/if}
			            				{l s='Minimum' mod='attributewizardpro'}: {$group.group_calc_min}
			            				<input style="width:60px" type="text" default="{$group.group_calc_min}" {if $group.attributes_quantity.$id_attribute == 0 && $awp_out_of_stock == 'disable'}disabled="disabled"{/if} class="awp_attribute_selected" onblur="if(parseFloat($(this).val()) < parseFloat({$group.group_calc_min})) {ldelim}$(this).val('{$group.group_calc_min}'){rdelim};if(parseFloat($(this).val()) > parseFloat({$group.group_calc_max})) {ldelim}$(this).val('{$group.group_calc_max}'){rdelim};" onkeyup="awp_select('{$group.id_group|intval}',{$group_attribute.0|intval}, {$awp_currency.id_currency}, false);" name="awp_group_{$group.id_group}_{$id_attribute}" id="awp_calc_group_{$id_attribute}" value="{$group.group_calc_min}" />&nbsp;
			            				{l s='Maximum' mod='attributewizardpro'}: {$group.group_calc_max}
										{if $group.group_per_row > 1}</center>{/if}
									</div>
									<div id="awp_impact_cell{$id_attribute}" style="{if !$group.group_layout}float:left;text-align:center;{else}width:100%;clear: left;{/if}">
										{if $group.group_per_row > 1}<center>{/if}
										{if isset($group.group_hide_name) && !$group.group_hide_name}{$group_attribute.1|escape:'htmlall':'UTF-8'}{/if}
										{foreach from=$attributeImpacts key=id_attributeImpact item=attributeImpact}
										{strip}
										{if $id_attribute == $attributeImpact.id_attribute}
											{assign var='awp_pi' value=$attributeImpact.price}
			                      			<span id="price_change_{$id_attribute}" style="display:none">
                       						{if $awp_pi_display == ""}
                       							&nbsp;
                   							{elseif $awp_pi > 0}
                   								{if !$group.group_layout} {elseif $group.group_per_row > 1 && isset($group.group_hide_name) && !$group.group_hide_name}<br />{/if}[{l s='Add' mod='attributewizardpro'} {convertPriceWithCurrency price=$awp_pi currency=$awp_currency}]
                   							{elseif $awp_pi < 0}
                   								{if !$group.group_layout} {elseif $group.group_per_row > 1 && isset($group.group_hide_name) && !$group.group_hide_name}<br />{/if}[{l s='Subtract' mod='attributewizardpro'} {convertPrice price=$awp_pi|abs}]
                   							{/if}
                     						</span>
										{/if}
										{/strip}
    		               				{/foreach}
                    					{if $group.group_per_row > 1}</center>{/if}
                    				</div>
               						{if !$group.group_layout && $group.group_height}
                   						<script type="text/javascript">
                   						$("#awp_quantity_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   						$("#awp_impact_cell{$id_attribute}").css('margin-top',({$group.group_height}/2) - 8);
                   						</script>
              						{/if}
                    		</div>
                    	</td>
                    	{if $smarty.foreach.awp_loop.iteration < $group.attributes|@count && $smarty.foreach.awp_loop.iteration % $group.group_per_row == 0}
                    	</tr>
                    	<tr style="height:20px;">
                    	{/if}
                    {/strip}
					{/foreach}
           			</tr>
					</table>*}
					{/if}						
					</div>
					<b class="xbottom"><b class="xb4 xbbot"></b><b class="xb3 xbbot"></b><b class="xb2 xbbot"></b><b class="xb1"></b></b>
				</div>
			{/strip}
			{/foreach}
			{if $awp_add_to_cart == "both" || $awp_add_to_cart == "bottom"}
				<div class="awp_stock_container awp_sct">
					{if $awp_popup}
						<div class="awp_stock_btn">
							<input type="button" value="{l s='Close' mod='attributewizardpro'}" class="button_small" onclick="$('#awp_container').fadeOut(1000);$('#awp_background').fadeOut(1000);awp_customize_func();" />
						</div>
					{/if}
					{if $awp_is_edit}
					
					<!-- MISE EN COMMENTAIRE DU BOUTON EDITER DU BAS DE LA PAGE PRODUIT
						<div class="awp_stock_btn">
							<input type="button" value="{l s='Edit' mod='attributewizardpro'}" class="exclusive awp_edit" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart(true);$(this).attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});" />&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					-->	
						
					{/if}	
					<div class="awp_stock_btn">
						<input type="button" value="{l s='Add to cart' mod='attributewizardpro'}" class="exclusive" onclick="$(this).attr('disabled', 'disabled');awp_add_to_cart();{if $awp_popup}awp_customize_func();{/if}$(this).attr('disabled', {if $awp_psv3 == '1.4.9' || $awp_psv3 == '1.4.10' || $awp_psv == '1.5'}false{else}''{/if});" />
					</div>
					<div class="awp_quantity_additional awp_stock">
						&nbsp;&nbsp;{l s='Quantity' mod='attributewizardpro'}: <input type="text" style="width:30px;padding:0;margin:0" id="awp_q2" onkeyup="$('#quantity_wanted').val(this.value);$('#awp_q2').val(this.value);" value="1" />
						<span class="awp_minimal_text"></span>
					</div>
					<div class="awp_stock">
						&nbsp;&nbsp;<b class="price our_price_display" id="awp_price"></b>
					</div>
					<div id="awp_in_stock"></div>
				</div>
				<script type="text/javascript">
				{if $awp_popup}
					$('#awp_container').show();
				{/if}
				awp_scw = $('.awp_sct').width() + $('#our_price_display').width() + 4;
				$('.awp_sct').css('float','none');
				$('.awp_sct').width(awp_scw);
				{if $awp_popup}
					$('#awp_container').hide();
				{/if}
				</script>
			{/if}
			</form>
		</div>
		<b class="xbottom"><b class="xb4 xbbot"></b><b class="xb3 xbbot"></b><b class="xb2 xbbot"></b><b class="xb1"></b></b>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {ldelim}
	if (awp_selected_attribute_default)
	{ldelim}
		{$awp_last_select}
	{rdelim}
{rdelim});
/* Javascript used to align certain elements in the wizard */
{if $awp_popup}
	$('#awp_container').show();
{/if}
awp_max_gi = 0;
$('.awp_gi').each(function () {ldelim}
	if ($(this).width() > awp_max_gi)
		awp_max_gi = $(this).width();
{rdelim});
if 	(awp_max_gi > 0)
	$('.awp_box_inner').width($('.awp_content').width() - awp_max_gi - 18);
{if $awp_popup}
	$('#awp_container').hide();
{/if}
{if $awp_popup}
	var awp_pop_center = ((document.body.clientWidth?document.body.clientWidth:window.innerWidth)/2) - $("#awp_container").width();
	$("#awp_container").css('display','none');
	$("#awp_container").css('left','{$awp_popup_left}px');
	$("#awp_container").css('top','{$awp_popup_top}px');
{/if}
if (awp_layered_image_list.length > 0)
	$('#view_full_size .span_link').css('display', 'none'); 

</script>
{/if}
<!-- /MODULE AttributeWizardPro -->