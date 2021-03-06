<?php
/*
* 2007-2011 PrestaShop
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
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 1.4 $
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
	public 		$date_upd;

	protected static $_nbProducts = NULL;
	protected static $_isVirtualCart = array();

	protected	$fieldsRequired = array('id_currency', 'id_lang');
	protected	$fieldsValidate = array('id_address_delivery' => 'isUnsignedId', 'id_address_invoice' => 'isUnsignedId',
		'id_currency' => 'isUnsignedId', 'id_customer' => 'isUnsignedId', 'id_guest' => 'isUnsignedId', 'id_lang' => 'isUnsignedId',
		'id_carrier' => 'isUnsignedId', 'recyclable' => 'isBool', 'gift' => 'isBool', 'gift_message' => 'isMessage');

	protected	$_products = NULL;
	protected 	static $_totalWeight = array();
	protected	$_taxCalculationMethod = PS_TAX_EXC;
	protected	static $_discounts = NULL;
	protected	static $_discountsLite = NULL;
	protected	static $_carriers = NULL;
	protected	static $_taxes_rate = NULL;
	protected 	static $_attributesLists = array();
	protected 	$table = 'cart';
	protected 	$identifier = 'id_cart';

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
			'cart_rows' => array('resource' => 'cart_row', 'fields' => array(
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
		if ($this->_products !== NULL AND !$refresh)
			return $this->_products;
		$sql = '
		SELECT cp.`id_product_attribute`, cp.`id_product`, cp.`instructions` AS instructions, cp.`instructions_valid` AS instructions_valid, cp.`instructions_id` AS instructions_id, cu.`id_customization`, cp.`quantity` AS cart_quantity, cu.`quantity` AS customization_quantity, pl.`name`,
		pl.`description_short`, pl.`available_now`, pl.`available_later`, p.`id_product`, p.`id_category_default`, p.`id_supplier`, p.`id_manufacturer`, p.`on_sale`, p.`ecotax`, p.`additional_shipping_cost`, p.`available_for_order`,
		p.`quantity`, p.`price`, p.`weight`, p.`width`, p.`height`, p.`depth`, p.`out_of_stock`, p.`active`, p.`date_add`, p.`date_upd`, IFNULL(pa.`minimal_quantity`, p.`minimal_quantity`) as minimal_quantity,
		t.`id_tax`, tl.`name` AS tax, t.`rate`, pa.`price` AS price_attribute, pa.`quantity` AS quantity_attribute,
        pa.`ecotax` AS ecotax_attr, i.`id_image`, il.`legend`, pl.`link_rewrite`, cl.`link_rewrite` AS category, CONCAT(cp.`id_product`, cp.`id_product_attribute`, cp.`instructions`) AS unique_id,
        IF (IFNULL(pa.`reference`, \'\') = \'\', p.`reference`, pa.`reference`) AS reference,
        IF (IFNULL(pa.`supplier_reference`, \'\') = \'\', p.`supplier_reference`, pa.`supplier_reference`) AS supplier_reference,
        (p.`weight`+ pa.`weight`) weight_attribute,
        IF (IFNULL(pa.`ean13`, \'\') = \'\', p.`ean13`, pa.`ean13`) AS ean13, IF (IFNULL(pa.`upc`, \'\') = \'\', p.`upc`, pa.`upc`) AS upc,
		pai.`id_image` as pai_id_image
		FROM `'._DB_PREFIX_.'cart_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.`id_product_attribute` = cp.`id_product_attribute`)
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
			AND tr.`id_country` = '.(int)Country::getDefaultCountryId().'
			AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'customization` cu ON (p.`id_product` = cu.`id_product`)
		LEFT JOIN `'._DB_PREFIX_.'product_attribute_image` pai ON (pai.`id_product_attribute` = pa.`id_product_attribute`)
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (IF(pai.`id_image`,
			i.`id_image` =
			(SELECT i2.`id_image`
			FROM `'._DB_PREFIX_.'image` i2
			INNER JOIN `'._DB_PREFIX_.'product_attribute_image` pai2 ON (pai2.`id_image` = i2.`id_image`)
			WHERE i2.`id_product` = p.`id_product` AND pai2.`id_product_attribute` = pa.`id_product_attribute`
			ORDER BY i2.`position`
			LIMIT 1),
			i.`id_product` = p.`id_product` AND i.`cover` = 1)
		)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$this->id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)$this->id_lang.')
		WHERE cp.`id_cart` = '.(int)$this->id.'
		'.($id_product ? ' AND cp.`id_product` = '.(int)$id_product : '').'
		AND p.`id_product` IS NOT NULL
		GROUP BY unique_id
		ORDER BY cp.date_add ASC';
		$result = Db::getInstance()->ExecuteS($sql);
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
		foreach ($result AS $k => $row)
		{
			if (isset($row['ecotax_attr']) AND $row['ecotax_attr'] > 0)
				$row['ecotax'] = (float)($row['ecotax_attr']);
			$row['stock_quantity'] = (int)($row['quantity']);
			// for compatibility with 1.2 themes
			$row['quantity'] = (int)($row['cart_quantity']);
			if (isset($row['id_product_attribute']) AND (int)$row['id_product_attribute'])
			{
				$row['weight'] = $row['weight_attribute'];
				$row['stock_quantity'] = $row['quantity_attribute'];
			}
			if ($this->_taxCalculationMethod == PS_TAX_EXC)
			{
				$row['price'] = Product::getPriceStatic((int)$row['id_product'], false, isset($row['id_product_attribute']) ? (int)($row['id_product_attribute']) : NULL, 2, NULL, false, true, (int)($row['cart_quantity']), false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL), $specificPriceOutput); // Here taxes are computed only once the quantity has been applied to the product price
				$row['price_wt'] = Product::getPriceStatic((int)$row['id_product'], true, isset($row['id_product_attribute']) ? (int)($row['id_product_attribute']) : NULL, 2, NULL, false, true, (int)($row['cart_quantity']), false, ((int)($this->id_customer) ? (int)($this->id_customer) : NULL), (int)($this->id), ((int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) ? (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}) : NULL));
                $tax_rate = Tax::getProductTaxRate((int)$row['id_product'], (int)($this->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                
				$row['total_wt'] = Tools::ps_round($row['price'] * (float)$row['cart_quantity'] * (1 + (float)($tax_rate) / 100), 2);
				$row['total'] = $row['price'] * (int)($row['cart_quantity']);
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
			$row['reduction_applies'] = $specificPriceOutput AND (float)($specificPriceOutput['reduction']);
			$row['id_image'] = Product::defineProductImage($row,$this->id_lang);
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
		$attributesList = array();
		$attributesListSmall = array();
		foreach ($ipaList as $id_product_attribute)
			if ((int)$id_product_attribute AND !array_key_exists($id_product_attribute.'-'.$id_lang, self::$_attributesLists))
			{
				$paImplode[] = (int)$id_product_attribute;
				self::$_attributesLists[(int)$id_product_attribute.'-'.$id_lang] = array('attributes' => '', 'attributes_small' => '');
			}
		if (!count($paImplode))
			return;

		$result = Db::getInstance()->ExecuteS('
		SELECT pac.`id_product_attribute`, agl.`public_name` AS public_group_name, al.`name` AS attribute_name
		FROM `'._DB_PREFIX_.'product_attribute_combination` pac
		LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
		LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
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
		$product = new Product((int)$id_product, false, (int)Configuration::get('PS_LANG_DEFAULT'));

		/* If we have a product combination, the minimal quantity is set with the one of this combination */
		if (!empty($id_product_attribute))
			$minimalQuantity = (int)Attribute::getAttributeMinimalQty((int)$id_product_attribute);
		else
			$minimalQuantity = (int)$product->minimal_quantity;

		if (!Validate::isLoadedObject($product))
			die(Tools::displayError());
		self::$_nbProducts = NULL;
		if (array_key_exists($this->id, self::$_totalWeight))
			unset(self::$_totalWeight[$this->id]);
		if ((int)$quantity <= 0)
			return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
		elseif (!$product->available_for_order OR Configuration::get('PS_CATALOG_MODE'))
			return false;
		else
		{
			/* Check if the product is already in the cart */
			$result = $this->containsProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);

			/* Update quantity if product already exist */
			if (Db::getInstance()->NumRows())
			{
				if ($operator == 'up')
				{
					$result2 = Db::getInstance()->getRow('
						SELECT '.(!empty($id_product_attribute) ? 'pa' : 'p').'.`quantity`, p.`out_of_stock`
						FROM `'._DB_PREFIX_.'product` p
						'.(!empty($id_product_attribute) ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON p.`id_product` = pa.`id_product`' : '').'
						WHERE p.`id_product` = '.(int)($id_product).
						(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : ''));
					$productQty = (int)$result2['quantity'];
					$newQty = (int)$result['quantity'] + (int)$quantity;
					$qty = '+ '.(int)$quantity;

					if (!Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
						if ($newQty > $productQty)
							return false;
				}
				elseif ($operator == 'down')
				{
					$qty = '- '.(int)$quantity;
					$newQty = (int)$result['quantity'] - (int)$quantity;
					if ($newQty < $minimalQuantity AND $minimalQuantity > 1)
						return -1;
				}
				else
					return false;

				/* Delete product from cart */
				if ($newQty <= 0)
					return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
				elseif ($newQty < $minimalQuantity)
					return -1;
				else
					Db::getInstance()->Execute('
					UPDATE `'._DB_PREFIX_.'cart_product`
					SET `quantity` = `quantity` '.$qty.'
					WHERE `id_product` = '.(int)$id_product.
					(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : '').' AND (instructions = "'.$instructions.'" OR  instructions_valid = "'.$instructions.'" OR  instructions_valid = "'.($instructions?md5($instructions):"").'")'.'
					AND `id_cart` = '.(int)$this->id.'
					LIMIT 1');
			}

			/* Add produt to the cart */
			else
			{
				$result2 = Db::getInstance()->getRow('
				SELECT '.(!empty($id_product_attribute) ? 'pa' : 'p').'.`quantity`, p.`out_of_stock`
				FROM `'._DB_PREFIX_.'product` p
				'.(!empty($id_product_attribute) ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON p.`id_product` = pa.`id_product`' : '').'
				WHERE p.`id_product` = '.(int)$id_product.
				(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : ''));

				if (!Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
					if ((int)$quantity > $result2['quantity'])
						return false;

				if ((int)$quantity < $minimalQuantity)
					return -1;

				if (!Db::getInstance()->AutoExecute(_DB_PREFIX_.'cart_product', array('id_product' => (int)$id_product,
				'id_product_attribute' => (int)$id_product_attribute, 'id_cart' => (int)$this->id,'instructions' => $instructions, 'instructions_valid' => ($instructions?md5($instructions):""), 'instructions_id' => $instructions_id,
				'quantity' => (int)$quantity, 'date_add' => date('Y-m-d H:i:s')), 'INSERT'))
					return false;
			}
		}
		// refresh cache of self::_products
		$this->_products = $this->getProducts(true);
		$this->update(true);

		if ($product->customizable)
			return $this->_updateCustomizationQuantity((int)$quantity, (int)$id_customization, (int)$id_product, (int)$id_product_attribute, $operator);
		else
			return true;
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
		self::$_nbProducts = NULL;
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
		$products = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'cart_product` WHERE `id_cart` = '.(int)$this->id);
		foreach ($products AS $product)
			$success &= $cart->updateQty($product['quantity'], (int)$product['id_product'], $product['instructions_id']!= ''?$awp->getIdProductAttribute($product['id_product'],$product['instructions_id']):(int)$product['id_product_attribute'], NULL, 'up',$product['instructions'], $product['instructions_id']);

		// Customized products
		$customs = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT *
		FROM '._DB_PREFIX_.'customization c
		LEFT JOIN '._DB_PREFIX_.'customized_data cd ON cd.id_customization = c.id_customization
		WHERE c.id_cart = '.(int)$this->id);

		$custom_ids = array();
		$sql_custom_data = 'INSERT INTO '._DB_PREFIX_.'customized_data (id_customization, type, index, value) VALUES ';
		if (count($custom_ids))
		{
			foreach ($customs AS $custom)
			{
				Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute('
				INSERT INTO '._DB_PREFIX_.'customization (id_customization, id_cart, id_product_attribute, id_product, quantity)
				VALUES(\'\', '.(int)$cart->id.', '.(int)$custom['id_product_attribute'].', '.(int)$custom['id_product'].', '.(int)$custom['quantity'].')');
				$custom_ids[$custom['id_customization']] = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
				$sql_custom_data .= '('.(int)$custom_ids[$custom['id_customization']].', '.(int)$custom['type'].', '.(int)$custom['index'].', \''.pSQL($custom['value']).'\'),';
			}
			Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($sql_custom_data);
		}

		return array('cart' => $cart, 'success' => $success);
	}

}