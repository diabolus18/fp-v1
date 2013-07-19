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
 *	Versions
 * 	1.34 - May 2, 2013 - idnovate.com - For Prestashop 1.4 & 1.5
 *
*/

include(dirname(__FILE__).'/../../config/config.inc.php');

$useSSL = true;

include(dirname(__FILE__).'/../../header.php');
include_once(dirname(__FILE__).'/creditcardofflinepayment.php');

$creditcard = new creditcardofflinepayment();
echo $creditcard->execPayment($cart);

include(dirname(__FILE__).'/../../footer.php');

?>
