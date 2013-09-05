{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- CS Block header links -->
<div id="cs_header_link">
	<ul id="cs_header_links">	
		<li id="cs_header_user_info">
		{l s='Welcome' mod='csheaderlink'}
		{if $logged}
			<a href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' mod='csheaderlink'}" class="account" rel="nofollow"><span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
			<a href="{$link->getPageLink('index', true, NULL, "mylogout")}" title="{l s='Log me out' mod='csheaderlink'}" class="logout" rel="nofollow">{l s='Log out' mod='csheaderlink'}</a>
		{else}
			<a href="{$link->getPageLink('my-account', true)}" title="{l s='Login to your customer account' mod='csheaderlink'}" class="login" rel="nofollow">{l s='Login' mod='csheaderlink'}</a>
			<a href="{$link->getPageLink('my-account', true)}" title="{l s='Login to your customer account' mod='csheaderlink'}" class="login" rel="nofollow">{l s='Wholesale' mod='csheaderlink'}</a>
		{/if}
		</li>
		<li id="cs_your_account"><a href="{$link->getPageLink('my-account', true)}" title="{l s='View my customer account' mod='csheaderlink'}" rel="nofollow">{l s='My Account' mod='csheaderlink'}</a></li>
	</ul>
	
</div>
<!-- /Block user information module HEADER -->
