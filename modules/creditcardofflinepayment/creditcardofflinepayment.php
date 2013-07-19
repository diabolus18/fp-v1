<?php
/*
 * idnovate.com (http://www.idnovate.com)
 * Credit Card Offline Payment Module - Allows currently running stores to
 * accept creditcard information through their online
 * shop. The credit card number is verified and the information 
 * is then stored masked in the database.  
 * It can then be decrypted, together with the information received by email,
 * at a later time for charges through an existing gateway (ie. a creditcard machine).
 *	
 * This product is licensed for one customer to use on one domain. Site developer has the 
 * right to modify this module to suit their needs, but can not redistribute the module in 
 * whole or in part. Any other use of this module constitues a violation of the user agreement.
 *
 *	NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
 *	ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
 *	WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF 
 *	PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
 *	IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
 *
*/

include_once(_PS_MODULE_DIR_.'creditcardofflinepayment/classes/CreditCardOfflinePaymentBrands.php');
include_once(_PS_MODULE_DIR_.'creditcardofflinepayment/classes/CreditCardOfflinePaymentOrder.php');
include_once(_PS_MODULE_DIR_.'creditcardofflinepayment/classes/CreditCardOfflinePaymentStates.php');


if (!defined('_PS_VERSION_'))
	exit;

class CreditCardOfflinePayment extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();
	private $_success;
	public $orderStates;

	public function __construct()
	{
		$this->name = 'creditcardofflinepayment';
		$this->tab = 'payments_gateways';
		$this->version = '1.34';
		$this->author = 'idnovate.com';
		$this->module_key = "9d9a3e22e4399d5d9caa8abd3cf256d6";
		
		$this->currencies = true;
		$this->currencies_mode = 'checkbox';
	
		parent::__construct();

		$this->displayName = $this->l('Credit card offline payment - physical POS');
		$this->description = $this->l('This module lets you make charges to your customer by a physical POS.');
		$this->confirmUninstall = $this->l('Are you sure that you want to delete the module and the related data?');

		if (!sizeof(Currency::checkPaymentCurrencies($this->id)))
			$this->warning = $this->l('Module not enabled');

		if (Configuration::get('CCOFFLINE_WORKINGMODE')==1 AND (!Configuration::get('CCOFFLINE_ADMIN_MAIL') OR (Configuration::get('CCOFFLINE_ADMIN_MAIL') == "")))
			$this->warning = $this->l('You have to set your mail address to receive the credit card information.');
	}

	public function install()
	{
		if (!parent::install() 
			OR !$this->registerHook('payment') 
			OR !$this->registerHook('paymentReturn') 
			OR !$this->registerHook('adminOrder')
			OR !$this->registerHook('header')
			OR !$this->registerHook('updateOrderStatus'))
			return false;

		//Inicialización de las variables
		Configuration::updateValue('CCOFFLINE_REQUIREISSUERNAME', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREDISSUERNAME', 1);
		Configuration::updateValue('CCOFFLINE_REQUIRECED', 0);
		Configuration::updateValue('CCOFFLINE_REQUIREDCED', 0);
		Configuration::updateValue('CCOFFLINE_REQUIREADDRESS', 0);
		Configuration::updateValue('CCOFFLINE_REQUIREDADDRESS', 0);
		Configuration::updateValue('CCOFFLINE_REQUIREZIPCODE', 0);
		Configuration::updateValue('CCOFFLINE_REQUIREDZIPCODE', 0);
		Configuration::updateValue('CCOFFLINE_REQUIRECARDNUMBER', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREDCARDNUMBER', 1);
		Configuration::updateValue('CCOFFLINE_REQUIRECVC', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREDCVC', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREISSUER', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREDISSUER', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREEXP', 1);
		Configuration::updateValue('CCOFFLINE_REQUIREDEXP', 1);
		Configuration::updateValue('CCOFFLINE_WORKINGMODE', 1);
		Configuration::updateValue('CCOFFLINE_DELETEINFO', 0);
		Configuration::updateValue('CCOFFLINE_ADMINMAILLANG', 1);

		//Instaladores de las clases
		$this->CreditCardOfflinePaymentStatesSetup();
		CreditCardOfflinePaymentBrands::setup();
		CreditCardOfflinePaymentOrder::setup();
			
		return true;
	}
	
	public function uninstall()
	{
		CreditCardOfflinePaymentBrands::remove();
		CreditCardOfflinePaymentOrder::remove();
		
		Configuration::deleteByName('CCOFFLINE_REQUIREISSUERNAME');
		Configuration::deleteByName('CCOFFLINE_REQUIREDISSUERNAME');
		Configuration::deleteByName('CCOFFLINE_REQUIREADDRESS');
		Configuration::deleteByName('CCOFFLINE_REQUIREDADDRESS');
		Configuration::deleteByName('CCOFFLINE_REQUIREZIPCODE');
		Configuration::deleteByName('CCOFFLINE_REQUIREDZIPCODE');		
		Configuration::deleteByName('CCOFFLINE_REQUIRECARDNUMBER');
		Configuration::deleteByName('CCOFFLINE_REQUIREDCARDNUMBER');
		Configuration::deleteByName('CCOFFLINE_REQUIREISSUER');
		Configuration::deleteByName('CCOFFLINE_REQUIREEXP');		
		Configuration::deleteByName('CCOFFLINE_REQUIRECVC');
		Configuration::deleteByName('CCOFFLINE_REQUIRECED');
		Configuration::deleteByName('CCOFFLINE_DATA_ISSUERS');
		Configuration::deleteByName('CCOFFLINE_ADMIN_MAIL');
		Configuration::deleteByName('CCOFFLINE_REQUIREDCVC');
		Configuration::deleteByName('CCOFFLINE_REQUIREDISSUER');
		Configuration::deleteByName('CCOFFLINE_REQUIREDEXP');
		Configuration::deleteByName('CCOFFLINE_REQUIREDCED');
		Configuration::deleteByName('CCOFFLINE_WORKINGMODE');
		Configuration::deleteByName('CCOFFLINE_DELETEINFO');
		Configuration::deleteByName('CCOFFLINE_ADMINMAILLANG');

		return parent::uninstall();
	}

	private function CreditCardOfflinePaymentStatesSetup() 
	{
		if(!Configuration::get('CCOFFLINE_DATA_OS_INITIAL') > 0)
		{
			$os = new OrderState();
			$os->name = array_fill(0,10, $this->l("Credit card - Payment pending"));
			$os->send_email = false;
			$os->invoice = 0;
			$os->color = "#FFFFAA";
			$os->unremovable = false;
			$os->logable = 0;		
			$os->add();

			Configuration::updateValue('CCOFFLINE_DATA_OS_INITIAL', $os->id);

			copy(_PS_MODULE_DIR_.$this->name.'/logo.gif',_PS_IMG_DIR_.'os/'.$os->id.'.gif');
		}
	}
	
	//Validación del Backoffice
	private function _postValidation()
	{
		if (isset($_POST['btnSubmit']))
		{
			$errors = array();
	
			//Actualizar tarjetas habilitadas
			$authorized_issuers = $_POST['issuers'];
			if(is_array($authorized_issuers)) {
				CreditCardOfflinePaymentBrands::setAuthorizedIssuers($authorized_issuers);				
			} 
			else {
				$errors[] = $this->l('You have to set one card issuer at least.');
			}
			
			if (Tools::getValue('workingMode') == 1)
			{
				if (Tools::getValue('adminMail') == "")
					$errors[] = $this->l('The mail address can not be empty.');
				elseif (!Validate::isEmail(Tools::getValue('adminMail')))
					$errors[] = $this->l('The mail address is not valid.');
				else
					Configuration::updateValue('CCOFFLINE_ADMIN_MAIL', Tools::getValue('adminMail'));
			} else {
					Configuration::updateValue('CCOFFLINE_ADMIN_MAIL', Tools::getValue('adminMail'));
			}

			//Actualizar resto de configuración			
			Configuration::updateValue('CCOFFLINE_REQUIREISSUERNAME', Tools::getValue('requireIssuerName') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDISSUERNAME', Tools::getValue('requiredIssuerName') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIRECED', Tools::getValue('requireCedule') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDCED', Tools::getValue('requiredCedule') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREADDRESS', Tools::getValue('requireAddress') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDADDRESS', Tools::getValue('requiredAddress') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREZIPCODE', Tools::getValue('requireZipCode') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDZIPCODE', Tools::getValue('requiredZipCode') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIRECARDNUMBER', Tools::getValue('requireCardNumber') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDCARDNUMBER', Tools::getValue('requiredCardNumber') == 'on' ? '1' : '0');			
			Configuration::updateValue('CCOFFLINE_REQUIREISSUER', Tools::getValue('requireIssuer') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDISSUER', Tools::getValue('requiredIssuer') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIRECVC', Tools::getValue('requireCVC') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDCVC', Tools::getValue('requiredCVC') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREEXP', Tools::getValue('requireExpiration') == 1 ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_REQUIREDEXP', Tools::getValue('requiredExpiration') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_WORKINGMODE', Tools::getValue('workingMode'));
			Configuration::updateValue('CCOFFLINE_DELETEINFO', Tools::getValue('deleteInfo') == 'on' ? '1' : '0');
			Configuration::updateValue('CCOFFLINE_DATA_OS_INITIAL', Tools::getValue('id_os_initial'));
			
			if (_PS_VERSION_ < '1.5') {
				global $cookie;
				Configuration::updateValue('CCOFFLINE_ADMINMAILLANG', (int)$cookie->id_lang);
			}
			else
				Configuration::updateValue('CCOFFLINE_ADMINMAILLANG', $this->context->language->id);
						
			if(sizeof($errors) < 1)
				return $this->_success = '<div class="conf confirm"><h3>'.$this->l('Settings updated.').'</h3></div>';
			else
				return $this->_postErrors = $errors;
		}
	}

	//Relleno de campos del BackOffice
	function getContent()
	{
		if (_PS_VERSION_ < '1.5')
			global $smarty;
		else
			$smarty = $this->context->smarty;

		if (!empty($_POST))
		{		
			$this->_postValidation();
		}

		$smarty->assign(array(
			'displayName'		=> $this->displayName,
			'issuers'			=> CreditCardOfflinePaymentBrands::getIssuers(),
			'version' 			=> $this->version,
			'adminMail' 		=> Configuration::get('CCOFFLINE_ADMIN_MAIL'),
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
			'workingMode'		=> Configuration::get('CCOFFLINE_WORKINGMODE'),
			'deleteInfo'		=> Configuration::get('CCOFFLINE_DELETEINFO') == '1' ? true : false,
			'errors'			=> $this->_postErrors,
			'success'			=> $this->_success,
			'states'			=> CreditCardOfflinePaymentStates::getOrderStates(),
			'id_os_initial'		=> Configuration::get('CCOFFLINE_DATA_OS_INITIAL'),
			'this_path' 		=> $this->_path,
			'this_path_ssl' 	=> Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
		));

		if (_PS_VERSION_ < '1.5')
			return $this->display(__FILE__,'views/templates/hook/admin_form.tpl');
		else
			return $this->display(__FILE__,'admin_form.tpl');
	}

	/*	execPayment($cart)
	 *	Se ejecta cuando el usuario clica "Pagar con tarjeta de crédito"
	*/
	function execPayment($cart)
	{
		try {
			global $smarty, $cookie;

			if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->active)
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
				die($this->l('This payment method is not available.', 'validation'));

			$customer = new Customer($cart->id_customer);
			if (!Validate::isLoadedObject($customer))
				Tools::redirect('index.php?controller=order&step=1');		

			if (!$this->checkCurrency($cart))
				Tools::redirect('index.php?controller=order');
			else
			{
				$errors = array();
				if(Tools::isSubmit('paymentSubmit'))
				{
					$card = Tools::getValue('card');

					//Validate variables
					//Name holder
					if(Configuration::get('CCOFFLINE_REQUIREISSUERNAME') & Configuration::get('CCOFFLINE_REQUIREDISSUERNAME'))
					{
						if($card['name'] == "")
							$errors[] = $this->l('You must introduce the card holder name.', 'validation');
					}					
					
					if(Configuration::get('CCOFFLINE_REQUIREISSUERNAME') & $card['name'] != "" & !Validate::isName($card['name']))
					{
						$errors[] = $this->l('The name introduced is not valid.', 'validation');
					}
					
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIREISSUERNAME'))
					{
						$card['name'] = "";
					}

					//ID/Passport
					if(Configuration::get('CCOFFLINE_REQUIRECED') & Configuration::get('CCOFFLINE_REQUIREDCED'))
					{
						if($card['cedula']=="")
							$errors[] = $this->l('You must introduce your ID Card/Passport.', 'validation');
					}

					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIRECED'))
					{
						$card['cedula'] = "";
					}

					//Address
					if(Configuration::get('CCOFFLINE_REQUIREADDRESS') & Configuration::get('CCOFFLINE_REQUIREDADDRESS'))
					{
						if($card['address']=="")
							$errors[] = $this->l('You must introduce your address.', 'validation');
					}

					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIREADDRESS'))
					{
						$card['address'] = "";
					}

					//Zip code
					if(Configuration::get('CCOFFLINE_REQUIREZIPCODE') & Configuration::get('CCOFFLINE_REQUIREDZIPCODE'))
					{
						if($card['zipcode']=="")
							$errors[] = $this->l('You must introduce your zip code.', 'validation');
					}

					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIREZIPCODE'))
					{
						$card['zipcode'] = "";
					}
					
					//Card number
					if(Configuration::get('CCOFFLINE_REQUIRECARDNUMBER') & Configuration::get('CCOFFLINE_REQUIREDCARDNUMBER'))
					{
						if($card['number']== "")
							$errors[] = $this->l('You must introduce the credit card number.', 'validation');
					}
					
					if(Configuration::get('CCOFFLINE_REQUIRECARDNUMBER') & $card['number'] != "" & Configuration::get('CCOFFLINE_REQUIREISSUER') & !$this->validateCard($card['number'], $card['issuer']))
						$errors[] = $this->l('The credit card number entered is not valid.', 'validation');
					
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIRECARDNUMBER'))
					{
						$card['number'] = "";
					}

					//CVC
					if(Configuration::get('CCOFFLINE_REQUIRECVC') & Configuration::get('CCOFFLINE_REQUIREDCVC'))
					{
						if($card['cvc']=="")
							$errors[] = $this->l('You must introduce the CVC card number.', 'validation');
					}
					//If variable not required, initialize to blank
					if(Configuration::get('CCOFFLINE_REQUIRECVC') & $card['cvc'] != "" & (!is_numeric($card['cvc'])))
						$errors[] = $this->l('The CVC card number entered is not valid.', 'validation');
					
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIRECVC'))
					{
						$card['cvc'] = "";
					}

					//Card issuer
					if(Configuration::get('CCOFFLINE_REQUIREISSUER') & Configuration::get('CCOFFLINE_REQUIREDISSUER'))
					{
						if($card['issuer']=="")
							$errors[] = $this->l('You must choose your card issuer.', 'validation');
					}
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIREISSUER'))
					{
						$card['issuer'] = "";
					}

					//Expiry date
					if(Configuration::get('CCOFFLINE_REQUIREEXP') & Configuration::get('CCOFFLINE_REQUIREDEXP'))
					{
						if($card['mes_caducidad']=="")
							$errors[] = $this->l('You must introduce the expiry month of the credit card.', 'validation');
						if($card['ano_caducidad']=="")
							$errors[] = $this->l('You must introduce the expiry year of the credit card.', 'validation');						
						// Check that the date is valid					
						if($card['mes_caducidad']!="" && $card['ano_caducidad']!="" && $card['ano_caducidad'] == date("Y") && $card['mes_caducidad'] < date("m"))
							$errors[] = $this->l('The expiry date that you introduced can not be prior to actual date.', 'validation');						
					}
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIREEXP'))
					{
						$card['mes_caducidad'] = "";
						$card['ano_caducidad'] = "";
					}

					//Si todos los campos son válidos
					if(!sizeof($errors))
					{
						$cardString = "";
						$id_currency = intval(Tools::getValue('id_currency'));
						$currency = Currency::getCurrency($id_currency);

						//lets put a name for the issuer instead of an object id
						if($card['issuer'])
							$card['issuer'] = CreditCardOfflinePaymentBrands::getNameById($card['issuer']);

						$total = floatval(number_format($cart->getOrderTotal(true, 3), 2, '.', ''));

						$payment_method = $this->l('Credit card offline payment - physical POS', 'validation');

						//and place the order
						$this->validateOrder($cart->id, Configuration::get('CCOFFLINE_DATA_OS_INITIAL'), $total, $this->displayName, null, null, $id_currency, false, $cart->secure_key);

						$order = new Order((int)($this->currentOrder));

						if (Configuration::get('CCOFFLINE_WORKINGMODE')==2) 
						{
							//Store whole number in database, don't send mail.
							CreditCardOfflinePaymentOrder::insertOrder((int)($order->id), $card['cvc'], $card['issuer'], $card['number'], $card['name'], $card['cedula'], $card['address'], $card['zipcode'], $card['mes_caducidad'], $card['ano_caducidad'], $total, $currency['sign']);
						}
						else 
						{
							//Store half number in database and send the other half by mail
							$length = ceil(strlen($card['number'])/2);
							CreditCardOfflinePaymentOrder::insertOrder((int)($order->id), $card['cvc'], $card['issuer'], substr($card['number'],0,$length) . str_pad('', strlen($card['number'])-$length , 'x'), $card['name'], $card['cedula'], $card['address'], $card['zipcode'], $card['mes_caducidad'], $card['ano_caducidad'], $total, $currency['sign']);

							//Send the email to the seller. Set the variables for the template
							$templateVars['{id_order}'] = $order->id;
							$templateVars['{nombre_titular}'] = $card['name'];
							$templateVars['{cedula}'] = $card['cedula'];
							$templateVars['{direccion}'] = $card['address'];
							$templateVars['{cp}'] = $card['zipcode'];
							$templateVars['{importe}'] = $total;
							$templateVars['{moneda}'] = $currency['sign'];
							$templateVars['{pan}'] = str_pad('', $length , 'x') . substr($card['number'],$length,(strlen($card['number'] - $length)));
							$templateVars['{mes_caducidad}'] = $card['mes_caducidad'];
							$templateVars['{ano_caducidad}'] = $card['ano_caducidad'];

							$id_lang = Configuration::get('CCOFFLINE_ADMINMAILLANG'); //Language template
							$template_name = 'mail'; //Template file name
							$title =  $this->l('Order') . ' #' .  $order->id . ' ' . $this->l('paid with credit card'); //Mail subject with translation
							$from = Configuration::get('PS_SHOP_EMAIL');   //Sender's email
							$fromName = Configuration::get('PS_SHOP_NAME'); //Sender's name
							$mailDir = dirname(__FILE__).'/mails/'; //Directory with message templates
							$toMail = Configuration::get('CCOFFLINE_ADMIN_MAIL'); //To mail address
								
							Mail::Send($id_lang, $template_name, $title, $templateVars, $toMail, '', $from, $fromName, NULL, NULL, $mailDir);
						}

						// Once complete, redirect to order-confirmation.php
						Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?id_cart='.(int)($cart->id).'&id_module='.(int)($this->id).'&id_order='.(int)($this->currentOrder).'&key='.$order->secure_key);

					} else {
						$smarty->assign('card', $card);
					}
				}

				$smarty->assign(array(
					'nbProducts' 		=> $cart->nbProducts(),
					'default_currency' 	=> new Currency(Configuration::get('PS_CURRENCY_DEFAULT')),
					'currency'			=> new Currency(intval((int)$cookie->id_currency)),
					'id_currency'		=> (int)$cookie->id_currency,
					'total'				=> number_format($cart->getOrderTotal(true, 3), 2, '.', ''),
					'issuers'			=> CreditCardOfflinePaymentBrands::getIssuers(),
					'errores' 			=> $errors,					
					'adminMail' 		=> Configuration::get('CCOFFLINE_ADMIN_MAIL'),
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
					'this_path' 		=> $this->_path,
					'this_path_ssl' 	=> Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
					'mobile_device' 	=> false,
				));

				return $this->display(__FILE__, 'views/templates/front/payment_execution.tpl');
			}
		} catch (Exception $e){
			error_log($e);
		}
	}

	/**	hookPayment($params)
	*	Mostrar plantilla para pagar con el módulo*/
	function hookPayment($params)
	{
		if (_PS_VERSION_ < '1.5')
		{
			global $smarty;
			global $cookie;
		}
		else
		{
			$smarty = $this->context->smarty;
			$cookie = $this->context->cookie;
		}

		//Únicamente se muestra el módulo si el correo electrónico está informado
		if (Configuration::get('CCOFFLINE_WORKINGMODE')==2 OR (Configuration::get('CCOFFLINE_WORKINGMODE')==1 AND (Configuration::get('CCOFFLINE_ADMIN_MAIL') <> "")))
		{
			$smarty->assign(array(
				'cookie_currency'		=> $cookie->id_currency,
				'currency_authorized'	=> $this->checkCurrency($params['cart']),
				'this_path' 	=> $this->_path,
				'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
			));

			
			if (_PS_VERSION_ < '1.5')
				return $this->display(__FILE__,'views/templates/hook/payment.tpl');
			else
				return $this->display(__FILE__,'payment.tpl');
		}
	}
	
	/**	hookAdminOrder($params)
	*	Información del pedido en el backoffice. Sólo se muestra si el pedido se ha realizado con este módulo */
	function hookAdminOrder($params)
	{
		if (_PS_VERSION_ < '1.5')
			global $smarty;
		else
			$smarty = $this->context->smarty;

		$id_order = $params['id_order'];

		if(CreditCardOfflinePaymentOrder::isCreditCardOrder($id_order))
		{				
			$data_string = CreditCardOfflinePaymentOrder::getOrder($id_order);
			$smarty->assign(array(
				'nombre_titular' 	=> $data_string['nombre_titular'],
				'cedula'		 	=> $data_string['cedula'],
				'direccion'		 	=> $data_string['direccion'],
				'cp'		 		=> $data_string['cp'],
				'pan' 				=> $data_string['pan'],
				'cvc' 				=> $data_string['cvc'],
				'tipo_tarjeta' 		=> $data_string['tipo_tarjeta'],
				'importe' 			=> $data_string['importe'],
				'moneda' 			=> $data_string['moneda'],
				'mes_caducidad' 	=> str_pad($data_string['mes_caducidad'], 2, "0", STR_PAD_LEFT),
				'ano_caducidad' 	=> $data_string['ano_caducidad'],
				'id_order'			=> $id_order,
				'this_page'			=> $_SERVER['REQUEST_URI'],
				'token'				=> Tools::getToken(false),
				'this_path' 		=> $this->_path,
				'this_path_ssl' 	=> Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
			));
		
			if (_PS_VERSION_ < '1.5')
				return $this->display(__FILE__,'views/templates/hook/invoice_block.tpl');
			else
				return $this->display(__FILE__,'invoice_block.tpl');
		}
	}

	/**
	*	hookPaymentReturn($params)
	*	Se llama después de realizar el pago
	*/
	function hookPaymentReturn($params)
	{
		if (_PS_VERSION_ < '1.5')
			global $smarty;
		else
			$smarty = $this->context->smarty;

		if (!$this->active)
			return ;

		$state = $params['objOrder']->getCurrentState();
		
		if ($state == _PS_OS_OUTOFSTOCK_ or $state == Configuration::get('CCOFFLINE_DATA_OS_INITIAL'))
			$smarty->assign(array(
				'total_to_pay' 	=> Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
				'success' 		=> true,
				'id_order' 		=> $params['objOrder']->id
			));
		else
			$this->smarty->assign('success', false);

		if (_PS_VERSION_ < '1.5')
			return $this->display(__FILE__,'views/templates/hook/order-confirmation.tpl');
		else
			return $this->display(__FILE__,'order-confirmation.tpl');
	}

	public function hookHeader($params)
	{
		if (_PS_VERSION_ < '1.5')
			Tools::addCSS($this->_path.'css/creditcardofflinepayment_1.4.css', 'all');
		else
			$this->context->controller->addCSS($this->_path.'css/creditcardofflinepayment_1.5.css', 'all');
	}

	public function hookUpdateOrderStatus($params)
	{
		if (Configuration::get('CCOFFLINE_DELETEINFO'))
		{
			if ($order AND !Validate::isLoadedObject($order))
				die($this->l('Incorrect Order object.'));
		
			if (intval($params['newOrderStatus']->id) <> Configuration::get('CCOFFLINE_DATA_OS_INITIAL'))
				CreditCardOfflinePaymentOrder::deleteCardInfo($params['id_order']);
		}			
	}
	
	/*
	 *	validateCard($cardnumber)
	 * 	Checks mod10 check digit of card, returns true if valid
	 */
	function validateCard($cardnumber, $issuer_name)
	{
		$issuer = CreditCardOfflinePaymentBrands::getInfoByIssuer($issuer_name);

		if ($issuer['check'] & $issuer['algorithm'] == 'luhn') {
			//Luhn algorithm
			$cardnumber = preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
			$cardlength = strlen($cardnumber);
			if ($cardlength != 0)
			{
				$parity = $cardlength % 2;
				$sum = 0;
				for ($i = 0; $i < $cardlength; $i++)
				{
					$digit = $cardnumber[$i];
					if ($i % 2 == $parity) $digit = $digit * 2;
						if ($digit > 9) $digit = $digit-9;
							$sum = $sum + $digit;
				}
				$valid = ($sum % 10 == 0);
				return $valid;
			}
			return false;
		}
		elseif ($issuer['check'] & $issuer['algorithm'] == 'isracard') {
			$comp1 = "987654321";
			$comp2 = $cardnumber;
			$srez = 0;

			if (strlen($comp2) < 9)
				$comp2 = '0' . $cardnumber;

			for ($i = 0; $i < 9; $i++) {
				$a = substr($comp1, $i, 1);
				$b = substr($comp2, $i, 1);
				$c = $a * $b;
				$srez = $srez + $c;
			}

			if ($srez % 11 == 0)
				return true;
			else
				return false;
		}
		else
			return false;
	}
	
	function checkCurrency($cart)
	{
		$currency_order = new Currency(intval($cart->id_currency));
		$currencies_module = $this->getCurrency();
		$currency_default = Configuration::get('PS_CURRENCY_DEFAULT');
		
		if (is_array($currencies_module))
			foreach ($currencies_module AS $currency_module)
				if ($currency_order->id == $currency_module['id_currency'])
					return true;
		return false;
	}
}
?>