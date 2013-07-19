<!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

<br />
{if $success == true}
	<p>{l s='Your order in' mod='creditcardofflinepayment'} <span class="bold">{$shop_name}</span> {l s='is completed.' mod='creditcardofflinepayment'}
		<br /><br />
		{l s='When your order is verified and the payment accepted, your order will be sent.' mod='creditcardofflinepayment'}
		<br /><br />- {l s='Order total amount:' mod='creditcardofflinepayment'} <span class="price">{$total_to_pay}</span>
		<br /><br />{l s='If you have any issue, please contact our' mod='creditcardofflinepayment'} <a href="{$base_dir}contact-form.php">{l s='Customer Service' mod='creditcardofflinepayment'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='There has been a problem with your order. Please contact our' mod='creditcardofflinepayment'} <a href="{$base_dir}contact-form.php">{l s='Customer Service' mod='creditcardofflinepayment'}</a>.
	</p>
{/if}