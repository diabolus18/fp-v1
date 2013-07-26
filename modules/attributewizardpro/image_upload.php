<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/attributewizardpro.php');

$awp = new AttributeWizardPro();
// Prevent unauthorized access.
if ($awp->_awp_random != Tools::getValue('awp_random'))
{
	print "No Permissions";
	exit;
}

$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'awp_attribute_wizard_pro');
$result = $result[0]['awp_attributes'];

$attributes = unserialize($result);
$is_group = false;
if (isset($_REQUEST['id_group']))
{
	$order = $awp->isInGroup($_REQUEST['id_group'], $attributes);
	if (isset($attributes[$order]['image_upload']))
		$attributes[$order]['image_upload']++;
	else
		$attributes[$order]['image_upload'] = 1;
	$is_group = true;
}
elseif (isset($_REQUEST['id_attribute']))
{
	$order = $awp->isInAttribute($_REQUEST['id_attribute'], $attributes[$_REQUEST['pos']]['attributes']);
	if (isset($attributes[$_REQUEST['pos']]['attributes'][$order]['image_upload_attr']))
		$attributes[$_REQUEST['pos']]['attributes'][$order]['image_upload_attr']++;
	else
	{
		$attributes[$_REQUEST['pos']]['attributes'][$order]['image_upload_attr'] = 1;
	}
}
else
{
	print "Missing Information";
	exit;
}
Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'awp_attribute_wizard_pro` SET awp_attributes = "'.addslashes(serialize($attributes)).'"');
	
$uploaddir = dirname(__FILE__).'/img/';
if ($is_group)
	$uploadfile = $uploaddir . strtolower("id_group_".$_REQUEST['id_group'].substr(basename($_FILES['userfile']['name']),strrpos(basename($_FILES['userfile']['name']),".")));
else
	$uploadfile = $uploaddir . strtolower("id_attribute_".$_REQUEST['id_attribute'].substr(basename($_FILES['userfile']['name']),strrpos(basename($_FILES['userfile']['name']),".")));
$move = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
if ($move)
{
	if ($is_group && Configuration::get('AWP_IMAGE_RESIZE') == 1)
	{
		$newWidth = Configuration::get('AWP_IMAGE_RESIZE_WIDTH');
	    $path_info = pathinfo($uploadfile);
    	$extension = strtolower($path_info['extension']);
		if($extension=="jpg" || $extension=="jpeg" )
			$src = imagecreatefromjpeg($uploadfile);
		else if($extension=="png")
			$src = imagecreatefrompng($uploadfile);
		else 
			$src = imagecreatefromgif($uploadfile);
		list($width, $height) = getimagesize($uploadfile);
		$newHeight = ($height / $width) * $newWidth;
		$tmp = imagecreatetruecolor($newWidth, $newHeight);
		$no_extention = substr($uploadfile,0,strlen($uploadfile)-strlen($extension)-1);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		if (file_exists($no_extention.".gif"))
			unlink($no_extention.".gif");
		if (file_exists($no_extention.".jpeg"))
			unlink($no_extention.".jpeg");
		if (file_exists($no_extention.".jpg"))
			unlink($no_extention.".jpg");
		if (file_exists($no_extention.".png"))
			unlink($no_extention.".png");
		imagejpeg($tmp, $uploadfile, 85);
	}
	echo "success";
} else {
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired
  print "error: could not write ".$uploadfile.", check your file permission";
}
?>