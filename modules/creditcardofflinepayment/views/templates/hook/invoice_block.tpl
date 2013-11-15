<!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->
{literal}
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
				data: 'id_order=' + '{/literal}{$id_order}{literal}' + '&token=' + '{/literal}{$token}{literal}',
				success: function() {$('#invoice_block').hide();},
				error: function(data) {alert('ERROR: unable to delete the info' + data);}
			})
		})
	});
</script>
{/literal}

<br />
<fieldset id="invoice_block" {if version_compare($smarty.const._PS_VERSION_,'1.5','<')}style="width:400px"{/if}>
    <legend>
    	<img src="{$this_path}logo.gif"/> {l s='Credit card payment information' mod='creditcardofflinepayment'}
    </legend>
	<div style="float:left">
		{if isset($nombre_titular) and $nombre_titular <> ''}
			{l s='Card holder name' mod='creditcardofflinepayment'}: <b>{$nombre_titular|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		{if isset($cedula) and $cedula <> ''}
			{l s='ID Card/Passport' mod='creditcardofflinepayment'}: <b>{$cedula|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		{if isset($direccion) and $direccion <> ''}
			{l s='Address' mod='creditcardofflinepayment'}: <b>{$direccion|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		{if isset($tipo_tarjeta) and $tipo_tarjeta <> ''}
			{l s='Card holder issuer' mod='creditcardofflinepayment'}: <b>{$tipo_tarjeta|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		{if isset($cp) and $cp <> ''}
			{l s='Zip Code' mod='creditcardofflinepayment'}: <b>{$cp|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		{if isset($pan) and $pan <> ''}
			{l s='Credit card number' mod='creditcardofflinepayment'}: <span style="color:red; background-image:url(http://www.fontenille-pataud.com/img/cms/Back%20office/background-cb%20copie_5.jpg);"><b>{$pan|spacify}</b></span><br/>
		{/if}
		{if isset($mes_caducidad) and $mes_caducidad <> ''}
			{l s='Expiry Month/Year' mod='creditcardofflinepayment'}: <b>{$mes_caducidad|escape:'htmlall':'UTF-8'}/{if isset($ano_caducidad)}{$ano_caducidad|escape:'htmlall':'UTF-8'}{/if}</b></br>
		{/if}
		{if isset($cvc) and $cvc <> ''}
			{l s='CVC' mod='creditcardofflinepayment'}: <b>{$cvc|escape:'htmlall':'UTF-8'}</b></br>
		{/if}
		
		
		
		{if isset($importe) and $importe <> ''}
			{l s='Amount' mod='creditcardofflinepayment'}: <b>{$importe|escape:'htmlall':'UTF-8'} {if isset($moneda)}{$moneda|escape:'htmlall':'UTF-8'}{/if}</b></br>
		{/if}
	</div>
	<div style="float:right;cursor:pointer" id="deleteInfo">
		<img src="../img/admin/disabled.gif" alt="{l s='Delete' mod='creditcardofflinepayment'}">
		<span>{l s='Delete info' mod='creditcardofflinepayment'}</span>		
	</div>
</fieldset>