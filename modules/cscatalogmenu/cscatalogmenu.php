<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class CsCatalogMenu extends Module
{
	function __construct()
	{
		$this->name = 'cscatalogmenu';
		$this->tab = 'MyBlocks';
		$this->version = 1.0;
		$this->author = 'Codespot';

		parent::__construct();

		$this->displayName = $this->l('CS Catalog Menu block');
		$this->description = $this->l('Adds a block featuring product subcategories');
	}

	function install()
	{
		Configuration::updateValue('CS_CATALOG_MENU', 1);
		if (!parent::install() OR
			!$this->registerHook('leftColumn') OR
			!$this->registerHook('header') OR
			!$this->registerHook('actionObjectCategoryUpdateAfter') OR
			!$this->registerHook('actionObjectCategoryDeleteAfter')
			)
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitWeddingouscatalogmenu'))
		{
			$cat = Tools::getValue('cscatalogmenu');
			Configuration::updateValue('CS_CATALOG_MENU', $cat);
			
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$categories = Category::getCategories((int)Context::getContext()->language->id, false);
		$cscatalogmenu = Configuration::get('CS_CATALOG_MENU');
		$trads = array(
					 'Home' => $this->l('Home'), 
					 'selected' => $this->l('selected'), 
					 'Collapse All' => $this->l('Collapse All'), 
					 'Expand All' => $this->l('Expand All')
				);
		$output = '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>Choose Root Category</label>
				<div class="margin-form">';
				$helper = new Helper();
				$output .= $helper->renderCategoryTree(null, array($cscatalogmenu), 'cscatalogmenu', true,false, array(), false, true);
			$output .='</div>
				<br/>
				<center><input type="submit" name="submitWeddingouscatalogmenu" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		
		return $output;
	}
	
	public function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0)
	{
		if (is_null($id_category))
			$id_category = $this->context->shop->getCategory();

		$children = array();
		if (isset($resultParents[$id_category]) && count($resultParents[$id_category]) && ($maxDepth == 0 || $currentDepth < $maxDepth))
		{
		
			foreach ($resultParents[$id_category] as $subcat)
				$children[] = $this->getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
		}
		if (!isset($resultIds[$id_category]))
		{
			return false;
		}
		$return = array('id' => $id_category, 'link' => $this->context->link->getCategoryLink($id_category, $resultIds[$id_category]['link_rewrite']),
					 'name' => $resultIds[$id_category]['name'], 'desc'=> $resultIds[$id_category]['description'],
					 'children' => $children);
		return $return;
	}

	function hookLeftColumn($params)
	{
		global $smarty, $cookie;

			$id_customer = intval($params['cookie']->id_customer);
			$maxdepth = 5;
			$id_parent = Configuration::get('CS_CATALOG_MENU');
			$groups = $id_customer ? implode(', ', Customer::getGroupsStatic($id_customer)) : Configuration::get('PS_UNIDENTIFIED_GROUP');
			$row = Db::getInstance()->getRow('
			SELECT `level_depth`
			FROM '._DB_PREFIX_.'category c
			WHERE c.`id_category` = '.intval($id_parent));
			$maxdepth = $maxdepth + $row['level_depth'];
			$id_lang = (int)$params['cookie']->id_lang;
			if (!$result = Db::getInstance()->ExecuteS('SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
					FROM `'._DB_PREFIX_.'category` c
					INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.$id_lang.Shop::addSqlRestrictionOnLang('cl').')
					INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int)$this->context->shop->id.')
					WHERE (c.`active` = 1 OR c.`id_category` = '.(int)Configuration::get('PS_ROOT_CATEGORY').')
					AND c.`id_category` != '.(int)Configuration::get('PS_ROOT_CATEGORY').'
					'.((int)$maxdepth != 0 ? ' AND `level_depth` <= '.(int)$maxdepth : '').'
					AND c.id_category IN (SELECT id_category FROM `'._DB_PREFIX_.'category_group` WHERE `id_group` IN ('.pSQL($groups).'))
					ORDER BY `level_depth` ASC, cs.`position` ASC '))
					return Tools::restoreCacheSettings();
			$resultParents = array();
			$resultIds = array();
			
			foreach ($result as $row)
			{
				$resultParents[$row['id_parent']][] = $row;
				$resultIds[$row['id_category']] = $row;
			}
			$blockCategTree = $this->getTree($resultParents, $resultIds, Configuration::get('BLOCK_CATALOGMENU_MAX_DEPTH'),$id_parent, 0);
			$isDhtml = true;

			if (isset($_GET['id_category']))
			{
				$cookie->last_visited_category = intval($_GET['id_category']);
				$smarty->assign('currentCategoryId', intval($_GET['id_category']));	
			}
			if (isset($_GET['id_product']))
			{			
				if (!isset($cookie->last_visited_category) OR !Product::idIsOnCategoryId(intval($_GET['id_product']), array('0' => array('id_category' => $cookie->last_visited_category))))
				{
					$product = new Product(intval($_GET['id_product']));
					if (isset($product) AND Validate::isLoadedObject($product))
						$cookie->last_visited_category = intval($product->id_category_default);
				}
				$smarty->assign('currentCategoryId', intval($cookie->last_visited_category));
			}	
			$smarty->assign('blockCategTree', $blockCategTree);
			
			if (file_exists(_PS_THEME_DIR_.'modules/cscatalogmenu/cscatalogmenu.tpl'))
				$smarty->assign('branche_tpl_path', _PS_THEME_DIR_.'modules/cscatalogmenu/category-tree-branch.tpl');
			else
				$smarty->assign('branche_tpl_path', _PS_MODULE_DIR_.'cscatalogmenu/category-tree-branch.tpl');
			$smarty->assign('isDhtml', $isDhtml);
			$rootcat = new Category ($id_parent, intval($params['cookie']->id_lang));
			$smarty->assign('title', $rootcat->name);
		
		return $this->display(__FILE__, 'cscatalogmenu.tpl');
	}
	
	function hookRightColumn($params)
	{
		
		return $this->hookLeftColumn($params);
	}
	public function hookHeader()
	{
		$this->context->controller->addCss(($this->_path).'cscatalogmenu.css', 'all'); 
		//$this->context->controller->addJs(_THEME_JS_DIR_.'tools/treeManagement.js'); 
	}
	public function hookActionObjectCategoryUpdateAfter($params)
	{
		$this->_clearCache('cscatalogmenu.tpl');
	}
	
	public function hookActionObjectCategoryDeleteAfter($params)
	{
		$this->_clearCache('cscatalogmenu.tpl');
	}
}

?>
