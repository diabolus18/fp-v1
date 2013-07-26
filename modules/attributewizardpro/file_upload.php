<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../images.inc.php');
include(dirname(__FILE__).'/attributewizardpro.php');

$awp = new AttributeWizardPro();
$ps_version  = floatval(substr(_PS_VERSION_,0,3));

$uploaddir = dirname(__FILE__).'/file_uploads/';
$uploadfile = strtolower(md5($_REQUEST['id_product']."_".$_REQUEST['id_attribute']."_".mt_rand()).substr($_FILES['userfile']['name'],strrpos($_FILES['userfile']['name'],".")));

if ($_FILES['userfile']['size'] > Configuration::get('AWP_UPLOAD_SIZE') * 1024)
{
	print $awp->l('File size is too big, max size = ').Configuration::get('AWP_UPLOAD_SIZE').'KB';
	exit;
}

$move = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$uploadfile);
if ($move)
{
	$newSize = Configuration::get('AWP_THUMBNAIL_SIZE');
    $path_info = pathinfo($uploaddir.$uploadfile);
    $extension = strtolower($path_info['extension']);
	$no_extention = substr($uploaddir.$uploadfile,0,strlen($uploaddir.$uploadfile)-strlen($extension)-1);
	if($_FILES['userfile']['size'] < 2000 * 1024 && ($extension=="jpg" || $extension=="jpeg" || $extension=="png" || $extension=="gif"))
	{
    	imageResize($ps_version==1.1?array('tmp_name'=>$uploaddir.$uploadfile):$uploaddir.$uploadfile, $no_extention."_small.jpg", $newSize, $newSize);
		echo $uploadfile."|||".$_FILES['userfile']['name'];
    }
   	else
		echo $uploadfile."||||".$_FILES['userfile']['name'];
} else {
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired
  echo $awp->l('Error: Could not copy file, please check there is writing permissions to ')." $uploaddir";
}
?>