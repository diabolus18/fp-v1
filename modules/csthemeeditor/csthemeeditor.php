<?php
if (!defined('_PS_VERSION_'))
	exit;
class CsThemeEditor extends Module
{
	private $_html;
	private $columns = array('1_column'=>'1 column','2_column_left'=>'2 column left','2_column_right'=>'2 column right','3_column'=>'3 column');
	private $array_color;
	private $column_lists = array(
							'1_column'=> array('grid_24(3)','grid_24(4)','grid_24(6)','grid_24(8)'),
							'2_column_left'=> array('grid_8,grid_16(2)','grid_6,grid_18(3)','grid_4,grid_20(4)','grid_4,grid_20(5)','grid_6,grid_18(6)'),
							'2_column_right'=> array('grid_16(2),grid_8','grid_18(3),grid_6','grid_20(4),grid_4','grid_20(5),grid_4','grid_18(6),grid_6'),
							'3_column'=> array('grid_8,grid_8(1),grid_8','grid_6,grid_12(2),grid_6','grid_4,grid_15(3),grid_5','grid_4,grid_16(4),grid_4','grid_6,grid_12(4),grid_6')
							);
	function __construct()
	{
		$this->name = 'csthemeeditor';
		$this->tab = 'My Blocks';
		$this->version = 1.0;
		$this->author = 'Codespot';

		parent::__construct();
		$this->displayName = $this->l('Cs Theme Editor');
		$this->description = $this->l('Add block theme editor.');
		/*load color default*/
		if (DIRECTORY_SEPARATOR == '/')
			$directory_color = _PS_ROOT_DIR_.'/modules/csthemeeditor/settings/default/';
		else
			$directory_color = _PS_ROOT_DIR_.'\modules\csthemeeditor\settings\default\\';
		$color_templates = glob($directory_color."*.xml");
		foreach($color_templates as $k=>$template)
		{
			if(substr(basename($template),8,-4) != "custom")
				$this->array_color[$k]=substr(basename($template),8,-4);
		}
		/*load color default*/
	}

	function install()
	{
		return (parent::install() AND $this->registerHook('top') AND $this->registerHook('header') AND Configuration::updateValue('CS_COLOR_TEMPLATE_'.Configuration::get('PS_SHOP_DEFAULT'),'custom_shop1'));
	}
	
	public function uninstall()
	{
		
		foreach (Shop::getContextListShopID() as $id_shop)
		{
			Configuration::deleteByName('CS_COLOR_TEMPLATE_'.$id_shop);
		}
		return parent::uninstall();
	}
	
	public function showColor($text, $style,$id)
	{
		$this->_html .= '<p>
			<label>'.$this->l(''.$text.':').'</label>
				<input style="background: '.($style ?  $style : '#FFF').'" id="result_'.$id.'" name="'.$id.'" type="text" value="'.($style ? $style : '').'" /> 
				<span id="'.$id.'" style="cursor:pointer">
				<img src="'._PS_ADMIN_IMG_.'color.png"/>
				</span>
			</p>';
	}
	public function showFontSize($name, $choosed)
	{
		$this->_html .= '
		<select name="'.$name.'" onchange="changeColorTemplate();">
		<option value="">'.$this->l('No Choose').'</option>
		';
		for($i=12;$i<=80;$i++)
		{
			$this->_html .= '<option value="'.$i.'" '.($choosed==$i ? "selected" : "").' >'.$i.'px</option>';
		}
		$this->_html .= '</select>
		';
	}
	
	public function showFontWeight($name, $choosed)
	{
		$font_weights = array("normal","inherit","italic");
		$this->_html .= '
		<select name="'.$name.'" onchange="changeColorTemplate();">
		<option value="">'.$this->l('No Choose').'</option>
		';
		foreach($font_weights as $font_weight)
		{
			$this->_html .= '<option value="'.$font_weight.'" '.($choosed==$font_weight ? "selected" : "").' >'.$font_weight.'</option>';
		}
		$this->_html .= '</select>
		';
	}
	
	public function createFormColorText($number_color,$settings,$prefix_text)
	{
		for($i=1;$i<=$number_color;$i++)
		{
			$text_name = $prefix_text.'_color_'.$i;
			$this->showColor('Color '.$i,$settings->$text_name,$text_name);
		}
		
	}
	public function showConfigFontText($number_font,$settings,$prefix_text)
	{
		$font_list = file_get_contents(dirname(__FILE__).'/fonts/'.'googlefont.html');
		for($i=1;$i<=$number_font;$i++)
		{
			$font_style = $prefix_text.'_fstyle_'.$i;
			$font_size = $prefix_text.'_fsize_'.$i;
			$font_weight = $prefix_text.'_fweight_'.$i;
			$this->_html .= '<p><label>'.$this->l('Font style '.$i.':').'</label>
				<select name="'.$font_style.'" id="'.$font_style.'" onchange="showResultChooseFont(\''.$font_style.'\',\'result_'.$font_style.'\')"> '.$font_list.' </select>
				<span id="result_'.$font_style.'" style="font-family:'.($settings->$font_style ? $settings->$font_style : 'arial').'">'.($settings->$font_style ? $settings->$font_style : '').'</span>
				</p><p><label>'.$this->l('Font size '.$i.':').'</label>';
			$this->showFontSize(''.$font_size.'',($settings->$font_size ? $settings->$font_size : ''));
			$this->_html .= '</p><p><label>'.$this->l('Font weight '.$i.':').'</label>';
			$this->showFontWeight(''.$font_weight.'',($settings->$font_weight ? $settings->$font_weight : ''));
		}
	}
	
	
	public function showConfigFontTextCustom($number_font,$settings,$prefix_text,$name_list)
	{
		$font_list = file_get_contents(dirname(__FILE__).'/fonts/'.'googlefont.html');
		for($i=0;$i<$number_font;$i++)
		{
			$font_style = $prefix_text.'_fstyle_'.$name_list[$i];
			$font_size = $prefix_text.'_fsize_'.$name_list[$i];
			$font_weight = $prefix_text.'_fweight_'.$name_list[$i];
			$this->_html .= '<p><label>'.$this->l('Font style '.$name_list[$i].':').'</label>
				<select name="'.$font_style.'" id="'.$font_style.'" onchange="showResultChooseFont(\''.$font_style.'\',\'result_'.$font_style.'\')"> '.$font_list.' </select>
				<span id="result_'.$font_style.'" style="font-family:'.($settings->$font_style ? $settings->$font_style : 'arial').'">'.($settings->$font_style ? $settings->$font_style : '').'</span>
				</p><p><label>'.$this->l('Font size '.$name_list[$i].':').'</label>';
			$this->showFontSize(''.$font_size.'',($settings->$font_size ? $settings->$font_size : ''));
			$this->_html .= '</p><p><label>'.$this->l('Font weight '.$name_list[$i].':').'</label>';
			$this->showFontWeight(''.$font_weight.'',($settings->$font_weight ? $settings->$font_weight : ''));
		}
	}
	
	
	
	public function showConfigBackground($folder,$prefix_text,$settings,$color_template)
	{
			global $currentIndex;
			$stringConfirm='onclick="if (!confirm(\'Are you sure that you want to delete background image ?\')) return false "';
			if (DIRECTORY_SEPARATOR == '/')
				$directory_pattern = _PS_MODULE_DIR_.'csthemeeditor/images/general/patterns/';
			else
				$directory_pattern = _PS_MODULE_DIR_.'csthemeeditor\images\general\patterns\\';
			$array_patterns = array_merge(glob($directory_pattern."*.jpg"), glob($directory_pattern."*.png"),glob($directory_pattern."*.gif"));
			$name_pattern = $prefix_text.'_b_pattern';
			$name_image = $prefix_text.'_b_img';
			$name_repeat = $prefix_text.'_b_repeat';
			$this->_html .= '<div style="clear:both;">
				<label>'.$this->l('Background image:').'</label><p style="overflow:hidden">';
			foreach($array_patterns as $pattern)
			{
				
				$relative_path = _MODULE_DIR_.$this->name.'/images/general/patterns/'.basename($pattern);
				$this->_html .= '<span class="bkg_pattern" style="background:url('.$relative_path.') repeat;float:left;margin:0 10px 10px 0">
				<input type="radio" name="'.$name_pattern.'" value="'.basename($pattern).'" '.($settings->$name_pattern && $settings->$name_pattern == basename($pattern) ? 'checked=checked' : '').' /></span>';
			}
			$this->_html .= '</p><div style="clear:both;overflow:hidden;"><label class="image_upload"><input type="radio" name="'.$name_pattern.'" value="up_load_image_'.$folder.'" '.($settings->$name_pattern && $settings->$name_pattern == 'up_load_image_'.$folder.'' ? 'checked=checked' : '' ).' id="up_load_image_'.$folder.'" />'.$this->l('Image upload').'</label>
			<div id="show_up_load_image_'.$folder.'" style="display:none">
			<input type="hidden" name="hid_'.$name_image.'" value="'.($settings->$name_image ? $settings->$name_image : '').'"/>
			<input style="float:left" type="file" name="'.$name_image.'" value="'.($settings->$name_image ? $settings->$name_image : '').'"/>';
				if (DIRECTORY_SEPARATOR == '/')
				$directory = _PS_MODULE_DIR_.'csthemeeditor/images/'.$folder.'/background/';
			else
				$directory = _PS_MODULE_DIR_.'csthemeeditor\images\\'.$folder.'\background\\';
				$backgrounds_old = array_merge(glob($directory."*.jpg"), glob($directory."*.png"),glob($directory."*.gif"));
				if(isset($backgrounds_old[0]) && isset($settings->$name_image))
				{
					$path_bg = _MODULE_DIR_.$this->name.'/images/'.$folder.'/background/'.$settings->$name_image;
					$this->_html .= '<div class="thumb_bg" style="background:url('.$path_bg.');">result</div>
					<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&delete_'.$name_image.'&color_template_change='.$color_template.'" '.$stringConfirm.'><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="'.$this->l('Delete image').'" title="'.$this->l('Delete').'" /></a>
					';
				}
			$this->_html .= '</div></div>
			<div class="clear:both;overflow:hidden;"><label>'.$this->l('Repeat image:').'</label>
			<div class="repeat_image">
			 <span><input type="radio" name="'.$name_repeat.'" value="no-repeat" '.($settings->$name_repeat && $settings->$name_repeat == 'no-repeat' ? 'checked=checked' : '' ).' />'.$this->l('No repeat').'</span>
			 <span><input type="radio" name="'.$name_repeat.'" value="repeat-x" '.($settings->$name_repeat && $settings->$name_repeat == 'repeat-x' ? 'checked=checked' : '' ).' />'.$this->l('Repeat x').'</span>
			 <span><input type="radio" name="'.$name_repeat.'" value="repeat-y" '.($settings->$name_repeat && $settings->$name_repeat == 'repeat-y' ? 'checked=checked' : '' ).' />'.$this->l('Repeat y').'</span>
			 <span><input type="radio" name="'.$name_repeat.'" value="repeat" '.($settings->$name_repeat && $settings->$name_repeat == 'repeat' ? 'checked=checked' : '' ).' />'.$this->l('Repeat x y').'</span>
			</div></div>';
	}
	
	public function _configForm ()
	{
		global $currentIndex;
		$this->context->controller->addCss($this->_path.'css/colorpicker.css', 'all');
		$this->context->controller->addCss($this->_path.'css/admin/style.css', 'all');
		$this->context->controller->addJs($this->_path.'js/colorpicker.js');
		$this->context->controller->addJs($this->_path.'js/eye.js');
		$this->context->controller->addJs($this->_path.'js/utils.js');
		$this->context->controller->addJs($this->_path.'js/admin/layoutcolor.js');
		$this->context->controller->addJs($this->_path.'js/admin/csthemeeditor.js');
		$id = (int)Context::getContext()->shop->id;
		$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
		$color_template = (Tools::getValue('color_template_change') ? Tools::getValue('color_template_change') : Configuration::get('CS_COLOR_TEMPLATE_'.$id_shop,false,Shop::getGroupFromShop($id_shop),$id_shop));
		$path = dirname(__FILE__).'/settings/';
		foreach($this->array_color as $cdf)
		{
			if($color_template == $cdf)
				$path = dirname(__FILE__).'/settings/default/';
		}
		if (!file_exists($path.'setting_'.$color_template.'.xml'))
			$color_template = Configuration::get('CS_COLOR_TEMPLATE_'.Configuration::get('PS_SHOP_DEFAULT'));
		$settings = simplexml_load_file($path.'setting_'.$color_template.'.xml');
		$class_column_home = explode(",",$settings->home_class);
		$this->_html .= '
		<link href="'.__PS_BASE_URI__.'modules/csthemeeditor/css/admin/tab.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" src="'.__PS_BASE_URI__.'modules/csthemeeditor/js/admin/tab.js"></script>
		<div class="productTabs" style="margin-right: -1px;width: 170px;">
				<ul class="tab">
						<li class="tab-row">
						<a class="nav-manager selected" id="manager-1" href="javascript:void(0);">'.$this->l('Setting Column').'</a></li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-2" href="javascript:void(0);">'.$this->l('Setting General').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-3" href="javascript:void(0);">'.$this->l('Setting Header').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-4" href="javascript:void(0);">'.$this->l('Setting Footer').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-5" href="javascript:void(0);">'.$this->l('Setting Menu').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-6" href="javascript:void(0);">'.$this->l('Setting Slideshow').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-7" href="javascript:void(0);">'.$this->l('Setting Product').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-8" href="javascript:void(0);">'.$this->l('Setting Button').'</a>
						</li>
						<li class="tab-row">
						<a class="nav-manager " id="manager-9" href="javascript:void(0);">'.$this->l('Setting Title').'</a>
						</li>
				</ul>
			</div>
		
		<form class="csthemeeditor" method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<fieldset class="manager-1 tab-manager plblogtabs">';
				//column setting
					$this->_html .= '<div class="setting_column">
						<h4>'.$this->l('Sub page (no home)').'</h4>
						
						<p><label>'.$this->l('Column:').'</label>
						</p>
						<div class="show_class_no_home">
						<select name="column" onchange="changeOptionColumn($(this).val())">';
						foreach($this->column_lists as $name_column=>$value_column)
						{
							$this->_html .= '<option value="'.$name_column.'" '.($settings->column && $settings->column == $name_column ? 'selected' : '').'>'.$name_column.'</option>';
						}
						
					$this->_html .= '</select>
					<div class="option_columns margin-form">';
					foreach($this->column_lists as $name_column=>$value_column)
					{
						$this->_html .= '<div class="'.$name_column.'" style="'.($settings->column && $settings->column == $name_column ? 'display:block' : 'display:none').'">';
						foreach ($value_column as $class_column)
						{
							
							$temp_class = explode("(",$class_column);
							$number_product = substr($temp_class[1], 0, strpos($temp_class[1], ')'));
							$this->_html .= '<p><input type="radio" '.($settings->column_class && $settings->column_class == $class_column ? 'checked="checked"' : '').' name="column_class" value="'.$class_column.'"/> '.$class_column.'</p><p style="margin-left:15px"> '.$number_product.$this->l(' products in a row.').'</p>';
						}
						$this->_html .= '</div>';
					}
						$this->_html .= '</div></div>
						<p class="preference_description clear">'.$this->l('Select number column and classes of column for sub page (no home).').'</p>
					</div>
				</fieldset>';
				
				//color general
				$this->_html .= '<fieldset class="manager-2 tab-manager plblogtabs" style="display:none;">
				<h4>'.$this->l('Settings front-end').'</h4>
				<p>
					<label>'.$this->l('Show panel front-end:').'</label> 
					<input type="radio" name="show_panel_front_end" value="1"'.(Configuration::get('SHOW_PANEL_FRONT_END') == 1 ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
					<input type="radio" name="show_panel_front_end" value="0"'.(Configuration::get('SHOW_PANEL_FRONT_END') == 0 ? 'checked="checked"' : '').' />
					<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label></p>
				<div class="separation"></div>
				<h4>'.$this->l('Color Tempate').'</h4>
				<p>
				<label>'.$this->l('Template:').'</label>
				<select name="color_template" id="color_template" onchange="submit()">';
				foreach($this->array_color as $template)
				{
					$this->_html .= '<option '.($template == $color_template ? "selected" : "").'  value='.$template.'>'.$template.'</option>';
				}
				$this->_html .= '
				<option value="custom" ';
				if(!Tools::getValue('color_template_change'))
				{
					if (!in_array($color_template, $this->array_color)) {
						$this->_html .= 'selected = "selected"';
					}
					
				}
				$this->_html .= '>'.$this->l('custom').'</option>
				</select></p><p>
				<label>'.$this->l('Background mode:').'</label>
				<input type="radio" name="bg_mode" value="box_mode" '.($settings->bg_mode && $settings->bg_mode == 'box_mode' ? 'checked=checked' : '').' />'.$this->l('Box mode:').'
				<input type="radio" name="bg_mode" value="wide_mode" '.($settings->bg_mode && $settings->bg_mode == 'wide_mode' ? 'checked=checked' : '').' />'.$this->l('Wide mode:').'</p>
				<div class="separation"></div>
				<h4>'.$this->l('Background Content').'</h4>
				<div class="background_setting">';
				
				$this->showColor('Background Color',$settings->g_b_color,'g_b_color');
				$this->showConfigBackground('general','g',$settings,$color_template);
				
				$this->_html .='<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for id=page element (background-color, backgroud-image).').'</p>
				</div>';
				
				$this->_html .='<div class="separation"></div>
				<h4>'.$this->l('Background Body').'</h4>
				<div class="background_setting">';
				$this->showColor('Background Color',$settings->gb_b_color,'gb_b_color');
				$this->showConfigBackground('general_body','gb',$settings,$color_template);
				
				$this->_html .='<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for body element (background-color, backgroud-image).').'</p>
				</div>
				
				<div class="separation"></div>
				<h4>'.$this->l('Text color').'</h4>';
				$this->showColor('Color link normal',$settings->g_link_color_normal,'g_link_color_normal');
				$this->showColor('Color link hover',$settings->g_link_color_hover,'g_link_color_hover');
				$this->showColor('Color text',$settings->g_text_color,'g_text_color');
				$this->createFormColorText(3,$settings,'g');
				$this->showColor('Background color custom',$settings->g_b_color_custom,'g_b_color_custom');
				$this->_html .= '
				<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for body element (color and font for text and link).').'</p><div class="separation"></div>
				<h4>'.$this->l('Text Font').'</h4>';
				$this->showConfigFontText(1,$settings,'g');
				$this->_html .= '</fieldset>';
				
				//Header
				$this->_html .= '
				<fieldset class="manager-3 tab-manager plblogtabs" style="display:none;">
				<h4>'.$this->l('Background').'</h4>';
				$this->showColor('Background Color',$settings->h_b_color,'h_b_color');
				$this->showConfigBackground('header','h',$settings,$color_template);
				$this->_html .='<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for #header element (background-color, backgroud-image).').'</p>
				</div><div class="separation"></div>';
				$this->_html .= '<h4>'.$this->l('Text').'</h4><div class="header_color">';
				$this->createFormColorText(3,$settings,'h');
				$this->_html .= '</div>
				<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply color and font for #header element (color and font for text and link).').'</p>
				<div class="separation"></div>
				<h4>'.$this->l('Text Font').'</h4>';
				$this->showConfigFontText(2,$settings,'h');
				$this->_html .= '</fieldset>';
				
				//color footer
				$this->_html .= '
				<fieldset class="manager-4 tab-manager plblogtabs" style="display:none;">
				<h4>'.$this->l('Background').'</h4>';
				$this->showColor('Color',$settings->f_b_color,'f_b_color');
				$this->showConfigBackground('footer','f',$settings,$color_template);
				$this->_html .= '<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for #footer element (background-color, backgroud-image).').'</p>
				</div><div class="separation"></div>';
				$this->_html .= '<h4>'.$this->l('Text').'</h4><div class="footer_color">';
				$this->createFormColorText(3,$settings,'f');
				$this->_html .= '</div>
				<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for #footer element (color and font for text and link). <strong>Color headding</strong> is applied for #footer h2,#footer h3,#footer h4.title_block,#footer h4,#footer h5 ').'</p>
				<div class="separation"></div>
				<h4>'.$this->l('Text Font').'</h4>';
				$this->showConfigFontText(2,$settings,'f');
				$this->_html .= '</fieldset>';
				
				//color menu
				$this->_html .= '
				<fieldset class="manager-5 tab-manager plblogtabs" style="display:none;">
					<h4>'.$this->l('Parent menu').'</h4><div class="col">';
					$this->showColor('Background color normal',$settings->mp_b_color_normal,'mp_b_color_normal');
					$this->showColor('Background color hover',$settings->mp_b_color_hover,'mp_b_color_hover');
					$this->showConfigBackground('menuparent','mp',$settings,$color_template);
					$this->showColor('Text color normal',$settings->mp_text_color_normal,'mp_text_color_normal');
					$this->showColor('Text color hover',$settings->mp_text_color_hover,'mp_text_color_hover');
					$this->_html .= '</div>
					<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for menu parent (text color, font style,font size,font weight,background color).').'</p>
					<div class="separation"></div>
					<h4>'.$this->l('Sub menu').'</h4><div class="col">';
					$this->showColor('Background color normal',$settings->ms_b_color_normal,'ms_b_color_normal');
					$this->showColor('Background color hover',$settings->ms_b_color_hover,'ms_b_color_hover');
					$this->showConfigBackground('menusub','ms',$settings,$color_template);
					$this->showColor('Text 1 color  normal',$settings->ms_text1_color_normal,'ms_text1_color_normal');
					$this->showColor('Text 1 color hover',$settings->ms_text1_color_hover,'ms_text1_color_hover');
					$this->showColor('Text 2 color  normal',$settings->ms_text2_color_normal,'ms_text2_color_normal');
					$this->showColor('Text 2 color hover',$settings->ms_text2_color_hover,'ms_text2_color_hover');
					$this->_html .= '</div>
					<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for sub menu (text color, font style,font size,font weight,background color).').'</p>
					<div class="separation"></div>
					<h4>'.$this->l('Text Font').'</h4>';
					$this->showConfigFontText(2,$settings,'m');
				$this->_html .= '</fieldset>';
				
				//slideshow
				$this->_html .= '
				<fieldset class="manager-6 tab-manager plblogtabs" style="display:none;">
					<h4>'.$this->l('Background').'</h4>
					<div class="background_setting">';
					$this->showColor('Background Color',$settings->s_b_color,'s_b_color');
					$this->showConfigBackground('slideshow','s',$settings,$color_template);
					$this->_html .='<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for main slideshow (background-color, backgroud-image).').'</p>
					</div>
					<div class="separation"></div>
					<h4>'.$this->l('Text').'</h4>';
					$this->showColor('Button background Color',$settings->s_bt_b_color,'s_bt_b_color');
					$this->createFormColorText(3,$settings,'s');
					$this->_html .= '
					<p class="preference_description clear">'.$this->l('This config <strong>is used</strong> to apply for body element (color and font for text and link).').'</p>
					<div class="separation"></div>
					<h4>'.$this->l('Text Font').'</h4>';
					$this->showConfigFontText(2,$settings,'s');
				$this->_html .= '</fieldset>';
				
				//Color Product
				$this->_html .= '
				<fieldset class="manager-7 tab-manager plblogtabs" style="display:none;">
				<h4>'.$this->l('Color').'</h4>';
					$this->showColor('Name',$settings->p_name_color,'p_name_color');
					$this->showColor('Description',$settings->p_des_color,'p_des_color');
					$this->showColor('Price',$settings->p_price_color,'p_price_color');
					$this->showColor('Price special',$settings->p_spec_price_color,'p_spec_price_color');
					$this->createFormColorText(3,$settings,'p');
				$this->_html .= '<div class="separation"></div><h4>'.$this->l('Font').'</h4>';
				$this->showConfigFontTextCustom(3,$settings,'p',array('name','description','price'));
				$this->_html .= '</fieldset>';
				
				//Color Button
				$this->_html .= '<fieldset class="manager-8 tab-manager plblogtabs" style="display:none;">';
				$this->_html .= '<h4>'.$this->l('Font').'</h4>';	
				$this->showConfigFontTextCustom(1,$settings,'bt',array('text'));
				$this->_html .= '<div class="separation"></div>';
				$this->_html .= '<h4>'.$this->l('Button 1').'</h4>';
					$this->showColor('Background color normal',$settings->bt_b_color_normal,'bt_b_color_normal');
					$this->showColor('Background color hover',$settings->bt_b_color_hover,'bt_b_color_hover');
					$this->showConfigBackground('button','bt',$settings,$color_template);
					$this->showColor('Text normal color',$settings->bt_text_color_normal,'bt_text_color_normal');
				
				$this->_html .= '<div class="separation"></div>';
				$this->_html .= '<h4>'.$this->l('Button 2').'</h4>';
					$this->showColor('Background color normal',$settings->bt2_b_color_normal,'bt2_b_color_normal');
					$this->showColor('Background color hover',$settings->bt2_b_color_hover,'bt2_b_color_hover');
					$this->showConfigBackground('button2','bt2',$settings,$color_template);
					
				$this->_html .= '</fieldset>';
				
				//Color Title
				$this->_html .= '
				<fieldset class="manager-9 tab-manager plblogtabs" style="display:none;">
				<h4>'.$this->l('Color').'</h4>
				';
					$this->showColor('Page title',$settings->t_p_color,'t_p_color');
					$this->_html .= '<div class="separation"></div>';
					$this->_html .= '<h4>'.$this->l('Block module').'</h4>';
					$this->showColor('Title color',$settings->t_t_color,'t_t_color');
					$this->showColor('Title background color',$settings->t_b_color,'t_b_color');
					$this->showConfigBackground('blocktitle','t',$settings,$color_template);
					$this->_html .= '<div class="separation"></div>';
					$this->_html .= '<h4>'.$this->l('Breadcrumb').'</h4>';
					$this->showColor('First Breadcrumb',$settings->t_f_bre_color,'t_f_bre_color');
					$this->showColor('Second Breadcrumb',$settings->t_s_bre_color,'t_s_bre_color');
					$this->_html .= '<div class="separation"></div><h4>'.$this->l('Font').'</h4>';
					$this->showConfigFontTextCustom(3,$settings,'t',array('page','block','breadcrumb'));
				$this->_html .= '</fieldset><br/>';
				
				$this->_html .= '<center>
				<input type="submit" class="button pointer" name="saveMainSetting" value="'.$this->l('Save').'" id="saveMainSetting" />
			<input type="submit" class="button pointer" name="resetSetting" value="'.$this->l('Reset Setting').'" id="resetSetting" />
			</center>
			</form>
		';
	}
	
	public function getClass($class_name, $home=false)
	{
		$output = '';
		switch ($class_name)
		{
		case '1_column':
		  $output .= ($home ? Tools::getValue('class_'.$class_name.'_home') : Tools::getValue('class_'.$class_name.''));
		  break;
		case '2_column_left':
		  $output .= 
		  ($home ? Tools::getValue('class_'.$class_name.'_1_home') : Tools::getValue('class_'.$class_name.'_1')).','.($home ? Tools::getValue('class_'.$class_name.'_2_home') : Tools::getValue('class_'.$class_name.'_2'));
		  break;
		case '2_column_right':
		  $output .= 
		  ($home ? Tools::getValue('class_'.$class_name.'_1_home') : Tools::getValue('class_'.$class_name.'_1')).','.($home ? Tools::getValue('class_'.$class_name.'_2_home') : Tools::getValue('class_'.$class_name.'_2'));
		  break;
		case '3_column':
		 $output .= 
		   ($home ? Tools::getValue('class_'.$class_name.'_1_home') : Tools::getValue('class_'.$class_name.'_1')).','.($home ? Tools::getValue('class_'.$class_name.'_2_home') : Tools::getValue('class_'.$class_name.'_2')).','.($home ? Tools::getValue('class_'.$class_name.'_3_home') : Tools::getValue('class_'.$class_name.'_3'));
		  break;
		default:
		 $output .= 
		   ($home ? Tools::getValue('class_'.$class_name.'_1_home') : Tools::getValue('class_'.$class_name.'_1')).','.($home ? Tools::getValue('class_'.$class_name.'_2_home') : Tools::getValue('class_'.$class_name.'_2')).','.($home ? Tools::getValue('class_'.$class_name.'_3_home') : Tools::getValue('class_'.$class_name.'_3'));
		}
		return $output;
	}
	
	public function UploadBackground($field_name,$folder)
	{
		if (isset($_FILES[$field_name]['tmp_name']) && $_FILES[$field_name]['tmp_name'])
		{
			if (ImageManager::validateUpload($_FILES[$field_name], 900000))
			{
				$er = ImageManager::validateUpload($_FILES[$field_name], 900000);
				return $er;
			}
			$tmp_name = _PS_MODULE_DIR_.'csthemeeditor/images/'.$folder.'/background/'.time().$_FILES[$field_name]['name'];
			if (DIRECTORY_SEPARATOR == '/')
				$directory = _PS_ROOT_DIR_.'/modules/csthemeeditor/images//'.$folder.'/background//';
			else
				$directory = _PS_ROOT_DIR_.'\modules\csthemeeditor\images\\'.$folder.'\background\\';
			if (!move_uploaded_file($_FILES[$field_name]['tmp_name'],$tmp_name))
			{
				return $this->displayError('Error upload image');
			}
			return true;
		}
		return false;
		
	}
	public function saveXmlBackground()
	{
		
	}
	private function saveXmlSetting($reset = false)
	{
		$newXml = '<?xml version=\'1.0\' encoding=\'utf-8\' ?>'."\n".'<setting>'."\n";
		if($reset == true)
		{
			$array_settings_reset= array(
				'column'=>'2_column_left',
				'column_class'=>'grid_6,grid_18(3)',
				'bg_mode'=>'wide_mode'
				);
			foreach ($array_settings_reset as $key=>$value_defautl)
			{
				$newXml .= '<'.$key.'>';
				$newXml .= $value_defautl;
				$newXml .= '</'.$key.'>'."\n";
			}
		}
		else
		{
				$error = false;
				$array_background = array(
							'g_b_img' => 'general',
							'gb_b_img' => 'general_body',
							'h_b_img'=>'header',
							'f_b_img'=>'footer',
							'mp_b_img'=>'menuparent',
							'ms_b_img'=>'menusub',
							's_b_img'=>'slideshow',
							'bt_b_img'=>'button',
							'bt2_b_img'=>'button2',
							't_b_img'=>'blocktitle',
							);
				foreach ($array_background as $name=>$folder)
				{
					if($_POST['hid_'.$name.''] != '' && $_FILES[''.$name.'']['name'] == "")
					{
						$newXml .= '<'.$name.'>';
						$newXml .= $_POST['hid_'.$name.''];
						$newXml .= '</'.$name.'>'."\n";
					}
					else if($_FILES[''.$name.'']['name'] != "")
					{
						$er = $this->UploadBackground($name,$folder);
						$newXml .= '<'.$name.'>';
						$newXml .= time().$_FILES[''.$name.'']['name'];
						$newXml .= '</'.$name.'>'."\n";
					}
					if($er != null)
					$error = $this->displayError($this->l($er));
				}
				$array_settings = 
					array(
							'bg_mode' => 'wide',
							'column'=>'3_column',
							'column_class'=>'grid_5,grid_14,grid_5',
							'g_b_color'=>'#FFF',/*general*/
							'g_b_pattern'=>'no_pattern.jpg',
							'g_b_repeat' => 'repeat',
							'gb_b_color'=>'#FFF',
							'gb_b_pattern'=>'no_pattern.jpg',
							'gb_b_repeat' => 'repeat',
							'g_link_color_normal' => '#FFF',
							'g_link_color_hover' => '#FFF',
							'g_text_color' => '#FFF',
							'g_color_1' => 'FFF',
							'g_color_2' => 'FFF',
							'g_color_3' => 'FFF',
							'g_b_color_custom' => 'FFF',
							'g_fstyle_1' => 'Arial',
							'g_fsize_1' => '12',
							'g_fweight_1' => 'normal',
							'h_b_color' => '#FFF',/*header*/
							'h_b_pattern'=>'no_pattern.jpg',
							'h_b_repeat' => 'repeat',
							'h_color_1' => 'FFF',
							'h_color_2' => 'FFF',
							'h_color_3' => 'FFF',
							'h_fstyle_1' => 'Arial',
							'h_fsize_1' => '12',
							'h_fweight_1' => 'normal',
							'h_fstyle_2' => 'Arial',
							'h_fsize_2' => '12',
							'h_fweight_2' => 'normal',
							'f_b_color' => '#FFF',/*footer*/
							'f_b_pattern' => 'no_img.jpg',
							'f_b_repeat' => 'repeat',
							'f_color_1'=>'#FFF',
							'f_color_2'=>'#FFF',
							'f_color_3'=>'#FFF',
							'f_fstyle_1' => 'Arial',
							'f_fsize_1' => '12',
							'f_fweight_1' => 'normal',
							'f_fstyle_2' => 'Arial',
							'f_fsize_2' => '12',
							'f_fweight_2' => 'normal',
							'mp_b_color_normal'=>'#FFF',/*menu*/
							'mp_b_color_hover'=>'#000',
							'mp_b_pattern' => 'no_img.jpg',
							'mp_b_repeat' => 'repeat',
							'mp_text_color_normal' => '#FFF',
							'mp_text_color_hover'=>'#000',
							'ms_b_color_normal'=>'#FFF',
							'ms_b_color_hover'=>'#000',
							'ms_b_pattern'=>'no_img.jpg',
							'ms_b_repeat' => 'repeat',
							'ms_text1_color_normal' => '#FFF',
							'ms_text1_color_hover' => '#000',
							'ms_text2_color_normal' => '#FFF',
							'ms_text2_color_hover' => '#000',
							'm_fstyle_1'=>'Arial',
							'm_fsize_1'=>'12',
							'm_fweight_1'=>'normal',
							'm_fstyle_2'=>'Arial',
							'm_fsize_2'=>'12',
							'm_fweight_2'=>'normal',
							's_b_color' => '#FFF',//slideshow
							's_b_pattern' => 'no_img.jpg',
							's_b_repeat' => 'repeat',
							's_bt_b_color' => '#FFF',
							's_color_1' => '#FFF',
							's_color_2' => '#FFF',
							's_color_3' => '#FFF',
							's_fstyle_1' => 'Arial',
							's_fsize_1' => '12',
							's_fweight_1' => 'normal',
							's_fstyle_2' => 'Arial',
							's_fsize_2' => '12',
							's_fweight_2' => 'normal',
							'p_name_color' => '#FFF', //product
							'p_des_color' => '#FFF',
							'p_price_color' => '#FFF',
							'p_spec_price_color' => '#FFF',
							'p_color_1' => '#FFF',
							'p_color_2' => '#FFF',
							'p_color_3' => '#FFF',
							'p_fstyle_name' => 'Arial',
							'p_fsize_name' => '12',
							'p_fweight_name' => 'normal',
							'p_fstyle_description' => 'Arial',
							'p_fsize_description' => '12',
							'p_fweight_description' => 'normal',
							'p_fstyle_price' => 'Arial',
							'p_fsize_price' => '12',
							'p_fweight_price' => 'normal',
							'bt_b_color_normal'=>'#FFF',//button
							'bt_b_color_hover'=>'#000',
							'bt_b_pattern' => 'no_img.jpg',
							'bt_b_repeat' => 'repeat',
							'bt_text_color_normal' => '#FFF',
							'bt2_b_color_normal'=>'#FFF',//button 2
							'bt2_b_color_hover'=>'#000',
							'bt2_b_pattern' => 'no_img.jpg',
							'bt2_b_repeat' => 'repeat',
							'bt_fstyle_text' => 'Arial',// button font
							'bt_fsize_text' => '12',
							'bt_fweight_text' => 'normal',
							't_p_color' => '#FFF',/*title*/
							't_t_color' => '#FFF',
							't_b_color' => '#FFF',
							't_b_pattern' => 'no_img.jpg',
							't_b_repeat' => 'repeat',
							't_f_bre_color' => '#FFF',
							't_s_bre_color' => '#FFF',
							't_fstyle_page' => 'Arial',
							't_fsize_page' => '12',
							't_fweight_page' => 'normal',
							't_fstyle_block' => 'Arial',
							't_fsize_block' => '12',
							't_fweight_block' => 'normal',
							't_fstyle_breadcrumb' => 'Arial',
							't_fsize_breadcrumb' => '12',
							't_fweight_breadcrumb' => 'normal',
						);
				foreach ($array_settings as $key=>$value_defautl)
				{
					if (Tools::getValue(''.$key.'') != '')
					{
						$newXml .= '<'.$key.'>';
						$newXml .= Tools::getValue(''.$key.'');
						$newXml .= '</'.$key.'>'."\n";
					}
				}
		
		}
		$newXml .= '</setting>'."\n";
		if (Shop::getContext() != Shop::CONTEXT_SHOP)
		{
			foreach (Shop::getContextListShopID() as $id_shop)
			{
				if ($fd = @fopen(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', 'w'))
				{
					
					if (!@fwrite($fd, $newXml))
						$error = $this->displayError($this->l('Unable to write to the editor file.'));
					if (!@fclose($fd))
						$error = $this->displayError($this->l('Can\'t close the editor file.'));
				}
				else
					$error = $this->displayError($this->l('Unable to update the editor file. Please check the editor file\'s writing permissions.'));
			}
		}
		else
		{
			$id_shop = (int)Context::getContext()->shop->id;
			if ($fd = @fopen(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', 'w'))//
			{
				if (!@fwrite($fd, $newXml))
					$error = $this->displayError($this->l('Unable to write to the editor file.'));
				if (!@fclose($fd))
					$error = $this->displayError($this->l('Can\'t close the editor file.'));
			}
			else
				$error = $this->displayError($this->l('Unable to update the editor file. Please check the editor file\'s writing permissions.'));
		}
		return $error;
	}
	
	
	private function _postProcess()
	{
		global $currentIndex;
		$errors = array();
		$id = (int)Context::getContext()->shop->id;
		$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
		$color_tp = Configuration::get('CS_COLOR_TEMPLATE_'.$id_shop);
		if(Tools::getValue('color_template'))
			$color = Tools::getValue('color_template');
		else if(Tools::getValue('color_template_change'))
			$color = Tools::getValue('color_template_change');
		else
			$color = Configuration::get('CS_COLOR_TEMPLATE_'.$id_shop);
		if (Tools::isSubmit('saveMainSetting'))
		{
			if ($color == "custom")
			{
				if ($error = $this->saveXmlSetting())
					$this->_html .= $error;
			}
			if (Shop::getContext() != Shop::CONTEXT_SHOP)
			{
				foreach (Shop::getContextListShopID() as $id_shop)
				{
					if ($color == "custom")
					{
						$temp = $color.'_shop'.$id_shop;
						Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,$temp,false,Shop::getGroupFromShop($id_shop),$id_shop);
					}
					else
					{
						Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,$color,false,Shop::getGroupFromShop($id_shop),$id_shop);
					}
					Configuration::updateValue('SHOW_PANEL_FRONT_END',Tools::getValue('show_panel_front_end'),false,Shop::getGroupFromShop($id_shop),$id_shop);
				}
			}
			else
			{
				if ($color == "custom")
					$color .='_shop'.$id_shop;
				Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,$color);
				Configuration::updateValue('SHOW_PANEL_FRONT_END',Tools::getValue('show_panel_front_end'));
			}
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveMainSettingConfirmation');
		}
		else if (Tools::isSubmit('delete_g_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->g_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_gb_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->gb_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_h_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->h_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_f_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->f_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_mp_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->mp_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_ms_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->ms_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_s_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->s_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_bt_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->bt_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('delete_bt2_b_img'))
		{
			if (in_array($color,$this->array_color))
			{
				copy(dirname(__FILE__).'/settings/default/'.'setting_'.$color.'.xml',dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			}
			$data = simplexml_load_file(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml');
			unset($data->bt2_b_img);
			Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,'custom_shop'.$id_shop);
			file_put_contents(dirname(__FILE__).'/settings/'.'setting_custom_shop'.$id_shop.'.xml', $data->saveXML());
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if (Tools::isSubmit('resetSetting'))
		{
			if (Shop::getContext() != Shop::CONTEXT_SHOP)
			{
				foreach (Shop::getContextListShopID() as $id_shop)
				{
					Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,"custom_shop".$id_shop,false,Shop::getGroupFromShop($id_shop),$id_shop);
				}
			}
			else
			{
				Configuration::updateValue('CS_COLOR_TEMPLATE_'.$id_shop,"custom_shop".$id_shop);
			}
			if ($error = $this->saveXmlSetting(true))
				$this->_html .= $error;
			else
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveMainSettingConfirmation');
		}else if (Tools::isSubmit('color_template'))
		{
			$color = Tools::getValue('color_template');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&color_template_change='.$color.'#tab=manager-2');
		}
		elseif (Tools::isSubmit('saveMainSettingConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Save main setting successfully'));
	}
	
	
	public function getContent()
   	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		$this->_postProcess();
		$this->_configForm();
		return $this->_html;
	}
	
	
	
	function hookTop($params)
	{
		if(Configuration::get('SHOW_PANEL_FRONT_END') == 0)
			return;
		global $smarty;
		if (DIRECTORY_SEPARATOR == '/')
			$directory = _PS_ROOT_DIR_.'/modules/csthemeeditor/images/general/patterns//';
		else
			$directory = _PS_ROOT_DIR_.'\modules\csthemeeditor\images\general\patterns\\';
		
		$patterns_temp = array_merge(glob($directory."*.jpg"), glob($directory."*.png"),glob($directory."*.gif"));
		$patterns = array();
		foreach ($patterns_temp as $key=>$pattern_temp)
		{
			if(basename($pattern_temp) != "no_img.jpg")
				$patterns[$key] = basename($pattern_temp);
		}
		$colors = array(
			'bg_color' => array ('Background color','Apply for body element (only works if you do not choose pattern or choosed pattern transparent).'),
			'bg_menu_parent' => array ('Background menu parent','Apply background color for menu parent'),
			'bg_menu_sub' => array('Background menu sub','Apply background color for menu sub'),
			'bg_footer' => array('Background footer','Apply background color for $footer element'),
			'bg_button' => array('Background button','Apply background color for button'),
			'text_body_color' => array('Text body color','Apply text color for text all site'),
			'title_page' => array('Title page','Apply text color for title page'),
			'title_block' => array('Title block','Apply text color for title block'),
			'text_name_product' => array('Name product','Apply text color for name product'),
			'text_menu_parent' => array('Text menu parent color','Apply text color for text menu parent'),
			'text_menu_sub' =>  array('Text menu sub color','Apply text color for text menu subb')
		);
		$fonts = array (
			'text_body_font' => array('Text body','Apply font style for text all site'),
			'title_page_font' => array('Title page','Apply font style for title page'),
			'title_block_font' => array('Title block','Apply font style for title block'),
			'name_product_font' => array('Name product','Apply font style for name product'),
			'menu_parent_font' =>  array('Menu parent','Apply font style for text menu parent'),
			'menu_sub_font' => array('Menu sub','Apply font style for text menu sub')
		);
		$font_list = file_get_contents(dirname(__FILE__).'/fonts/'.'googlefont.html');
		$smarty->assign(array(
			'patterns' => $patterns,
			'colors' => $colors,
			'fonts' => $fonts,
			'font_list' => $font_list,
			'column_lists' => $this->column_lists,
			'path' => _MODULE_DIR_.$this->name,
			'path_admin' =>_PS_ADMIN_IMG_,
			'color_templates' =>$this->array_color
		));
		return $this->display(__FILE__, 'csthemeeditor.tpl');
	}
	
	function hookHeader($params)
	{
		global $smarty;
		$id_shop = (int)Context::getContext()->shop->id;
		$color_tp = Configuration::get('CS_COLOR_TEMPLATE_'.$id_shop);
		$this->context->controller->addCSS($this->_path.'config.php', 'screen');
		if(Configuration::get('SHOW_PANEL_FRONT_END') == 1)
			$this->context->controller->addJS($this->_path.'liveconfig.php');
		$this->context->controller->addJS($this->_path.'js/frontend/jquery.nicescroll.min.js'); //frontend
		$this->context->controller->addJS($this->_path.'js/frontend/jquery.cookie.js');
		$this->context->controller->addCss($this->_path.'css/colorpicker.css', 'all');
		$this->context->controller->addJs($this->_path.'js/colorpicker.js');
		$this->context->controller->addJs($this->_path.'js/eye.min.js');
		$this->context->controller->addJs($this->_path.'js/utils.js');
		$this->context->controller->addJs($this->_path.'js/frontend/setconfig.js');
		$path = dirname(__FILE__).'/settings/';
		foreach($this->array_color as $cdf)
		{
			if($color_tp == $cdf)
				$path = dirname(__FILE__).'/settings/default/';
		}
		if (!file_exists($path.'setting_'.$color_tp.'.xml'))
			$color_tp = Configuration::get('CS_COLOR_TEMPLATE_'.Configuration::get('PS_SHOP_DEFAULT'));
		$settings = simplexml_load_file($path.'setting_'.$color_tp.'.xml');	
		if(isset($_COOKIE['setting_column_'.$id_shop.'']) && $_COOKIE['setting_column_'.$id_shop.'']!=null) 
		{
			$cookie_column = explode("&",$_COOKIE['setting_column_'.$id_shop.'']);
			$settings->column = $cookie_column[0];
			$settings->column_class = $cookie_column[1];
		}
		$class_list = explode(",",$settings->column_class);
		$grid_product = 'grid_';
		$number_p = 1;
		switch ($settings->column)
		{
		case '1_column':
			$settings->left_class = ' ';
			$settings->center_class = '';
			$settings->right_class = ' ';
			$grid_column = 'one_column';
			$temp = substr($class_list[0],strpos($class_list[0], '(') + 1);
			$number_p = substr($temp,0,strpos($temp, ')'));
			$grid_product .= (int)substr($class_list[0],5)/(int)$number_p;
		  break;
		case '2_column_left':
			$grid_column = 'two_column';
			$settings->left_class =$class_list[0];
			$settings->center_class =substr($class_list[1],0,strpos($class_list[1], '(')) ;
			$settings->right_class = '';
			$temp = substr($class_list[1],strpos($class_list[1], '(') + 1);
			$number_p = substr($temp,0,strpos($temp, ')'));
			$grid_product .= (int)substr($settings->center_class,5)/(int)$number_p;
			$this->_html .= '
			<script type="text/javascript">
			$(window).ready(function(){
			if ($("body").attr("id") != "index")
			{
				$("#center_column").addClass("omega");
			}});</script> ';
			break;
		case '2_column_right':
			$grid_column = 'two_column';
			$settings->left_class = '';
			$settings->center_class = substr($class_list[0],0,strpos($class_list[0], '('));
			$settings->right_class = $class_list[1];
			$temp = substr($class_list[0],strpos($class_list[0], '(') + 1);
			$number_p = substr($temp,0,strpos($temp, ')'));
			$grid_product .= (int)substr($settings->center_class,5)/(int)$number_p;
			$this->_html .= '
			<script type="text/javascript">
			$(window).ready(function(){
			if ($("body").attr("id") != "index")
			{
				$("#center_column").addClass("alpha");
			}
			}); </script> ';
			break;
		case '3_column':
			$grid_column = 'three_column';
			$settings->left_class = $class_list[0];
			$settings->center_class =substr($class_list[1],0,strpos($class_list[1], '(')) ;
			$settings->right_class = $class_list[2];
			$temp = substr($class_list[1],strpos($class_list[1], '(') + 1);
			$number_p = substr($temp,0,strpos($temp, ')'));
			$grid_product .= (int)substr($settings->center_class,5)/(int)$number_p;
			$this->_html .= '
			<script type="text/javascript">
			$(window).ready(function(){
			if ($("body").attr("id") != "index")
				{
					$("#center_column").removeClass("alpha");
					$("#center_column").removeClass("omega");
			}});</script>'; 
			break;
		default:
			$settings->left_class = 'grid_6';
			$settings->center_class = 'grid_18';
			$settings->right_class = '';
			$grid_product = 'grid_6';
		}
		$this->_html .= '
		<script type="text/javascript">
		$.cookie("grid_product", "'.$grid_product.'"); 
		</script>';
		$smarty->assign(array(
			'settings' => $settings,
			'grid_product' =>$grid_product,
			'grid_column' => $grid_column
		));
		return $this->_html;
	}
}


