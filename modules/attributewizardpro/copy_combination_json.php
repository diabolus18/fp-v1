<?php
//call module
include(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/JSON.php');

include(dirname(__FILE__).'/attributewizardpro.php');

$awp = new AttributeWizardPro();
// Prevent unauthorized access.
if ($awp->_awp_random != Tools::getValue('awp_random'))
{
	print "No Permissions";
	exit;
}

$return = array();

function array2object($array) {
 
    if (is_array($array)) {
        $obj = new StdClass();
 
        foreach ($array as $key => $val){
            $obj->$key = $val;
        }
    }
    else { $obj = $array; }
 
    return $obj;
}

function copyProductAttributes($id_src, $id_tgt)
{
    $ps_version  = floatval(substr(_PS_VERSION_,0,3));
	
	if ($ps_version >= 1.5){	
		
		$awp_shops = $_POST['awp_shops'];
			
		$shopsAvailable = explode(",", $awp_shops);
		foreach ($shopsAvailable as $shops)
			$shopsAvailables[] = $shops['id_shop'];
			
			
		
		Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'stock_available 
									WHERE id_product = '.(int)($id_tgt).' and 
									id_product_attribute NOT IN (SELECT id_product_attribute FROM '._DB_PREFIX_.'product_attribute WHERE id_product = '.(int)($id_tgt).' ) ');
		foreach ($shopsAvailables as $shop){
			$pa = Db::getInstance()->ExecuteS('
			SELECT * FROM `'._DB_PREFIX_.'product_attribute` pa
			
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` pas ON pas.id_product_attribute = pa.id_product_attribute
			WHERE pas.`id_shop` = '.intval($shop).' and pa.`id_product` = '.intval($id_src));
			
						
				$advStock = Db::getInstance()->ExecuteS('SELECT advanced_stock_management FROM `'._DB_PREFIX_.'product_shop` 
																WHERE id_product = '.(int)($id_src).' and id_shop = '.(int)($shop));
				
				Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'product_shop`  
								SET advanced_stock_management = '.$advStock[0]['advanced_stock_management'].'
								WHERE id_product = '.(int)($id_tgt).' and id_shop = '.(int)($shop));
			
		
		
	
		
			$defaultStockAvailable = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'stock_available` 
																	WHERE id_product = '.(int)($id_src).' and id_shop = '.(int)($shop).' and id_product_attribute = 0');	
														
			
			if (count($defaultStockAvailable) > 0){
			
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'stock_available` (`id_product`, `id_product_attribute`, `id_shop`,
									`id_shop_group`, `quantity`,
									`depends_on_stock`, `out_of_stock`) 
									VALUES ('.(int)$id_tgt.', 0 ,'.(int)$shop.',
									'.$defaultStockAvailable[0]['id_shop_group'].', '.$defaultStockAvailable[0]['quantity'].',
									'.$defaultStockAvailable[0]['depends_on_stock'].','.$defaultStockAvailable[0]['out_of_stock'].')');
			}
							
			
				foreach ($pa AS $srow)
				{				
					
						//$productSrc = new Product((int)($id_src));
						//$productTgt = new Product((int)($id_tgt));
						
						
						$query = 'INSERT INTO `'._DB_PREFIX_.'product_attribute`
						('.($ps_version == 1.1?'id_image,':'').'id_product,reference,supplier_reference,location,ean13,wholesale_price,price,ecotax,quantity,weight,default_on'.($ps_version == 1.4?',upc,unit_price_impact,minimal_quantity':'').' '.($ps_version >= 1.5?',upc,unit_price_impact,minimal_quantity, available_date':'').')
						VALUES 
						('.($ps_version == 1.1?($srow['id_image'] != ""?'"'.$srow['id_image'].'",':'null,'):'').'"'.$id_tgt.'","'.$srow['reference'].'","'.$srow['supplier_reference'].'","'.$srow['location'].'",
						"'.$srow['ean13'].'","'.$srow['wholesale_price'].'","'.$srow['price'].'","'.$srow['ecotax'].'","'.$srow['quantity'].'","'.$srow['weight'].'","'.$srow['default_on'].'"'.($ps_version == 1.4?',"'.$srow['upc'].'","'.$srow['unit_price_impact'].'","'.$srow['minimal_quantity'].'"':'').' '.($ps_version >= 1.5?',"'.$srow['upc'].'","'.$srow['unit_price_impact'].'","'.$srow['minimal_quantity'].'",  "'.$srow['available_date'].'"':'').')';
						
						Db::getInstance()->Execute($query);
						
						$id_pa = Db::getInstance()->Insert_ID();
						
						$pac = Db::getInstance()->ExecuteS('
							SELECT * FROM `'._DB_PREFIX_.'product_attribute_combination`
							WHERE `id_product_attribute` = '.(int)$srow['id_product_attribute']);
							
						foreach ($pac AS $pacrow)
							Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'product_attribute_combination` (`id_product_attribute`, `id_attribute`) VALUES ('.(int)$id_pa.','.(int)$pacrow['id_attribute'].')');

							
						//foreach ($shopsAvailable as $shop){
							
							$exists = Db::getInstance()->ExecuteS('SELECT * FROM  `'._DB_PREFIX_.'product_attribute_shop` WHERE `id_product_attribute` = '.(int)$id_pa.' and  `id_shop` = '.(int)$shop.'');
							if (count($exists) > 0){
								Db::getInstance()->Execute('DELETE FROM  `'._DB_PREFIX_.'product_attribute_shop` WHERE `id_product_attribute` = '.(int)$id_pa.' and  `id_shop` = '.(int)$shop);
							}	
							//$pac = Db::getInstance()->ExecuteS('show columns from `'._DB_PREFIX_.'product_attribute_shop` ');
							//print_r($pac);
							Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'product_attribute_shop` (`id_product_attribute`, `id_shop`,
							`wholesale_price`, `price`,
							`ecotax`, `weight`,
							`unit_price_impact`, `default_on`,
							`minimal_quantity`, `available_date`)
							VALUES ('.(int)$id_pa.','.(int)$shop.',
							"'.$srow['wholesale_price'].'", "'.$srow['price'].'",
							"'.$srow['ecotax'].'","'.$srow['weight'].'",
							"'.$srow['unit_price_impact'].'","'.$srow['default_on'].'",
							"'.$srow['minimal_quantity'].'",  "'.$srow['available_date'].'"	)');
							
						$stockAvailable = Db::getInstance()->ExecuteS('SELECT * FROM  `'._DB_PREFIX_.'stock_available` 
												WHERE   `id_product` = '.$id_src.' and  `id_product_attribute` = '.(int)$srow['id_product_attribute'].' and  `id_shop` = '.(int)$shop.'');
												
						//if (count($stockAvailable) > 0){
								Db::getInstance()->Execute('DELETE FROM  `'._DB_PREFIX_.'stock_available` WHERE  `id_product` = '.$id_tgt.' and `id_product_attribute` = '.(int)($id_pa).' and `id_shop` = '.(int)$shop);
						//}

						//print_r($stockAvailable);
						foreach ($stockAvailable as $stock){

							Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'stock_available` (`id_product`, `id_product_attribute`, `id_shop`,
							`id_shop_group`, `quantity`,
							`depends_on_stock`, `out_of_stock`)
							VALUES ('.(int)$id_tgt.', '.(int)$id_pa.','.(int)$shop.',
							"'.$stock['id_shop_group'].'", "'.$stock['quantity'].'",
							"'.$stock['depends_on_stock'].'","'.$stock['out_of_stock'].'")');
							
							
							
						}
							
						$stockAB = Db::getInstance()->ExecuteS('SELECT * FROM  `'._DB_PREFIX_.'stock` 
												WHERE   `id_product` = '.$id_src.' and  `id_product_attribute` = '.(int)$srow['id_product_attribute'].' ');
												
					//	if (count($stock) > 0){
								Db::getInstance()->Execute('DELETE FROM  `'._DB_PREFIX_.'stock` WHERE  `id_product` = '.$id_tgt.' and `id_product_attribute` = '.(int)($id_pa));
					//	}

						foreach ($stockAB as $stockRow){
							Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'stock` (`id_warehouse`, `id_product`, `id_product_attribute`, `reference`,
							`ean13`, `upc`,
							`physical_quantity`, `usable_quantity` , `price_te`)
							VALUES ("'.$stockRow['id_warehouse'].'", '.(int)$id_tgt.', '.(int)$id_pa.',"'.$stockRow['reference'].'",
							"'.$stockRow['ean13'].'", "'.$stockRow['upc'].'",
							"'.$stockRow['physical_quantity'].'","'.$stockRow['usable_quantity'].'","'.$stockRow['price_te'].'")');
							
						}
						
						$warehouse = Db::getInstance()->ExecuteS('SELECT * FROM  `'._DB_PREFIX_.'warehouse_product_location` 
												WHERE   `id_product` = '.$id_src.' and  `id_product_attribute` = '.(int)$srow['id_product_attribute'].' ');
												
						//if (count($warehouse) > 0){
								Db::getInstance()->Execute('DELETE FROM  `'._DB_PREFIX_.'warehouse_product_location` WHERE  `id_product` = '.$id_tgt.' and `id_product_attribute` = '.(int)($id_pa));
					//	}

						foreach ($warehouse as $warehouseRow){

							Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'warehouse_product_location` (`id_product`, 
							`id_product_attribute`, `id_warehouse`,
							`location`)
							VALUES ( '.(int)$id_tgt.', '.(int)$id_pa.',"'.$warehouseRow['id_warehouse'].'",
							"'.$warehouseRow['location'].'")');
						}
						
					
				}
		
		}
	
	
		$advStock = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'product_shop` 
															WHERE id_product = '.(int)($id_tgt));
														//	print_r($advStock);
	}else{
	
		$pa = Db::getInstance()->ExecuteS('
		SELECT * FROM `'._DB_PREFIX_.'product_attribute` pa
		WHERE pa.`id_product` = '.intval($id_src));
		
		foreach ($pa AS $srow)
		{
		
			$query = 'INSERT INTO `'._DB_PREFIX_.'product_attribute`
					('.($ps_version == 1.1?'id_image,':'').'id_product,reference,supplier_reference,location,ean13,wholesale_price,price,ecotax,quantity,weight,default_on'.($ps_version >= 1.4?',upc,unit_price_impact,minimal_quantity':'').($ps_version >= 1.5?',available_date':'').')
					VALUES
					('.($ps_version == 1.1?($srow['id_image'] != ""?'"'.$srow['id_image'].'",':'null,'):'').'"'.$id_tgt.'","'.$srow['reference'].'","'.$srow['supplier_reference'].'","'.$srow['location'].'",
					"'.$srow['ean13'].'","'.$srow['wholesale_price'].'","'.$srow['price'].'","'.$srow['ecotax'].'","'.$srow['quantity'].'","'.$srow['weight'].'","'.$srow['default_on'].'"'.($ps_version >= 1.4?',"'.$srow['upc'].'","'.$srow['unit_price_impact'].'","'.$srow['minimal_quantity'].'"':'').($ps_version == 1.5?',"'.$srow['wholesale_price'].'"':'').')';
			Db::getInstance()->Execute($query);
			$id_pa = Db::getInstance()->Insert_ID();
			$pac = Db::getInstance()->ExecuteS('
				SELECT * FROM `'._DB_PREFIX_.'product_attribute_combination`
				WHERE `id_product_attribute` = '.intval($srow['id_product_attribute']));
			foreach ($pac AS $pacrow)
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'product_attribute_combination` (`id_product_attribute`, `id_attribute`) VALUES ('.intval($id_pa).','.intval($pacrow['id_attribute']).')');

		}
	}
	
	if ($ps_version >= 1.5){
		Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'attribute_impact`
									(id_product,id_attribute,weight,price) 
										SELECT "'.intval($id_tgt).'" as id_product,id_attribute,weight,price
										FROM `'._DB_PREFIX_.'attribute_impact` as ai 
										WHERE ai.id_product = '.intval($id_src));

	}else
		Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'attribute_impact` (id_product,id_attribute,weight,price) SELECT "'.intval($id_tgt).'" as id_product,id_attribute,weight,price FROM `'._DB_PREFIX_.'attribute_impact` as ai WHERE ai.id_product = '.intval($id_src));
}

if ($_POST['action'] == "validate")
{
	$invalid_src = 0;
	$invalid_tgt = 0;
	$p = 0;
	$src = new Product(intval($_POST['id_product_src']));
	if ($_POST['type'] == "p")
		$tgt = new Product(intval($_POST['id_product_tgt']));
	else if ($_POST['type'] == "m")
		$tgt = new Manufacturer(intval($_POST['id_product_tgt']));
	else if ($_POST['type'] == "s")
		$tgt = new Supplier(intval($_POST['id_product_tgt']));
	else
	{
		$tgt = new Category(intval($_POST['id_product_tgt']));
		if ($tgt->name)
		{
			$query = 'SELECT CONCAT(COUNT(id_product_attribute), SUM(price), SUM(weight), SUM(quantity)) AS concat FROM `'._DB_PREFIX_.'product_attribute` WHERE id_product  = '.intval($_POST['id_product_src']);
			$src_hash = Db::getInstance()->getRow($query);
			$query = 'SELECT id_product FROM `'._DB_PREFIX_.'category_product` WHERE id_category = '.$_POST['id_product_tgt'];
			$products = Db::getInstance()->executeS($query);
			foreach ($products as $product)
			{
				if (intval($_POST['id_product_src']) == $product['id_product'])
					continue;
				$query = 'SELECT CONCAT(COUNT(id_product_attribute), SUM(price), SUM(weight), SUM(quantity)) AS concat FROM `'._DB_PREFIX_.'product_attribute` WHERE id_product  = '.intval($product['id_product']);
				$tgt_hash = Db::getInstance()->getRow($query);
				// If attributes are the same, no need to delete and copy again.
				if ($src_hash['concat'] != $tgt_hash['concat'])
					$p++;
			}
		}
	}
	if (!$src->name)
		$invalid_src = 1;
	if (!$tgt->name)
		$invalid_tgt = 1;
	if ($invalid_src == 1 || $invalid_tgt == 1)
		$return = array("invalid_src"=>$invalid_src, "invalid_tgt"=>$invalid_tgt);
	else
		$return = array("product_src"=>$src->name, "product_tgt"=>$tgt->name, "copy_products" => $p);
}

if ($_POST['action'] == "copy")
{
	$ps_version  = floatval(substr(_PS_VERSION_,0,3));
	if ($ps_version >= 1.5){
		$awp_shops = $_POST['awp_shops'];
	}
	$query = 'SELECT CONCAT(COUNT(pa.id_product_attribute), SUM(pa.price), SUM(pa.weight),  '.($ps_version >= 1.5? 'SUM(stock.quantity)':'SUM(pa.quantity)').') AS concat 
				FROM `'._DB_PREFIX_.'product_attribute` pa
				'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'product_attribute_shop product_attribute_shop
					ON product_attribute_shop.id_product_attribute = pa.id_product_attribute
					AND product_attribute_shop.id_shop IN('.$awp_shops.')':'').'	
				'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'stock_available stock
					ON stock.id_product_attribute = pa.id_product_attribute
					AND  stock.id_product ='.intval($_POST['id_product_src']).' ':'').'
				WHERE pa.id_product  = '.intval($_POST['id_product_src'] );
	
	$src_hash = Db::getInstance()->getRow($query);
	
	if ($_POST['type'] == "p")
	{
		$query = 'SELECT CONCAT(COUNT(pa.id_product_attribute), SUM(pa.price), SUM(pa.weight),  '.($ps_version >= 1.5? 'SUM(stock.quantity)':'SUM(pa.quantity)').') AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` pa
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'product_attribute_shop product_attribute_shop
						ON product_attribute_shop.id_product_attribute = pa.id_product_attribute
						AND product_attribute_shop.id_shop IN('.$awp_shops.')':'').'	
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'stock_available stock
						ON stock.id_product_attribute = pa.id_product_attribute
						AND  stock.id_product ='.intval($_POST['id_product_tgt']).' ':'').'
					WHERE pa.id_product  = '.intval($_POST['id_product_tgt']);
		
		$tgt_hash = Db::getInstance()->getRow($query);
		
		// If attributes are the same, no need to delete and copy again.  
		if ($src_hash['concat'] != $tgt_hash['concat'])
		{
			$product_tgt = new Product(intval($_POST['id_product_tgt']));
			
			 if ($ps_version >= 1.5){
				
			
				$shopsAvailable = explode(",", $awp_shops);
				
				  
				foreach ($shopsAvailable as $shops){ 
					
						$product_tgt = new Product(intval($_POST['id_product_tgt']), false, Context::getContext()->language->id, $shops);
					
						$result = true;
						$combinations = new Collection('Combination');
					
						$combinations->where('id_product', '=', intval($_POST['id_product_tgt']));
					
						foreach ($combinations as $combination){
							
							$comb = new Combination($combination->id, NULL, $shops);
							//echo ($comb->multishop_specific);
							$comb->id_shop_list = array($shops);
							$comb->delete();	
						}
						SpecificPriceRule::applyAllRules(array(intval($_POST['id_product_tgt'])));
				}
			 }else{
				$product_tgt->deleteProductAttributes();
			}
			copyProductAttributes(intval($_POST['id_product_src']),intval($_POST['id_product_tgt']));
		}
	}
	else if ($_POST['type'] == "c")
	{
		$query = 'SELECT id_product FROM `'._DB_PREFIX_.'category_product` WHERE id_category = '.$_POST['id_product_tgt'];
		$products = Db::getInstance()->executeS($query);
		foreach ($products as $product)
		{
			if (intval($_POST['id_product_src']) == $product['id_product'])
				continue;
			$query = 'SELECT CONCAT(COUNT(pa.id_product_attribute), SUM(pa.price), SUM(pa.weight),  '.($ps_version >= 1.5? 'SUM(stock.quantity)':'SUM(pa.quantity)').') AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` pa
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'product_attribute_shop product_attribute_shop
						ON product_attribute_shop.id_product_attribute = pa.id_product_attribute
						AND product_attribute_shop.id_shop IN('.$awp_shops.')':'').'	
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'stock_available stock
						ON stock.id_product_attribute = pa.id_product_attribute
						AND  stock.id_product ='.intval($product['id_product']).' ':'').'
					WHERE pa.id_product  = '.intval($product['id_product']);
			/*$query = 'SELECT CONCAT(COUNT(id_product_attribute), SUM(price), SUM(weight), SUM(quantity)) AS concat
						FROM `'._DB_PREFIX_.'product_attribute` 
						WHERE id_product  = '.intval($product['id_product']);*/
			$tgt_hash = Db::getInstance()->getRow($query);
			// If attributes are the same, no need to delete and copy again.
			if ($src_hash['concat'] != $tgt_hash['concat'])
			{
				$product_tgt = new Product($product['id_product']);
				
				 if ($ps_version >= 1.5){
				
			
					$shopsAvailable = explode(",", $awp_shops);
					
					  
					foreach ($shopsAvailable as $shops){ 
						
							$product_tgt = new Product(intval($product['id_product']), false, Context::getContext()->language->id, $shops);
						
							$result = true;
							$combinations = new Collection('Combination');
						
							$combinations->where('id_product', '=', intval($product['id_product']));
						
							foreach ($combinations as $combination){
								
								$comb = new Combination($combination->id, NULL, $shops);
								//echo ($comb->multishop_specific);
								$comb->id_shop_list = array($shops);
								$comb->delete();	
							}
							SpecificPriceRule::applyAllRules(array(intval($product['id_product'])));
					}
				}else{
					$product_tgt->deleteProductAttributes();
				}
				//$product_tgt->deleteProductAttributes();
				copyProductAttributes(intval($_POST['id_product_src']),$product['id_product']);
			}
		}
	}
	else if ($_POST['type'] == "m")
	{
		$query = 'SELECT id_product FROM `'._DB_PREFIX_.'product` WHERE id_manufacturer = '.$_POST['id_product_tgt'];
		$products = Db::getInstance()->executeS($query);
		foreach ($products as $product)
		{
			if (intval($_POST['id_product_src']) == $product['id_product'])
				continue;
			$query = 'SELECT CONCAT(COUNT(pa.id_product_attribute), SUM(pa.price), SUM(pa.weight),  '.($ps_version >= 1.5? 'SUM(stock.quantity)':'SUM(pa.quantity)').') AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` pa
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'product_attribute_shop product_attribute_shop
						ON product_attribute_shop.id_product_attribute = pa.id_product_attribute
						AND product_attribute_shop.id_shop IN('.$awp_shops.')':'').'	
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'stock_available stock
						ON stock.id_product_attribute = pa.id_product_attribute
						AND  stock.id_product ='.intval($product['id_product']).' ':'').'
					WHERE pa.id_product  = '.intval($product['id_product']);
			/*$query = 'SELECT CONCAT(COUNT(id_product_attribute), SUM(price), SUM(weight), SUM(quantity)) AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` 
					WHERE id_product  = '.intval($product['id_product']);*/
			
			$tgt_hash = Db::getInstance()->getRow($query);
			// If attributes are the same, no need to delete and copy again.
			if ($src_hash['concat'] != $tgt_hash['concat'])
			{
				$product_tgt = new Product($product['id_product']);
				if ($ps_version >= 1.5){
				
			
					$shopsAvailable = explode(",", $awp_shops);
					
					  
					foreach ($shopsAvailable as $shops){ 
						
							$product_tgt = new Product(intval($product['id_product']), false, Context::getContext()->language->id, $shops);
						
							$result = true;
							$combinations = new Collection('Combination');
						
							$combinations->where('id_product', '=', intval($product['id_product']));
						
							foreach ($combinations as $combination){
								
								$comb = new Combination($combination->id, NULL, $shops);
								//echo ($comb->multishop_specific);
								$comb->id_shop_list = array($shops);
								$comb->delete();	
							}
							SpecificPriceRule::applyAllRules(array(intval($product['id_product'])));
					}
				}else{
					$product_tgt->deleteProductAttributes();
				}
				//$product_tgt->deleteProductAttributes();
				copyProductAttributes(intval($_POST['id_product_src']),$product['id_product']);
			}
		}
	}
	else if ($_POST['type'] == "s")
	{
		$query = 'SELECT id_product FROM `'._DB_PREFIX_.'product` WHERE id_supplier = '.$_POST['id_product_tgt'];
		if ($ps_version >= 1.5){
			$query = 'SELECT p.id_product FROM `'._DB_PREFIX_.'product`  p
						left join `'._DB_PREFIX_.'product_supplier` ps on ps.id_product = p.id_product
						WHERE ps.id_product_attribute = 0 AND ps.id_supplier = '.$_POST['id_product_tgt'];
		}
		$products = Db::getInstance()->executeS($query);
		foreach ($products as $product)
		{
			if (intval($_POST['id_product_src']) == $product['id_product'])
				continue;
			$query = 'SELECT CONCAT(COUNT(pa.id_product_attribute), SUM(pa.price), SUM(pa.weight),  '.($ps_version >= 1.5? 'SUM(stock.quantity)':'SUM(pa.quantity)').') AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` pa
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'product_attribute_shop product_attribute_shop
						ON product_attribute_shop.id_product_attribute = pa.id_product_attribute
						AND product_attribute_shop.id_shop IN('.$awp_shops.')':'').'	
					'.($ps_version >= 1.5?	'INNER JOIN '._DB_PREFIX_.'stock_available stock
						ON stock.id_product_attribute = pa.id_product_attribute
						AND  stock.id_product ='.intval($product['id_product']).' ':'').'
					WHERE pa.id_product  = '.intval($product['id_product']);
			/*$query = 'SELECT CONCAT(COUNT(id_product_attribute), SUM(price), SUM(weight), SUM(quantity)) AS concat 
					FROM `'._DB_PREFIX_.'product_attribute` 
					WHERE id_product  = '.intval($product['id_product']);*/
			$tgt_hash = Db::getInstance()->getRow($query);
			// If attributes are the same, no need to delete and copy again.
			if ($src_hash['concat'] != $tgt_hash['concat'])
			{
				$product_tgt = new Product($product['id_product']);
				
				if ($ps_version >= 1.5){
				
			
					$shopsAvailable = explode(",", $awp_shops);
					
					  
					foreach ($shopsAvailable as $shops){ 
						
							$product_tgt = new Product(intval($product['id_product']), false, Context::getContext()->language->id, $shops);
						
							$result = true;
							$combinations = new Collection('Combination');
						
							$combinations->where('id_product', '=', intval($product['id_product']));
						
							foreach ($combinations as $combination){
								
								$comb = new Combination($combination->id, NULL, $shops);
								//echo ($comb->multishop_specific);
								$comb->id_shop_list = array($shops);
								$comb->delete();	
							}
							SpecificPriceRule::applyAllRules(array(intval($product['id_product'])));
					}
				}else{
					$product_tgt->deleteProductAttributes();
				}
				//$product_tgt->deleteProductAttributes();
				copyProductAttributes(intval($_POST['id_product_src']),$product['id_product']);
			}
		}
	}
	$return = array("complete"=>"1");
}

ob_end_clean();
if (!function_exists('json_decode') )
{
	$j = new JSON();
	print $j->serialize(array2object($return));
}
else
	print json_encode($return);
?>