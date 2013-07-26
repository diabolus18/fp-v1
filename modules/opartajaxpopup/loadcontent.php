<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
$context = Context::getContext();

if(isset($_POST['type']) && $_POST['type']=="cms") {	
	//include(dirname(__FILE__).'/../../classes/CMS.php');
	$cms=new CMS($_POST['id'], (int)$context->language->id);	
	echo $cms->content;
}
else if(isset($_POST['id']) && is_numeric($_POST['id'])) {
	$context = Context::getContext();
	$sql='
	SELECT o.id_opartajaxpopup,ol.title,ol.code
	FROM '._DB_PREFIX_.'opartajaxpopup o
	LEFT JOIN '._DB_PREFIX_.'opartajaxpopup_lang ol ON (o.id_opartajaxpopup=ol.id_opartajaxpopup)
	WHERE ol.id_lang = '.(int)$context->language->id.' AND o.id_opartajaxpopup = '. (int)$_POST['id'];
	
	if (!$result = Db::getInstance()->getRow($sql))
		$erreur="Nothing";
	else {
		//print_r($result);
		echo $result['code'];
	}
}
else 
	echo "got problem";

?>