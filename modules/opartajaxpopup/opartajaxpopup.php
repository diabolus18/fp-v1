<?php
// Security
if (!defined('_PS_VERSION_'))
	exit;

// Loading Models
require_once(_PS_MODULE_DIR_ . 'opartajaxpopup/models/Popup.php');

class Opartajaxpopup extends Module
{

	public function __construct()
	{
		$this->name = 'opartajaxpopup';
		$this->tab = 'front_office_features';
		$this->version = '1';
		 
		$this->author = 'Op\'art - Olivier CLEMENCE';
		$this->need_instance = 0;
		//$this->module_key="4ddbc6f52446057f4f6ff71d96990358";
		
		parent::__construct();

		$this->displayName = $this->l('Op\'art ajax popup');
		$this->description = $this->l('Add and display html content inside a lightbox');

		$this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
		 
		if ($this->active && Configuration::get('OPART_AJAXPOPUP_CONF') == '')
			$this->warning = $this->l('You have to configure your module');
	}


	public function install()
	{
		// Install SQL
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
			return false;		

		// Install Tabs
		$parent_tab = new Tab();
		$parent_tab->name = array();
		foreach (Language::getLanguages() as $language)
			$parent_tab->name[$language['id_lang']] = 'Op\'art ajax popup';
		//$parent_tab->name = 'Op\'art ajax popup';
		$parent_tab->class_name = 'AdminMainOpartajaxpopup';
		$parent_tab->id_parent = 0;
		$parent_tab->module = $this->name;
		$parent_tab->add();
		
		
		$tab1 = new Tab();
		$tab1->name = array();
		foreach (Language::getLanguages() as $language)
			$tab1->name[$language['id_lang']] = 'Popup';
		//$tab1->name = 'Popup';
		$tab1->class_name = 'AdminOpartAjaxpopup';
		$tab1->id_parent = $parent_tab->id;
		$tab1->module = $this->name;
		$tab1->add();
		
		//Init
		Configuration::updateValue('OPART_AJAXPOPUP_CONF', 'ok');

		// Install Module
		if (parent::install() == false OR !$this->registerHook('displayFooter'))
			return false;
		return true;			
	}

	public function uninstall()
	{
		// Uninstall SQL
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
			return false;

		Configuration::deleteByName('OPART_AJAXPOPUP_CONF');

		// Uninstall Tabs		
		$tab = new Tab((int)Tab::getIdFromClassName('AdminMainOpartajaxpopup'));
		$tab->delete();
		
		$tab = new Tab((int)Tab::getIdFromClassName('AdminOpartAjaxpopup'));
		$tab->delete();
		
		// Uninstall Module
		if (!parent::uninstall())
			return false;
		return true;
	}

	public function hookDisplayFooter()
	{
		if ($this->context->getMobileDevice() != false)
			return false;

		$this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-1.7.2.min.js');
		$this->context->controller->addJS($this->_path.'js/script.js');
		$this->context->controller->addCSS($this->_path.'css/style.css');
	}
	
	public function getContent()
	{
		$this->_html=$this->display(__FILE__, 'views/templates/admin/configure.tpl');	
		return $this->_html;
	}


}