<?php
require_once(_PS_MODULE_DIR_ . 'attributewizardpro/PrestoChangeoClasses/init.php');

class AttributeWizardPro extends PrestoChangeoModule 
{
 	private $_html = '';
 	public $_awp_attributes;
 	private $_awp_width;
 	private $_awp_image_resize;
 	private $_awp_layered_image;
 	private $_awp_thumbnail_size;
 	private $_awp_upload_size;
 	private $_awp_add_to_cart;
 	private $_awp_out_of_stock;
 	private $_awp_pi_display;
 	private $_awp_second_add;
 	private $_awp_no_customize;
 	private $_awp_popup;
 	private $_awp_fade;
 	private $_awp_opacity;
 	private $_awp_popup_width;
 	private $_awp_popup_top;
 	private $_awp_popup_left;
 	private $_awp_popup_image;
 	private $_awp_popup_image_type;
 	private $_awp_display_wizard;
 	private $_awp_display_wizard_field;
 	private $_awp_display_wizard_value;
 	private $_awp_disable_all;
 	private $_awp_disable_hide;
 	private $_awp_no_tax_impact;
 	private $_awp_adc_no_attribute;
 	public $_awp_default_group;
 	public $_awp_default_item;
 	public $_awp_random;
 	protected $_full_version = 15700;

 	function __construct()
	{
		$this->name = 'attributewizardpro';
		$this->tab = floatval(substr(_PS_VERSION_,0,3))<1.4?'Presto-Changeo':'front_office_features';
		$this->version = '1.5.7';
		if ($this->getPSV() >= 1.4)
			$this->author = 'Presto-Changeo';
		
		parent::__construct(); // The parent construct is required for translations
		$this->_refreshProperties();

		$this->displayName = $this->l('Attribute Wizard Pro');
		$this->description = $this->l('Customized the displays of product attributes, override product combination and create unlimited custom attributes.');
		if ($this->upgradeCheck('AWP'))
			$this->warning = $this->l('We have released a new version of the module,') .' '.$this->l('request an upgrade at ').' https://www.presto-changeo.com/en/contact_us';
	}

	function install()
	{
		$hooked = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'hook` WHERE name = "awpProduct"');
		if (!is_array($hooked) || sizeof($hooked) == 0)
			Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'hook` (
			`id_hook` ,`name` ,`title` ,`description` ,`position`)
			VALUES (NULL , "awpProduct", "AWP Product", "Product page hook for Attribute Wizard Pro", "1");');
		if (!parent::install() || 
			!$this->registerHook('header') || !$this->registerHook('productfooter')
			 || !$this->registerHook('newOrder')|| !$this->registerHook('footer'))
			return false;
		Configuration::updateValue('AWP_INSTALLED',1);
		Configuration::updateValue('AWP_INSTALL','block');
		Configuration::updateValue('AWP_THUMBNAIL_SIZE','60');
		Configuration::updateValue('AWP_UPLOAD_SIZE','2000');
		Configuration::updateValue('AWP_PI_DISPLAY','diff');
		Configuration::updateValue('AWP_SECOND_ADD','10');
		Configuration::updateValue('AWP_SECOND_ADD','10');
		Configuration::updateValue('AWP_NO_CUSTOMIZE','0');
		Configuration::updateValue('AWP_POPUP','0');
		Configuration::updateValue('AWP_FADE','0');
		Configuration::updateValue('AWP_OPACITY','40');
		Configuration::updateValue('AWP_POPUP_WIDTH','700');
		Configuration::updateValue('AWP_POPUP_TOP','200');
		Configuration::updateValue('AWP_POPUP_LEFT','-100');
		Configuration::updateValue('AWP_DISPLAY_WIZARD','1');
		Configuration::updateValue('AWP_DISPLAY_WIZARD_VALUE','1');
		Configuration::updateValue('AWP_NO_TAX_IMPACT','0');
		Configuration::updateValue('AWP_ADCC_NO_ATTRIBUTE','1');
		Configuration::updateValue('PRESTO_CHANGEO_UC',time());
		Configuration::updateValue('AWP_RANDOM', md5(mt_rand().time()));
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'awp_attribute_wizard_pro` (
  			`awp_attributes` MEDIUMTEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
		Db::getInstance()->Execute(trim($query));
		$result = Db::getInstance()->ExecuteS("SELECT * FROM `"._DB_PREFIX_."awp_attribute_wizard_pro`");
		if (sizeof($result) == 0)
			Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'awp_attribute_wizard_pro` (`awp_attributes`) VALUES ("")');
		$result = Db::getInstance()->ExecuteS("show keys from `"._DB_PREFIX_."product_attribute_combination`");
		if (sizeof($result) == 2)
		{
			Db::getInstance()->Execute("ALTER TABLE `"._DB_PREFIX_."product_attribute_combination` ADD INDEX ( `id_attribute` ) ");
			Db::getInstance()->Execute("ALTER TABLE `"._DB_PREFIX_."product_attribute_combination` ADD INDEX ( `id_product_attribute` ) ");
		}
		$this->getDbOrderedAttributes();
		$cols = Db::getInstance()->ExecuteS('describe '._DB_PREFIX_.'cart_product');
		$installed = false;
		$upgraded = false;
		foreach ($cols AS $col)
			if ($col['Field'] == "instructions")
				$installed = true;
			elseif ($col['Field'] == "instructions_id")
				$upgraded = true;
		if (!$installed)
		{
			Db::getInstance()->Execute("ALTER TABLE `"._DB_PREFIX_."cart_product` ADD `instructions` TEXT  NOT NULL AFTER `quantity` ,ADD `instructions_valid` varchar(50) NOT NULL AFTER `instructions`, ADD `instructions_id` TEXT NOT NULL AFTER `instructions_valid`");
			Db::getInstance()->Execute("ALTER TABLE `"._DB_PREFIX_."order_detail` CHANGE `product_name` `product_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		}
		else if (!$upgraded)
			Db::getInstance()->Execute("ALTER TABLE `"._DB_PREFIX_."cart_product` ADD `instructions_id` TEXT NOT NULL AFTER `instructions_valid`");
		$res = Db::getInstance()->ExecuteS('SHOW KEYS FROM '._DB_PREFIX_.'cart_product');
		foreach ($res as $val)
			if ($val['Key_name'] == 'PRIMARY')
			{
				Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'cart_product` DROP INDEX `PRIMARY`');
				Db::getInstance()->Execute('
					ALTER TABLE `'._DB_PREFIX_.'cart_product`
					ADD PRIMARY KEY (`id_cart`, `id_product`, `id_product_attribute`, `instructions_valid` (50))');
				break;
			}
		$result = Db::getInstance()->ExecuteS("SELECT * FROM "._DB_PREFIX_."attribute_group_lang WHERE name = 'awp_details'");
		if (sizeof($result) == 0)
		{
			$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
			$obj = new AttributeGroup();
			$obj->is_color_group = false;
			$obj->name[$defaultLanguage] = "awp_details";
			$obj->public_name[$defaultLanguage] = "Details";
			if ($this->comparePSV('>=', 1.5))
				$obj->group_type = 'select';
			$obj->add();
			Configuration::updateValue('AWP_DEFAULT_GROUP', $obj->id);
			if ($this->comparePSV('>=', 1.5))
			{
				$att = new Attribute();
				$att->id_attribute_group = $obj->id;
				$att->name[$defaultLanguage] = " ";
				$att->add();
				$id_attribute = $att->id;
			}
			else
			{
				Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."attribute (id_attribute_group, color) VALUES ('".$obj->id."','0')");
				$id_attribute = Db::getInstance()->Insert_ID();
				Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."attribute_lang (id_attribute, id_lang, name) VALUES ('$id_attribute','".$this->context->cookie->id_lang."',' ')");
			}
				Configuration::updateValue('AWP_DEFAULT_ITEM', $id_attribute);
		}
		
		return true;
	}

	function uninstall()
	{
		if (!parent::uninstall())
			return false;
		return true;
	}

	private function _refreshProperties()
	{
		if (!Configuration::get('AWP_INSTALLED'))
		{
			$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'awp_attribute_wizard_pro` (
	  			`awp_attributes` MEDIUMTEXT NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
			Db::getInstance()->Execute(trim($query));
			$result = Db::getInstance()->ExecuteS("SELECT * FROM `"._DB_PREFIX_."awp_attribute_wizard_pro`");
			if (!is_array($result) || sizeof($result) == 0)
			{
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'awp_attribute_wizard_pro` (`awp_attributes`) VALUES ("")');
				$result = '';
			}	
			Configuration::updateValue('AWP_INSTALLED',1);
		}
		$result = Db::getInstance()->ExecuteS("SELECT * FROM `"._DB_PREFIX_."awp_attribute_wizard_pro`");
		if (!is_array($result) || sizeof($result) == 0)
		{
			$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'awp_attribute_wizard_pro` (
	  			`awp_attributes` MEDIUMTEXT NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
			Db::getInstance()->Execute(trim($query));
			Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'awp_attribute_wizard_pro` (`awp_attributes`) VALUES ("")');
			$result = "";
		}
		else
			$result = $result[0]['awp_attributes'];
		$this->_awp_attributes = $result != ""?unserialize($result):$this->getDbOrderedAttributes();
    	$this->_awp_width = Configuration::get('AWP_IMAGE_RESIZE_WIDTH');
		$this->_awp_image_resize = Configuration::get('AWP_IMAGE_RESIZE');    	
		$this->_awp_layered_image = Configuration::get('AWP_LAYERED_IMAGE');    	
		$this->_awp_thumbnail_size = Configuration::get('AWP_THUMBNAIL_SIZE');    	
		$this->_awp_upload_size = Configuration::get('AWP_UPLOAD_SIZE');    	
		$this->_awp_add_to_cart = Configuration::get('AWP_ADD_TO_CART');    	
		$this->_awp_out_of_stock = Configuration::get('AWP_OUT_OF_STOCK');    	
		$this->_awp_pi_display = Configuration::get('AWP_PI_DISPLAY');    	
		$this->_awp_second_add = (int)(Configuration::get('AWP_SECOND_ADD'));
		$this->_awp_no_customize = (int)(Configuration::get('AWP_NO_CUSTOMIZE'));
		$this->_awp_popup = (int)(Configuration::get('AWP_POPUP'));
		$this->_awp_fade = (int)(Configuration::get('AWP_FADE'));
		$this->_awp_opacity = (int)(Configuration::get('AWP_OPACITY'));
		$this->_awp_popup_width = (int)(Configuration::get('AWP_POPUP_WIDTH'));
		$this->_awp_popup_top = (int)(Configuration::get('AWP_POPUP_TOP'));
		$this->_awp_popup_left = (int)(Configuration::get('AWP_POPUP_LEFT'));
		$this->_awp_popup_image = (int)(Configuration::get('AWP_POPUP_IMAGE'));
		$this->_awp_popup_image_type = Configuration::get('AWP_POPUP_IMAGE_TYPE');
		$this->_awp_default_group = Configuration::get('AWP_DEFAULT_GROUP');    	
		$this->_awp_default_item = Configuration::get('AWP_DEFAULT_ITEM');    	
		$this->_awp_display_wizard = Configuration::get('AWP_DISPLAY_WIZARD');    	
		$this->_awp_display_wizard_field = Configuration::get('AWP_DISPLAY_WIZARD_FIELD');    	
		$this->_awp_display_wizard_value = Configuration::get('AWP_DISPLAY_WIZARD_VALUE');    	
		$this->_awp_disable_all = (int)(Configuration::get('AWP_DISABLE_ALL'));    	
		$this->_awp_disable_hide = (int)(Configuration::get('AWP_DISABLE_HIDE'));    	
		$this->_awp_no_tax_impact = $this->comparePSV('<=', 1.4)?(int)Configuration::get('AWP_NO_TAX_IMPACT'):1;    	
		$this->_awp_adc_no_attribute = (int)(Configuration::get('AWP_ADC_NO_ATTRIBUTE'));    	
		$this->_last_updated = Configuration::get('PRESTO_CHANGEO_UC');
		$random = Configuration::get('AWP_RANDOM');
		if ($random != '')
			$this->_awp_random = $random;
		else
		{
			$random = md5(mt_rand().time());
			Configuration::updateValue('AWP_RANDOM', $random);
			$this->_awp_random = $random;
		}
	}
	
	public function getContent()
	{
		$this->_postProcess();
		$this->_displayForm();
		return $this->_html;
	}
	
    private function _displayForm()
    {
    	global $cookie;
    	$ps_version  = floatval(substr(_PS_VERSION_,0,3));
		if ($this->comparePSV('>=', 1.5))
		{
			$ps_shops = Shop::getContextListShopID();
			$shops = implode(",", $ps_shops);
		}
    	$ps_version3  = substr(_PS_VERSION_,0,5).(substr(_PS_VERSION_,5,1) != "."?substr(_PS_VERSION_,5,1):"");
		$languages = Language::getLanguages();
		$features = Feature::getFeatures($cookie->id_lang);
		$image_formats = ImageType::getImagesTypes('products');
		$image_formats_options = '';
		foreach ($image_formats as $format)
			$image_formats_options .= '<option value="' . $format['name'].'|||'.$format['width'].'x'.$format['height'].'"'.(Tools::getValue('awp_popup_image_type', $this->_awp_popup_image_type) == $format['name'].'|||'.$format['width'].'x'.$format['height'] ? ' selected="selected"' : '').'">'.$format['name'] .'  ('.$format['width'].'x'.$format['height'].')</option>';
		$iso = Language::getIsoById($cookie->id_lang);
		$ipr_arr = array("checkbox","radio","textbox","quantity","calculation","image","images");
		$size_arr = array("dropdown","file");
		$hin_arr = array("checkbox","radio","textbox","textarea","file","quantity","calculation","image","images");
		$ml_arr = array("textbox","textarea");
		$req_arr = array("textbox","textarea","file");
		$this->_html .= ($this->comparePSV('>=', 1.5)?'<div style="width:900px;margin:auto">':'').
			'<img src="http://updates.presto-changeo.com/logo.jpg" border="0" /> <h2>'.$this->displayName.'</h2>';
		if ($url = $this->upgradeCheck('AWP'))
			$this->_html .= '
			<fieldset class="width3" style="background-color:#FFFAC6;width:800px;"><legend><img src="'.$this->_path.'logo.gif" />'.$this->l('New Version Available').'</legend>
			'.$this->l('We have released a new version of the module. For a list of new features, improvements and bug fixes, view the ').'<a href="'.$url.'#change" target="_index"><b><u>'.$this->l('Change Log').'</b></u></a> '.$this->l('on our site.').'
			<br />
			'.$this->l('For real-time alerts about module updates, be sure to join us on our') .' <a href="http://www.facebook.com/pages/Presto-Changeo/333091712684" target="_index"><u><b>Facebook</b></u></a> / <a href="http://twitter.com/prestochangeo1" target="_index"><u><b>Twitter</b></u></a> '.$this->l('pages').'.
			<br />
			<br />
			'.$this->l('Please').' <a href="https://www.presto-changeo.com/en/contact_us" target="_index"><b><u>'.$this->l('contact us').'</u></b></a> '.$this->l('to request an upgrade to the latest version').'.
			</fieldset><br />';
    	$this->_html .= '
    		<link rel="stylesheet" type="text/css" href="'._MODULE_DIR_.'attributewizardpro/css/awp.css">
    		<script type="text/javascript" src="'._MODULE_DIR_.'attributewizardpro/js/jquery.tablednd_0_5.js"></script>
			<script type="text/javascript" src="'._MODULE_DIR_.'attributewizardpro/js/ajaxupload.js"></script>
			<script type="text/javascript">
    			var awp_psv = '.floatval(substr(_PS_VERSION_,0,3)).';
    			var awp_layered_image = \''.$this->_awp_layered_image.'\';
				var baseDir = \''._MODULE_DIR_.'attributewizardpro/'.'\';
				var awp_random = \''.$this->_awp_random.'\';
				var alternate = \'0\';
				var total_groups = \''.sizeof($this->_awp_attributes).'\';
				var awp_edit = \''.$this->l('Edit').'\';
				var awp_tiny = false;
				var awp_link = \''.$this->l('Link').'\';
				var awp_delete = \''.$this->l('Delete').'\';
				var awp_enter = \''.$this->l('Enter').'\';
				var awp_hide = \''.$this->l('Hide').'\';
				var awp_confirm_reset = \''.$this->l('Are you sure you want to reset all the settings').'?\';
				var awp_confirm_delete = \''.$this->l('Are you sure you want to delete all the temporary attributes').'?\';
				var awp_description = \''.$this->l('Description').'\';
				'.($this->comparePSV('>=', 1.5) ? 'var awp_shops = "'.$shops.'"; ' : '' ).'
				function awp_change_type(obj, id_attribute_group, group_color)
				{
					$(\'#ipr_container_\'+id_attribute_group).css(\'display\',(obj.value == \'checkbox\' || obj.value == \'radio\' || obj.value == \'image\' || obj.value == \'iamges\' || obj.value == \'textbox\' || obj.value == \'quantity\'?\'\':\'none\'));
					$(\'#hin_container_\'+id_attribute_group).css(\'display\',(obj.value != \'dropdown\'?\'\':\'none\'));
					$(\'#qty_zero_container_\'+id_attribute_group).css(\'display\',(obj.value == \'quantity\'?\'\':\'none\'));
					$(\'#size_container_\'+id_attribute_group).css(\'display\',(group_color == 1 || (obj.value != \'dropdown\' && obj.value != \'file\')?\'\':\'none\'));
					$(\'#size2_container_\'+id_attribute_group).css(\'display\',(group_color == 1 || (obj.value != \'dropdown\' && obj.value != \'file\')?\'\':\'none\'));
					$(\'#resize_container_\'+id_attribute_group).css(\'display\',(group_color == 1?\'\':\'none\'));
					$(\'#required_container_\'+id_attribute_group).css(\'display\',(obj.value == \'textbox\' || obj.value == \'textarea\' || obj.value == \'file\'?\'\':\'none\'));
					$(\'#max_limit_container_\'+id_attribute_group).css(\'display\',(obj.value == \'textbox\' || obj.value == \'textarea\'?\'\':\'none\'));
					$(\'#ext_container_\'+id_attribute_group).css(\'display\',(obj.value == \'file\'?\'\':\'none\'));
    			}
				</script>';
    	if (file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js'))
    	{
    		$this->_html .= '
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
		<script type="text/javascript">
		function tinyMCEInit(element)
		{
			$().ready(function() {
				$(element).tinymce({
					// Location of TinyMCE script
					script_url : \''.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/tiny_mce.js\',
					// General options
					theme : "advanced",
					plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
					// Theme options
					theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
					theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
					theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					width : "700px",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true,
					content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
					// Drop lists for link/image/media/template dialogs
					template_external_list_url : "lists/template_list.js",
					external_link_list_url : "lists/link_list.js",
					external_image_list_url : "lists/image_list.js",
					media_external_list_url : "lists/media_list.js",
					elements : "nourlconvert",
					convert_urls : false,
					language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en').'"
				});
			});
		}
		</script>';
    	}
    	elseif (file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js'))
    	{
			$this->_html .= ' <script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript">
		function tinyMCEInit(element)
		{
						tinyMCE.init({
						mode : element != "textarea"?"exact":"textareas",
						theme : "advanced",
						plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
						// Theme options
						theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : false,
						content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
						document_base_url : "'.__PS_BASE_URI__.'",
						width: "600",
						height: "auto",
						font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",
						elements : element != "textarea"?element.substring(1):"nourlconvert,ajaxfilemanager",
						file_browser_callback : "ajaxfilemanager",
						entity_encoding: "raw",
						convert_urls : false,
						language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en').'"
						
					});
					}
				</script>';
    	}
    	elseif (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/tiny_mce.js'))
    	{
    			$iso = Language::getIsoById((int)($cookie->id_lang));
				$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
				$ad = dirname($_SERVER["PHP_SELF"]);

			$this->_html .= ' <script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript">
				var iso = \''.$isoTinyMCE.'\' ;
				var pathCSS = \''._THEME_CSS_DIR_.'\' ;
				var ad = \''.$ad.'\' ;
				function tinyMCEInit(element)
				{
					tinyMCE.init({
						mode : element != "textarea"?"exact":"textareas",
						theme : "advanced",
						skin:"cirkuit",
						plugins : "safari,pagebreak,style,table,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen,xhtmlxtras,preview",
						// Theme options
						theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs,pagebreak",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : false,
						content_css : pathCSS+"global.css",
						document_base_url : ad,
						width: "600",
						height: "auto",
						font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
						elements : element != "textarea"?element.substring(1):"nourlconvert,ajaxfilemanager",
						file_browser_callback : "ajaxfilemanager",
						entity_encoding: "raw",
						convert_urls : false,
						language : iso,
					});
				}
				
				function ajaxfilemanager(field_name, url, type, win)
				{
					var ajaxfilemanagerurl = ad+"/ajaxfilemanager/ajaxfilemanager.php";
					switch (type)
					{
						case "image":
							break;
						case "media":
							break;
						case "flash": 
							break;
						case "file":
							break;
						default:
							return false;
					}
					tinyMCE.activeEditor.windowManager.open({
						url: ajaxfilemanagerurl,
						width: 782,
						height: 440,
						inline : "yes",
						close_previous : "no"
					},{
						window : win,
						input : field_name
					});
				}
			</script>';
    	}
		$ps_version3_array = array("1.2.5","1.3","1.3.1","1.3.2","1.3.3","1.3.4","1.3.5","1.3.6","1.3.7",
 		"1.4.0","1.4.1","1.4.2","1.4.3","1.4.4","1.4.5","1.4.6","1.4.7","1.4.8","1.4.9","1.4.10","1.4.11",
				"1.5.0","1.5.1","1.5.2","1.5.3","1.5.4");
		if (!in_array($ps_version3, $ps_version3_array))
		{
			$this->_html .= '<b style="color:red">'.$this->l('The module is not compatible with this version of Prestashop').'</b>';
			return;
		}	
 		$this->_html .= '
			<script type="text/javascript" src="'.$this->_path.'js/awp.js"></script>
			<script>
			var awp_copy_src = "'.$this->l('You must enter a Source Product ID (to copy from)').'";
			var awp_copy_tgt = "'.$this->l('You must enter a Target Product or Category ID (to copy to)').'";
			var awp_invalid_src = "'.$this->l('Invalid Source ID').'";
			var awp_invalid_tgt = "'.$this->l('Invalid Target ID').'";
			var awp_copy_same = "'.$this->l('Source and Target ID must be different').'";
			var awp_are_you = "'.$this->l('Are you sure you want to copy the attributes From').'";
			var awp_will_delete = "'.$this->l('This will delete all the existing attributes in the Target Product or Category').'";
			var awp_to = "'.$this->l('to').'";
			var awp_copy = "'.$this->l('Copy').'";
			var awp_cancel = "'.$this->l('Cancel').'";
			var awp_copied = "'.$this->l('Attributes Copied').'.";
			var awp_id_lang = '.$cookie->id_lang.';
			</script>
			<style>
			.awp_hidden {display:none;}
			.awp_help {
				-moz-border-radius: 15px;
				border-radius: 15px;
				border: 1px solid blue;
				background-color: #ffffff;
				position: absolute;
				display: none;
				padding: 10px;
			}
			.awp_help li { margin-left: 10px; }
			.awp_qm { pointer: cursor; }
			</style>
			<form action="'.$_SERVER['REQUEST_URI'].'" name="wizard_form" id="wizard_form" method="post">
			<input type="hidden" name="awp_id_lang" id="awp_id_lang" value="'.$cookie->id_lang.'" />
			<fieldset class="width3" style="width:850px"><legend>'.$this->l('Installation Instructions').' (<a href="'.$_SERVER['REQUEST_URI'].'&awp_shi='.Configuration::get('AWP_INSTALL').'" style="color:blue;text-decoration:underline">'.(Configuration::get('AWP_INSTALL')=="block"?"Hide":"Show").'</a>)</legend>
			<div id="awp_install" style="padding-left:10px;display:'.Configuration::get('AWP_INSTALL').'">
				<table width="850">
				<tr height="40">
					<td align="left">
						<li style="margin-left:10px"><b>'.$this->l('A new attribute group named "awp_details" was created').', <b style="color:red">'.$this->l('DO NOT DELETE OR RENAME IT!!!').'</b></b></li>
						<br />
						<li style="margin-left:10px"><b>'.$this->l('The following changes need to be made to your existing Presatshop files').'.</b></li>
						<br />
						<li style="margin-left:10px"><b>'.$this->l('There is a copy of all the modified files in /modules/attributewizardpro/modified_').(in_array($ps_version3, $ps_version3_array)?$ps_version3:$ps_version).'.</b></li>
						<br />
						<li style="margin-left:10px"><b style="color:blue">'.$this->l('If you have not made changes in those files on your server, you can copy the files from /modules/attributewizardpro/modified_').(in_array($ps_version3, $ps_version3_array)?$ps_version3:$ps_version).' '.$this->l('to your root directory').'.</b></li>
						<br />
						<li style="margin-left:10px"><b style="color:red">'.$this->l('If you have made changes in those files on your server, copy only the lines listed below from the files in /modules/attributewizardpro/modified_').(in_array($ps_version3, $ps_version3_array)?$ps_version3:$ps_version).' '.$this->l('to the corresponding local files.').'.</b></li>
						<br />
						<li style="margin-left:10px"><b>'.$this->l('The filenames below will appear in').'<b style="color:red"> '.$this->l('RED').'</b> '.$this->l('until you make the necessary changes, if the changes were made correctly, they will turn').' <b style="color:green">'.$this->l('GREEN').'</b> '.$this->l('after you reload the page').'.</b></li>
						<br />
						<li style="margin-left:10px"><b>'.$this->l('The code comparison is done on each line + previous and next, if you made custom changes to those files (I.E remove or add lines), you may not get the line as green, even though the code is correct').'.</b></li> 
						<br />'.($this->comparePSV('==', 1.4)?'
						<li style="margin-left:10px"><b style="color:red">'.$this->l('Make sure to turn on force recompile (Preferences->Performance) after changing the tpl files, when you see the module is working correctly, you can turn it back to off').'.</b></li>
						<br />':'');
			$this->_html .= $this->getFileChanges().'
						<hr style="background-color:green" />
						<b style="margin-left:10px;font-size:14px;color:blue">'.$this->l('Dedicated Hook (Optional)').'</b> - '.$this->l('if you wish to diplay the wizard in a different location on the product page').'
						<br />
						<li style="margin-left:10px"><b style="color:red">'.$this->l('The module can ONLY be hooked in one location, make sure to remove is from productFooter if you used the custom hook').'.</b></li>
						<br />';
		if ($this->comparePSV('==', 1.4))
			$this->_html .= '<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/FrontController.php','/override/classes/FrontController.php',array('28-34'), $ps_version3).'</li><br />';
		elseif ($this->comparePSV('<', 1.4))
			$this->_html .= '<li style="margin-left:10px"><b style="">'.$this->l('In /header.php add').'</b> &nbsp;<b style="color:blue">\'HOOK_AWP_PRODUCT\' => Module::hookExec(\'awpProduct\'),&nbsp;</b> '.$this->l('below HOOK_TOP around line #15').'.</li><br />';
			$this->_html .= '
						<li style="margin-left:10px"><b style="">'.$this->l('In').' /themes/'._THEME_NAME_.'/product.tpl '.$this->l('add').'</b>&nbsp;&nbsp;<b style="color:blue">'.($this->comparePSV('<=', 1.4)?'{$HOOK_AWP_PRODUCT}':'{hook h="awpProduct"}').'</b> '.$this->l('where you want to display the wizard, make sure it\'s not inside a &lt;form> tag').'.</li>
						<hr style="background-color:green" />
						<br />
						</td>
				</tr>		
				<tr height="40">
					<td align="left">
						<b style="margin-left:10px;font-size:16px">'.$this->l('Please read this information carefully, adding attributes is done differently than before').'!</b>
						<br />
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('To add attributes, use the regular combinations tab, but ').'</b><b style="color:red">'.$this->l('add only 1 or more items from each group').'.</b>
						<br />
						<b style="color:red">'.$this->l('DO NOT use the attribute combination generator').'.</b>
						</li>
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('Quantity is entered per attribute item, and not per combination (see example 2), when using quantity (stock) you should enter each attribute item. The available quantity of a product is set to the lowest of the selected attributes').'.</b></li>
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('If all the items from a group have the same price, weight and no quantity, they all be grouped').' <a style="color:blue;text-decoration:underline" href="'.$this->_path.'img/instructions1.jpg" target="_blank">'.$this->l('Example 1').'</a>.</b></li>
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('If they need to have a different price, weight or quantity, add them individually').' <a style="color:blue;text-decoration:underline" href="'.$this->_path.'img/instructions2.jpg" target="_blank">'.$this->l('Example 2').'</a>.</b></li>
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('Do this for each attribute group').' <a style="color:blue;text-decoration:underline" href="'.$this->_path.'img/instructions3.jpg" target="_blank">'.$this->l('Example 3').'</a>, <a style="color:blue;text-decoration:underline" href="'.$this->_path.'img/instructions4.jpg" target="_blank">'.$this->l('Example 4').'</a>.</b></li>
						<br />
						<li style="margin-left:10px"><b style="">'.$this->l('Finally, to define the defaults for each group, you MUST CREATE A NEW COMBINATION with one item from each group (for groups that will use checkboxes, you can use 0 or multiple items, This will also be the default when a customer clicks "Add to cart" from pages other than the product page)').' <a style="color:blue;text-decoration:underline" href="'.$this->_path.'img/instructions5.jpg" target="_blank">'.$this->l('Example 5').'</a>.</b></li>
						<br />
						<li style="margin-left:10px"><b style="color:blue">'.$this->l('When a customer adds a product to the cart, a new temporary group is created (awp_details), you should delete them once in a while using the "Delete Temporary Attributes" button.').'</b><b style="color:red">'.$this->l('This will not affect existing order details').'.</b></li>
					</td>
				</tr>		
				</table>
			</div>
			</fieldset>
			<br />
			<fieldset class="width3" style="width:850px"><legend><img src="'.$this->_path.'logo.gif" />'.$this->l('Copy Attributes').'</legend>
				<table width="850">
				<tr height="40">
					<td align="left">
						<li>
						'.$this->l('This tool allows you to copy All attributes from one product to another (or to all products in a category, manufacturer or supplier)').'
						</li>
						<br />
						'.$this->l('Source (Product ID):').'&nbsp;
						<input type="text" name="awp_copy_src" style="width:50px" id="awp_copy_src" value="" onchange="$(\'#awp_copy_confirmation\').html(\'\');" />&nbsp;&nbsp;
						'.$this->l('Target :').'&nbsp;
						<select name="awp_copy_tgt_type" id="awp_copy_tgt_type" onchange="$(\'#awp_copy_confirmation\').html(\'\');">
						<option value="p">'.$this->l('Product').'</option>
						<option value="c">'.$this->l('Category').'</option>
						<option value="m">'.$this->l('Manufacturer').'</option>
						<option value="s">'.$this->l('Supplier').'</option>
						</select>
						(ID)
						<input type="text" name="awp_copy_tgt" style="width:50px" id="awp_copy_tgt" value="" onchange="$(\'#awp_copy_confirmation\').html(\'\');" />&nbsp;&nbsp;
						<input class="button" type="button" id="awp_copy_validate" value="'.$this->l('Confirm').'" onclick="awp_copy_validation()" />
					</td>
				</tr>
				<tr height="40">
					<td>
						<div id="awp_copy_confirmation">
						</div>
					</td>
				</tr>		
				</table>
			</fieldset>
			<br />
			<fieldset class="width3" style="width:850px"><legend><img src="'.$this->_path.'logo.gif" />'.$this->l('Attribute Settings').'</legend>
			<table border="0" width="850">
			<tr>
				<td align="left" width="1">
					<b>'.$this->l('Display Wizard').':</b> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_dw" />
				</td>
				<td align="left">
					'.$this->l('For all products').':
					<input type="radio" name="awp_display_wizard" id="awp_display_wizard" value="1" '.(Tools::getValue('awp_display_wizard', $this->_awp_display_wizard) == 1 ? 'checked' : '').' />
					&nbsp;&nbsp;
					'.$this->l('Only when').':
					<input type="radio" name="awp_display_wizard" id="awp_display_wizard" value="0" '.(Tools::getValue('awp_display_wizard', $this->_awp_display_wizard) != 1 ? 'checked' : '').' />
					&nbsp;&nbsp;
   					<select name="awp_display_wizard_field">
   						<option value="Reference" '.(Tools::getValue('awp_display_wizard_field', $this->_awp_display_wizard_field) == "Reference"?"selected":"").'>'.$this->l('Reference').'</option>
						<option value="Supplier Reference" '.(Tools::getValue('awp_display_wizard_field', $this->_awp_display_wizard_field) == "Supplier Reference"?"selected":"").'>'.$this->l('Supplier Reference').'</option>
        				<option value="EAN13" '.(Tools::getValue('awp_display_wizard_field', $this->_awp_display_wizard_field) == "EAN13"?"selected":"").'>'.$this->l('EAN13').'</option>
        				<option value="UPC" '.(Tools::getValue('awp_display_wizard_field', $this->_awp_display_wizard_field) == "UPC"?"selected":"").'>'.$this->l('UPC').'</option>
        				<option value="Location" '.(Tools::getValue('awp_display_wizard_field', $this->_awp_display_wizard_field) == "Location"?"selected":"").'>'.$this->l('Location').'</option>
        			</select>
					'.$this->l('is set to').'
					<input type="text" name="awp_display_wizard_value" size="3" id="awp_display_wizard_value" value="'.Tools::getValue('awp_display_wizard_value', $this->_awp_display_wizard_value).'" />
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left" width="180">
					<b>'.$this->l('Wizard Location').':</b>
				</td>
				<td align="left">
					<table border="0">
					<tr>
						<td align="left" width="100">
							'.$this->l('In Page').':
							<input type="radio" onclick="$(\'#awp_popup_control\').fadeOut(1000)" name="awp_popup" id="awp_popup" value="0" '.(Tools::getValue('awp_popup', $this->_awp_popup) != 1 ? 'checked' : '').' />
						</td>
						<td align="left" width="1%">
							&nbsp;&nbsp;
						</td>
						<td align="left">
							'.$this->l('Popup').': 
							<input type="radio" onclick="$(\'#awp_popup_control\').fadeIn(1000)" name="awp_popup" id="awp_popup" value="1" '.(Tools::getValue('awp_popup', $this->_awp_popup) == 1 ? 'checked' : '').' />
						</td>
					</tr>
					<tr>
						<td align="left">&nbsp;	</td>
						<td align="left">&nbsp;	</td>
						<td align="left"id="awp_popup_control" style="display:'.(Tools::getValue('awp_popup', $this->_awp_popup) == 1 ? 'block' : 'none').'">
							'.$this->l('Fade Background').': &nbsp;
							<input type="checkbox" style="border:none;padding:0px;margin:0px" name="awp_fade" id="awp_fade" value="1" '.(Tools::getValue('awp_fade', $this->_awp_fade)==1?'checked':'').' />
							&nbsp;&nbsp;
							'.$this->l('Opacity').': &nbsp;
							<input type="text" name="awp_opacity" size="3" id="awp_opacity" value="'.Tools::getValue('awp_opacity', $this->_awp_opacity).'" />
							0-100
							<br />
							'.$this->l('Width').': &nbsp;
							<input type="text" name="awp_popup_width" size="3" id="awp_popup_width" value="'.Tools::getValue('awp_popup_width', $this->_awp_popup_width).'" />
							<br />
							'.$this->l('Top position').': &nbsp;
							<input type="text" name="awp_popup_top" size="3" id="awp_popup_top" value="'.Tools::getValue('awp_popup_top', $this->_awp_popup_top).'" />
							&nbsp;&nbsp;&nbsp;
							'.$this->l('Left position').': &nbsp;
							<input type="text" name="awp_popup_left" size="3" id="awp_popup_left" value="'.Tools::getValue('awp_popup_left', $this->_awp_popup_left).'" />
							<br />
							'.$this->l('The default is center, to change enter a value like 100 or -100').'
							<br />
							'.$this->l('Include Product Image').': &nbsp;
							<input type="checkbox" style="border:none;padding:0px;margin:0px" name="awp_popup_image" id="awp_popup_image" value="1" '.(Tools::getValue('awp_popup_image', $this->_awp_popup_image)==1?'checked':'').' />
							&nbsp;&nbsp;&nbsp;
							<span id="popup_image_type">'.$this->l('Image Type').': &nbsp;
							<select name="awp_popup_image_type">
								'.$image_formats_options.'
							</select>
							<span>
							</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left" width="1">
					<b>'.$this->l('Group Image').':</b> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_gi" />
				</td>
				<td align="left">
					<input onclick="update_image_resize()" style="border:none;padding:0px;margin:0px" type="checkbox" name="awp_image_resize" id="awp_image_resize" value="1" '.(Configuration::get('AWP_IMAGE_RESIZE')==1?"checked":"").'/>
					'.$this->l('Resize on upload, max width').': 
					<input onblur="update_image_resize()" type="text" name="awp_image_resize_width" size="3" id="awp_image_resize_width" value="'.($this->_awp_width?$this->_awp_width:"100").'" />
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left" width="1">
					<b>'.$this->l('Layered Images').':</b> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_li" />
				</td>
				<td align="left">
					<select name="awp_layered_image">
   						<option value="0" '.(Tools::getValue('awp_layered_image', Configuration::get('AWP_LAYERED_IMAGE')) != "1"?"selected":"").'>'.$this->l('Disable').'</option>
   						<option value="1" '.(Tools::getValue('awp_layered_image', Configuration::get('AWP_LAYERED_IMAGE')) == "1"?"selected":"").'>'.$this->l('Enable').'</option>
   					</select>
					'.$this->l('You must click Update for a change to take affect.').'
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left" width="1">
					<b>'.$this->l('File Upload Setting').':</b> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_fus" />
				</td>
				<td align="left">
					'.$this->l('Thumbnail Width/Height').': 
					<input type="text" name="awp_thumbnail_size" size="3" id="awp_thumbnail_size" value="'.($this->_awp_thumbnail_size?$this->_awp_thumbnail_size:"60").'" />
					&nbsp;&nbsp;
					'.$this->l('Max Upload Size').': 
					<input type="text" name="awp_upload_size" size="5" id="awp_upload_size" value="'.($this->_awp_upload_size?$this->_awp_upload_size:"2000").'" /> KB ('.$this->l('Server limit = ').(substr(ini_get('upload_max_filesize'),0,-1)*1024).'KB)
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left">
					<b>'.$this->l('Add to Cart Display').':</b> &nbsp;
				</td>
				<td align="left">
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_add_to_cart" value="" '.(!$this->_awp_add_to_cart?"checked":"").' /> 
					'.$this->l('No Change ').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_add_to_cart" value="bottom" '.($this->_awp_add_to_cart == "bottom"?"checked":"").' /> 
					'.$this->l('Add to Bottom ').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_add_to_cart" value="scroll" '.($this->_awp_add_to_cart == "scroll"?"checked":"").' /> 
					'.$this->l('Scroll Existing').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_add_to_cart" value="both" '.($this->_awp_add_to_cart == "both"?"checked":"").' /> 
					'.$this->l('Both').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<b>'.$this->l('Add to Cart button').':</b>
				</td>
				<td align="left">
					'.$this->l('Display additional button when more than').' 
					<input type="text" name="awp_second_add" size="3" id="awp_second_add" value="'.Tools::getValue('awp_second_add', $this->_awp_second_add).'" />
					'.$this->l('attribute groups are used').'
					<br />
					<input type="checkbox" style="border:none;padding:5px;margin:5px" name="awp_no_customize" value="1" '.($this->_awp_no_customize==1?"checked":"").' /> 
					'.$this->l('Do not replace with Customize (In page)').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr height="30">
				<td align="left">
					<b>'.$this->l('Out of Stock').':</b> &nbsp;
				</td>
				<td align="left">
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_out_of_stock" value="" '.(!$this->_awp_out_of_stock?"checked":"").' /> 
					'.$this->l('No Change ').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_out_of_stock" value="disable" '.($this->_awp_out_of_stock == "disable"?"checked":"").' /> 
					'.$this->l('Disable ').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_out_of_stock" value="hide" '.($this->_awp_out_of_stock == "hide"?"checked":"").' /> 
					'.$this->l('Hide').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>			';
		if ($this->comparePSV('<', 1.4))
			$this->_html .= '
			 <tr>
				<td align="left">
					<b>'.$this->l('Attribute Price Impact').':</b> &nbsp;
				</td>
				<td align="left">
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_no_tax_impact" value="0" '.($this->_awp_no_tax_impact != 1?"checked":"").' /> 
					'.$this->l('Include Tax').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_no_tax_impact" value="1" '.($this->_awp_no_tax_impact == 1?"checked":"").' /> 
					'.$this->l('Exclude Tax').'&nbsp;&nbsp;'.$this->l('Requires changes to /classes/Product.php').'
				</td>
			</tr>';
		$this->_html .= '
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left">
					<b>'.$this->l('Price Impact Display').':</b> &nbsp;
				</td>
				<td align="left">
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_pi_display" value="" '.(!$this->_awp_pi_display?"checked":"").' /> 
					'.$this->l('None ').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_pi_display" value="diff" '.($this->_awp_pi_display == "diff"?"checked":"").' /> 
					'.$this->l('Difference').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_pi_display" value="total" '.($this->_awp_pi_display == "total"?"checked":"").' /> 
					'.$this->l('Total').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left">
					<b>'.$this->l('Not in Product Page').':</b>  <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_npp" />
				</td>
				<td align="left">
					<select name="awp_disable_hide">
   						<option value="0" '.(Tools::getValue('awp_disable_hide', $this->_awp_disable_hide) != "1"?"selected":"").'>'.$this->l('Disable').'</option>
   						<option value="1" '.(Tools::getValue('awp_disable_hide', $this->_awp_disable_hide) == "1"?"selected":"").'>'.$this->l('Hide').'</option>
   					</select>
   					&nbsp;'.$this->l('for').'&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_disable_all" value="" '.($this->_awp_disable_all==0?"checked":"").' /> 
					'.$this->l('Products with a required field').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_disable_all" value="1" '.($this->_awp_disable_all == 1?"checked":"").' /> 
					'.$this->l('All Products with attributes').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="6">
				<td></td>
			</tr>
			<tr>
				<td align="left">
					<b>'.$this->l('No Attribute Selection').':</b> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_nas" />
				</td>
				<td align="left">
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_adc_no_attribute" value="" '.($this->_awp_adc_no_attribute==0?"checked":"").' /> 
					'.$this->l('Enabled').'&nbsp;&nbsp;
					<input type="radio" style="border:none;padding:5px;margin:5px" name="awp_adc_no_attribute" value="1" '.($this->_awp_adc_no_attribute == 1?"checked":"").' /> 
					'.$this->l('Disabled').'&nbsp;&nbsp;
				</td>
			</tr>
			<tr height="40">
				<td colspan="2" align="center">
					<input type="submit" value="'.$this->l('Update').'" onclick="awp_update_lang(false)" name="submitChanges" class="button" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input onclick="return confirm(awp_confirm_reset)" type="submit" value="'.$this->l('Reset').'" name="resetData" class="button" /> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_res" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input onclick="return confirm(awp_confirm_delete)" type="submit" value="'.$this->l('Delete Temporary (awp_details) Attributes').'" name="deleteAttributes" class="button" /> <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_dta" />
				</td>
			</tr>
			<tr height="30">
				<td align="left" colspan="2">
					<li style="margin-left:10px"><b style="color:green">'.$this->l('Click on an Attribute Group name to Expand or Collapse settings and values ').' '.$this->l('or').' <b style="cursor:pointer;color:blue" onclick="awp_toggle_all(1)">'.$this->l('Expand All').'</b> &nbsp;/&nbsp; <b style="cursor:pointer;color:blue" onclick="awp_toggle_all(0)">'.$this->l('Collapse All').'</b>.</b></li>
					<li style="margin-left:10px"><b>'.$this->l('Set each group display type (radio, dropdown, checkbox, etc...), select the number of attributes to display in each row.').'.</b></li>
					<li style="margin-left:10px"><b>'.$this->l('Select a layout ("Vertical" is better with multiple items per row, or "Horizontal") as well as image related settings.').'</b></li>
					<li style="margin-left:10px"><b>'.$this->l('Attribute Colors and Images are assigned from the existing PS interface (Catalog -> Attributes and Groups, make sure the group is set as "Color" and then edit each attribute)').'</b></li>
				</td>
			</tr>
			';
    	if (file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js') || file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js') || file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/tiny_mce.js'))
	    	$this->_html .='
			<tr height="30">
				<td align="left" colspan="2">
					<input class="button" type="button" value="'.$this->l('Turn on TinyMCE Editor for All').'" onclick="$(\'div.awp_tinymce\').css(\'display\',\'block\');'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js') || file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js') || file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/tiny_mce.js')?'tinyMCEInit(\'textarea\');':'').'awp_tiny=true" /> <b style="color:red">'.$this->l('You MUST click "Update" after changing the text, do not try to drag any groups').'.</span>
				</td>
			</tr>		
			';
    	if (sizeof($languages) > 1)
    	{
    	$this->_html .='
			<tr height="20">
				<td align="left" valign="top" colspan="2">
					'.$this->l('Select a Language for Group Description and Group Headers').'&nbsp;
				</td>
			</tr>
			<tr height="20">
				<td align="left" valign="top" colspan="2">
					<div id="awp_languages_block_top">
					<ul id="awp_first-languages" style="list-style-type: none">';
    	$n = 0;
    	foreach ($languages AS $language)
    	{
			$this->_html .= '<li id="awp_lang_'.$language['id_lang'].'" '.($language['id_lang'] == $cookie->id_lang?'class="selected_language"':'').'>
								<input type="hidden" name="awp_li_lang_'.$n.'" id="awp_li_lang_'.$n.'" value='.$language['id_lang'].' />
								<img onclick="awp_update_lang(true);awp_select_lang('.$language['id_lang'].')" src="'._THEME_LANG_DIR_.$language['id_lang'].'.jpg" alt="'.$language['name'].'" />
							</li>';
			$n++;
    	}
		$this->_html .= '
					</ul>
					</div>
				</td>
			</tr>';
    	}
		$this->_html .= '
			<tr height="20">
				<td align="left" valign="top" colspan="2">
				<li style="margin-left:10px">
					'.$this->l('Select an attribute type for each group, each type will open additional settings below it').'.
				</li>
				</td>
			</tr>
			</table>
			<table id="group" border="0" width="850" class="table tableDnD">
			<tr>
				<th align="left" width="30">
					'.$this->l('Order').'
				</th>
				<th align="left" width="140">
					'.$this->l('Group Name').' <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_gn" />
				</th>
				<th align="left" width="150">
					'.$this->l('Group Image').'
				</th>
				<th align="left" width="130">
					'.$this->l('Attribute Type').' <img src="'.$this->_path.'img/qm.png" class="awp_qm" id="awp_qm_at" />
				</th>
				<th align="left" width="300">
					'.$this->l('Attribute Order').'
				</th>
				</tr>';
        		$ordered_groups = $this->getDbOrderedAttributes();
        		//print_r($ordered_groups);
        		$i = 0;
        		if (sizeof($ordered_groups) > 0)
        		{
	        		foreach ($ordered_groups as $group)
    	    		{
    	    			if ($group['group_name'] == 'awp_details')
    	    				continue;
    	    			//print_r($group);
        				$this->_html .= '
        					<tr id="td_'.$group['id_attribute_group'].'">
        						<td align="left" valign="top" style="cursor:move" class="pointer dragHandle center" style="width:16px">
        							<img src="'.$this->_path.'img/arrow.png" />
        						</td>
        						<td align="left" valign="top" style="width:16px">
        							<b style="cursor:pointer" onclick="awp_toggle('.$i.')">'.$group['group_name'].'</b>
        							<br />
        							<span class="awp_ag_display_'.$i.($i>0?' awp_hidden':'').'" id="awp_description_'.$group['id_attribute_group'].'_text" style="cursor:pointer;color:blue;text-decoration:underline" onclick="toggle_desc('.$group['id_attribute_group'].')">'.(isset($group['group_description_'.$cookie->id_lang])?$this->l('Edit'):$this->l('Enter')).' '.$this->l('Description').'</span>
        							<div id="description_container_'.$group['id_attribute_group'].'" class="awp_tinymce" style="display: none">
        							<textarea onchange="awp_update_lang(false)" id="awp_description_'.$group['id_attribute_group'].'" name="awp_description_'.$group['id_attribute_group'].'" style="width:150px; height:150px;">'.(isset($group['group_description_'.$cookie->id_lang])?$group['group_description_'.$cookie->id_lang]:"").'</textarea>
        							';
        				foreach ($languages as $language)
        				{
        					$this->_html .= '<input type="hidden" id="awp_description_'.$group['id_attribute_group'].'_'.$language['id_lang'].'" name="awp_description_'.$group['id_attribute_group'].'_'.$language['id_lang'].'" value="'.(isset($group['group_description_'.$language['id_lang']])?$group['group_description_'.$language['id_lang']]:"").'" />';
        					$this->_html .= '<input type="hidden" name="group_header_'.$group['id_attribute_group'].'_'.$language['id_lang'].'" id="group_header_'.$group['id_attribute_group'].'_'.$language['id_lang'].'" value="'.(isset($group['group_header_'.$language['id_lang']])?$group['group_header_'.$language['id_lang']]:"").'" />';
        				}
        				$this->_html .= '</div>';
    					if (file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js') || file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js') || file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/tiny_mce.js'))
	    					$this->_html .='<br /><br />
									<input class="button awp_ag_display_'.$i.($i>0?' awp_hidden':'').'" type="button" value="'.$this->l('Turn on TinyMCE').'" onclick="$(\'#description_container_'.$group['id_attribute_group'].'\').css(\'display\',\'block\');'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js') || file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js') || file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/tiny_mce.js')?'tinyMCEInit(\'#awp_description_'.$group['id_attribute_group'].'\');':'').'" />
									';
        				$this->_html .= '</td>
        						<td align="left" valign="top" style="width:16px">
        							<input type="hidden" id="id_group_'.$i.'" name="id_group_'.$i.'" value="'.$group['id_attribute_group'].'" />';
        				$filename = $this->getGroupImage($group['id_attribute_group']);
        				if ($filename)
        				{
        					$this->_html .= '<div class="awp_ag_display_'.$i.($i>0?' awp_hidden':'').'" id="upload_container_'.$i.'">
        								<div id="image_container_'.$i.'">
        								<img src="'.$filename.'" />
        								<br /><br />
        								</div>
			        					<input id="upload_button_'.$i.'" class="button" style="cursor:pointer" value="'.$this->l('Change Image').'" type="button">
        								<br /><br />
        								Link: <input type="text" style="width:100px" name="group_url_'.$group['id_attribute_group'].'" value="'.$group['group_url'].'">
        								<br />
			        					<div id="delete_image_container_'.$i.'">
        									<br />
        									<input type="checkbox" name="delete_image_'.$group['id_attribute_group'].'" value="1"> &nbsp;<b>'.$this->l('Delete').'</b>
          								</div>
			        					</div>';
        				}
        				else
        				{
        					$this->_html .= '<div class="awp_ag_display_'.$i.($i>0?' awp_hidden':'').'" id="upload_container_'.$i.'">
        								<div id="image_container_'.$i.'">
        								</div>
        									<input id="upload_button_'.$i.'" class="button" style="cursor:pointer" value="'.$this->l('Upload Image').'" type="button">
        								<div id="delete_image_container_'.$i.'" style="display:none">
        									<br />
        									<input type="checkbox" name="delete_image_'.$group['id_attribute_group'].'" value="1"> &nbsp;<b>'.$this->l('Delete').'</b>
          								</div>
        								</div>';
        				}
						$this->_html .= '<br />
        						</td>
        						<td align="left" valign="top" style="width:16px">
        							<table>
        							<tr style="height:25px">
        							<td align="left">
        							<select name="group_type_'.$group['id_attribute_group'].'" onchange="awp_toggle_on('.$i.');awp_change_type(this, '.$group['id_attribute_group'].', '.(isset($group['group_color'])?$group['group_color']:'').')">
        								<option value="image" '.($group['group_type'] == "image"?"selected":"").'>'.$this->l('Image (Single-Select)').'</option>
        								<!--<option value="images" '.($group['group_type'] == "images"?"selected":"").'>'.$this->l('Image (Multi-Select)').'</option>-->
        								<option value="radio" '.($group['group_type'] == "radio"?"selected":"").'>'.$this->l('Radio Button').'</option>
										<option value="checkbox" '.($group['group_type'] == "checkbox"?"selected":"").'>'.$this->l('Checkbox').'</option>
        								<option value="dropdown" '.($group['group_type'] == "dropdown"?"selected":"").'>'.$this->l('Dropdown').'</option>
        								<option value="textbox" '.($group['group_type'] == "textbox"?"selected":"").'>'.$this->l('Textbox').'</option>
        								<option value="textarea" '.($group['group_type'] == "textarea"?"selected":"").'>'.$this->l('Textarea').'</option>
        								<option value="file" '.($group['group_type'] == "file"?"selected":"").'>'.$this->l('File Upload').'</option>
        								<option value="quantity" '.($group['group_type'] == "quantity"?"selected":"").'>'.$this->l('Quantity').'</option>
        								<!--<option value="calculation" '.($group['group_type'] == "calculation"?"selected":"").'>'.$this->l('Calculation').'</option>-->
        							</select>
        							</td>
        							</tr>
        							</table>
        							<table class="awp_ag_display_'.$i.($i>0?' awp_hidden':'').'">
        							<tr id="ipr_container_'.$group['id_attribute_group'].'" style="height:25px;display:'.(in_array($group['group_type'], $ipr_arr)?"":"none").'">
        								<td align="left">
        									<div>
												<input type="text" name="group_per_row_'.$group['id_attribute_group'].'" id="group_per_row_'.$group['id_attribute_group'].'" style="width:20px" value="'.max(1,(isset($group['group_per_row'])?$group['group_per_row']:0)).'" />
        										'.$this->l('Per Row').' 
											</div>
        								</td>
        							</tr>
        							<tr id="il_container_'.$group['id_attribute_group'].'" style="height:25px">
        								<td align="left">
        									<div>
        										'.$this->l('Attribute Layout').':
												<br />
												<small>
												<input type="radio" style="border:none;padding:0;margin:0" name="group_layout_'.$group['id_attribute_group'].'" id="group_layout_'.$group['id_attribute_group'].'" value="0" '.(!isset($group['group_layout']) || $group['group_layout'] == "0"?"checked":"").' /> 
												'.$this->l('Horizontal').'<br />
												<input type="radio" style="border:none;padding:0;margin:0" name="group_layout_'.$group['id_attribute_group'].'" id="group_layout_'.$group['id_attribute_group'].'" value="1" '.(isset($group['group_layout']) && $group['group_layout'] == "1"?"checked":"").' /> 
												'.$this->l('Vertical').'</small>
											</div>
										</td>
        							</tr>
        							<tr id="size_container_'.$group['id_attribute_group'].'" style="display:'.((isset($group['group_color']) && $group['group_color'] == 1) || !in_array($group['group_type'], $size_arr)?"":"none").';height:25px">
        								<td align="left">
											'.$this->l('Cell Size').'
        								</td>
        							</tr>
        							<tr id="size2_container_'.$group['id_attribute_group'].'" style="display:'.((isset($group['group_color']) && $group['group_color'] == 1) || !in_array($group['group_type'], $size_arr)?"":"none").';height:25px">
        								<td align="left">
        									'.$this->l('W').': 
											<input type="text" name="group_width_'.$group['id_attribute_group'].'" id="group_width_'.$group['id_attribute_group'].'" style="width:25px" value="'.(isset($group['group_width'])?$group['group_width']:"").'" />
											'.$this->l('H').': 
											<input type="text" name="group_height_'.$group['id_attribute_group'].'" id="group_height_'.$group['id_attribute_group'].'" style="width:25px" value="'.(isset($group['group_height'])?$group['group_height']:"").'" />
        								</td>
        							</tr>
        							'.((isset($group['group_color']) && $group['group_color'] == 1)?'
        							<tr id="resize_container_'.$group['id_attribute_group'].'" style="height:25px">
        								<td align="left">
											'.$this->l('Resize Textures').': 
											<input type="checkbox" name="group_resize_'.$group['id_attribute_group'].'" id="group_resize_'.$group['id_attribute_group'].'" value="1" '.(isset($group['group_resize']) && $group['group_resize']==1?'checked':'').' />
        								</td>
        							</tr>':'').'
        							<tr id="ext_container_'.$group['id_attribute_group'].'" style="display:'.($group['group_type'] == "file"?"":"none").';height:25px">
	        							<td align="left">
        									<div>
        										'.$this->l('Allowed Extentions').':
        										<br /> 
												<input type="text" name="group_file_ext_'.$group['id_attribute_group'].'" id="group_file_ext_'.$group['id_attribute_group'].'" value="'.(isset($group['group_file_ext'])?$group['group_file_ext']:'jpg|png|jpeg|gif').'" />
												<br />
												'.$this->l('To include more use |extention (I.E |pdf|bmp)').'
											</div>
        								</td>
        							</tr>
        							<tr id="hin_container_'.$group['id_attribute_group'].'" style="display:'.(in_array($group['group_type'], $hin_arr)?"":"none").';height:25px">
        								<td align="left">
        									<div>
        										'.$this->l('Hide Item Name').': 
												<input type="checkbox" name="group_hide_name_'.$group['id_attribute_group'].'" id="group_hide_name_'.$group['id_attribute_group'].'" value="1" '.(array_key_exists('group_hide_name', $group) && $group['group_hide_name']==1?'checked':'').' />
											</div>
        								</td>
        							</tr>
        							<tr id="max_limit_container_'.$group['id_attribute_group'].'" style="display:'.(in_array($group['group_type'], $ml_arr)?"":"none").'">
        								<td align="left">
        									<div>
        										'.$this->l('Max Limit').': 
												<input type="text" size=5" name="group_max_limit_'.$group['id_attribute_group'].'" id="group_max_limit_'.$group['id_attribute_group'].'" value="'.(isset($group['group_max_limit'])?$group['group_max_limit']:'0').'"  />
											</div>
        								</td>
        							</tr>
        							<tr id="required_container_'.$group['id_attribute_group'].'" style="display:'.(in_array($group['group_type'], $req_arr)?"":"none").'">
        								<td align="left">
	        								<div>
        										'.$this->l('Required').': 
												<input type="checkbox" name="group_required_'.$group['id_attribute_group'].'" id="group_required_'.$group['id_attribute_group'].'" value="1" '.(array_key_exists('group_required', $group) && $group['group_required']==1?'checked':'').' />
											</div>
        								</td>
        							</tr>
        							<tr id="qty_zero_container_'.$group['id_attribute_group'].'" style="display:'.($group['group_type'] != "quantity"?'none':'').'">
        								<td align="left">
        									<div>
        										'.$this->l('Default Qty = 0').': 
												<input type="checkbox" name="group_quantity_zero_'.$group['id_attribute_group'].'" id="group_quantity_zero_'.$group['id_attribute_group'].'" value="1" '.(array_key_exists('group_quantity_zero', $group) && $group['group_quantity_zero']==1?'checked':'').' />
											</div>
        								</td>
        							</tr>
        							<tr id="max_limit_container_'.$group['id_attribute_group'].'" style="display:'.($group['group_type'] == "calculation"?"":"none").'">
        								<td align="left">
        									<div>
        										'.$this->l('Min').': &nbsp;
												<input type="text" size=5" name="group_calc_min_'.$group['id_attribute_group'].'" id="group_calc_min_'.$group['id_attribute_group'].'" value="'.(isset($group['group_calc_min'])?$group['group_calc_min']:'0').'"  />
												<br />
        										'.$this->l('Max').': 
												<input type="text" size=5" name="group_calc_max_'.$group['id_attribute_group'].'" id="group_calc_max_'.$group['id_attribute_group'].'" value="'.(isset($group['group_calc_max'])?$group['group_calc_max']:'0').'"  />
												<br />
        										'.$this->l('Feature').': 
												<select name="group_calc_multiply_'.$group['id_attribute_group'].'" id="group_calc_multiply_'.$group['id_attribute_group'].'">';
													foreach($features as $feature)
													{
														$this->_html .='<option value="'.$feature['id_feature'].'" '.(isset($group['group_calc_multiply']) && $group['group_calc_multiply'] == $feature['id_feature']?'selected':'').'>'.$feature['name'].'</option>';
													}
												$this->_html .='										
												</select>
											</div>
        								</td>
        							</tr>
        							<tr style="height:25px">
        							<td align="left">
        							</td>
        							</tr>
        							</table>
									</td>
        						<td align="left" valign="top" style="width:16px">';
						$orders_attributes = $group['attributes'];
						if (sizeof($orders_attributes) > 0)
						{
        					$this->_html .= '<div class="awp_ag_display_'.$i.($i>0?' awp_hidden':'').'" id="awp_ag_'.$i.'" style="display:'.($i == 0?'block':'none').'"><table id="attribute_'.$group['id_attribute_group'].'" width="100%" border="0" class="table tableDnD">';
							for ($n = 0 ; $n < sizeof($orders_attributes) ; $n++)
	    	    			{
        				$this->_html .= '
        					<tr id="td_'.$group['id_attribute_group'].'_'.$group['attributes'][$n]['id_attribute'].'" '.($n%2==0?"":"class=\"alt_row\"").'>
        						<td align="left" valign="top" style="cursor:move" class="pointer dragHandle center" style="width:16px">
        							<img src="'.$this->_path.'img/arrow.png" />
        						</td>
        						<td align="left" valign="top" style="width:270px">
        							<b>'.$group['attributes'][$n]['attribute_name'].'</b>';
        				if ($this->_awp_layered_image)
        				{
        					$awp_lid = $group['attributes'][$n]['id_attribute'];
        					$filename = $this->getLayeredImage($awp_lid, false, $i);
        					if ($filename)
        					{
	        					$this->_html .= '<div class="liu" group="'.$i.'" id="upload_container_l'.$awp_lid.'">
        								<div id="image_container_l'.$awp_lid.'">
        									<img src="'.$filename.'" width="32" height="32" />
        								</div>
			        					<input id="upload_button_l'.$awp_lid.'" class="button" style="cursor:pointer" value="'.$this->l('Change Image').'" type="button">
			        					<div id="delete_image_container_l'.$awp_lid.'">
        									<br />
        									<input type="checkbox" name="delete_image_l'.$awp_lid.'" value="1"> &nbsp;<b>'.$this->l('Delete').'</b>
          								</div>
			        					</div>';
        					}
        					else
        					{
	        					$this->_html .= '<div class="liu" group="'.$i.'" id="upload_container_l'.$awp_lid.'">
        								<div id="image_container_l'.$awp_lid.'">
        								</div>
        									<input id="upload_button_l'.$awp_lid.'" class="button" style="cursor:pointer" value="'.$this->l('Upload Image').'" type="button">
        								<div id="delete_image_container_l'.$awp_lid.'" style="display:none">
        									<br />
        									<input type="checkbox" name="delete_image_l'.$awp_lid.'" value="1"> &nbsp;<b>'.$this->l('Delete').'</b>
          								</div>
        								</div>';
        					}
        					
        				}
        				$this->_html .= '
        						</td>
        					</tr>';
	    	    				
	    	    			}
        					$this->_html .= '</div></table>';
						}
        				$this->_html .= '
        						</td>
        					</tr>
							';
        				$i++;
    	    		}
        		}
		$this->_html .= '
			<tr height="6">
				<td colspan="5"><hr /></td>
			</tr>
			<tr>
				<td colspan="5" align="center">
					<input type="submit" value="'.$this->l('Update').'" onclick="awp_update_lang(false)" name="submitChanges" class="button" />
				</td>
			</tr>
			</table>
			</fieldset>
		</form>'.($this->comparePSV('>=', 1.5)?'</div>':'');
		$this->_html .= $this->helpWindows();
	}

	private function _postProcess()
	{
		$languages = Language::getLanguages();
		if (Tools::getValue('awp_shi') != "")
			if (Tools::getValue('awp_shi') == "block")
				Configuration::updateValue('AWP_INSTALL',"none");
			else
				Configuration::updateValue('AWP_INSTALL',"block");
		if (Tools::isSubmit('deleteAttributes'))
		{
			$result = Db::getInstance()->ExecuteS("SELECT * FROM "._DB_PREFIX_."product_attribute_combination WHERE id_attribute = '".$this->_awp_default_item."'");
			foreach ($result as $row)
			{
				Db::getInstance()->Execute("DELETE FROM "._DB_PREFIX_."product_attribute WHERE id_product_attribute = '".$row['id_product_attribute']."'");
				if ($this->comparePSV('>=', 1.5))
				{
					Db::getInstance()->Execute("DELETE FROM "._DB_PREFIX_."product_attribute_shop WHERE id_product_attribute = '".$row['id_product_attribute']."'");
					Db::getInstance()->Execute("DELETE FROM "._DB_PREFIX_."stock_available WHERE id_product_attribute = '".$row['id_product_attribute']."'");
				}
				$query = "SELECT cp.id_cart FROM `"._DB_PREFIX_."cart_product` AS cp LEFT JOIN ps_orders AS o ON o.id_cart = cp.id_cart WHERE id_product_attribute = '".$row['id_product_attribute']."' AND o.id_order is null";
				$result1 = Db::getInstance()->ExecuteS($query);
				foreach ($result1 as $row1)
					Db::getInstance()->Execute("DELETE FROM `"._DB_PREFIX_."cart_product` WHERE id_product_attribute = '".$row['id_product_attribute']."' AND id_cart = '".$row1['id_cart']."'");
			}
			Db::getInstance()->Execute("DELETE FROM "._DB_PREFIX_."product_attribute_combination WHERE id_attribute = '".$this->_awp_default_item."'");
		}
		if (Tools::isSubmit('resetData'))
		{
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'awp_attribute_wizard_pro`');
			$this->_awp_attributes = array();
		}
		if (Tools::isSubmit('submitChanges'))
		{
			foreach ($this->_awp_attributes AS $key => $att)
			{
				$this->_awp_attributes[$key]["group_type"] = $_POST["group_type_".$att['id_attribute_group']];
				if (isset($_POST["group_required_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_required"] = $_POST["group_required_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_required"] = "";
				if (isset($_POST["group_max_limit_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_max_limit"] = $_POST["group_max_limit_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_max_limit"] = "0";
				if (isset($_POST["group_width_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_width"] = $_POST["group_width_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_width"] = "";
				if (isset($_POST["group_height_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_height"] = $_POST["group_height_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_height"] = "";
				if (isset($_POST["group_resize_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_resize"] = $_POST["group_resize_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_resize"] = "";
				if (isset($_POST["group_layout_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_layout"] = $_POST["group_layout_".$att['id_attribute_group']];
				if (isset($_POST["group_per_row_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_per_row"] = $_POST["group_per_row_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_per_row"] = "1";
				if (isset($_POST["group_hide_name_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_hide_name"] = $_POST["group_hide_name_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_hide_name"] = "";
				if (isset($_POST["group_url_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_url"] = $_POST["group_url_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_url"] = "";
				if (isset($_POST["group_file_ext_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_file_ext"] = $_POST["group_file_ext_".$att['id_attribute_group']];
				if (isset($_POST["group_quantity_zero_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_quantity_zero"] = $_POST["group_quantity_zero_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_quantity_zero"] = "";
					
				if (isset($_POST["group_calc_min_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_calc_min"] = $_POST["group_calc_min_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_calc_min"] = "";
				if (isset($_POST["group_calc_max_".$att['id_attribute_group']]))
					$this->_awp_attributes[$key]["group_calc_max"] = $_POST["group_calc_max_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_calc_max"] = "";
				if (isset($_POST["group_calc_multiply_".$att['id_attribute_group']]) && $_POST["group_type_".$att['id_attribute_group']] == "calculation")
					$this->_awp_attributes[$key]["group_calc_multiply"] = $_POST["group_calc_multiply_".$att['id_attribute_group']];
				else
					$this->_awp_attributes[$key]["group_calc_multiply"] = "";
				foreach ($languages as $language)
				{
					$idl = $language['id_lang'];
					$this->_awp_attributes[$key]["group_description_".$idl] = htmlspecialchars(stripslashes($_POST["awp_description_".$att['id_attribute_group']."_".$idl]));
					$this->_awp_attributes[$key]["group_header_".$idl] = htmlspecialchars(stripslashes($_POST["group_header_".$att['id_attribute_group']."_".$idl]));
				}
				if (isset($_POST["delete_image_".$att['id_attribute_group']]) && $_POST["delete_image_".$att['id_attribute_group']])
				{
 					$filename = $this->getGroupImage($att['id_attribute_group'],true);
 					unlink(dirname(__FILE__).'/img/'.$filename);					
				}
				foreach ($att['attributes'] as $attr)
					if (isset($_POST["delete_image_l".$attr['id_attribute']]) && $_POST["delete_image_l".$attr['id_attribute']])
					{
 						$filename = $this->getLayeredImage($attr['id_attribute'],true, $key);
 						unlink(dirname(__FILE__).'/img/'.$filename);					
					}
			}
			//Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'configuration` WHERE name = "AWP_NO_TAX_IMPACT"');
			$attr = $this->comparePSV('>=', 1.5)?Db::getInstance()->_escape(serialize($this->_awp_attributes)): mysql_real_escape_string(serialize($this->_awp_attributes));
			Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'awp_attribute_wizard_pro` SET awp_attributes = "'.$attr.'"');			
			if (!Configuration::updateValue('AWP_ADD_TO_CART', Tools::getValue('awp_add_to_cart'))
				|| !Configuration::updateValue('AWP_SECOND_ADD', Tools::getValue('awp_second_add'))
				|| !Configuration::updateValue('AWP_OUT_OF_STOCK', Tools::getValue('awp_out_of_stock'))
				|| !Configuration::updateValue('AWP_NO_CUSTOMIZE', Tools::getValue('awp_no_customize'))
				|| !Configuration::updateValue('AWP_PI_DISPLAY', Tools::getValue('awp_pi_display'))
				|| !Configuration::updateValue('AWP_LAYERED_IMAGE', Tools::getValue('awp_layered_image'))
				|| !Configuration::updateValue('AWP_POPUP', Tools::getValue('awp_popup'))
				|| !Configuration::updateValue('AWP_THUMBNAIL_SIZE', Tools::getValue('awp_thumbnail_size'))
				|| !Configuration::updateValue('AWP_UPLOAD_SIZE', Tools::getValue('awp_upload_size'))
				|| !Configuration::updateValue('AWP_DISPLAY_WIZARD', Tools::getValue('awp_display_wizard'))
				|| !Configuration::updateValue('AWP_DISPLAY_WIZARD_FIELD', Tools::getValue('awp_display_wizard_field'))
				|| !Configuration::updateValue('AWP_DISPLAY_WIZARD_VALUE', Tools::getValue('awp_display_wizard_value'))
				|| !Configuration::updateValue('AWP_FADE', Tools::getValue('awp_fade'))
				|| !Configuration::updateValue('AWP_OPACITY', Tools::getValue('awp_opacity'))
				|| !Configuration::updateValue('AWP_NO_TAX_IMPACT', Tools::getValue('awp_no_tax_impact'))
				|| !Configuration::updateValue('AWP_ADC_NO_ATTRIBUTE', Tools::getValue('awp_adc_no_attribute'))
				|| !Configuration::updateValue('AWP_POPUP_WIDTH', Tools::getValue('awp_popup_width'))
				|| !Configuration::updateValue('AWP_POPUP_TOP', Tools::getValue('awp_popup_top'))
				|| !Configuration::updateValue('AWP_POPUP_LEFT', Tools::getValue('awp_popup_left'))
				|| !Configuration::updateValue('AWP_POPUP_IMAGE', Tools::getValue('awp_popup_image'))
				|| !Configuration::updateValue('AWP_POPUP_IMAGE_TYPE', Tools::getValue('awp_popup_image_type'))
				|| !Configuration::updateValue('AWP_DISABLE_ALL', Tools::getValue('awp_disable_all'))
				|| !Configuration::updateValue('AWP_DISABLE_HIDE', Tools::getValue('awp_disable_hide')))
				$this->_html .= '<div class="alert error">'.$this->l('Cannot update settings').Db::getInstance()->getMsgError().'</div>';
			else
				$this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Settings updated').'</div>';
		}
		$this->_refreshProperties();
	}
	
	public function getDbOrderedAttributes()
	{
		global $cookie;
		$query = ' SELECT ag.`id_attribute_group`, ag.`'.($this->comparePSV('<', 1.5)?'is_color_group':'group_type').'`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute` , al.`name` AS attribute_name, a.`color` AS attribute_color
			FROM `'._DB_PREFIX_.'attribute_group` ag
			LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
			LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute_group` = ag.`id_attribute_group`
			LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
			WHERE ag.id_attribute_group != "'.$this->_awp_default_group.'" AND agl.`id_lang` = '.intval($cookie->id_lang).' AND al.`id_lang` = '.intval($cookie->id_lang);
		$result = Db::getInstance()->ExecuteS($query);
		//print $query;
		//print_r($result);		
		$ordered_list = is_array($this->_awp_attributes)?$this->_awp_attributes:array();
		$ordered_list_new = array(); 
		foreach ($result as $attribute)
		{
			if (array_key_exists($attribute["id_attribute_group"],$ordered_list_new) && is_array($ordered_list_new[$attribute["id_attribute_group"]]))
				array_push($ordered_list_new[$attribute["id_attribute_group"]], $attribute['id_attribute']);
			else
			{
				$ordered_list_new[$attribute["id_attribute_group"]] = array();
				array_push($ordered_list_new[$attribute["id_attribute_group"]], $attribute['id_attribute']);
			}
			$awp_order = $this->isInGroup($attribute["id_attribute_group"],$ordered_list);
			if ($awp_order >= 0)
			{
				$ordered_list[$awp_order]["group_color"] = $this->comparePSV('<', 1.5)?$attribute['is_color_group']:($attribute['group_type'] == 'color'?1:0);
				if ($ordered_list[$awp_order]["group_name"] != $attribute['group_name'] || $ordered_list[$awp_order]["public_group_name"] != $attribute['public_group_name'])
				{
					$ordered_list[$awp_order]["group_name"] = $attribute['group_name'];
					if ($ordered_list[$awp_order]["group_type"] == "")
						$ordered_list[$awp_order]["group_type"] = "dropdown";
					$ordered_list[$awp_order]["public_group_name"] = $attribute['public_group_name'];
					//$ordered_list[$awp_order]["attributes"] = array();
				}
				$att_pos = $this->isInAttribute($attribute["id_attribute"],$ordered_list[$awp_order]["attributes"]);
				if ($att_pos == -1)
					$ordered_list[$awp_order]["attributes"][sizeof($ordered_list[$awp_order]["attributes"])] = array(
							"id_attribute"=>$attribute['id_attribute'],
							"attribute_name"=>$attribute['attribute_name'],
							"attribute_color"=>$this->comparePSV('<', 1.5)?($attribute['is_color_group']==1?$attribute['attribute_color']:''):($attribute['group_type'] == 'color'?$attribute['attribute_color']:''));
				else
					$ordered_list[$awp_order]["attributes"][$att_pos] = array(
						"id_attribute"=>$attribute['id_attribute'],
						"attribute_name"=>$attribute['attribute_name'],
						"image_upload_attr"=>(isset($attribute['image_upload_attr'])?$attribute['image_upload_attr']:''),
						"attribute_color"=>$this->comparePSV('<', 1.5)?($attribute['is_color_group']==1?$attribute['attribute_color']:''):($attribute['group_type'] == 'color'?$attribute['attribute_color']:''));
			}
			else
			{
				$ordered_list[sizeof($ordered_list)] = 
					array(
					"id_attribute_group"=>$attribute['id_attribute_group'],
					"group_name"=>$attribute['group_name'],
					"group_type"=>"dropdown",
					"public_group_name"=>$attribute['public_group_name'],
					"attributes" => 
						array("0"=>
							array(
							"id_attribute"=>$attribute['id_attribute'],
							"attribute_name"=>$attribute['attribute_name'],
							"attribute_color"=>$attribute['attribute_color'],
							"image_upload_attr"=>(isset($attribute['image_upload_attr'])?$attribute['image_upload_attr']:'')
							)
						)
					);
			}
		}
		//print_r($ordered_list_new);
		//print_r($ordered_list);
		$rg = 0;
		foreach ($ordered_list AS $key => $group)
		{
			
			if (!isset($group['id_attribute_group']) || !isset($ordered_list_new[$group['id_attribute_group']]))
			{
				unset($ordered_list[$key]);
				$rg++;
				//print "######Removing Group $key<br />\n\r";
			}
			else
			{
				if ($rg > 0)
				{
					$ordered_list[$key-$rg] = $ordered_list[$key];
					unset($ordered_list[$key]);
				}
				$ri = 0;
				//print_r($ordered_list_new[$group['id_attribute_group']]);
				foreach ($group['attributes'] AS $akey => $attribute)
				{
					if (!in_array($attribute['id_attribute'], $ordered_list_new[$group['id_attribute_group']]))
					{
						//print "\n\r!!!!!! ".$group['id_attribute_group']." - ".$ordered_list_new[$group['id_attribute_group']]." !!! ".$attribute['id_attribute']." == ".$ordered_list_new[$group['id_attribute_group']][$attribute['id_attribute']]."\n\r\n\r";
						unset($ordered_list[$key]['attributes'][$akey]);
						$ri++;
					}
					else if($ri > 0)
					{
						$ordered_list[$key]['attributes'][$akey-$ri] = $ordered_list[$key]['attributes'][$akey];
						unset($ordered_list[$key]['attributes'][$akey]);
					}
				}
			}
		}
		//print_r($ordered_list);
		Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'awp_attribute_wizard_pro` SET awp_attributes = "'.addslashes(serialize($ordered_list)).'"');
		return $ordered_list;
	}
	
	public function isInGroup($id_ag, $groups)
	{
		foreach ($groups AS $order => $ag)
			if ($ag['id_attribute_group'] == $id_ag)
				return $order;
		return -1; 
	}
	
	public function isInAttribute($id_a, $attributes)
	{
		foreach ($attributes AS $order => $a)
			if (isset($a['id_attribute']) && $a['id_attribute'] == $id_a)
				return $order;
		return -1; 
	}
	
	private function getAttributeValue($id, $attributes)
	{
		$val_arr = explode('<span class=awp_mark_'.$id.'>', $attributes);
		if (sizeof($val_arr) == 2)
		{
			$val_arr = explode('</span class=awp_mark_'.$id.'', $val_arr[1]);
			return str_replace("<br />","\n",$val_arr[0]);
		}
		return false;
	}
	
	private function getAttributeFileValue($id, $attributes)
	{
		$val_arr = explode('<span class=awp_mark_'.$id.'>', $attributes);
		if (sizeof($val_arr) == 2)
		{
			$val_arr = explode('</span class=awp_mark_'.$id.'', $val_arr[1]);
			$val_arr = explode('"',$val_arr[1]);
			return isset($val_arr[1])?$val_arr[1]:false;
		}
		return false;
	}
	
	function hookAwpProduct($params)
	{
		global $page_name,$smarty;
		if ($page_name == '')
			$page_name = $this->comparePSV('>=', 1.4) && Configuration::get('PS_FORCE_SMARTY_2') == 0?$smarty->tpl_vars['page_name']->value:$smarty->get_template_vars('page_name');
		if ($page_name != "product")
			return;
		return $this->hookProductFooter($params);
	}
	
	function hookProductFooter($params)
	{
		global $smarty, $cookie, $cart, $link;
		$currency = array_key_exists('id_currency',$params)?$_REQUEST['id_currency']:($cookie->id_currency?$cookie->id_currency:$params['id_currency']);
		if (!$currency)
			$currency = Configuration::get('PS_CURRENCY_DEFAULT');
		$product = new Product((int)$_GET['id_product'], true, (int)$cookie->id_lang);
		$query = 'SELECT SUM(`quantity`)
			FROM `'._DB_PREFIX_.'cart_product`
			WHERE `id_product` = '.(int)($_GET['id_product']).' AND `id_cart` = '.(int)($cart->id);
		if ($this->comparePSV('<', 1.2))
		{
			$cart_quantity = !$cart ? 0 : Db::getInstance()->executeS($query);
			if (is_array($cart_quantity))
				$cart_quantity = $cart_quantity[0]['qty'];
		}
		else if ($this->comparePSV('<', 1.4))
			$cart_quantity = !$cart ? 0 : Db::getInstance()->getValue($query);
		else
			$cart_quantity = !$cart ? 0 : Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
		$product_features = Product::getFrontFeaturesStatic($cookie->id_lang, $_GET['id_product']);
		$quantity = $cart_quantity ? $cart_quantity : 1;
		if ($product->hasAttributes() <= 0)
			return;
		if ($this->_awp_display_wizard != 1)
		{
			if ($this->_awp_display_wizard_field == "Reference" && $this->_awp_display_wizard_value != $product->reference)
				return;
			if ($this->_awp_display_wizard_field == "Supplier Reference" && $this->_awp_display_wizard_value != $product->supplier_reference)
				return;
			if ($this->_awp_display_wizard_field == "EAN13" && $this->_awp_display_wizard_value != $product->ean13)
				return;
			if ($this->_awp_display_wizard_field == "UPC" && $this->_awp_display_wizard_value != $product->upc)
				return;
			if ($this->_awp_display_wizard_field == "Location" && $this->_awp_display_wizard_value != $product->location)
				return;
		}
		$use_stock = Configuration::get('PS_STOCK_MANAGEMENT');
		// PS 1.5 has a difference stock system.
		/* Filter using id_dhop */
		if ($this->comparePSV('>=', 1.5))
			$query = '
			SELECT ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name,
			a.`color` AS attribute_color, pa.`id_product_attribute`, '.($use_stock?'stock.`quantity`,':'').' pa.`price`, pa.`ecotax`, pa.`weight`, pa.`default_on`, pa.`reference`
			FROM `'._DB_PREFIX_.'product_attribute` pa
			'.Shop::addSqlAssociation('product_attribute', 'pa').'
			'.Product::sqlStock('pa', 'pa').'
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` pas ON pas.`id_product_attribute` = pa.`id_product_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
			LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
			WHERE pa.`id_product` = '.intval($product->id).'
			AND pas.id_shop = '.(int)$this->context->shop->id.'
			AND al.`id_lang` = '.(int)$this->context->cookie->id_lang.'
			AND agl.`id_lang` = '.(int)$this->context->cookie->id_lang.'
			ORDER BY agl.`public_name`, pa.id_product_attribute DESC, default_on ASC';
		else
			$query = '
			SELECT ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name,
			a.`color` AS attribute_color, pa.`id_product_attribute`, pa.`quantity`, pa.`price`, pa.`ecotax`, pa.`weight`, pa.`default_on`, pa.`reference`
			FROM `'._DB_PREFIX_.'product_attribute` pa
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
			LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
			LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
			WHERE pa.`id_product` = '.intval($product->id).'
			AND al.`id_lang` = '.(int)$cookie->id_lang.'
			AND agl.`id_lang` = '.(int)($cookie->id_lang).'
			ORDER BY agl.`public_name`, pa.id_product_attribute DESC, default_on ASC';
		
		$attributesGroups = Db::getInstance()->ExecuteS($query);
		//print $query;
		//print_r($attributesGroups);
		if (Db::getInstance()->numRows())
		{
			$groups = array();
			$master = false;
			$default_on = array();
			foreach ($attributesGroups AS $k => $row)
			{
				/* Color management */
				if (isset($row['attribute_color']) AND $row['attribute_color'] AND $row['id_attribute_group'] == $product->id_color_default)
				{
					$colors[$row['id_attribute']]['value'] = $row['attribute_color'];
					$colors[$row['id_attribute']]['name'] = $row['attribute_name'];
				}
				$group_order = $this->isInGroup($row['id_attribute_group'],$this->_awp_attributes);
				if ($group_order == -1)
					continue;
				$groups[$group_order]['id_group'] = $row['id_attribute_group'];
				$groups[$group_order]['group_type'] = $this->_awp_attributes[$group_order]['group_type'];
				if ($this->_awp_attributes[$group_order]['group_type'] == "checkbox")
					$groups[$group_order]['group_header'] = htmlspecialchars_decode($this->_awp_attributes[$group_order]['group_header_'.$cookie->id_lang]);
				if (isset($this->_awp_attributes[$group_order]['group_max_limit']))
					$groups[$group_order]['group_max_limit'] = $this->_awp_attributes[$group_order]['group_max_limit'];
				if (isset($this->_awp_attributes[$group_order]['group_required']))
					$groups[$group_order]['group_required'] = $this->_awp_attributes[$group_order]['group_required'];
				if (isset($this->_awp_attributes[$group_order]['image_upload']))
					$groups[$group_order]['image_upload'] = $this->_awp_attributes[$group_order]['image_upload'];
				if (isset($this->_awp_attributes[$group_order]['group_url']))
					$groups[$group_order]['group_url'] = $this->_awp_attributes[$group_order]['group_url'];
				if (isset($this->_awp_attributes[$group_order]['group_color']))
					$groups[$group_order]['group_color'] = $this->_awp_attributes[$group_order]['group_color'];
				if (isset($this->_awp_attributes[$group_order]['group_width']))
					$groups[$group_order]['group_width'] = $this->_awp_attributes[$group_order]['group_width'];
				if (isset($this->_awp_attributes[$group_order]['group_height']))
					$groups[$group_order]['group_height'] = $this->_awp_attributes[$group_order]['group_height'];
				if (isset($this->_awp_attributes[$group_order]['group_resize']))
					$groups[$group_order]['group_resize'] = $this->_awp_attributes[$group_order]['group_resize'];
				if (isset($this->_awp_attributes[$group_order]['group_layout']))
					$groups[$group_order]['group_layout'] = $this->_awp_attributes[$group_order]['group_layout'];
				if (isset($this->_awp_attributes[$group_order]['group_per_row']))
					$groups[$group_order]['group_per_row'] = $this->_awp_attributes[$group_order]['group_per_row'];
				if (isset($this->_awp_attributes[$group_order]['group_hide_name']))
					$groups[$group_order]['group_hide_name'] = $this->_awp_attributes[$group_order]['group_hide_name'];
				if (isset($this->_awp_attributes[$group_order]['group_calc_min']))
					$groups[$group_order]['group_calc_min'] = $this->_awp_attributes[$group_order]['group_calc_min'];
				if (isset($this->_awp_attributes[$group_order]['group_calc_max']))
					$groups[$group_order]['group_calc_max'] = $this->_awp_attributes[$group_order]['group_calc_max'];
				if (isset($this->_awp_attributes[$group_order]['group_calc_multiply']) && $this->_awp_attributes[$group_order]['group_type'] == "calculation")
					$groups[$group_order]['group_calc_multiply'] = $this->getFeatureVal($cookie->id_lang, $product->id, $this->_awp_attributes[$group_order]['group_calc_multiply']);
				if (isset($this->_awp_attributes[$group_order]['group_quantity_zero']))
					$groups[$group_order]['group_quantity_zero'] = $this->_awp_attributes[$group_order]['group_quantity_zero'];
				if (isset($this->_awp_attributes[$group_order]['group_description_'.$cookie->id_lang]))
				{
					$groups[$group_order]['group_description'] = htmlspecialchars_decode($this->_awp_attributes[$group_order]['group_description_'.$cookie->id_lang]);
					if (substr_count($groups[$group_order]['group_description'],"<") < 2)
					$groups[$group_order]['group_description'] = nl2br($groups[$group_order]['group_description']);
				}
				if (isset($this->_awp_attributes[$group_order]['group_file_ext']))
					$groups[$group_order]['group_file_ext'] = $this->_awp_attributes[$group_order]['group_file_ext'];
				$attribute_order = $this->isInAttribute($row['id_attribute'],$this->_awp_attributes[$group_order]["attributes"]);
				$groups[$group_order]['attributes'][$attribute_order] = array($row['id_attribute'],$row['attribute_name'],((isset($this->_awp_attributes[$group_order]['group_color']) && $this->_awp_attributes[$group_order]['group_color']==1)?$row['attribute_color']:""), (isset($this->_awp_attributes[$group_order]['attributes'][$attribute_order]['image_upload_attr'])?$this->_awp_attributes[$group_order]['attributes'][$attribute_order]['image_upload_attr']:''));
				$groups[$group_order]['name'] = $row['public_group_name'];
				if ($row['default_on'])
				{
					if (isset($groups[$group_order]['default']))
						array_push($groups[$group_order]['default'],intval($row['id_attribute']));
					else 
						$groups[$group_order]['default'] = array(intval($row['id_attribute']));
					if (!isset($groups[$group_order]['attributes_quantity'][$row['id_attribute']]))
					{
						$groups[$group_order]['attributes_quantity'][$row['id_attribute']] = intval($row['quantity']);
						$default_on[$row['id_attribute']] = 1;
					}
						
				}
				else
				{
					if (!isset($groups[$group_order]['attributes_quantity'][$row['id_attribute']]) || array_key_exists($row['id_attribute'], $default_on))
					{
						$groups[$group_order]['attributes_quantity'][$row['id_attribute']] = 0;
						unset($default_on[$row['id_attribute']]);
					}
					$groups[$group_order]['attributes_quantity'][$row['id_attribute']] += intval($row['quantity']);
				}
			}
			$ins = Tools::getValue('ins');
			$awp_qty_edit = 0;
			$awp_is_edit = 0;
			$awp_edit_special_values = array();
			if ($ins != '')
			{
				//print 'SELECT * FROM `'._DB_PREFIX_.'cart_product` WHERE id_product = '.$product->id.' AND id_product_attribute = '.Tools::getValue('ipa').' AND instructions_valid = "'.$ins.'"';
				$ids = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'cart_product` WHERE id_product = '.$product->id.' AND id_product_attribute = '.Tools::getValue('ipa').' AND instructions_valid = "'.$ins.'"');
				if (is_array($ids) && sizeof($ids) > 0)
				{
					$ids_array = explode(",", substr($ids[0]['instructions_id'],1));
					$awp_text = $ids[0]['instructions'];
					$awp_qty_edit = $ids[0]['quantity'];
					$awp_is_edit = 1;
					foreach ($groups AS $key => $val)
					{	
						$arr = $val['attributes'];
						if (!is_array($arr))
							$arr = array();
						ksort($arr);
						$groups[$key]['attributes'] = $arr;
						$groups[$key]['default'] = array();
						foreach ($ids_array as $ids)
							if ($this->isInAttribute($ids, $this->_awp_attributes[$key]["attributes"]) != -1)
							{
								if (in_array($val['group_type'], array("textbox","textarea","file")))
								{
									//print "$awp_text<br />";
									if ($text_val = $this->getAttributeValue($ids, $awp_text))
										$awp_edit_special_values[$ids] = $text_val;
									if ($text_val = $this->getAttributeFileValue($ids, $awp_text))
										$awp_edit_special_values[$ids.'_file'] = $text_val;
								}
									//$text = explode($this->_awp_attributes[$key]["attributes"]['attribute_name'], $string)
								$groups[$key]['default'][] = $ids;
									
							}
					}
				}
			}
			else
			{
				foreach ($groups AS $key => $val)
				{
					$arr = $val['attributes'];
					if (!is_array($arr))
						$arr = array();
					ksort($arr);
					$groups[$key]['attributes'] = $arr;
					//print_r($arr);
					//if ($groups[$key]['group_type'] != "checkbox" && $groups[$key]['group_type'] != "quantity" && !array_key_exists('default',$val) && array_key_exists('0',$arr))
					if (($val['group_type'] == "radio" || $val['group_type'] == "dropdown") && !isset($val['default']) && isset($arr['0']))
						$groups[$key]['default'] = array($arr[0][0]);
					elseif (!isset($val['default']))
						$groups[$key]['default'] = array();
				}
			}
			$smarty->assign("awp_is_edit", $awp_is_edit);
			$smarty->assign("awp_qty_edit", $awp_qty_edit);
			ksort($groups);
			//print print_r($groups,true);
			if (Configuration::get('PS_FORCE_SMARTY_2') || $this->comparePSV('<', 1.4))
			{
				$smarty->register_function('getGroupImageTag', array('AttributeWizardPro', 'getGroupImageTag'));
				$smarty->register_function('getLayeredImageTag', array('AttributeWizardPro', 'getLayeredImageTag'));
			}
			else
			{
				if (!isset($smarty->registered_plugins['function']['getGroupImageTag'])) { 
					$smarty->registerPlugin('function','getGroupImageTag', array('AttributeWizardPro', 'getGroupImageTag')); // or keep a backward compatibility if PHP version < 5.1.2
				
				}
				if (!isset($smarty->registered_plugins['function']['getLayeredImageTag'])) { 
					$smarty->registerPlugin('function','getLayeredImageTag', array('AttributeWizardPro', 'getLayeredImageTag')); // or keep a backward compatibility if PHP version < 5.1.2
				}
			}
			if ($this->comparePSV('<', 1.4))
			{
				$result = Db::getInstance()->getRow('
					SELECT  t.`rate`
					FROM `'._DB_PREFIX_.'product` p
					LEFT JOIN `'._DB_PREFIX_.'tax` AS t ON t.`id_tax` = p.`id_tax`
					WHERE p.`id_product` = '.intval($_GET['id_product']));
				$tax_rate = $result['rate'];
			}
			if ($this->comparePSV('<', 1.5))
			{
				$query = 'SELECT pa.id_product, pa.price, pa.weight, '.($this->comparePSV('<', 1.4)?'1 as minimal_quantity':'pa.minimal_quantity').', pac.id_attribute
					FROM `'._DB_PREFIX_.'product_attribute` AS pa, `'._DB_PREFIX_.'product_attribute_combination` AS pac
					WHERE pa.default_on = 0 AND pa.id_product_attribute = pac.id_product_attribute AND pa.id_product = ' . intval($_GET['id_product']) .' GROUP BY pac.id_attribute';
				$attribute_impact = Db::getInstance()->ExecuteS($query);
				$query = 'SELECT pa.id_product, pa.price, pa.weight, '.($this->comparePSV('<', 1.4)?'1 as minimal_quantity':'pa.minimal_quantity').', pac.id_attribute
					FROM `'._DB_PREFIX_.'product_attribute` AS pa, `'._DB_PREFIX_.'product_attribute_combination` AS pac
					WHERE pa.default_on = 1 AND pa.id_product_attribute = pac.id_product_attribute AND pa.id_product = ' . intval($_GET['id_product']) .' GROUP BY pac.id_attribute';
				$attribute_impact_default = Db::getInstance()->ExecuteS($query);
			}
			else
			{
				/* Filter using id_dhop */
				$query = 'SELECT pa.id_product, pas.price, pas.weight, pas.minimal_quantity, pac.id_attribute
					FROM `'._DB_PREFIX_.'product_attribute` AS pa,`'._DB_PREFIX_.'product_attribute_shop` AS pas, `'._DB_PREFIX_.'product_attribute_combination` AS pac
					WHERE pas.id_shop = '.(int)$this->context->shop->id.' AND pas.default_on = 0 AND pas.id_product_attribute = pac.id_product_attribute AND pas.id_product_attribute = pa.id_product_attribute AND pa.id_product = ' . (int)$_GET['id_product'] .' GROUP BY pac.id_attribute';
				$attribute_impact = Db::getInstance()->ExecuteS($query);
				$query = 'SELECT pa.id_product, pas.price, pas.weight, pas.minimal_quantity, pac.id_attribute
					FROM `'._DB_PREFIX_.'product_attribute` AS pa,`'._DB_PREFIX_.'product_attribute_shop` AS pas, `'._DB_PREFIX_.'product_attribute_combination` AS pac
					WHERE pas.id_shop = '.(int)$this->context->shop->id.' AND pas.default_on = 1 AND pas.id_product_attribute = pac.id_product_attribute AND pas.id_product_attribute = pa.id_product_attribute AND pa.id_product = ' . (int)$_GET['id_product'] .' GROUP BY pac.id_attribute';
				$attribute_impact_default = Db::getInstance()->ExecuteS($query);
			}
			foreach ($attribute_impact_default as $drow)
			{
				$found = false;
				foreach ($attribute_impact as $row)
					if ($drow['id_attribute'] == $row['id_attribute'])
					{
						$found = true;
						break;
					}
				if (!$found)
					array_push($attribute_impact, $drow);
			}
			//	print_r($product);
			//print_r($attribute_impact_default);
			//print_r($this->_awp_attributes);
			//print_r($groups);
			$awp_currency = Currency::getCurrency($currency);
			//print_r($awp_edit_special_values);
			$smarty->assign("awp_add_to_cart", $this->_awp_add_to_cart);
			$smarty->assign("awp_out_of_stock", $this->_awp_out_of_stock);
			$smarty->assign("awp_ins", Tools::getValue('ins'));
			$smarty->assign("awp_ipa", Tools::getValue('ipa'));
			// Check for popup image display selection
			if ($this->_awp_popup_image && $this->comparePSV('>=', 1.4))
			{
				$tmp_pit =  explode('|||', $this->_awp_popup_image_type);
				$cover = Product::getCover($product->id);
				if (is_array($cover) && sizeof($cover) == 1)
				{
					$img_src = $link->getImageLink($product->link_rewrite, $product->id.'-'.$cover['id_image'], $tmp_pit[0]);
					$awp_product_image = array('src' => $img_src);
					$tmp_pit = explode('x', $tmp_pit[1]);
					$awp_product_image['width'] = $tmp_pit[0];
					$awp_product_image['height'] = $tmp_pit[1];
					$smarty->assign("awp_product_image", $awp_product_image);
				}
			}
			$smarty->assign(array(
				'col_img_dir' => _PS_COL_IMG_DIR_,								  
				'this_wizard_path' => __PS_BASE_URI__.'modules/attributewizardpro/',
				'awp_stock' => $this->comparePSV('<', 1.4)?Configuration::get('PS_STOCK_MANAGEMENT'):(!Configuration::get('PS_DISPLAY_QTIES') || $product->quantity <= 0 || !$product->available_for_order || Configuration::get('PS_CATALOG_MODE')?'':1),
				'awp_display_qty' => Configuration::get('PS_DISPLAY_QTIES'),
				'awp_pi_display' => $this->_awp_pi_display,
				'groups' => $groups,
				'awp_ajax' => Configuration::get('PS_BLOCK_CART_AJAX'),
				'awp_no_customize' => intval($this->_awp_no_customize),
				'awp_second_add' => intval($this->_awp_second_add),
				'awp_popup' => intval($this->_awp_popup),
				'awp_fade' => intval($this->_awp_fade),
				'awp_opacity' => intval($this->_awp_opacity),
				'awp_opacity_fraction' => intval($this->_awp_opacity) / 100,
				'awp_popup_width' => intval($this->_awp_popup_width),
				'awp_popup_top' => intval($this->_awp_popup_top),
				'awp_popup_left' => intval($this->_awp_popup_left),
				'awp_no_tax_impact' => intval($this->_awp_no_tax_impact),
				'awp_adc_no_attribute' => intval($this->_awp_adc_no_attribute),
				'awp_edit_special_values' => $awp_edit_special_values,
				'attributeImpacts' => $attribute_impact,
				'awp_currency' => $awp_currency,
				'awp_converted_price' => $this->comparePSV('==', '1.3.6')?1:0,
				'awp_psv' => $this->getPSV(),
				'awp_psv3' => substr(_PS_VERSION_,0,5).(substr(_PS_VERSION_,5,1) != "."?substr(_PS_VERSION_,5,1):""),
				'awp_reload_page' => $this->comparePSV('>=', 1.4) && Configuration::get('PS_CART_REDIRECT') == 0?1:0,
				'awp_currency_rate' => $awp_currency['conversion_rate']));
		return $this->display(__FILE__, 'attributewizardpro.tpl');
		}
	}

	function hookNewOrder($params)
	{
		global $cookie;
		$cart = $params['cart'];
		foreach ($cart->getProducts() AS $product)
		{
			if ($this->_awp_display_wizard != 1)
			{
				$productO = new Product($product['id_product'], true, intval($cookie->id_lang));
				if ($this->_awp_display_wizard_field == "Reference" && $this->_awp_display_wizard_value != $productO->reference)
					continue;
				if ($this->_awp_display_wizard_field == "Supplier Reference" && $this->_awp_display_wizard_value != $productO->supplier_reference)
					continue;
				if ($this->_awp_display_wizard_field == "EAN13" && $this->_awp_display_wizard_value != $productO->ean13)
					continue;
				if ($this->_awp_display_wizard_field == "UPC" && $this->_awp_display_wizard_value != $product->upc)
					continue;
				if ($this->_awp_display_wizard_field == "Location" && $this->_awp_display_wizard_value != $productO->location)
					continue;
			}
			if ($product['instructions_id'] == "" || Configuration::get('PS_STOCK_MANAGEMENT') != 1)
				continue;

			if ($this->comparePSV('>=', 1.5))
			{
				$query = 'SELECT pa.id_product_attribute FROM `'._DB_PREFIX_.'product_attribute_combination` AS pac, '._DB_PREFIX_.'product_attribute AS pa
					WHERE
					pac.id_attribute IN ('.substr($product['instructions_id'],1).') AND pac.id_product_attribute = pa.id_product_attribute AND
					pa.id_product = '.$product['id_product'].' '.(substr_count($product['instructions_id'],",") > 1?'AND pa.default_on = 0':'');
				$res = Db::getInstance()->ExecuteS($query);
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "New Order: \n$query\n".print_r($res, true)." \n\r");
//fclose($fh);
				foreach ($res as $id)
				{
					$current_stock = StockAvailable::getQuantityAvailableByProduct($product['id_product'], $id['id_product_attribute'], Context::getContext()->shop->id);
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "Starting removeStock15 (New Order - ".$product['instructions_id'].") ".$product['id_product'].", ".$id['id_product_attribute'].", ".Context::getContext()->shop->id.", ".max($current_stock - $product['cart_quantity'], 0)." ($current_stock - ".$product['cart_quantity'].")\n\r");
//fclose($fh);					
					$this->removeStock15(new Product($product['id_product']), $id['id_product_attribute'], Context::getContext()->shop->id, max($current_stock - $product['cart_quantity'], 0));
				}
			}
			else
			{
				$query = 'UPDATE `'._DB_PREFIX_.'product_attribute_combination` AS pac, '._DB_PREFIX_.'product_attribute AS pa
					SET pa.quantity = GREATEST(pa.quantity - '.$product['cart_quantity'].',0)
					WHERE
					pac.id_attribute IN ('.substr($product['instructions_id'],1).') AND pac.id_product_attribute = pa.id_product_attribute AND
					pa.id_product = '.$product['id_product'].' '.(substr_count($product['instructions_id'],",") > 1?'AND pa.default_on = 0':'');
				Db::getInstance()->Execute($query);
			}			
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "Starting deleteAttributeCombination ".$product['id_product_attribute']."\n\r");
//fclose($fh);
			//$productToDelete = new Product($product['id_product']);
			//$productToDelete->deleteAttributeCombination($product['id_product_attribute']);
		}
	}
	
	function hookHeader()
	{
		global $smarty, $cookie;
		$ps_version  = floatval(substr(_PS_VERSION_,0,3));
		$smarty->assign("awp_url_rewrite", (int)Configuration::get('PS_REWRITING_SETTINGS'));
		if (!array_key_exists('id_product',$_GET))
			return;
		$product = new Product(intval($_GET['id_product']), true, intval($cookie->id_lang));
		if ($product->hasAttributes() <= 0)
			return;
		if ($this->_awp_display_wizard != 1)
		{
			if ($this->_awp_display_wizard_field == "Reference" && $this->_awp_display_wizard_value != $product->reference)
				return;
			if ($this->_awp_display_wizard_field == "Supplier Reference" && $this->_awp_display_wizard_value != $product->supplier_reference)
				return;
			if ($this->_awp_display_wizard_field == "EAN13" && $this->_awp_display_wizard_value != $product->ean13)
				return;
			if ($this->_awp_display_wizard_field == "UPC" && $this->_awp_display_wizard_value != $product->upc)
				return;
			if ($this->_awp_display_wizard_field == "Location" && $this->_awp_display_wizard_value != $product->location)
				return;
		}
		if ($this->comparePSV('<', 1.4))
			$smarty->assign("awp_include_files", true);
		else
		{
			if ($this->comparePSV('<', 1.5)){
				Tools::addCSS(($this->_path).'css/awp.css', 'all');
				Tools::addJS(($this->_path).'js/awp_product.js');
			}else{
				$this->context->controller->addCSS(($this->_path).'css/awp.css', 'all');
				$this->context->controller->addJS(($this->_path).'js/awp_product.js');
			}
		}
		
		$smarty->assign("awp_add_to_cart", $this->_awp_add_to_cart);
		return $this->display(__FILE__, 'header.tpl');
	}
	
	function hookFooter()
	{
		global $smarty;
		$page_name = $this->comparePSV('>=', 1.4) && !Configuration::get('PS_FORCE_SMARTY_2')?$smarty->tpl_vars['page_name']->value:$smarty->get_template_vars('page_name');
		if (!in_array($page_name, array('index', 'category', 'supplier', 'manufacturer', 'prices-drop', 'specials', 'new-products', 'search')))
			return;
		$smarty->assign(array("awp_disable_hide" => $this->_awp_disable_hide));
		return $this->display(__FILE__, 'footer.tpl');
	}
	
	function getGroupImage($id_group, $filename = false)
	{	
		$id = $this->isInGroup($id_group,$this->_awp_attributes);
		if ($id < 0)
			return false;
		$v = array_key_exists("image_upload",$this->_awp_attributes[$id])?$this->_awp_attributes[$id]['image_upload']:"";
		$dir = ($filename?'':_MODULE_DIR_.'attributewizardpro/img/');
		if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.gif'))
			return $dir.'id_group_'.$id_group.'.gif'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.png'))
			return $dir.'id_group_'.$id_group.'.png'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.jpg'))
			return $dir.'id_group_'.$id_group.'.jpg'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.jpeg'))
			return $dir.'id_group_'.$id_group.'.jpeg'.($filename?'':'?v='.$v);
		else
			return false;
	}

	public static function getGroupImageTag($id_group)
	{
		if (is_array($id_group))
			$alt = $id_group['alt'];
		if (is_array($id_group))
			$v = $id_group['v'];
		if (is_array($id_group))
			$id_group = $id_group['id_group'];
		if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.gif'))
		{
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_group_'.$id_group.'.gif?v='.$v;
			$serverfile = dirname(__FILE__).'/img/id_group_'.$id_group.'.gif';
		}
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.png'))
		{
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_group_'.$id_group.'.png?v='.$v;
			$serverfile = dirname(__FILE__).'/img/id_group_'.$id_group.'.png';
		}
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.jpg'))
		{
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_group_'.$id_group.'.jpg?v='.$v;
			$serverfile = dirname(__FILE__).'/img/id_group_'.$id_group.'.jpg';
		}
		else if (is_file(dirname(__FILE__).'/img/id_group_'.$id_group.'.jpeg'))
		{
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_group_'.$id_group.'.jpeg?v='.$v;
			$serverfile = dirname(__FILE__).'/img/id_group_'.$id_group.'.jpeg';
		}
		if (isset($filename))
		{
			list($width, $height, $type, $attr) = getimagesize($serverfile);
			return "<img border=\"0\" src=\"$filename\" width=\"$width\" height=\"$height\" alt=\"$alt\" class=\"awp_gi\" />";
		}
		else
			return false;
	}
	
	public function getLayeredImage($id_attribute, $filename = false, $pos)
	{	
		if (!isset($this->_awp_attributes[$pos]))
			return;
		$id = $this->isInAttribute($id_attribute, $this->_awp_attributes[$pos]['attributes']);
		$v = array_key_exists("image_upload_attr",$this->_awp_attributes[$pos]['attributes'][$id])?$this->_awp_attributes[$pos]['attributes'][$id]['image_upload_attr']:"";
		$dir = ($filename?'':_MODULE_DIR_.'attributewizardpro/img/');
		if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.gif'))
			return $dir.'id_attribute_'.$id_attribute.'.gif'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.png'))
			return $dir.'id_attribute_'.$id_attribute.'.png'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.jpg'))
			return $dir.'id_attribute_'.$id_attribute.'.jpg'.($filename?'':'?v='.$v);
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.jpeg'))
			return $dir.'id_attribute_'.$id_attribute.'.jpeg'.($filename?'':'?v='.$v);
		else
			return false;
	}

	public static function getLayeredImageTag($id_attribute)
	{
		if (is_array($id_attribute))
			$v = $id_attribute['v'];
		if (is_array($id_attribute))
			$id_attribute = $id_attribute['id_attribute'];
		if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.gif'))
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_attribute_'.$id_attribute.'.gif?v='.$v;
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.png'))
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_attribute_'.$id_attribute.'.png?v='.$v;
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.jpg'))
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_attribute_'.$id_attribute.'.jpg?v='.$v;
		else if (is_file(dirname(__FILE__).'/img/id_attribute_'.$id_attribute.'.jpeg'))
			$filename = _MODULE_DIR_.'attributewizardpro/img/id_attribute_'.$id_attribute.'.jpeg?v='.$v;
		if (isset($filename))
			return "$filename";
		else
			return false;
	}
	
	private function fileCheckLines($lfile, $mfile, $lines, $ps_version, $extra = "")
	{
		$return = "";
    	// Cart.php
    	if (!file_exists(_PS_ROOT_DIR_.$lfile))
    		return '<b style="color:red">'.$lfile.'</b> '.($extra != ""?"<b>$extra</b>":"").' - '.$this->l('Copy entire file');
    	$server_file = @file_get_contents(_PS_ROOT_DIR_.$lfile);
		$all_good = true;
   		$module_lines = file(_PS_ROOT_DIR_."/modules/attributewizardpro/modified_".$ps_version.$mfile);
   		foreach ($lines AS $line)
   		{
			if (sizeof($module_lines) <= 1)
			{
    				$all_good = false;
    				$line_good = false;
    				break;
			}
   			$start = "";
   			$end = "";
   			if (strpos($line, "-") === false)
   			{
   				$start = max($line-1, 0);
   				$end = min($line+1, sizeof($module_lines)-1);
   			}
   			else
   			{
   				$tmp_arr = explode("-", $line);
   				$start = max(intval($tmp_arr[0])-1, 0);
   				$end = min(intval($tmp_arr[1]+1), sizeof($module_lines)-1);
   			}
   			$line_good = true;
   			for ($i = $start; $i <= $end ; $i++)
   			{
   				//print "$i) !".$module_lines[$i]."! <br />\n\r @".substr($server_file,0,100)."#<br/>\n\r";
   				if (trim($module_lines[$i]) == "" || strpos($server_file, trim($module_lines[$i])) !== false)
    			{
    				if (trim($module_lines[$i]) != "")
    					$server_file = substr($server_file,strpos($server_file, trim($module_lines[$i]))+1);
    			}
    			else
    			{
    				$all_good = false;
    				$line_good = false;
    				break;
    			}
   			}
   			$return .= ($return != ''?', ':'').'<span style="color:'.($line_good?'green':'red').'">'.$line.'</span>';
   		}
   		$return = '<b style="color:'.($all_good?'green':'red').'">'.$lfile.'</b> '.($extra != ""?"<b>$extra</b>":"").' - '.$this->l('Lines').' #'.$return;
    	return $return;
	}
	
	/*
	 * This function is used to retrieve an exising id_product attribute for a given product based on all the selected attributes (in $ids)
	 * If the combination does not exist, we will generate it. 
	 */
	public function getIdProductAttribute($id_product, $ids)
	{
		global $cookie;
//$myFile = dirname(__FILE__)."/2_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "Starting getIdProductAttribute $id_product, $ids\n\r");
//fclose($fh);
		$use_stock = Configuration::get('PS_STOCK_MANAGEMENT');
		if ($this->comparePSV('>=', 1.5))
			$query = 'SELECT pac.id_attribute, '.($use_stock?'sa.quantity,':'').' pa.minimal_quantity, pa.price, pa.weight,
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '.($use_stock?_DB_PREFIX_.'stock_available AS sa,':'').' '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				'.($use_stock?'AND pa.`id_product_attribute` = sa.`id_product_attribute`':'').'
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 0';
		else
			$query = 'SELECT pac.id_attribute, pa.quantity, pa.minimal_quantity, pa.price, pa.weight,
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 0';
		$result = Db::getInstance()->ExecuteS($query);
		$attribute_impact = array();
		foreach ($result AS $row)
		{
			$attribute_impact[$row['id_attribute']]['quantity'] = $row['quantity'];
			$attribute_impact[$row['id_attribute']]['minimal_quantity'] = $row['minimal_quantity'];
			$attribute_impact[$row['id_attribute']]['price'] = $row['price'];
			$attribute_impact[$row['id_attribute']]['weight'] = $row['weight'];
			$attribute_impact[$row['id_attribute']]['attribute'] = $row['attribute_name'];
			$attribute_impact[$row['id_attribute']]['group'] = $row['public_group_name'];
		}
		// Get attributes for the default group, and use only if not already used in the query above
		if ($this->comparePSV('>=', 1.5))
			$query = 'SELECT pac.id_attribute, '.($use_stock?'sa.quantity,':'').' pa.minimal_quantity, pa.price, pa.weight,
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '.($use_stock?_DB_PREFIX_.'stock_available AS sa,':'').' '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				'.($use_stock?'AND pa.`id_product_attribute` = sa.`id_product_attribute`':'').'
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 1';
		else
			$query = 'SELECT pac.id_attribute, pa.quantity, pa.minimal_quantity, pa.price, pa.weight,
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 1';
		$result = Db::getInstance()->ExecuteS($query);
		foreach ($result AS $row)
		{
			if (!array_key_exists($row['id_attribute'], $attribute_impact))
			{
				$attribute_impact[$row['id_attribute']]['quantity'] = $row['quantity'];
				$attribute_impact[$row['id_attribute']]['minimal_quantity'] = $row['minimal_quantity'];
				$attribute_impact[$row['id_attribute']]['price'] = $row['price'];
				$attribute_impact[$row['id_attribute']]['weight'] = $row['weight'];
				$attribute_impact[$row['id_attribute']]['attribute'] = $row['attribute_name'];
				$attribute_impact[$row['id_attribute']]['group'] = $row['public_group_name'];
			}
		}
//$myFile = dirname(__FILE__)."/2_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "calculated attribute impact\n\r");
//fclose($fh);
		$ids = substr($ids,1);
		$id_arr = explode(",", $ids);
		$price_impact = 0;
		$weight_impact = 0;
		$quantity_available = 0;
		$cur_quantity_minimal = 1;
		$first = true;
		foreach ($id_arr as $id_attribute)
		{
			$cur_price_impact = $attribute_impact[$id_attribute]['price'];
			$cur_weight_impact = $attribute_impact[$id_attribute]['weight'];
			$cur_quantity_available = $attribute_impact[$id_attribute]['quantity'];
			$cur_quantity_minimal = max($attribute_impact[$id_attribute]['minimal_quantity'], $cur_quantity_minimal);
			
			$price_impact += $cur_price_impact;
			$weight_impact += $cur_weight_impact;
			if ($first)
			{
				$quantity_available = $cur_quantity_available;
				$first = false;
			}
			else
				$quantity_available = min($quantity_available, $cur_quantity_available);
		}
		$id_image = 0;
		$query = 'SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.$ids.') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$id_product.' ORDER BY pa.default_on ASC';
		$res = Db::getInstance()->ExecuteS($query);
		if (is_array($res) && sizeof($res) > 0)
			$id_image = $res[0]['id_image'];
		$query = "SELECT pa.* FROM "._DB_PREFIX_."product_attribute AS pa, "._DB_PREFIX_."product_attribute_combination AS pac, "._DB_PREFIX_."attribute AS a ".($id_image > 0?", "._DB_PREFIX_."product_attribute_image AS pai":"")." ".
				"WHERE id_product = '".$id_product."' AND price = '".$price_impact."' AND weight = '".$weight_impact."' ".
				"AND a.id_attribute = pac.id_attribute AND pac.id_product_attribute = pa.id_product_attribute ".
				"AND a.id_attribute_group = '".$this->_awp_default_group."' ".
				"AND pa.quantity = ".(intval($quantity_available)).
				($id_image > 0?" AND pac.id_product_attribute = pai.id_product_attribute AND pai.id_image = ".$id_image:"");
				
		$result = Db::getInstance()->ExecuteS($query);
		$id_product_attribute = "";
		foreach ($result AS $k => $row)
			$id_product_attribute = $row['id_product_attribute'];
//$myFile = dirname(__FILE__)."/2_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "Checking id_product_attribute = $id_product_attribute\n\r");
//fclose($fh);
		if ($id_product_attribute == "")
		{
			Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute (id_product, price, weight, quantity) VALUES ('".$id_product."','".$price_impact."','".$weight_impact."','".intval($quantity_available)."')");
			$id_product_attribute = Db::getInstance()->Insert_ID();
			Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_combination (id_attribute, id_product_attribute) VALUES ('$this->_awp_default_item','$id_product_attribute')");
			$res = Db::getInstance()->ExecuteS('SELECT pai.id_image  FROM '._DB_PREFIX_.'product_attribute_combination pac, '._DB_PREFIX_.'product_attribute_image pai, '._DB_PREFIX_.'product_attribute pa WHERE `id_attribute` IN ('.$ids.') AND pac.id_product_attribute = pa.id_product_attribute AND pac.id_product_attribute = pai.id_product_attribute AND pa.id_product = '.$id_product.' ORDER BY pa.default_on ASC');
			if (is_array($res) && sizeof($res) > 0)
				Db::getInstance()->Execute("INSERT INTO "._DB_PREFIX_."product_attribute_image (id_product_attribute, id_image) VALUES ('$id_product_attribute', '".$res[0]['id_image']."')");
			if ($this->comparePSV('>=', 1.5))
			{
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'product_attribute_shop` (`id_product_attribute`, `id_shop`,
					`wholesale_price`, `price`,
					`ecotax`, `weight`,
					`unit_price_impact`, `default_on`,
					`minimal_quantity`,`available_date`)
					VALUES ('.(int)$id_product_attribute.','.(int) Context::getContext()->shop->id.',
					"0", "'.$price_impact.'",
					"0","'.$weight_impact.'",
					"0","0",
					"'.$cur_quantity_minimal.'",  "0000-00-00"	)');
				$stock = (int)$quantity_available < 0 ? 0 : (int)$quantity_available;
//$myFile = dirname(__FILE__)."/2_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "$id_product, $id_product_attribute, ".Context::getContext()->shop->id.", $stock\n\r");
//fclose($fh);
				$this->addStock15(new Product($id_product), $id_product_attribute, Context::getContext()->shop->id, $stock);
			}
		}
		else
		{
			Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product_attribute SET quantity = ".(intval($quantity_available))." WHERE id_product_attribute = '$id_product_attribute'");
			if ($this->comparePSV('>=', 1.5))
			{
				$stock = (int)$quantity_available < 0 ? 0 : (int)$quantity_available;
//$myFile = dirname(__FILE__)."/2_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "STOCK = $stock\n\r");
//fclose($fh);
				$this->removeStock15(new Product($id_product), $id_product_attribute, Context::getContext()->shop->id, $stock);
			}
		}
		return	$id_product_attribute;
	}
	
	public function getFeatureVal($id_lang, $id_product, $id_feature)
	{
		
		$query = 'SELECT fv.value
			FROM '._DB_PREFIX_.'feature_product pf, '._DB_PREFIX_.'feature_value_lang fv
			WHERE pf.id_feature = '.$id_feature.' AND pf.id_product = '.(int)$id_product.' AND
			pf.id_feature_value = fv.id_feature_value AND fv.id_lang = '.$id_lang;
		$arr =  Db::getInstance()->ExecuteS($query);
		return (is_array($arr) && sizeof($arr) > 0?$arr[0]['value']:1);
	}
	
	public function checkCartQuantity($idProduct, $qty, $ins_id)
	{
		global $cookie, $cart;
		$log = false;
		$add = true;
		$ids = explode(",",substr($ins_id,1));
		$attribute_impact = $this->getAttributeImpact($idProduct);
		$query = 'SELECT *
				FROM `'._DB_PREFIX_.'cart_product`
				WHERE `id_product` = '.intval($idProduct).' AND `id_cart` = '.intval($cart->id);
		// 	Get the products from the cart //
		$result = Db::getInstance()->ExecuteS($query);
		if ($log)
		{
			$myFile = dirname(__FILE__)."/1_log.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, "$idProduct, $qty, $ins_id result ($query) = ".print_r($result,true)."\n\r");
			fwrite($fh, "attribute_impact1 = ".print_r($attribute_impact,true)."\n\r");
			fclose($fh);
		}
		foreach ($result as $row)
		{
			$tids = explode(",",substr($row['instructions_id'],1));
			// 	remove cart quantity from total quantity 
			foreach ($tids as $id)
				if (isset($attribute_impact[$id]['quantity']))
					$attribute_impact[$id]['quantity'] -= $row['quantity'];  
		}
		foreach ($ids as $id)
			if (isset($attribute_impact[$id]['quantity']) && $attribute_impact[$id]['quantity'] - $qty < 0)
			{
				if ($log)
				{
					$myFile = dirname(__FILE__)."/1_log.txt";
					$fh = fopen($myFile, 'a') or die("can't open file");
					fwrite($fh, "$id = ".$attribute_impact[$id]['quantity']." - $qty\n\r");
					fclose($fh);
				}
				$add = false;
			}
		if ($log)
		{
			$myFile = dirname(__FILE__)."/1_log.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
			fwrite($fh, "add = $add attribute_impact2 = ".print_r($attribute_impact,true)."\n\r");
			fclose($fh);
		}
		return $add;
	}
	
	function getAttributeImpact($id_product)
	{
		global $cookie;
		$use_stock = Configuration::get('PS_STOCK_MANAGEMENT');
		$ps_version  = floatval(substr(_PS_VERSION_,0,3));
		$log = false;
		if ($this->comparePSV('>=', 1.5))
			$query = 'SELECT pac.id_attribute, '.($use_stock?'sa.quantity,':'').' pa.price, pa.weight,'.($this->comparePSV('>=', 1.4)?'pa.minimal_quantity,':'').' 
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '.($use_stock?_DB_PREFIX_.'stock_available AS sa,':'').' '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				'.($use_stock?'AND pa.`id_product_attribute` = sa.`id_product_attribute`':'').'
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 0';
		else
			$query = 'SELECT pac.id_attribute, pa.quantity, pa.price, pa.weight,'.($this->comparePSV('>=', 1.4)?'pa.minimal_quantity,':'').' 
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 0';
		if ($log)
		{
			$myFile = dirname(__FILE__)."/getAttributeImpact.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, "\n\r".$query);
			fclose($fh);
		}
		$result = Db::getInstance()->ExecuteS($query);
		$attribute_impact = array();
		foreach ($result AS $row)
		{
			$attribute_impact[$row['id_attribute']]['minimal_quantity'] = isset($row['minimal_quantity'])?$row['minimal_quantity']:1;
			$attribute_impact[$row['id_attribute']]['quantity'] = (int)$row['quantity'];
			$attribute_impact[$row['id_attribute']]['price'] = $row['price'];
			$attribute_impact[$row['id_attribute']]['weight'] = $row['weight'];
			$attribute_impact[$row['id_attribute']]['attribute'] = $row['attribute_name'];
			$attribute_impact[$row['id_attribute']]['group'] = $row['public_group_name'];
		}
		// Get attributes for the default group, and use only if not already used in the query above
		if ($this->comparePSV('>=', 1.5))
			$query = 'SELECT pac.id_attribute, '.($use_stock?'sa.quantity,':'').' pa.price, pa.weight,'.($this->comparePSV('>=', 1.4)?'pa.minimal_quantity,':'').' 
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`, al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '.($use_stock?_DB_PREFIX_.'stock_available AS sa,':'').' '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				'.($use_stock?'AND pa.`id_product_attribute` = sa.`id_product_attribute`':'').'
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 1';
		else
			$query = 'SELECT pac.id_attribute, pa.quantity, pa.price, pa.weight,
				ag.`id_attribute_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name, a.`id_attribute`,'.($this->comparePSV('>=', 1.4)?'pa.minimal_quantity,':'').'  al.`name` AS attribute_name
				FROM '._DB_PREFIX_.'product_attribute AS pa, '._DB_PREFIX_.'product_attribute_combination AS pac, '._DB_PREFIX_.'attribute AS a 
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pac.id_product_attribute = pa.id_product_attribute AND pac.id_attribute = a.id_attribute
				AND al.`id_lang` = '.intval($cookie->id_lang).'
				AND agl.`id_lang` = '.intval($cookie->id_lang).'
				AND a.id_attribute_group != '.$this->_awp_default_group.'
				AND pa.id_product = '.$id_product.'
				AND pa.default_on = 1';
		$result = Db::getInstance()->ExecuteS($query);
		foreach ($result AS $row)
		{
			if (!array_key_exists($row['id_attribute'], $attribute_impact))
			{
				$attribute_impact[$row['id_attribute']]['minimal_quantity'] = isset($row['minimal_quantity'])?$row['minimal_quantity']:1;
				$attribute_impact[$row['id_attribute']]['quantity'] = (int)$row['quantity'];
				$attribute_impact[$row['id_attribute']]['price'] = $row['price'];
				$attribute_impact[$row['id_attribute']]['weight'] = $row['weight'];
				$attribute_impact[$row['id_attribute']]['attribute'] = $row['attribute_name'];
				$attribute_impact[$row['id_attribute']]['group'] = $row['public_group_name'];
			}
		}
		if ($log)
		{
			$myFile = dirname(__FILE__)."/getAttributeImpact.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
			fwrite($fh, "\n\r".$query);
			fwrite($fh, "\n\r".print_r($attribute_impact, true));
			fclose($fh);
		}
		return $attribute_impact;
	}
	
		/*
	*	Function for PS 1.5.X - increasing advanced stock management for a product
	*	$product	= Product class
	* 	$id_ac		= Product combination (id_product_combination, 0 if no combination selected or product does not have a combination)
	* 	$id_shop 	= current shop id selected
	*	$stockIncreaseValue = stock value
	*	$id_stock_mvt_reason = reason for changing the stock (1 - increase stock, 2 - decrease stock) 
	* 	$id_employee = logged employee
	*/
	public function addStock15($product, $id_ac, $id_shop, $stock)
	{
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "addStock15((int)$product->id, (int)$id_ac, $stock, $id_shop)\n\r");
//fclose($fh);
		if ($stock <= 0 && Configuration::get('PS_ORDER_OUT_OF_STOCK') == 0 && StockAvailable::outOfStock($product->id, $id_shop) == 0)
			return	$this->removeStock15($product, $id_ac, $id_shop, $stock);
		/* Advanced stock management */
		if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && $product->advanced_stock_management)
		{
			$id_stock_mvt_reason = 1;
			/* Creating the context employee */
			$employee = new Employee(Db::getInstance()->getValue('SELECT id_employee FROM '._DB_PREFIX_.'employee where active = 1 ORDER BY id_employee ASC'));
			$this->context->employee = $employee;
			/* Getting current warehouses for the product id and product combination id */
			$productAttributeWarehouse = Warehouse::getProductWarehouseList($product->id, $id_ac, $id_shop);
			/* If not accosiates witha warehouse, then associate it 
		 	* with the first warehouse we find for the product */
			if (count($productAttributeWarehouse) <= 0)
			{
				$houses = WarehouseProductLocation::getCollection($product->id);
				$id_warehouse = 0;
				foreach ($houses as $warehouse)
					if ($warehouse->id_warehouse > 0)
					{
						$id_warehouse = $warehouse->id_warehouse;
						break;
					}
				if ($id_warehouse == 0)
					return;
			}	
			else
				/* Get first warehouse where to increase the stock for product*/
				$id_warehouse = (int)$productAttributeWarehouse[0]['id_warehouse'];
			$warehouse = new Warehouse($id_warehouse);				
			$wpl_id = (int)WarehouseProductLocation::getIdByProductAndWarehouse($product->id, $id_ac, $id_warehouse);
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "wpl_id = $wpl_id\n\r");
//fclose($fh);
			/* Create a warehouse accosiation for the product combination */ 
			if ($wpl_id <= 0)
			{
			//	create new record
				$warehouse_location_entity = new WarehouseProductLocation();
				$warehouse_location_entity->id_product = $product->id;
				$warehouse_location_entity->id_product_attribute = $id_ac;
				$warehouse_location_entity->id_warehouse = $id_warehouse;
				$warehouse_location_entity->location = "";
				$warehouse_location_entity->save();
			}
			$stock_manager = StockManagerFactory::getManager();
			/* Add stock + $startingCount (no of serials uploaded) to product and product attribute to first warehouse found */
			if ($stock_manager->addProduct((int)$product->id, (int)$id_ac, $warehouse, $stock, $id_stock_mvt_reason, $product->price, 1))
			{
				/* Syncronize all stock for product id*/
				StockAvailable::synchronize((int)$product->id);						
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "StockAvailable::synchronize\n\r");
//fclose($fh);
			}	
			else
				return false;	
		}
		else
		{
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "StockAvailable::setQuantity((int)$product->id, (int)$id_ac, $stock, $id_shop)\n\r");
//fclose($fh);
			StockAvailable::setQuantity((int)$product->id, (int)$id_ac, $stock, $id_shop);
		}
	}
		
	public function removeStock15($product, $id_ac, $id_shop, $stock)
	{
//$myFile = dirname(__FILE__)."/1_log.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, "Starting removeStock15 $product->id, $id_ac, $id_shop, $stock (".print_r(debug_backtrace(), true).")\n\r");
//fclose($fh);
		if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && $product->advanced_stock_management)
		{
			$id_stock_mvt_reason = 2;
			$employee = new Employee(Db::getInstance()->getValue('SELECT id_employee FROM '._DB_PREFIX_.'employee where active = 1 ORDER BY id_employee ASC'));
			$this->context->employee = $employee;
			/* Getting current warehouses for the product id and product combination id */
			$productAttributeWarehouse = Warehouse::getProductWarehouseList($product->id, $id_ac, $id_shop);
			if (count($productAttributeWarehouse) <= 0)
				return false;	
			else
			{
				/* Get first warehouse where to decrease the stock for product*/
				$id_warehouse = (int)$productAttributeWarehouse[0]['id_warehouse'];
				$warehouse = new Warehouse($id_warehouse);				
				$stock_manager = StockManagerFactory::getManager();
				$current_stock = StockAvailable::getStockAvailableIdByProductId($product->id, $id_ac, $id_shop);
				if ($current_stock == $stock)
					return;
				else 
					$stock = $current_stock - $stock;
				$removed_products = $stock_manager->removeProduct((int)$product->id, (int)$id_ac, $warehouse, $stock, $id_stock_mvt_reason, 1);
				if (count($removed_products) >= 0)
					StockAvailable::synchronize((int)$product->id);
				else
					return false;	
			}
		}
		else
		{
			if ($stock <= 0 && Configuration::get('PS_ORDER_OUT_OF_STOCK') == 0 && StockAvailable::outOfStock($product->id, $id_shop) == 0)
				StockAvailable::removeProductFromStockAvailable((int)$product->id, (int)$id_ac, $id_shop);
			else
				StockAvailable::setQuantity((int)$product->id, (int)$id_ac, $stock, $id_shop);
		}
	}
	
	
	
	private function getFileChanges()
	{
		$ps_version = $this->getPSV();
    	$ps_version3  = substr(_PS_VERSION_,0,5).(substr(_PS_VERSION_,5,1) != "."?substr(_PS_VERSION_,5,1):"");
    	$admin_dir = substr(dirname($_SERVER['REQUEST_URI']), strrpos(dirname($_SERVER['REQUEST_URI']), "/"));
    	// CHECK FOR FILE CHANGES //
    	if ($this->getPSV() == 1.1)
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(47, 179, 185, 201, 312, 318, 330, 333, 337, 366, 373, 390, 489, 500, 503), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(85), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(193, 215, 226), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('519-520'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', '82-84', 103), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(177, 180), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(17, '29-33'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '22-26'), $ps_version).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 25, '56-57', 61, '120-121', 133, 159, 167, '192-209', '237-242', 272, 303, '333-334', '342-343', 350, 395, 400, 410), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(42, 45, '72-76'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(8, '20-23'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(129), $ps_version, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(96), $ps_version, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array('161-162'), $ps_version, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.tpl','/modules/paypal/paypal.tpl',array(23), $ps_version, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1159-1169'), $ps_version, '('.$this->l('Only for "Exclude Tax" Price Impact').')').'</li><br />';
    	else if ($this->getPSV() == 1.2)
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(50, 186, 208, 212, '246-248', 326, 332, 344, 348, 352, 381, 387, 404, 503, 515, 518), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(91), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(197, 220, 231), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('631-632'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', '83-85', 104), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(177, 180), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(23, '35-39'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '26-29'), $ps_version).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(144), $ps_version).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 25, '56-57', 61, 140, 150, 163, 185, 195, 203, 211, '238-259', '286-291', 321, 354, 375, '384-385', 393, 401, 446, 451, 461), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(42, 45, 49, '71-75'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(8, '20-23'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(131), $ps_version, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(109), $ps_version, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array('180-181'), $ps_version, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.tpl','/modules/paypal/paypal.tpl',array(23), $ps_version, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1254-1278'), $ps_version, '('.$this->l('Only for "Exclude Tax" Price Impact').')').'</li><br />';
    	else if ($this->getPSV() == 1.3)
    	{
			if ($ps_version3 == '1.3.2')
				return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(50, 223, 245, 249, 385, 391, 403, 407, 411, 440, 446, 463, 563, 581, 586), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(97), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(209, 242, 253), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('687-688'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', 83, 102), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(177, 180), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(23, '28-32'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '26-29'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(144), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 20, 25, '56-57', 61, 140, 150, 163, 185, 195, 203, 211, '238-259', '286-291', 321, 354, 375, '384-385', 394, 402, 447, 452, 462), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(44, 47, 51, '73-77'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(9, '21-24'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(135), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(114), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/redirect.tpl','/modules/paypal/redirect.tpl',array(26), $ps_version3, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1434-1459'), $ps_version3, '('.$this->l('Only for "Exclude Tax" Attribute Price Impact').')').'</li><br />';
			else if ($ps_version3 == '1.3.6' || $ps_version3 == "1.3.7")
				return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(50, 224, 246, 250, 380, 386, 398, 402, 406, 437, 443, 462, 562, 580, 585), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(103), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(217, 260, 271), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('696-697'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', 83, 90), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(191, 194), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(23, '28-32'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '26-29'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(144), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 20, 25, '56-57', 61, 140, 150, 163, 185, 195, 203, 211, '238-259', '286-291', 321, 354, 375, '384-385', 394, 402, 447, 452, 462), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(44, 47, 51, '73-77'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(9, '21-24'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(135), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(139), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/redirect.tpl','/modules/paypal/redirect.tpl',array(26), $ps_version3, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1452-1478'), $ps_version3, '('.$this->l('Only for "Exclude Tax" Attribute Price Impact').')').'</li><br />';
			else if ($ps_version3 == '1.3.3'  || $ps_version3 == "1.3.4" || $ps_version3 == "1.3.5")
				return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(50, 224, 246, 250, 380, 386, 398, 402, 406, 437, 443, 462, 562, 580, 585), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(97), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(216, 259, 270), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('696-697'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', 83, 90), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(178, 181), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(23, '28-32'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '26-29'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(144), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 20, 25, '56-57', 61, 140, 150, 163, 185, 195, 203, 211, '238-259', '286-291', 321, 354, 375, '384-385', 394, 402, 447, 452, 462), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(44, 47, 51, '73-77'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(9, '21-24'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(135), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(139), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/redirect.tpl','/modules/paypal/redirect.tpl',array(26), $ps_version3, '('.$this->l('Only if using Paypal').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1452-1478'), $ps_version3, '('.$this->l('Only for "Exclude Tax" Attribute Price Impact').')').'</li><br />';
			else
				return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Cart.php','/classes/Cart.php',array(50, 199, 221, 225, 356, 362, 374, 378, 382, 411, 417, 434, 533, 551, 554), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/OrderDetail.php','/classes/OrderDetail.php',array(91), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PaymentModule.php','/classes/PaymentModule.php',array(195, 226, 237), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/PDF.php','/classes/PDF.php',array('662-663'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/cart.php','/cart.php',array('30-33', 83, 102), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(178, 181), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(23, '28-32'), $ps_version).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array(3, '6-8', '26-29'), $ps_version).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(144), $ps_version).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array('14-15', 20, 25, '56-57', 61, 140, 150, 163, 185, 195, 203, 211, '238-259', '286-291', 321, 354, 375, '384-385', 394, 402, 447, 452, 462), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(44, 47, 51, '73-77'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(9, '21-24'), $ps_version, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(131), $ps_version, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(111), $ps_version, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/redirect.tpl','/modules/paypal/redirect.tpl',array(26), $ps_version, '('.$this->l('Only if using Paypal').')').'</li><br />';
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/classes/Product.php','/classes/Product.php',array('1411-1434'), $ps_version, '('.$this->l('Only for "Exclude Tax" Price Impact').')').'</li><br />';
    	}
    	else if ($this->getPSV() == 1.4)
    	{
		if ($ps_version3 == '1.4.0')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 280, 286, 298, 314, 320, 353, 361, 384, 407, 422, 427, 430, '447-448',456), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(30, 164, 199, 210), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '125-126'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28, '57-60', 123, 152), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(235, 238), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(58, '68-69', 76, 137, '147-148', 155, 194, '206-207', 214, 254, '263-264', '269-270', '277-278', 282, '287-289'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(186), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(416,788), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 167, 191, 233, 241, '272-293', '320-325', 355, 404, 425, '434-435', 444, 452, 497, 502, 512), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(63, 66, 70, '92-96'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, 43, '47-50', 59, 63, '69-70', '90-92'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(188), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(143), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array('407-431'), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array('66-90'), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
		elseif ($this->comparePSV('==', '1.4.1.0'))
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 281, 287, 299, 315, 321, 354, 362, 385, 408, 422, 429, 434, 437,  '454-455',463), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 163, 198, 209), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '125-126'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28, '57-60', 123, 152), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(238, 241), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(55, '60-64'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(58, '68-69', 76, 137, '147-148', 155, 194, '206-207', 214, 254, '263-264', '269-270', '277-278', 282, '287-289'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(186), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(416,783), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 166, 190, 232, 240, '271-292', '319-324', 354, 403, 424, '433-434', 443, 451, 496, 501, 511), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array(63, 66, 70, '92-96'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, 43, '46-49', '69-70', '90-92'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(188), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(143), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array('407-431'), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array('66-90'), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.2')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 281, 287, 299, 316, 322, 355, 363, 386, 409, 433, 438, 441, '458-459',467), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 166, 209, 220), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(246, 249), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(55, '60-64'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(58, '68-69', 76, 137, '147-148', 155, 194, '206-207', 214, 254, '263-264', '269-270', '277-278', 282, '287-289'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(187), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(416,779), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 166, 190, 232, 240, '271-292', '319-324', 354, 403, 424, '433-434', 443, 451, 496, 501, 511), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, 43, '46-49', '69-70', '90-92'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(204), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(143), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(416, 431), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(74, 89), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.3')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 281, 287, 299, 316, 322, 355, 363, 386, 409, 433, 438, 441, '458-459',467), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 166, 209, 220), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(246, 249), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(55, '60-64'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 198, '210-211', 218, 258, '267-268', '273-274', '281-282', 286, '291-293'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(417,786), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 178, 203, 249, 257, '288-309', '336-341', 371, 420, 441, '450-451', 460, 468, 513, 518, 528), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '47-50'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(204), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(166), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(406, 421), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(79, 94), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.4')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 168, 211, 222), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array('28-30', '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(246, 249), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(55, '60-64'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 198, '210-211', 218, 262, '271-272', '277-278', '285-286', 290, '295-297'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(425,794), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 178, 203, 249, 257, '288-309', '336-341', 371, 420, 441, '450-451', 460, 468, 513, 518, 528), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '47-50'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(219), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(167), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(418, 433), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(79, 94), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
  		elseif ($ps_version3 == '1.4.5')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 168, 211, 222), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array('28-30', '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(244, 247), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 198, '210-211', 218, 262, '271-272', '277-278', '285-286', 290, '295-297'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(425,795), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 178, 203, 249, 257, '288-309', '336-341', 371, 420, 441, '450-451', 460, 468, 513, 518, 528), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '46-49'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(226), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(167), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(422, 437), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(88, 103), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
  		elseif ($ps_version3 == '1.4.6')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 208, 251, 262), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28,32, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(244, 247), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 198, '210-211', 218, 262, '271-272', '277-278', '285-286', 290, '295-297'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(425,795), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 180, 205, 251, 259, 263, '293-312', 340, 425, 448, '457-458', 467, 475, 523, 528, 538), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '46-49'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(226), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(167), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(422, 437), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(88, 103), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.7')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 211, 254, 265), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28,32, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(244, 247), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 203, '215-216', 223, 272, '281-282', '287-288', '295-296', 300, '305-307'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(425,795), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 179, 204, 250, 258, 262, '292-311', 339, 430, 453, '462-463', 472, 480, 528, 535, 545), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '46-49'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(230), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(167), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(422, 437), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(88, 103), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.8')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 123, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 211, 254, 265), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28,32, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(244, 247), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 203, '215-216', 223, 272, '281-282', '287-288', '295-296', 300, '305-307'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(425,794), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(52, '83-84', 88, 180, 205, 251, 259, 263, '293-312', '340-345', 430, 453, '462-463', 472, 480, 528, 535, 545), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '46-49'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(230), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(167), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/standard/redirect.tpl','/modules/paypal/standard/redirect.tpl',array(53), $ps_version3, '('.$this->l('Only if using Paypal Standard').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/paypal.php','/modules/paypal/paypal.php',array(424, 439), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/paypal/payment/paypalpayment.php','/modules/paypal/payment/paypalpayment.php',array(88, 103), $ps_version3, '('.$this->l('Only if using Paypal API').')').'</li><br />';
 		elseif ($ps_version3 == '1.4.9')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(28, 63, 124, 146, 150, 288, 294, 306, 323, 329, 362, 370, 393, 416, 440, 445, 448, '465-466',474), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(28, 35), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('28-30', 220, 263, 274), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(30, '147-148'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(28,32, '57-60', 140, 169), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(244, 247), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(54, '59-63'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('27-29', '32-34', 45, 50, 53, '56-58', 62, '67-68', 73), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(62, '72-73', 80, 141, '151-152', 159, 203, '215-216', 223, 272, '281-282', '287-288', '295-296', 300, '305-307'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('329-330'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(189), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(446,805), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(51, '82-83', 87, 180, 205, 251, 259, 263, '293-312', '340-345', 430, 453, '462-463', 472, 480, 528, 535, 545), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('63-67', 71, '94-98'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(35, '46-49'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(230), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(150), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
		elseif ($this->comparePSV('==', '1.4.10'))
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(27, 62, 123, 147, 169, 285, 291, 303, 319, 335, 367, 379, '403-404', 430, 454, 459, 462, '479-488'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(27, 34), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('27-29', 219, 262, 273), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(29, '146-147'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(27,31, '56-59', 139, 168), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(243, 246), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(53, '58-62'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('26-28', '31-33', 44, 49, 52, '55-57', 61, '66-67', 72), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(56, '66-67', 78, 136, '146-147', 155, 202, '214-215', 223, 272, '281-282', '287-288', '295-296', 299, '303-305'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('328-329'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(188), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(445,806), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(50, '81-82', 86, 184, 211, 257, 266, 270, '300-319', '347-352', 437, 460, '469-470', 487, 552), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('59-63', 67, '90-94'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(34, '45-48'), $ps_version3, '('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(229), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(149), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
		elseif ($this->comparePSV('==', '1.4.11'))
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array(27, 62, 123, 147, 169, 285, 291, 303, 319, 335, 367, 379, '403-404', 430, 454, 459, 462, '479-488'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/OrderDetail.php','/override/classes/OrderDetail.php',array(27, 34), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array('27-29', 219, 262, 273), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PDF.php','/override/classes/PDF.php',array(29, '208-209'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/CartController.php','/override/controllers/CartController.php',array(27,31, '56-59', 139, 168), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/prestashop/order-detail.tpl',array(243, 246), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/prestashop/shopping-cart.tpl',array(53, '58-62'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/prestashop/shopping-cart-product-line.tpl',array('26-28', '31-33', 44, 49, 52, '55-57', 61, '66-67', 72), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/prestashop/js/cart-summary.js',array(56, '66-67', 75, 160, '171-172', 180, 227, '239-240', 248, 297, '306-307', '312-313', '320-321','331-333'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('328-329'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminCarts.php','/admin/tabs/AdminCarts.php',array(188), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/tabs/AdminOrders.php','/admin/tabs/AdminOrders.php',array(449,810), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(50, '78-79', 83, 181, 208, 254, 263, 267, '297-316', '344-349', 434, 457, '466-467', 484, 549), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('59-63', 67, '90-94'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array(34, '45-48'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout/gcheckout.php',array(229), $ps_version3, '('.$this->l('Only if using Google Checkout').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(149), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
    	}
    	else if ($this->getPSV() == 1.5)
    	{
 		if ($ps_version3 == '1.5.0')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array('72-73', 156, 203, 208, 489, 503, 522, 558, 564, 600, 608, '637-639', 675, 726, 736, '763-764', 776, '780-783', '838-839', '851-852', '857-875', '883-886', '898-899', 911, 978), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/order/OrderDetail.php','/override/classes/order/OrderDetail.php',array(44, '117-118'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(28, 287, 298), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Product.php','/override/classes/Product.php',array(27), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/front/CartController.php','/override/controllers/front/CartController.php',array('30-31', '37-40', 48, '72-75', 140), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-address-product-line.tpl','/themes/default/order-address-product-line.tpl',array('26-40', '43-45', '54-56', 60, '65-66', 75), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/default/order-detail.tpl',array(264, 267), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/default/shopping-cart.tpl',array('63-67'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/default/shopping-cart-product-line.tpl',array('26-40', '43-45', 49, 74, '78-80', 84, '89-90', 96, 112), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/default/js/cart-summary.js',array(57, 84, 101, 153, 177, '188-197', '213-229', 262, '274-276', 287, 389, '401-403', 417, 467, '480-482', 499, 560, '566-567', '574-575', 598, '605-606', '611-612', '617-618', '622-624', '629-631'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('187-188'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/themes/default/template/controllers/carts/helpers/view/view.tpl','/admin/themes/default/template/controllers/carts/helpers/view/view.tpl',array(129), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(56, '87-94', 180, 205, 254, 262, 266, '292-315', '341-350', 430, '460-462', 473, 484, 535, 542, 621), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('75-91', '101-102', '124-128'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array('33-44', 47, '61-64'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout_only_if_installed/gcheckout.php',array(231), $ps_version3, '(<b style="color:red">'.$this->l('Only if using Google Checkout').'</b>)').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(313), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
  		elseif ($ps_version3 == '1.5.1')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array('72-73', 156, 210, 215, 515, 529, 549, 585, 591, 627, 635, '664-666', 702, 753, 763, '790-791',803, '807-810', '865-866', '878-879', '884-902', '910-913', '925-926', 938, 1005), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/order/OrderDetail.php','/override/classes/order/OrderDetail.php',array(44, '117-118'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(28, 287, 298), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Product.php','/override/classes/Product.php',array(27), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/front/CartController.php','/override/controllers/front/CartController.php',array('30-31', '37-40', 48, '72-75', 140), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-address-product-line.tpl','/themes/default/order-address-product-line.tpl',array('26-40', '43-45', '54-56', 60, '65-66', 75), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/default/order-detail.tpl',array(264, 267), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/default/shopping-cart.tpl',array('63-67'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/default/shopping-cart-product-line.tpl',array('26-40', '43-45', 49, 74, '78-80', 84, '89-90', 96, 112), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/default/js/cart-summary.js',array(57, 84, 101, 153, 177, '188-197', '213-229', 262, '274-276', 287, 389, '401-403', 417, 467, '480-482', 499, 560, '566-567', '574-575', 598, '605-606', '611-612', '617-618', '622-624', '629-631'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('187-188'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/themes/default/template/controllers/carts/helpers/view/view.tpl','/admin/themes/default/template/controllers/carts/helpers/view/view.tpl',array(129), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(56, '87-94', 180, 205, 254, 262, 266, '293-315', '337-346', 427, '457-459', 470, 481, 532, 539, 618), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('75-91', '101-102', '124-128'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array('33-44', 47, '61-64'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout_only_if_installed/gcheckout.php',array(231), $ps_version3, '(<b style="color:red">'.$this->l('Only if using Google Checkout').'</b>)').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(313), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
  		elseif ($ps_version3 == '1.5.2')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array('72-73', 156, 210, 215, 516, 530, 550, 586, 592, 628, 636, '665-667', 703, 754, 764, '791-792', 804, '808-811', '866-867', '879-880', '885-903', '911-914', '926-927', 939, 1006), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/order/OrderDetail.php','/override/classes/order/OrderDetail.php',array(44, '117-118'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(28, 292, 303), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Product.php','/override/classes/Product.php',array(27), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/front/CartController.php','/override/controllers/front/CartController.php',array('30-31', '37-40', 48, '74-77', 142), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-address-product-line.tpl','/themes/default/order-address-product-line.tpl',array('26-40', '43-45', '54-56', 60, '65-66', 75), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/default/order-detail.tpl',array(264, 267), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/default/shopping-cart.tpl',array('63-67'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/default/shopping-cart-product-line.tpl',array('26-40', '43-45', 49, 74, '78-80', 84, '89-90', 96, 112), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/default/js/cart-summary.js',array(57, 83, 100, 133, 152, 176, '187-196', '212-228', 262, '274-276', 287, 389, '401-403', 417, 467, '480-482', 499, 560, '566-567', '574-575', 598, '605-606', '611-612', '617-618', '622-624', '629-631'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/order-opc.js','/themes/default/js/order-opc.js',array(373), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('187-188'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/themes/default/template/controllers/carts/helpers/view/view.tpl','/admin/themes/default/template/controllers/carts/helpers/view/view.tpl',array(129), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(56, '87-94', 180, 205, 254, 262, 266, '293-315', '336-345', 426, '456-458', 469, 480, 531, 538), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('78-94', '104-105', '127-131'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array('33-44', 47, '61-64'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout_only_if_installed/gcheckout.php',array(231), $ps_version3, '(<b style="color:red">'.$this->l('Only if using Google Checkout').'</b>)').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(313), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
  		elseif ($ps_version3 == '1.5.3')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array('71-72', 155, 200, 205, 497, 511, 531, 567, 573, 609, 617, '646-648', 684, 735, 745, '772-773', 785, '789-792', '847-848', '860-861', '867-884', '892-895', '907-908', 920, 987), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/order/OrderDetail.php','/override/classes/order/OrderDetail.php',array(43, '116-117'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(27, 294, 305), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Product.php','/override/classes/Product.php',array(27, 72), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/front/CartController.php','/override/controllers/front/CartController.php',array('29-30', '36-39', 47, '71-74', 139), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-address-product-line.tpl','/themes/default/order-address-product-line.tpl',array('26-40', '43-45', '54-56', 60, '65-66', 75), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/default/order-detail.tpl',array(263, 266), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/default/shopping-cart.tpl',array('62-66'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/default/shopping-cart-product-line.tpl',array('25-39', '42-44', 48, 73, '77-79', 83, '88-89', 95, 111), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/default/js/cart-summary.js',array(56, 83, 100, 133, 152, 176, '187-196', '211-228', 264, '276-278', 289, 391, '403-405', 419, 469, '482-484', 501, 562, '568-569', '576-577', 600, '607-608', '613-614', '619-620', '624-627', '631-633'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/order-opc.js','/themes/default/js/order-opc.js',array(373), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('186-187'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/themes/default/template/controllers/carts/helpers/view/view.tpl','/admin/themes/default/template/controllers/carts/helpers/view/view.tpl',array(128), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(55, '86-93', 179, 204, 253, 261, 265, '292-314', '335-344', 430, '460-462', 473, 484, 535, 542), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('77-93', '103-104', '126-130'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array('32-43', 46, '59-62'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout_only_if_installed/gcheckout.php',array(231), $ps_version3, '(<b style="color:red">'.$this->l('Only if using Google Checkout').'</b>)').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(312), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
  		elseif ($ps_version3 == '1.5.4')
			return '<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Cart.php','/override/classes/Cart.php',array('74-75', 159, 204, 209, 501, 515, 535, 578, 584, 620, 628, '657-659', 695, 745, 755, '783-784', 796, '800-803', '858-859', '871-872', '878-895', '904-906', '918-919', 931, 998), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/order/OrderDetail.php','/override/classes/order/OrderDetail.php',array(43, '116-117'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/PaymentModule.php','/override/classes/PaymentModule.php',array(27, 287, 298), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/classes/Product.php','/override/classes/Product.php',array(28, 74), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/override/controllers/front/CartController.php','/override/controllers/front/CartController.php',array('29-30', '36-39', 47, '71-74', 144), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-address-product-line.tpl','/themes/default/order-address-product-line.tpl',array('26-40', '43-45', '54-56', 60, '65-66', 75), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/order-detail.tpl','/themes/default/order-detail.tpl',array(263, 266), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart.tpl','/themes/default/shopping-cart.tpl',array('62-66'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/shopping-cart-product-line.tpl','/themes/default/shopping-cart-product-line.tpl',array('25-39', '42-44', 48, 73, '77-79', 83, '88-89', 95, 111), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/cart-summary.js','/themes/default/js/cart-summary.js',array(50, 77, 96, 128, 147, 171, '182-191', 206, 209, 277, '286-291', 303, 421, '433-435', 450, 503, '516-518', 536, 599, '604-605', '609-610', '629-630'), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/themes/'._THEME_NAME_.'/js/order-opc.js','/themes/default/js/order-opc.js',array(402), $ps_version3).'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/js/attributesBack.js','/js/attributesBack.js',array('186-187'), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines($admin_dir.'/themes/default/template/controllers/carts/helpers/view/view.tpl','/admin/themes/default/template/controllers/carts/helpers/view/view.tpl',array(128), $ps_version3).'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js':'/modules/blockcart/ajax-cart.js','/modules/blockcart/ajax-cart.js',array(55, '83-89', 180, 206, 255, 264, 268, '295-314', '339-349', 380, '465-466', 476, 487, 538, 545), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/js/modules/blockcart/ajax-cart.js')?$this->l('Copy From').' "modules/blockcart/ajax-cart.js"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl':'/modules/blockcart/blockcart.tpl','/modules/blockcart/blockcart.tpl',array('77-93', '103-104', '126-130'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines(file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl.tpl')?'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl.tpl':'/modules/blockcart/blockcart-json.tpl','/modules/blockcart/blockcart-json.tpl',array('31-42', 45, '59-62'), $ps_version3, (file_exists(_PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/modules/blockcart/blockcart-json.tpl')?$this->l('Copy From').' "modules/blockcart/blockcart-json.tpl"':'').' ('.$this->l('Only if using AJAX cart').')').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/gcheckout/gcheckout.php','/modules/gcheckout_only_if_installed/gcheckout.php',array(231), $ps_version3, '(<b style="color:red">'.$this->l('Only if using Google Checkout').'</b>)').'</li><br />'.
					'<hr style="background-color:blue" />'.
					'<li style="margin-left:10px">'.$this->fileCheckLines('/modules/mailalerts/mailalerts.php','/modules/mailalerts/mailalerts.php',array(312), $ps_version3, '('.$this->l('Only if using Mail Alerts').')').'</li><br />';
    	}
	}
	
	private function helpWindows()
	{
		$ret = '
			<!-- Display Wizard -->
			<div class="awp_help" id="awp_qm_dw_text">
			<li>'.$this->l('You can display the wizard only for certain products, all other products will load the normal attributes.').'</li>
			<br />
			<li>'.$this->l('You can use any of the product fields in the drop down and select a value, any product that will have that value set, will display the wizard.').'</li>
			<br />
			<img src="'.$this->_path.'img/help_dw.jpg" border="0" />
			</div>
			<!-- Group Image -->
			<div class="awp_help" id="awp_qm_gi_text">
			<li>'.$this->l('Group images will be displayed to the left of the attribute selection box').'</li>
			<br />
			<li>'.$this->l('You can have them automatically resized, and assign a link to each image.').'</li>
			<br />
			<img src="'.$this->_path.'img/help_gi1.jpg" border="0" />
			<br />
			<li>'.$this->l('Group images can be uploaded for each group below.').'</li>
			<br />
			<img src="'.$this->_path.'img/help_gi2.jpg" border="0" />
			</div>
			<!-- Layered Images -->
			<div class="awp_help" id="awp_qm_li_text">
			<li>'.$this->l('When using layered images, product zoom will not be available').'</li>
			<br />
			<li>'.$this->l('Layered images are assigned per attribute, when enabled, an option to upload an image is added below').'</li>
			<br />
			<img src="'.$this->_path.'img/help_li1.jpg" border="0" />
			<br />
			<li>'.$this->l('The size of each image must be exactly the same as the product image, and must be a transparent PNG.').'</li>
			<br />
			<img src="'.$this->_path.'img/help_li2.jpg" border="0" />
			<br />
			<li>'.$this->l('You can assign different layer images for each attribute in each group, one image from each group').'
			<br />
			'.$this->l('will be on top of the product image (and each other).').'</li>
			</div>
			<!-- File Upload Settings -->
			<div class="awp_help" id="awp_qm_fus_text">
			<li>'.$this->l('When displaying attributes as File Upload, you can set a maximum file size the customer will be able to upload').'
			<br />
			'.$this->l('as well as thumbnail dimensions (if an image is uploaded, the thumbnail will display in the cart and order history)').'
			</li>
			<br />
			<li>'.$this->l('Each File Upload attribute has its own settings as well (like acceptable file extensions)').'</li>
			<br />
			<img src="'.$this->_path.'img/help_fus.jpg" border="0" />
			</div>
			<!-- Not in Product Page -->
			<div class="awp_help" id="awp_qm_npp_text">
			<li>'.$this->l('You can disable or hide the "Add to Cart" button in product list pages.').'</li>
			</div>
			<!-- No Attribute Selection -->
			<div class="awp_help" id="awp_qm_nas_text">
			<li>'.$this->l('When using checkboxes, allow to add the product to the cart without any attributes selected').'
			<br />
			'.$this->l('For example when offering accessories to a product. If Disabled is selected, at least one box would need to be ticked.').'
			</li>
			</div>
			<!-- Reset -->
			<div class="awp_help" id="awp_qm_res_text">
			<li>'.$this->l('Will reset all the attribute selections without an option to undo.').'</li>
			<br />
			<li>'.$this->l('If you have added new attributes and you do not see them in the list below, you should click "Reset".').'</li>
			</div>
			<!-- Delete Temporary Attributes -->
			<div class="awp_help" id="awp_qm_dta_text">
			<li>'.$this->l('Whenever a product with attributes gets added to the cart, a new dynamic (temporary) combination is creted (awp_details)').'
			<br />
			'.$this->l('While leaving them there will have no negative affects on the site, you can delete them once in a while to reduce the clutter').'
			</li>
			<br />
			<li>'.$this->l('Deleting them will remove any products that are currently in customers\' carts, so do it during off peak hours.').'</li>
			</div>
			<!-- Attribute Type -->
			<div class="awp_help" id="awp_qm_at_text">
			<li>'.$this->l('Select how you want the attributes from each group to be displayed.').'</li>
			<br />
			<li>'.$this->l('Each option has its own settings, such as layout, color / image size, hiding the name etc...').'</li>
			</div>
			<!-- Group Name -->
			<div class="awp_help" id="awp_qm_gn_text">
			<li>'.$this->l('Click on each Group Name to expand all of its options.').'</li>
			<br />
			<li>'.$this->l('You can enter a description for each of the groups with more information about it').'</li>
			<br />
			<img src="'.$this->_path.'img/help_gn.jpg" border="0" />
			</div>
			<!-- Initiate help popins -->
			<script type="text/javascript">
			$(".awp_qm").each(function () {
				$(this).mouseover( function (j, that) {
					awp_qm_pos = $(this).offset();
					$("#"+$(this).attr("id")+"_text").css("top",(awp_qm_pos.top+20)+"px");
					$("#"+$(this).attr("id")+"_text").css("left",(awp_qm_pos.left + 30)+"px");
					$("#"+$(this).attr("id")+"_text").fadeIn();
				});
				$(this).mouseout( function (j, that) {
					
					$("#"+$(this).attr("id")+"_text").fadeOut();
				});
			});
			</script>
			';
		return $ret;
	}
}
?>