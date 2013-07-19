<?php
/*
CsMegamenu
*/
if (!defined('_CAN_LOAD_FILES_'))
	exit;
include_once(dirname(__FILE__).'/classes/CsMegaMenuClass.php');
include_once(dirname(__FILE__).'/classes/CsMegaMenuOptionClass.php');
class CsMegaMenu extends Module
{
	private $_html;
	private $temp_url = "{megamenu_url}";
	private $optionsMenu = array('Category','Product','Static Block','Manufacture','Information');
	private $user_groups;
	function __construct()
	{
		$this->name = 'csmegamenu';
	 	$this->tab = 'MyBlocks';
	 	$this->version = '1.0';
		$this->author = 'CodeSpot';

		parent::__construct();

		$this->displayName = $this->l('CS Mega Menu block');
		$this->description = $this->l('Adds a mega menu block.');
	}
	
	public function init_data()
	{
	
		$id_en = Language::getIdByIso('en');
		$id_fr = Language::getIdByIso('fr');
		$id_shop = Configuration::get('PS_SHOP_DEFAULT');;
		$option_1 = '{"opt_fill_column":"1","opt_show_image_cat":"0","opt_image_size_cate":"category_default","opt_show_sub_cat":"1","opt_show_parent_cat":"0","opt_id_parent_cat":"2"}';
		$option_2 = '{"opt_fill_column":"1","opt_show_image_cat":"1","opt_image_size_cate":"c_menu_default","opt_show_sub_cat":"1","opt_show_parent_cat":"0","opt_id_parent_cat":"3"}';
		$option_3 = '{"opt_show_image_product":"1","opt_image_size_product":"p_menu_default","input_hidden_id":"2-3-4-5-","input_hidden_name":"eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4","opt_fill_column":"2"}';
		$option_4 = '{"opt_show_image_manu":"1","opt_image_size_manu":"mf_default","opt_show_name_manu":"0","opt_list_manu":["1","2"],"opt_fill_column":"1"}';
		$option_5 = '{&quot;opt_content_static&quot;:{&quot;1&quot;:&quot;&lt;p&gt;&lt;img src=\\&quot;{megamenu_url}themes\\/andolo\\/img\\/cms\\/channel.png\\&quot; alt=\\&quot;\\&quot; \\/&gt;&lt;\\/p&gt;\\r\\n&lt;p&gt;\\u00a0&lt;\\/p&gt;\\r\\n&lt;p&gt;Proin mauris vel urna adipiscing congue malesuada eros augue&lt;\\/p&gt;\\r\\n&lt;p&gt;Mauris id neque risus facilisis euismod eros consequat massa posuere varius tempor metus tincidunt justo vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue malesuada eros augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&lt;p&gt;&lt;img src=\\&quot;{megamenu_url}themes\\/andolo\\/img\\/cms\\/channel.png\\&quot; alt=\\&quot;\\&quot; \\/&gt;&lt;\\/p&gt;\\r\\n&lt;p&gt;\\u00a0&lt;\\/p&gt;\\r\\n&lt;p&gt;Proin mauris vel urna adipiscing congue malesuada eros augue&lt;\\/p&gt;\\r\\n&lt;p&gt;Mauris id neque risus facilisis euismod eros consequat massa posuere varius tempor metus tincidunt justo vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue malesuada eros augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;&quot;,&quot;6&quot;:&quot;&quot;},&quot;opt_fill_column&quot;:&quot;1&quot;}';
		$option_6 = '{"opt_show_image_product":"1","opt_image_size_product":"p_menu_default","input_hidden_id":"4-5-","input_hidden_name":"eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4eiusmod tempor \\u2122 BY COLOR  incididunt\\u00ae\\u00a4","opt_fill_column":"2"}';
		$option_7 = '{"opt_fill_column":"1","opt_show_image_cat":"0","opt_image_size_cate":"category_default","opt_show_sub_cat":"1","opt_show_parent_cat":"1","opt_id_parent_cat":"2"}';
		$option_8 = '{"opt_fill_column":"1","opt_show_image_cat":"0","opt_image_size_cate":"category_default","opt_show_sub_cat":"1","opt_show_parent_cat":"1","opt_id_parent_cat":"2"}';
		$option_9 = '{"opt_fill_column":"1","opt_show_image_cat":"0","opt_image_size_cate":"category_default","opt_show_sub_cat":"1","opt_show_parent_cat":"1","opt_id_parent_cat":"2"}';
		$option_10 = '{&quot;opt_content_static&quot;:{&quot;1&quot;:&quot;&lt;h2&gt;Nullam placerat blandite rhoncus odio quis fringilla dictum urna&lt;\\/h2&gt;\\r\\n&lt;p&gt;Mauris id neque id risus facilisis euismod consequat massa. Etiam posuere, felis varius tempor, metus ante tincidunt justo, vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue. Sed malesuada, augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;\\r\\n&lt;h2&gt;Phasellus lobortis interdum leo eu condimentum auctor eu cursus&lt;\\/h2&gt;\\r\\n&lt;p&gt;Mauris id neque id risus facilisis euismod consequat massa. Etiam posuere, felis varius tempor, metus ante tincidunt justo, vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue. Sed malesuada, augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;&quot;,&quot;2&quot;:&quot;&quot;,&quot;3&quot;:&quot;&quot;,&quot;4&quot;:&quot;&quot;,&quot;5&quot;:&quot;&lt;h2&gt;Nullam placerat blandite rhoncus odio quis fringilla dictum urna&lt;\\/h2&gt;\\r\\n&lt;p&gt;Mauris id neque id risus facilisis euismod consequat massa. Etiam posuere, felis varius tempor, metus ante tincidunt justo, vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue. Sed malesuada, augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;\\r\\n&lt;h2&gt;Phasellus lobortis interdum leo eu condimentum auctor eu cursus&lt;\\/h2&gt;\\r\\n&lt;p&gt;Mauris id neque id risus facilisis euismod consequat massa. Etiam posuere, felis varius tempor, metus ante tincidunt justo, vitae semper tellus lacus amet metus ipsum eleifend sagittis a quis libero. Proin id mauris vel urna adipiscing congue. Sed malesuada, augue eget ultricies consequat, nunc tellus consequat metus eros&lt;\\/p&gt;&quot;,&quot;6&quot;:&quot;&quot;},&quot;opt_fill_column&quot;:&quot;1&quot;}';
		
		//insert db table csmegamenu
		if(!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csmegamenu` (`id_menu`, `number_column`, `width`, `link_of_title`,`icon`,`display`,`display_icon`,`position`) VALUES 
		(1, 1, 200,"{megamenu_url}index.php?id_category=3&controller=category","icon_1.png", 1, 1, 1),
		(2, 1, 250, "{megamenu_url}index.php?id_category=4&controller=category","icon_2.png", 1, 1, 2),
		(3, 2, 630, "{megamenu_url}index.php?id_category=3&controller=category","icon_3.png", 1, 1, 3),
		(4, 3, 510, "{megamenu_url}index.php?id_category=4&controller=category","icon_4.png", 1, 1, 4),
		(5, 6, 1180, "{megamenu_url}index.php?id_category=3&controller=category","icon_5.png", 1, 1, 5),
		(6, 1, 510, "{megamenu_url}index.php?id_category=3&controller=category","icon_6.png", 1, 1, 6),
		(7, 0, 0, "{megamenu_url}index.php?id_category=3&controller=category","icon_7.png", 1, 1, 7),
		(8, 0, 0, "{megamenu_url}index.php?id_category=3&controller=category", "icon_8.png", 1, 1, 8),
		(9, 0, 0, "{megamenu_url}index.php?id_category=3&controller=category", "icon_9.png", 1, 1, 9),
		(10, 0, 0, "{megamenu_url}index.php?id_category=4&controller=category", "icon_10.png", 1, 1, 10);'	
		) OR
		//insert db table csmegamenu_shop
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csmegamenu_shop` (`id_menu`, `id_shop`, `number_column`, `width`, `link_of_title`, `display`, `position`) VALUES
		(1, "'.$id_shop.'",1, 200,"{megamenu_url}index.php?id_category=3&controller=category",1, 1),
		(2, "'.$id_shop.'", 1, 250, "{megamenu_url}index.php?id_category=4&controller=category",1, 2),
		(3, "'.$id_shop.'",2, 630, "{megamenu_url}index.php?id_category=3&controller=category",1, 3),
		(4,"'.$id_shop.'",3, 510, "{megamenu_url}index.php?id_category=4&controller=category",1, 4),
		(5, "'.$id_shop.'",6, 1180, "{megamenu_url}index.php?id_category=3&controller=category",1, 5),
		(6, "'.$id_shop.'",1, 510, "{megamenu_url}index.php?controller=best-sales",1, 6),
		(7, "'.$id_shop.'",0, 0, "{megamenu_url}index.php?controller=prices-drop",1, 7),
		(8, "'.$id_shop.'",0, 0, "{megamenu_url}index.php?controller=contact",1, 8),
		(9, "'.$id_shop.'",0, 0, "{megamenu_url}index.php?id_category=3&controller=category", 1, 9),
		(10,"'.$id_shop.'" ,0, 0, "{megamenu_url}index.php?id_category=4&controller=category",1, 10)
		;'
		) OR
		//insert db table csmegamenu_lang
		!Db::getInstance()->Execute("INSERT INTO `"._DB_PREFIX_."csmegamenu_lang` (`id_menu`, `id_lang`, `id_shop`, `title`,`description`) VALUES 
			(1, '".$id_en."', '".$id_shop."', 'Cod', ''),
			(1, '".$id_fr."', '".$id_shop."', 'Cod', ''),
			(2, '".$id_en."', '".$id_shop."', 'Sports and honnies', ''),
			(2, '".$id_fr."', '".$id_shop."', 'Sports and honnies', ''),
			(3, '".$id_en."', '".$id_shop."', 'Fashion', ''),
			(3, '".$id_fr."', '".$id_shop."', 'Fashion', ''),
			(4, '".$id_en."', '".$id_shop."', 'Jewelry and Cosmetics', ''),
			(4, '".$id_fr."', '".$id_shop."', 'Jewelry and Cosmetics', ''),
			(5, '".$id_en."', '".$id_shop."', 'Electronic', ''),
			(5, '".$id_fr."', '".$id_shop."', 'Electronic', ''),
			(6, '".$id_en."', '".$id_shop."', 'Toy and Handmade', ''),
			(6, '".$id_fr."', '".$id_shop."', 'Toy and Handmade', ''),
			(7, '".$id_en."', '".$id_shop."', 'Furniture and  home Accessories', ''),
			(7, '".$id_fr."', '".$id_shop."', 'Furniture and  home Accessories', ''),
			(8, '".$id_en."', '".$id_shop."', 'transportation', ''),
			(8, '".$id_fr."', '".$id_shop."', 'transportation', ''),
			(9, '".$id_en."', '".$id_shop."', 'Gift Center', ''),
			(9, '".$id_fr."', '".$id_shop."', 'Gift Center', ''),
			(10, '".$id_en."', '".$id_shop."', 'Health care and Medical', ''),
			(10, '".$id_fr."', '".$id_shop."', 'Health care and Medical', '')
			;"		
		) OR
		//insert db table csmegamenu_option
		!Db::getInstance()->Execute("INSERT INTO `"._DB_PREFIX_."csmegamenu_option` (`id_option`, `id_menu`, `type_option`, `position_option`, `content_option`) 
		VALUES 
			(1, 1, 0, 0,'".$option_1."'),
			(2, 2, 0, 1,'".$option_2."'),
			(3, 3, 1, 0, '".$option_3."'),
			(4, 4, 3, 0, '".$option_4."'),
			(5, 5, 2, 1,'".pSQL($option_5)."'),
			(6, 5, 1, 0, '".$option_6."'),
			(7, 5, 0, 3,'".$option_7."'),
			(8, 5, 0, 4,'".$option_8."'),
			(9, 5, 0, 4,'".$option_9."'),
			(10,6, 2, 0,'".pSQL($option_10)."')
			;
			"
		) OR
		//insert db table csmegamenu_option_shop
		!Db::getInstance()->Execute("INSERT INTO `"._DB_PREFIX_."csmegamenu_option_shop` (`id_option`, `id_menu`, `id_shop`, `type_option`, `position_option`, `content_option`)
			VALUES 
			(1, 1, '".$id_shop."', 0, 1,'".$option_1."'),
			(2, 2, '".$id_shop."', 0, 1, '".$option_2."'),
			(3, 3, '".$id_shop."', 1, 1, '".$option_3."'),
			(4, 4, '".$id_shop."', 3, 1, '".$option_4."'),
			(5, 5, '".$id_shop."', 2, 1, '".pSQL($option_5)."'),
			(6, 5, '".$id_shop."', 1, 2, '".$option_6."'),
			(7, 5, '".$id_shop."', 0, 3, '".$option_7."'),
			(8, 5, '".$id_shop."', 0, 4, '".$option_8."'),
			(9, 5, '".$id_shop."', 0, 5, '".$option_9."'),
			(10, 6, '".$id_shop."', 2, 0, '".pSQL($option_10)."')	
			;	
			")
		)
			return false;
		return true;
	}
	
	function install()
	{
		if (!parent::install() || !$this->registerHook('header')|| !$this->registerHook('csmegamenu') ||
			!$this->registerHook('actionObjectCategoryUpdateAfter') ||
			!$this->registerHook('actionObjectCategoryDeleteAfter') ||
			!$this->registerHook('actionObjectCmsUpdateAfter') ||
			!$this->registerHook('actionObjectCmsDeleteAfter') ||
			!$this->registerHook('actionObjectManufacturerUpdateAfter') ||
			!$this->registerHook('actionObjectManufacturerDeleteAfter') ||
			!$this->registerHook('actionObjectProductUpdateAfter') ||
			!$this->registerHook('actionObjectProductDeleteAfter') ||
			!$this->registerHook('categoryUpdate') ||
			!$this->registerHook('actionUpdateQuantity')
			)
			return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csmegamenu (`id_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,`number_column` int(10) unsigned default \'1\', `width` int(10) unsigned default \'120\',  `link_of_title` varchar(300),`icon` varchar(255) default \'\', `display` tinyint(1) NOT NULL default \'1\',`display_icon` tinyint(1) NOT NULL default \'1\',`position` int(10) unsigned default \'0\',PRIMARY KEY (`id_menu`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csmegamenu_shop (`id_menu` int(10) unsigned NOT NULL ,`id_shop` int(10) unsigned NOT NULL,`number_column` int(10) unsigned default \'1\', `width` int(10) unsigned default \'120\',  `link_of_title` varchar(300), `display` tinyint(1) NOT NULL default \'1\',`position` int(10) unsigned default \'0\',PRIMARY KEY (`id_menu`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csmegamenu_option (`id_option` int(10) unsigned NOT NULL AUTO_INCREMENT,`id_menu` int(10) unsigned NOT NULL,`type_option` int(10) unsigned NOT NULL, `position_option` int(10) unsigned default \'0\', `content_option` text ,PRIMARY KEY (`id_option`)) ENGINE=InnoDB default CHARSET=utf8'))
			return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csmegamenu_option_shop (`id_option` int(10) unsigned NOT NULL,`id_menu` int(10) unsigned NOT NULL,`id_shop` int(10) unsigned NOT NULL,`type_option` int(10) unsigned NOT NULL, `position_option` int(10) unsigned default \'0\', `content_option` text ,PRIMARY KEY (`id_option`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
			return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csmegamenu_lang (`id_menu` int(10) unsigned NOT NULL, `id_lang` int(10) unsigned NOT NULL,`id_shop` int(10) unsigned NOT NULL, `title` varchar(255) NOT NULL default \'\', `description` varchar(255) default \'\', PRIMARY KEY (`id_menu`,`id_lang`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		$this->init_data();
		return true;
	}
	
	public function uninstall()
	{
	 	if (parent::uninstall() == false)
	 		return false; 	
		if (!Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csmegamenu') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csmegamenu_shop') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csmegamenu_option') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csmegamenu_option_shop') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csmegamenu_lang'))
	 		return false;
	 	return true;
	}
	
	private function _displayHelp() //not write
	{
	}
	//cms
	private function displayRecurseCheckboxes($categories, $selected, $has_suite = array())
	{
		static $irow = 0;	
		$this->_html .= '
			<tr '.($irow++ % 2 ? 'class="alt_row"' : '').'>
				<td width="3%"><input type="checkbox" name="content_option[4][footerBox][]" class="cmsBox" id="1_'.$categories['id_cms_category'].'" value="1_'.$categories['id_cms_category'].'" '.
				(in_array('1_'.$categories['id_cms_category'], $selected) ? ' checked="checked"' : '').' /></td>
				<td width="3%">'.$categories['id_cms_category'].'</td>
				<td width="94%">';
		for ($i = 1; $i < $categories['level_depth']; $i++)
		if(isset($has_suite[$i - 1]))
			$this->_html .=	'<img style="vertical-align:middle;" src="../img/admin/lvl_'.$has_suite[$i - 1].'.gif" alt="" />';
		$this->_html .= '<img style="vertical-align:middle;" src="../img/admin/'.($categories['level_depth'] == 0 ? 'lv1' : 'lv2_');
		if(isset($has_suite[$categories['level_depth'] - 1]))
			$this->_html .= 'b.gif" alt="" /> &nbsp;';
		else
			$this->_html .= 'f.gif" alt="" /> &nbsp;';
			$this->_html .= '<label for="1_'.$categories['id_cms_category'].'" class="t"><b>'.$categories['name'].'</b></label></td>
			</tr>';
		if (isset($categories['children']))
			foreach ($categories['children'] as $key => $category)
			{
				$has_suite[$categories['level_depth']] = 1;
				if (sizeof($categories['children']) == $key + 1 AND !sizeof($categories['cms']))
					$has_suite[$categories['level_depth']] = 0;
				$this->displayRecurseCheckboxes($category, $selected, $has_suite, 0);
			}
		
		$cpt = 0;
		foreach ($categories['cms'] as $cms)
		{
			$this->_html .= '
				<tr '.($irow++ % 2 ? 'class="alt_row"' : '').'>
					<td width="3%"><input type="checkbox" name="content_option[4][footerBox][]" class="cmsBox" id="0_'.$cms['id_cms'].'" value="0_'.$cms['id_cms'].'" '.
					(in_array('0_'.$cms['id_cms'], $selected) ? ' checked="checked"' : '').' /></td>
					<td width="3%">'.$cms['id_cms'].'</td>
					<td width="94%">';
			for ($i = 0; $i < $categories['level_depth']; $i++)
			if(isset($has_suite[$i]))
				$this->_html .=	'<img style="vertical-align:middle;" src="../img/admin/lvl_'.$has_suite[$i].'.gif" alt="" />';
			$this->_html .= '<img style="vertical-align:middle;" src="../img/admin/lv2_'.(++$cpt == sizeof($categories['cms']) ? 'f' : 'b').'.gif" alt="" /> &nbsp;
			<label for="0_'.$cms['id_cms'].'" class="t" style="margin-top:6px;">'.$cms['meta_title'].'</label></td>
				</tr>';
		}
	}
	private function _displayFormCMS($array_check)
	{
		global $currentIndex, $cookie;
		$this->_html .='<div class="margin-form"><table cellspacing="0" cellpadding="0" class="table" width="100%">
				<tr>
					<th width="3%"><input type="checkbox" name="content_option[4][checkme_cms]" class="noborder" onclick="checkallCMSBoxes($(this).attr(\'checked\'))"/></th>
					<th width="3%">'.$this->l('ID').'</th>
					<th width="94%">'.$this->l('Name').'</th>
				</tr>';
				$this->displayRecurseCheckboxes(CMSCategory::getRecurseCategory($cookie->id_lang),$array_check);
		$this->_html .= '</table></div>';
	}
	//cms
	private function _displayAddOptionForm()
	{
		global $currentIndex, $cookie;
		$menu_item = new CsMegaMenuClass(Tools::getValue('id_menu'));
		$this->_html .= '
		<link href="'._PS_JS_DIR_.'jquery/plugins/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/autocomplete/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="'.$this->_path.'js/csmegamenu.js"></script>
		<script type="text/javascript">
		$(window).ready(function(){
			'.(isset($_POST['type_option']) ? '
			for (var i=0;i<5;i++)
			{ 
				$(".option_type_" + i + "").hide();
			}
			$(".option_type_'.$_POST['type_option'].'").show();' : '' ).'
			});
		</script>
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="'.$this->l('Add Option for menu ').$menu_item->title[(int)($cookie->id_lang)].'" /> '.$this->l('Add Option for menu ').$menu_item->title[(int)($cookie->id_lang)].'</legend>
		<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
		<input type="hidden" name="id_menu" value="'.Tools::getValue('id_menu').'"/>

		<div class="div_select_option">
					<div id="div_select_option">
					<p>
					<label>'.$this->l('Option:').'</label>
						<select name="type_option" onchange="displayFormOption(this.value);" style="width:150px;" >';
					foreach ($this->optionsMenu AS $key=>$optionValue){
						$this->_html .= '<option value="'.$key.'" '.(isset($_POST['type_option']) && $_POST['type_option'] == $key ? 'selected' : '' ).' >'.$optionValue.'</option>';
					}
					$this->_html .= '
						</select>
					</p>
					<p>
					<label>'.$this->l('Fill the column:').'</label>
					<input type="text" class="opt_fill_column" size="20" value="'.(isset($_POST['content_option'][''.Tools::getValue('type_option').'']['opt_fill_column']) ? $_POST['content_option'][''.Tools::getValue('type_option').'']['opt_fill_column'] : '').'"  name="content_option[0][opt_fill_column]"/>
					</p>
					</div>
			<div class="div_content_option">
				<div class="option_type_0">
					<p>
					<label>'.$this->l('Show Image:').'</label> 
					<input class="opt_show_image_cat" type="radio" name="content_option[0][opt_show_image_cat]" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_image_cat" type="radio" name="content_option[0][opt_show_image_cat]" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
					
					$imageTypes = ImageType ::getImagesTypes();
				$this->_html .= '
					<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size"  name="content_option[0][opt_image_size_cate]">';
				foreach ($imageTypes as $imageType)
				{
					$this->_html .= '<option  value="'.$imageType['name'].'">'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
					<p>
					<label>'.$this->l('Show Sub Category:').'</label> 
					<input class="opt_show_sub_cat" name="content_option[0][opt_show_sub_cat]" type="radio" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_sub_cat" name="content_option[0][opt_show_sub_cat]" type="radio" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
					<p>
					<label>'.$this->l('Show Parent Category:').'</label> 
					<input class="opt_show_parent_cat" type="radio" name="content_option[0][opt_show_parent_cat]" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_parent_cat" type="radio" name="content_option[0][opt_show_parent_cat]" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
					$cate_selected = array();
					$helper = new Helper();
					$this->_html .= '<div class="cs_out_content"><label>Choose Parent Category</label><div class="margin-form">'.
					$helper->renderCategoryTree(null, $cate_selected, 'content_option[0][opt_id_parent_cat]', true, false, array(), false, true);
				$this->_html .= '</div></div>
				</div>
				<div class="option_type_1" style="display:none">
				<p>
				<label>'.$this->l('Show Image:').'</label> 
					<input class="opt_show_image_product" type="radio" name="content_option[1][opt_show_image_product]" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_image_product" type="radio" name="content_option[1][opt_show_image_product]" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
				<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size" name="content_option[1][opt_image_size_product]">';
				foreach ($imageTypes as $imageType)
				{
					$this->_html .= '<option  value="'.$imageType['name'].'">'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
				<p>
				<label>'.$this->l('Choose product').'</label>
				<input type="text" value="" id="opt_product_autocomplete_input" /></p>
				<input type="hidden" value="" id="input_hidden_id" name="content_option[1][input_hidden_id]"/>
				<input type="hidden" value="" id="input_hidden_name" name="content_option[1][input_hidden_name]"/>
				<div id="opt_result_product_autocomplete" class="margin-form"></div>
				</div>
				<div class="option_type_2" style="display:none">';
				$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
				$languages = Language::getLanguages(false);
				$divLangName = 'opt_content_static';
				$iso = Language::getIsoById((int)($cookie->id_lang));
				$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
				$ad = dirname($_SERVER["PHP_SELF"]);
				$this->_html .=  '
				<script type="text/javascript">	
				var iso = \''.$isoTinyMCE.'\' ;
				var pathCSS = \''._THEME_CSS_DIR_.'\' ;
				var ad = \''.$ad.'\' ;
				</script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
				<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>	
				<script type="text/javascript">
				$(document).ready(function(){		
					tinySetup({});});
				</script>
				<div class="cs_out_content">
				<label>'.$this->l('Content:').'</label>
				<div class="margin-form">';									
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="opt_content_static_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<textarea class="rte" name="content_option[2][opt_content_static]['.$language['id_lang'].']" id="opt_content_static'.$language['id_lang'].'" cols="100" rows="20">'.Tools::getValue('opt_content_static_'.$language['id_lang']).'</textarea>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'opt_content_static', true);
					$this->_html .= '</div></div>';
				$this->_html .= '</div>
				<div class="option_type_3" style="display:none">
				<label>'.$this->l('Show Image:').'</label> 
				<input class="opt_show_image_manu" type="radio" name="content_option[3][opt_show_image_manu]" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input class="opt_show_image_manu" type="radio" name="content_option[3][opt_show_image_manu]" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
				$this->_html .= '
					<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size" name="content_option[3][opt_image_size_manu]">';
				foreach ($imageTypes as $imageType)
				{
					$this->_html .= '<option  value="'.$imageType['name'].'">'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
				<p>
				<label>'.$this->l('Show Name:').'</label> 
				<input class="opt_show_name_manu" type="radio" name="content_option[3][opt_show_name_manu]" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input class="opt_show_name_manu" type="radio" name="content_option[3][opt_show_name_manu]" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
				<div class="cs_out_content">
				<label>'.$this->l('Choose Manufacturers:').'</label>
				<div class="margin-form">
				<table cellspacing="0" cellpadding="0" class="table" width="100%">
				<tbody>
				<tr class="nodrag nodrop">
				<th><input type="checkbox" name="content_option[3][opt_check-manu]" class="noborder" /></th>
				<th>'.$this->l('ID').'</th>
				<th>'.$this->l('Name').'</th>
				</tr>
				';
				$manu_list = Manufacturer ::getManufacturers();
				static $irow_manu = 0;
				foreach($manu_list as $manu)
				{
					$this->_html .= '
					<tr '.($irow_manu++ % 2 ? 'class="alt_row"' : '').'>
					<td><input type="checkbox" name="content_option[3][opt_list_manu][]" value="'.$manu['id_manufacturer'].'"/>'.'
					</td>
					<td>'.$manu['id_manufacturer'].'</td>
					<td>'.$manu['name'].'</td>
					</tr>
					';
				}
				$this->_html .= '
				</tbody>
				</table>
				</div>
				</div>
				</div>
				<div class="option_type_4" style="display:none">
				';
				$array_check_cms =  array();
				$this->_displayFormCMS($array_check_cms);
				$this->_html .='
				</div>
			</div>
			
			<div class="margin-form"><input type="submit" class="button pointer" name="saveSubmitOptionMenu" value="'.$this->l('Save').'" id="saveSubmitOptionMenu" />
		</div>
		</form>
		<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>
		';
	}
	
	private function _displayUpdateOptionForm()
	{
		global $currentIndex, $cookie;
		if (!Tools::getValue('id_option'))
		{
			$this->_html .= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>';
			return;
		}
		$menu_item = new CsMegaMenuClass(Tools::getValue('id_menu'));
		$option = new CsMegaMenuOptionClass((int)Tools::getValue('id_option'));
		if($option->type_option == 2) //check option static block
			$option->content_option =json_decode(htmlspecialchars_decode(($option->content_option)));
		else
			$option->content_option =json_decode($option->content_option);
		$this->_html .= '
		<link href="'._PS_JS_DIR_.'jquery/plugins/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/autocomplete/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="'.$this->_path.'js/csmegamenu.js"></script>
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="'.$this->l('Edit Option').'" title="'.$this->l('Edit option for menu ').$menu_item->title[(int)($cookie->id_lang)].'" /> '.$this->l('Edit option for menu ').$menu_item->title[(int)($cookie->id_lang)].'</legend>
		<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
		<div class="div_select_option">
					<div id="div_select_option">
					<p>
					<label>'.$this->l('Option:').'</label>
						<select name="type_option" onchange="displayFormOption(this.value);" style="width:150px;" >';
					foreach ($this->optionsMenu AS $key=>$optionValue){
						$this->_html .= '<option value="'.$key.'"'; 
						if($key == $option->type_option)  
							$this->_html .= 'selected';
						$this->_html .= '>'.$optionValue.'</option>';
					}
					$this->_html .= '
						</select>
					</p>
					<p>
					<label>'.$this->l('Fill the column:').'</label>
					<input type="text" class="opt_fill_column" size="20" name="content_option[0][opt_fill_column]" value="'.(isset($option->content_option->opt_fill_column) ? $option->content_option->opt_fill_column : '').'"/></p>
					</div>
			<div class="div_content_option">
				<div class="option_type_0" style="display:none">
					<p>
					<label>'.$this->l('Show Image:').'</label> 
					<input class="opt_show_image_cat" type="radio" name="content_option[0][opt_show_image_cat]" value="1"';
					if(isset($option->content_option->opt_show_image_cat))
						if($option->content_option->opt_show_image_cat == 1)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_image_cat" type="radio" name="content_option[0][opt_show_image_cat]" value="0"';
					if(isset($option->content_option->opt_show_image_cat))
						if($option->content_option->opt_show_image_cat == 0)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
					$imageTypes = ImageType ::getImagesTypes();
				$this->_html .= '
				<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size"  name="content_option[0][opt_image_size_cate]">';
				
				foreach ($imageTypes as $key_image=>$imageType)
				{
					$this->_html .= '<option';
					if(isset($option->content_option->opt_image_size_cate))
					{
						if(strcmp($imageType['name'],$option->content_option->opt_image_size_cate)==0)
							$this->_html .= ' selected';
					}
					$this->_html .= ' value="'.$imageType['name'].'" >'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
				<p>
					<label>'.$this->l('Show Sub Category:').'</label> 
					<input class="opt_show_sub_cat" name="content_option[0][opt_show_sub_cat]" type="radio" value="1"';
					if(isset($option->content_option->opt_show_sub_cat))
						if($option->content_option->opt_show_sub_cat == 1)
							$this->_html .= 'checked="checked"';
					$this->_html .= ' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_sub_cat" name="content_option[0][opt_show_sub_cat]" type="radio" value="0"';
					if(isset($option->content_option->opt_show_sub_cat))
						if($option->content_option->opt_show_sub_cat == 0)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
					<p>
					<label>'.$this->l('Show Parent Category:').'</label> 
					<input class="opt_show_parent_cat" type="radio" name="content_option[0][opt_show_parent_cat]" value="1"';
					if(isset($option->content_option->opt_show_parent_cat))
						if($option->content_option->opt_show_parent_cat == 1)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_parent_cat" type="radio" name="content_option[0][opt_show_parent_cat]" value="0"';
					if(isset($option->content_option->opt_show_parent_cat))
						if($option->content_option->opt_show_parent_cat == 0)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
					if(isset($option->content_option->opt_id_parent_cat))
						$cate_selected = array($option->content_option->opt_id_parent_cat);
					else
						$cate_selected = array();
					$helper = new Helper();
					$this->_html .= '<div class="cs_out_content"><label>Choose Parent Category</label>
					<div class="margin-form">
					'.
					$helper->renderCategoryTree(null, $cate_selected, 'content_option[0][opt_id_parent_cat]', true, false, array(), false, true);
				$this->_html .= '</div></div>
				</div>
				<div class="option_type_1" style="display:none">
				<p>
				<label>'.$this->l('Show Image:').'</label> 
					<input class="opt_show_image_product" type="radio" name="content_option[1][opt_show_image_product]" value="1"';
					if(isset($option->content_option->opt_show_image_product))
						if($option->content_option->opt_show_image_product == 1)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input class="opt_show_image_product" type="radio" name="content_option[1][opt_show_image_product]" value="0"';
					if(isset($option->content_option->opt_show_image_product))
						if($option->content_option->opt_show_image_product == 0)
							$this->_html .= 'checked="checked"';
					$this->_html .= '/>
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
					<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size" name="content_option[1][opt_image_size_product]">';
				foreach ($imageTypes as $key_image=>$imageType)
				{
					$this->_html .= '<option';
					if(isset($option->content_option->opt_image_size_product))
					{
						if(strcmp($imageType['name'],$option->content_option->opt_image_size_product)==0)
							$this->_html .= ' selected';
					}
					$this->_html .= ' value="'.$imageType['name'].'" >'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
				<p>
				<label>'.$this->l('Choose product').'</label>
				<input type="text" value="" id="opt_product_autocomplete_input" />
				</p>
				<input type="hidden" id="input_hidden_id" name="content_option[1][input_hidden_id]" value="'.(isset($option->content_option->input_hidden_id) ? $option->content_option->input_hidden_id : '').'"/>
				<input type="hidden" id="input_hidden_name" name="content_option[1][input_hidden_name]" value="'.(isset($option->content_option->input_hidden_id) ? $option->content_option->input_hidden_name : '').'"/>
				
				<div id="opt_result_product_autocomplete" class="margin-form">';
				if(isset($option->content_option->input_hidden_id))
				{
					$stringIdProducts = $option->content_option->input_hidden_id;
					$arrayIdProducts = explode('-',$stringIdProducts);
					$stringNameProducts = $option->content_option->input_hidden_name;
					$arrayNameProducts = explode('¤',$stringNameProducts);
					$products = array();
					foreach ($arrayIdProducts as $k=>$id_product)
					{
						
							if($id_product !== end($arrayIdProducts))
							{
								$proObj = new Product((int)$id_product,(int)($cookie->id_lang));
								//print_r($pO);
								if (Validate::isLoadedObject($proObj))
								{
									//die();
									$this->_html .= $arrayNameProducts[$k].'
									<span class="delProducts" name="'.$id_product.'" style="cursor: pointer;">
									<img src="../img/admin/delete.gif" alt="" />
									</span><br />';
								}
							}
					}
				}
				$this->_html .= '</div></div>
				<div class="option_type_2" style="display:none">';
				$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
				$languages = Language::getLanguages(false);
				$divLangName = 'opt_content_static';
				$iso = Language::getIsoById((int)($cookie->id_lang));
				$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
				$ad = dirname($_SERVER["PHP_SELF"]);
				$this->_html .=  '
				<script type="text/javascript">	
				var iso = \''.$isoTinyMCE.'\' ;
				var pathCSS = \''._THEME_CSS_DIR_.'\' ;
				var ad = \''.$ad.'\' ;
				</script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
				<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>	
				<script type="text/javascript">
				$(document).ready(function(){		
					tinySetup({});});
				</script>
				<div class="cs_out_content">
				<label>'.$this->l('Content:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						if(isset($option->content_option->opt_content_static->$language['id_lang']))
							$option->content_option->opt_content_static->$language['id_lang'] = str_replace($this->temp_url, _PS_BASE_URL_.__PS_BASE_URI__, $option->content_option->opt_content_static->$language['id_lang']);
						$this->_html .= '
					<div id="opt_content_static_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<textarea class="rte" name="content_option[2][opt_content_static]['.$language['id_lang'].']" id="opt_content_static'.$language['id_lang'].'" cols="100" rows="20">'.(isset($option->content_option->opt_content_static->$language['id_lang']) ? $option->content_option->opt_content_static->$language['id_lang'] : '').'</textarea>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'opt_content_static', true);
					$this->_html .= '</div></div>';
				$this->_html .= '</div>
				<div class="option_type_3" style="display:none">
				<p>
				<label>'.$this->l('Show Image:').'</label> 
				<input class="opt_show_image_manu" type="radio" name="content_option[3][opt_show_image_manu]" value="1"';
				if(isset($option->content_option->opt_show_image_manu))
						if($option->content_option->opt_show_image_manu == 1)
							$this->_html .= 'checked="checked"';
				$this->_html .= '/>
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input class="opt_show_image_manu" type="radio" name="content_option[3][opt_show_image_manu]" value="0"';
				if(isset($option->content_option->opt_show_image_manu))
						if($option->content_option->opt_show_image_manu == 0)
							$this->_html .= 'checked="checked"';
				$this->_html .= '/>
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>';
				$this->_html .= '
				<p>
					<label>'.$this->l('Size Image (W x H):').'</label>
					<select class="opt_img_size" name="content_option[3][opt_image_size_manu]">';
				foreach ($imageTypes as $key_image=>$imageType)
				{
					$this->_html .= '<option';
					if(isset($option->content_option->opt_image_size_manu))
					{
						if(strcmp($imageType['name'],$option->content_option->opt_image_size_manu)==0)
							$this->_html .= ' selected';
					}
					$this->_html .= ' value="'.$imageType['name'].'" >'.$imageType['name'].' - '.$imageType['width'].'x'.$imageType['height'].'</option>';
				}
				$this->_html .= '</select></p>
				<p>
				<label>'.$this->l('Show Name:').'</label> 
				<input class="opt_show_name_manu" type="radio" name="content_option[3][opt_show_name_manu]" value="1"';
				if(isset($option->content_option->opt_show_name_manu))
						if($option->content_option->opt_show_name_manu == 1)
							$this->_html .= 'checked="checked"';
				$this->_html .= '/>
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input class="opt_show_name_manu" type="radio" name="content_option[3][opt_show_name_manu]" value="0"';
				if(isset($option->content_option->opt_show_name_manu))
						if($option->content_option->opt_show_name_manu == 0)
							$this->_html .= 'checked="checked"';
				$this->_html .= '/>
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
				<div class="cs_out_content">
				<label>'.$this->l('Choose Manufacturers:').'</label>
				<div class="margin-form">
				<table cellspacing="0" cellpadding="0" class="table" width="100%">
				<tbody>
				<tr class="nodrag nodrop">
				<th><input type="checkbox" name="content_option[3][opt_check-manu]" class="noborder" value=""/></th>
				<th>'.$this->l('ID').'</th>
				<th>'.$this->l('Name').'</th>
				</tr>
				';
				$manu_list = Manufacturer ::getManufacturers(false,0,false);
				static $irow_manu = 0;
				foreach($manu_list as $manu)
				{
					$this->_html .= '
					<tr '.($irow_manu++ % 2 ? 'class="alt_row"' : '').'>
					<td><input type="checkbox"';
					if(isset($option->content_option->opt_list_manu))
					{
						if(in_array($manu['id_manufacturer'], $option->content_option->opt_list_manu))
						$this->_html .= ' checked=checked';
					}
					$this->_html .= ' name="content_option[3][opt_list_manu][]" value="'.$manu['id_manufacturer'].'"/>'.'
					</td>
					<td>'.$manu['id_manufacturer'].'</td>
					<td>'.$manu['name'].'</td>
					</tr>
					';
				}
				$this->_html .= '
				</tbody>
				</table>
				</div>
				</div>
				</div>
				<div class="option_type_4" style="display:none">';
				if(isset($option->content_option->footerBox))
					$arr_checked_cms_update = $option->content_option->footerBox;
				else
					$arr_checked_cms_update = array();
				$this->_displayFormCMS($arr_checked_cms_update);
				$this->_html .='
				</div>
			</div>
			<div class="margin-form"><input type="submit" class="button pointer" name="saveSubmitOptionMenu" value="'.$this->l('Save').'" id="saveSubmitOptionMenu" />
		</div>
		</form>
		<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>
		';
	}
	
	
	private function _displayForm()
	{
		global $currentIndex, $cookie;
	 	$this->_html .= '
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/autocomplete/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="'.$this->_path.'js/csmegamenu.js"></script>
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="Megamenu" /> '.$this->l('MegaMenu').'</legend>
			<form method="post" name="formMainMenu" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
			<p><a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addMenu"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> '.$this->l('Add a item menu').'</a></p><br/>
			<table width="100%" class="csmegamenu table tableDnD feature table_grid" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop" style="height:40px">
				<th class="center"><input type="checkbox" name="checkme" id="idCheckDelBoxesMenu" class="noborder" onclick="checkDelBoxesMenu(this.form, \'checkMenuItem[]\',this.checked)"></th>
				<th class="center">'.$this->l('Id item').'</th>
				<th class="center">'.$this->l('Title').'</th>
				<th class="center">'.$this->l('Link of title').'</th>
				<th class="center">'.$this->l('Description').'</th>
				<th class="center">'.$this->l('Icon').'</th>
				<th class="center">'.$this->l('Width (px)').'</th>
				<th class="center">'.$this->l('Number of column').'</th>
				<th class="center">'.$this->l('Number option').'</th>
				<th class="center">'.$this->l('Position').'</th>
				<th class="center">'.$this->l('Actions with menu').'</th>
				<th class="center">'.$this->l('Actions with option').'</th>
			</tr>
			</thead><tbody>';
		$menus = $this->getMenus();
		
		if (is_array($menus))
		{
			static $irow;
			foreach ($menus as $menu)
			{
				$menu_item = new CsMegaMenuClass($menu['id_menu']);
					$options_list = $menu_item->getOptionForMenu();
				$menu['link_of_title'] = str_replace($this->temp_url, _PS_BASE_URL_.__PS_BASE_URI__, $menu['link_of_title']);
				$menu_item = new CsMegaMenuClass($menu['id_menu']);
				$number_option = $menu_item->getNumberOptionForMenu();
				$stringConfirm='onclick="if (!confirm(\'Are you sure that you want to delete item menu id = '.$menu['id_menu'].' ?\')) return false "';
				$this->_html .= '
				<tr class="row_hover '.($irow++ % 2 ? 'alt_row' : '').'">
					<td class="pointer center"><input type="checkbox" name="checkMenuItem[]" class="noborder" value="'.$menu['id_menu'].'" onclick="checkCheckItemBox(this.form,\'checkme\',\'checkMenuItem[]\',this.checked)"></td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['id_menu'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['title'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['link_of_title'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['description'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.($menu['icon'] ? '<img style="width:30px;height:30px" src="'._PS_BASE_URL_._MODULE_DIR_.'csmegamenu/img/icon/'.$menu['icon'].'"/>' : '' ).'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['width'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$menu['number_column'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'\'">'.$number_option.'</td>
					<td class="pointer center">'.($menu !== end($menus) ? '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderMenu&id_menu='.$menu['id_menu'].'&way=1&position='.($menu['position']+1).'"><img src="'._PS_ADMIN_IMG_.'down.gif" alt="'.$this->l('Down').'" /></a>' : '').($menu !== reset($menus) ? '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderMenu&id_menu='.$menu['id_menu'].'&way=0&position='.($menu['position']-1).'"><img src="'._PS_ADMIN_IMG_.'up.gif" alt="'.$this->l('Up').'" /></a>' : '').'</td>
					<td class="pointer center">
					<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changeStatusMenu&id_menu='.$menu['id_menu'].'&status='.$menu['display'].'">'.($menu['display'] ? '<img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" />' : '<img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" />').'</a>
					<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editMenu&id_menu='.$menu['id_menu'].'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="Edit" title="Edit" /></a>
					<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteMenu&id_menu='.$menu['id_menu'].'\'" '.$stringConfirm.'><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="Delete" title="Delete" /></a>
					</td>
					<td class="pointer center">
					<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addOptionMenu&id_menu='.$menu['id_menu'].'"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="Add option" title="Add option" /></a>
					
					<a class="pointer" id="details_menu_'.$menu['id_menu'].'" title="'.$this->l('Show Options').'" onclick="if ($(\'#option_menu_'.$menu['id_menu'].'\').is(\':visible\'))$(this).find(\'img\').attr(\'src\', \'../img/admin/more.png\'); else $(this).find(\'img\').attr(\'src\', \'../img/admin/less.png\');$(\'#option_menu_'.$menu['id_menu'].'\').slideToggle(\'fast\');">
					<img id="image_more_options'.$menu['id_menu'].'" src="../img/admin/more.png" alt="'.$this->l('show Options').'" /></a>
					</td>
					</tr>
					';
					
					$menu_item = new CsMegaMenuClass($menu['id_menu']);
					$options_list = $menu_item->getOptionForMenu();
					$this->_html .= '<tr id="option_menu_'.$menu['id_menu'].'" style="display:none">
					<td colspan="10" class="td_option">';
					if(isset($options_list) && !empty($options_list))
					{
						
							$this->_html .= '<table class="table" cellpadding="0" cellspacing="0" style="width : 100%; margin:8px 0;">
							<thead>
							<tr class="nodrag nodrop">
								<th class="center">'.$this->l('ID').'</th>
								<th class="center">'.$this->l('Option Type').'</th>
								<th class="center">'.$this->l('Fill the column').'</th>
								<th class="center">'.$this->l('Position').'</th>
								<th class="center">'.$this->l('Actions').'</th></tr></thead><tbody>';
								$row_option = 0;
									foreach ($options_list as $option)
									{								
										if($option['type_option'] == 2) //check option static block
											$option['content_option'] =json_decode(htmlspecialchars_decode(($option['content_option'])));
										else
											$option['content_option'] =json_decode($option['content_option']);
									$stringConfirmOption='onclick="if (!confirm(\'Are you sure that you want to delete this item option?\')) return false "';
									$this->_html .= '<tr class="row_hover '.($row_option++ % 2 ? 'alt_row' : '').'">
										<input type="hidden" value="'.$menu['id_menu'].'" name="id_menu_hidden[]"/>
										<td class="center">'.$option['id_option'].'</td>
										<td class="center">';
										foreach ($this->optionsMenu as $k=>$ot)
										{
											if($k == $option['type_option'])
											{
												$this->_html .= $ot;
												break; 
											}
										}
										$this->_html .= '</td>
										<td class="pointer center">'.$option['content_option']->opt_fill_column.'</td>
										<td class="pointer center">'.($option !== end($options_list) ? '
										<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderOptionMenu&id_option='.$option['id_option'].'&way=1&position_option='.($option['position_option']+1).'&id_menu='.$option['id_menu'].'">
										<img src="'._PS_ADMIN_IMG_.'down.gif" alt="'.$this->l('Down').'" />
										</a>' : '').($option !== reset($options_list) ? '
										<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderOptionMenu&id_option='.$option['id_option'].'&way=0&position_option='.($option['position_option']-1).'&id_menu='.$option['id_menu'].'">
										<img src="'._PS_ADMIN_IMG_.'up.gif" alt="'.$this->l('Up').'" /></a>' : '').'</td>
										<td class="center">
										<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editOptionMenu&id_option='.$option['id_option'].'&id_menu='.$menu['id_menu'].'&type_option='.$option['type_option'].'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="'.$this->l('Edit Option').'" title="'.$this->l('Edit Option').'" /></a>
										<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteOptionMenu&id_option='.$option['id_option'].'\'" '.$stringConfirmOption.'><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="'.$this->l('Delete Option').'" title="'.$this->l('Delete Option').'" /></a>
										</td>
									</tr>';
									}
									$this->_html .= '</tbody>
									</table>';
					}
					else
					{
						$this->_html .= '<span>No option</span>';
					}
					$this->_html .= '</td>
					</tr>
					';
			}
		}
		$this->_html .= '</tbody></table><br/>
			<p>
			<input type="submit" class="button" name="submitDeleteMenus" value="Delete selected" onclick="return confirm(\'Delete selected items?\');">
			</p>
			<p><a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addMenu"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> '.$this->l('Add a item menu').'</a></p><br/>
			</form>
		</fieldset>';
	}
	
	private function _displayAddForm()
	{
		global $currentIndex, $cookie;
	 	// Language 
	 	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$divLangName = 'titlediv¤descriptiondiv';
		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('New Menu Item').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<label>'.$this->l('Title:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="titlediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="title_'.$language['id_lang'].'" value="'.Tools::getValue('title_'.$language['id_lang']).'" size="55" /><sup> *</sup>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Link of title:').'</label>
				<div class="margin-form">
					<input type="text" name="link_of_title" value="'.Tools::getValue('link_of_title').'" size="55" />
				</div>
				<label>'.$this->l('Description:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="descriptiondiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="description_'.$language['id_lang'].'" value="'.Tools::getValue('description_'.$language['id_lang']).'" size="55" />
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'descriptiondiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<label>'.$this->l('width:').'</label>
				<div class="margin-form">
					<input type="text" name="width" value="'.Tools::getValue('width').'" size="55" />
				</div>
				<label>'.$this->l('Number of column:').'</label>
				<div class="margin-form">
					<input type="text" name="number_column" value="'.Tools::getValue('number_column').'" size="55" />
				</div>
				<label>'.$this->l('Displayed:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" class="activediv" name="display" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" class="activediv" name="display" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Icon:').'</label>
				<div class="margin-form">
					<input type="file" name="icon" value="'.Tools::getValue('icon').'" size="55" />
				</div>
				<label>'.$this->l('Displayed Icon:').'</label>
				<div class="margin-form">
					<div id="activedivicon" style="float: left;">
						<input type="radio" class="activedivicon" name="display_icon" value="1"'.(Tools::getValue('display_icon',1) ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" class="activedivicon" name="display_icon" value="0"'.(Tools::getValue('display_icon',1) ? '' : 'checked="checked"').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				';
					$this->_html .='
				<div class="margin-form"><input type="submit" class="button pointer" name="saveMenu" value="'.$this->l('Save Menu').'" id="saveMenu" />';
					$this->_html .= '					
				</div>
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
	}
	
	private function _displayUpdateForm()
	{
		global $currentIndex, $cookie;
		if (!Tools::getValue('id_menu'))
		{
			$this->_html .= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>';
			return;
		}
	 	// Language 
	 	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$divLangName = 'titlediv¤descriptiondiv';
		$menu = new CsMegaMenuClass((int)Tools::getValue('id_menu'));
		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('New Menu Item').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<label>'.$this->l('Title:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="titlediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="title_'.$language['id_lang'].'" value="'.(isset($menu->title[$language['id_lang']]) ? $menu->title[$language['id_lang']] : '').'" size="55" /><sup> *</sup>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Link of title:').'</label>
				<div class="margin-form">
					<input type="text" name="link_of_title" value="'.$menu->link_of_title.'" size="55" />
				</div>
				<label>'.$this->l('Description:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="descriptiondiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="description_'.$language['id_lang'].'" value="'.(isset($menu->description[$language['id_lang']]) ? $menu->description[$language['id_lang']] : '').'" size="55" />
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'descriptiondiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Number of column:').'</label>
				<div class="margin-form">
					<input type="text" name="number_column" value="'.$menu->number_column.'" size="55" />
				</div>
				<label>'.$this->l('width:').'</label>
				<div class="margin-form">
					<input type="text" name="width" value="'.$menu->width.'" size="55" />
				</div>
				<label>'.$this->l('Displayed:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" class="activediv" name="display" value="1"'.($menu->display ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" class="activediv" name="display" value="0"'.($menu->display ? '' : 'checked="checked"').'/>
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Icon:').'</label>
				<div class="margin-form">
					<input type="hidden" name="icon_hidden" value="'.$menu->icon.'" size="55" />
					<input type="file" name="icon" value="'.$menu->icon.'" size="55" />
				</div><span style="float:right;margin-right:730px;margin-top:-41px">
				'.($menu->icon ? '<img style="width:30px;height:30px" src="'._PS_BASE_URL_._MODULE_DIR_.'csmegamenu/img/icon/'.$menu->icon.'"/>' : '' ).'</span>
				<label>'.$this->l('Displayed Icon:').'</label>
				<div class="margin-form">
					<div id="activedivicon" style="float: left;">
						<input type="radio" class="activedivicon" name="display_icon" value="1"'.($menu->display_icon ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" class="activedivicon" name="display_icon" value="0"'.($menu->display_icon ? '' : 'checked="checked"').'/>
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				';
					$this->_html .='
				<div class="margin-form"><input type="submit" class="button pointer" name="saveMenu" value="'.$this->l('Save Menu').'" id="saveMenu" />';
					$this->_html .= '					
				</div>
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
	}
	
	private function _postProcess()
	{
		global $currentIndex;
		$errors = array();
		if (Tools::isSubmit('saveMenu'))
		{
			$mg_menu = new CsMegaMenuClass(Tools::getValue('id_menu'));
			$mg_menu->copyFromPost();
			$errors = $mg_menu->validateController();
			if (sizeof($errors))
			{
				$this->_html .= $this->displayError(implode('<br />', $errors));
			}
			else
			{
				Tools::getValue('id_menu') ? $mg_menu->update() : $mg_menu->add();
				$this->_clearCache('csmegamenu.tpl');
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveMenuConfirmation');
			}
		}
		elseif (Tools::isSubmit('saveSubmitOptionMenu'))
		{
			$mg_menu_option = new CsMegaMenuOptionClass(Tools::getValue('id_option'));
			$errors =  $mg_menu_option->validateController();
			if (isset($errors) && $errors != '')
			{
				$this->_html .= $this->displayError($errors);
			}
			else
			{
				$mg_menu_option->copyFromPostOption();
				Tools::getValue('id_option') ? $mg_menu_option->update() : $mg_menu_option->add();
				$this->_clearCache('csmegamenu.tpl');
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveMenuOptionConfirmation&id_menu='.$mg_menu_option->id_menu);
			}
		}
		elseif (Tools::isSubmit('applyOptions'))
		{
			if ($error = $this->saveXmlOption())
				$this->_html .= $error;
			else
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('resetOptions'))
		{
			if ($error = $this->saveXmlOption(true))
				$this->_html .= $error;
			else
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('changeStatusMenu') AND Tools::getValue('id_menu'))
		{
			$mg_menu = new CsMegaMenuClass(Tools::getValue('id_menu'));
			$mg_menu->updateStatus(Tools::getValue('status'));
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('deleteMenu') AND Tools::getValue('id_menu'))
		{
			$mg_menu = new CsMegaMenuClass(Tools::getValue('id_menu'));
			$options = $mg_menu->getOptionForMenu();
			if(!empty($options))
			{
				foreach ($options as $option)
				{
					$mg_menu_option = new CsMegaMenuOptionClass($option['id_option']);
					$mg_menu_option->delete();
					$mg_menu_option->cleanPositionsOption();
				}
			}
			$mg_menu->delete();
			$mg_menu->cleanPositions();
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteMenuConfirmation');
		}
		elseif (Tools::isSubmit('submitDeleteMenus'))
		{
			if(empty($_POST['checkMenuItem']))
			{
				$this->_html = $this->displayError($this->l('You must select at least one element to delete.'));
				return;
			}
			foreach($_POST['checkMenuItem'] as $IDMenu)
			{
				$mg_menu = new CsMegaMenuClass($IDMenu);
				$options = $mg_menu->getOptionForMenu();
				if(!empty($options))
				{
					foreach ($options as $option)
					{
						$mg_menu_option = new CsMegaMenuOptionClass($option['id_option']);
						$mg_menu_option->delete();
						$mg_menu_option->cleanPositionsOption();
					}
				}
				$mg_menu->delete();
				$mg_menu->cleanPositions();
			}
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteMenuConfirmation');
		}
		elseif (Tools::isSubmit('orderMenu') AND Validate::isInt(Tools::getValue('id_menu')) AND Validate::isInt(Tools::getValue('position')))
		{
			$mg_menu = new CsMegaMenuClass(Tools::getValue('id_menu'));
			$mg_menu->updatePosition(Tools::getValue('way'),Tools::getValue('position'));
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changePositionConfirmation');
		}
		elseif (Tools::isSubmit('orderOptionMenu') AND Validate::isInt(Tools::getValue('id_option')) AND Validate::isInt(Tools::getValue('position_option')))
		{
			$mg_menu_option = new CsMegaMenuOptionClass(Tools::getValue('id_option'));
			$mg_menu_option->updatePositionOption(Tools::getValue('way'),Tools::getValue('position_option'));
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changPositionOptionMenuConfirmation&id_menu='.Tools::getValue('id_menu').'');
		}
		elseif (Tools::isSubmit('deleteOptionMenu') AND Tools::getValue('id_option'))
		{
			$mg_menu_option = new CsMegaMenuOptionClass(Tools::getValue('id_option'));
			$mg_menu_option->delete();
			$mg_menu_option->cleanPositionsOption();
			$this->_clearCache('csmegamenu.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteOptionMenuConfirmation&id_menu='.$mg_menu_option->id_menu.'');
		}
		elseif (Tools::isSubmit('saveMenuConfirmation'))
			$this->_html .= $this->displayConfirmation($this->l('Menu has been added successfully'));
		elseif (Tools::isSubmit('deleteOptionMenuConfirmation'))
		{
			$this->_html = '
			<script type="text/javascript">
			$(document).ready(function() {
				$("#option_menu_'.Tools::getValue('id_menu').'").show();
				$("#image_more_options'.Tools::getValue('id_menu').'").attr(\'src\', \'../img/admin/less.png\');
			});</script>';
			$this->_html .= $this->displayConfirmation($this->l('Option has been deleted successfully'));
		}
		elseif (Tools::isSubmit('changPositionOptionMenuConfirmation'))
		{
			$this->_html = '
			<script type="text/javascript">
			$(document).ready(function() {
				$("#option_menu_'.Tools::getValue('id_menu').'").show();
				$("#image_more_options'.Tools::getValue('id_menu').'").attr(\'src\', \'../img/admin/less.png\');
			});</script>';
			$this->_html .= $this->displayConfirmation($this->l('Change position option has been deleted successfully'));
		}
		elseif (Tools::isSubmit('saveMenuOptionConfirmation'))
		{
			$this->_html = '
				<script type="text/javascript">
				$(document).ready(function() {
					$("#option_menu_'.Tools::getValue('id_menu').'").show();
					$("#image_more_options'.Tools::getValue('id_menu').'").attr(\'src\', \'../img/admin/less.png\');
				});</script>';
			$this->_html .= $this->displayConfirmation($this->l('Option of menu has been saved successfully'));
		}
		elseif (Tools::isSubmit('changePositionConfirmation'))
			{
			$this->_html = $this->displayConfirmation($this->l('Change position successfully'));
			}
	}
	
	private function _displayOptions()
	{
		$option = simplexml_load_file(dirname(__FILE__).'/'.'option.xml');
		$this->_html .= '
		<br/>
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Megamenu Options').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
			
			<label>'.$this->l('Add More Item for Ipad horizontal:').'</label>
			<div class="margin-form">
				<input type="text" name="moreipadh" value="'.($option->moreipadh ? $option->moreipadh : 0).'"/>
				<p class="clear">'.$this->l('Add More-item after the xth menu item. Ex: 6,7,8... If =0,will not add More-item').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Add More Item for Ipad vertical:').'</label>
			<div class="margin-form">
				<input type="text" name="moreipadv" value="'.($option->moreipadv ? $option->moreipadv : 0).'"/>
				<p class="clear">'.$this->l('Add More-item after the xth menu item. Ex: 5,6,7... If =0,will not add More-item').'</p>
				<div class="clear"></div>
			</div>
			<div class="margin-form">';
				$this->_html .= '
				<input type="submit" class="button" name="applyOptions" value="'.$this->l('Apply').'" id="applyOptions" />
				<input type="submit" class="button" name="resetOptions" value="'.$this->l('Reset').'" id="resetOptions" />';
				$this->_html .= '					
			</div>';
		$this->_html .= '
			</form>
		</fieldset>';
	}
	
	private function saveXmlOption($reset = false)
	{
		$error = false;
		$newXml = '<?xml version=\'1.0\' encoding=\'utf-8\' ?>'."\n".'<options>'."\n";
		
		$newXml .= '<moreipadh>';
		$newXml .= ($reset ? 0 : Tools::getValue('moreipadh'));
		$newXml .= '</moreipadh>'."\n";
		
		$newXml .= '<moreipadv>';
		$newXml .= ($reset ? 0 : Tools::getValue('moreipadv'));
		$newXml .= '</moreipadv>'."\n";
		
		$newXml .= '</options>'."\n";
		if ($fd = @fopen(dirname(__FILE__).'/'.'option.xml', 'w'))
		{
			if (!@fwrite($fd, $newXml))
				$error = $this->displayError($this->l('Unable to write to the editor file.'));
			if (!@fclose($fd))
				$error = $this->displayError($this->l('Can\'t close the editor file.'));
		}
		else
			$error = $this->displayError($this->l('Unable to update the editor file. Please check the editor file\'s writing permissions.'));
		return $error;
	}
	
	public function getContent()
   	{
		$this->context->controller->addCss($this->_path.'css/csmegamenu_admin.css', 'all');//css for admin form
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		$this->_postProcess();
		if (Tools::isSubmit('addMenu'))
			$this->_displayAddForm();
		elseif (Tools::isSubmit('addOptionMenu'))
		$this->_displayAddOptionForm();
		elseif (Tools::isSubmit('editMenu'))
			$this->_displayUpdateForm();
		elseif (Tools::isSubmit('editOptionMenu'))
		{
			$type_option = Tools::getValue('type_option');
			$this->_html.='
				<script type="text/javascript">
			$(document).ready(function() {
				$(".option_type_'.$type_option.'").show();
			});</script>';
			$this->_displayUpdateOptionForm();
		}
		else
			$this->_displayForm();
		
		$this->_displayOptions();
		return $this->_html;
	}
	
	private function getMenus($active = null) //case in : allshop show shop default
	{
		$this->context = Context::getContext();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
	 	if (!$result = Db::getInstance()->ExecuteS(
			'SELECT ms.*, ml.`title`,ml.`description`,m.`icon`
			FROM `'._DB_PREFIX_.'csmegamenu` m
			LEFT JOIN `'._DB_PREFIX_.'csmegamenu_shop` ms ON (m.`id_menu` = ms.`id_menu` )
			LEFT JOIN `'._DB_PREFIX_.'csmegamenu_lang` ml ON (m.`id_menu` = ml.`id_menu` '.( $id_shop ? 'AND ml.`id_shop` = '.$id_shop : ' ' ).') 
			WHERE ml.id_lang = '.(int)$id_lang.
			($active ? ' AND ms.`display` = 1' : ' ').
			( $id_shop ? 'AND ms.`id_shop` = '.$id_shop : ' ' ).'
			ORDER BY ms.`position` ASC'))
	 		return false;
	 	return $result;
	}
	
	
	/*For front end*/
	public function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0)
	{
		if (is_null($id_category))
			$id_category = $this->context->shop->getCategory();

		$children = array();
		if (isset($resultParents[$id_category]) && count($resultParents[$id_category]) && ($maxDepth == 0 || $currentDepth < $maxDepth))
			foreach ($resultParents[$id_category] as $subcat)
				$children[] = $this->getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
		if (!isset($resultIds[$id_category]))
			return false;
		$return = array('id' => $id_category, 'link' => $this->context->link->getCategoryLink($id_category, $resultIds[$id_category]['link_rewrite']),
					 'name' => $resultIds[$id_category]['name'], 'desc'=> $resultIds[$id_category]['description'],
					 'children' => $children);
		return $return;
	}
	public function getAllSubCategory ($id_parent)
	{
		global $cookie;
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_customer = intval($cookie->id_customer);
		$maxdepth = 5;
		$row = Db::getInstance()->getRow('
		SELECT `level_depth`
		FROM '._DB_PREFIX_.'category c
		WHERE c.`id_category` = '.intval($id_parent));
		$maxdepth = $maxdepth + $row['level_depth'];
		if (!$result = Db::getInstance()->ExecuteS('
		SELECT DISTINCT c.*, cl.*
		FROM `'._DB_PREFIX_.'category` c 
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = '.(int)Context::getContext()->language->id.')
		LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cg.`id_category` = c.`id_category`)
		WHERE 1 AND cl.id_shop = '.$id_shop
		.(intval($maxdepth) != 0 ? ' AND `level_depth` <= '.intval($maxdepth) : '').'
		AND cg.`id_group` '.(!$cookie->id_customer ?  '= 1' : 'IN (SELECT id_group FROM '._DB_PREFIX_.'customer_group WHERE id_customer = '.intval($cookie->id_customer).')').'
		ORDER BY `level_depth` ASC'))
			return;
		$resultParents = array();
		$resultIds = array();

		foreach ($result as $row)
		{
			$resultParents[$row['id_parent']][] = $row;
			$resultIds[$row['id_category']] = $row;
		}
		
		$blockCategTree = $this->getTree($resultParents, $resultIds, $maxdepth,$id_parent);
		return $blockCategTree;
	}
	public static function getCMStitles($cmsCategories)
	{
		global $cookie;
		$content = array();
		$link = new Link();
		$id_cms_temp = 0;
		foreach ($cmsCategories AS $key=>$cmsCategory)
		{
			$ids = explode('_', $cmsCategory);
			$cms = new CMS((int)$ids[1], (int)$cookie->id_lang);
			if (Validate::isLoadedObject($cms) && $cms->active == 1)
			{
				if ($ids[0] == 1)
				{
					$query = Db::getInstance()->getRow('
					SELECT cl.`name`, cl.`link_rewrite`
					FROM `'._DB_PREFIX_.'cms_category_lang` cl
					INNER JOIN `'._DB_PREFIX_.'cms_category` c ON (cl.`id_cms_category` = c.`id_cms_category`)
					WHERE cl.`id_cms_category` = '.(int)$ids[1].' AND (c.`active` = 1 OR c.`id_cms_category` = 1)
					AND cl.`id_lang` = '.(int)$cookie->id_lang);
					$content[$id_cms_temp]['link'] = $link->getCMSCategoryLink((int)$ids[1], $query['link_rewrite']);
					$content[$id_cms_temp]['meta_title'] = $query['name'];
				}
				elseif (!$ids[0])
				{
					$query = Db::getInstance()->getRow('
					SELECT cl.`meta_title`, cl.`link_rewrite` 
					FROM `'._DB_PREFIX_.'cms_lang` cl
					INNER JOIN `'._DB_PREFIX_.'cms` c ON (cl.`id_cms` = c.`id_cms`)
					WHERE cl.`id_cms` = '.(int)$ids[1].' AND c.`active` = 1
					AND cl.`id_lang` = '.(int)$cookie->id_lang);
					
					$content[$id_cms_temp]['link'] = $link->getCMSLink((int)$ids[1], $query['link_rewrite']);
					$content[$id_cms_temp]['meta_title'] = $query['meta_title'];
				}
				$id_cms_temp++;
			}
		}
		return $content;
	}
	
	private function getMenuDisplay()
	{
		global $cookie;
		$menus = array();
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$results = Db::getInstance()->ExecuteS(
					'SELECT ms.`id_menu` FROM `'._DB_PREFIX_.'csmegamenu_shop` ms
					LEFT JOIN `'._DB_PREFIX_.'csmegamenu` m ON (ms.id_menu = m.id_menu)
					WHERE (ms.id_shop = '.(int)$id_shop.')
					AND ms.`display` = 1 ORDER BY ms.`position` ASC
				');
		foreach ($results as $row)
		{
			$menus[$row['id_menu']] = new CsMegaMenuClass($row['id_menu']);
			if($menus[$row['id_menu']]->number_column !=0)
				$menus[$row['id_menu']]->width_item = $menus[$row['id_menu']]->width/($menus[$row['id_menu']]->number_column!= 0 ? $menus[$row['id_menu']]->number_column : 1);
			else
				$menus[$row['id_menu']]->width_item = $menus[$row['id_menu']]->width;
			$menus[$row['id_menu']]->options = $menus[$row['id_menu']]->getOptionForMenu();
			if($menus[$row['id_menu']]->options)
			{
				foreach ($menus[$row['id_menu']]->options as $key=>$option)
				{
					
					if($option['type_option'] == 2) //check option static block
					{
						$option['content_option'] = json_decode(htmlspecialchars_decode(($option['content_option'])));
						$languages = Language::getLanguages(false);
						foreach ($languages AS $language)
						{
							$option['content_option']->opt_content_static->$language['id_lang'] = str_replace($this->temp_url, _PS_BASE_URL_.__PS_BASE_URI__, $option['content_option']->opt_content_static->$language['id_lang']);
						}
					}
					else
						$option['content_option'] = json_decode($option['content_option']);
					$option['width'] = $menus[$row['id_menu']]->width_item * $option['content_option']->opt_fill_column;
					//get content for type option
					if($option['type_option'] == 0)//option 0 : type category
					{
						//if($option['content_option']->opt_show_parent_cat == 1)
						//{
							$option['category_parent']= new Category($option['content_option']->opt_id_parent_cat,(int)Context::getContext()->language->id);
						//}
						$option['sub_category'] = $this->getAllSubCategory($option['content_option']->opt_id_parent_cat);
					}
					if($option['type_option'] == 1) //option 1 : type product
					{
						$stringIdProducts = $option['content_option']->input_hidden_id;
						$arrayIdProducts = explode('-',$stringIdProducts);
						$id_temp = 0;
						foreach($arrayIdProducts as $k=>$id)
							if($id !== end($arrayIdProducts))
							{
								$proObj = new Product((int)$id, true, $this->context->language->id, $this->context->shop->id);
								if(Validate::isLoadedObject($proObj))
								{
									
									$option['product_list'][$id_temp] = $proObj;
									$option['product_list'][$id_temp]->images = Product::getCover((int)$id);
									$id_temp++;
								}
							}
					}
					//option 2: static block available
					if($option['type_option'] == 3) //option 3 : manufacturer
					{
						if(isset($option['content_option']->opt_list_manu))
						{
							$manu_temp = 0;
							foreach($option['content_option']->opt_list_manu as $k_manu=>$id_manu)
							{
								$manuObj = new Manufacturer((int)$id_manu,$this->context->language->id);
								if(Validate::isLoadedObject($manuObj))
								{
									$option['opt_list_manu_info'][$manu_temp] = $manuObj;
									$manu_temp++;
								}
							}
						}
					}
					if($option['type_option'] == 4) //option 4: cms (information)
					{
						if(isset($option['content_option']->footerBox) && $option['content_option']->footerBox)
						$option['cms'] = $this->getCMStitles($option['content_option']->footerBox);
					}
					$menus[$row['id_menu']]->options[$key] = $option;
					
				}
			}
			
		}

		return $menus;
	}
	
	/*-------------------------------------------------------------*/    
           
        public function _getRespCategories($id_category = 1, $id_lang = false, $id_shop = false){
        
            $id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
            $category = new Category((int)$id_category, (int)$id_lang, (int)$id_shop);

            if (is_null($category->id)){
                return;
            }

            $children = Category::getChildren((int)$id_category, (int)$id_lang, true, (int)$id_shop);
            
            
            $class = "";
            if (isset($children) && count($children) && $category->level_depth > 1){
                $class .= "parent ";
            }

                        
            if ($category->level_depth > 1){
                $cat_link = $category->getLink();
            }else{
                $cat_link = $this->context->link->getPageLink('index');
            }
            
            $is_intersected = array_intersect($category->getGroups(), $this->user_groups);
                                    
            if (!empty($is_intersected)){
                $this->_respMenu .= '<li class="'.$class.'">';
                $this->_respMenu .= '<a href="'.$cat_link.'"><span>'.$category->name.'</span></a>';
            }
            
            if (isset($children) && count($children)){
                
                $this->_respMenu .= '<ul>';
                
                foreach ($children as $child){
                        $this->_getRespCategories((int)$child['id_category'], (int)$id_lang, (int)$child['id_shop']);
                }

                $this->_respMenu .= '</ul>';
                
            }
			 if (!empty($is_intersected)){
				$this->_respMenu .= '</li>';
			}
           
            return $this->_respMenu;
     }
    
    
    
/*-------------------------------------------------------------*/
	
    public function _buildResponsiveMenu(){
 
		
        return $this->_getRespCategories(1, (int)Context::getContext()->language->id, $id_shop = false);
        
    }
  	
	public function hookDisplayHeader()
	{
		global $smarty;
		$smarty->assign(array(
			'CS_MEGA_MENU' => Hook::Exec('csmegamenu')
		));
		$this->context->controller->addCSS(($this->_path).'css/csmegamenu_front.css', 'all');
		$this->context->controller->addJS(($this->_path).'js/csmegamenu_front.js');
		$this->context->controller->addJS(($this->_path).'js/csmegamenu_addmore.js');
	}
	
	function hookCsMegaMenu($params)
	{
		global $smarty, $cookie;
		if (!$this->isCached('csmegamenu.tpl', $this->getCacheId('csmegamenu')))
		{
			$this->user_groups = ($this->context->customer->getGroups());
			$option_megamenu = simplexml_load_file(dirname(__FILE__).'/'.'option.xml');
			$menus = $this->getMenuDisplay();
			$responsive_menu = $this->_buildResponsiveMenu();
			$smarty->assign(array(
				'menus' => $menus,
				'ps_manu_img_dir' => _PS_MANU_IMG_DIR_,
				'ps_cat_img_dir' => _PS_CAT_IMG_DIR_,
				'path_icon' => _PS_BASE_URL_._MODULE_DIR_.'csmegamenu/img/icon/',
				'responsive_menu' => $responsive_menu,
				'option_megamenu' => $option_megamenu
			));
		}
		return $this->display(__FILE__, 'csmegamenu.tpl',$this->getCacheId('csmegamenu'));
	}
	public function hookActionObjectCategoryUpdateAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectCategoryDeleteAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectCmsUpdateAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectCmsDeleteAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}

	public function hookActionObjectManufacturerUpdateAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectManufacturerDeleteAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectProductUpdateAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookActionObjectProductDeleteAfter($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	
	public function hookCategoryUpdate($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
	public function hookActionUpdateQuantity($params)
	{
		$this->_clearCache('csmegamenu.tpl');
	}
}

?>
