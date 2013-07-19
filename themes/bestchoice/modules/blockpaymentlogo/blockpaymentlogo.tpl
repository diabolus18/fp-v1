{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block payment logo module -->
<div id="paiement_logo_block_left" class="paiement_logo_block">
	<h4>payment</h4>
	<a href="{$link->getCMSLink($cms_payement_logo)}" title="paypal">	
		<img src="{$img_dir}logo_paiement_paypal.png" alt="paypal" />
	</a>
	<a href="{$link->getCMSLink($cms_payement_logo)}" title="visa">
		<img src="{$img_dir}logo_paiement_visa.png" alt="visa"/></a>
	<a href="{$link->getCMSLink($cms_payement_logo)}" title="mastercard">	
		<img src="{$img_dir}logo_paiement_mastercard.png" alt="mastercard" /></a>
	<a href="{$link->getCMSLink($cms_payement_logo)}" title="american">	
		<img src="{$img_dir}i_american.png" alt="american" /></a>
	
</div>
<!-- /Block payment logo module -->