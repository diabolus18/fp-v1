<!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<script type="text/javascript">
	{literal}
	function procesando()
	{
		$('*').css('cursor', 'wait');
		document.getElementById('buttons').style.display = "none";
		document.getElementById('procesando').style.display = "block";

	}
	{/literal}
</script>

{if !$mobile_device}
<link rel="stylesheet" type="text/css" href="{$this_path}js/shadowbox.css">
<script type="text/javascript" src="{$this_path}js/shadowbox.js"></script>
<script type="text/javascript">
	{literal}
	Shadowbox.init();
	{/literal}
</script>
{/if}

{capture name=path}{l s='Credit card payment' mod='creditcardofflinepayment'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='creditcardofflinepayment'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='creditcardofflinepayment'}</p>
{else}
	<h3>{l s='Credit card payment' mod='creditcardofflinepayment'}</h3>
	<form action="{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}{else}{$link->getModuleLink('creditcardofflinepayment', 'validation', [], true)}{/if}" method="post" id="creditForm" name="creditForm" class="std">
		<fieldset>
			<input type="hidden" name="id_currency" value="{$id_currency|escape:'htmlall':'UTF-8'}"/>

			<div id="payment_form">
				<h3 style="align: center;text-align: center;">
					{l s='You can use the following card issuers:' mod='creditcardofflinepayment'}
					<br /><br />
					{foreach from=$issuers item=issuer}
					{if $issuer.authorized}
					<img src="{$this_path}img/{$issuer.imgName|escape:'htmlall':'UTF-8'}" />
					{/if}
					{/foreach}
				</h3>
				{if $errores|@count > 0}
				<div class="alert error" id="errorDiv">
					<img alt="{l s='Error' mod='creditcardofflinepayment'}" src="{$base_dir}img/admin/forbbiden.gif" />
					{l s='There are errors' mod='creditcardofflinepayment'}:
					<ol>
						{foreach from=$errores item=error}
						<li>{$error|escape:'htmlall':'UTF-8'}</li>
						{/foreach}
					</ol>
				</div>
				{/if}

				{if $requireIssuerName}
				<p class="required text">
					<label for="card[name]">
						{l s='Card holder name' mod='creditcardofflinepayment'}
						{if $requiredIssuerName}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" maxlength="150" name="card[name]" id="cardName" value="{if isset($card.name)}{$card.name|escape:'htmlall':'UTF-8'}{else}{$cookie->customer_firstname|escape:'htmlall':'UTF-8'} {$cookie->customer_lastname|escape:'htmlall':'UTF-8'}{/if}"/>
				</p>
				{/if}

				{if $requireCedule}
				<p class="required text">
					<label for="card[cedula]">
						{l s='ID Card/Passport' mod='creditcardofflinepayment'}
						{if $requiredCedule}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" name="card[cedula]" id="cardCVC" value="{if isset($card.cedula)}{$card.cedula|escape:'htmlall':'UTF-8'}{/if}" size="20" maxlength="20"/>
				</p>
				{/if}

				{if $requireAddress}
				<p class="required text">
					<label for="card[address]">
						{l s='Address' mod='creditcardofflinepayment'}
						{if $requiredCedule}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" name="card[address]" id="cardAddress" value="{if isset($card.address)}{$card.address|escape:'htmlall':'UTF-8'}{/if}" size="20" maxlength="20"/>
				</p>
				{/if}

				{if $requireZipCode}
				<p class="required text">
					<label for="card[zipcode]">
						{l s='Zip code' mod='creditcardofflinepayment'}
						{if $requiredZipCode}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" name="card[zipcode]" id="cardZipCode" value="{if isset($card.zipcode)}{$card.zipcode|escape:'htmlall':'UTF-8'}{/if}" size="5" />
				</p>
				{/if}

				{if $requireCardNumber}
				<p class="required text">
					<label for="card[number]">
						{l s='Credit card number' mod='creditcardofflinepayment'}
						{if $requiredCardNumber}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" name="card[number]" id="cardNumber" value="{if isset($card.number)}{$card.number|escape:'htmlall':'UTF-8'}{/if}" size="20" maxlength="16" />
				</p>
				{/if}
				
				{if $requireCVC}
				<p class="required text">
					<label for="card[cvc]">
						{l s='CVC (card security code)' mod='creditcardofflinepayment'}
						{if $requiredCVC}
							<sup>*</sup>
						{/if}
					</label>
					<input type="text" name="card[cvc]" id="cardCVC" value="{if isset($card.cvc)}{$card.cvc|escape:'htmlall':'UTF-8'}{/if}" size="4" maxlength="4"/>
					{if !$mobile_device}
					<a href="{$this_path}img/CVC.png" alt="{l s='Where is the CVC number?' mod='creditcardofflinepayment'}" class="thickbox shown" rel="shadowbox">
						<img style="vertical-align:middle" src="/img/admin/help.png" width="16" height="16" alt="{l s='Where is the CVC number?' mod='creditcardofflinepayment'}"/>
					</a>
					{/if}
				</p>
				{/if}

				{if $requireIssuer}
				<p class="required text">
					<label for="card[issuer]">
						{l s='Card issuer' mod='creditcardofflinepayment'}
						{if $requiredIssuer}
							<sup>*</sup>
						{/if}
					</label>
					<select name="card[issuer]">
						<option value="" {if isset($card.issuer)}{if $card.issuer == ''}selected="selected"{/if}{/if}></option>
						{foreach from=$issuers item=issuer}
						{if $issuer.authorized}
						<option value="{$issuer.name}" {if isset($card.issuer)}{if ($card.issuer == $issuer.name)}selected="selected"{/if}{/if}>{$issuer.name}</option>
						{/if}
						{/foreach}
					</select>
				</p>
				{/if}

				{if $requireExpiration}
				<p class="required text">
					<label>
						{l s='Card expiry date' mod='creditcardofflinepayment'}
						{if $requiredExpiration}
							<sup>*</sup>
						{/if}
					</label>
					<select name="card[mes_caducidad]">
						<option value="" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == ''}selected="selected"{/if}{/if}></option>
						<option value="01" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '01'}selected="selected"{/if}{/if}>01</option>
						<option value="02" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '02'}selected="selected"{/if}{/if}>02</option>
						<option value="03" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '03'}selected="selected"{/if}{/if}>03</option>
						<option value="04" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '04'}selected="selected"{/if}{/if}>04</option>
						<option value="05" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '05'}selected="selected"{/if}{/if}>05</option>
						<option value="06" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '06'}selected="selected"{/if}{/if}>06</option>
						<option value="07" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '07'}selected="selected"{/if}{/if}>07</option>
						<option value="08" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '08'}selected="selected"{/if}{/if}>08</option>
						<option value="09" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '09'}selected="selected"{/if}{/if}>09</option>
						<option value="10" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '10'}selected="selected"{/if}{/if}>10</option>
						<option value="11" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '11'}selected="selected"{/if}{/if}>11</option>
						<option value="12" {if isset($card.mes_caducidad)}{if $card.mes_caducidad == '12'}selected="selected"{/if}{/if}>12</option>
					</select>
					<select name="card[ano_caducidad]" width="150px">
						<option value=""  {if isset($card.ano_caducidad)}{if $card.ano_caducidad == ""} selected="selected"{/if}{/if}></option>
						{*Function to get a select with the current year and 6 more *}
						{for $i=$smarty.now|date_format:"%Y" to ($smarty.now|date_format:"%Y")+5}
						<option value="{$i}" {if isset($card.ano_caducidad)}{if $card.ano_caducidad == $i}selected="selected"{/if}{/if}>{$i}</option>
						{/for}
					</select>
				</p>
				{/if}

				<br />
				<b>{l s='Confirm your order of' mod='creditcardofflinepayment'} <b class="price">{convertPriceWithCurrency price=$total currency=$currency}</b> {l s='by clicking the button "Confirm my order":' mod='creditcardofflinepayment'}</b>
				<p class="cart_navigation" id="buttons" style="padding-bottom: 0px">
					<a href="{$link->getPageLink('order', true, NULL, "step=3")}" class="button_large hideOnSubmit">{l s='Other payment methods' mod='creditcardofflinepayment'}</a>
					<input type="submit" name="paymentSubmit" value="{l s='Confirm my order' mod='creditcardofflinepayment'}" class="exclusive hideOnSubmit" onclick="procesando();" />
				</p>
				<p id="procesando" style="text-align:center;font-weight:bold;display:none;margin:20px 0 0 0;"><i>{l s='Processing...' mod='creditcardofflinepayment'}</i>&nbsp;&nbsp;&nbsp;<img src="/img/loadingAnimation.gif" width="208" height="13" vertical-align="middle" />
			</div>

		</fieldset>
	</form>
{/if}