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

global $cookie;

//call module
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/attributewizardpro.php');
include_once(dirname(__FILE__).'/JSON.php');
$awp = new AttributeWizardPro();
$requiredAttributes = array();
$disableProducts = array();;
$ret = "";
$disable_all = intval(Configuration::get('AWP_DISABLE_ALL'));
foreach ($awp->_awp_attributes AS $group)
	if ($group['group_required'] || $disable_all == 1)
		foreach ($group['attributes'] AS $attribute)
			array_push($requiredAttributes, $attribute['id_attribute']);

//print_r($requiredAttributes);
if (isset($_POST['products']) && $_POST['products'] != "")
{
	$query = '
		SELECT pa.id_product, pac.id_attribute
		FROM `'._DB_PREFIX_.'product_attribute` pa
		LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
		WHERE pa.`id_product` in ('.$_POST['products'].')';
	$attributes = Db::getInstance()->ExecuteS($query);
	if (is_array($attributes))
	foreach ($attributes AS $row)
		if (!in_array($row['id_product'],$disableProducts) && in_array($row['id_attribute'], $requiredAttributes))
		{
			array_push($disableProducts, $row['id_product']);
			$ret .= ($ret==""?"":",").$row['id_product'];
		}
}	

$redirect = array("awp_disable"=>$ret);
ob_end_clean();
if (!function_exists('json_decode') )
{
	$j = new JSON();
	print $j->serialize(array2object($redirect));
	
}
else
	print json_encode($redirect);

?>