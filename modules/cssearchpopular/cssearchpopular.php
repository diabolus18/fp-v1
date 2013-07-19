<?php
class CsSearchPopular extends Module
{
	private $_html = '';
	private $_postErrors = array();

    function __construct()
    {
        $this->name = 'cssearchpopular';
        $this->tab = 'MyBlock';
        $this->version = 1.0;
		$this->author = 'CodeSpot';

		parent::__construct();

		$this->displayName = $this->l('CS Popular search block');
		$this->description = $this->l('Adds a block popular search.');
	}

	public function install()
	{
		return (parent::install() AND $this->registerHook('displayfooterbottom') AND $this->registerHook('actionSearch'));
	}
	public function uninstall()
	{
	 	if (parent::uninstall() == false)
	 		return false;
		$this->_clearCache('cssearchpopular.tpl');
	 	return true;
	}

	public static function getPopularSearch($id_lang,$id_shop)
	{
		$searchList = Db::getInstance()->executeS('
		SELECT COUNT(sw.`word`) AS total,sw.`word` FROM '._DB_PREFIX_.'search_word sw
		LEFT JOIN '._DB_PREFIX_.'search_index si ON (sw.id_word = si.id_word AND sw.id_lang = '.(int)$id_lang.' AND sw.id_shop = '.$id_shop.') GROUP BY sw.`word` ORDER BY total DESC LIMIT 30 ');
		return $searchList;
	}
	
	public function hookDisplayFooterBottom($params)
	{
		if (Configuration::get('PS_CATALOG_MODE'))
			return ;
		global $smarty;
		if (!$this->isCached('cssearchpopular.tpl', $this->getCacheId('cssearchpopular')))
		{
			$context = Context::GetContext();
			$id_lang = $context->language->id;
			$id_shop = $context->shop->id;
			$searchList = $this->getPopularSearch($id_lang,$id_shop);
			$smarty->assign(array('searchList' => $searchList));
		}
		return $this->display(__FILE__, 'cssearchpopular.tpl',$this->getCacheId('cssearchpopular'));
	}
	public function hookActionSearch($params)
	{
		$this->_clearCache('cssearchpopular.tpl');
	}
}


