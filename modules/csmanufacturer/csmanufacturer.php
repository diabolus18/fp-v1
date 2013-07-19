<?php
if (!defined('_PS_VERSION_'))
	exit;

class csmanufacturer extends Module
{
	function __construct()
	{
		$this->name = 'csmanufacturer';
		$this->tab = 'My Blocks';
		$this->version = '1.0';
		$this->author = 'Codespot';

		parent::__construct();

		$this->displayName = $this->l('CS Slider of Manufacturer Logo');
		$this->description = $this->l('Adds Slider of Manufacturer Logo.');
	}

	function install()
	{
		if (!parent::install() || !$this->registerHook('home') || !$this->registerHook('header') ||
			!$this->registerHook('actionObjectManufacturerUpdateAfter') ||
			!$this->registerHook('actionObjectManufacturerDeleteAfter'))
			return false;
		return true;
	}
	public function uninstall()
	{
	 	if (parent::uninstall() == false)
	 		return false;
		$this->_clearCache('csmanufacturer.tpl');
	 	return true;
	}
	function hookHome($params)
	{
		global $smarty,$cookie;
		if (!$this->isCached('csmanufacturer.tpl', $this->getCacheId('csmanufacturer')))
		{
			$manufacturers = Manufacturer::getManufacturers(false,0,true);
			$smarty->assign(array(
				'manufacs' => $manufacturers,
				'ps_manu_img_dir' => _PS_MANU_IMG_DIR_
			));
		}
		return $this->display(__FILE__, 'csmanufacturer.tpl',$this->getCacheId('csmanufacturer'));
	}
	
	function hookHeader($params)
	{
		global $smarty;
		if ($smarty->tpl_vars['page_name']->value == 'index')
		{
			$this->context->controller->addCss($this->_path.'css/csmanufacturer.css', 'all');
		}
		/*$this->context->controller->addJs($this->_path.'js/jquery.carouFredSel-6.1.0.js');
		$this->context->controller->addJs($this->_path.'js/helper-plugins/jquery.mousewheel.min.js');
		$this->context->controller->addJs($this->_path.'js/helper-plugins/jquery.touchSwipe.min.js');
		$this->context->controller->addJs($this->_path.'js/helper-plugins/jquery.ba-throttle-debounce.min.js');*/
	}
	public function hookActionObjectManufacturerUpdateAfter($params)
	{
		$this->_clearCache('csmanufacturer.tpl');
	}
	
	public function hookActionObjectManufacturerDeleteAfter($params)
	{
		$this->_clearCache('csmanufacturer.tpl');
	}
}


