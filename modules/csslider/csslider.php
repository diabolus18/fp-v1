<?php
include_once(dirname(__FILE__).'/SliderClass.php');

class CsSlider extends Module
{
	private $_html;
	
	public function __construct()
	{
	 	$this->name = 'csslider';
	 	$this->tab = 'MyBlocks';
	 	$this->version = '1.0';
		$this->author = 'CodeSpot';

	 	parent::__construct();

		$this->displayName = $this->l('CS Slider');
		$this->description = $this->l('Add a JQuery Camera Slider on the homepage');
		$this->confirmUninstall = $this->l('Are you sure that you want to delete your CSSlider?');

	}
	public function init_data()
	{
		$id_en = Language::getIdByIso('en');
		$id_fr = Language::getIdByIso('fr');
		$id_shop = Configuration::get('PS_SHOP_DEFAULT');
		$caption = "<div class=\'content_slider\'> <div class=\'block_content\'> 	<h5 class=\'s_color_1\'>assassins creed iii</h5> 	<p>Lorem ipsum dolor sit amet  consectetur adipiscing elit. Phasellus ultrices condimentum  Phasellus porttitor posuere sapien non dictum nisi convallis... </p> </div> <p class=\'price\'><span>$259.00</span></p> </div>";
		
		if(!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider` (`id_slider`, `url`, `position`, `display`) VALUES ( "1", "#","1", "1")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider` (`id_slider`, `url`, `position`, `display`) VALUES ( "2", "#","2", "1")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider` (`id_slider`, `url`, `position`, `display`) VALUES ( "3", "#","3", "1")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_shop` (`id_slider`, `id_shop`, `url`, `position`, `display`) VALUES ("1", \''.$id_shop.'\', "#", "1", "1") ') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_shop` (`id_slider`, `id_shop`, `url`, `position`, `display`) VALUES ("2", \''.$id_shop.'\', "#", "2", 1) ') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_shop` (`id_slider`, `id_shop`, `url`, `position`, `display`) VALUES ("3", \''.$id_shop.'\', "#", "3", 1) ') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "1", \''.$id_en.'\',\''.$id_shop.'\', "1_1.jpg", \''.$caption.'\',"1", "")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "1", \''.$id_fr.'\',\''.$id_shop.'\', "1_5.jpg", \''.$caption.'\',"1", "")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "2", \''.$id_en.'\',\''.$id_shop.'\', "2_1.jpg", \''.$caption.'\',"1", "")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "2", \''.$id_fr.'\',\''.$id_shop.'\', "2_5.jpg", \''.$caption.'\',"1", "")') OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "3", \''.$id_en.'\',\''.$id_shop.'\', "3_1.jpg", \''.$caption.'\',"1", "")')OR
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'csslider_lang` (`id_slider`, `id_lang`, `id_shop`, `image`, `caption`, `video_type`, `video_id`)  VALUES ( "3", \''.$id_fr.'\',\''.$id_shop.'\', "3_5.jpg", \''.$caption.'\',"1", "")') 
		)
			return false;
		return true;
	}
	
	
	public function install()
	{
	 	if (parent::install() == false OR !$this->registerHook('header') OR !$this->registerHook('csslideshow'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csslider (`id_slider` int(10) unsigned NOT NULL AUTO_INCREMENT, `url` varchar(255), `position` int(10) unsigned DEFAULT \'0\', `display` tinyint(1) NOT NULL DEFAULT \'1\', PRIMARY KEY (`id_slider`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csslider_shop (`id_slider` int(10) unsigned NOT NULL ,`id_shop` int(10) unsigned NOT NULL, `url` varchar(255), `position` int(10) unsigned DEFAULT \'0\', `display` tinyint(1) NOT NULL DEFAULT \'1\', PRIMARY KEY (`id_slider`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'csslider_lang (`id_slider` int(10) unsigned NOT NULL, `id_lang` int(10) unsigned NOT NULL,`id_shop` int(10) unsigned NOT NULL, `image` varchar(255) NOT NULL DEFAULT \'\', `caption` mediumtext, `video_type` tinyint(6) NOT NULL DEFAULT \'1\', `video_id` varchar(255) NOT NULL, PRIMARY KEY (`id_slider`,`id_lang`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		$this->init_data();
	 	return true;
	}
	
	public function uninstall()
	{
	 	if (parent::uninstall() == false OR !$this->unregisterHook('csslideshow'))
	 		return false;
		if (!Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csslider') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csslider_shop') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'csslider_lang'))
	 		return false;
	 	return true;
	}
	
	private function _displayHelp()
	{
		$this->_html .= '
		<br/>
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Camera Slider Helper').'</legend>
			<a href="http://www.pixedelic.com/plugins/camera/" alt="Camera Slider" title="Camera Slider">http://www.pixedelic.com/plugins/camera/</a>
		</fieldset>';
	}
	
	private function _displayOptions()
	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		if (!file_exists(dirname(__FILE__).'/'.'option_'.$id_shop.'.xml'))
		{
			copy(dirname(__FILE__).'/'.'option_'.Configuration::get('PS_SHOP_DEFAULT').'.xml',dirname(__FILE__).'/'.'option_'.$id_shop.'.xml');
		}
		$option = simplexml_load_file(dirname(__FILE__).'/'.'option_'.$id_shop.'.xml');
		
		$effects = explode(",", $option->effect);
		$this->_html .= '
		<br/>
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Slider Options').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
			
			<label>'.$this->l('Alignment:').'</label>
			<div class="margin-form">
				<input type="text" name="alignment" value="'.($option->alignment ? $option->alignment : 'center').'"/>
				<p class="clear">'.$this->l('topLeft, topCenter, topRight, centerLeft, center, centerRight, bottomLeft, bottomCenter, bottomRight').'</p>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('AutoAdvance:').'</label>
			<div class="margin-form">
				<input type="radio" name="autoadvance" value="true" '.($option->autoadvance != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="autoadvance" value="false" '.($option->autoadvance == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>	
				<p class="clear">'.$this->l('autoAdvance').'</p>
				
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Mobile AutoAdvance:').'</label>
			<div class="margin-form">
				<input type="radio" name="mobileautoadvance" value="true" '.($option->mobileautoadvance != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="mobileautoadvance" value="false" '.($option->mobileautoadvance == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>	
				<p class="clear">'.$this->l('Mobile AutoAdvance').'</p>
				
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Easing:').'</label>
			<div class="margin-form">
				<input type="text" name="easing" value="'.($option->easing ? $option->easing : 'easeInOutExpo').'"/>
				<p class="clear">'.$this->l('Easing:  for the complete list http://jqueryui.com/demos/effect/easing.html').'</p>
				
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Effect:').'</label>
			<div class="margin-form">
				<table cellpadding="0" cellspacing="0" class="table">
				<tbody>
					<tr>
						<td><input type="checkbox" name="effect[]" value="random" '.(in_array("random",$effects) ? 'checked="checked"' : '').'/><label class="t"> random</label></td>
						<td><input type="checkbox" name="effect[]" value="simpleFade" '.(in_array("simpleFade",$effects) ? 'checked="checked"' : '').'/><label class="t"> simpleFade</label></td>
						<td><input type="checkbox" name="effect[]" value="curtainTopLeft" '.(in_array("curtainTopLeft",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainTopLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="curtainTopRight" '.(in_array("curtainTopRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainTopRight</label></td>
					</tr>
					<tr class="alt_row">
						<td><input type="checkbox" name="effect[]" value="curtainBottomLeft" '.(in_array("curtainBottomLeft",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainBottomLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="curtainBottomRight" '.(in_array("curtainBottomRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainBottomRight</label></td>
						<td><input type="checkbox" name="effect[]" value="curtainSliceLeft" '.(in_array("curtainSliceLeft",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainSliceLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="curtainSliceRight" '.(in_array("curtainSliceRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> curtainSliceRight</label></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="effect[]" value="blindCurtainTopLeft" '.(in_array("blindCurtainTopLeft",$effects) ? 'checked="checked"' : '').' /><label class="t"> blindCurtainTopLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="blindCurtainTopRight" '.(in_array("blindCurtainTopRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> blindCurtainTopRight</label></td>
						<td><input type="checkbox" name="effect[]" value="blindCurtainBottomLeft" '.(in_array("blindCurtainBottomLeft",$effects) ? 'checked="checked"' : '').'/><label class="t"> blindCurtainBottomLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="blindCurtainBottomRight" '.(in_array("blindCurtainBottomRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> blindCurtainBottomRight</label></td>
					</tr>					
					<tr class="alt_row">
						<td><input type="checkbox" name="effect[]" value="blindCurtainSliceBottom" '.(in_array("blindCurtainSliceBottom",$effects) ? 'checked="checked"' : '').'/><label class="t"> blindCurtainSliceBottom</label></td>
						<td><input type="checkbox" name="effect[]" value="blindCurtainSliceTop" '.(in_array("blindCurtainSliceTop",$effects) ? 'checked="checked"' : '').'/><label class="t"> blindCurtainSliceTop</label></td>
						<td><input type="checkbox" name="effect[]" value="stampede" '.(in_array("stampede",$effects) ? 'checked="checked"' : '').'/><label class="t"> stampede</label></td>
						<td><input type="checkbox" name="effect[]" value="mosaic" '.(in_array("mosaic",$effects) ? 'checked="checked"' : '').'/><label class="t"> mosaic</label></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="effect[]" value="mosaicReverse" '.(in_array("mosaicReverse",$effects) ? 'checked="checked"' : '').'/><label class="t"> mosaicReverse</label></td>
						<td><input type="checkbox" name="effect[]" value="mosaicRandom" '.(in_array("mosaicRandom",$effects) ? 'checked="checked"' : '').'/><label class="t"> mosaicRandom</label></td>
						<td><input type="checkbox" name="effect[]" value="mosaicSpiral" '.(in_array("mosaicSpiral",$effects) ? 'checked="checked"' : '').'/><label class="t"> mosaicSpiral</label></td>
						<td><input type="checkbox" name="effect[]" value="mosaicSpiralReverse" '.(in_array("mosaicSpiralReverse",$effects) ? 'checked="checked"' : '').'/><label class="t"> mosaicSpiralReverse</label></td>
					</tr>
					<tr class="alt_row">
						<td><input type="checkbox" name="effect[]" value="topLeftBottomRight" '.(in_array("topLeftBottomRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> topLeftBottomRight</label></td>
						<td><input type="checkbox" name="effect[]" value="bottomRightTopLeft" '.(in_array("bottomRightTopLeft",$effects) ? 'checked="checked"' : '').'/><label class="t"> bottomRightTopLeft</label></td>
						<td><input type="checkbox" name="effect[]" value="bottomLeftTopRight" '.(in_array("bottomLeftTopRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> bottomLeftTopRight</label></td>
						<td><input type="checkbox" name="effect[]" value="bottomLeftTopRight" '.(in_array("bottomLeftTopRight",$effects) ? 'checked="checked"' : '').'/><label class="t"> bottomLeftTopRight</label></td>
					</tr>
				</tbody>
				</table>
				<p class="clear">'.$this->l('Specify sets like: random,fade,sliceDown').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Full Srceen:').'</label>
			<div class="margin-form">
				<input type="radio" name="full_screen" value="true" '.($option->full_screen != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="full_screen" value="false" '.($option->full_screen == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>	
				<p class="clear">'.$this->l('Slide Full Srceen').'</p>
				
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Height:').'</label>
			<div class="margin-form">
				<input type="text" name="height" value="'.($option->height ? $option->height : '40%').'" />
				<p class="clear">'.$this->l('here you can type pixels (for instance "400px"), a percentage (relative to the width of the slideshow, for instance "40%") or "auto"').'</p>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Slide Speed:').'</label>
			<div class="margin-form">
				<input type="text" name="animSpeed" value="'.($option->animSpeed ? $option->animSpeed : 500).'" />
				<p class="clear">'.$this->l('Slide transition speed').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Pause Time:').'</label>
			<div class="margin-form">
				<input type="text" name="transPeriod" value="'.($option->transPeriod ? $option->transPeriod : 3000).'" />
				<p class="clear">'.$this->l('How long each slide will show').'</p>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Hover:').'</label>
			<div class="margin-form">
				<input type="radio" name="hover" value="true" '.($option->hover != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="hover" value="false" '.($option->hover == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>	
				<p class="clear">'.$this->l('true, false. Puase on state hover. Not available for mobile devices').'</p>
				
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Direction Navigation:').'</label>
			<div class="margin-form">
				<input type="radio" name="navigation" value="true" '.($option->navigation != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="navigation" value="false" '.($option->navigation == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
				<p class="clear">'.$this->l('Next & Prev navigation').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Navigation Hover:').'</label>
			<div class="margin-form">
				<input type="radio" name="navigationHover" value="true" '.($option->navigationHover != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="navigationHover" value="false" '.($option->navigationHover == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
				<p class="clear">'.$this->l('Only show on hover').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Control Pagination:').'</label>
			<div class="margin-form">
				<input type="radio" name="pagination" value="true" '.($option->pagination != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="pagination" value="false" '.($option->pagination == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
				<p class="clear">'.$this->l('1,2,3... navigation').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Control Navigation Thumbnails:').'</label>
			<div class="margin-form">
				<input type="radio" name="thumbnails" value="true" '.($option->thumbnails != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="thumbnails" value="false" '.($option->thumbnails == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
				<p class="clear">'.$this->l('Use thumbnails for Control Navigation').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Display icon pause:').'</label>
			<div class="margin-form">
				<input type="radio" name="playPause" value="true" '.($option->playPause != "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
				<input type="radio" name="playPause" value="false" '.($option->playPause == "false" ? 'checked="checked"' : '').' />
				<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
				<p class="clear">'.$this->l('Display or hide icon pause').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Type icon loader:').'</label>
			<div class="margin-form">
				<input type="radio" name="loader" value="bar" '.($option->loader == "bar" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('Bar').'</label>
				<input type="radio" name="loader" value="pie" '.($option->loader == "pie" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('Pie').'</label>
				<input type="radio" name="loader" value="none" '.($option->loader == "none" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('None').'</label>
				<p class="clear">'.$this->l('Display type or hide bar loader').'</p>
				<div class="clear"></div>
			</div>	
			<label>'.$this->l('Loader Color:').'</label>
			<div class="margin-form">
				<input type="text" name="loaderColor" value="'.($option->loaderColor ? $option->loaderColor : '#eeeeee').'"/>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Loader BgColor:').'</label>
			<div class="margin-form">
				<input type="text" name="loaderBgColor" value="'.($option->loaderBgColor ? $option->loaderBgColor : '#222222').'"/>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Loader Opacity:').'</label>
			<div class="margin-form">
				<input type="text" name="loaderOpacity" value="'.($option->loaderOpacity ? $option->loaderOpacity : .8).'"/>
				<p class="clear">'.$this->l('0, .1, .2, .3, .4, .5, .6, .7, .8, .9, 1').'</p>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Loader Padding:').'</label>
			<div class="margin-form">
				<input type="text" name="loaderPadding" value="'.($option->loaderPadding ? $option->loaderPadding : 2).'"/>
				<p class="clear">'.$this->l('how many empty pixels you want to display between the loader and its background').'</p>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('Loader Stroke:').'</label>
			<div class="margin-form">
				<input type="text" name="loaderStroke" value="'.($option->loaderStroke ? $option->loaderStroke : 7).'"/>
				<p class="clear">'.$this->l('the thickness both of the pie loader and of the bar loader. Remember: for the pie, the loader thickness must be less than a half of the pie diameter').'</p>
				<div class="clear"></div>
			</div>
		
			<label>'.$this->l('Bar direction:').'</label>
			<div class="margin-form">
				<input type="radio" name="barDirection" value="leftToRight" '.($option->barDirection == "leftToRight" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('leftToRight').'</label>
				<input type="radio" name="barDirection" value="rightToLeft" '.($option->barDirection == "rightToLeft" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('rightToLeft').'</label>
				<input type="radio" name="barDirection" value="topToBottom" '.($option->barDirection == "topToBottom" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('topToBottom').'</label>
				<input type="radio" name="barDirection" value="bottomToTop" '.($option->barDirection == "bottomToTop" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('bottomToTop').'</label>
				<p class="clear">'.$this->l('Direction of bar loader').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Bar position:').'</label>
			<div class="margin-form">
				<input type="radio" name="barPosition" value="bottom" '.($option->barPosition == "bottom" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('bottom').'</label>
				<input type="radio" name="barPosition" value="left" '.($option->barPosition == "left" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('left').'</label>
				<input type="radio" name="barPosition" value="top" '.($option->barPosition == "top" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('top').'</label>
				<input type="radio" name="barPosition" value="right" '.($option->barPosition == "right" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('right').'</label>
				<p class="clear">'.$this->l('Position of bar loader. Only apply for type loader is bar.').'</p>
				<div class="clear"></div>
			</div>
			<label>'.$this->l('Pie position:').'</label>
			<div class="margin-form">
				<input type="radio" name="piePosition" value="rightTop" '.($option->piePosition == "rightTop" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('rightTop').'</label>
				<input type="radio" name="piePosition" value="leftTop" '.($option->piePosition == "leftTop" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('leftTop').'</label>
				<input type="radio" name="piePosition" value="leftBottom" '.($option->piePosition == "leftBottom" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('leftBottom').'</label>
				<input type="radio" name="piePosition" value="rightBottom" '.($option->piePosition == "rightBottom" ? 'checked="checked"' : '').' />
				<label class="t">'.$this->l('rightBottom').'</label>
				<p class="clear">'.$this->l('Position of pie loader. Only apply for type loader is pie.').'</p>
				<div class="clear"></div>
			</div> 
			
			<label>'.$this->l('Cols:').'</label>
			<div class="margin-form">
				<input type="text" name="cols" value="'.($option->cols ? $option->cols : 6).'"/>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('rows:').'</label>
			<div class="margin-form">
				<input type="text" name="rows" value="'.($option->rows ? $option->rows : 4).'"/>
				<div class="clear"></div>
			</div>
			
			<label>'.$this->l('slideOn:').'</label>
			<div class="margin-form">
				<input type="text" name="slideOn" value="'.($option->slideOn ? $option->slideOn : 'random').'"/>
				<p class="clear">'.$this->l('next, prev, random: decide if the transition effect will be applied to the current (prev) or the next slide.').'</p>	
				<div class="clear"></div>
			</div>
			
			<div class="margin-form">';
				$this->_html .= '
				<input type="submit" class="button" name="applyOptions" value="'.$this->l('Apply').'" id="applyOptions" />
				<input type="submit" class="button" name="resetOptions" value="'.$this->l('Reset').'" id="applyOptions" />';
				$this->_html .= '					
			</div>';
		$this->_html .= '
			</form>
		</fieldset>';
	}
	
	public function getContent()
   	{
		global $currentIndex;
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		
		$this->_postProcess();
		
		if (Tools::isSubmit('addSlider'))
			$this->_displayAddForm();
		elseif (Tools::isSubmit('editSlider'))
			$this->_displayUpdateForm();
		else
		{
			$this->_displayForm();
			$this->_displayOptions();
		}
		
		$this->_displayHelp();
		
		return $this->_html;
	}
	
	private function saveXmlOption($reset = false)
	{
		$error = false;
		
		$newXml = '<?xml version=\'1.0\' encoding=\'utf-8\' ?>'."\n".'<options>'."\n";
		
		$newXml .= '<alignment>';
		$newXml .= ($reset ? 'center' : Tools::getValue('alignment'));
		$newXml .= '</alignment>'."\n";
		
		$newXml .= '<autoadvance>';
		$newXml .= ($reset ? 'true' : Tools::getValue('autoadvance'));
		$newXml .= '</autoadvance>'."\n";
		
		$newXml .= '<mobileautoadvance>';
		$newXml .= ($reset ? 'false' : Tools::getValue('mobileautoadvance'));
		$newXml .= '</mobileautoadvance>'."\n";
		
		$newXml .= '<easing>';
		$newXml .= ($reset ? 'easeInOutExpo' : Tools::getValue('easing'));
		$newXml .= '</easing>'."\n";
		
		$newXml .= '<effect>';
		$newXml .= ($reset ? 'random' : implode(",", Tools::getValue('effect')));
		$newXml .= '</effect>'."\n";
		
		$newXml .= '<full_screen>';
		$newXml .= ($reset ? 'false' : Tools::getValue('full_screen'));
		$newXml .= '</full_screen>'."\n";
		
		$newXml .= '<height>';
		$newXml .= ($reset ? '40%' : Tools::getValue('height'));
		$newXml .= '</height>'."\n";
		
		$newXml .= '<hover>';
		$newXml .= ($reset ? 'true' : Tools::getValue('hover'));
		$newXml .= '</hover>'."\n";
		
		$newXml .= '<animSpeed>';
		$newXml .= ($reset ? '200' : Tools::getValue('animSpeed'));
		$newXml .= '</animSpeed>'."\n";
		
		$newXml .= '<transPeriod>';
		$newXml .= ($reset ? '1500' : Tools::getValue('transPeriod'));
		$newXml .= '</transPeriod>'."\n";
		
		$newXml .= '<navigation>';
		$newXml .= ($reset ? 'true' : Tools::getValue('navigation'));
		$newXml .= '</navigation>'."\n";
		
		$newXml .= '<navigationHover>';
		$newXml .= ($reset ? 'true' : Tools::getValue('navigationHover'));
		$newXml .= '</navigationHover>'."\n";
		
		$newXml .= '<pagination>';
		$newXml .= ($reset ? 'true' : Tools::getValue('pagination'));
		$newXml .= '</pagination>'."\n";
		
		$newXml .= '<thumbnails>';
		$newXml .= ($reset ? 'false' : Tools::getValue('thumbnails'));
		$newXml .= '</thumbnails>'."\n";
		
		$newXml .= '<playPause>';
		$newXml .= ($reset ? 'false' : Tools::getValue('playPause'));
		$newXml .= '</playPause>'."\n";
		
		$newXml .= '<loader>';
		$newXml .= ($reset ? 'bar' : Tools::getValue('loader'));
		$newXml .= '</loader>'."\n";
		
		$newXml .= '<loaderBgColor>';
		$newXml .= ($reset ? '#222222' : Tools::getValue('loaderBgColor'));
		$newXml .= '</loaderBgColor>'."\n";
		
		$newXml .= '<loaderColor>';
		$newXml .= ($reset ? '#eeeeee' : Tools::getValue('loaderColor'));
		$newXml .= '</loaderColor>'."\n";
		
		$newXml .= '<loaderOpacity>';
		$newXml .= ($reset ? '.8' : Tools::getValue('loaderOpacity'));
		$newXml .= '</loaderOpacity>'."\n";
		
		$newXml .= '<loaderPadding>';
		$newXml .= ($reset ? '2' : Tools::getValue('loaderPadding'));
		$newXml .= '</loaderPadding>'."\n";
		
		$newXml .= '<loaderStroke>';
		$newXml .= ($reset ? '7' : Tools::getValue('loaderStroke'));
		$newXml .= '</loaderStroke>'."\n";
		
		$newXml .= '<barDirection>';
		$newXml .= ($reset ? 'leftToRight' : Tools::getValue('barDirection'));
		$newXml .= '</barDirection>'."\n";
		
		$newXml .= '<barPosition>';
		$newXml .= ($reset ? 'top' : Tools::getValue('barPosition'));
		$newXml .= '</barPosition>'."\n";	
		
		$newXml .= '<piePosition>';
		$newXml .= ($reset ? 'rightTop' : Tools::getValue('piePosition'));
		$newXml .= '</piePosition>'."\n";
		
		$newXml .= '<cols>';
		$newXml .= ($reset ? 6 : Tools::getValue('cols'));
		$newXml .= '</cols>'."\n";
		
		$newXml .= '<rows>';
		$newXml .= ($reset ? 4 : Tools::getValue('rows'));
		$newXml .= '</rows>'."\n";
		
		$newXml .= '<slideOn>';
		$newXml .= ($reset ? 'random' : Tools::getValue('slideOn'));
		$newXml .= '</slideOn>'."\n";
		
		
		$newXml .= '</options>'."\n";
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		if ($fd = @fopen(dirname(__FILE__).'/'.'option_'.$id_shop.'.xml', 'w'))
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
	
	private function _postProcess()
	{
		global $currentIndex;
		$errors = array();
		if (Tools::isSubmit('saveSlider'))
		{
			$slider = new SliderClass(Tools::getValue('id_slider'));
			$slider->copyFromPost();
			$errors = $slider->validateController();
						
			if (sizeof($errors))
			{
				$this->_html .= $this->displayError(implode('<br />', $errors));
			}
			else
			{
				Tools::getValue('id_slider') ? $slider->update() : $slider->add();
				$this->_clearCache('csslider.tpl');
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveSliderConfirmation');
			}
		}
		elseif (Tools::isSubmit('deleteSlider') AND Tools::getValue('id_slider'))
		{
			$slider = new SliderClass(Tools::getValue('id_slider'));
			$slider->delete();
			$this->_clearCache('csslider.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteSliderConfirmation');
		}
		elseif (Tools::isSubmit('orderSlider') AND Validate::isInt(Tools::getValue('id_slider')) AND Validate::isInt(Tools::getValue('position')))
		{
			$slider = new SliderClass(Tools::getValue('id_slider'));
			$slider->updatePosition(Tools::getValue('way'),Tools::getValue('position'));
			$this->_clearCache('csslider.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('applyOptions'))
		{
			if ($error = $this->saveXmlOption())
				$this->_html .= $error;
			else
			{
				$this->_clearCache('csslider.tpl');
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&statusConfirmation');
			}
		}
		elseif (Tools::isSubmit('changeStatusSlider') AND Tools::getValue('id_slider'))
		{
			$slidernew = new SliderClass(Tools::getValue('id_slider'));
			$slidernew->updateStatus(Tools::getValue('status'));
			$this->_clearCache('csslider.tpl');
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('resetOptions'))
		{
			if ($error = $this->saveXmlOption(true))
				$this->_html .= $error;
			else
			{
				$this->_clearCache('csslider.tpl');
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&statusConfirmation');
			}
		}
		elseif (Tools::isSubmit('saveSliderConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Slider has been added successfully'));
		elseif (Tools::isSubmit('deleteSliderConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Slider deleted successfully'));
		elseif (Tools::isSubmit('statusConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Options updated successfully'));
	}
	
	private function getSliders($active = null)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;		
	 	if (!$result = Db::getInstance()->ExecuteS(
			'SELECT ss.*, sl.*
			FROM `'._DB_PREFIX_.'csslider_shop` ss
			LEFT JOIN `'._DB_PREFIX_.'csslider` s ON (ss.id_slider = s.id_slider)
			LEFT JOIN `'._DB_PREFIX_.'csslider_lang` sl ON (s.`id_slider` = sl.`id_slider` AND sl.id_shop = '.(int)$id_shop.')
			WHERE (ss.id_shop = '.(int)$id_shop.')
			AND sl.id_lang = '.(int)$id_lang.
			($active ? ' AND ss.`display` = 1' : ' ').'
			ORDER BY ss.`position` ASC'))
	 		return false;
	 	return $result;
	}
	
	private function _displayForm()
	{
		global $currentIndex, $cookie;
	 	$this->_html .= '
		
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Sliders').'</legend>
			<p><a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addSlider"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> '.$this->l('Add a new Slider').'</a></p><br/>
			<table width="100%" class="table" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop">
				<th>&nbsp;</th>
				<th class="center">'.$this->l('Image').'</th>
				<th class="center">'.$this->l('Caption').'</th>
				<th class="center">'.$this->l('Url').'</th>
				<th class="center">'.$this->l('Displayed').'</th>
				<th class="right">'.$this->l('Position').'</th>
			</tr>
			</thead>
			<tbody>';
		$sliders = $this->getSliders(false);
		if (is_array($sliders))
		{
			static $irow;
			$stt = 1;
			foreach ($sliders as $slider)
			{
				if ($dot_pos = strrpos($slider['image'],'.'))
					$thumb_url = _PS_BASE_URL_._MODULE_DIR_.$this->name.'/images/thumbs/'.substr($slider['image'], 0, $dot_pos).substr($slider['image'], $dot_pos);
				else
					$thumb_url =_PS_BASE_URL_._MODULE_DIR_.$this->name.'/image/default_thumb.jpg';
				$this->_html .= '
				<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
					<td class="pointer" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editSlider&id_slider='.$slider['id_slider'].'\'">'.$stt.'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editSlider&id_slider='.$slider['id_slider'].'\'"><img src="'.$thumb_url.'" alt="" title="" style="height:45px;width:45px;margin: 3px 0px 3px 0px;"/></td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editSlider&id_slider='.$slider['id_slider'].'\'">'.$slider['caption'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editSlider&id_slider='.$slider['id_slider'].'\'">'.$slider['url'].'</td>
					
					<td class="pointer center"> <a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changeStatusSlider&id_slider='.$slider['id_slider'].'&status='.$slider['display'].'">'.($slider['display'] ? '<img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" />' : '<img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" />').'</a> </td>
					
					<td class="pointer center">'.($slider !== end($sliders) ? '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderSlider&id_slider='.$slider['id_slider'].'&way=1&position='.($slider['position']+1).'"><img src="'._PS_ADMIN_IMG_.'down.gif" alt="'.$this->l('Down').'" /></a>' : '').($slider !== reset($sliders) ? '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&orderSlider&id_slider='.$slider['id_slider'].'&way=0&position='.($slider['position']-1).'"><img src="'._PS_ADMIN_IMG_.'up.gif" alt="'.$this->l('Up').'" /></a>' : '').'</td>
				</tr>';
				$stt++;
			}
			
		}
		$this->_html .= '
			</tbody>
			</table>
		</fieldset>';
			
		
	}
	
	private function _displayAddForm()
	{
		global $currentIndex, $cookie;
	 	// Language 
	 	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$divLangName = 'imagediv¤captiondiv¤video_typediv¤video_iddiv';

		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('New Slider').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<label>'.$this->l('Image:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="imagediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="file" name="image_'.$language['id_lang'].'" /><sup> *</sup>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'imagediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<div class="margin-form"><div><span><a class="add-video" href="javascript:void(0)" onclick="return showVideoDiv();" title="Add video to Slideshow"><strong>Add Video</strong></a></span></div></div>
				<div class="video-section" style="display:none">
				<label>'.$this->l('Video Type:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="video_typediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<select name="video_type_'.$language['id_lang'].'">';
						$this->_html .= '<option value="1" selected="selected">Youtube</option>';
						$this->_html .= '<option value="2">Vimeo</option>';
					$this->_html .= '
						</select>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'video_typediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				<label>'.$this->l('Video ID:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="video_id_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">';
					
						$this->_html .= '<input type="text" name="video_id_'.$language['id_lang'].'" value="'.Tools::getValue('video_id_'.$language['id_lang']).'" size="30" />';
						$this->_html .= '
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'video_iddiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				</div>
				<label>'.$this->l('Caption:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="captiondiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="caption_'.$language['id_lang'].'" value="'.Tools::getValue('caption_'.$language['id_lang']).'" size="55" />
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'captiondiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('URL:').'</label>
				<div class="margin-form">
					<div id="urldiv" style="float: left;">
						<input type="text" name="url" value="'.(Tools::getValue('url') ? Tools::getValue('url') : '#').'" size="55" />
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Displayed:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" name="display" value="1"'.(Tools::getValue('display',1) ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" name="display" value="0"'.(Tools::getValue('display',1) ? '' : 'checked="checked"').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="margin-form">';
					$this->_html .= '<input type="submit" class="button" name="saveSlider" value="'.$this->l('Save Slider').'" id="saveSlider" />';
					$this->_html .= '					
				</div>
				
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
		$this->_html.='<script type="text/javascript">
			function showVideoDiv()
			{
				$(".video-section").slideToggle("slow");
			}
		</script>';
	}
	
	private function _displayUpdateForm()
	{
		global $currentIndex, $cookie;
		if (!Tools::getValue('id_slider'))
		{
			$this->_html .= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>';
			return;
		}
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;
		$slider = new SliderClass((int)Tools::getValue('id_slider'));
		
	 	// Language 
	 	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$divLangName = 'imagediv¤captiondiv¤video_typediv¤video_iddiv';

		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Edit Slider').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<input type="hidden" name="id_slider" value="'.(int)$slider->id_slider.'" id="id_slider" />
				<div class="margin-form">
					<input type="submit" class="button " name="deleteSlider" value="'.$this->l('Delete Slider').'" id="deleteSlider" onclick="if (!confirm(\'Are you sure that you want to delete this slider?\')) return false "/>
				</div>
				<label>'.$this->l('Image:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						if ($dot_pos = strrpos($slider->image[$language['id_lang']],'.'))
							$thumb_url = _PS_BASE_URL_._MODULE_DIR_.$this->name.'/images/thumbs/'.substr($slider->image[$language['id_lang']], 0, $dot_pos).substr($slider->image[$language['id_lang']], $dot_pos);
						else
							$thumb_url =_PS_BASE_URL_._MODULE_DIR_.$this->name.'/image/default_thumb.jpg';
						$this->_html .= '
					<div id="imagediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="file" name="image_'.$language['id_lang'].'" /><sup> *</sup>
						<p><img src="'.$thumb_url.'" alt="" title="" style="height:45px;width:45px;"/></p>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'imagediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>';
				$stylediv='display:block';
				if (isset($slider->video_id) && $slider->video_id=="")
				{
					$this->_html.=
					'<div class="margin-form"><div><span><a class="add-video" href="javascript:void(0)" onclick="return showVideoDiv();" title="Add video to Slideshow"><strong>Add Video</strong></a></span></div></div>';
					$stylediv='display:none';
				}
				$this->_html .='<div class="video-section" style="'.$stylediv.'">
				<label>'.$this->l('Video Type:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="video_typediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<select name="video_type_'.$language['id_lang'].'">';
						if(isset($slider->video_type[$language['id_lang']]) && $slider->video_type[$language['id_lang']]==1) $checkedy='selected="selected"';else $checkedy='';
						if(isset($slider->video_type[$language['id_lang']]) && $slider->video_type[$language['id_lang']]==2) $checkedv='selected="selected"';else $checkedv='';
						
						$this->_html .= '<option value="1"'.$checkedy.'>Youtube</option>';
						$this->_html .= '<option value="2"'.$checkedv.'>Vimeo</option>';
					$this->_html .= '
						</select>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'video_typediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Video ID:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="video_id_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">';
					
						$this->_html .= '<input type="text" name="video_id_'.$language['id_lang'].'" value="'.(isset($slider->video_id[$language['id_lang']]) ? $slider->video_id[$language['id_lang']] : '').'" size="30" />';
						$this->_html .= '
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'video_iddiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				</div>
				<label>'.$this->l('Caption:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="captiondiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="caption_'.$language['id_lang'].'" value="'.(isset($slider->caption[$language['id_lang']]) ? $slider->caption[$language['id_lang']] : '').'" size="55" />
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'captiondiv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('URL:').'</label>
				<div class="margin-form">
					<div id="urldiv" style="float: left;">
						<input type="text" name="url" value="'.($slider->url ? $slider->url : '#').'" size="55" />
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Displayed:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" name="display" value="1"'.($slider->display ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" name="display" value="0"'.($slider->display ? '' : 'checked="checked"').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="margin-form">';
					$this->_html .= '<input type="submit" class="button" name="saveSlider" value="'.$this->l('Save Slider').'" id="saveSlider" />';
					$this->_html .= '					
				</div>
				
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
		$this->_html.='<script type="text/javascript">
			function showVideoDiv()
			{
				$(".video-section").slideToggle("slow");
			}
		</script>';
	}
	
	private function getSlidersDisplay() //not yet use
	{
		$sliders = array();
	 	$results = Db::getInstance()->ExecuteS('SELECT `id_slider` FROM `'._DB_PREFIX_.'csslider` WHERE `display` = 1 ORDER BY `position` ASC');
		foreach ($results as $row)
		{
			$sliders[] = new SliderClass($row['id_slider']);
		}
		return $sliders;
	}
	
	public function hookHeader($params)
	{
		global $smarty;
		$smarty->assign(array(
			
			'HOOK_CS_SLIDESHOW' => Hook::Exec('csslideshow')
		));
		if ($smarty->tpl_vars['page_name']->value == 'index')
		{
			$this->context->controller->addCSS($this->_path.'css/camera.css');
			$this->context->controller->addJS($this->_path.'js/jquery.mobile.customized.min.js');
			$this->context->controller->addJS($this->_path.'js/jquery.easing.1.3.js');
			$this->context->controller->addJS($this->_path.'js/camera.js');
		}
	}
	
	public function hookCsSlideshow()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csslider.tpl', $this->getCacheId('csslider')))
		{
			$sliders = $this->getSliders(true);
			if($sliders)
			{
				$context = Context::getContext();
				$id_shop = $context->shop->id;
				if (file_exists(dirname(__FILE__).'/'.'option_'.$id_shop.'.xml'))
					$option = simplexml_load_file(dirname(__FILE__).'/'.'option_'.$id_shop.'.xml');
				else	
					$option = simplexml_load_file(dirname(__FILE__).'/'.'option_'.Configuration::get('PS_SHOP_DEFAULT').'.xml');
				$smarty->assign(array(
					'path' => $this->_path,
					'sliders' => $sliders,
					'option' => $option
				));
			}
		}
		return $this->display(__FILE__, 'csslider.tpl',$this->getCacheId('csslider'));
	}
	
}
?>
