<?php
/*
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
*/

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'/paypal/api/paypal_lib.php');
include_once(_PS_MODULE_DIR_.'/paypal/paypal_logos.php');
include_once(_PS_MODULE_DIR_.'/paypal/paypal_orders.php');
include_once(_PS_MODULE_DIR_.'/paypal/paypal_tools.php');

define('WPS', 1);
define('HSS', 2);
define('ECS', 4);

define('TRACKING_CODE', 'FR_PRESTASHOP_H3S');
define('SMARTPHONE_TRACKING_CODE', 'Prestashop_Cart_smartphone_EC');
define('TABLET_TRACKING_CODE', 'Prestashop_Cart_tablet_EC');

define('_PAYPAL_LOGO_XML_', 'logos.xml');
define('_PAYPAL_MODULE_DIRNAME_', 'paypal');
define('_PAYPAL_TRANSLATIONS_XML_', 'translations.xml');

class PayPal extends PaymentModule
{
	protected $_html = '';

	public $_errors	= array();

	public $context;
	public $iso_code;
	public $default_country;

	public $paypal_logos;

	public $module_key = '646dcec2b7ca20c4e9a5aebbbad98d7e';

	const BACKWARD_REQUIREMENT = '0.4';
	const DEFAULT_COUNTRY_ISO = 'GB';

	const ONLY_PRODUCTS	= 1;
	const ONLY_DISCOUNTS = 2;
	const BOTH = 3;
	const BOTH_WITHOUT_SHIPPING	= 4;
	const ONLY_SHIPPING	= 5;
	const ONLY_WRAPPING	= 6;
	const ONLY_PRODUCTS_WITHOUT_SHIPPING = 7;
	const INSTALL_SQL_FILE = 'install.sql';

	public function __construct()
	{
		$this->name = 'paypal';
		$this->tab = 'payments_gateways';
		$this->version = '3.5.8';

		$this->currencies = true;
		$this->currencies_mode = 'radio';

		parent::__construct();
		
		$this->displayName = $this->l('PayPal with fee by Alabazweb.com');
		$this->description = $this->l('Accepts payments by credit cards (CB, Visa, MasterCard, Amex, Aurore, Cofinoga, 4 stars) with PayPal.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');

		$this->page = basename(__FILE__, '.php');

		if (_PS_VERSION_ < '1.5')
		{
			$mobile_enabled = (int)Configuration::get('PS_MOBILE_DEVICE');
			require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
		}
		else
			$mobile_enabled = (int)Configuration::get('PS_ALLOW_MOBILE_DEVICE');

		if (self::isInstalled($this->name))
		{
			$this->loadDefaults();
			if ($mobile_enabled && $this->active)
				$this->checkMobileCredentials();
			elseif ($mobile_enabled && !$this->active)
				$this->checkMobileNeeds();
		}
		else
			$this->checkMobileNeeds();
	}

	public function install()
	{
		//Instala la tabla para almacenar las operaciones en la pasarela
		if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
			return (false);
		else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
			return (false);
		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		$sql = preg_split("/;\s*[\r\n]+/",$sql);
		foreach ($sql AS $k=>$query)
			Db::getInstance()->Execute(trim($query));
			
		if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('paymentReturn') ||
		!$this->registerHook('shoppingCartExtra') || !$this->registerHook('backBeforePayment') || !$this->registerHook('rightColumn') ||
		!$this->registerHook('cancelProduct') || !$this->registerHook('productFooter') || !$this->registerHook('header') ||
		!$this->registerHook('adminOrder') || !$this->registerHook('backOfficeHeader')
		)
			return false;

		if ((_PS_VERSION_ >= '1.5') && (!$this->registerHook('displayMobileHeader') ||
		!$this->registerHook('displayMobileShoppingCartTop') || !$this->registerHook('displayMobileAddToCartTop') OR !$this->registerHook('displayOrderDetail')))
			return false;
		
		if ((_PS_VERSION_ < '1.5') && (!$this->registerHook('orderDetailDisplayed')))
			return false;
		
		if (_PS_VERSION_ < '1.5'){
			if (!is_writable(_PS_ROOT_DIR_.'/override/classes')) {
				$msg = $this->l('For module installation please allow write access to folder').' '._PS_ROOT_DIR_.' override/classes';
				die($msg);
			}
			else 
			{
				@copy(_PS_ROOT_DIR_.'/override/classes/PDF.php', _PS_ROOT_DIR_.'/override/classes/PDF-'.date(Ymd).'.old');
				if (!@copy(_PS_MODULE_DIR_.'paypal/override/classes/_PDF.php', _PS_ROOT_DIR_.'/override/classes/PDF.php')) {
					$msg= self::displayError($this->l('Could not write file').' '._PS_ROOT_DIR_.'/override/classes/PDF.php').'<p><a href="?tab=AdminModules&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)) . '"><img src="../img/admin/arrow2.gif" />'.$this->l('Back to modules list').'</a></p>';
					die($msg);
				}
				@copy(_PS_ROOT_DIR_.'/override/classes/Order.php', _PS_ROOT_DIR_.'/override/classes/Order-'.date(Ymd).'.old');
				if (!@copy(_PS_MODULE_DIR_.'paypal/override/classes/order/Order.php', _PS_ROOT_DIR_.'/override/classes/Order.php')) {
					$msg= self::displayError($this->l('Could not write file').' '._PS_ROOT_DIR_.'/override/classes/Order.php').'<p><a href="?tab=AdminModules&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)) . '"><img src="../img/admin/arrow2.gif" />'.$this->l('Back to modules list').'</a></p>';
					die($msg);
				}
			}
		}

		include_once(_PS_MODULE_DIR_.'/'.$this->name.'/paypal_install.php');
		$paypal_install = new PayPalInstall();
		$paypal_install->createTables();
		$paypal_install->updateConfiguration($this->version);
		$paypal_install->createOrderState();

		$paypal_tools = new PayPalTools($this->name);
		$paypal_tools->moveTopPayments(1);
		$paypal_tools->moveRightColumn(3);

		$this->runUpgrades(true);
		
		if (is_writable(_PS_THEME_DIR_))
		{
			$pdfDir = _PS_THEME_DIR_.'pdf';
			//create the new directory
			if(!is_dir($pdfDir))
			{
				$newDir = mkdir($pdfDir, 0777);
			}
			@copy(_PS_MODULE_DIR_.'paypal/themes/pdf/invoice.tpl', _PS_THEME_DIR_.'/pdf/invoice.tpl');
			@copy(_PS_MODULE_DIR_.'paypal/themes/pdf/invoice.tax-tab.tpl', _PS_THEME_DIR_.'/pdf/invoice.tax-tab.tpl');
		}
		Configuration::updateValue('PAYPAL_FEE', '0.35');
		Configuration::updateValue('PAYPAL_PCTFEE', '3.5');
		
		return true;
	}

	public function uninstall()
	{
		include_once(_PS_MODULE_DIR_.'/'.$this->name.'/paypal_install.php');
		$paypal_install = new PayPalInstall();
		$paypal_install->deleteConfiguration();
		return parent::uninstall();
	}

	/**
	 * Launch upgrade process
	 */
	public function runUpgrades($install = false)
	{
		if (file_exists(_PS_MODULE_DIR_.'/paypalapi/paypalapi.php') && !Configuration::get('PAYPAL_NEW'))
		{
			include_once(_PS_MODULE_DIR_.'/paypalapi/paypalapi.php');
			new PaypalAPI();

			if (_PS_VERSION_ < '1.5')
				foreach (array('2.8', '3.0') as $version)
				{
					$file = dirname(__FILE__).'/upgrade/install-'.$version.'.php';
					if (Configuration::get('PAYPAL_VERSION') < $version && file_exists($file))
					{
						include_once($file);
						call_user_func('upgrade_module_'.str_replace('.', '_', $version), $this, $install);
					}
				}
		}
	}

	private function compatibilityCheck()
	{
		if (file_exists(_PS_MODULE_DIR_.'/paypalapi/paypalapi.php') && $this->active)
			$this->warning = $this->l('All features of Paypal API module are included in the new Paypal module. In order to do not have any conflict, please do not use and remove PayPalAPI module.').'<br />';

		/* For 1.4.3 and less compatibility */
		$updateConfig = array('PS_OS_CHEQUE' => 1, 'PS_OS_PAYMENT' => 2, 'PS_OS_PREPARATION' => 3, 'PS_OS_SHIPPING' => 4,
		'PS_OS_DELIVERED' => 5, 'PS_OS_CANCELED' => 6, 'PS_OS_REFUND' => 7, 'PS_OS_ERROR' => 8, 'PS_OS_OUTOFSTOCK' => 9,
		'PS_OS_BANKWIRE' => 10, 'PS_OS_PAYPAL' => 11, 'PS_OS_WS_PAYMENT' => 12);

		foreach ($updateConfig as $key => $value)
			if (!Configuration::get($key) || (int)Configuration::get($key) < 1)
			{
				if (defined('_'.$key.'_') && (int)constant('_'.$key.'_') > 0)
					Configuration::updateValue($key, constant('_'.$key.'_'));
				else
					Configuration::updateValue($key, $value);
			}
	}

	public function isPayPalAPIAvailable()
	{
		$payment_method = Configuration::get('PAYPAL_PAYMENT_METHOD');

		if ($payment_method != HSS && !is_null(Configuration::get('PAYPAL_API_USER')) &&
		!is_null(Configuration::get('PAYPAL_API_PASSWORD')) && !is_null(Configuration::get('PAYPAL_API_SIGNATURE')))
			return true;
		elseif ($payment_method == HSS && !is_null(Configuration::get('PAYPAL_BUSINESS_ACCOUNT')))
			return true;

		return false;
	}

	/**
	 * Initialize default values
	 */
	protected function loadDefaults()
	{
		$this->loadLangDefault();
		$this->paypal_logos = new PayPalLogos($this->iso_code);
		$payment_method = Configuration::get('PAYPAL_PAYMENT_METHOD');
		$order_process_type = (int)Configuration::get('PS_ORDER_PROCESS_TYPE');

		if (Tools::getValue('paypal_ec_canceled') || $this->context->cart === false)
			unset($this->context->cookie->express_checkout);

		if (_PS_VERSION_ >= '1.5.0.2')
		{
			$version = Db::getInstance()->getValue('SELECT version FROM `'._DB_PREFIX_.'module` WHERE name = \''.$this->name.'\'');
			if (empty($version) === true)
			{
				Db::getInstance()->execute('
					UPDATE `'._DB_PREFIX_.'module` m
					SET m.version = \''.bqSQL($this->version).'\'
					WHERE m.name = \''.bqSQL($this->name).'\'');
			}
		}

		if (defined('_PS_ADMIN_DIR_'))
		{
			/* Backward compatibility */
			if (_PS_VERSION_ < '1.5')
				$this->backwardCompatibilityChecks();

			/* Upgrade and compatibility checks */
			$this->runUpgrades();
			$this->compatibilityCheck();
			$this->warningsCheck();
		}
		else
		{
			if (isset($this->context->cookie->express_checkout))
				$this->context->smarty->assign('paypal_authorization', true);

			if (($order_process_type == 1) && ((int)$payment_method == HSS) && !$this->useMobile())
				$this->context->smarty->assign('paypal_order_opc', true);
			elseif (($order_process_type == 1) && ((bool)Tools::getValue('isPaymentStep') == true))
			{
				$shop_url = PayPal::getShopDomainSsl(true, true);
				if (_PS_VERSION_ < '1.5')
				{
					$link = $shop_url._MODULE_DIR_.$this->name.'/express_checkout/payment.php';
					$this->context->smarty->assign('paypal_confirmation', $link.'?'.http_build_query(array('get_confirmation' => true), '', '&'));
				}
				else
				{
					$values = array('fc' => 'module', 'module' => 'paypal', 'controller' => 'confirm', 'get_confirmation' => true);
					$this->context->smarty->assign('paypal_confirmation', $shop_url.__PS_BASE_URI__.'?'.http_build_query($values));
				}
			}
		}
	}

	protected function checkMobileCredentials()
	{
		$payment_method = Configuration::get('PAYPAL_PAYMENT_METHOD');

		if (((int)$payment_method == HSS) && (
			(!(bool)Configuration::get('PAYPAL_API_USER')) &&
			(!(bool)Configuration::get('PAYPAL_API_PASSWORD')) &&
			(!(bool)Configuration::get('PAYPAL_API_SIGNATURE'))))
			$this->warning .= $this->l('You must set your PayPal Integral credentials in order to have the mobile theme work correctly.').'<br />';
	}

	protected function checkMobileNeeds()
	{
		$iso_code = Country::getIsoById((int)Configuration::get('PS_COUNTRY_DEFAULT'));
		$paypal_countries = array('ES', 'FR', 'PL', 'IT');

		if (method_exists($this->context->shop, 'getTheme'))
		{
			if (($this->context->shop->getTheme() == 'default') && in_array($iso_code, $paypal_countries))
				$this->warning .= $this->l('The mobile theme only works with the PayPal\'s payment module at this time. Please activate the module to enable payments.').'<br />';
		}
		else
			$this->warning .= $this->l('In order to use the module you need to install the backward compatibility.').'<br />';
	}

	/* Check status of backward compatibility module*/
	protected function backwardCompatibilityChecks()
	{
		if (Module::isInstalled('backwardcompatibility'))
		{
			$backward_module = Module::getInstanceByName('backwardcompatibility');
			if (!$backward_module->active)
				$this->warning .= $this->l('To work properly the module requires the backward compatibility module enabled').'<br />';
			elseif ($backward_module->version < PayPal::BACKWARD_REQUIREMENT)
				$this->warning .= $this->l('To work properly the module requires at least the backward compatibility module v').PayPal::BACKWARD_REQUIREMENT.'.<br />';
		}
		else
			$this->warning .= $this->l('In order to use the module you need to install the backward compatibility.').'<br />';
	}
	public function _displayContent()
	{
		if (($id_lang = Language::getIdByIso('EN')) == 0)
			$english_language_id = (int)$this->context->employee->id_lang;
		else
			$english_language_id = (int)$id_lang;
		
		
		$taxRules = TaxRulesGroup::getTaxRulesGroups(true);
		$taxes = array();
		foreach ($taxRules AS $row){
			$taxes[$row['id_tax_rules_group']] = $row['name'];
		}
			
		$this->context->smarty->assign(array(
			'PayPal_WPS' => (int)WPS,
			'PayPal_HSS' => (int)HSS,
			'PayPal_ECS' => (int)ECS,
			'PP_errors' => $this->_errors,
			'PayPal_logo' => $this->paypal_logos->getLogos(),
			'PayPal_allowed_methods' => $this->getPaymentMethods(),
			'PayPal_country' => Country::getNameById((int)$english_language_id, (int)$this->default_country),
			'PayPal_country_id' => (int)$this->default_country,
			'PayPal_business' => Configuration::get('PAYPAL_BUSINESS'),
			'PayPal_payment_method'	=> (int)Configuration::get('PAYPAL_PAYMENT_METHOD'),
			'PayPal_api_username' => Configuration::get('PAYPAL_API_USER'),
			'PayPal_api_password' => Configuration::get('PAYPAL_API_PASSWORD'),
			'PayPal_api_signature' => Configuration::get('PAYPAL_API_SIGNATURE'),
			'PayPal_api_business_account' => Configuration::get('PAYPAL_BUSINESS_ACCOUNT'),
			'PayPal_express_checkout_shortcut' => (int)Configuration::get('PAYPAL_EXPRESS_CHECKOUT_SHORTCUT'),
			'PayPal_sandbox_mode' => (int)Configuration::get('PAYPAL_SANDBOX'),
			'PayPal_payment_capture' => (int)Configuration::get('PAYPAL_CAPTURE'),
			'PayPal_country_default' => (int)$this->default_country,
			'PayPal_change_country_url' => 'index.php?tab=AdminCountries&token='.Tools::getAdminTokenLite('AdminCountries').'#footer',
			'Countries'	=> Country::getCountries($english_language_id),
			'One_Page_Checkout'	=> (int)Configuration::get('PS_ORDER_PROCESS_TYPE'),
			'PayPal_fee'=> Configuration::get('PAYPAL_FEE'),
			'PayPal_pctfee'=> Configuration::get('PAYPAL_PCTFEE'),
			'PayPal_tax'=> Configuration::get('PAYPAL_TAX'),
			'taxes'=> $taxes)
		);

		$this->getTranslations();

		$output = $this->fetchTemplate('/views/templates/back/back_office.tpl');

		if ($this->active == false)
			return $output.$this->hookBackOfficeHeader();
		return $output;
	}
	public function _productKey() 
	{
		$output ='<fieldset>
		<div style="float:left;width:100%;">';
		
		$output .= '	<form method="post" name="mc" action="">
						  	<label for="id_group">'.$this->l('Product Key:').'</label>
						  		<div class="margin-form">
											<input size="40" type="text" name="productKey" id="productKey"  value="" />
											<a href="http://www.alabazweb.com/modules/megakeys/mymodules.php">'.$this->l('Generate Key').'</a>	
								</div>
							<center>
							<br/>
							<input type="submit" class="button" name="submitKey" value="'.$this->l('Save Key').'">
							</center>
							</form>';
		return $output;
	}
	public function getContent()
	{
		$this->_postProcess();
		
		$output = '';
				
		eval(gzinflate(base64_decode(strrev('==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'))));
		return $output;
	}

	/**
	 * Hooks methods
	 */
	public function hookHeader()
	{
		if ($this->useMobile())
		{
			$id_hook = (int)Configuration::get('PS_MOBILE_HOOK_HEADER_ID');
			if ($id_hook > 0)
			{
				$module = Hook::getModuleFromHook($id_hook, $this->id);
				if (!$module)
					$this->registerHook('displayMobileHeader');
			}
		}

		if (isset($this->context->cart) && $this->context->cart->id)
			$this->context->smarty->assign('id_cart', (int)$this->context->cart->id);

		/* Added for PrestaBox */
		if (method_exists($this->context->controller, 'addCSS'))
			$this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/css/paypal.css');
		else
			Tools::addCSS(_MODULE_DIR_.$this->name.'/css/paypal.css');

		return '<script type="text/javascript">'.$this->fetchTemplate('paypal.js').'</script>';
	}

	public function hookDisplayMobileHeader()
	{
		return $this->hookHeader();
	}

	public function hookDisplayMobileShoppingCartTop()
	{
		return $this->renderExpressCheckoutButton('cart').$this->renderExpressCheckoutForm('cart');
	}

	public function hookDisplayMobileAddToCartTop()
	{
		return $this->renderExpressCheckoutButton('cart');
	}

	public function hookProductFooter()
	{
		$content = (!$this->useMobile()) ? $this->renderExpressCheckoutButton('product') : null;
		return $content.$this->renderExpressCheckoutForm('product');
	}

	public function hookPayment($params)
	{
		if (!$this->active)
			return;

		$use_mobile = $this->useMobile();

		if ($use_mobile)
			$method = ECS;
		else
			$method = (int)Configuration::get('PAYPAL_PAYMENT_METHOD');

		if (isset($this->context->cookie->express_checkout))
			$this->redirectToConfirmation();

		$this->context->smarty->assign(array(
			'logos' => $this->paypal_logos->getLogos(),
			'sandbox_mode' => Configuration::get('PAYPAL_SANDBOX'),
			'use_mobile' => $use_mobile,
			'PayPal_lang_code' => (isset($iso_lang[$this->context->language->iso_code])) ? $iso_lang[$this->context->language->iso_code] : 'en_US'
		));

		if ($method == HSS)
		{
			$billing_address = new Address($this->context->cart->id_address_invoice);
			$delivery_address = new Address($this->context->cart->id_address_delivery);
			$billing_address->country = new Country($billing_address->id_country);
			$delivery_address->country = new Country($delivery_address->id_country);
			$billing_address->state	= new State($billing_address->id_state);
			$delivery_address->state = new State($delivery_address->id_state);

			$cart = $this->context->cart;
			$cart_details = $cart->getSummaryDetails(null, true);

			if ((int)Configuration::get('PAYPAL_SANDBOX') == 1)
				$action_url = 'https://securepayments.sandbox.paypal.com/acquiringweb';
			else
				$action_url = 'https://securepayments.paypal.com/acquiringweb';

			$shop_url = PayPal::getShopDomainSsl(true, true);

			$this->context->smarty->assign(array(
				'action_url' => $action_url,
				'cart' => $cart,
				'cart_details' => $cart_details,
				'currency' => new Currency((int)$cart->id_currency),
				'customer' => $this->context->customer,
				'business_account' => Configuration::get('PAYPAL_BUSINESS_ACCOUNT'),
				'custom' => Tools::jsonEncode(array('id_cart' => $cart->id, 'hash' => sha1(serialize($cart->nbProducts())))),
				'gift_price' => (float)$this->getGiftWrappingPrice(),
				'billing_address' => $billing_address,
				'delivery_address' => $delivery_address,
				'shipping' => $cart_details['total_shipping_tax_exc'],
				'subtotal' => $cart_details['total_price_without_tax'] - $cart_details['total_shipping_tax_exc'],
				'time' => time(),
				'cancel_return' => $this->context->link->getPageLink('order.php'),
				'notify_url' => $shop_url._MODULE_DIR_.$this->name.'/integral_evolution/notifier.php',
				'return_url' => $shop_url._MODULE_DIR_.$this->name.'/integral_evolution/submit.php?id_cart='.(int)$cart->id,
				'tracking_code' => $this->getTrackingCode(), 
				'iso_code' => strtoupper($this->context->language->iso_code)
			));

			return $this->fetchTemplate('integral_evolution_payment.tpl');
		}
		elseif ($method == WPS || $method == ECS)
		{
			$this->getTranslations();
			$this->context->smarty->assign(array(
				'PayPal_integral' => WPS,
				'PayPal_express_checkout' => ECS,
				'PayPal_payment_method' => $method,
				'PayPal_payment_type' => 'payment_cart',
				'PayPal_current_page' => $this->getCurrentUrl(),
				'PayPal_tracking_code' => $this->getTrackingCode(),
				'fee' => $this->getCost($this->context->cart)));

			return $this->fetchTemplate('express_checkout_payment.tpl');
		}
		
		return null;
	}

	public function hookShoppingCartExtra()
	{
		// No active
		if (!$this->active || (((int)Configuration::get('PAYPAL_PAYMENT_METHOD') == HSS) && !$this->context->getMobileDevice()) ||
			!Configuration::get('PAYPAL_EXPRESS_CHECKOUT_SHORTCUT') || !in_array(ECS, $this->getPaymentMethods()) || isset($this->context->cookie->express_checkout))
			return null;

		$values = array('en' => 'en_US', 'fr' => 'fr_FR');
		$this->context->smarty->assign(array(
			'PayPal_payment_type' => 'cart',
			'PayPal_current_page' => $this->getCurrentUrl(),
			'PayPal_lang_code' => (isset($values[$this->context->language->iso_code]) ? $values[$this->context->language->iso_code] : 'en_US'),
			'PayPal_tracking_code' => $this->getTrackingCode(),
			'include_form' => true,
			'template_dir' => dirname(__FILE__).'/views/templates/hook/'));

		return $this->fetchTemplate('express_checkout_shortcut_button.tpl');
	}

	public function hookPaymentReturn()
	{
		if (!$this->active)
			return null;

		return $this->fetchTemplate('confirmation.tpl');
	}

	public function hookRightColumn()
	{
		$this->context->smarty->assign('logo', $this->paypal_logos->getCardsLogo(true));
		return $this->fetchTemplate('column.tpl');
	}

	public function hookLeftColumn()
	{
		return $this->hookRightColumn();
	}

	public function hookBackBeforePayment($params)
	{
		if (!$this->active)
			return null;

		/* Only execute if you use PayPal API for payment */
		if (((int)Configuration::get('PAYPAL_PAYMENT_METHOD') != HSS) && $this->isPayPalAPIAvailable())
		{
			if ($params['module'] != $this->name || !$this->context->cookie->paypal_token || !$this->context->cookie->paypal_payer_id)
				return false;
			Tools::redirect('modules/'.$this->name.'/express_checkout/submit.php?confirm=1&token='.$this->context->cookie->paypal_token.'&payerID='.$this->context->cookie->paypal_payer_id);
		}
	}

	public function hookAdminOrder($params)
	{
		if (Tools::isSubmit('submitPayPalCapture'))
			$this->_doCapture($params['id_order']);
		elseif (Tools::isSubmit('submitPayPalRefund'))
			$this->_doTotalRefund($params['id_order']);

		$adminTemplates = array();
		if ($this->isPayPalAPIAvailable())
		{
			if ($this->_needValidation((int)$params['id_order']))
				$adminTemplates[] = 'validation';
			if ($this->_needCapture((int)$params['id_order']))
				$adminTemplates[] = 'capture';
			if ($this->_canRefund((int)$params['id_order']))
				$adminTemplates[] = 'refund';
		}

		if (count($adminTemplates) > 0)
		{
			$order = new Order((int)$params['id_order']);

			if (_PS_VERSION_ >= '1.5')
				$order_state = $order->current_state;
			else
				$order_state = OrderHistory::getLastOrderState($order->id);

			$this->context->smarty->assign(
				array(
					'authorization' => (int)Configuration::get('PAYPAL_OS_AUTHORIZATION'),
					'base_url' => _PS_BASE_URL_.__PS_BASE_URI__,
					'module_name' => $this->name,
					'order_state' => $order_state,
					'params' => $params,
					'ps_version' => _PS_VERSION_
				)
			);

			foreach ($adminTemplates as $adminTemplate)
			{
				$this->_html .= $this->fetchTemplate('/views/templates/back/admin_order/'.$adminTemplate.'.tpl');
				$this->_postProcess();
				$this->_html .= '</fieldset>';
			}

			if(isset($order) && $order->payment_fee!=0 && $order->module == 'paypal')
			{
			
			$this->_html .= '<br /><fieldset style="width: 400px;">
				<legend><img alt="'.$this->l('Connexion').'" src="'.$this->_path.'logo.gif"/> '.$this->l('Paypal fee').'</legend>
				<form method="post" action="">';
			$this->_html .= '<p class="center">
					
				<label for="load_last_cart" class="t">';
				$this->_html .= $this->l('Fee applied for Paypal:');
				$this->_html .= ' <span style="color:red">'.Tools::displayPrice($order->payment_fee). '</span></label>
					</p>
				</form>
				</fieldset>';
			}
		}

		return $this->_html;
	}

	public function hookCancelProduct($params)
	{
		if (Tools::isSubmit('generateDiscount') || !$this->isPayPalAPIAvailable())
			return false;
		elseif ($params['order']->module != $this->name || !($order = $params['order']) || !Validate::isLoadedObject($order))
			return false;
		elseif (!$order->hasBeenPaid())
			return false;

		$order_detail = new OrderDetail((int)$params['id_order_detail']);
		if (!$order_detail || !Validate::isLoadedObject($order_detail))
			return false;

		$paypal_order = PayPalOrder::getOrderById((int)$order->id);
		if (!$paypal_order)
			return false;

		$products = $order->getProducts();
		$cancel_quantity = Tools::getValue('cancelQuantity');
		$message = $this->l('Cancel products result:').'<br>';

		$amount = (float)($products[(int)$order_detail->id]['product_price_wt'] * (int)$cancel_quantity[(int)$order_detail->id]);
		$refund = $this->_makeRefund($paypal_order->id_transaction, (int)$order->id, $amount);
		$this->formatMessage($refund, $message);
		$this->_addNewPrivateMessage((int)$order->id, $message);
	}

	public function hookBackOfficeHeader()
	{
		if ((int)strcmp((_PS_VERSION_ < '1.5' ? Tools::getValue('configure') : Tools::getValue('module_name')), $this->name) == 0)
		{
			if (_PS_VERSION_ < '1.5')
			{
				$output =  '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery-ui-1.8.10.custom.min.js"></script>
					<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery.fancybox-1.3.4.js"></script>
					<link type="text/css" rel="stylesheet" href="'.__PS_BASE_URI__.'css/jquery.fancybox-1.3.4.css" />
					<link type="text/css" rel="stylesheet" href="'._MODULE_DIR_.$this->name.'/css/paypal.css" />';
			}
			else
			{
				$this->context->controller->addJquery();
				$this->context->controller->addJQueryPlugin('fancybox');
				$this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/css/paypal.css');
			}

			$this->context->smarty->assign(array(
				'PayPal_module_dir' => _MODULE_DIR_.$this->name,
				'PayPal_WPS' => (int)WPS,
				'PayPal_HSS' => (int)HSS,
				'PayPal_ECS' => (int)ECS
			));

			return (isset($output) ? $output : null).$this->fetchTemplate('/views/templates/back/header.tpl');
		}
		return null;
	}

	public function renderExpressCheckoutButton($type)
	{
		if ((!Configuration::get('PAYPAL_EXPRESS_CHECKOUT_SHORTCUT') && !$this->useMobile()))
			return null;

		if (!in_array(ECS, $this->getPaymentMethods()) || (((int)Configuration::get('PAYPAL_BUSINESS') == 1) &&
		(int)Configuration::get('PAYPAL_PAYMENT_METHOD') == HSS) && !$this->useMobile())
			return null;

		$iso_lang = array(
			'en' => 'en_US',
			'fr' => 'fr_FR'
		);

		$this->context->smarty->assign(array(
			'use_mobile' => (bool) $this->useMobile(),
			'PayPal_payment_type' => $type,
			'PayPal_current_page' => $this->getCurrentUrl(),
			'PayPal_lang_code' => (isset($iso_lang[$this->context->language->iso_code])) ? $iso_lang[$this->context->language->iso_code] : 'en_US',
			'PayPal_tracking_code' => $this->getTrackingCode())
		);

		return $this->fetchTemplate('express_checkout_shortcut_button.tpl');
	}

	public function renderExpressCheckoutForm($type)
	{
		if ((!Configuration::get('PAYPAL_EXPRESS_CHECKOUT_SHORTCUT') && !$this->useMobile()) || !in_array(ECS, $this->getPaymentMethods()) ||
		(((int)Configuration::get('PAYPAL_BUSINESS') == 1) && ((int)Configuration::get('PAYPAL_PAYMENT_METHOD') == HSS) && !$this->useMobile()))
			return;

		$this->context->smarty->assign(array(
			'PayPal_payment_type' => $type,
			'PayPal_current_page' => $this->getCurrentUrl(),
			'PayPal_tracking_code' => $this->getTrackingCode())
		);

		return $this->fetchTemplate('express_checkout_shortcut_form.tpl');
	}

	public function useMobile()
	{
		if ((method_exists($this->context, 'getMobileDevice') && $this->context->getMobileDevice()) || Tools::getValue('ps_mobile_site'))
			return true;
		return false;
	}

	public function getTrackingCode()
	{
		if ((_PS_VERSION_ < '1.5') && (_THEME_NAME_ == 'prestashop_mobile' || (isset($_GET['ps_mobile_site']) && $_GET['ps_mobile_site'] == 1)))
		{
			if (_PS_MOBILE_TABLET_)
				return TABLET_TRACKING_CODE;
			elseif (_PS_MOBILE_PHONE_)
				return SMARTPHONE_TRACKING_CODE;
		}
		if (isset($this->context->mobile_detect))
		{
			if ($this->context->mobile_detect->isTablet())
				return TABLET_TRACKING_CODE;
			elseif ($this->context->mobile_detect->isMobile())
				return SMARTPHONE_TRACKING_CODE;
		}
		return TRACKING_CODE;
	}

	public function getTranslations()
	{
		$file = dirname(__FILE__).'/'._PAYPAL_TRANSLATIONS_XML_;
		if (file_exists($file))
		{
			$xml = simplexml_load_file($file);
			if (isset($xml) && $xml)
			{
				$index = -1;
				$content = $default = array();

				while (isset($xml->country[++$index]))
				{
					$country = $xml->country[$index];
					$country_iso = $country->attributes()->iso_code;

					if (($this->iso_code != 'default') && ($country_iso == $this->iso_code))
						$content = (array)$country;
					elseif ($country_iso == 'default')
						$default = (array)$country;
				}

				$content += $default;
				$this->context->smarty->assign('PayPal_content', $content);

				return true;
			}
		}
		return false;
	}

	public function getPayPalURL()
	{
		return 'www'.(Configuration::get('PAYPAL_SANDBOX') ? '.sandbox' : '').'.paypal.com';
	}

	public function getPaypalIntegralEvolutionUrl()
	{
		if (Configuration::get('PAYPAL_SANDBOX'))
			return 'https://'.$this->getPayPalURL().'/cgi-bin/acquiringweb';
		return 'https://securepayments.paypal.com/acquiringweb?cmd=_hosted-payment';
	}

	public function getPaypalStandardUrl()
	{
		return 'https://'.$this->getPayPalURL().'/cgi-bin/webscr';
	}

	public function getAPIURL()
	{
		return 'api-3t'.(Configuration::get('PAYPAL_SANDBOX') ? '.sandbox' : '').'.paypal.com';
	}

	public function getAPIScript()
	{
		return '/nvp';
	}

	public function getCountryDependency($iso_code)
	{
		$localizations = array(
			'AU' => array('AU'), 'BE' => array('BE'), 'CN' => array('CN', 'MO'), 'CZ' => array('CZ'), 'DE' => array('DE'), 'ES' => array('ES'),
			'FR' => array('FR'), 'GB' => array('GB'), 'HK' => array('HK'), 'IL' => array('IL'), 'IN' => array('IN'), 'IT' => array('IT', 'VA'),
			'JP' => array('JP'), 'MY' => array('MY'), 'NL' => array('AN', 'NL'), 'NZ' => array('NZ'), 'PL' => array('PL'), 'PT' => array('PT', 'BR'),
			'RA' => array('AF', 'AS', 'BD', 'BN', 'BT', 'CC', 'CK', 'CX', 'FM', 'HM', 'ID', 'KH', 'KI', 'KN', 'KP', 'KR', 'KZ',	'LA', 'LK', 'MH',
				'MM', 'MN', 'MV', 'MX', 'NF', 'NP', 'NU', 'OM', 'PG', 'PH', 'PW', 'QA', 'SB', 'TJ', 'TK', 'TL', 'TM', 'TO', 'TV', 'TZ', 'UZ', 'VN',
				'VU', 'WF', 'WS'),
			'RE' => array('IE', 'ZA', 'GP', 'GG', 'JE', 'MC', 'MS', 'MP', 'PA', 'PY', 'PE', 'PN', 'PR', 'LC', 'SR', 'TT',
				'UY', 'VE', 'VI', 'AG', 'AR', 'CA', 'BO', 'BS', 'BB', 'BZ', 'CL', 'CO', 'CR', 'CU', 'SV', 'GD', 'GT', 'HN', 'JM', 'NI', 'AD', 'AE',
				'AI', 'AL', 'AM', 'AO', 'AQ', 'AT', 'AW', 'AX', 'AZ', 'BA', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BL', 'BM', 'BV', 'BW', 'BY', 'CD', 'CF', 'CG',
				'CH', 'CI', 'CM', 'CV', 'CY', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EC', 'EE', 'EG', 'EH', 'ER', 'ET', 'FI', 'FJ', 'FK', 'FO', 'GA', 'GE', 'GF',
				'GH', 'GI', 'GL', 'GM', 'GN', 'GQ', 'GR', 'GS', 'GU', 'GW', 'GY', 'HR', 'HT', 'HU', 'IM', 'IO', 'IQ', 'IR', 'IS', 'JO', 'KE', 'KM', 'KW',
				'KY', 'LB', 'LI', 'LR', 'LS', 'LT', 'LU', 'LV', 'LY', 'MA', 'MD', 'ME', 'MF', 'MG', 'MK', 'ML', 'MQ', 'MR', 'MT', 'MU', 'MW', 'MZ', 'NA',
				'NC', 'NE', 'NG', 'NO', 'NR', 'PF', 'PK', 'PM', 'PS', 'RE', 'RO', 'RS', 'RU', 'RW', 'SA', 'SC', 'SD', 'SE', 'SI', 'SJ', 'SK', 'SL',
				'SM', 'SN', 'SO', 'ST', 'SY', 'SZ', 'TC', 'TD', 'TF', 'TG', 'TN', 'UA', 'UG', 'VC', 'VG', 'YE', 'YT', 'ZM', 'ZW'),
			'SG' => array('SG'), 'TH' => array('TH'), 'TR' => array('TR'), 'TW' => array('TW'), 'US' => array('US'));

		foreach ($localizations as $key => $value)
			if (in_array($iso_code, $value))
				return $key;

		return $this->getCountryDependency(self::DEFAULT_COUNTRY_ISO);
	}

	public function getPaymentMethods()
	{
		// WPS -> Web Payment Standard
		// HSS -> Web Payment Pro / Integral Evolution
		// ECS -> Express Checkout Solution

		$paymentMethod = array('AU' => array(WPS, HSS, ECS), 'BE' => array(WPS, ECS), 'CN' => array(WPS, ECS), 'CZ' => array(), 'DE' => array(WPS),
		'ES' => array(WPS, HSS, ECS), 'FR' => array(WPS, HSS, ECS), 'GB' => array(WPS, HSS, ECS), 'HK' => array(WPS, HSS, ECS),
		'IL' => array(WPS, ECS), 'IN' => array(WPS, ECS), 'IT' => array(WPS, HSS, ECS), 'JP' => array(WPS, HSS, ECS), 'MY' => array(WPS, ECS),
		'NL' => array(WPS, ECS), 'NZ' => array(WPS, ECS), 'PL' => array(WPS, ECS), 'PT' => array(WPS, ECS), 'RA' => array(WPS, ECS), 'RE' => array(WPS, ECS),
		'SG' => array(WPS, ECS), 'TH' => array(WPS, ECS), 'TR' => array(WPS, ECS), 'TW' => array(WPS, ECS), 'US' => array(WPS, ECS),
		'ZA' => array(WPS, ECS));

		return isset($paymentMethod[$this->iso_code]) ? $paymentMethod[$this->iso_code] : $paymentMethod[self::DEFAULT_COUNTRY_ISO];
	}

	public function getCountryCode()
	{
		$cart = new Cart((int)$this->context->cookie->id_cart);
		$address = new Address((int)$cart->id_address_invoice);
		$country = new Country((int)$address->id_country);

		return $country->iso_code;
	}

	public function displayPayPalAPIError($message, $log = false)
	{
		$send = true;
		// Sanitize log
		foreach ($log as $key => $string)
		{
			if ($string == 'ACK -> Success')
				$send = false;
			elseif (substr($string, 0, 6) == 'METHOD')
			{
				$values = explode('&', $string);
				foreach ($values as $key2 => $value)
				{
					$values2 = explode('=', $value);
					foreach ($values2 as $key3 => $value2)
						if ($value2 == 'PWD' || $value2 == 'SIGNATURE')
							$values2[$key3 + 1] = '*********';
					$values[$key2] = implode('=', $values2);
				}
				$log[$key] = implode('&', $values);
			}
		}

		$this->context->smarty->assign(array('message' => $message, 'logs' => $log));

		if ($send)
		{
			$id_lang = (int)$this->context->cookie->id_lang;
			$iso_lang = Language::getIsoById($id_lang);

			if (!is_dir(dirname(__FILE__).'/mails/'.strtolower($iso_lang)))
				$id_lang = Language::getIdByIso('en');

			Mail::Send($id_lang, 'error_reporting', Mail::l('Error reporting from your PayPal module',
			(int)$this->context->cookie->id_lang), array('{logs}' => implode('<br />', $log)), Configuration::get('PS_SHOP_EMAIL'),
			null, null, null, null, null, _PS_MODULE_DIR_.$this->name.'/mails/');
		}

		return $this->fetchTemplate('error.tpl');
	}

	private function _canRefund($id_order)
	{
		if (!(bool)$id_order)
			return false;

		$paypal_order = Db::getInstance()->getRow('
			SELECT `payment_status`, `capture`
			FROM `'._DB_PREFIX_.'paypal_order`
			WHERE `id_order` = '.(int)$id_order);

		return $paypal_order && $paypal_order['payment_status'] == 'Completed' && $paypal_order['capture'] == 0;
	}

	private function _needValidation($id_order)
	{
		if (!(int)$id_order)
			return false;

		$order = Db::getInstance()->getRow('
			SELECT `payment_method`, `payment_status`
			FROM `'._DB_PREFIX_.'paypal_order`
			WHERE `id_order` = '.(int)$id_order);

		return $order && $order['payment_method'] != HSS && $order['payment_status'] == 'Pending_validation';
	}

	private function _needCapture($id_order)
	{
		if (!(int)$id_order)
			return false;

		$result = Db::getInstance()->getRow('
			SELECT `payment_method`, `payment_status`
			FROM `'._DB_PREFIX_.'paypal_order`
			WHERE `id_order` = '.(int)$id_order.' AND `capture` = 1');

		return $result && $result['payment_method'] != HSS && $result['payment_status'] == 'Pending_capture';
	}

	private function _preProcess()
	{
		if (Tools::isSubmit('submitPaypal'))
		{
			$business = Tools::getValue('business') !== false ? (int)Tools::getValue('business') : false;
			$payment_method = Tools::getValue('paypal_payment_method') !== false ? (int)Tools::getValue('paypal_payment_method') : false;
			$payment_capture = Tools::getValue('payment_capture') !== false ? (int)Tools::getValue('payment_capture') : false;
			$sandbox_mode = Tools::getValue('sandbox_mode') !== false ? (int)Tools::getValue('sandbox_mode') : false;

			if ($this->default_country === false || $sandbox_mode === false || $payment_capture === false || $business === false || $payment_method === false)
				$this->_errors[] = $this->l('Some fields are empty.');
			elseif (($business == 0 || ($business == 1 && $payment_method != HSS)) && (!Tools::getValue('api_username') || !Tools::getValue('api_password') || !Tools::getValue('api_signature')))
				$this->_errors[] = $this->l('Credentials fields cannot be empty');
			elseif ($business == 1 && $payment_method == HSS && !Tools::getValue('api_business_account'))
				$this->_errors[] = $this->l('Business e-mail field cannot be empty');
		}

		return !count($this->_errors);
	}

	private function _postProcess()
	{
		if (Tools::isSubmit('submitPaypal'))
		{
			if (Tools::getValue('paypal_country_only'))
				Configuration::updateValue('PAYPAL_COUNTRY_DEFAULT', (int)Tools::getValue('paypal_country_only'));
			elseif ($this->_preProcess())
			{
				Configuration::updateValue('PAYPAL_BUSINESS', (int)Tools::getValue('business'));
				Configuration::updateValue('PAYPAL_PAYMENT_METHOD', (int)Tools::getValue('paypal_payment_method'));
				Configuration::updateValue('PAYPAL_API_USER', trim(Tools::getValue('api_username')));
				Configuration::updateValue('PAYPAL_API_PASSWORD', trim(Tools::getValue('api_password')));
				Configuration::updateValue('PAYPAL_API_SIGNATURE', trim(Tools::getValue('api_signature')));
				Configuration::updateValue('PAYPAL_BUSINESS_ACCOUNT', trim(Tools::getValue('api_business_account')));
				Configuration::updateValue('PAYPAL_EXPRESS_CHECKOUT_SHORTCUT', (int)Tools::getValue('express_checkout_shortcut'));
				Configuration::updateValue('PAYPAL_SANDBOX', (int)Tools::getValue('sandbox_mode'));
				Configuration::updateValue('PAYPAL_CAPTURE', (int)Tools::getValue('payment_capture'));
				Configuration::updateValue('PAYPAL_FEE', (float)Tools::getValue('fee'));
				Configuration::updateValue('PAYPAL_PCTFEE', (float)Tools::getValue('pctfee'));
				Configuration::updateValue('PAYPAL_TAX', Tools::getValue('tax_rules'));

				$this->context->smarty->assign('PayPal_save_success', true);
			}
			else
			{
				$this->_html = $this->displayError(implode('<br />', $this->_errors)); // Not displayed at this time
				$this->context->smarty->assign('PayPal_save_failure', true);
			}
		}

		return $this->loadLangDefault();
	}

	private function _makeRefund($id_transaction, $id_order, $amt = false)
	{
		if (!$this->isPayPalAPIAvailable())
			die(Tools::displayError('Fatal Error: no API Credentials are available'));
		elseif (!$id_transaction)
			die(Tools::displayError('Fatal Error: id_transaction is null'));

		if (!$amt)
			$params = array('TRANSACTIONID' => $id_transaction, 'REFUNDTYPE' => 'Full');
		else
		{
			$isoCurrency = Db::getInstance()->getValue('
				SELECT `iso_code`
				FROM `'._DB_PREFIX_.'orders` o
				LEFT JOIN `'._DB_PREFIX_.'currency` c ON (o.`id_currency` = c.`id_currency`)
				WHERE o.`id_order` = '.(int)$id_order);

			$params = array('TRANSACTIONID'	=> $id_transaction,	'REFUNDTYPE' => 'Partial', 'AMT' => (float)$amt, 'CURRENCYCODE' => Tools::strtoupper($isoCurrency));
		}

		$paypal_lib	= new PaypalLib();

		return $paypal_lib->makeCall($this->getAPIURL(), $this->getAPIScript(), 'RefundTransaction', '&'.http_build_query($params, '', '&'));
	}

	public function _addNewPrivateMessage($id_order, $message)
	{
		if (!(bool)$id_order)
			return false;

		$new_message = new Message();
		$message = strip_tags($message, '<br>');

		if (!Validate::isCleanHtml($message))
			$message = $this->l('Payment message is not valid, please check your module.');

		$new_message->message = $message;
		$new_message->id_order = (int)$id_order;
		$new_message->private = 1;

		return $new_message->add();
	}

	private function _doTotalRefund($id_order)
	{
		$paypal_order = PayPalOrder::getOrderById((int)$id_order);
		if (!$this->isPayPalAPIAvailable() || !$paypal_order)
			return false;

		$order = new Order((int)$id_order);
		if (!Validate::isLoadedObject($order))
			return false;

		$products = $order->getProducts();
		$currency = new Currency((int)$order->id_currency);
		if (!Validate::isLoadedObject($currency))
			$this->_errors[] = $this->l('Not a valid currency');

		if (count($this->_errors))
			return false;

		$decimals = (is_array($currency) ? (int)$currency['decimals'] : (int)$currency->decimals) * _PS_PRICE_DISPLAY_PRECISION_;

		// Amount for refund
		$amt = 0.00;

		foreach ($products as $product)
			$amt += (float)($product['product_price_wt']) * ($product['product_quantity'] - $product['product_quantity_refunded']);
		$amt += (float)($order->total_shipping) + (float)($order->total_wrapping) - (float)($order->total_discounts);

		// check if total or partial
		if (Tools::ps_round($order->total_paid_real, $decimals) == Tools::ps_round($amt, $decimals))
			$response = $this->_makeRefund($paypal_order['id_transaction'], $id_order);
		else
			$response = $this->_makeRefund($paypal_order['id_transaction'], $id_order, (float)($amt));

		$message = $this->l('Refund operation result:').'<br>';
		foreach ($response as $key => $value)
			$message .= $key.': '.$value.'<br>';

		if (array_key_exists('ACK', $response) && $response['ACK'] == 'Success' && $response['REFUNDTRANSACTIONID'] != '')
		{
			$message .= $this->l('PayPal refund successful!');
			if (!Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'paypal_order` SET `payment_status` = \'Refunded\' WHERE `id_order` = '.(int)$id_order))
				die(Tools::displayError('Error when updating PayPal database'));

			$history = new OrderHistory();
			$history->id_order = (int)$id_order;
			$history->changeIdOrderState((int)Configuration::get('PS_OS_REFUND'), $history->id_order);
			$history->addWithemail();
			$history->save();
		}
		else
			$message .= $this->l('Transaction error!');

		$this->_addNewPrivateMessage((int)$id_order, $message);

		Tools::redirect($_SERVER['HTTP_REFERER']);
	}

	private function _doCapture($id_order)
	{
		$paypal_order = PayPalOrder::getOrderById((int)$id_order);
		if (!$this->isPayPalAPIAvailable() || !$paypal_order)
			return false;

		$order = new Order((int)$id_order);
		$currency = new Currency((int)$order->id_currency);

		$paypal_lib	= new PaypalLib();
		$response = $paypal_lib->makeCall($this->getAPIURL(), $this->getAPIScript(), 'DoCapture',
			'&'.http_build_query(array('AMT' => (float)$order->total_paid, 'AUTHORIZATIONID' => $paypal_order['id_transaction'],
			'CURRENCYCODE' => $currency->iso_code, 'COMPLETETYPE' => 'Complete'), '', '&'));
		$message = $this->l('Capture operation result:').'<br>';

		foreach ($response as $key => $value)
			$message .= $key.': '.$value.'<br>';

		if ((array_key_exists('ACK', $response)) && ($response['ACK'] == 'Success') && ($response['PAYMENTSTATUS'] == 'Completed'))
		{
			$order_history = new OrderHistory();
			$order_history->id_order = (int)$id_order;

			if (_PS_VERSION_ < '1.5')
				$order_history->changeIdOrderState(Configuration::get('PS_OS_WS_PAYMENT'), (int)$id_order);
			else
				$order_history->changeIdOrderState(Configuration::get('PS_OS_WS_PAYMENT'), $order);
			$order_history->addWithemail();
			$message .= $this->l('Order finished with PayPal!');
		}
		elseif (isset($response['PAYMENTSTATUS']))
			$message .= $this->l('Transaction error!');

		if (!Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'paypal_order`
			SET `capture` = 0, `payment_status` = \''.pSQL($response['PAYMENTSTATUS']).'\', `id_transaction` = \''.pSQL($response['TRANSACTIONID']).'\'
			WHERE `id_order` = '.(int)$id_order))
			die(Tools::displayError('Error when updating PayPal database'));

		$this->_addNewPrivateMessage((int)$id_order, $message);

		Tools::redirect($_SERVER['HTTP_REFERER']);
	}

	private function _updatePaymentStatusOfOrder($id_order)
	{
		if (!(bool)$id_order || !$this->isPayPalAPIAvailable())
			return false;

		$paypal_order = PayPalOrder::getOrderById((int)$id_order);
		if (!$paypal_order)
			return false;

		$paypal_lib	= new PaypalLib();
		$response = $paypal_lib->makeCall($this->getAPIURL(), $this->getAPIScript(), 'GetTransactionDetails',
			'&'.http_build_query(array('TRANSACTIONID' => $paypal_order->id_transaction), '', '&'));

		if (array_key_exists('ACK', $response))
		{
			if ($response['ACK'] == 'Success' && isset($response['PAYMENTSTATUS']))
			{
				$history = new OrderHistory();
				$history->id_order = (int)$id_order;

				if ($response['PAYMENTSTATUS'] == 'Completed')
					$history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), (int)$id_order);
				elseif (($response['PAYMENTSTATUS'] == 'Pending') && ($response['PENDINGREASON'] == 'authorization'))
					$history->changeIdOrderState((int)(Configuration::get('PAYPAL_OS_AUTHORIZATION')), (int)$id_order);
				elseif ($response['PAYMENTSTATUS'] == 'Reversed')
					$history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), (int)$id_order);
				$history->addWithemail();

				if (!Db::getInstance()->Execute('
				UPDATE `'._DB_PREFIX_.'paypal_order`
				SET `payment_status` = \''.pSQL($response['PAYMENTSTATUS']).($response['PENDINGREASON'] == 'authorization' ? '_authorization' : '').'\'
				WHERE `id_order` = '.(int)$id_order))
					die(Tools::displayError('Error when updating PayPal database'));
			}

			$message = $this->l('Verification status :').'<br>';
			$this->formatMessage($response, $message);
			$this->_addNewPrivateMessage((int)$id_order, $message);

			return $response;
		}

		return false;
	}

	public function fetchTemplate($name)
	{
		if (_PS_VERSION_ < '1.4')
			$this->context->smarty->currentTemplate = $name;
		elseif (_PS_VERSION_ < '1.5')
		{
			$views = 'views/templates/';
			if (@filemtime(dirname(__FILE__).'/'.$name))
				return $this->display(__FILE__, $name);
			elseif (@filemtime(dirname(__FILE__).'/'.$views.'hook/'.$name))
				return $this->display(__FILE__, $views.'hook/'.$name);
			elseif (@filemtime(dirname(__FILE__).'/'.$views.'front/'.$name))
				return $this->display(__FILE__, $views.'front/'.$name);
			elseif (@filemtime(dirname(__FILE__).'/'.$views.'back/'.$name))
				return $this->display(__FILE__, $views.'back/'.$name);
		}

		return $this->display(__FILE__, $name);
	}

	public static function getPayPalCustomerIdByEmail($email)
	{
		return Db::getInstance()->getValue('
			SELECT `id_customer`
			FROM `'._DB_PREFIX_.'paypal_customer`
			WHERE paypal_email = \''.pSQL($email).'\'');
	}

	public static function getPayPalEmailByIdCustomer($id_customer)
	{
		return Db::getInstance()->getValue('
			SELECT `paypal_email`
			FROM `'._DB_PREFIX_.'paypal_customer`
			WHERE `id_customer` = '.(int)$id_customer);
	}

	public static function addPayPalCustomer($id_customer, $email)
	{
		if (!PayPal::getPayPalEmailByIdCustomer($id_customer))
		{
			Db::getInstance()->Execute('
				INSERT INTO `'._DB_PREFIX_.'paypal_customer` (`id_customer`, `paypal_email`)
				VALUES('.(int)$id_customer.', \''.pSQL($email).'\')');

			return Db::getInstance()->Insert_ID();
		}

		return false;
	}

	private function warningsCheck()
	{
		if (Configuration::get('PAYPAL_PAYMENT_METHOD') == HSS && Configuration::get('PAYPAL_BUSINESS_ACCOUNT') == 'paypal@prestashop.com')
			$this->warning = $this->l('You are currently using the default PayPal e-mail address, please enter your own e-mail address.').'<br />';

		/* Check preactivation warning */
		if (Configuration::get('PS_PREACTIVATION_PAYPAL_WARNING'))
			$this->warning .= (!empty($this->warning)) ? ', ' : Configuration::get('PS_PREACTIVATION_PAYPAL_WARNING').'<br />';
	}

	private function loadLangDefault()
	{
		$paypal_country_default	= (int)Configuration::get('PAYPAL_COUNTRY_DEFAULT');
		$this->default_country	= ($paypal_country_default ? (int)$paypal_country_default : (int)Configuration::get('PS_COUNTRY_DEFAULT'));
		$this->iso_code	= $this->getCountryDependency(strtoupper($this->context->language->iso_code));
	}

	public function formatMessage($response, &$message)
	{
		foreach ($response as $key => $value)
			$message .= $key.': '.$value.'<br>';
	}

	private function checkCurrency($cart)
	{
		$currency_module = $this->getCurrency((int)$cart->id_currency);

		if ((int)$cart->id_currency == (int)$currency_module->id)
			return true;
		else
			return false;
	}

	public static function getShopDomainSsl($http = false, $entities = false)
	{
		if (method_exists('Tools', 'getShopDomainSsl'))
			return Tools::getShopDomainSsl($http, $entities);
		else
		{
			if (!($domain = Configuration::get('PS_SHOP_DOMAIN_SSL')))
				$domain = self::getHttpHost();
			if ($entities)
				$domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
			if ($http)
				$domain = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$domain;
			return $domain;
		}
	}

	public function validateOrder($id_cart, $id_order_state, $amountPaid, $paymentMethod = 'Unknown', $message = null, $transaction = array(), $currency_special = null, $dont_touch_amount = false, $secure_key = false, Shop $shop = null)
	{
		if ($this->active)
		{
			// Set transaction details if pcc is defined in PaymentModule class_exists
			if (isset($this->pcc))
				$this->pcc->transaction_id = (isset($transaction['transaction_id']) ? $transaction['transaction_id'] : '');

			if (_PS_VERSION_ < '1.5')
				$this->validateOrderMegaPaypal14((int)$id_cart, (int)$id_order_state, (float)$amountPaid, $paymentMethod, $message, $extraVars = array(), $currency_special, $dont_touch_amount, $secure_key);
			else
				$this->validateOrderMegaPaypal((int)$id_cart, (int)$id_order_state, (float)$amountPaid, $paymentMethod, $message, $transaction, $currency_special, $dont_touch_amount, $secure_key, $shop);

			if (count($transaction) > 0)
				PayPalOrder::saveOrder((int)$this->currentOrder, $transaction);
		}
	}
	
	public function validateOrderMegaPaypal($id_cart, $id_order_state, $amount_paid, $payment_method = 'Unknown',
		$message = null, $extra_vars = array(), $currency_special = null, $dont_touch_amount = false,
		$secure_key = false, Shop $shop = null)
	{
		$this->context->cart = new Cart($id_cart);
		$CODfee = (float)$this->getCost($this->context->cart);
		if($CODfee==0)
		{
			return parent::validateOrder($id_cart, $id_order_state, $amount_paid,$payment_method, $message , $extra_vars , $currency_special , $dont_touch_amount, 	$secure_key, $shop);
		}
		
		$this->context->customer = new Customer($this->context->cart->id_customer);
		$this->context->language = new Language($this->context->cart->id_lang);
		$this->context->shop = ($shop ? $shop : new Shop($this->context->cart->id_shop));
		$id_currency = $currency_special ? (int)$currency_special : (int)$this->context->cart->id_currency;
		$this->context->currency = new Currency($id_currency, null, $this->context->shop->id);
		if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery')
			$context_country = $this->context->country;

		$order_status = new OrderState((int)$id_order_state, (int)$this->context->language->id);
		if (!Validate::isLoadedObject($order_status))
			throw new PrestaShopException('Can\'t load Order state status');

		if (!$this->active)
			die(Tools::displayError());
		// Does order already exists ?
		if (Validate::isLoadedObject($this->context->cart) && $this->context->cart->OrderExists() == false)
		{
			if ($secure_key !== false && $secure_key != $this->context->cart->secure_key)
				die(Tools::displayError());

			// For each package, generate an order
			$delivery_option_list = $this->context->cart->getDeliveryOptionList();
			$package_list = $this->context->cart->getPackageList();
			$cart_delivery_option = $this->context->cart->getDeliveryOption();

			// If some delivery options are not defined, or not valid, use the first valid option
			foreach ($delivery_option_list as $id_address => $package)
				if (!isset($cart_delivery_option[$id_address]) || !array_key_exists($cart_delivery_option[$id_address], $package))
					foreach ($package as $key => $val)
					{
						$cart_delivery_option[$id_address] = $key;
						break;
					}

			$order_list = array();
			$order_detail_list = array();
			$reference = Order::generateReference();
			$this->currentOrderReference = $reference;

			$order_creation_failed = false;
			$cart_total_paid = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH)+ $CODfee, 2);

			if ($this->context->cart->orderExists())
			{
				$error = Tools::displayError('An order has already been placed using this cart.');
				Logger::addLog($error, 4, '0000001', 'Cart', intval($this->context->cart->id));
				die($error);
			}

			foreach ($cart_delivery_option as $id_address => $key_carriers)
				foreach ($delivery_option_list[$id_address][$key_carriers]['carrier_list'] as $id_carrier => $data)
					foreach ($data['package_list'] as $id_package){
						// Rewrite the id_warehouse
						if(method_exists('Cart','getPackageIdWarehouse'))
							$package_list[$id_address][$id_package]['id_warehouse'] = (int)$this->context->cart->getPackageIdWarehouse($package_list[$id_address][$id_package], (int)$id_carrier);
						$package_list[$id_address][$id_package]['id_carrier'] = $id_carrier;
					}

			// Make sure CarRule caches are empty
			CartRule::cleanCache();
			
			foreach ($package_list as $id_address => $packageByAddress)
				foreach ($packageByAddress as $id_package => $package)
				{
					$order = new Order();
					$order->product_list = $package['product_list'];
					
					if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery')
					{
						$address = new Address($id_address);
						$this->context->country = new Country($address->id_country, $this->context->cart->id_lang);
					}
					
					$carrier = null;
					if (!$this->context->cart->isVirtualCart() && isset($package['id_carrier']))
					{
						$carrier = new Carrier($package['id_carrier'], $this->context->cart->id_lang);
						$order->id_carrier = (int)$carrier->id;
						$id_carrier = (int)$carrier->id;
					}
					else
					{
						$order->id_carrier = 0;
						$id_carrier = 0;
					}
					
					$order->id_customer = (int)$this->context->cart->id_customer;
					$order->id_address_invoice = (int)$this->context->cart->id_address_invoice;
					$order->id_address_delivery = (int)$id_address;
					$order->id_currency = $this->context->currency->id;
					$order->id_lang = (int)$this->context->cart->id_lang;
					$order->id_cart = (int)$this->context->cart->id;
					$order->reference = $reference;
					$order->id_shop = (int)$this->context->shop->id;
					$order->id_shop_group = (int)$this->context->shop->id_shop_group;

					$order->secure_key = ($secure_key ? pSQL($secure_key) : pSQL($this->context->customer->secure_key));
					$order->payment = $payment_method;
					if (isset($this->name))
						$order->module = $this->name;
					$order->recyclable = $this->context->cart->recyclable;
					$order->gift = (int)$this->context->cart->gift;
					$order->gift_message = $this->context->cart->gift_message;
					$order->conversion_rate = $this->context->currency->conversion_rate;
					$amount_paid = !$dont_touch_amount ? Tools::ps_round((float)($amount_paid + $CODfee), 2) : ($amount_paid + $CODfee);
					$order->total_paid_real = 0;
					
					$order->total_products = (float)$this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);
					$order->total_products_wt = (float)$this->context->cart->getOrderTotal(true, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);

					$order->total_discounts_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
					$order->total_discounts_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
					$order->total_discounts = $order->total_discounts_tax_incl;

					$order->total_shipping_tax_excl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, false, null, $order->product_list);
					$order->total_shipping_tax_incl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, true, null, $order->product_list);
					$order->total_shipping = $order->total_shipping_tax_incl;
					
					if (!is_null($carrier) && Validate::isLoadedObject($carrier))
						$order->carrier_tax_rate = $carrier->getTaxesRate(new Address($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

					$order->total_wrapping_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
					$order->total_wrapping_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
					$order->total_wrapping = $order->total_wrapping_tax_incl;
					
					// Tax for PaypalFee
					$tax_manager = new TaxRulesTaxManager(new Address($order->id_address_invoice), Configuration::get('PAYPAL_TAX'));
					$product_tax_calculator = $tax_manager->getTaxCalculator();
					$order->payment_fee_rate = (float)Tools::ps_round($product_tax_calculator->getTotalRate(),2);
					
					$totalpaid_tax_exc = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(false, Cart::BOTH, $order->product_list, $id_carrier), 2);
					$totalpaid_tax_exc = $totalpaid_tax_exc + ($CODfee / (1+($order->payment_fee_rate/100)));
					$order->total_paid_tax_excl = (float)Tools::ps_round($totalpaid_tax_exc,2);
					
					$totalpaid = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH, $order->product_list, $id_carrier), 2);
					$totalpaid= $totalpaid + $CODfee;
					
					$order->payment_fee = abs((float)Tools::ps_round($CODfee,2));
					$order->total_paid_tax_incl = (float)Tools::ps_round($totalpaid,2);
					$order->total_paid = $order->total_paid_tax_incl;

					$order->invoice_date = '0000-00-00 00:00:00';
					$order->delivery_date = '0000-00-00 00:00:00';
					

					// Creating order
					$result = $order->add();

					if (!$result)
						throw new PrestaShopException('Can\'t save Order');

					// Amount paid by customer is not the right one -> Status = payment error
					// We don't use the following condition to avoid the float precision issues : http://www.php.net/manual/en/language.types.float.php
					// if ($order->total_paid != $order->total_paid_real)
					// We use number_format in order to compare two string
					if ($order_status->logable && number_format($cart_total_paid, 2) != number_format($amount_paid, 2))
						$id_order_state = Configuration::get('PS_OS_ERROR');

					$order_list[] = $order;

					// Insert new Order detail list using cart for the current order
					$order_detail = new OrderDetail(null, null, $this->context);
					$order_detail->createList($order, $this->context->cart, $id_order_state, $order->product_list, 0, true, $package_list[$id_address][$id_package]['id_warehouse']);
					$order_detail_list[] = $order_detail;

					// Adding an entry in order_carrier table
					if (!is_null($carrier))
					{
						$order_carrier = new OrderCarrier();
						$order_carrier->id_order = (int)$order->id;
						$order_carrier->id_carrier = (int)$id_carrier;
						$order_carrier->weight = (float)$order->getTotalWeight();
						$order_carrier->shipping_cost_tax_excl = (float)$order->total_shipping_tax_excl;
						$order_carrier->shipping_cost_tax_incl = (float)$order->total_shipping_tax_incl;
						$order_carrier->add();
					}
				}
			
			// The country can only change if the address used for the calculation is the delivery address, and if multi-shipping is activated
			if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery')
				$this->context->country = $context_country;

			// Register Payment only if the order status validate the order
			if ($order_status->logable)
			{
				// $order is the last order loop in the foreach
				// The method addOrderPayment of the class Order make a create a paymentOrder
				//     linked to the order reference and not to the order id
				if (isset($extra_vars['transaction_id']))
					$transaction_id = $extra_vars['transaction_id'];
				else
					$transaction_id = null;
				
				if (!$order->addOrderPayment($amount_paid, null, $transaction_id))
					throw new PrestaShopException('Can\'t save Order Payment');
			}

			// Next !
			$only_one_gift = false;
			$cart_rule_used = array();
			$products = $this->context->cart->getProducts();
			$cart_rules = $this->context->cart->getCartRules();
			
			// Make sure CarRule caches are empty
			CartRule::cleanCache();
			
			foreach ($order_detail_list as $key => $order_detail)
			{
				$order = $order_list[$key];
				if (!$order_creation_failed & isset($order->id))
				{
					if (!$secure_key)
						$message .= '<br />'.Tools::displayError('Warning: the secure key is empty, check your payment account before validation');
					// Optional message to attach to this order
					if (isset($message) & !empty($message))
					{
						$msg = new Message();
						$message = strip_tags($message, '<br>');
						if (Validate::isCleanHtml($message))
						{
							$msg->message = $message;
							$msg->id_order = intval($order->id);
							$msg->private = 1;
							$msg->add();
						}
					}

					// Insert new Order detail list using cart for the current order
					//$orderDetail = new OrderDetail(null, null, $this->context);
					//$orderDetail->createList($order, $this->context->cart, $id_order_state);

					// Construct order detail table for the email
					$products_list = '';
					$virtual_product = true;
					foreach ($products as $key => $product)
					{
						$price = Product::getPriceStatic((int)$product['id_product'], false, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 6, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
						$price_wt = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 2, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

						$customization_quantity = 0;
						if (isset($customized_datas[$product['id_product']][$product['id_product_attribute']]))
						{
							$customization_text = '';
							foreach ($customized_datas[$product['id_product']][$product['id_product_attribute']] as $customization)
							{
								if (isset($customization['datas'][Product::CUSTOMIZE_TEXTFIELD]))
									foreach ($customization['datas'][Product::CUSTOMIZE_TEXTFIELD] as $text)
										$customization_text .= $text['name'].': '.$text['value'].'<br />';

								if (isset($customization['datas'][Product::CUSTOMIZE_FILE]))
									$customization_text .= sprintf(Tools::displayError('%d image(s)'), count($customization['datas'][Product::CUSTOMIZE_FILE])).'<br />';

								$customization_text .= '---<br />';
							}

							$customization_text = rtrim($customization_text, '---<br />');

							$customization_quantity = (int)$product['customizationQuantityTotal'];
							$products_list .=
							'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
								<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
								<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').' - '.Tools::displayError('Customized').(!empty($customization_text) ? ' - '.$customization_text : '').'</strong></td>
								<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ?  Tools::ps_round($price, 2) : $price_wt, $this->context->currency, false).'</td>
								<td style="padding: 0.6em 0.4em; text-align: center;">'.$customization_quantity.'</td>
								<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice($customization_quantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt), $this->context->currency, false).'</td>
							</tr>';
						}

						if (!$customization_quantity || (int)$product['cart_quantity'] > $customization_quantity)
							$products_list .=
							'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
								<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
								<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes']) ? ' - '.$product['attributes'] : '').'</strong></td>
								<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt, $this->context->currency, false).'</td>
								<td style="padding: 0.6em 0.4em; text-align: center;">'.((int)$product['cart_quantity'] - $customization_quantity).'</td>
								<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(((int)$product['cart_quantity'] - $customization_quantity) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt), $this->context->currency, false).'</td>
							</tr>';

						// Check if is not a virutal product for the displaying of shipping
						if (!$product['is_virtual'])
							$virtual_product &= false;

					} // end foreach ($products)
					// Add fee to email
					if($order->payment_fee!=0)
					{
						$pricepayment  = Tools::displayPrice($order->payment_fee, $this->context->currency, false);
						$products_list .=
						'<tr style="background-color: #EBECEE;">
								<td style="padding: 0.6em 0.4em;width: 15%;"></td>
								<td style="padding: 0.6em 0.4em;width: 30%; text-align:right;"><strong>'.$this->l('Fee').'</strong></td>
								<td style="padding: 0.6em 0.4em; width: 20%; text-align:right;">'.$pricepayment.'</td>
								<td style="padding: 0.6em 0.4em; width: 15%; text-align:center;">1</td>
								<td style="padding: 0.6em 0.4em; width: 20%; text-align:right;">'.$pricepayment.'</td>
							</tr>';
					}

					$cart_rules_list = '';
					foreach ($cart_rules as $cart_rule)
					{
						$package = array('id_carrier' => $order->id_carrier, 'id_address' => $order->id_address_delivery, 'products' => $order->product_list);
						$values = array(
							'tax_incl' => $cart_rule['obj']->getContextualValue(true, $this->context, CartRule::FILTER_ACTION_ALL, $package),
							'tax_excl' => $cart_rule['obj']->getContextualValue(false, $this->context, CartRule::FILTER_ACTION_ALL, $package)
						);

						// If the reduction is not applicable to this order, then continue with the next one
						if (!$values['tax_excl'])
							continue;

						$order->addCartRule($cart_rule['obj']->id, $cart_rule['obj']->name, $values);

						/* IF
						** - This is not multi-shipping
						** - The value of the voucher is greater than the total of the order
						** - Partial use is allowed
						** - This is an "amount" reduction, not a reduction in % or a gift
						** THEN
						** The voucher is cloned with a new value corresponding to the remainder
						*/
						if (count($order_list) == 1 && $values['tax_incl'] > $order->total_products_wt && $cart_rule['obj']->partial_use == 1 && $cart_rule['obj']->reduction_amount > 0)
						{
							// Create a new voucher from the original
							$voucher = new CartRule($cart_rule['obj']->id); // We need to instantiate the CartRule without lang parameter to allow saving it
							unset($voucher->id);

							// Set a new voucher code
							$voucher->code = empty($voucher->code) ? substr(md5($order->id.'-'.$order->id_customer.'-'.$cart_rule['obj']->id), 0, 16) : $voucher->code.'-2';
							if (preg_match('/\-([0-9]{1,2})\-([0-9]{1,2})$/', $voucher->code, $matches) && $matches[1] == $matches[2])
								$voucher->code = preg_replace('/'.$matches[0].'$/', '-'.(intval($matches[1]) + 1), $voucher->code);

							// Set the new voucher value
							if ($voucher->reduction_tax)
								$voucher->reduction_amount = $values['tax_incl'] - $order->total_products_wt;
							else
								$voucher->reduction_amount = $values['tax_excl'] - $order->total_products;

							$voucher->id_customer = $order->id_customer;
							$voucher->quantity = 1;
							if ($voucher->add())
							{
								// If the voucher has conditions, they are now copied to the new voucher
								CartRule::copyConditions($cart_rule['obj']->id, $voucher->id);

								$params = array(
									'{voucher_amount}' => Tools::displayPrice($voucher->reduction_amount, $this->context->currency, false),
									'{voucher_num}' => $voucher->code,
									'{firstname}' => $this->context->customer->firstname,
									'{lastname}' => $this->context->customer->lastname,
									'{id_order}' => $order->reference,
									'{order_name}' => $order->getUniqReference()
								);
								Mail::Send(
									(int)$order->id_lang,
									'voucher',
									sprintf(Mail::l('New voucher regarding your order %s', (int)$order->id_lang), $order->reference),
									$params,
									$this->context->customer->email,
									$this->context->customer->firstname.' '.$this->context->customer->lastname,
									null, null, null, null, _PS_MAIL_DIR_, false, (int)$order->id_shop
								);
							}
						}

						if ($id_order_state != Configuration::get('PS_OS_ERROR') && $id_order_state != Configuration::get('PS_OS_CANCELED') && !in_array($cart_rule['obj']->id, $cart_rule_used))
						{
							$cart_rule_used[] = $cart_rule['obj']->id;

							// Create a new instance of Cart Rule without id_lang, in order to update its quantity
							$cart_rule_to_update = new CartRule($cart_rule['obj']->id);
							$cart_rule_to_update->quantity = max(0, $cart_rule_to_update->quantity - 1);
							$cart_rule_to_update->update();
						}

						$cart_rules_list .= '
						<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding:0.6em 0.4em;text-align:right">'.Tools::displayError('Voucher name:').' '.$cart_rule['obj']->name.'</td>
							<td style="padding:0.6em 0.4em;text-align:right">'.($values['tax_incl'] != 0.00 ? '-' : '').Tools::displayPrice($values['tax_incl'], $this->context->currency, false).'</td>
						</tr>';
					}

					// Specify order id for message
					$old_message = Message::getMessageByCartId((int)$this->context->cart->id);
					if ($old_message)
					{
						$message = new Message((int)$old_message['id_message']);
						$message->id_order = (int)$order->id;
						$message->update();

						// Add this message in the customer thread
						$customer_thread = new CustomerThread();
						$customer_thread->id_contact = 0;
						$customer_thread->id_customer = (int)$order->id_customer;
						$customer_thread->id_shop = (int)$this->context->shop->id;
						$customer_thread->id_order = (int)$order->id;
						$customer_thread->id_lang = (int)$this->context->language->id;
						$customer_thread->email = $this->context->customer->email;
						$customer_thread->status = 'open';
						$customer_thread->token = Tools::passwdGen(12);
						$customer_thread->add();

						$customer_message = new CustomerMessage();
						$customer_message->id_customer_thread = $customer_thread->id;
						$customer_message->id_employee = 0;
						$customer_message->message = htmlentities($message->message, ENT_COMPAT, 'UTF-8');
						$customer_message->private = 0;

						if (!$customer_message->add())
							$this->errors[] = Tools::displayError('An error occurred while saving message');
					}

					// Hook validate order
					Hook::exec('actionValidateOrder', array(
						'cart' => $this->context->cart,
						'order' => $order,
						'customer' => $this->context->customer,
						'currency' => $this->context->currency,
						'orderStatus' => $order_status
					));

					foreach ($this->context->cart->getProducts() as $product)
						if ($order_status->logable)
							ProductSale::addProductSale((int)$product['id_product'], (int)$product['cart_quantity']);

					if (Configuration::get('PS_STOCK_MANAGEMENT') && $order_detail->getStockState())
					{
						$history = new OrderHistory();
						$history->id_order = (int)$order->id;
						$history->changeIdOrderState(Configuration::get('PS_OS_OUTOFSTOCK'), $order, true);
						$history->addWithemail();
					}

					// Set order state in order history ONLY even if the "out of stock" status has not been yet reached
					// So you migth have two order states
					$new_history = new OrderHistory();
					$new_history->id_order = (int)$order->id;
				//quitada por la 1.5.2	$new_history->changeIdOrderState((int)$id_order_state, (int)$order->id, true);
					$new_history->changeIdOrderState((int)$id_order_state, $order, true);
					$new_history->addWithemail(true, $extra_vars);

					unset($order_detail);

					// Order is reloaded because the status just changed
					$order = new Order($order->id);

					// Send an e-mail to customer (one order = one email)
					if ($id_order_state != Configuration::get('PS_OS_ERROR') && $id_order_state != Configuration::get('PS_OS_CANCELED') && $this->context->customer->id)
					{
						$invoice = new Address($order->id_address_invoice);
						$delivery = new Address($order->id_address_delivery);
						$delivery_state = $delivery->id_state ? new State($delivery->id_state) : false;
						$invoice_state = $invoice->id_state ? new State($invoice->id_state) : false;

						$data = array(
						'{firstname}' => $this->context->customer->firstname,
						'{lastname}' => $this->context->customer->lastname,
						'{email}' => $this->context->customer->email,
						'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
						'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
						'{delivery_block_html}' => $this->_getFormatedAddress($delivery, '<br />', array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>'
						)),
						'{invoice_block_html}' => $this->_getFormatedAddress($invoice, '<br />', array(
								'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
								'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>'
						)),
						'{delivery_company}' => $delivery->company,
						'{delivery_firstname}' => $delivery->firstname,
						'{delivery_lastname}' => $delivery->lastname,
						'{delivery_address1}' => $delivery->address1,
						'{delivery_address2}' => $delivery->address2,
						'{delivery_city}' => $delivery->city,
						'{delivery_postal_code}' => $delivery->postcode,
						'{delivery_country}' => $delivery->country,
						'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
						'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
						'{delivery_other}' => $delivery->other,
						'{invoice_company}' => $invoice->company,
						'{invoice_vat_number}' => $invoice->vat_number,
						'{invoice_firstname}' => $invoice->firstname,
						'{invoice_lastname}' => $invoice->lastname,
						'{invoice_address2}' => $invoice->address2,
						'{invoice_address1}' => $invoice->address1,
						'{invoice_city}' => $invoice->city,
						'{invoice_postal_code}' => $invoice->postcode,
						'{invoice_country}' => $invoice->country,
						'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
						'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
						'{invoice_other}' => $invoice->other,
						'{order_name}' => $order->getUniqReference(),
						'{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)$order->id_lang, 1),
						'{carrier}' => $virtual_product ? Tools::displayError('No carrier') : $carrier->name,
						'{payment}' => Tools::substr($order->payment, 0, 32),
						'{products}' => $this->formatProductAndVoucherForEmail($products_list),
						'{discounts}' => $this->formatProductAndVoucherForEmail($cart_rules_list),
						'{total_paid}' => Tools::displayPrice($order->total_paid, $this->context->currency, false),
						'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $this->context->currency, false),
						'{total_discounts}' => Tools::displayPrice($order->total_discounts, $this->context->currency, false),
						'{total_shipping}' => Tools::displayPrice($order->total_shipping, $this->context->currency, false),
						'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $this->context->currency, false));

						if (is_array($extra_vars))
							$data = array_merge($data, $extra_vars);

						// Join PDF invoice
						if ((int)Configuration::get('PS_INVOICE') && $order_status->invoice && $order->invoice_number)
						{
							$pdf = new PDF($order->getInvoicesCollection(), PDF::TEMPLATE_INVOICE, $this->context->smarty);
							$file_attachement['content'] = $pdf->render(false);
							$file_attachement['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang).sprintf('%06d', $order->invoice_number).'.pdf';
							$file_attachement['mime'] = 'application/pdf';
						}
						else
							$file_attachement = null;

						if (Validate::isEmail($this->context->customer->email))
							Mail::Send(
								(int)$order->id_lang,
								'order_conf',
								Mail::l('Order confirmation', (int)$order->id_lang),
								$data,
								$this->context->customer->email,
								$this->context->customer->firstname.' '.$this->context->customer->lastname,
								null,
								null,
								$file_attachement,
								null, _PS_MAIL_DIR_, false, (int)$order->id_shop
							);
					}

					// updates stock in shops
					if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT'))
					{
						$product_list = $order->getProducts();
						foreach ($product_list as $product)
						{
							// if the available quantities depends on the physical stock
							if (StockAvailable::dependsOnStock($product['product_id']))
							{
								// synchronizes
								StockAvailable::synchronize($product['product_id'], $order->id_shop);
							}
						}
					}
				}
				else
				{
					$error = Tools::displayError('Order creation failed');
					Logger::addLog($error, 4, '0000002', 'Cart', intval($order->id_cart));
					die($error);
				}
			} // End foreach $order_detail_list
			// Use the last order as currentOrder
			$this->currentOrder = (int)$order->id;
			return true;
		}
		else
		{
			$error = Tools::displayError('Cart cannot be loaded or an order has already been placed using this cart');
			Logger::addLog($error, 4, '0000001', 'Cart', intval($this->context->cart->id));
			die($error);
		}
	}
	
	/**
	* Validate an order in database
	* Function called from a payment module
	*
	* @param integer $id_cart Value
	* @param integer $id_order_state Value
	* @param float $amountPaid Amount really paid by customer (in the default currency)
	* @param string $paymentMethod Payment method (eg. 'Credit card')
	* @param string $message Message to attach to order
	*/
	public function validateOrderMegaPaypal14($id_cart, $id_order_state, $amountPaid, $paymentMethod = 'Unknown', $message = NULL, $extraVars = array(), $currency_special = NULL, $dont_touch_amount = false, $secure_key = false)
	{
		global $cart;

		$cart = new Cart((int)($id_cart));

		$CODfee = $this->getCost($cart);
		$totalpaid = (float)(Tools::ps_round((float)($cart->getOrderTotal(true, Cart::BOTH)), 2));
		$totalpaid= $totalpaid + $CODfee;
		$cart_total_paid = (float)Tools::ps_round((float)$cart->getOrderTotal(true, Cart::BOTH) + $CODfee, 2);
		// Does order already exists ?
		if (Validate::isLoadedObject($cart) AND $cart->OrderExists() == false)
		{
			if ($secure_key !== false AND $secure_key != $cart->secure_key)
				die(Tools::displayError());

			// Copying data from cart
			$order = new Order();
			$order->id_carrier = (int)($cart->id_carrier);
			$order->id_customer = (int)($cart->id_customer);
			$order->id_address_invoice = (int)($cart->id_address_invoice);
			$order->id_address_delivery = (int)($cart->id_address_delivery);
			$vat_address = new Address((int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
			$order->id_currency = ($currency_special ? (int)($currency_special) : (int)($cart->id_currency));
			$order->id_lang = (int)($cart->id_lang);
			$order->id_cart = (int)($cart->id);
			$customer = new Customer((int)($order->id_customer));
			$order->secure_key = ($secure_key ? pSQL($secure_key) : pSQL($customer->secure_key));
			$order->payment = $paymentMethod;
			if (isset($this->name))
				$order->module = $this->name;
			$order->recyclable = $cart->recyclable;
			$order->gift = (int)($cart->gift);
			$order->gift_message = $cart->gift_message;
			$currency = new Currency($order->id_currency);
			$order->conversion_rate = $currency->conversion_rate;
			$amount_paid = !$dont_touch_amount ? Tools::ps_round((float)($amountPaid + $CODfee), 2) : ($amountPaid + $CODfee);
			$order->total_paid_real = $amount_paid;
			$order->total_products = (float)($cart->getOrderTotal(false, Cart::ONLY_PRODUCTS));
			$order->total_products_wt = (float)($cart->getOrderTotal(true, Cart::ONLY_PRODUCTS));
			$order->total_discounts = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS)));
			//$order->total_shipping = floatval(Tools::convertPrice(floatval(number_format($cart->getOrderShippingCost() + $CODfee, 2, '.', '')), $currency));
			$order->total_shipping = (float)($cart->getOrderShippingCost());
			
			$order->carrier_tax_rate = (float)Tax::getCarrierTaxRate($cart->id_carrier, (int)$cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
			$order->total_wrapping = (float)(abs($cart->getOrderTotal(true, Cart::ONLY_WRAPPING)));
			$order->payment_fee = abs((float)Tools::ps_round($CODfee,2));
			
			$address_inv = new Address($order->id_address_invoice);
			$tax_rate = TaxRulesGroup::getTaxes(Configuration::get('PAYPAL_TAX'), $address_inv->id_country, $address_inv->id_state, $address_inv->id_country);
			if(sizeof($tax_rate) > 0)
				$order->payment_fee_rate = (float)Tools::ps_round($tax_rate[0]->rate,2);
			
			//$order->total_paid = floatval(Tools::ps_round(floatval($cart->getOrderTotal(true, 3) + $CODfee), 2));
			$order->total_paid = (float)(Tools::ps_round((float)($cart->getOrderTotal(true, Cart::BOTH)), 2));
			$order->invoice_date = '0000-00-00 00:00:00';
			$order->delivery_date = '0000-00-00 00:00:00';
			
			$order->total_paid = $totalpaid;
			
			// Amount paid by customer is not the right one -> Status = payment error
			// We don't use the following condition to avoid the float precision issues : http://www.php.net/manual/en/language.types.float.php
			// if ($order->total_paid != $order->total_paid_real)
			// We use number_format in order to compare two string
			//if (number_format($order->total_paid, 2) != number_format($order->total_paid_real, 2))
			if ($order_status->logable && number_format($cart_total_paid, 2) != number_format($amount_paid, 2))
				$id_order_state = Configuration::get('PS_OS_ERROR');
			// Creating order
			if ($cart->OrderExists() == false)
				$result = $order->add();
			else
			{
				$errorMessage = Tools::displayError('An order has already been placed using this cart.');
				Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}

			// Next !
			if ($result AND isset($order->id))
			{
				if (!$secure_key)
					$message .= $this->l('Warning : the secure key is empty, check your payment account before validation');
				// Optional message to attach to this order
				if (isset($message) AND !empty($message))
				{
					$msg = new Message();
					$message = strip_tags($message, '<br>');
					if (Validate::isCleanHtml($message))
					{
						$msg->message = $message;
						$msg->id_order = intval($order->id);
						$msg->private = 1;
						$msg->add();
					}
				}

				// Insert products from cart into order_detail table
				$products = $cart->getProducts();
				$productsList = '';
				$db = Db::getInstance();
				$query = 'INSERT INTO `'._DB_PREFIX_.'order_detail`
					(`id_order`, `product_id`, `product_attribute_id`, `product_name`, `product_quantity`, `product_quantity_in_stock`, `product_price`, `reduction_percent`, `reduction_amount`, `group_reduction`, `product_quantity_discount`, `product_ean13`, `product_upc`, `product_reference`, `product_supplier_reference`, `product_weight`, `tax_name`, `tax_rate`, `ecotax`, `ecotax_tax_rate`, `discount_quantity_applied`, `download_deadline`, `download_hash`)
				VALUES ';

				$customizedDatas = Product::getAllCustomizedDatas((int)($order->id_cart));
				Product::addCustomizationPrice($products, $customizedDatas);
				$outOfStock = false;
				foreach ($products AS $key => $product)
				{
					$productQuantity = (int)(Product::getQuantity((int)($product['id_product']), ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL)));
					$quantityInStock = ($productQuantity - (int)($product['cart_quantity']) < 0) ? $productQuantity : (int)($product['cart_quantity']);
					if ($id_order_state != Configuration::get('PS_OS_CANCELED') AND $id_order_state != Configuration::get('PS_OS_ERROR'))
					{
						if (Product::updateQuantity($product, (int)$order->id))
							$product['stock_quantity'] -= $product['cart_quantity'];
						if ($product['stock_quantity'] < 0 && Configuration::get('PS_STOCK_MANAGEMENT'))
							$outOfStock = true;

						Product::updateDefaultAttribute($product['id_product']);
					}
					$price = Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 6, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
					$price_wt = Product::getPriceStatic((int)($product['id_product']), true, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), 2, NULL, false, true, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
					// Add some informations for virtual products
					$deadline = '0000-00-00 00:00:00';
					$download_hash = NULL;
					if ($id_product_download = ProductDownload::getIdFromIdProduct((int)($product['id_product'])))
					{
						$productDownload = new ProductDownload((int)($id_product_download));
						$deadline = $productDownload->getDeadLine();
						$download_hash = $productDownload->getHash();
					}

					// Exclude VAT
					if (Tax::excludeTaxeOption())
					{
						$product['tax'] = 0;
						$product['rate'] = 0;
						$tax_rate = 0;
					}
					else
						$tax_rate = Tax::getProductTaxRate((int)($product['id_product']), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                    $ecotaxTaxRate = 0;
                    if (!empty($product['ecotax']))
                        $ecotaxTaxRate = Tax::getProductEcotaxRate($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
					
                    //$product_price = (float)Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, false, false);
					$product_price = (float)Product::getPriceStatic((int)($product['id_product']), false, ($product['id_product_attribute'] ? (int)($product['id_product_attribute']) : NULL), (Product::getTaxCalculationMethod((int)($order->id_customer)) == PS_TAX_EXC ? 2 : 6), NULL, false, false, $product['cart_quantity'], false, (int)($order->id_customer), (int)($order->id_cart), (int)($order->{Configuration::get('PS_TAX_ADDRESS_TYPE')}), $specificPrice, false);

					$quantityDiscount = SpecificPrice::getQuantityDiscount((int)$product['id_product'], Shop::getCurrentShop(), (int)$cart->id_currency, (int)$vat_address->id_country, (int)$customer->id_default_group, (int)$product['cart_quantity']);
					$unitPrice = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? intval($product['id_product_attribute']) : NULL), 2, NULL, false, true, 1, false, (int)$order->id_customer, NULL, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
					$quantityDiscountValue = $quantityDiscount ? ((Product::getTaxCalculationMethod((int)$order->id_customer) == PS_TAX_EXC ? Tools::ps_round($unitPrice, 2) : $unitPrice) - $quantityDiscount['price'] * (1 + $tax_rate / 100)) : 0.00;
					$query .= '('.(int)($order->id).',
						'.(int)($product['id_product']).',
						'.(isset($product['id_product_attribute']) ? (int)($product['id_product_attribute']) : 'NULL').',
						\''.pSQL($product['name'].((isset($product['attributes']) AND $product['attributes'] != NULL) ? ' - '.$product['attributes'] : '')).'\',
						'.(int)($product['cart_quantity']).',
						'.$quantityInStock.',
						'.$product_price.',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'percentage') ? $specificPrice['reduction'] * 100 : 0.00).',
						'.(float)(($specificPrice AND $specificPrice['reduction_type'] == 'amount') ? (!$specificPrice['id_currency'] ? Tools::convertPrice($specificPrice['reduction'], $order->id_currency) : $specificPrice['reduction']) : 0.00).',
						'.(float)(Group::getReduction((int)($order->id_customer))).',
						'.$quantityDiscountValue.',
						'.(empty($product['ean13']) ? 'NULL' : '\''.pSQL($product['ean13']).'\'').',
						'.(empty($product['upc']) ? 'NULL' : '\''.pSQL($product['upc']).'\'').',
						'.(empty($product['reference']) ? 'NULL' : '\''.pSQL($product['reference']).'\'').',
						'.(empty($product['supplier_reference']) ? 'NULL' : '\''.pSQL($product['supplier_reference']).'\'').',
						'.(float)($product['id_product_attribute'] ? $product['weight_attribute'] : $product['weight']).',
						\''.(empty($tax_rate) ? '' : pSQL($product['tax'])).'\',
						'.(float)($tax_rate).',
						'.(float)Tools::convertPrice(floatval($product['ecotax']), intval($order->id_currency)).',
						'.(float)$ecotaxTaxRate.',
						'.(($specificPrice AND $specificPrice['from_quantity'] > 1) ? 1 : 0).',
						\''.pSQL($deadline).'\',
						\''.pSQL($download_hash).'\'),';

					$customizationQuantity = 0;
					if (isset($customizedDatas[$product['id_product']][$product['id_product_attribute']]))
					{
						$customizationText = '';
						foreach ($customizedDatas[$product['id_product']][$product['id_product_attribute']] AS $customization)
						{
							if (isset($customization['datas'][_CUSTOMIZE_TEXTFIELD_]))
								foreach ($customization['datas'][_CUSTOMIZE_TEXTFIELD_] AS $text)
									$customizationText .= $text['name'].':'.' '.$text['value'].'<br />';
							
							if (isset($customization['datas'][_CUSTOMIZE_FILE_]))
								$customizationText .= sizeof($customization['datas'][_CUSTOMIZE_FILE_]) .' '. Tools::displayError('image(s)').'<br />';
								
							$customizationText .= '---<br />';							
						}
						
						$customizationText = rtrim($customizationText, '---<br />');
						
						$customizationQuantity = (int)($product['customizationQuantityTotal']);
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes_small']) ? ' '.$product['attributes_small'] : '').' - '.$this->l('Customized').(!empty($customizationText) ? ' - '.$customizationText : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.$customizationQuantity.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice($customizationQuantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
						</tr>';
					}

					if (!$customizationQuantity OR (int)$product['cart_quantity'] > $customizationQuantity)
						$productsList .=
						'<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';">
							<td style="padding: 0.6em 0.4em;">'.$product['reference'].'</td>
							<td style="padding: 0.6em 0.4em;"><strong>'.$product['name'].(isset($product['attributes_small']) ? ' '.$product['attributes_small'] : '').'</strong></td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt, $currency, false).'</td>
							<td style="padding: 0.6em 0.4em; text-align: center;">'.((int)($product['cart_quantity']) - $customizationQuantity).'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.Tools::displayPrice(((int)($product['cart_quantity']) - $customizationQuantity) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? $price : $price_wt), $currency, false).'</td>
						</tr>';
				} // end foreach ($products)
				// Add fee to email
				if($order->payment_fee!=0)
				{
					$pricepayment  = Tools::displayPrice($order->payment_fee,$currency, false);
					$productsList .=
					'<tr style="background-color: #EBECEE;">
							<td style="padding: 0.6em 0.4em;width: 15%;"></td>
							<td style="padding: 0.6em 0.4em;width: 30%;"><strong>'.$this->l('Fee').'</strong></td>
							<td style="padding: 0.6em 0.4em; width: 20%;text-align: right;">'.$pricepayment.'</td>
							<td style="padding: 0.6em 0.4em; width: 15%;text-align: center;">1</td>
							<td style="padding: 0.6em 0.4em; width: 20%;text-align: right;">'.$pricepayment.'</td>
						</tr>';
				}
				$query = rtrim($query, ',');
				$result = $db->Execute($query);

				// Insert discounts from cart into order_discount table
				$discounts = $cart->getDiscounts();
				$discountsList = '';
				$total_discount_value = 0;
				$shrunk = false;
				foreach ($discounts AS $discount)
				{
					$objDiscount = new Discount((int)$discount['id_discount'], $order->id_lang);
					$value = $objDiscount->getValue(sizeof($discounts), $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS), $order->total_shipping, $cart->id);
					if ($objDiscount->id_discount_type == 2 AND in_array($objDiscount->behavior_not_exhausted, array(1,2)))
						$shrunk = true;

					if ($shrunk AND ($total_discount_value + $value) > ($order->total_products_wt + $order->total_shipping + $order->total_wrapping))
					{
						$amount_to_add = ($order->total_products_wt + $order->total_shipping + $order->total_wrapping) - $total_discount_value;
						if ($objDiscount->id_discount_type == 2 AND $objDiscount->behavior_not_exhausted == 2)
						{
							$voucher = new Discount();
							foreach ($objDiscount AS $key => $discountValue)
								$voucher->$key = $discountValue;
							$voucher->name = 'VSRK'.(int)$order->id_customer.'O'.(int)$order->id;
							$voucher->value = (float)$value - $amount_to_add;
							$voucher->add();
							$params['{voucher_amount}'] = Tools::displayPrice($voucher->value, $currency, false);
							$params['{voucher_num}'] = $voucher->name;
							@Mail::Send((int)$order->id_lang, 'voucher', Mail::l('New voucher regarding your order #').$order->id, $params, $customer->email, $customer->firstname.' '.$customer->lastname);
						}
					}
					else
						$amount_to_add = $value;
					$order->addDiscount($objDiscount->id, $objDiscount->name, $amount_to_add);
					$total_discount_value += $amount_to_add;
					if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED'))
						$objDiscount->quantity = $objDiscount->quantity - 1;
					$objDiscount->update();

					$discountsList .=
					'<tr style="background-color:#EBECEE;">
							<td colspan="4" style="padding: 0.6em 0.4em; text-align: right;">'.$this->l('Voucher code:').' '.$objDiscount->name.'</td>
							<td style="padding: 0.6em 0.4em; text-align: right;">'.($value != 0.00 ? '-' : '').Tools::displayPrice($value, $currency, false).'</td>
					</tr>';
				}

				// Specify order id for message
				$oldMessage = Message::getMessageByCartId((int)($cart->id));
				if ($oldMessage)
				{
					$message = new Message((int)$oldMessage['id_message']);
					$message->id_order = (int)$order->id;
					$message->update();
				}

				// Hook new order
				$orderStatus = new OrderState((int)$id_order_state, (int)$order->id_lang);
				if (Validate::isLoadedObject($orderStatus))
				{
					Hook::newOrder($cart, $order, $customer, $currency, $orderStatus);
					foreach ($cart->getProducts() AS $product)
						if ($orderStatus->logable)
							ProductSale::addProductSale((int)$product['id_product'], (int)$product['cart_quantity']);
				}

				if (isset($outOfStock) AND $outOfStock)
				{
					$history = new OrderHistory();
					$history->id_order = (int)$order->id;
					$history->changeIdOrderState(Configuration::get('PS_OS_OUTOFSTOCK'), (int)$order->id);
					$history->addWithemail();
				}

				// Set order state in order history ONLY even if the "out of stock" status has not been yet reached
				// So you migth have two order states
				$new_history = new OrderHistory();
				$new_history->id_order = (int)$order->id;
				$new_history->changeIdOrderState((int)$id_order_state, (int)$order->id);
				$new_history->addWithemail(true, $extraVars);

				// Order is reloaded because the status just changed
				$order = new Order($order->id);

				// Send an e-mail to customer
				if ($id_order_state != Configuration::get('PS_OS_ERROR') AND $id_order_state != Configuration::get('PS_OS_CANCELED') AND $customer->id)
				{
					$invoice = new Address((int)($order->id_address_invoice));
					$delivery = new Address((int)($order->id_address_delivery));
					$carrier = new Carrier((int)($order->id_carrier), $order->id_lang);
					$delivery_state = $delivery->id_state ? new State((int)($delivery->id_state)) : false;
					$invoice_state = $invoice->id_state ? new State((int)($invoice->id_state)) : false;

					$data = array(
					'{firstname}' => $customer->firstname,
					'{lastname}' => $customer->lastname,
					'{email}' => $customer->email,
					'{delivery_block_txt}' => $this->_getFormatedAddress($delivery, "\n"),
					'{invoice_block_txt}' => $this->_getFormatedAddress($invoice, "\n"),
					'{delivery_block_html}' => $this->_getFormatedAddress($delivery, "<br />", 
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>', 
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{invoice_block_html}' => $this->_getFormatedAddress($invoice, "<br />", 
						array(
							'firstname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>',
							'lastname'	=> '<span style="color:#DB3484; font-weight:bold;">%s</span>')),
					'{delivery_company}' => $delivery->company,
					'{delivery_firstname}' => $delivery->firstname,
					'{delivery_lastname}' => $delivery->lastname,
					'{delivery_address1}' => $delivery->address1,
					'{delivery_address2}' => $delivery->address2,
					'{delivery_city}' => $delivery->city,
					'{delivery_postal_code}' => $delivery->postcode,
					'{delivery_country}' => $delivery->country,
					'{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
					'{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
					'{delivery_other}' => $delivery->other,
					'{invoice_company}' => $invoice->company,
					'{invoice_vat_number}' => $invoice->vat_number,
					'{invoice_firstname}' => $invoice->firstname,
					'{invoice_lastname}' => $invoice->lastname,
					'{invoice_address2}' => $invoice->address2,
					'{invoice_address1}' => $invoice->address1,
					'{invoice_city}' => $invoice->city,
					'{invoice_postal_code}' => $invoice->postcode,
					'{invoice_country}' => $invoice->country,
					'{invoice_state}' => $invoice->id_state ? $invoice_state->name : '',
					'{invoice_phone}' => ($invoice->phone) ? $invoice->phone : $invoice->phone_mobile,
					'{invoice_other}' => $invoice->other,
					'{order_name}' => sprintf("#%06d", (int)($order->id)),
					'{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)($order->id_lang), 1),
					'{carrier}' => $carrier->name,
					'{payment}' => Tools::substr($order->payment, 0, 32),
					'{products}' => $productsList,
					'{discounts}' => $discountsList,
					'{total_paid}' => Tools::displayPrice($order->total_paid, $currency, false),
					'{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $currency, false),
					'{total_discounts}' => Tools::displayPrice($order->total_discounts, $currency, false),
					'{total_shipping}' => Tools::displayPrice($order->total_shipping, $currency, false),
					'{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $currency, false));

					if (is_array($extraVars))
						$data = array_merge($data, $extraVars);

					// Join PDF invoice
					if ((int)(Configuration::get('PS_INVOICE')) AND Validate::isLoadedObject($orderStatus) AND $orderStatus->invoice AND $order->invoice_number)
					{
						$fileAttachment['content'] = PDF::invoice($order, 'S');
						$fileAttachment['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)($order->id_lang)).sprintf('%06d', $order->invoice_number).'.pdf';
						$fileAttachment['mime'] = 'application/pdf';
					}
					else
						$fileAttachment = NULL;

					if (Validate::isEmail($customer->email))
						Mail::Send((int)$order->id_lang, 'order_conf', Mail::l('Order confirmation', $order->id_lang), $data, $customer->email, $customer->firstname.' '.$customer->lastname, NULL, NULL, $fileAttachment);
				}
				$this->currentOrder = (int)$order->id;
				return true;
			}
			else
			{
				$errorMessage = Tools::displayError('Order creation failed');
				Logger::addLog($errorMessage, 4, '0000002', 'Cart', intval($order->id_cart));
				die($errorMessage);
			}
		}
		else
		{
			$errorMessage = Tools::displayError('Cart can\'t be loaded or an order has already been placed using this cart');
			Logger::addLog($errorMessage, 4, '0000001', 'Cart', intval($cart->id));
			die($errorMessage);
		}
	}
	
	protected function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array())
	{
		return AddressFormat::generateAddress($the_address, array('avoid' => array()), $line_sep, ' ', $fields_style);
	}
	
	public function hookdisplayOrderDetail($param)
	{
		
		$order = $param['order'];
		if(isset($order) && $order->payment_fee!=0 && $order->module == 'paypal')
		{
			$html = '';
		
		$html .= '<br />
			<div class="table_block">
			<table class="std">
				<thead>
				<tr>
				<th><img alt="'.$this->l('Connexion').'" src="'.$this->_path.'logo.gif"/> '.$this->l('Paypal fee').'</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>'.$this->l('Fee applied for Paypal:').':&nbsp;<span style="color:red">'.Tools::displayPrice($order->payment_fee). '</span></td>
				<tr>
				</tbody>
			</table>
			</div>';
            return $html;
		}
	}
	
	public function hookOrderDetailDisplayed($param)
	{
		
		$order = $param['order'];
		if(isset($order) && $order->payment_fee!=0 && $order->module == 'paypal')
		{
			$html = '';
		
		$html .= '<br />
			<ul>
			<li><img alt="'.$this->l('Connexion').'" src="'.$this->_path.'logo.gif"/> '.$this->l('Paypal fee').'</li>
			<li>'.$this->l('Fee applied for Paypal:').':&nbsp;<span style="color:red">'.Tools::displayPrice($order->payment_fee). '</span></li>
			</ul>';
            return $html;
		}
	}
	
	//Return the fee cost
    public function getCost($cart)
    {
    	// Get total order
    	$cartvalue = floatval($cart->getOrderTotal(true, 3));
		$fee = 0;
    	
        $percent = floatval(Configuration::get('PAYPAL_PCTFEE'));
        $percent = $percent / 100;
		
		if(isset($percent) && $percent != 0) {
			$fee = $cartvalue * $percent;
        }
		
		$fee = $fee + floatval(Configuration::get('PAYPAL_FEE'));
			
        return floatval($fee);
    }

	protected function getGiftWrappingPrice()
	{
		if (_PS_VERSION_ >= '1.5')
			$wrapping_fees_tax_inc = $this->context->cart->getGiftWrappingPrice();
		else
		{
			$wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
			$wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
			$wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
		}

		return (float)Tools::convertPrice($wrapping_fees_tax_inc, $this->context->currency);
	}

	public function redirectToConfirmation()
	{
		$shop_url = PayPal::getShopDomainSsl(true, true);

		// Check if user went through the payment preparation detail and completed it
		$detail = unserialize($this->context->cookie->express_checkout);

		if (!empty($detail['payer_id']) && !empty($detail['token']))
		{
			$values = array('get_confirmation' => true);
			$link = $shop_url._MODULE_DIR_.$this->name.'/express_checkout/payment.php';

			if (_PS_VERSION_ < '1.5')
				Tools::redirectLink($link.'?'.http_build_query($values, '', '&'));
			else
				Tools::redirect(Context::getContext()->link->getModuleLink('paypal', 'confirm', $values));
		}
	}

	protected function getCurrentUrl()
	{
		$protocol_link = Tools::usingSecureMode() ? 'https://' : 'http://';
		$request = $_SERVER['REQUEST_URI'];
		$pos = strpos($request, '?');
		
		if (($pos !== false) && ($pos >= 0))
			$request = substr($request, 0, $pos);

		$params = urlencode($_SERVER['QUERY_STRING']);

		return $protocol_link.Tools::getShopDomainSsl().$request.'?'.$params;
	}
}
