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
*  @version  Release: $Revision: 15094 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
* @since 1.5.0
*/
class CreditCardOfflinePaymentValidationModuleFrontController extends ModuleFrontController
{
	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{
		try {
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
				die($this->module->l('This payment method is not available.', 'validation'));

			$customer = new Customer($cart->id_customer);
			if (!Validate::isLoadedObject($customer))
				Tools::redirect('index.php?controller=order&step=1');		

			if (!$this->module->checkCurrency($cart))
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
							$errors[] = $this->module->l('You must introduce the card holder name.', 'validation');
					}					
					
					if(Configuration::get('CCOFFLINE_REQUIREISSUERNAME') & $card['name'] != "" & !Validate::isName($card['name']))
					{
						$errors[] = $this->module->l('The name introduced is not valid.', 'validation');
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
							$errors[] = $this->module->l('You must introduce your ID Card/Passport.', 'validation');
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
							$errors[] = $this->module->l('You must introduce your address.', 'validation');
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
							$errors[] = $this->module->l('You must introduce your zip code.', 'validation');
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
							$errors[] = $this->module->l('You must introduce the credit card number.', 'validation');
					}
					
					if(Configuration::get('CCOFFLINE_REQUIRECARDNUMBER') & $card['number'] != "" & Configuration::get('CCOFFLINE_REQUIREISSUER') & !$this->module->validateCard($card['number'], $card['issuer']))
						$errors[] = $this->module->l('The credit card number entered is not valid.', 'validation');
					
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIRECARDNUMBER'))
					{
						$card['number'] = "";
					}

					//CVC
					if(Configuration::get('CCOFFLINE_REQUIRECVC') & Configuration::get('CCOFFLINE_REQUIREDCVC'))
					{
						if($card['cvc']=="")
							$errors[] = $this->module->l('You must introduce the CVC card number.', 'validation');
					}
					//If variable not required, initialize to blank
					if(Configuration::get('CCOFFLINE_REQUIRECVC') & $card['cvc'] != "" & (!is_numeric($card['cvc'])))
						$errors[] = $this->module->l('The CVC card number entered is not valid.', 'validation');
					
					//If variable not required, initialize to blank
					if(!Configuration::get('CCOFFLINE_REQUIRECVC'))
					{
						$card['cvc'] = "";
					}

					//Card issuer
					if(Configuration::get('CCOFFLINE_REQUIREISSUER') & Configuration::get('CCOFFLINE_REQUIREDISSUER'))
					{
						if($card['issuer']=="")
							$errors[] = $this->module->l('You must choose your card issuer.', 'validation');
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
							$errors[] = $this->module->l('You must introduce the expiry month of the credit card.', 'validation');
						if($card['ano_caducidad']=="")
							$errors[] = $this->module->l('You must introduce the expiry year of the credit card.', 'validation');						
						// Check that the date is valid					
						if($card['mes_caducidad']!="" && $card['ano_caducidad']!="" && $card['ano_caducidad'] == date("Y") && $card['mes_caducidad'] < date("m"))
							$errors[] = $this->module->l('The expiry date that you introduced can not be prior to actual date.', 'validation');						
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

						$payment_method = $this->module->l('Credit card offline payment - physical POS', 'validation');

						//and place the order
						$this->module->validateOrder($cart->id, Configuration::get('CCOFFLINE_DATA_OS_INITIAL'), $total, $this->module->displayName, null, null, $id_currency, false, $cart->secure_key);

						$order = new Order((int)($this->module->currentOrder));

						if (Configuration::get('CCOFFLINE_WORKINGMODE')==2) {
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
							$title =  $this->module->l('Order', 'validation') . ' #' .  $order->id . ' ' . $this->module->l('paid with credit card', 'validation'); //Mail subject with translation
							$from = Configuration::get('PS_SHOP_EMAIL');   //Sender's email
							$fromName = Configuration::get('PS_SHOP_NAME'); //Sender's name
							$mailDir = $this->module->getLocalPath().'mails/'; //Directory with message templates
							$toMail = Configuration::get('CCOFFLINE_ADMIN_MAIL'); //To mail address
								
							Mail::Send($id_lang, $template_name, $title, $templateVars, $toMail, '', $from, $fromName, NULL, NULL, $mailDir);
						}

						// Once complete, redirect to order-confirmation.php
						Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?id_cart='.(int)($cart->id).'&id_module='.(int)($this->module->id).'&id_order='.(int)($this->module->currentOrder).'&key='.$order->secure_key);

					} else {
						$this->context->smarty->assign('card', $card);
					}
				}

				$this->display_column_left = false;
				parent::initContent();

				$this->context->smarty->assign(array(
					'nbProducts' 		=> $cart->nbProducts(),
					'default_currency' 	=> new Currency(Configuration::get('PS_CURRENCY_DEFAULT')),
					'currency'			=> new Currency(intval((int)$this->context->cookie->id_currency)),
					'id_currency'		=> (int)$this->context->cookie->id_currency,
					'total'				=> number_format($cart->getOrderTotal(true, 3), 2, '.', ''),
					'errores' 			=> $errors,
					'issuers'			=> CreditCardOfflinePaymentBrands::getIssuers(),
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
					'this_path' 		=> $this->module->getPathUri(),
					'this_path_ssl' 	=> Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
					'mobile_device' 	=> $this->context->getMobileDevice(),
				));

				$this->setTemplate('payment_execution.tpl');
			}
		} catch (Exception $e){
				error_log($e);
		}
	}
}