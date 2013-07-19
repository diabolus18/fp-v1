<!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->
<script type="text/javascript">
{literal}
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
{/literal}
</script>
<h2>{$displayName} - {l s='Configuration' mod='creditcardofflinepayment'}</h2>

{if $errors|@count > 0}
	<div class="alert error">
		<h3>{l s='There are errors:' mod='creditcardofflinepayment'}</h3>
		<ol>
			{foreach from=$errors item=error}
				<li>{$error}</li>
			{/foreach}
		</ol>
	</div>
{/if}
{if $success}
	{$success}
{/if}

<br />
<div style="clear: both"></div>

<form action="{$smarty.server.REQUEST_URI}" method="post" class="half_form">
	
	<fieldset>
		<legend>
			<img src="../img/admin/edit.gif" />
			{l s='Module configuration' mod='creditcardofflinepayment'}
		</legend>

		<label>{l s='Working mode' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" onchange="javascript:showWM('1')" name="workingMode" value="1" {if $workingMode==1}checked="checked"{/if} />
			<label class="t">
				{l s='Send info by email' mod='creditcardofflinepayment'}
			</label>
			<input type="radio" onchange="javascript:showWM('2')" name="workingMode" value="2" {if $workingMode==2}checked="checked"{/if} />
			<label class="t">
				{l s='Store in database' mod='creditcardofflinepayment'}
			</label>
			<br />
			<span>{l s='- If you set "Send info by email", part of the credit card number will be stored in database and the other half sent by email. You will have to match information received from email with the one from Backoffice. This way you also follow' mod='creditcardofflinepayment'} <a href="https://www.pcisecuritystandards.org/security_standards/" target="_blank">PCI DSS</a> {l s='law.' mod='creditcardofflinepayment'}</span>
			<br />
			<span>{l s='- If you set "Store in database", whole credit card number will be stored in database and you will be able to check it from BackOffice. You can delete the card info afterwards.' mod='creditcardofflinepayment'}</span>
			<br /><br />
			<span><b>{l s='How you will see the credit card info:' mod='creditcardofflinepayment'}</b></span>
			<div id="bymail"><img src="{$this_path}img/bymail.png" /></div>
			<div id="indatabase"><img src="{$this_path}img/indatabase.png" /></div>
		</div>

		<label id="maillabel">{l s='Mail address' mod='creditcardofflinepayment'}:</label>
		<div id="mail" class="margin-form">
			<input type="text" name="adminMail" value="{$adminMail|escape:'htmlall':'UTF-8'}" size="35"/>
			<br />
			<span>{l s='Mail address where credit card information will be sent if you select "Send info by email" working mode' mod='creditcardofflinepayment'}</span>
		</div>	

		<label>{l s='Delete credit card info when the status change' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="checkbox" name="deleteInfo" {if $deleteInfo}checked="checked"{/if} />
			<br />
			<span>{l s='If enabled, the credit card data stored in database will be deleted automatically when you change an order from its initial status.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Order initial status' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">			
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<th style="width: 200px;font-weight: bold;">{l s='Status name' mod='creditcardofflinepayment'}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$states item=state}
					<tr style="background-color: {$state.color};">
						<td>{$state.name}</td>
						<td style="text-align:center"><input type="radio" name="id_os_initial" {if $state.id_order_state == $id_os_initial}checked="checked"{/if} value="{$state.id_order_state}"/></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<span>{l s='When a customer choose this payment method, the order will be left in this status.' mod='creditcardofflinepayment'}</span>
		</div>
	</fieldset>
	
	<div style="clear: both"></div>

	<br/>

	<fieldset>
		<legend>
			<img src="../img/admin/cog.gif" />
			{l s='Credit card configuration' mod='creditcardofflinepayment'}:
		</legend>

		<label>{l s='Request for Card Holder Name?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireIssuerName" value="1" {if $requireIssuerName}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireIssuerName" value="0" {if !$requireIssuerName}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredIssuerName" {if $requiredIssuerName}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers must enter their name.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request for ID Card/Passport?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireCedule" value="1" {if $requireCedule}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCedule" value="0" {if !$requireCedule}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCedule" {if $requiredCedule}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers must enter their identifity card.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request for address?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireAddress" value="1" {if $requireAddress}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireAddress" value="0" {if !$requireAddress}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredAddress" {if $requiredAddress}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers should enter an address.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request for zip code?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireZipCode" value="1" {if $requireZipCode}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireZipCode" value="0" {if !$requireZipCode}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredZipCode" {if $requiredZipCode}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customer should enter a zip code.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request for credit card number?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireCardNumber" value="1" {if $requireCardNumber}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCardNumber" value="0" {if !$requireCardNumber}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCardNumber" {if $requiredCardNumber}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers should enter their credit card number.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request CVC number?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireCVC" value="1" {if $requireCVC}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireCVC" value="0" {if !$requireCVC}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredCVC" {if $requiredCVC}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>
			<br />
			<span>{l s='Customers should enter the card CVC number.' mod='creditcardofflinepayment'}</span>
		</div>		
		
		<label>{l s='Request for credit card expiration date?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireExpiration" value="1" {if $requireExpiration}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireExpiration" value="0" {if !$requireExpiration}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredExpiration" {if $requiredExpiration}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers should enter month and year card expiration.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Request card issuer?' mod='creditcardofflinepayment'}:</label>
		<div class="margin-form">
			<input type="radio" name="requireIssuer" value="1" {if $requireIssuer}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Enabled' mod='creditcardofflinepayment'}" alt="{l s='Enabled' mod='creditcardofflinepayment'}" src="../img/admin/enabled.gif"/>
			</label>
			<input type="radio" name="requireIssuer" value="0" {if !$requireIssuer}checked="checked"{/if} />
			<label class="t">
				<img title="{l s='Disabled' mod='creditcardofflinepayment'}" alt="{l s='Disabled' mod='creditcardofflinepayment'}" src="../img/admin/disabled.gif"/>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="requiredIssuer" {if $requiredIssuer}checked="checked"{/if} />
			<label class="t">
				{l s='Required' mod='creditcardofflinepayment'}
			</label>			
			<br />
			<span>{l s='Customers should introduce the card issuer.' mod='creditcardofflinepayment'}</span>
		</div>

		<label>{l s='Card issuers' mod='creditcardofflinepayment'}:</label>

		<div class="margin-form">
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<th style="width: 200px;font-weight: bold;">{l s='Card issuer' mod='creditcardofflinepayment'}</th>
						<th>{l s='Enabled?' mod='creditcardofflinepayment'}</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$issuers item=issuer}
					<tr>
						<td>{$issuer.name}</td>
						<td style="text-align: center;"><input type="checkbox" name="issuers[]" value="{$issuer.id}" {if $issuer.authorized}checked="checked"{/if} /></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<span>{l s='Card issuers enabled to choose when making payment.' mod='creditcardofflinepayment'}</span>
		</div>
			

	</fieldset>	
	
	<div style="clear: both;"></div>
	<br />

	<center>
		<input type="submit" name="btnSubmit" value="{l s='Update settings' mod='creditcardofflinepayment'}" class="button" />
	</center>
	<hr />
</form>

<script type="text/javascript">
	javascript:showWM('{$workingMode}');
</script>