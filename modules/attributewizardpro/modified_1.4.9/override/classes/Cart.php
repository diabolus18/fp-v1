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
*  @version  Release: $Revision: 16875 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Cart extends CartCore
{
	public		$id;

	/** @var integer Customer delivery address ID */
	public 		$id_address_delivery;

	/** @var integer Customer invoicing address ID */
	public 		$id_address_invoice;

	/** @var integer Customer currency ID */
	public 		$id_currency;

	/** @var integer Customer ID */
	public 		$id_customer;

	/** @var integer Guest ID */
	public 		$id_guest;

	/** @var integer Language ID */
	public 		$id_lang;

	/** @var integer Carrier ID */
	public 		$id_carrier;

	/** @var boolean True if the customer wants a recycled package */
	public		$recyclable = 1;

	/** @var boolean True if the customer wants a gift wrapping */
	public		$gift = 0;

	/** @var string Gift message if specified */
	public 		$gift_message;

	/** @var string Object creation date */
	public 		$special_instructions;
	public 		$date_add;

	/** @var string secure_key */
	public		$secure_key;

	/** @var string Object last modification date */
	public		$date_upd;

	protected static $_nbProducts = array();
	protected static $_isVirtualCart = array();

	protected $fieldsRequired = array('id_currency', 'id_lang');
	protected $fieldsValidate = array('id_address_delivery' => 'isUnsignedId', 'id_address_invoice' => 'isUnsignedId',
		'id_currency' => 'isUnsignedId', 'id_customer' => 'isUnsignedId', 'id_guest' => 'isUnsignedId', 'id_lang' => 'isUnsignedId',
		'id_carrier' => 'isUnsignedId', 'recyclable' => 'isBool', 'gift' => 'isBool', 'gift_message' => 'isMessage');

	protected $_products = NULL;
	protected static $_totalWeight = array();
	protected $_taxCalculationMethod = PS_TAX_EXC;
	protected static $_discounts = NULL;
	protected static $_discountsLite = NULL;
	protected static $_carriers = NULL;
	protected static $_taxes_rate = NULL;
	protected static $_attributesLists = array();
	protected $table = 'cart';
	protected $identifier = 'id_cart';

	protected	$webserviceParameters = array(
		'fields' => array(
		'id_address_delivery' => array('xlink_resource' => 'addresses'),
		'id_address_invoice' => array('xlink_resource' => 'addresses'),
		'id_currency' => array('xlink_resource' => 'currencies'),
		'id_customer' => array('xlink_resource' => 'customers'),
		'id_guest' => array('xlink_resource' => 'guests'),
		'id_lang' => array('xlink_resource' => 'languages'),
		'id_carrier' => array('xlink_resource' => 'carriers'),
		),
		'associations' => array(
			'cart_rows' => array('resource' => 'cart_row', 'virtual_entity' => true, 'fields' => array(
				'id_product' => array('required' => true, 'xlink_resource' => 'products'),
				'id_product_attribute' => array('required' => true, 'xlink_resource' => 'combinations'),
				'quantity' => array('required' => true),
				)
			),
		),
	);
	
	const ONLY_PRODUCTS = 1;
	const ONLY_DISCOUNTS = 2;
	const BOTH = 3;
	const BOTH_WITHOUT_SHIPPING = 4;
	const ONLY_SHIPPING = 5;
	const ONLY_WRAPPING = 6;
	const ONLY_PRODUCTS_WITHOUT_SHIPPING = 7;
	const ONLY_PHYSICAL_PRODUCTS_WITHOUT_SHIPPING = 8;


	public function getLastProduct()
	{
		$sql = '
			SELECT `id_product`, `id_product_attribute`, `instructions`
			FROM `'._DB_PREFIX_.'cart_product`
			WHERE `id_cart` = '.(int)($this->id).'
			ORDER BY `date_add` DESC';
		$result = Db::getInstance()->getRow($sql);
		if ($result AND isset($result['id_product']) AND $result['id_product'])
			return $result;
		return false;
	}

	/**
	 * Return cart products
	 *
	 * @result array Products
	 */
	public function getProducts($refresh = false, $id_product = false)
	{
		if (!$this->id)
			return array();
		// Product cache must be strictly compared to NULL, or else an empty cart will add dozens of queries
		if ($this->_products !== null && !$refresh)
			return $this->_products;

		$result = Db::getInstance()->ExecuteS('
		SELECT cp.`id_product_attribute`, cp.`id_product`, cp.`instructions` AS instructions, cp.`instructions_valid` AS instructions_valid, cp.`instructions_id` AS instructions_id, cu.`id_customization`, cp.`quantity` cart_quantity, cu.`quantity` customization_quantity, pl.`name`,
		pl.`description_short`, pl.`available_now`, pl.`available_later`, p.`id_product`, p.`id_category_default`, p.`id_supplier`, p.`id_manufacturer`, p.`on_sale`, p.`ecotax`, p.`additional_shipping_cost`, p.`available_for_order`,
		p.`quantity`, p.`price`, p.`weight`, p.`width`, p.`height`, p.`depth`, p.`out_of_stock`, p.`active`, p.`date_add`, p.`date_upd`, IFNULL(pa.`minimal_quantity`, p.`minimal_quantity`) minimal_quantity,
		t.`id_tax`, tl.`name` tax, t.`rate`, pa.`price` price_attribute, pa.`quantity` quantity_attribute,
		pa.`ecotax` ecotax_attr, pl.`link_rewrite`, cl.`link_rewrite` category,
		IF (IFNULL(pa.`reference`, \'\') = \'\', p.`reference`, pa.`reference`) reference,
		IF (IFNULL(pa.`supplier_reference`, \'\') = \'\', p.`supplier_reference`, pa.`supplier_reference`) supplier_reference,
		(p.`weight`+ pa.`weight`) weight_attribute,
		IF (IFNULL(pa.`ean13`, \'\') = \'\', p.`ean13`, pa.`ean13`) ean13, IF (IFNULL(pa.`upc`, \'\') = \'\', p.`upc`, pa.`upc`) upc,
		pai.`id_image` pai_id_image, il.`legend` pai_legend
		FROM `'._DB_PREFIX_.'cart_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.`id_product_attribute` = cp.`id_product_attribute`)
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`	AND tr.`id_country` = '.(int)Country::getDefaultCountryId().' AND tr.`id_state` = 0)
		LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'customization` cu ON (cp.`id_product` = cu.`id_product` AND cp.`id_product_attribute` = cu.`id_product_attribute` AND cu.`id_cart` = cp.`id_cart`)
		LEFT JOIN `'._DB_PREFIX_.'product_attribute_image` pai ON (pai.`id_product_attribute` = pa.`id_product_attribute`)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (il.`id_image` = pai.`id_image` AND il.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)$this->id_lang.')
		WHERE cp.`id_cart` = '.(int)$this->id.($id_product ? ' AND cp.`id_product` = '.(int)$id_product : '').'	AND p.`id_product` IS NOT NULL
		GROUP BY CONCAT(cp.`id_product`, \'_\', cp.`id_product_attribute`, \'_\', cp.`instructions_valid`)
		ORDER BY cp.date_add ASC');
//CHECK THIS GROUP BY//
		// Reset the cache before the following return, or else an empty cart will add dozens of queries
		$productsIds = array();
		$paIds = array();
		foreach ($result as $row)
		{
			$productsIds[] = $row['id_product'];
			$paIds[] = $row['id_product_attribute'];
		}
		// Thus you can avoid one query per product, because there will be only one query for all the products of the cart
		Product::cacheProductsFeatures($productsIds);
		self::cacheSomeAttributesLists($paIds, $this->id_lang);

		$this->_products = array();
		if (empty($result))
			return array();
		foreach ($result as $row)
		{
			if (isset($row['ecotax_attr']) && $row['ecotax_attr'] > 0)
				$row['ecotax'] = (float)$row['ecotax_attr'];
			$row['stock_quantity'] = (int)$row['quantity'];
			// for compatibility with 1.2 themes
			$row['quantity'] = (int)$row['cart_quantity'];
			if (isset($row['id_product_attribute']) && (int)$row['id_product_attribute'])
			{
				$row['weight'] = $row['weight_attribute'];
				$row['stock_quantity'] = $row['quantity_attribute'];
			}
			if ($this->_taxCalculationMethod == PS_TAX_EXC)
			{
				$row['price'] = Product::getPriceStatic((int)$row['id_product'], false, isset($row['id_product_attribute']) ? (int)($row['id_product_attribute']) : NULL, 2, NULL, false, true, (int)($row['cart_quantity']), false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL), $specificPriceOutput); // Here taxes are computed only once the quantity has been applied to the product price
				$row['price_wt'] = Product::getPriceStatic((int)$row['id_product'], true, isset($row['id_product_attribute']) ? (int)($row['id_product_attribute']) : NULL, 2, NULL, false, true, (int)($row['cart_quantity']), false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL));
				$tax_rate = Tax::getProductTaxRate((int)$row['id_product'], (int)$this->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

				$row['total_wt'] = Tools::ps_round($row['price'] * (float)$row['cart_quantity'] * (1 + (float)$tax_rate / 100), 2);
				$row['total'] = $row['price'] * (int)$row['cart_quantity'];
			}
			else
			{
				$row['price'] = Product::getPriceStatic((int)$row['id_product'], false, (int)$row['id_product_attribute'], 6, NULL, false, true, $row['cart_quantity'], false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL), $specificPriceOutput);
				$row['price_wt'] = Product::getPriceStatic((int)$row['id_product'], true, (int)$row['id_product_attribute'], 2, NULL, false, true, $row['cart_quantity'], false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL));

				/* In case when you use QuantityDiscount, getPriceStatic() can be return more of 2 decimals */
				$row['price_wt'] = Tools::ps_round($row['price_wt'], 2);
				$row['total_wt'] = $row['price_wt'] * (int)($row['cart_quantity']);
				$row['total'] = Tools::ps_round($row['price'] * (int)($row['cart_quantity']), 2);
			}

			if (!isset($row['pai_id_image']) || $row['pai_id_image'] == 0)
			{
				$row2 = Db::getInstance()->getRow('
				SELECT i.`id_image`, il.`legend`
				FROM `'._DB_PREFIX_.'image` i
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$this->id_lang.')
				WHERE i.`id_product` = '.(int)$row['id_product'].' AND i.`cover` = 1');
				if (!$row2)
					$row2 = array('id_image' => false, 'legend' => false);
				else
					$row = array_merge($row, $row2);
			}
			else
			{
				$row['id_image'] = $row['pai_id_image'];
				$row['legend'] = $row['pai_legend'];
			}

			$row['reduction_applies'] = $specificPriceOutput && $specificPriceOutput['reduction'];
			$row['id_image'] = Product::defineProductImage($row, $this->id_lang);
			$row['allow_oosp'] = Product::isAvailableWhenOutOfStock($row['out_of_stock']);
			$row['features'] = Product::getFeaturesStatic((int)$row['id_product']);
			if (array_key_exists($row['id_product_attribute'].'-'.$this->id_lang, self::$_attributesLists))
				$row = array_merge($row, self::$_attributesLists[$row['id_product_attribute'].'-'.$this->id_lang]);

			$this->_products[] = $row;
		}
		return $this->_products;
	}

	public static function cacheSomeAttributesLists($ipaList, $id_lang)
	{
		$paImplode = array();
		foreach ($ipaList as $id_product_attribute)
			if ((int)$id_product_attribute AND !array_key_exists($id_product_attribute.'-'.$id_lang, self::$_attributesLists))
			{
				$paImplode[] = (int)$id_product_attribute;
				self::$_attributesLists[(int)$id_product_attribute.'-'.$id_lang] = array('attributes' => '', 'attributes_small' => '');
			}
		if (!count($paImplode))
			return;

		$result = Db::getInstance()->ExecuteS('
		SELECT pac.`id_product_attribute`, agl.`public_name` public_group_name, al.`name` attribute_name
		FROM `'._DB_PREFIX_.'product_attribute_combination` pac
		LEFT JOIN `'._DB_PREFIX_.'attribute` a ON (a.`id_attribute` = pac.`id_attribute`)
		LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON (ag.`id_attribute_group` = a.`id_attribute_group`)
		LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)$id_lang.')
		WHERE pac.`id_product_attribute` IN ('.implode($paImplode, ',').')
		ORDER BY agl.`public_name` ASC');

		foreach ($result as $row)
		{
			self::$_attributesLists[$row['id_product_attribute'].'-'.$id_lang]['attributes'] .= $row['public_group_name'].' : '.$row['attribute_name'].', ';
			self::$_attributesLists[$row['id_product_attribute'].'-'.$id_lang]['attributes_small'] .= $row['attribute_name'].', ';
		}

		foreach ($paImplode as $id_product_attribute)
		{
			self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes'] = rtrim(self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes'], ', ');
			self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes_small'] = rtrim(self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes_small'], ', ');
		}
	}

	public function containsProduct($id_product, $id_product_attribute, $id_customization, $instructions)
	{
		return Db::getInstance()->getRow('
		SELECT cp.`quantity`
		FROM `'._DB_PREFIX_.'cart_product` cp
		'.($id_customization ? 'LEFT JOIN `'._DB_PREFIX_.'customization` c ON (c.`id_product` = cp.`id_product` AND c.`id_product_attribute` = cp.`id_product_attribute`)' : '').'
		WHERE cp.`id_product` = '.(int)$id_product.' AND cp.`id_product_attribute` = '.(int)$id_product_attribute.' AND cp.`id_cart` = '.(int)$this->id. ' AND (cp.instructions = "'.mysql_real_escape_string($instructions).'" OR cp.instructions_valid= "'.mysql_real_escape_string($instructions).'")'.
		($id_customization ? ' AND c.`id_customization` = '.(int)$id_customization : ''));
	}

	/**
	 * Update product quantity
	 *
	 * @param integer $quantity Quantity to add (or substract)
	 * @param integer $id_product Product ID
	 * @param integer $id_product_attribute Attribute ID if needed
	 * @param string $operator Indicate if quantity must be increased or decreased
	 */
	public	function updateQty($quantity, $id_product, $id_product_attribute = NULL, $id_customization = false, $operator = 'up',$instructions, $instructions_id)
	{
		/* Check if the product exists in Db and is available for order (+ handle product removal from cart) */
		if ($id_product > 0)
			$product = Db::getInstance()->getRow('
			SELECT id_product, available_for_order, minimal_quantity, customizable
			FROM '._DB_PREFIX_.'product
			WHERE id_product = '.(int)$id_product.' AND active = 1');

		if (!isset($product) || !$product)
			die(Tools::displayError());
		if (isset(self::$_nbProducts[$this->id]))
			unset(self::$_nbProducts[$this->id]);
		if (isset(self::$_totalWeight[$this->id]))
			unset(self::$_totalWeight[$this->id]);
		if ((int)$quantity <= 0)
			return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
		elseif (!$product['available_for_order'] || Configuration::get('PS_CATALOG_MODE'))
			return false;
			
		/* Product is available for order, let's add it to the cart or update the existing quantities */
		else
		{
			/* If we have a product combination, the minimal quantity is set with the one of this combination */
			$minimalQuantity = !empty($id_product_attribute) ? (int)Attribute::getAttributeMinimalQty((int)$id_product_attribute) : (int)$product['minimal_quantity'];
		
			/* Check if the product is already in the cart */
			$result = $this->containsProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);

			/* Update the current quantity if the product already exist in the cart */
			if ($result)
			{
				if ($operator == 'up')
				{
					/* We need to check if the product is in stock (or can be ordered without stock) */
					$result2 = Db::getInstance()->getRow('
					SELECT '.(!empty($id_product_attribute) ? 'pa' : 'p').'.`quantity`, p.`out_of_stock`
					FROM `'._DB_PREFIX_.'product` p
					'.(!empty($id_product_attribute) ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)' : '').'
					WHERE p.`id_product` = '.(int)$id_product.
					(!empty($id_product_attribute) ? ' AND pa.`id_product_attribute` = '.(int)$id_product_attribute : ''));

					$newQty = (int)$result['quantity'] + (int)$quantity;
					$qty = '+ '.(int)$quantity;

					/* If the total quantity asked is greater than the stock, we need to make sure that the product can be ordered without stock */
					if ($newQty > (int)$result2['quantity'] && !Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
						return false;
				}
				elseif ($operator == 'down')
				{
					$qty = '- '.(int)$quantity;
					$newQty = (int)$result['quantity'] - (int)$quantity;
				}
				else
					return false;

				/* If the new product quantity is lower or equal to zero, we can remove this product from the cart */
				if ($newQty <= 0)
					return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
				
				/* If the new product quantity does not match the minimal quantity to buy the product (default = 1), return -1 */
				elseif ($minimalQuantity > 1 && $newQty < $minimalQuantity)
					return -1;
					
				/* Otherwise, we are ready to update the current quantity of this product in the cart */
				else
					Db::getInstance()->Execute('
					UPDATE `'._DB_PREFIX_.'cart_product`
					SET `quantity` = `quantity` '.$qty.', `date_add` = NOW()
					WHERE `id_product` = '.(int)$id_product.
					(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : '').' AND (instructions = "'.mysql_real_escape_string($instructions).'" OR  instructions_valid = "'.mysql_real_escape_string($instructions).'" OR  instructions_valid = "'.($instructions?md5($instructions):"").'")'.'
					AND `id_cart` = '.(int)$this->id.'
					LIMIT 1');
			}

			/* Add the product to the cart */
			else
			{
				$result2 = Db::getInstance()->getRow('
				SELECT '.(!empty($id_product_attribute) ? 'pa' : 'p').'.`quantity`, p.`out_of_stock`
				FROM `'._DB_PREFIX_.'product` p
				'.(!empty($id_product_attribute) ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON p.`id_product` = pa.`id_product`' : '').'
				WHERE p.`id_product` = '.(int)$id_product.
				(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : ''));

				/* If the quantity asked is greater than the stock, we need to make sure that the product can be ordered without stock */
				if ((int)$quantity > $result2['quantity'] && !Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
					return false;

				/* If the new product quantity does not match the minimal quantity to buy the product (default = 1), return -1 */
				if ($minimalQuantity > 1 && $quantity < $minimalQuantity)
					return -1;

				if (!Db::getInstance()->Execute('
				INSERT INTO '._DB_PREFIX_.'cart_product (id_product, id_product_attribute, id_cart, quantity, instructions, instructions_valid, instructions_id, date_add) VALUES
				('.(int)$id_product.', '.($id_product_attribute ? (int)$id_product_attribute : 0).', '.(int)$this->id.', '.(int)$quantity.', "'.mysql_real_escape_string($instructions).'", "'.($instructions?md5($instructions):"").'", "'.$instructions_id.'", NOW())'))
					return false;
			}
		}

		/* If it's a customizable product, we need to update the related table. The function will also refresh the cache and update the cart itself */ 
		if ($product['customizable'])
			return $this->_updateCustomizationQuantity((int)$quantity, (int)$id_customization, (int)$id_product, (int)$id_product_attribute, $operator);
			
		/* Otherwise, refresh the cache of self::_products and update the cart */
		else
		{
			$this->_products = $this->getProducts(true);
			$this->update(true);
			return true;
		}
	}

	/**
	 * Delete a product from the cart
	 *
	 * @param integer $id_product Product ID
	 * @param integer $id_product_attribute Attribute ID if needed
	 * @param integer $id_customization Customization id
	 * @return boolean result
	 */
	public	function deleteProduct($id_product, $id_product_attribute = NULL, $id_customization = NULL, $instructions)
	{
		if (isset(self::$_nbProducts[$this->id]))
			unset(self::$_nbProducts[$this->id]);
		if (isset(self::$_totalWeight[$this->id]))
			unset(self::$_totalWeight[$this->id]);
		if ((int)($id_customization))
		{
			$productTotalQuantity = (int)(Db::getInstance()->getValue('SELECT `quantity`
				FROM `'._DB_PREFIX_.'cart_product`
				WHERE `id_product` = '.(int)($id_product).' AND `id_product_attribute` = '.(int)($id_product_attribute)));
			$customizationQuantity = (int)(Db::getInstance()->getValue('SELECT `quantity`
				FROM `'._DB_PREFIX_.'customization`
				WHERE `id_cart` = '.(int)($this->id).'
					AND `id_product` = '.(int)($id_product).'
					AND `id_product_attribute` = '.(int)($id_product_attribute)));
			if (!$this->_deleteCustomization((int)($id_customization), (int)($id_product), (int)($id_product_attribute)))
				return false;
			// refresh cache of self::_products
			$this->_products = $this->getProducts(true);
			return ($customizationQuantity == $productTotalQuantity AND $this->deleteProduct((int)($id_product), $id_product_attribute, NULL));
		}

		/* Get customization quantity */
		if (($result = Db::getInstance()->getRow('SELECT SUM(`quantity`) AS \'quantity\' FROM `'._DB_PREFIX_.'customization` WHERE `id_cart` = '.(int)($this->id).' AND `id_product` = '.(int)($id_product).' AND `id_product_attribute` = '.(int)($id_product_attribute))) === false && $instructions == '')
			return false;

		/* If the product still possesses customization it does not have to be deleted */
		if (Db::getInstance()->NumRows() AND (int)($result['quantity']))
			return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'cart_product` SET `quantity` = '.(int)($result['quantity']).' WHERE `id_cart` = '.(int)($this->id).' AND  (instructions = "'.$instructions.'" OR instructions_valid = "'.$instructions.'") AND `id_product` = '.(int)($id_product).($id_product_attribute != NULL ? ' AND `id_product_attribute` = '.(int)($id_product_attribute) : ''));

		/* Product deletion */
		if (Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'cart_product` WHERE `id_product` = '.(int)($id_product).($id_product_attribute != NULL ? ' AND `id_product_attribute` = '.(int)($id_product_attribute) : '').' AND (`instructions` = \''.$instructions.'\' OR instructions_valid = "'.$instructions.'")  AND `id_cart` = '.(int)($this->id)))
		{
			// refresh cache of self::_products
			$this->_products = $this->getProducts(true);
			/* Update cart */
			return $this->update(true);
		}
		return false;
	}

	public function duplicate()
	{
		if (!Validate::isLoadedObject($this))
			return false;
		$cart = new Cart($this->id);
		$cart->id = NULL;
		$cart->add();
		include_once(dirname(__FILE__).'/../../modules/attributewizardpro/attributewizardpro.php');
		$awp = new AttributeWizardPro();

		if (!Validate::isLoadedObject($cart))
			return false;

		$success = true;
		$products = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'cart_product` WHERE `id_cart` = '.(int)$this->id);
		foreach ($products AS $product)
			$success &= $cart->updateQty($product['quantity'], (int)$product['id_product'], $product['instructions_id']!= ''?$awp->getIdProductAttribute($product['id_product'],$product['instructions_id']):(int)$product['id_product_attribute'], NULL, 'up',$product['instructions'], $product['instructions_id']);

		// Customized products
		$customs = Db::getInstance()->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'customization c
		LEFT JOIN '._DB_PREFIX_.'customized_data cd ON cd.id_customization = c.id_customization
		WHERE c.id_cart = '.(int)$this->id);

		// Get datas from customization table
		$customsById = array();
		foreach ($customs as $custom)
		{
			if (!isset($customsById[$custom['id_customization']]))
				$customsById[$custom['id_customization']] = array('id_product_attribute' => $custom['id_product_attribute'],
				'id_product' => $custom['id_product'], 'quantity' => $custom['quantity']);
		}

		// Insert new customizations
		$custom_ids = array();
		foreach($customsById as $customizationId => $val)
		{
			Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'customization` (id_cart, id_product_attribute, id_product, quantity)
			VALUES('.(int)$cart->id.', '.(int)$val['id_product_attribute'].', '.(int)$val['id_product'].', '.(int)$val['quantity'].')');
			$custom_ids[$customizationId] = Db::getInstance()->Insert_ID();
		}

		// Insert customized_data
		if (sizeof($customs))
		{
			$first = true;
			$sql_custom_data = 'INSERT INTO '._DB_PREFIX_.'customized_data (`id_customization`, `type`, `index`, `value`) VALUES ';
			foreach ($customs AS $custom)
			{
				if (!$first)
					$sql_custom_data .= ',';
				else
					$first = false;
				$sql_custom_data .= '('.(int)$custom_ids[$custom['id_customization']].', '.(int)$custom['type'].', '.(int)$custom['index'].', \''.pSQL($custom['value']).'\')';
			}
			Db::getInstance()->Execute($sql_custom_data);
		}

		return array('cart' => $cart, 'success' => $success);
	}

}