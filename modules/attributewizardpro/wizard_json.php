<?php
global $cookie;

//call module
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/attributewizardpro.php');
$awp = new AttributeWizardPro();

$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'awp_attribute_wizard_pro');
$result = $result[0]['awp_attributes'];

$attributes = unserialize($result);

if ($_POST['id_attribute'] == "")
{
	$order = 0;
	foreach($_POST['group'] AS $ids)
		if ($ids != "")
		{
			$id_group = explode("_",$ids);
			$group = $awp->isInGroup($id_group[1], $attributes);
			$nattributes[$order] = $attributes[$group];
			$order++;
		}
	//if (sizeof($nattributes) == sizeof($attributes))
		Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'awp_attribute_wizard_pro` SET awp_attributes = "'.addslashes(serialize($nattributes)).'"');
}
else
{
	$order = 0;
	$group = 0;
	foreach($_POST['attribute_'.$_POST['id_group']] AS $ids)
		if ($ids != "")
		{
			$id_group = explode("_",$ids);
			$group = $awp->isInGroup($id_group[1], $attributes);
			$attr = $awp->isInAttribute($id_group[2],$attributes[$group]["attributes"]); 
			$nattributes[$order] = $attributes[$group]["attributes"][$attr];
			$order++;
		}
	$attributes[$group]["attributes"] = $nattributes;
	Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'awp_attribute_wizard_pro` SET awp_attributes = "'.addslashes(serialize($attributes)).'"');
}
?>