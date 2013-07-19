<?php
/*
 * IDnovate (http://www.idnovate.com)
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
 *	Versions
 * 	1.34 - May 2, 2013 - idnovate.com - For Prestashop 1.4 & 1.5
 *
*/

/**
 * Defines statuses which will trigger the 
 * deletion of credit data from the database
 */

class CreditCardOfflinePaymentStates extends ObjectModel
{
	
	public static function getOrderStates($ids_only = false)
	{
		global $cookie;
		
		$returnStates = array();
		
		$states = OrderState::getOrderStates($cookie->id_lang);		
		
		$id_initial_state = Configuration::get('CCOFFLINE_DATA_OS_INITIAL');
		
		foreach($states as $k => $state)
		{
			if($ids_only)
			{
				$returnStates[] = $state['id_order_state'];
			}
			else
			{
				$returnStates[] = $state;
			}
		}
		return $returnStates;
	}
}

?>