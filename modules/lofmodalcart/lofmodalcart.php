<?php
  /*
  **************************************
  **        PrestaShop V1.5.4.1        *
  **            ModalCart              *
  **    http://www.brainos.com         *
  **             V 1.0                 *
  **    Author-team: Land of coder       *
  **************************************
  */

  if(!defined('_PS_VERSION_'))
    exit;
  include_once(_PS_MODULE_DIR_.'lofmodalcart/libs/Params.php');

  class LofModalCart extends Module{

    private $_html = '';
    private $_configs = '';
    protected $params = null;

    public function __construct(){
      $this->name = 'lofmodalcart';
      $this->tab = 'landofcoder';
      $this->version = '1.0';
      $this->author = 'landofcoder';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

      parent::__construct();

      $this->page = basename(__FILE__, '.php');
      $this->displayName = $this->l('Lof Modal Cart');
      $this->description = $this->l('Display a confirmation modal window when add product to cart.');
      $this->confirmUninstall = $this->l('Are you sure to uninstall this module?');
      $this->_prepareForm();
      $this->params =  new LofModalCartParams( $this, $this->name, $this->_configs  );

    }

    public function _prepareForm(){
      $this->_configs = array(
        'width' => 800,
        'overlay_color' => '#43f5ff',
        'overlay_color1' => '#ff47ff',
        'overlay_opacity' => 80,
        'title_color' => '#0041e1',
        'title_size' => 16,
        'border' => 4,
        'border_type' => 'solid',
        'border_color' => '#0041e1',
        'border_radius' => 35,
        'summary_type' => 1,
        'image_size' => 'small_default',
        'show_attribute' => '1',
        'show_button' => 1
      );
    }
    /**
     * @see Module::getParams()
     */
    public function getParams(){
      return $this->params;
    }
    /**
     * @see Module::install()
     */
    public function install(){
      if(!parent::install()||
         !$this->getParams()->batchUpdate( $this->_configs )||
         !$this->registerHook('header'))
        return false;
      if(intval(Configuration::get('PS_BLOCK_CART_AJAX')) == 1) {
        Configuration::updateValue('PS_BLOCK_CART_AJAX', 0);
      }
      $langs = Language::getLanguages(false);
      foreach( $langs  as $lang){
        Configuration::updateValue(strtoupper($this->name.'_display_above_'.$lang['id_lang']), 'BrainOS'  , true);
        Configuration::updateValue(strtoupper($this->name.'_display_bellow_'.$lang['id_lang']), 'Landofcoder'  , true);
      }
      return true;
    }
    /**
     * @see Module::uninstall()
     */
    public function uninstall(){
      if(!parent::uninstall()||
         !$this->getParams()->delete()||
         !$this->unregisterHook('header'))
        return false;
      if(intval(Configuration::get('PS_BLOCK_CART_AJAX')) == 0) {
        Configuration::updateValue('PS_BLOCK_CART_AJAX', 1);
      }
      $langs = Language::getLanguages(false);
      foreach( $langs  as $lang){
        Configuration::deleteByName(strtoupper($this->name.'_display_above_'.$lang['id_lang']));
        Configuration::deleteByName(strtoupper($this->name.'_display_bellow_'.$lang['id_lang']));
      }
      return true;
    }
    /**
     * @see Module::getContent()
     */
    public function getContent(){
      $this->_html .= '<h2>'.$this->displayName.'.</h2>';
      if(Tools::isSubmit('saveModalConfig')){
        if($this->_postValidation())
          $this->_postProcess();
      }
      $this->_displayForm();
      return $this->_html;
    }
    /**
     * @see Module::getContent()
     */
    public function _displayForm(){
      $id_lang = Context::getContext()->language->id;
      Configuration::get( strtoupper($this->name.'_display_above_'.$id_lang) );
      Configuration::get( strtoupper($this->name.'_display_bellow_'.$id_lang) );
      $params = $this->params;
      require_once ( dirname(__FILE__).'/form.php' );
    }
    /**
     * @see Module::_postValidation()
     */
    private function _postValidation(){
      $errors = array();
      if(Tools::isSubmit('saveModalConfig')){

        if(!Tools::getValue(strtoupper($this->name.'_width')))
          $errors[] = $this->l('Invalid modal width.');
        elseif(!Validate::isUnsignedInt(Tools::getValue(strtoupper($this->name.'_width'))))
          $errors[] = $this->l('You need to input an integer.');
        elseif((Tools::getValue(strtoupper($this->name.'_width')) < 500) || (1000 < Tools::getValue(strtoupper($this->name.'_width'))))
          $errors[] = $this->l('500<= ModalCart width <= 1000.');

        if(!Tools::getValue(strtoupper($this->name.'_overlay_color')) && !Tools::getValue(strtoupper($this->name.'_overlay_color1')))
          $errors[] = $this->l('Invalid overlay color');

        if(!Tools::getValue(strtoupper($this->name.'_overlay_opacity')))
          $errors[] = $this->l('Invalid overlay opacity');
        elseif(!Validate::isUnsignedInt(Tools::getValue(strtoupper($this->name.'_overlay_opacity'))))
          $errors[] = $this->l('You need to input an integer.');
        elseif((Tools::getValue(strtoupper($this->name.'_overlay_opacity')) <= 0) || (200 < Tools::getValue(strtoupper($this->name.'_overlay_opacity'))))
          $errors[] = $this->l('0< Overlay Opacity <= 200.');

        if(!Tools::getValue(strtoupper($this->name.'_title_color')))
          $errors[] = $this->l('Invalid Modal title color');

        if(!Tools::getValue(strtoupper($this->name.'_title_size')))
           $errors[] = $this->l('Invalid Modal title size');
        elseif(!Validate::isUnsignedInt(Tools::getValue(strtoupper($this->name.'_title_size'))))
          $errors[] = $this->l('You need to input an integer.');
        elseif((Tools::getValue(strtoupper($this->name.'_title_size')) <= 0) || (25 < Tools::getValue(strtoupper($this->name.'_title_size'))))
          $errors[] = $this->l('0 < ModalCart title size <= 25.');

        if(!Tools::getValue(strtoupper($this->name.'_border')))
           $errors[] = $this->l('Invalid Modal border');
        elseif(!Validate::isUnsignedInt(Tools::getValue(strtoupper($this->name.'_border'))))
          $errors[] = $this->l('You need to input an integer.');
        elseif((Tools::getValue(strtoupper($this->name.'_border')) <= 0) || (6 < Tools::getValue(strtoupper($this->name.'_border'))))
          $errors[] = $this->l('0 < ModalCart border <= 6');

        if(!Tools::getValue(strtoupper($this->name.'_border_radius')))
           $errors[] = $this->l('Invalid Modal border radius');
        elseif(!Validate::isUnsignedInt(Tools::getValue(strtoupper($this->name.'_border_radius'))))
          $errors[] = $this->l('You need to input an integer.');
        elseif((Tools::getValue(strtoupper($this->name.'_border_radius')) < 0) || ( 100 < Tools::getValue(strtoupper($this->name.'_border_radius'))))
          $errors[] = $this->l('0 =< ModalCart border <= 100');

        $languages = Language::getLanguages(false);
        foreach ($languages as $language){
          if(strlen(Tools::getValue('display_above_'.$language['id_lang'])))
            $errors[] = $this->l('You need to enter values for display above');
          elseif(strlen(Tools::getValue('display_bellow_'.$language['id_lang'])))
            $errors[] = $this->l('You need to enter values for display bellow');
        }

        if(count($errors)){
          $this->_html .= $this->displayError(implode('<br />', $errors));
          return false;
        }
      }
      return true;
    }
    /**
     * @see Module::_postProcess()
     */
    private function _postProcess(){
      $errors = array();
      if (Tools::isSubmit('saveModalConfig')){
        $res = $this->getParams()->batchUpdate( $this->_configs );
        $langs = Language::getLanguages(false);
        foreach( $langs  as $lang){
          Configuration::updateValue(strtoupper($this->name.'_display_above_'.$lang['id_lang']), Tools::getValue( strtoupper($this->name.'_display_above_'.$lang['id_lang']) ) , true);
          Configuration::updateValue(strtoupper($this->name.'_display_bellow_'.$lang['id_lang']), Tools::getValue( strtoupper($this->name.'_display_bellow_'.$lang['id_lang']) ) , true);
        }
        $this->getParams()->refreshConfig();
        if (!$res)
          $errors .= $this->displayError($this->l('Configuration could not be updated!'));
        else
        $this->_html .= $this->displayConfirmation($this->l('Configuration updated successfully.'));
      }
      /* Display errors if needed */
      if (count($errors))
        $this->_html .= $this->displayError(implode('<br />', $errors));
    }

    public function hookHeader(){
      $this->context->controller->addJS($this->_path.'assets/js/jquery.nyroModal.custom.min.js');
      $this->context->controller->addJS($this->_path.'assets/js/modal-cart.js');
      $this->context->controller->addCSS($this->_path.'assets/css/nyroModal.css');
      $this->context->controller->addCSS($this->_path.'themes/default/assets/style.css');
      $this->context->smarty->assign(array(
        'modalCartPath'	        => _MODULE_DIR_.$this->name.'/',
        'modalCartWidth'			  => (int)(Configuration::get(strtoupper($this->name.'_width'))),
        'mcOverlayColor_1'      => Configuration::get(strtoupper($this->name.'_overlay_color')),
        'mcOverlayColor_2'      => Configuration::get(strtoupper($this->name.'_overlay_color1')),
        'mcOverlayOpacity'      => (Configuration::get(strtoupper($this->name.'_overlay_opacity')))/100,
        'mcBorder'              => Configuration::get(strtoupper($this->name.'_border')),
        'mcBorderType'          => Configuration::get(strtoupper($this->name.'_border_type')),
        'mcBorderColor'         => Configuration::get(strtoupper($this->name.'_border_color')),
        'mcBorderRadius'         => Configuration::get(strtoupper($this->name.'_border_radius')),
        'CUSTOMIZE_TEXTFIELD'	  => '_CUSTOMIZE_TEXTFIELD_'
      ));
      return $this->display(__FILE__, 'themes/default/header.tpl');
    }

    public function showAllProductCart(){
      global $link;

      $params = $this->params;
      $configs = array();
      foreach($this->_configs as $config => $value){
        $configs[$config] = $params->get($config);
      }

      $cart = $this->context->cart;
      $allProduct = $cart->getProducts();
      if($allProduct){
        foreach ($allProduct as &$product) {
          $product["link"] = $link->getProductLink($product["id_product"],$product["link_rewrite"]);
          $product["price"] = Tools::displayPrice($product["price"]);
          $product["total"] = Tools::displayPrice($product["total"]);
        }
      }

      $currency = $this->context->currency;
      $taxCalculationMethod = Group::getPriceDisplayMethod((int)Group::getCurrent()->id);
      $useTax = !($taxCalculationMethod == PS_TAX_EXC);
      $totalToPay = $cart->getOrderTotal($useTax);

      $shipping_cost = Tools::displayPrice($cart->getOrderTotal($useTax, Cart::ONLY_SHIPPING), $currency);

      $id_lang = Context::getContext()->language->id;
      $display_above = Configuration::get( strtoupper($this->name.'_display_above_'.$id_lang) );
      $display_bellow = Configuration::get( strtoupper($this->name.'_display_bellow_'.$id_lang) );

      $this->context->smarty->assign(array(
        'productModal'  => $allProduct,
        'order_process' => Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order',
        'totalToPay'    => Tools::displayPrice($totalToPay, $currency),
        'shippingCost'  => $shipping_cost,
        'displayAbove'  => $display_above,
        'displayBellow' => $display_bellow,
        'modalConfigs'  => $configs
      ));
      return $this->display(__FILE__, 'themes/default/display_product.tpl');
    }

    public function showLastProductOnCart(){
      global $link;

      $params = $this->params;
      $configs = array();
      foreach($this->_configs as $config => $value){
        $configs[$config] = $params->get($config);
      }

      $cart = $this->context->cart;
      $lastProduct = $cart->getLastProduct();

      if($lastProduct){
        $lastProduct["link"] = $link->getProductLink($lastProduct["id_product"], $lastProduct["link_rewrite"]);
        $lastProduct["price"] = Tools::displayPrice($lastProduct["price"]);
        $lastProduct["total"] = Tools::displayPrice($lastProduct["total"]);
      }
      $id_lang = Context::getContext()->language->id;
      $display_above = Configuration::get( strtoupper($this->name.'_display_above_'.$id_lang) );
      $display_bellow = Configuration::get( strtoupper($this->name.'_display_bellow_'.$id_lang) );

      $this->context->smarty->assign(array(
        'lastProductModal' => $lastProduct,
        'order_process'    => Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order',
        'displayAbove'     => $display_above,
        'displayBellow'    => $display_bellow,
        'modalConfigs'  => $configs
      ));
      return $this->display(__FILE__, 'themes/default/display_product.tpl');
    }
  }
?>
