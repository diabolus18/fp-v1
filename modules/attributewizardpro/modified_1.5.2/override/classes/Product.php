<?php

class Product extends ProductCore
{
	/**
	* Get all available product attributes combinations
	*
	* MODIFIED:	GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
	*
	* @param integer $id_lang Language id
	* @return array Product attributes combinations
	*/
	public function getAttributeCombinations($id_lang)
	{
		if (!Combination::isFeatureActive())
			return array();

		$sql = 'SELECT pa.*, product_attribute_shop.*, ag.`id_attribute_group`, ag.`is_color_group`, agl.`name` AS group_name, al.`name` AS attribute_name,
					a.`id_attribute`, pa.`unit_price_impact`
				FROM `'._DB_PREFIX_.'product_attribute` pa
				'.Shop::addSqlAssociation('product_attribute', 'pa').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)$id_lang.')
				WHERE pa.`id_product` = '.(int)$this->id.'
				GROUP BY pa.`id_product_attribute`, a.`id_attribute`
				ORDER BY pa.`id_product_attribute`';

		$res = Db::getInstance()->executeS($sql);
		//Get quantity of each variations
		foreach ($res as $key => $row)
		{
			$cache_key = $row['id_product'].'_'.$row['id_product_attribute'].'_quantity';

			if (!Cache::isStored($cache_key))
				Cache::store(
					$cache_key,
					StockAvailable::getQuantityAvailableByProduct($row['id_product'], $row['id_product_attribute'])
				);

			$res[$key]['quantity'] = Cache::retrieve($cache_key);
		}

		return $res;
	}
	

	/**
	* Get product attribute combination by id_product_attribute
	*
	* MODIFIED:	GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
	*
	* @param integer $id_product_attribute
	* @param integer $id_lang Language id
	* @return array Product attribute combination by id_product_attribute
	*/
	public function getAttributeCombinationsById($id_product_attribute, $id_lang)
	{
		if (!Combination::isFeatureActive())
			return array();
		$sql = 'SELECT pa.*, product_attribute_shop.*, ag.`id_attribute_group`, ag.`is_color_group`, agl.`name` AS group_name, al.`name` AS attribute_name,
					a.`id_attribute`, pa.`unit_price_impact`
				FROM `'._DB_PREFIX_.'product_attribute` pa
				'.Shop::addSqlAssociation('product_attribute', 'pa').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)$id_lang.')
				WHERE pa.`id_product` = '.(int)$this->id.'
				AND pa.`id_product_attribute` = '.(int)$id_product_attribute.'
				GROUP BY pa.`id_product_attribute`, a.`id_attribute`
				ORDER BY pa.`id_product_attribute`';

		$res = Db::getInstance()->executeS($sql);

		//Get quantity of each variations
		foreach ($res as $key => $row)
		{
			$cache_key = $row['id_product'].'_'.$row['id_product_attribute'].'_quantity';

			if (!Cache::isStored($cache_key))
				Cache::store(
					$cache_key,
					StockAvailable::getQuantityAvailableByProduct($row['id_product'], $row['id_product_attribute'])
				);

			$res[$key]['quantity'] = Cache::retrieve($cache_key);
		}

		return $res;
	}	
}

