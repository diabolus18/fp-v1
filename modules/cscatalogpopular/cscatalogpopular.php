<?php
if (!defined('_CAN_LOAD_FILES_'))
	exit;

class CsCatalogPopular extends Module
{
	public function __construct()
	{
		$this->name = 'cscatalogpopular';
		$this->tab = 'MyBlock';
		$this->version = '1.0';
		$this->author = 'CodeSpot';

		parent::__construct();

		$this->displayName = $this->l('CS Block categories popular');
		$this->description = $this->l('Adds a block categories popular on your homepage');
	}

	public function install()
	{
		if (!Configuration::updateValue('POPULAR_CAT', '',false,null,Configuration::get('PS_SHOP_DEFAULT')) ||
			!parent::install() ||
			!$this->registerHook('homeleft') ||
			!$this->registerHook('header') ||
			!$this->registerHook('actionObjectCategoryUpdateAfter') ||
			!$this->registerHook('actionObjectCategoryDeleteAfter') ||
			!$this->registerHook('actionObjectProductUpdateAfter') ||
			!$this->registerHook('actionObjectProductDeleteAfter') ||
			!$this->registerHook('categoryUpdate'))
			return false;
		return true;
	}

	public function uninstall()
	{
		Configuration::deleteByName('POPULAR_CAT');
		if (!parent::uninstall())
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitcatalogauto'))
		{
			if(Tools::getValue('categoryBox')!='')
			{
				$cat = implode(",", Tools::getValue('categoryBox'));
				if (Shop::getContext() != Shop::CONTEXT_SHOP)
					foreach (Shop::getContextListShopID() as $id_shop)
					{
						Configuration::updateValue('POPULAR_CAT', $cat,false,null,$id_shop);
					}
				else
					Configuration::updateValue('POPULAR_CAT', $cat);
				
			}
			else
				Configuration::updateValue('POPULAR_CAT', '');
			$this->_clearCache('cscatalogpopular.tpl');
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}
	public static function getCheckboxCatalog($arrCheck,$categories, $current, $id_category = 1, $has_suite = array())
	{
		global $done;
		static $irow;

		if (!isset($done[$current['infos']['id_parent']]))
			$done[$current['infos']['id_parent']] = 0;
		$done[$current['infos']['id_parent']] += 1;
		if(isset($categories[$current['infos']['id_parent']]))
			$todo = sizeof($categories[$current['infos']['id_parent']]);
		$doneC = $done[$current['infos']['id_parent']];

		$level = $current['infos']['level_depth'] + 1;
		
		if($id_category != 1)
		{
			$result = '
			<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
				<td>
					<input type="checkbox" name="categoryBox[]" class="categoryBox" id="categoryBox_'.$id_category.'" value="'.$id_category.'"'.(in_array($id_category, $arrCheck) ? ' checked="checked"' : '').'/>
				</td>
				<td>
					'.$id_category.'
				</td>
				<td>';
				for ($i = 2; $i < $level; $i++)
					$result .= '<img src="../img/admin/lvl_'.$has_suite[$i - 2].'.gif" alt="" />';
				$result .= '<img style="vertical-align:middle" src="../img/admin/'.($level == 1 ? 'lv1.gif' : 'lv2_'.($todo == $doneC ? 'f' : 'b').'.gif').'" alt="" /> &nbsp;
				<label for="categoryBox_'.$id_category.'" class="t">'.stripslashes($current['infos']['name']).'</label></td>
			</tr>';
		}
		else
			$result = '';
		
		if ($level > 1)
			$has_suite[] = ($todo == $doneC ? 0 : 1);

		if (isset($categories[$id_category]))
			foreach ($categories[$id_category] AS $key => $row)
				if ($key != 'infos')
					$result.= self::getCheckboxCatalog($arrCheck,$categories, $categories[$id_category][$key], $key, $has_suite);
		
		return $result;
	}
	public function displayForm()
	{
		global $cookie;
		$categories = Category::getCategories((int)($cookie->id_lang), false);
		$id = (int)Context::getContext()->shop->id;
		$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
		$arrCheck = explode(",",Configuration::get('POPULAR_CAT'));
		$output = '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<div class="margin-form">
					<p class="clear">Mark all checkbox(es) of categories which have products appear in your homepage<sup> *</sup></p>
				</div>
				<div style="overflow: auto; min-height: 300px;" id="categoryList">
					<table cellspacing="0" cellpadding="0" class="table">
						<tr>
							<th>c</th>
							<th>ID</th>
							<th style="width: 600px">Category</th>
						</tr>'
						.$this->getCheckboxCatalog($arrCheck,$categories,$categories[0][1],1).
					'</table>
				</div>
				<br/>
				<center><input type="submit" name="submitcatalogauto" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		
		return $output;
	}
	
	function hookHomeLeft($params)
	{
		global $smarty;
		if (!$this->isCached('cscatalogpopular.tpl', $this->getCacheId('cscatalogpopular')))
		{
			$category_list = array();
			$id_lang = (int)Context::getContext()->language->id;
			if(Configuration::get('POPULAR_CAT') != '')
			{
				$id_cat = explode(",",Configuration::get('POPULAR_CAT'));
				foreach ($id_cat as $id)
				{
					$categories = new Category($id, $id_lang);
					$categories->subs = $categories->getSubCategories($id_lang);
					$category_list[$id]= (Array)$categories;
					$category_list[$id]['subs'] = $categories->subs;
					
					$category_list[$id]['product_latest'] = $categories->getProducts($id_lang,1,1,'id_product','DESC',false,true,true);
				}
				
			}
			$smarty->assign(array(
			'category_list' => $category_list
			));
		}
		return $this->display(__FILE__, 'cscatalogpopular.tpl',$this->getCacheId('cscatalogpopular'));
	}
	
	
	function hookHeader($params)
	{
		global $smarty;
		$smarty->assign(array(
			'HOOK_CS_HOME_LEFT' => Hook::Exec('homeleft')
		));
		
	}
	
	public function hookActionObjectCategoryUpdateAfter($params)
	{
		$this->_clearCache('cscatalogpopular.tpl');
	}
	
	public function hookActionObjectCategoryDeleteAfter($params)
	{
		$this->_clearCache('cscatalogpopular.tpl');
	}


	public function hookActionObjectProductUpdateAfter($params)
	{
		$this->_clearCache('cscatalogpopular.tpl');
	}
	
	public function hookActionObjectProductDeleteAfter($params)
	{
		$this->_clearCache('cscatalogpopular.tpl');
	}
	
	public function hookCategoryUpdate($params)
	{
		$this->_clearCache('cscatalogpopular.tpl');
	}
}