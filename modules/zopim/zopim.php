<?php

if (!defined('_PS_VERSION_'))
	exit;

class Zopim extends Module
{
        public function __construct()
	{
		$this->name = 'zopim';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'Prestakit';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Zopim chat');
		$this->description = $this->l('Adds Zopim chat to your shop.');
	}
        
        function install()
        {
                return (parent::install() 
                        && $this->registerHook('header')
                        && Configuration::updateValue('PS_ZOPIM_CODE', ''));
        }
        
        function uninstall() 
        {
                return (parent::install() && Configuration::deleteByName('PS_ZOPIM_CODE'));
        }
                
        public function hookHeader($params)
	{
                $zopimcode = Configuration::get('PS_ZOPIM_CODE');
                
                if ($zopimcode) {
                        $this->smarty->assign(array(
                                'zopimcode' => $zopimcode
                        ));
                        return $this->display(__FILE__, 'zopimcode.tpl');
                }
	}
        
        public function getContent()
        {
                $output = '<h2>'.$this->displayName.'</h2>';
                
		if (Tools::isSubmit('submitZopimCode'))
		{
			$zopimcode = Tools::getValue('zopimcode');
                        
			if (!$zopimcode)
				$errors[] = $this->l('Zopim code field is empty.');
			else
                                Configuration::updateValue('PS_ZOPIM_CODE', $zopimcode);
          
                        
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
                        
		}
                
		return $output.$this->displayForm();                              
        }
        
	public function displayForm()
	{
		$output = '
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<p>'.$this->l('Add Zopim code there. If you don\'t have a code proceed to www.zopim.com, register and copy and paste exact code given you by Zopim to the text area below.').'</p><br />
				<label>'.$this->l('Zopim code').'</label>
				<div class="margin-form">
					<textarea name="zopimcode" rows="7" cols="100">'.Tools::safeOutput(Tools::getValue('zopimcode', Configuration::get('PS_ZOPIM_CODE'))).'</textarea>
					<p class="clear">'.$this->l('Code given you by Zopim').'</p>
                                </div>
				<center><input type="submit" name="submitZopimCode" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}         
}        

?>
