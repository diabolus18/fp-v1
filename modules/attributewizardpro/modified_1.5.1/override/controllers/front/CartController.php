<?php
/*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 7310 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class CartController extends CartControllerCore
{
	protected $instructions;
	protected $id_instructions;
	public function init()
	{
		parent::init();

		// Get page main parameters
		$ins = Tools::getValue('special_instructions',"");
		$this->instructions = $ins != "undefined"?$ins:"";
		$ins_id = Tools::getValue('special_instructions_id',"");
		$this->id_instructions = $ins_id != "undefined"?$ins_id:"";
	}

	/**
	 * This process delete a product from the cart
	 */
	protected function processDeleteProductInCart()
	{
		if ($this->context->cart->deleteProduct($this->id_product, $this->id_product_attribute, $this->customization_id, $this->id_address_delivery, $this->instructions))
		{
			if (!Cart::getNbProducts((int)($this->context->cart->id)))
			{
				$this->context->cart->setDeliveryOption(null);
				$this->context->cart->gift = 0;
				$this->context->cart->gift_message = '';
				$this->context->cart->update();
			}
		}
		$removed = CartRule::autoAddToCart();
		if (count($removed) && (int)Tools::getValue('allow_refresh'))
			$this->ajax_refresh = true;
	}
	
	protected function processDuplicateProduct()
	{
		if (!Configuration::get('PS_ALLOW_MULTISHIPPING'))
			return;

		if (!$this->context->cart->duplicateProduct(
				$this->id_product,
				$this->id_product_attribute,
				$this->id_address_delivery,
				(int)Tools::getValue('new_id_address_delivery'),
				1,
				false,
				Tools::getValue('instrcutions_valid',"")
			))
		{
			//$error_message = $this->l('Error durring product duplication');
			// For the moment no translations
			$error_message = 'Error durring product duplication';
		}
	}

	/**
	 * This process add or update a product in the cart
	 */
	protected function processChangeProductInCart()
	{
		$mode = (Tools::getIsset('update') && $this->id_product) ? 'update' : 'add';

		if ($this->qty == 0)
			$this->errors[] = Tools::displayError('Null quantity');
		else if (!$this->id_product)
			$this->errors[] = Tools::displayError('Product not found');

		$product = new Product($this->id_product, true, $this->context->language->id);
		if (!$product->id || !$product->active)
		{
			$this->errors[] = Tools::displayError('Product is no longer available.', false);
			return;
		}

		// Check product quantity availability
		if ($this->id_product_attribute)
		{
			if (!Product::isAvailableWhenOutOfStock($product->out_of_stock) && !Attribute::checkAttributeQty($this->id_product_attribute, $this->qty))
				$this->errors[] = Tools::displayError('There is not enough product in stock.');
		}
		else if ($product->hasAttributes())
		{
			$minimumQuantity = ($product->out_of_stock == 2) ? !Configuration::get('PS_ORDER_OUT_OF_STOCK') : !$product->out_of_stock;
			$this->id_product_attribute = Product::getDefaultAttribute($product->id, $minimumQuantity);
			// @todo do something better than a redirect admin !!
			if (!$this->id_product_attribute)
				Tools::redirectAdmin($this->context->link->getProductLink($product));
			else if (!Product::isAvailableWhenOutOfStock($product->out_of_stock) && !Attribute::checkAttributeQty($this->id_product_attribute, $this->qty))
				$this->errors[] = Tools::displayError('There is not enough product in stock.');
		}
		else if (!$product->checkQty($this->qty))
			$this->errors[] = Tools::displayError('There is not enough product in stock.');

		// If no errors, process product addition
		if (!$this->errors && $mode == 'add')
		{
			// Add cart if no cart found
			if (!$this->context->cart->id)
			{
				$this->context->cart->add();
				if ($this->context->cart->id)
					$this->context->cookie->id_cart = (int)$this->context->cart->id;
			}

			// Check customizable fields
			if (!$product->hasAllRequiredCustomizableFields() && !$this->customization_id)
				$this->errors[] = Tools::displayError('Please fill in all required fields, then save the customization.');

			if (!$this->errors)
			{
				$cart_rules = $this->context->cart->getCartRules();
				$update_quantity = $this->context->cart->updateQty($this->qty, $this->id_product, $this->id_product_attribute, $this->customization_id, Tools::getValue('op', 'up'), $this->id_address_delivery, null, true, $this->instructions, $this->id_instructions);
				if ($update_quantity < 0)
				{
					// If product has attribute, minimal quantity is set with minimal quantity of attribute
					$minimal_quantity = ($this->id_product_attribute) ? Attribute::getAttributeMinimalQty($this->id_product_attribute) : $product->minimal_quantity;
					$this->errors[] = sprintf(Tools::displayError('You must add %d minimum quantity', false), $minimal_quantity);
				}
				elseif (!$update_quantity)
					$this->errors[] = Tools::displayError('You already have the maximum quantity available for this product.', false);
				elseif ((int)Tools::getValue('allow_refresh'))
				{
					// If the cart rules has changed, we need to refresh the whole cart
					$cart_rules2 = $this->context->cart->getCartRules();
					if (count($cart_rules2) != count($cart_rules))
						$this->ajax_refresh = true;
					else
					{
						$rule_list = array();
						foreach ($cart_rules2 as $rule)
							$rule_list[] = $rule['id_cart_rule'];
						foreach ($cart_rules as $rule)
							if (!in_array($rule['id_cart_rule'], $rule_list))
							{
								$this->ajax_refresh = true;
								break;
							}
					}
				}
			}
		}

		$removed = CartRule::autoRemoveFromCart();
		if (count($removed) && (int)Tools::getValue('allow_refresh'))
			$this->ajax_refresh = true;
	}

}
