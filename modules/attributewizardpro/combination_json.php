<?php
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

$log = false;


function add2cart($idProduct, $idProductAttribute, $qty, $ins, $ins_id)
{
	global $cookie, $cart, $log, $awp;
	$psv  = floatval(substr(_PS_VERSION_,0,3));
	$log = false;
	if ($log)
	{
		$myFile = dirname(__FILE__)."/add2cart_log.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, "add2cart $cookie->id_lang = $idProduct, $idProductAttribute, $qty, $ins, $ins_id\n\r");
	}
//get the values
	$errors = "";
	
	$add = true;
	$customizationId = 0;
	$instructions = $ins != "undefined"?stripslashes($ins):"";
	$instructions_id = $ins_id != "undefined"?$ins_id:"";
	if ($qty == 0)
		$errors = Tools::displayError('null quantity');
	elseif (!$idProduct)
		$errors = Tools::displayError('product not found');
	else
	{
		if ($psv < 1.5)
		{
			$producToAdd = new Product(intval($idProduct), false, intval($cookie->id_lang));
			if (!$producToAdd->isAvailableWhenOutOfStock($producToAdd->out_of_stock) && !$awp->checkCartQuantity($idProduct, $qty, $ins_id))
				return $awp->l('You already have the maximum quantity for this product in the cart');
			if ($log)
				fwrite($fh, "$idProduct) = $producToAdd->id - $producToAdd->active\n\r");
			if ((!$producToAdd->id OR !$producToAdd->active))
				$errors = Tools::displayError('product is no longer available');
			else
			{
				if ($log)
					fwrite($fh, "step1\n\r");
				/* Check the quantity availability */
				if ($idProductAttribute AND is_numeric($idProductAttribute))
				{
					if ($log)
						fwrite($fh, "step1.1\n\r");
					if (!$producToAdd->isAvailableWhenOutOfStock($producToAdd->out_of_stock) AND !Attribute::checkAttributeQty(intval($idProductAttribute), intval($qty)))
						$errors = Tools::displayError('product is no longer available');
				}
				elseif ($producToAdd->hasAttributes())
				{
					$idProductAttribute = Product::getDefaultAttribute(intval($producToAdd->id), intval($producToAdd->out_of_stock) == 2 ? !intval(Configuration::get('PS_ORDER_OUT_OF_STOCK')) : !intval($producToAdd->out_of_stock));
					if ($log)
						fwrite($fh, "step1.2\n\r");
					if (!$idProductAttribute)
						Tools::redirectAdmin($link->getProductLink($producToAdd));
					elseif (!$delete AND !$producToAdd->isAvailableWhenOutOfStock($producToAdd->out_of_stock) AND !Attribute::checkAttributeQty(intval($idProductAttribute), intval($qty)))
						$errors = Tools::displayError('product is no longer available');
				}
				elseif (!$producToAdd->checkQty(intval($qty)))
				{
					if ($log)
						fwrite($fh, "step11.3\n\r");
					$errors = Tools::displayError('product is no longer available');
				}
				/* Check vouchers compatibility */
				if ($log)
					fwrite($fh, "step2\n\r");
				if ($add AND (isset($producToAdd->reduction_price) OR isset($producToAdd->reduction_percent) OR isset($producToAdd->on_sale)))
				{
					$discounts = $cart->getDiscounts();
					foreach($discounts as $discount)
						if (!$discount['cumulable_reduction'])
							$errors = Tools::displayError('cannot add this product because current voucher doesn\'t allow additional discounts');
				}
				if ($errors == "")
				{
					if ($add AND $qty >= 0)
					{
						/* Product addition to the cart */
						if ($log)
							fwrite($fh, "trying to adding to cart = $cart->id\n\r");
						if (!isset($cart->id) OR !$cart->id)
						{
							$cart->id_address_delivery = intval($cookie->id_address_delivery);
							$cart->id_address_invoice = intval($cookie->id_address_invoice);
							$cart->add();
							if ($cart->id)
								$cookie->id_cart = intval($cart->id);
						}
						if ($add AND !$cart->containsProduct(intval($idProduct), intval($idProductAttribute), $customizationId, $instructions) AND !$producToAdd->hasAllRequiredCustomizableFields())
							$errors= Tools::displayError('Please fill all required fields, then save the customization.');
						if ($log)
							fwrite($fh, "trying to adding to cart = intval($qty), intval($idProduct), intval($idProductAttribute), $customizationId, Tools::getValue('op', 'up'),$instructions, $instructions_id\n\r");
						if ($errors == "" AND !$cart->updateQty(intval($qty), intval($idProduct), intval($idProductAttribute), $customizationId, Tools::getValue('op', 'up'),$instructions, $instructions_id))
							$errors = Tools::displayError('you already have the maximum quantity available for this product')
								.((isset($_SERVER['HTTP_REFERER']) AND basename($_SERVER['HTTP_REFERER']) == 'order.php') ? ('<script language="javascript">setTimeout("history.back()",5000);</script><br />- '.
								Tools::displayError('You will be redirected to your cart in a few seconds.')) : '');
					}
				}
			}
		}
		// Add to cart PS 1.5+$context
		else
		{
			$mode = 'add';
			$context = Context::getContext();
			$product = new Product((int)$idProduct, true, $context->language->id);
			if (!$product->id || !$product->active)
			{	
				$errors = Tools::displayError('Product is no longer available.', false);
				return;
			}
			if (!Product::isAvailableWhenOutOfStock($product->out_of_stock) && !$awp->checkCartQuantity($idProduct, $qty, $ins_id))
				return $awp->l('You already have the maximum quantity for this product in the cart ('.Product::isAvailableWhenOutOfStock($product->out_of_stock).' - '.$awp->checkCartQuantity($idProduct, $qty, $ins_id).')');
			// If no errors, process product addition
			if (!$errors && $mode == 'add')
			{
				// Add cart if no cart found
				if (!$context->cart->id)
				{
					$context->cart->add();
					if ($context->cart->id)
						$context->cookie->id_cart = (int)$context->cart->id;
				}
				if (!$errors)
				{
					$cart_rules = $context->cart->getCartRules();
					$update_quantity = $context->cart->updateQty($qty, (int)$idProduct, (int)$idProductAttribute, 0, Tools::getValue('op', 'up'), (int)Tools::getValue('id_address_delivery'), null, true, $instructions, $instructions_id);
					if ($update_quantity < 0)
					{
						// If product has attribute, minimal quantity is set with minimal quantity of attribute
						$minimal_quantity = ($idProductAttribute) ? Attribute::getAttributeMinimalQty($idProductAttribute) : $product->minimal_quantity;
						$errors = sprintf(Tools::displayError('You must add %d minimum quantity', false), $minimal_quantity);
					}
					elseif (!$update_quantity)
						$errors = Tools::displayError('You already have the maximum quantity available for this product..', false);
					elseif ((int)Tools::getValue('allow_refresh'))
					{
						// If the cart rules has changed, we need to refresh the whole cart
						$cart_rules2 = $context->cart->getCartRules();
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

		}
	}
	if ($log)
	{
		fwrite($fh, "errors = ".print_r($errors,true)."\n\r");
		fclose($fh);
	}
	return $errors;
}

function getUpdateQuantity($ids, $quantity, &$attribute_impact)
{
	global $log;
	if ($log)
	{
		$myFile = dirname(__FILE__)."/import_log.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, "getUpdateQuantity: $ids, $quantity\n ".print_r($attribute_impact,true)."\n\r");
	}
	$quantity_left = "";
	$tmp_ids = explode(",",substr($ids,1));
	$first = true;
	foreach ($tmp_ids AS $id)
	{
		if ($log)
			fwrite($fh, "quantity_left = $quantity_left , id = $id  --- ".$attribute_impact[$id]['quantity']."\n\r");
		if ($first)
			$quantity_left = $attribute_impact[$id]['quantity'];
		else
			$quantity_left = min($quantity_left, $attribute_impact[$id]['quantity']);
		$first = false;
	}
	foreach ($tmp_ids AS $id)
		$attribute_impact[$id]['quantity'] -= $quantity;
	if ($log)
	{
		fwrite($fh, "quantity_left = $quantity_left\n\r");
		fclose($fh);
	}
	return $quantity_left;
}

if ($log)
{
	$myFile = dirname(__FILE__)."/import_log.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, print_r($_POST,true));
}
//call module
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/attributewizardpro.php');
include_once(dirname(__FILE__).'/JSON.php');
$awp = new AttributeWizardPro();

$psv  = (float)substr(_PS_VERSION_,0,3);

$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'awp_attribute_wizard_pro');
$result = $result[0]['awp_attributes'];

// Get All the regular attributes (no default group)
$attributes = unserialize($result);
$attribute_impact = $awp->getAttributeImpact($_POST['id_product']);

if ($log)
	fwrite($fh, "\n\r".print_r($attribute_impact,true));

	$quantity_groups = explode(",",$_POST['awp_is_quantity']);
if (false && $log)
	fwrite($fh, "quantity_groups +=  ".print_r($quantity_groups,true)."\n\r");
$return = "";
$last_id_group = "";
$ids = "";
$price_impact = 0;
$weight_impact = 0;
$quantity_available = 0;
$minimal_quantity = 1;
$first = true;
$first_attribute = true;
$qty_to_add = array();
// Edit cart
if (Tools::getValue('awp_ins') != '')
{
	Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'cart_product` WHERE id_product = '.Tools::getValue('id_product').' AND id_product_attribute = '.Tools::getValue('awp_ipa').' AND instructions_valid = "'.Tools::getValue('awp_ins').'"');
	if ($log)
	{
		$myFile = dirname(__FILE__)."/1_log.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, 'DELETE FROM `'._DB_PREFIX_.'cart_product` WHERE id_product = '.Tools::getValue('id_product').' AND id_product_attribute = '.Tools::getValue('awp_ipa').' AND instructions_valid = "'.Tools::getValue('awp_ins').'"');
		fclose($fh);
	}
}
foreach($_POST AS $key => $val)
	if (substr($key,0,6) == "group_")
	{
		if ($log)
			fwrite($fh, "\n\r!!!$key => $val\n\r");
		$is_qty = false;
		$id_group = substr($key,6);
		$id_group_arr = explode("_",$id_group);
		$id_group = $id_group_arr[0];
		if (in_array($id_group,$quantity_groups))
			$is_qty = true;
		$group = $awp->isInGroup($id_group, $attributes);
		$attr = $awp->isInAttribute($val,$attributes[$group]["attributes"]);
		if (sizeof($id_group_arr) == 1 || $attributes[$group]["group_type"] == "checkbox")
			$id_attribute = $val;
		else
			$id_attribute = $id_group_arr[1];
		if ($attributes[$group]["group_type"] == "calculation")
		{
			$cur_price_impact = $attribute_impact[$id_attribute]['price'] * $val * $awp->getFeatureVal($cookie->id_lang, $_POST['id_product'], $attributes[$group]["group_calc_multiply"]) / 1000000;
			$cur_weight_impact = $attribute_impact[$id_attribute]['weight'];
		}
		else
		{
			$cur_price_impact = $attribute_impact[$id_attribute]['price'];
			$cur_weight_impact = $attribute_impact[$id_attribute]['weight'];
		}
		$cur_quantity_available = $attribute_impact[$id_attribute]['quantity'];
			
		// Quantity group
		if ($attributes[$group]["group_type"] == "quantity")
		{
			$attr = $awp->isInAttribute($id_group_arr[1],$attributes[$group]["attributes"]);
			$cur_ids = ",".$id_attribute;
			$cur_return =  (!$first_attribute && $id_group != $last_id_group?"<br />":"")."<b>".($psv >= 1.5?Db::getInstance()->_escape($attribute_impact[$id_attribute]["group"]):mysql_real_escape_string($attribute_impact[$id_attribute]["group"])).":</b> ".($psv >= 1.5?Db::getInstance()->_escape($attribute_impact[$id_attribute]["attribute"]):mysql_real_escape_string($attribute_impact[$id_attribute]["attribute"]));
			$last_id_group = $id_group; 
		}
		// Text or Image group
		elseif (isset($id_group_arr[1]) && $attributes[$group]["group_type"] != "checkbox")
		{
			$cur_ids = ",".$id_group_arr[1];
			$attr = $awp->isInAttribute($id_group_arr[1],$attributes[$group]["attributes"]);
			$cur_return =  (!$first_attribute && $id_group != $last_id_group?"<br />":"");
			if ($id_group != $last_id_group)
			{
				$cur_return .= "<b>".($psv >= 1.5?Db::getInstance()->_escape($attribute_impact[$id_attribute]["attribute"]):mysql_real_escape_string($attribute_impact[$id_attribute]["attribute"]));
				$cur_return .= ":</b> ";
			}
			else
				$cur_return .= ", ";
			$val_arr = explode("%7C%7C%7C",$val,2);
			if (sizeof($val_arr) == 2 && strtolower(substr($val_arr[0],strrpos($val_arr[0],"."))) == strtolower(substr($val_arr[1],strrpos($val_arr[1],"."))))
			{
				$type = substr($val_arr[0],strrpos($val_arr[0],".")+1);
				$thumb = substr($val_arr[0],0,strrpos($val_arr[0],"."));
				$full_url = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__;
				if (file_exists(dirname(__FILE__).'/file_uploads/'.urldecode($thumb).'_small.jpg') && ($type == "jpg" || $type == "jpeg" || $type == "gif" || $type == "png"))
					$cur_return .= '<span class=awp_mark_'.$id_group_arr[1].'><a href='.$full_url.'modules/attributewizardpro/file_uploads/'.urlencode($val_arr[0]).' target=_blank><img src='.$full_url.'modules/attributewizardpro/file_uploads/'.urlencode($thumb).'_small.jpg /></a></span class=awp_mark_'.$id_group_arr[1].' val="'.$val.'">';
				else
					$cur_return .= '<span class=awp_mark_'.$id_group_arr[1].'><a href='.$full_url.'modules/attributewizardpro/file_uploads/'.urlencode($val_arr[0]).' target=_blank>'.$val_arr[1].'</a></span class=awp_mark_'.$id_group_arr[1].'>';
			}
			else
			{
					$cur_return .= '<span class=awp_mark_'.$id_group_arr[1].'>'.str_replace("\r","",str_replace("\n","",nl2br(htmlspecialchars(urldecode($val))))).'</span class=awp_mark_'.$id_group_arr[1].'>';
					//$cur_return .= nl2br(str_replace("#","%23",str_replace("&","%26",htmlspecialchars(stripslashes($val),ENT_QUOTES))));
			}
			$last_id_group = 0; 
		}
		// All other "simple" attributes
		else
		{
			$cur_ids = ",".$val;
			$cur_return =  (!$first_attribute && $id_group != $last_id_group?"<br />":"").($id_group != $last_id_group?"<b>".($psv >= 1.5?Db::getInstance()->_escape($attribute_impact[$id_attribute]["group"]):mysql_real_escape_string($attribute_impact[$id_attribute]["group"])).":</b> ":", ").($psv >= 1.5?Db::getInstance()->_escape($attribute_impact[$id_attribute]["attribute"]):mysql_real_escape_string($attribute_impact[$id_attribute]["attribute"]));
			$last_id_group = $id_group; 
		}
		if (!$is_qty)
		{
			$return .= $cur_return; 
			$ids .= $cur_ids;
			$price_impact += $cur_price_impact;
			$weight_impact += $cur_weight_impact;
			$minimal_quantity = max($attribute_impact[$id_attribute]['minimal_quantity'], $minimal_quantity);
			if ($first)
			{
				$quantity_available = $cur_quantity_available;
				$first = false;
			}
			else
				$quantity_available = min($quantity_available, $cur_quantity_available);
if ($log)
	fwrite($fh, "$cur_ids) quantity_available = $quantity_available\n\r");
		}
		if ($log)
			fwrite($fh, "$id_attribute $is_qty) $cur_return | $cur_ids | $cur_price_impact | $cur_weight_impact \n\r".print_r($qty_to_add,true));
		if ($is_qty)
		{
			$qty_to_add[$id_attribute]["price"] = $price_impact+$cur_price_impact;
			$qty_to_add[$id_attribute]["weight"] = $weight_impact+$cur_weight_impact;
			$qty_to_add[$id_attribute]["quantity"] = $val;
			$qty_to_add[$id_attribute]["quantity_available"] = $cur_quantity_available;
			$qty_to_add[$id_attribute]["minimal_quantity"] = $minimal_quantity;
			$qty_to_add[$id_attribute]["ids"] = $ids.$cur_ids;
			$qty_to_add[$id_attribute]["cart"] = $return.$cur_return;
		}
		else if (sizeof($qty_to_add) > 0)
		{
			foreach ($qty_to_add AS $key => $product)
			{
				$qty_to_add[$key]["price"] += $cur_price_impact;
				$qty_to_add[$key]["weight"] += $cur_weight_impact;
				$qty_to_add[$key]["minimal_quantity"] = max($minimal_quantity,$qty_to_add[$id_attribute]["minimal_quantity"]);
				$qty_to_add[$key]["quantity_available"] = min($cur_quantity_available,$qty_to_add[$id_attribute]["quantity_available"]);
				$qty_to_add[$key]["ids"] .= $cur_ids;
				$qty_to_add[$key]["cart"] .= $cur_return;
			}
		}
		$first_attribute = false;
	}
	
if ($log)
{
	fwrite($fh, "qty_to_add = ".print_r($qty_to_add,true)."\n\r");
	fclose($fh);
}
$producToAdd = new Product((int)$_POST['id_product'], false, (int)$cookie->id_lang);

//exit;
// Add multiple products
if (sizeof($qty_to_add) > 0)
{
	$i = 1;
	foreach ($qty_to_add AS $product)
	{
		$id_image = 0;
		$query = 'SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.substr($product['ids'],1).') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$_POST['id_product'].' ORDER BY pa.default_on ASC';
		$res = Db::getInstance()->ExecuteS($query);
		if (is_array($res) && sizeof($res) > 0)
			$id_image = $res[0]['id_image'];

		$query = "SELECT pa.* FROM "._DB_PREFIX_."product_attribute AS pa, "._DB_PREFIX_."product_attribute_combination AS pac, "._DB_PREFIX_."attribute AS a ". ($id_image > 0?", "._DB_PREFIX_."product_attribute_image AS pai":"")." ".
		"WHERE id_product = '".$_POST['id_product']."' AND price = '".$product["price"]."' AND weight = '".$product["weight"]."' ". ($psv >= 1.4?' AND minimal_quantity = "'.$product["minimal_quantity"].'" ':'').
		"AND a.id_attribute = pac.id_attribute AND pac.id_product_attribute = pa.id_product_attribute ".
		"AND a.id_attribute_group = '".$awp->_awp_default_group."' ".
		"AND pa.quantity = ".(intval($product['quantity_available'])).
		($id_image > 0?" AND pac.id_product_attribute = pai.id_product_attribute AND pai.id_image = ".$id_image:"");
		$result = Db::getInstance()->ExecuteS($query);
		if ($log)
		{
			$myFile = dirname(__FILE__)."/2import_log.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
		}
		$nqty = getUpdateQuantity($product['ids'], $product['quantity'], $attribute_impact);
		if (intval($_POST['allow_oos']) != 1 && $nqty <= 0)
			continue;
		if ($log)
		{
			fwrite($fh, "$i ($nqty)query $query =  ".print_r($result,true)."\n\r");
			fclose($fh);
		}
		$id_product_attribute = "";
		foreach ($result AS $k => $row)
			$id_product_attribute = $row['id_product_attribute'];
		if ($id_product_attribute == "")
		{
			Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute (id_product, price, weight, quantity".($psv >= 1.4?",minimal_quantity":"").($psv >= 1.5?",available_date":"").")
				VALUES ('".$_POST['id_product']."','".$product["price"]."','".$product["weight"]."','".(int)$nqty."'".($psv >= 1.4?",'".$product["minimal_quantity"]."'":"").($psv >= 1.5?",'0000-00-00'":"").")");
			$id_product_attribute = Db::getInstance()->Insert_ID();
			Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_combination (id_attribute, id_product_attribute) VALUES ('$awp->_awp_default_item','$id_product_attribute')");
			$res = Db::getInstance()->ExecuteS('SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.substr($product['ids'],1).') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$_POST['id_product'].' ORDER BY pa.default_on ASC');
			if (is_array($res) && sizeof($res) > 0)
				Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_image (id_product_attribute, id_image) VALUES ('$id_product_attribute', '".$res[0]['id_image']."')");
			if ($psv >= 1.5)
			{
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'product_attribute_shop` (`id_product_attribute`, `id_shop`,
					`wholesale_price`, `price`,
					`ecotax`, `weight`,
					`unit_price_impact`, `default_on`,
					`minimal_quantity`,`available_date`)
					VALUES ('.(int)$id_product_attribute.','.(int) Context::getContext()->shop->id.',
					"0", "'.$product["price"].'",
					"0","'.$product["weight"].'",
					"0","0",
					"'.$product["minimal_quantity"].'",  "0000-00-00"	)');
				$stock = (int)$nqty < 0 ? 0 : (int)$nqty;
				$awp->addStock15($producToAdd, $id_product_attribute, Context::getContext()->shop->id, $stock);
			}
		}
		else
		{
			Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product_attribute SET quantity = ".(int)$nqty." WHERE id_product_attribute = '$id_product_attribute'");
			if ($psv >= 1.5)
			{
				$awp->removeStock15($producToAdd, $id_product_attribute, Context::getContext()->shop->id, $nqty);
			}	
			//Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."stock_available SET quantity = ".(int)$nqty." WHERE id_product_attribute = '$id_product_attribute' AND id_shop =".(int) Context::getContext()->shop->id);
		}
		$errors = add2cart($_POST['id_product'], $id_product_attribute, $product["quantity"], urldecode($product["cart"]), $product["ids"]);
		$i++;
	}
	$redirect = array("error" => $errors);
}
else
{
// Single product to add
	if ($first)
	{
		$quantity_available = $producToAdd->quantity;
		if ($quantity_available == 0)
			$quantity_available = $_POST['quantity'];
	}
	$id_image = 0;
	$query = 'SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.substr($ids,1).') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$_POST['id_product'].' ORDER BY pa.default_on ASC';
	$res = Db::getInstance()->ExecuteS($query);
	if (is_array($res) && sizeof($res) > 0)
		$id_image = $res[0]['id_image'];

	$query = "SELECT pa.* FROM "._DB_PREFIX_."product_attribute AS pa, "._DB_PREFIX_."product_attribute_combination AS pac, "._DB_PREFIX_."attribute AS a ". ($id_image > 0?", "._DB_PREFIX_."product_attribute_image AS pai":"")." ".
		"WHERE id_product = '".$_POST['id_product']."' AND price = '".$price_impact."' AND weight = '".$weight_impact."' ". ($psv >= 1.4?' AND minimal_quantity = "'.$minimal_quantity.'" ':'').
		"AND a.id_attribute = pac.id_attribute AND pac.id_product_attribute = pa.id_product_attribute ".
		"AND a.id_attribute_group = '".$awp->_awp_default_group."' ".
		"AND pa.quantity = ".(intval($quantity_available)).
		($id_image > 0?" AND pac.id_product_attribute = pai.id_product_attribute AND pai.id_image = ".$id_image:"");
	$result = Db::getInstance()->ExecuteS($query);
	if ($log)
	{
		$myFile = dirname(__FILE__)."/1import_log.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, "Existing attribute check query = $query\n\r");
		fclose($fh);
	}	
	$id_product_attribute = "";
	foreach ($result AS $k => $row)
		$id_product_attribute = $row['id_product_attribute'];
/*$myFile = dirname(__FILE__)."/1_log.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
fwrite($fh, "Existing attribute check query = $query\n\r($id_product_attribute)\n\n");
fclose($fh);*/
	if ($id_product_attribute == "")
	{
		Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute (id_product, price, weight, quantity".($psv >= 1.4?",minimal_quantity":"").($psv >= 1.5?",available_date":"").")
		 VALUES ('".(int)$_POST['id_product']."','".$price_impact."','".$weight_impact."','".(int)$quantity_available."'".($psv >= 1.4?",'".$minimal_quantity."'":"").($psv >= 1.5?",'0000-00-00'":"").")");
		$id_product_attribute = Db::getInstance()->Insert_ID();
		Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_combination (id_attribute, id_product_attribute) VALUES ('$awp->_awp_default_item','$id_product_attribute')");
		$res = Db::getInstance()->ExecuteS('SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.substr($ids,1).') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$_POST['id_product'].' ORDER BY pa.default_on ASC');
		if (is_array($res) && sizeof($res) > 0)
			Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_image (id_product_attribute, id_image) VALUES ('$id_product_attribute', '".$res[0]['id_image']."')");
		if ($psv >= 1.5)
		{
			$query = 'INSERT INTO `'._DB_PREFIX_.'product_attribute_shop` (`id_product_attribute`, `id_shop`,
				`wholesale_price`, `price`,
				`ecotax`, `weight`,
				`unit_price_impact`, `default_on`,
				`minimal_quantity`,`available_date`)
				VALUES ('.(int)$id_product_attribute.','.(int) Context::getContext()->shop->id.',
				"0", "'.$price_impact.'",
				"0","'.$weight_impact.'",
				"0","0",
				"'.$minimal_quantity.'",  "0000-00-00"	)';
			Db::getInstance()->Execute($query);
/*$myFile = dirname(__FILE__)."/1_log.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
fwrite($fh, "query = $query\n\r");
fclose($fh);*/
			$stock = (int)$quantity_available < 0 ? 0 : (int)$quantity_available;
			$awp->addStock15($producToAdd, $id_product_attribute, Context::getContext()->shop->id, $stock);

		}
	}
	else
	{
		Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product_attribute SET quantity = ".(int)$quantity_available." WHERE id_product_attribute = '$id_product_attribute'");
		if ($psv >= 1.5)
		{
			$stock = (int)$quantity_available < 0 ? 0 : (int)$quantity_available;
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "new stock = $stock\n\n");
//fclose($fh);
			$awp->removeStock15($producToAdd, $id_product_attribute, Context::getContext()->shop->id, $stock);

		}	
	}
	$errors = add2cart($_POST['id_product'], $id_product_attribute, $_POST['quantity'], ($return), $ids);
	$redirect = array("error" => $errors);
}	
if ($log)
{
	$myFile = dirname(__FILE__)."/1import_log.txt";
	$fh = fopen($myFile, 'a') or die("can't open file");
	fwrite($fh, "redirect = ".print_r($redirect,true)."\n\r");
	fclose($fh);
}
//ob_end_clean();
if (!function_exists('json_decode') )
{
	$j = new JSON();
	print $j->serialize(array2object($redirect));
	
}
else
	print json_encode($redirect);
?>