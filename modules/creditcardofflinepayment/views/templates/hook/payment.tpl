<!--
 * idnovate.com
 * Credit Card Offline Payment Module
-->

{if $currency_authorized}
<p class="payment_module">
	<a href="{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}{$this_path_ssl}payment.php{else}{$link->getModuleLink('creditcardofflinepayment', 'payment', [], true)}{/if}" title="{l s='Pay with credit card' mod='creditcardofflinepayment'}">
		<img src="{$this_path}creditcardofflinepayment.jpg" alt="{l s='Pay with credit card' mod='creditcardofflinepayment'}" width="86px" height="57px"/>
		{l s='Pay with credit card' mod='creditcardofflinepayment'}
	</a>
</p>
{else}
<p class="payment_module">
	<a href="#" style="cursor:not-allowed;" title="{l s='Pay with credit card' mod='creditcardofflinepayment'}">
		<img src="{$this_path}creditcardofflinepayment.jpg" alt="{l s='Pay with credit card' mod='creditcardofflinepayment'}" />
		{l s='Payment with credit card is not enabled with this currency' mod='creditcardofflinepayment'}
	</a>
</p>
{/if}