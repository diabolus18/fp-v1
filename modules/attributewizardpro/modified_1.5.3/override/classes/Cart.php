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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Cart extends CartCore
{
	public $id;

	public $id_shop_group;

	public $id_shop;

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

	/** @var boolean True if the customer wants a recycled package */
	public		$recyclable = 1;

	/** @var boolean True if the customer wants a gift wrapping */
	public		$gift = 0;

	/** @var string Gift message if specified */
	public 		$gift_message;

	/** @var string Object creation date */
	public 		$date_add;

	/** @var string secure_key */
	public		$secure_key;

	/** @var integer Carrier ID */
	public $id_carrier = 0;

	/** @var html AWP */
	public 	$special_instructions;

	/** @var string Object last modification date */
	public $date_upd;

	public $checkedTos = false;
	public $pictures;
	public $textFields;

	public $delivery_option;

	/** @var boolean Allow to seperate order in multiple package in order to recieve as soon as possible the available products */
	public $allow_seperated_package = false;

	protected static $_nbProducts = array();
	protected static $_isVirtualCart = array();

	protected $_products = null;
	protected static $_totalWeight = array();
	protected $_taxCalculationMethod = PS_TAX_EXC;
	protected static $_carriers = null;
	protected static $_taxes_rate = null;
	protected static $_attributesLists = array();

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'cart',
		'primary' => 'id_cart',
		'fields' => array(
			'id_shop_group' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_shop' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_address_delivery' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_address_invoice' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_carrier' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_currency' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'id_customer' => 			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_guest' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_lang' => 				array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'recyclable' => 			array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'gift' => 					array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'gift_message' => 			array('type' => self::TYPE_STRING, 'validate' => 'isMessage'),
			'delivery_option' => 		array('type' => self::TYPE_STRING),
			'secure_key' => 			array('type' => self::TYPE_STRING, 'size' => 32),
			'allow_seperated_package' =>array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
			'date_add' => 				array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' => 				array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
		),
	);

	protected $webserviceParameters = array(
		'fields' => array(
		'id_address_delivery' => array('xlink_resource' => 'addresses'),
		'id_address_invoice' => array('xlink_resource' => 'addresses'),
		'id_currency' => array('xlink_resource' => 'currencies'),
		'id_customer' => array('xlink_resource' => 'customers'),
		'id_guest' => array('xlink_resource' => 'guests'),
		'id_lang' => array('xlink_resource' => 'languages'),
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
			SELECT `id_product`, `id_product_attribute`, id_shop, `instructions`
			FROM `'._DB_PREFIX_.'cart_product`
			WHERE `id_cart` = '.(int)$this->id.'
			ORDER BY `date_add` DESC';

		$result = Db::getInstance()->getRow($sql);
		if ($result && isset($result['id_product']) && $result['id_product'])
			foreach ($this->getProducts() as $product)
			if ($result['id_product'] == $product['id_product']
				&& (
					!$result['id_product_attribute']
					|| $result['id_product_attribute'] == $product['id_product_attribute']
				))
				return $product;

		return false;
	}

	/**
	 * Return cart products
	 *
	 * @result array Products
	 */
	public function getProducts($refresh = false, $id_product = false, $id_country = null)
	{
		if (!$this->id)
			return array();
		// Product cache must be strictly compared to NULL, or else an empty cart will add dozens of queries
		if ($this->_products !== null && !$refresh)
		{
			// Return product row with specified ID if it exists
			if (is_int($id_product))
			{
				foreach ($this->_products as $product)
					if ($product['id_product'] == $id_product)
						return array($product);
				return array();
			}
			return $this->_products;
		}

		// Build query
		$sql = new DbQuery();

		// Build SELECT
		$sql->select('cp.`id_product_attribute`, cp.`id_product`, cp.`quantity` AS cart_quantity, cp.`instructions` AS instructions, cp.`instructions_valid` AS instructions_valid, cp.`instructions_id` AS instructions_id, cp.id_shop, pl.`name`, p.`is_virtual`,
						pl.`description_short`, pl.`available_now`, pl.`available_later`, p.`id_product`, product_shop.`id_category_default`, p.`id_supplier`,
						p.`id_manufacturer`, product_shop.`on_sale`, product_shop.`ecotax`, product_shop.`additional_shipping_cost`, product_shop.`available_for_order`, product_shop.`price`, p.`weight`,
						stock.`quantity` quantity_available, p.`width`, p.`height`, p.`depth`, stock.`out_of_stock`, product_shop.`active`, p.`date_add`,
						p.`date_upd`, IFNULL(stock.quantity, 0) as quantity, pl.`link_rewrite`, cl.`link_rewrite` AS category,
						CONCAT(cp.`id_product`, cp.`id_product_attribute`, cp.`instructions_valid`, cp.`id_address_delivery`) AS unique_id, cp.id_address_delivery,
						product_shop.`wholesale_price`, product_shop.advanced_stock_management');

		// Build FROM
		$sql->from('cart_product', 'cp');

		// Build JOIN
		$sql->leftJoin('product', 'p', 'p.`id_product` = cp.`id_product`');
		$sql->innerJoin('product_shop', 'product_shop', '(product_shop.id_shop=cp.id_shop AND product_shop.id_product = p.id_product)');
		$sql->leftJoin('product_lang', 'pl', '
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$this->id_lang.Shop::addSqlRestrictionOnLang('pl', 'cp.id_shop')
		);
		

		$sql->leftJoin('category_lang', 'cl', '
			product_shop.`id_category_default` = cl.`id_category`
			AND cl.`id_lang` = '.(int)$this->id_lang.Shop::addSqlRestrictionOnLang('cl', 'cp.id_shop')
		);

		// @todo test if everything is ok, then refactorise call of this method
		$sql->join(Product::sqlStock('cp', 'cp'));

		// Build WHERE clauses
		$sql->where('cp.`id_cart` = '.(int)$this->id);
		if ($id_product)
			$sql->where('cp.`id_product` = '.(int)$id_product);
		$sql->where('p.`id_product` IS NOT NULL');

		// Build GROUP BY
		$sql->groupBy('unique_id');

		// Build ORDER BY
		$sql->orderBy('p.id_product, cp.id_product_attribute, cp.date_add ASC');

		if (Customization::isFeatureActive())
		{
			$sql->select('cu.`id_customization`, cu.`quantity` AS customization_quantity');
			$sql->leftJoin('customization', 'cu',
				'p.`id_product` = cu.`id_product` AND cp.`id_product_attribute` = cu.id_product_attribute AND cu.id_cart='.(int)$this->id);
		}
		else
			$sql->select('NULL AS customization_quantity, NULL AS id_customization');

		if (Combination::isFeatureActive())
		{
			$sql->select('
				product_attribute_shop.`price` AS price_attribute, product_attribute_shop.`ecotax` AS ecotax_attr,
				IF (IFNULL(pa.`reference`, \'\') = \'\', p.`reference`, pa.`reference`) AS reference,
				IF (IFNULL(pa.`supplier_reference`, \'\') = \'\', p.`supplier_reference`, pa.`supplier_reference`) AS supplier_reference,
				(p.`weight`+ pa.`weight`) weight_attribute,
				IF (IFNULL(pa.`ean13`, \'\') = \'\', p.`ean13`, pa.`ean13`) AS ean13,
				IF (IFNULL(pa.`upc`, \'\') = \'\', p.`upc`, pa.`upc`) AS upc,
				pai.`id_image` as pai_id_image, il.`legend` as pai_legend,
				IFNULL(product_attribute_shop.`minimal_quantity`, product_shop.`minimal_quantity`) as minimal_quantity
			');

			$sql->leftJoin('product_attribute', 'pa', 'pa.`id_product_attribute` = cp.`id_product_attribute`');
			$sql->leftJoin('product_attribute_shop', 'product_attribute_shop', '(product_attribute_shop.id_shop=cp.id_shop AND product_attribute_shop.id_product_attribute = pa.id_product_attribute)');
			$sql->leftJoin('product_attribute_image', 'pai', 'pai.`id_product_attribute` = pa.`id_product_attribute`');
			$sql->leftJoin('image_lang', 'il', 'il.id_image = pai.id_image AND il.id_lang = '.(int)$this->id_lang);
		}
		else
			$sql->select(
				'p.`reference` AS reference, p.`supplier_reference` AS supplier_reference, p.`ean13`,
				p.`upc` AS upc, product_shop.`minimal_quantity` AS minimal_quantity'
			);
		$result = Db::getInstance()->executeS($sql);

		// Reset the cache before the following return, or else an empty cart will add dozens of queries
		$products_ids = array();
		$pa_ids = array();
		if ($result)
			foreach ($result as $row)
			{
				$products_ids[] = $row['id_product'];
				$pa_ids[] = $row['id_product_attribute'];
			}
		// Thus you can avoid one query per product, because there will be only one query for all the products of the cart
		Product::cacheProductsFeatures($products_ids);
		Cart::cacheSomeAttributesLists($pa_ids, $this->id_lang);

		$this->_products = array();
		if (empty($result))
			return array();

		$cart_shop_context = Context::getContext()->cloneContext();
		foreach ($result as &$row)
		{
			if (isset($row['ecotax_attr']) && $row['ecotax_attr'] > 0)
				$row['ecotax'] = (float)$row['ecotax_attr'];

			$row['stock_quantity'] = (int)$row['quantity'];
			// for compatibility with 1.2 themes
			$row['quantity'] = (int)$row['cart_quantity'];

			if (isset($row['id_product_attribute']) && (int)$row['id_product_attribute'] && isset($row['weight_attribute']))
				$row['weight'] = (float)$row['weight_attribute'];

			if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_invoice')
				$address_id = (int)$this->id_address_invoice;
			else
				$address_id = (int)$row['id_address_delivery'];
			if (!Address::addressExists($address_id))
				$address_id = null;

			if ($cart_shop_context->shop->id != $row['id_shop'])
				$cart_shop_context->shop = new Shop((int)$row['id_shop']);

			if ($this->_taxCalculationMethod == PS_TAX_EXC)
			{
				$row['price'] = Product::getPriceStatic(
					(int)$row['id_product'],
					false,
					isset($row['id_product_attribute']) ? (int)$row['id_product_attribute'] : null,
					2,
					null,
					false,
					true,
					(int)$row['cart_quantity'],
					false,
					((int)$this->id_customer ? (int)$this->id_customer : null),
					(int)$this->id,
					((int)$address_id ? (int)$address_id : null),
					$specific_price_output,
					true,
					true,
					$cart_shop_context
				); // Here taxes are computed only once the quantity has been applied to the product price

				$row['price_wt'] = Product::getPriceStatic(
					(int)$row['id_product'],
					true,
					isset($row['id_product_attribute']) ? (int)$row['id_product_attribute'] : null,
					2,
					null,
					false,
					true,
					(int)$row['cart_quantity'],
					false,
					((int)$this->id_customer ? (int)$this->id_customer : null),
					(int)$this->id,
					((int)$address_id ? (int)$address_id : null),
					$null,
					true,
					true,
					$cart_shop_context
				);

				$tax_rate = Tax::getProductTaxRate((int)$row['id_product'], (int)$address_id);

				$row['total_wt'] = Tools::ps_round($row['price'] * (float)$row['cart_quantity'] * (1 + (float)$tax_rate / 100), 2);
				$row['total'] = $row['price'] * (int)$row['cart_quantity'];
			}
			else
			{
				$row['price'] = Product::getPriceStatic(
					(int)$row['id_product'],
					false,
					(int)$row['id_product_attribute'],
					2,
					null,
					false,
					true,
					$row['cart_quantity'],
					false,
					((int)$this->id_customer ? (int)$this->id_customer : null),
					(int)$this->id,
					((int)$address_id ? (int)$address_id : null),
					$specific_price_output,
					true,
					true,
					$cart_shop_context
				);

				$row['price_wt'] = Product::getPriceStatic(
					(int)$row['id_product'],
					true,
					(int)$row['id_product_attribute'],
					2,
					null,
					false,
					true,
					$row['cart_quantity'],
					false,
					((int)$this->id_customer ? (int)$this->id_customer : null),
					(int)$this->id,
					((int)$address_id ? (int)$address_id : null),
					$null,
					true,
					true,
					$cart_shop_context
				);
				
				// In case when you use QuantityDiscount, getPriceStatic() can be return more of 2 decimals
				$row['price_wt'] = Tools::ps_round($row['price_wt'], 2);
				$row['total_wt'] = $row['price_wt'] * (int)$row['cart_quantity'];
				$row['total'] = Tools::ps_round($row['price'] * (int)$row['cart_quantity'], 2);
			}

			if (!isset($row['pai_id_image']) || $row['pai_id_image'] == 0)
			{
				$row2 = Db::getInstance()->getRow('
					SELECT image_shop.`id_image` id_image, il.`legend`
					FROM `'._DB_PREFIX_.'image` i'.
					Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
					LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$this->id_lang.')
					WHERE i.`id_product` = '.(int)$row['id_product'].' AND image_shop.`cover` = 1'
				);

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

			$row['reduction_applies'] = ($specific_price_output && (float)$specific_price_output['reduction']);
			$row['quantity_discount_applies'] = ($specific_price_output && $row['cart_quantity'] >= (int)$specific_price_output['from_quantity']);
			$row['id_image'] = Product::defineProductImage($row, $this->id_lang);
			$row['allow_oosp'] = Product::isAvailableWhenOutOfStock($row['out_of_stock']);
			$row['features'] = Product::getFeaturesStatic((int)$row['id_product']);

			if (array_key_exists($row['id_product_attribute'].'-'.$this->id_lang, self::$_attributesLists))
				$row = array_merge($row, self::$_attributesLists[$row['id_product_attribute'].'-'.$this->id_lang]);

			$row = Product::getTaxesInformations($row, $cart_shop_context);

			$this->_products[] = $row;
		}

		return $this->_products;
	}

	public static function cacheSomeAttributesLists($ipa_list, $id_lang)
	{
		if (!Combination::isFeatureActive())
			return;

		$pa_implode = array();

		foreach ($ipa_list as $id_product_attribute)
			if ((int)$id_product_attribute && !array_key_exists($id_product_attribute.'-'.$id_lang, self::$_attributesLists))
			{
				$pa_implode[] = (int)$id_product_attribute;
				self::$_attributesLists[(int)$id_product_attribute.'-'.$id_lang] = array('attributes' => '', 'attributes_small' => '');
			}

		if (!count($pa_implode))
			return;

		$result = Db::getInstance()->executeS('
			SELECT pac.`id_product_attribute`, agl.`public_name` AS public_group_name, al.`name` AS attribute_name
			FROM `'._DB_PREFIX_.'product_attribute_combination` pac
			LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
			LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (
				a.`id_attribute` = al.`id_attribute`
				AND al.`id_lang` = '.(int)$id_lang.'
			)
			LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (
				ag.`id_attribute_group` = agl.`id_attribute_group`
				AND agl.`id_lang` = '.(int)$id_lang.'
			)
			WHERE pac.`id_product_attribute` IN ('.implode($pa_implode, ',').')
			ORDER BY agl.`public_name` ASC'
		);

		foreach ($result as $row)
		{
			self::$_attributesLists[$row['id_product_attribute'].'-'.$id_lang]['attributes'] .= $row['public_group_name'].' : '.$row['attribute_name'].', ';
			self::$_attributesLists[$row['id_product_attribute'].'-'.$id_lang]['attributes_small'] .= $row['attribute_name'].', ';
		}

		foreach ($pa_implode as $id_product_attribute)
		{
			self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes'] = rtrim(
				self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes'],
				', '
			);

			self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes_small'] = rtrim(
				self::$_attributesLists[$id_product_attribute.'-'.$id_lang]['attributes_small'],
				', '
			);
		}
	}

	public function containsProduct($id_product, $id_product_attribute = 0, $id_customization = false, $id_address_delivery = 0, $instructions = "")
	{
		$sql = 'SELECT cp.`quantity` FROM `'._DB_PREFIX_.'cart_product` cp';

		if ($id_customization)
			$sql .= '
				LEFT JOIN `'._DB_PREFIX_.'customization` c ON (
					c.`id_product` = cp.`id_product`
					AND c.`id_product_attribute` = cp.`id_product_attribute`
				)';

		$sql .= '
			WHERE cp.`id_product` = '.(int)$id_product.'
			AND cp.`id_product_attribute` = '.(int)$id_product_attribute.'
			AND (cp.instructions = "'.Db::getInstance()->_escape($instructions).'" OR cp.instructions_valid= "'.Db::getInstance()->_escape($instructions).'")
			AND cp.`id_cart` = '.(int)$this->id;
		if (Configuration::get('PS_ALLOW_MULTISHIPPING') && $this->isMultiAddressDelivery())
			$sql .= ' AND cp.`id_address_delivery` = '.(int)$id_address_delivery;

		if ($id_customization)
			$sql .= ' AND c.`id_customization` = '.(int)$id_customization;

		return Db::getInstance()->getRow($sql);
	}

	/**
	 * Update product quantity
	 *
	 * @param integer $quantity Quantity to add (or substract)
	 * @param integer $id_product Product ID
	 * @param integer $id_product_attribute Attribute ID if needed
	 * @param string $operator Indicate if quantity must be increased or decreased
	 */
	public function updateQty($quantity, $id_product, $id_product_attribute = null, $id_customization = false,
		$operator = 'up', $id_address_delivery = 0, Shop $shop = null, $auto_add_cart_rule = true, $instructions = "" , $instructions_id = "")
	{
		if (!$shop)
			$shop = Context::getContext()->shop;

		if (Context::getContext()->customer->id)
		{
			if ($id_address_delivery == 0 && (int)$this->id_address_delivery) // The $id_address_delivery is null, use the cart delivery address
				$id_address_delivery = $this->id_address_delivery;
			elseif ($id_address_delivery == 0) // The $id_address_delivery is null, get the default customer address
				$id_address_delivery = (int)Address::getFirstCustomerAddressId((int)Context::getContext()->customer->id);
			elseif (!Customer::customerHasAddress(Context::getContext()->customer->id, $id_address_delivery)) // The $id_address_delivery must be linked with customer
				$id_address_delivery = 0;
		}

		$quantity = (int)$quantity;
		$id_product = (int)$id_product;
		$id_product_attribute = (int)$id_product_attribute;
		$product = new Product($id_product, false, Configuration::get('PS_LANG_DEFAULT'), $shop->id);

		/* If we have a product combination, the minimal quantity is set with the one of this combination */
		if (!empty($id_product_attribute))
			$minimal_quantity = (int)Attribute::getAttributeMinimalQty($id_product_attribute);
		else
			$minimal_quantity = (int)$product->minimal_quantity;

		if (!Validate::isLoadedObject($product))
			die(Tools::displayError());

		if (isset(self::$_nbProducts[$this->id]))
			unset(self::$_nbProducts[$this->id]);

		if (isset(self::$_totalWeight[$this->id]))
			unset(self::$_totalWeight[$this->id]);

		if ((int)$quantity <= 0)
			return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
		elseif (!$product->available_for_order || Configuration::get('PS_CATALOG_MODE'))
			return false;
		else
		{
			/* Check if the product is already in the cart */
			$result = $this->containsProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization, (int)$id_address_delivery,$instructions);

			/* Update quantity if product already exist */
			if ($result)
			{
				if ($operator == 'up')
				{
					$sql = 'SELECT stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity
							FROM '._DB_PREFIX_.'product p
							'.Product::sqlStock('p', $id_product_attribute, true, $shop).'
							WHERE p.id_product = '.$id_product;

					$result2 = Db::getInstance()->getRow($sql);
					$product_qty = (int)$result2['quantity'];
					// Quantity for product pack
					if (Pack::isPack($id_product))
						$product_qty = Pack::getQuantity($id_product, $id_product_attribute);
					$new_qty = (int)$result['quantity'] + (int)$quantity;
					$qty = '+ '.(int)$quantity;

					if (!Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
						if ($new_qty > $product_qty)
							return false;
				}
				else if ($operator == 'down')
				{
					$qty = '- '.(int)$quantity;
					$new_qty = (int)$result['quantity'] - (int)$quantity;
					if ($new_qty < $minimal_quantity && $minimal_quantity > 1)
						return -1;
				}
				else
					return false;

				/* Delete product from cart */
				if ($new_qty <= 0)
					return $this->deleteProduct((int)$id_product, (int)$id_product_attribute, (int)$id_customization,$instructions);
				else if ($new_qty < $minimal_quantity)
					return -1;
				else
					Db::getInstance()->execute('
						UPDATE `'._DB_PREFIX_.'cart_product`
						SET `quantity` = `quantity` '.$qty.', `date_add` = NOW()
						WHERE `id_product` = '.(int)$id_product.
						(!empty($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : '').' AND (instructions = "'.Db::getInstance()->_escape($instructions).'" OR  instructions_valid = "'.Db::getInstance()->_escape($instructions).'" OR  instructions_valid = "'.($instructions?md5($instructions):"").'")'.'
						AND `id_cart` = '.(int)$this->id.(Configuration::get('PS_ALLOW_MULTISHIPPING') && $this->isMultiAddressDelivery() ? ' AND `id_address_delivery` = '.(int)$id_address_delivery : '').'
						LIMIT 1'
					);
			}
			/* Add product to the cart */
			elseif ($operator == 'up')
			{
				$sql = 'SELECT stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity
						FROM '._DB_PREFIX_.'product p
						'.Product::sqlStock('p', $id_product_attribute, true, $shop).'
						WHERE p.id_product = '.$id_product;

				$result2 = Db::getInstance()->getRow($sql);

				// Quantity for product pack
				if (Pack::isPack($id_product))
					$result2['quantity'] = Pack::getQuantity($id_product, $id_product_attribute);

				if (!Product::isAvailableWhenOutOfStock((int)$result2['out_of_stock']))
					if ((int)$quantity > $result2['quantity'])
						return false;

				if ((int)$quantity < $minimal_quantity)
					return -1;

				$result_add = Db::getInstance()->insert('cart_product', array(
					'id_product' => 			(int)$id_product,
					'id_product_attribute' => 	(int)$id_product_attribute,
					'instructions'		=>	Db::getInstance()->_escape($instructions),
					'instructions_valid'	=>	($instructions?md5($instructions):""),
					'instructions_id'	=>	$instructions_id,
					'id_cart' => 				(int)$this->id,
					'id_address_delivery' => 	(int)$id_address_delivery,
					'id_shop' => 				$shop->id,
					'quantity' => 				(int)$quantity,
					'date_add' => 				date('Y-m-d H:i:s')
				));

				if (!$result_add)
					return false;
			}
		}

		// refresh cache of self::_products
		$this->_products = $this->getProducts(true);
		$this->update(true);
		$context = Context::getContext()->cloneContext();
		$context->cart = $this;
		if ($auto_add_cart_rule)
			CartRule::autoAddToCart($context);

		if ($product->customizable)
			return $this->_updateCustomizationQuantity((int)$quantity, (int)$id_customization, (int)$id_product, (int)$id_product_attribute, (int)$id_address_delivery, $operator);
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
	public function deleteProduct($id_product, $id_product_attribute = null, $id_customization = null, $id_address_delivery = 0, $instructions = "")
	{
		if (isset(self::$_nbProducts[$this->id]))
			unset(self::$_nbProducts[$this->id]);

		if (isset(self::$_totalWeight[$this->id]))
			unset(self::$_totalWeight[$this->id]);

		if ((int)$id_customization)
		{
			$product_total_quantity = (int)Db::getInstance()->getValue(
				'SELECT `quantity`
				FROM `'._DB_PREFIX_.'cart_product`
				WHERE `id_product` = '.(int)$id_product.'
				AND `id_product_attribute` = '.(int)$id_product_attribute
			);

			$customization_quantity = (int)Db::getInstance()->getValue('
			SELECT `quantity`
			FROM `'._DB_PREFIX_.'customization`
			WHERE `id_cart` = '.(int)$this->id.'
			AND `id_product` = '.(int)$id_product.'
			AND `id_product_attribute` = '.(int)$id_product_attribute.'
			'.((int)$id_address_delivery ? 'AND `id_address_delivery` = '.(int)$id_address_delivery : ''));

			if (!$this->_deleteCustomization((int)$id_customization, (int)$id_product, (int)$id_product_attribute, $id_address_delivery))
				return false;

			// refresh cache of self::_products
			$this->_products = $this->getProducts(true);
			return ($this->deleteProduct((int)$id_product, $id_product_attribute, $id_address_delivery) && $customization_quantity == $product_total_quantity);
		}

		/* Get customization quantity */
		$result = Db::getInstance()->getRow('
			SELECT SUM(`quantity`) AS \'quantity\'
			FROM `'._DB_PREFIX_.'customization`
			WHERE `id_cart` = '.(int)$this->id.'
			AND `id_product` = '.(int)$id_product.'
			AND `id_product_attribute` = '.(int)$id_product_attribute
		);

		if ($result === false)
			return false;

		/* If the product still possesses customization it does not have to be deleted */
		if (Db::getInstance()->NumRows() && (int)$result['quantity'])
			return Db::getInstance()->execute('
				UPDATE `'._DB_PREFIX_.'cart_product`
				SET `quantity` = '.(int)$result['quantity'].'
				WHERE `id_cart` = '.(int)$this->id.'
				AND  (instructions = "'.$instructions.'" OR instructions_valid = "'.$instructions.'")
				AND `id_product` = '.(int)$id_product.
				($id_product_attribute != null ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : '')
			);

		/* Product deletion */
		$result = Db::getInstance()->execute('
		DELETE FROM `'._DB_PREFIX_.'cart_product`
		WHERE `id_product` = '.(int)$id_product.'
		'.(!is_null($id_product_attribute) ? ' AND `id_product_attribute` = '.(int)$id_product_attribute : '').'
		AND (`instructions` = \''.$instructions.'\' OR instructions_valid = "'.$instructions.'")
		AND `id_cart` = '.(int)$this->id.'
		'.((int)$id_address_delivery ? 'AND `id_address_delivery` = '.(int)$id_address_delivery : ''));

		if ($result)
		{
			$return = $this->update(true);
			// refresh cache of self::_products
			$this->_products = $this->getProducts(true);
			CartRule::autoRemoveFromCart();
			
			return $return;
		}

		return false;
	}
	
	public function duplicate()
	{
		if (!Validate::isLoadedObject($this))
			return false;

		$cart = new Cart($this->id);
		$cart->id = null;
		$cart->id_shop = $this->id_shop;
		$cart->id_shop_group = $this->id_shop_group;
		$cart->add();
		include_once(dirname(__FILE__).'/../../modules/attributewizardpro/attributewizardpro.php');
		$awp = new AttributeWizardPro();

		if (!Validate::isLoadedObject($cart))
			return false;

		$success = true;
		$products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'cart_product` WHERE `id_cart` = '.(int)$this->id);

		foreach ($products as $product)
			$success &= $cart->updateQty(
				$product['quantity'],
				(int)$product['id_product'],
				$product['instructions_id']!= ''?$awp->getIdProductAttribute($product['id_product'],$product['instructions_id']):(int)$product['id_product_attribute'],
				null,
				'up',
				(int)$product['id_address_delivery'],
				new Shop($cart->id_shop),
				true,
				$product['instructions'],
				$product['instructions_id']
			);

		// Customized products
		$customs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT *
			FROM '._DB_PREFIX_.'customization c
			LEFT JOIN '._DB_PREFIX_.'customized_data cd ON cd.id_customization = c.id_customization
			WHERE c.id_cart = '.(int)$this->id
		);

		// Get datas from customization table
		$customs_by_id = array();
		foreach ($customs as $custom)
		{
			if (!isset($customs_by_id[$custom['id_customization']]))
				$customs_by_id[$custom['id_customization']] = array(
					'id_product_attribute' => $custom['id_product_attribute'],
					'id_product' => $custom['id_product'],
					'quantity' => $custom['quantity']
				);
		}

		// Insert new customizations
		$custom_ids = array();
		foreach ($customs_by_id as $customization_id => $val)
		{
			Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'customization` (id_cart, id_product_attribute, id_product, `id_address_delivery`, quantity, `quantity_refunded`, `quantity_returned`, `in_cart`)
				VALUES('.(int)$cart->id.', '.(int)$val['id_product_attribute'].', '.(int)$val['id_product'].', '.(int)$this->id_address_delivery.', '.(int)$val['quantity'].', 0, 0, 1)'
			);
			$custom_ids[$customization_id] = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
		}

		// Insert customized_data
		if (count($customs))
		{
			$first = true;
			$sql_custom_data = 'INSERT INTO '._DB_PREFIX_.'customized_data (`id_customization`, `type`, `index`, `value`) VALUES ';
			foreach ($customs as $custom)
			{
				if (!$first)
					$sql_custom_data .= ',';
				else
					$first = false;

				$sql_custom_data .= '('.(int)$custom_ids[$custom['id_customization']].', '.(int)$custom['type'].', '.
					(int)$custom['index'].', \''.pSQL($custom['value']).'\')';
			}
			Db::getInstance()->execute($sql_custom_data);
		}

		return array('cart' => $cart, 'success' => $success);
	}

	public function duplicateProduct($id_product, $id_product_attribute, $id_address_delivery,
		$new_id_address_delivery, $quantity = 1, $keep_quantity = false, $instructions_valid = '')
	{
		// Check address is linked with the customer
		if (!Customer::customerHasAddress(Context::getContext()->customer->id, $new_id_address_delivery))
			return false;
		// Checking the product do not exist with the new address
		$sql = new DbQuery();
		$sql->select('count(*)');
		$sql->from('cart_product', 'c');
		$sql->where('id_product = '.(int)$id_product);
		$sql->where('id_product_attribute = '.(int)$id_product_attribute);
		$sql->where('id_address_delivery = '.(int)$new_id_address_delivery);
		if ($instructions_valid != '')
			$sql->where('instructions_valid = "'.$instructions_valid.'"');
		$sql->where('id_cart = '.(int)$this->id);
		$result = Db::getInstance()->getValue($sql);
		if ($result > 0)
			return false;
		// Get AWP data
		$instructions = '';
		$id_instructions = '';
		if ($instructions_valid != '')
		{
			$sql = new DbQuery();
			$sql->select('*');
			$sql->from('cart_product', 'c');
			$sql->where('instructions_valid = "'.$instructions_valid.'"');
			$sql->where('id_cart = '.(int)$this->id);
			$result = Db::getInstance()->getRow($sql);
			$instructions = $result['instructions'];
			$id_instructions = $result['instructions_id'];
		}
		
		// Duplicating cart_product line
		$sql = 'INSERT INTO '._DB_PREFIX_.'cart_product
			(`id_cart`, `id_product`, `id_shop`, `id_product_attribute`, `quantity`, `date_add`, `id_address_delivery`
			, `instructions`, `instructions_valid`, `instructions_id`)
			values(
				'.(int)$this->id.',
				'.(int)$id_product.',
				'.(int)$this->id_shop.',
				'.(int)$id_product_attribute.',
				'.(int)$quantity.',
				NOW(),
				'.(int)$new_id_address_delivery.',
				"'.$instructions.'",
				"'.($instructions_valid!=''?$instructions_valid:'').'",
				"'.$id_instructions.'")';

		Db::getInstance()->execute($sql);
			
		if (!$keep_quantity)
		{
			$sql = new DbQuery();
			$sql->select('quantity');
			$sql->from('cart_product', 'c');
			$sql->where('id_product = '.(int)$id_product);
			$sql->where('id_product_attribute = '.(int)$id_product_attribute);
			$sql->where('id_address_delivery = '.(int)$id_address_delivery);
			if ($instructions_valid != '')
				$sql->where('instructions_valid = "'.$instructions_valid.'"');
			$sql->where('id_cart = '.(int)$this->id);
			$duplicatedQuantity = Db::getInstance()->getValue($sql);

			if ($duplicatedQuantity > $quantity)
			{
				$sql = 'UPDATE '._DB_PREFIX_.'cart_product
					SET `quantity` = `quantity` - '.(int)$quantity.'
					WHERE id_cart = '.(int)$this->id.'
					AND id_product = '.(int)$id_product.'
					AND id_shop = '.(int)$this->id_shop.'
					AND id_product_attribute = '.(int)$id_product_attribute.'
					AND instructions_valid = "'.$instructions_valid.'"
					AND id_address_delivery = '.(int)$id_address_delivery;
				Db::getInstance()->execute($sql);
			}
		}

		// Checking if there is customizations
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from('customization', 'c');
		$sql->where('id_product = '.(int)$id_product);
		$sql->where('id_product_attribute = '.(int)$id_product_attribute);
		$sql->where('id_address_delivery = '.(int)$id_address_delivery);
		$sql->where('id_cart = '.(int)$this->id);
		$results = Db::getInstance()->executeS($sql);

		foreach ($results as $customization)
		{

			// Duplicate customization
			$sql = 'INSERT INTO '._DB_PREFIX_.'customization
				(`id_product_attribute`, `id_address_delivery`, `id_cart`, `id_product`, `quantity`, `in_cart`)
				VALUES (
					'.$customization['id_product_attribute'].',
					'.$new_id_address_delivery.',
					'.$customization['id_cart'].',
					'.$customization['id_product'].',
					'.$quantity.',
					'.$customization['in_cart'].')';
			Db::getInstance()->execute($sql);

			$sql = 'INSERT INTO '._DB_PREFIX_.'customized_data(`id_customization`, `type`, `index`, `value`)
				(
					SELECT '.(int)Db::getInstance()->Insert_ID().' `id_customization`, `type`, `index`, `value`
					FROM customized_data
					WHERE id_customization = '.$customization['id_customization'].'
				)';
			Db::getInstance()->execute($sql);
		}

		$customization_count = count($results);
		if ($customization_count > 0)
		{
			$sql = 'UPDATE '._DB_PREFIX_.'cart_product
				SET `quantity` = `quantity` = '.(int)$customization_count * $quantity.'
				WHERE id_cart = '.(int)$this->id.'
				AND id_product = '.(int)$id_product.'
				AND id_shop = '.(int)$this->id_shop.'
				AND id_product_attribute = '.(int)$id_product_attribute.'
				AND id_address_delivery = '.(int)$new_id_address_delivery;
			Db::getInstance()->execute($sql);
		}

		return true;
	}

	/**
	 * Update products cart address delivery with the address delivery of the cart
	 * ADDED , instructions_valid
	 */
	public function setNoMultishipping()
	{
		// Upgrading quantities
		$sql = 'SELECT sum(`quantity`) as quantity, id_product, id_product_attribute, count(*) as count
				FROM `'._DB_PREFIX_.'cart_product`
				WHERE `id_cart` = '.(int)$this->id.'
					AND `id_shop` = '.(int)$this->id_shop.'
				GROUP BY id_product, id_product_attribute, instructions_valid
				HAVING count > 1';

		foreach (Db::getInstance()->executeS($sql) as $product)
		{
			$sql = 'UPDATE `'._DB_PREFIX_.'cart_product`
				SET `quantity` = '.$product['quantity'].'
				WHERE  `id_cart` = '.(int)$this->id.'
					AND `id_shop` = '.(int)$this->id_shop.'
					AND id_product = '.$product['id_product'].'
					AND id_product_attribute = '.$product['id_product_attribute'];
				Db::getInstance()->execute($sql);
		}

		// Merging multiple lines
		$sql = 'DELETE cp1
			FROM `'._DB_PREFIX_.'cart_product` cp1
				INNER JOIN `'._DB_PREFIX_.'cart_product` cp2
				ON (
					(cp1.id_cart = cp2.id_cart)
					AND (cp1.id_product = cp2.id_product)
					AND (cp1.id_product_attribute = cp2.id_product_attribute)
					AND (cp1.id_address_delivery <> cp2.id_address_delivery)
					AND (cp1.date_add > cp2.date_add)
				)';
				Db::getInstance()->execute($sql);

		// Upgrading address delivery
		$sql = 'UPDATE `'._DB_PREFIX_.'cart_product`
			SET `id_address_delivery` =
			(
				SELECT `id_address_delivery`
				FROM `'._DB_PREFIX_.'cart`
				WHERE `id_cart` = '.(int)$this->id.'
					AND `id_shop` = '.(int)$this->id_shop.'
			)
			WHERE `id_cart` = '.(int)$this->id.'
			'.(Configuration::get('PS_ALLOW_MULTISHIPPING') ? ' AND `id_shop` = '.(int)$this->id_shop : '');

		Db::getInstance()->execute($sql);

		$sql = 'UPDATE `'._DB_PREFIX_.'customization`
			SET `id_address_delivery` =
			(
				SELECT `id_address_delivery`
				FROM `'._DB_PREFIX_.'cart`
				WHERE `id_cart` = '.(int)$this->id.'
			)
			WHERE `id_cart` = '.(int)$this->id;

		Db::getInstance()->execute($sql);
	}

}