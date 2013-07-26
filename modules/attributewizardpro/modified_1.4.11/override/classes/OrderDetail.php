<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OrderDetail extends OrderDetailCore
{

	protected	$fieldsValidate = array (
	'id_order' => 'isUnsignedId',
	'product_id' => 'isUnsignedId',
	'product_attribute_id' => 'isUnsignedId',
	'product_name' => 'isCleanHtml',
	'product_quantity' => 'isInt',
	'product_quantity_in_stock' => 'isInt',
	'product_quantity_return' => 'isUnsignedInt',
	'product_quantity_refunded' => 'isUnsignedInt',
	'product_quantity_reinjected' => 'isUnsignedInt',
	'product_price' => 'isPrice',
	'reduction_percent' => 'isFloat',
	'reduction_amount' => 'isPrice',
	'group_reduction' => 'isFloat',
	'product_quantity_discount' => 'isFloat',
	'product_ean13' => 'isEan13',
	'product_upc' => 'isUpc',
	'product_reference' => 'isReference',
	'product_supplier_reference' => 'isReference',
	'product_weight' => 'isFloat',
	'tax_name' => 'isGenericName',
	'tax_rate' => 'isFloat',
	'ecotax' => 'isFloat',
	'ecotax_tax_rate' => 'isFloat',
	'download_nb' => 'isInt',
	);
	


}


