<?php
/*
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
*  @version  Release: $Revision: 17805 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
class CreditCardOfflinePaymentPaymentModuleFrontController extends ModuleFrontController
{
	public $ssl = true;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		$this->display_column_left = false;
		parent::initContent();

		$cart = $this->context->cart;
		if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
			Tools::redirect('index.php?controller=order&step=1');

			// Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
		$authorized = false;

		foreach (Module::getPaymentModules() as $module)
		{
			if ($module['name'] == 'creditcardofflinepayment')
			{
				$authorized = true;
				break;
			}
		}
		
		if (!$authorized)
			die($this->module->l('This payment method is not available.', 'payment'));		

		$customer = new Customer($cart->id_customer);
		if (!Validate::isLoadedObject($customer))
			Tools::redirect('index.php?controller=order&step=1');		

		if (!$this->module->checkCurrency($cart))
			Tools::redirect('index.php?controller=order');

		$this->context->smarty->assign(array(
			'nbProducts' 		=> $cart->nbProducts(),
			'default_currency' 	=> new Currency(Configuration::get('PS_CURRENCY_DEFAULT')),
			'currency'			=> new Currency(intval((int)$this->context->cookie->id_currency)),
			'id_currency'		=> (int)$this->context->cookie->id_currency,
			'total'				=> number_format($cart->getOrderTotal(true, 3), 2, '.', ''),
			'issuers'			=> CreditCardOfflinePaymentBrands::getIssuers(),
			'errores' 			=> null,
			'requireIssuerName' => Configuration::get('CCOFFLINE_REQUIREISSUERNAME') == '1' ? true : false,
			'requiredIssuerName'=> Configuration::get('CCOFFLINE_REQUIREDISSUERNAME') == '1' ? true : false,
			'requireCedule'		=> Configuration::get('CCOFFLINE_REQUIRECED') == '1' ? true : false,
			'requiredCedule'	=> Configuration::get('CCOFFLINE_REQUIREDCED') == '1' ? true : false,
			'requireAddress'	=> Configuration::get('CCOFFLINE_REQUIREADDRESS') == '1' ? true : false,
			'requiredAddress'	=> Configuration::get('CCOFFLINE_REQUIREDADDRESS') == '1' ? true : false,
			'requireZipCode'	=> Configuration::get('CCOFFLINE_REQUIREZIPCODE') == '1' ? true : false,
			'requiredZipCode'	=> Configuration::get('CCOFFLINE_REQUIREDZIPCODE') == '1' ? true : false,
			'requireCardNumber' => Configuration::get('CCOFFLINE_REQUIRECARDNUMBER') == '1' ? true : false,
			'requiredCardNumber'=> Configuration::get('CCOFFLINE_REQUIREDCARDNUMBER') == '1' ? true : false,
			'requireIssuer' 	=> Configuration::get('CCOFFLINE_REQUIREISSUER') == '1' ? true : false,
			'requiredIssuer' 	=> Configuration::get('CCOFFLINE_REQUIREDISSUER') == '1' ? true : false,
			'requireExpiration'	=> Configuration::get('CCOFFLINE_REQUIREEXP') == '1' ? true : false,
			'requiredExpiration'=> Configuration::get('CCOFFLINE_REQUIREDEXP') == '1' ? true : false,
			'requireCVC'		=> Configuration::get('CCOFFLINE_REQUIRECVC') == '1' ? true : false,
			'requiredCVC'		=> Configuration::get('CCOFFLINE_REQUIREDCVC') == '1' ? true : false,
			'this_path' 		=> $this->module->getPathUri(),
			'this_path_ssl' 	=> Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
			'mobile_device' 	=> $this->context->getMobileDevice(),
		));

		$this->setTemplate('payment_execution.tpl');
	}
}