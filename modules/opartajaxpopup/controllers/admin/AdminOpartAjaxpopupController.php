<?php

class AdminOpartAjaxpopupController extends ModuleAdminController
{
	public function __construct()
	{
		$this->table = 'opartajaxpopup';
		$this->className = 'Popup';
		$this->lang = true;
		$this->deleted = false;
		$this->colorOnBackground = false;
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->context = Context::getContext();
		
		parent::__construct();
	}
	
	private function renderHeader() {
		
	}
	
	/**
	 * Function used to render the list to display for this controller
	 */
	public function renderList()
	{
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		
		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Delete selected items?')
				)
			);
		$this->fields_list = array(
			'id_opartajaxpopup' => array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			),
			'title' => array(
				'title' => $this->l('Title'),
				'width' => 'auto',
			),
			'width' => array(
				'title' => $this->l('Width'),
				'width' => 'auto',
			),
			'height' => array(
				'title' => $this->l('Height'),
				'width' => 'auto',
			)
		);
		
		$lists = parent::renderList();
		
		parent::initToolbar();
		$html="";
		$html.=$this->context->smarty->fetch(parent::getTemplatePath().'header.tpl');		
		$html.=$lists;
		$html.=$this->context->smarty->fetch(parent::getTemplatePath().'help.tpl');
		return $html;
	}
		
	public function renderForm()
	{
		$this->fields_form = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Popup'),
				'image' => '../img/admin/cog.gif',				
			),
			'input' => array(
				array(
					'type' => 'text',
					'lang' => true,
					'label' => $this->l('Title:'),
					'name' => 'title',
					'size' => 100					
				),
				array(
					'type' => 'textarea',
					'lang' => true,
					'autoload_rte' => true,
					'label' => $this->l('Code:'),
					'name' => 'code',					
					'rows' => 10,
					'cols' => 102,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Responsive:'),
					'name' => 'responsive',
					'options' => array(
							'query' => array(
									array('key' => 0, 'name' => $this->l('no')),
									array('key' => 1, 'name' => $this->l('yes')),
							),
							'name' => 'name',
							'id' => 'key'
					),
					'desc' => $this->l('If responsive is set to "yes", height and width will be in percent')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Width:'),
					'name' => 'width',
					'size' => 10,
					'desc' => $this->l('If responsive is set to "yes", this field must be lower or equal to 100')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Height:'),
					'name' => 'height',
					'size' => 10,
					'desc' => $this->l('If responsive is set to "yes", this field must be lower or equal to 100')
				),
				
				array(
					'type' => 'text',
					'label' => $this->l('Link:'),
					'name' => 'link',
					'size' => 150,
					'lang' => true,
					'readonly' => true,
					'desc' => $this->l('When you will save your form, you will see the code in this field.<br />Copy this code and paste it where you need to see your link. For example in a CMS post or product description with the HTML editor.')
				),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);
		
		
		if (!($obj = $this->loadObject(true)))
			return;
		if($obj->id!=null) {
			foreach($this->_languages AS $lang) {
				$this->fields_value['link'][$lang['id_lang']] = '<a href="#" onClick="showOpartAjaxPopup('.$obj->id.','.$obj->width.','.$obj->height.',\'\','.$obj->responsive.'); return false;">'.$obj->title[$lang['id_lang']].'</a>';
			}				
		}
		return parent::renderForm();
	}
	

}