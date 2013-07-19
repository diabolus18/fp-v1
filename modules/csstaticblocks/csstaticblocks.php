<?php
include_once(dirname(__FILE__).'/StaticBlockClass.php');
class csstaticblocks extends Module
{
	protected $error = false;
	private $_html;
	private $myHook = array('displaytop','displayleftColumn','displayrightColumn','displayfooter','displayhome', 'csslideshow','displaytopbottom','homeright','displayfootertop','displayfooterbottom');
	
	public function __construct()
	{
	 	$this->name = 'csstaticblocks';
	 	$this->tab = 'MyBlocks';
	 	$this->version = '1.0';
		$this->author = 'Codespot';
	 	parent::__construct();

		$this->displayName = $this->l('Cs Static block');
		$this->description = $this->l('Adds static blocks with free content');
		$this->confirmUninstall = $this->l('Are you sure that you want to delete your static blocks?');
	
	}
	public function init_data()
	{
		$content_block1 = '<div class="container_24">
			<div class="cs_home_staticblock">
			<div class="col extra">
			<div class="number g_color_1">10%</div>
			<h4 class="g_color_1">save an extra</h4>
			<p>when you use your credit card</p>
			</div>
			<div class="col offers">
			<p>exclusive offers</p>
			<h4 class="g_color_1">only at BEST CHOIcE</h4>
			</div>
			<div class="col deals">
			<div class="number g_color_1">70%off</div>
			<p>Deals up to</p>
			</div>
			<div class="col coveted">
			<p>The most coveted</p>
			<h4 class="g_color_1">Quality gear</h4>
			</div>
			</div>
			</div>';
		$content_block1_fr='<div class="container_24">
			<div class="cs_home_staticblock">
			<div class="col extra">
			<div class="number">10%</div>
			<h4>save an extra</h4>
			<p>when you use your credit card</p>
			</div>
			<div class="col offers">
			<p>exclusive offers</p>
			<h4>only at BEST CHOIcE</h4>
			</div>
			<div class="col deals">
			<div class="number">70%off</div>
			<p>Deals up to</p>
			</div>
			<div class="col coveted">
			<p>The most coveted</p>
			<h4>Quality gear</h4>
			</div>
			</div>
			</div>';
		$content_block2 = '<div class="block cs_sample_block_footer container_24">
		<h4>Sample Block Text Footer</h4>
		<p class="des">Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos</p>
		<div class="s_f_content">
		<div class="col consectetur">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_1.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>sapien magna</p>
		<h5>consectetur</h5>
		</div>
		</div>
		<p>Phasellus sit amet quam a leo tempus ultrice Maecenas porta arcu et tortor consequat reet Nunc eu nisl vitae orc consectetus ante ipsum primis...</p>
		<p class="Read_more"><a title="Read more" href="#">Read more</a></p>
		</div>
		<div class="col meacenas">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_2.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>NEQUE SODALES</p>
		<h5>MEACENAS TELL</h5>
		</div>
		</div>
		<p>Donec at metus non eros ornare placerat vitae vel nibh. Maecenas consectetur tellus sit amet neque eleifend ac sodales lectus tristique...</p>
		<p class="Read_more"><a title="Read more" href="#">Read more</a></p>
		</div>
		<div class="col acsit">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_3.jpg" alt="" width="281" height="105" /></a>
		<div class="bkg_color">
		<p>CONSECTETUR</p>
		<h5>ELEIFEND ACSIT</h5>
		</div>
		</div>
		<p>Donec at metus non eros ornare placerat vitae vel nibh. Maecenas consectetur tellus sit amet neque eleifend ac sodales lectus tristique...</p>
		<p class="Read_more"><a title="Read more" href="#">Read more</a></p>
		</div>
		<div class="col consectetur_2">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_4.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>sapien magna</p>
		<h5>consectetur</h5>
		</div>
		</div>
		<p>Phasellus sit amet quam a leo tempus ultrice Maecenas porta arcu et tortor consequat reet Nunc eu nisl vitae orc consectetus ante ipsum primis...</p>
		<p class="Read_more"><a title="Read more" href="#">Read more</a></p>
		</div>
		</div>
		</div>';
		$content_block2_fr='<div class="block cs_sample_block_footer container_24">
		<h4>Exemple de bloc Bas du texte</h4>
		<p class="des">Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos</p>
		<div class="s_f_content">
		<div class="col consectetur">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_1.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>sapien magna</p>
		<h5>consectetur</h5>
		</div>
		</div>
		<p>Phasellus sit amet quam a leo tempus ultrice Maecenas porta arcu et tortor consequat reet Nunc eu nisl vitae orc consectetus ante ipsum primis...</p>
		<p class="Read_more"><a title="Read more" href="#">En savoir plus</a></p>
		</div>
		<div class="col meacenas">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_2.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>NEQUE SODALES</p>
		<h5>MEACENAS TELL</h5>
		</div>
		</div>
		<p>Donec at metus non eros ornare placerat vitae vel nibh. Maecenas consectetur tellus sit amet neque eleifend ac sodales lectus tristique...</p>
		<p class="Read_more"><a title="Read more" href="#">En savoir plus</a></p>
		</div>
		<div class="col acsit">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_3.jpg" alt="" width="281" height="105" /></a>
		<div class="bkg_color">
		<p>CONSECTETUR</p>
		<h5>ELEIFEND ACSIT</h5>
		</div>
		</div>
		<p>Donec at metus non eros ornare placerat vitae vel nibh. Maecenas consectetur tellus sit amet neque eleifend ac sodales lectus tristique...</p>
		<p class="Read_more"><a title="Read more" href="#">En savoir plus</a></p>
		</div>
		<div class="col consectetur_2">
		<div class="s_f_img"><a title="" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/s_f_4.jpg" alt="" width="280" height="105" /></a>
		<div class="bkg_color">
		<p>sapien magna</p>
		<h5>consectetur</h5>
		</div>
		</div>
		<p>Phasellus sit amet quam a leo tempus ultrice Maecenas porta arcu et tortor consequat reet Nunc eu nisl vitae orc consectetus ante ipsum primis...</p>
		<p class="Read_more"><a title="Read more" href="#">En savoir plus</a></p>
		</div>
		</div>
		</div>';
		$content_block3 = '<div class="footer_copy_payment">
		<p class="copy">© 2013 Best Choice Demo Store. All Rights Reverved. <a href="http://eggthemes.com">Prestashop Themes</a> by <a href="http://eggthemes.com">eggthemes.com</a></p>
		<p class="payment"><a title="visa" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_visa.png" alt="" width="45" height="18" /></a> <a title="paypal" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_paypal.png" alt="" width="68" height="18" /></a> <a title="dhl" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_dhl.png" alt="" width="82" height="18" /></a> <a title="money" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_money.png" alt="" width="51" height="18" /></a></p>
		</div>';
		$content_block3_fr='<div class="footer_copy_payment">
			<p class="copy">© 2013 Best Choice Demo Store. All Rights Reverved. <a href="http://eggthemes.com">Presta shop Themes</a> by <a href="http://eggthemes.com">eggthemes.com</a></p>
			<p class="payment"><a title="visa" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_visa.png" alt="" width="45" height="18" /></a> <a title="paypal" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_paypal.png" alt="" width="68" height="18" /></a> <a title="dhl" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_dhl.png" alt="" width="82" height="18" /></a> <a title="money" href="#"><img src="{static_block_url}themes/bestchoice/img/cms/i_money.png" alt="" width="51" height="18" /></a></p>
			</div>';
			
		$content_block4='<div class="static_block_chat_with">
		<p><span class="h_color_2">Customer Support</span> 1800-000-perfect choice<a title="Chat with us" href="#">Chat with us</a></p>
		</div>';
		
		$content_block4_fr='<div class="static_block_chat_with">
		<p><span class="h_color_2">Soutien à la clientèle</span> 1800-000-perfect choice<a title="Chat with us" href="#">Chattez avec nous</a></p>
		</div>';
		
		$content_block5='<div class="static_block_free_account">
		<p>Free account<span class="h_color_2">+ 60% off shipping on orders US $50</span></p>
		</div>';
		
		$content_block5_fr='<div class="static_block_free_account">
		<p>Compte gratuit<span class="h_color_2">+ 60% Frais de port gratuits sur les commandes US $50</span></p>
		</div>';
		
		$content_block6='<div class="static_block_banner_home1"><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv.png" alt="" width="1180" height="117" /></a></div>';
		
		$content_block6_fr='<div class="static_block_banner_home1"><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv.png" alt="" width="1180" height="117" /></a></div>';
		
		$content_block7='<div class="static_block_banner_home_right">
			<p><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv_hamles.jpg" alt="" /></a></p>
			<p><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv_gloves.jpg" alt="" /></a></p>
			</div>';
		$content_block7_fr='<div class="static_block_banner_home_right">
		<p><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv_hamles.jpg" alt="" /></a></p>
		<p><a href="#"><img src="{static_block_url}themes/bestchoice/img/cms/banner_adv_gloves.jpg" alt="" /></a></p>
		</div>';

		$content_block8='<div class="static-blokc-follow-us">
			<h4>Follow Us</h4>
			<ul class="col">
			<li><img src="{static_block_url}themes/bestchoice/img/cms/google.png" alt="" width="16" height="16" /><a title="" href="#">Google plus</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_face_1.png" alt="" width="16" height="16" /><a title="Facebook" href="#">Facebook</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_twitter_1.png" alt="" width="16" height="16" /><a title="Twitter" href="#">Twitter</a></li>
			</ul>
			<ul class="col">
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_Flickr.png" alt="" width="16" height="16" /><a title="Flickr" href="#">Flickr</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_vineo.png" alt="" width="16" height="16" /><a title="Vimeo" href="#">Vimeo</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_rss_1.png" alt="" width="16" height="16" /><a title="RSS feed " href="#">RSS feed </a></li>
			</ul>
			</div>';
		$content_block8_fr='<div class="static-blokc-follow-us">
			<h4>Suivez-nous</h4>
			<ul class="col">
			<li><img src="{static_block_url}themes/bestchoice/img/cms/google.png" alt="" width="16" height="16" /><a title="" href="#">Google plus</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_face_1.png" alt="" width="16" height="16" /><a title="Facebook" href="#">Facebook</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_twitter_1.png" alt="" width="16" height="16" /><a title="Twitter" href="#">Twitter</a></li>
			</ul>
			<ul class="col">
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_Flickr.png" alt="" width="16" height="16" /><a title="Flickr" href="#">Flickr</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_vineo.png" alt="" width="16" height="16" /><a title="Vimeo" href="#">Vimeo</a></li>
			<li><img src="{static_block_url}themes/bestchoice/img/cms/i_rss_1.png" alt="" width="16" height="16" /><a title="RSS feed " href="#">RSS feed </a></li>
			</ul>
			</div>';
		
		
		
		$hook_slideshow = Hook::getIdByName('csslideshow');
		$hook_footer_top = Hook::getIdByName('displayfootertop');
		$hook_footer_bottom = Hook::getIdByName('displayfooterbottom');
		$hook_top = Hook::getIdByName('displaytop');
		$hook_top_bottom = Hook::getIdByName('displaytopbottom');
		$hook_home = Hook::getIdByName('displayhome');
		$hook_home_right = Hook::getIdByName('homeright');
		$hook_footer = Hook::getIdByName('displayfooter');
		
		$id_en = Language::getIdByIso('en');
		$id_fr = Language::getIdByIso('fr');
		
		$id_shop = Configuration::get('PS_SHOP_DEFAULT');
		
		//install static Block
		if(!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'staticblock` (`id_block`, `identifier_block`, `hook`, `is_active`) 
			VALUES (1, "banner-home","'.$hook_slideshow.'", 1),
				(2, "sample-block-text-footer","'.$hook_footer_top.'", 1),
				(3, "allright_payment","'.$hook_footer_bottom.'", 1),
				(4, "chat-with-our-expert","'.$hook_top.'", 1),
				(5, "free-account","'.$hook_top_bottom.'", 1),
				(6, "banner-home1","'.$hook_home.'", 1),
				(7, "banner-home-right","'.$hook_home_right.'", 1),
				(8, "follow-us-footer","'.$hook_footer.'", 1);') OR
		// Install Static Block _shop
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'staticblock_shop` (`id_block`, `id_shop`, `is_active`)
			VALUES 	(1,'.$id_shop.', 1),
					(2,'.$id_shop.', 1),
					(3,'.$id_shop.', 1),
					(4,'.$id_shop.', 1),
					(5,'.$id_shop.', 1),
					(6,'.$id_shop.', 1),
					(7,'.$id_shop.', 1),
					(8,'.$id_shop.', 1);') OR
		// static block lang
		!Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'staticblock_lang` (`id_block`, `id_lang`, `id_shop`, `title`, `content`) 
			VALUES 
			( "1", "'.$id_en.'","'.$id_shop.'","Banner Home", \''.$content_block1.'\'),
			( "1", "'.$id_fr.'","'.$id_shop.'","Banner Home", \''.$content_block1_fr.'\'),
			( "2", "'.$id_en.'","'.$id_shop.'","Sample Block Text Footer", \''.$content_block2.'\'),
			( "2", "'.$id_fr.'","'.$id_shop.'","Sample Block Text Footer", \''.$content_block2_fr.'\'),
			( "3", "'.$id_en.'","'.$id_shop.'","All Right + Payment", \''.$content_block3.'\'),
			( "3","'.$id_fr.'","'.$id_shop.'","All Right + Payment", \''.$content_block3_fr.'\'),
			( "4", "'.$id_en.'","'.$id_shop.'","chat with our expert", \''.$content_block4.'\'),
			( "4", "'.$id_fr.'","'.$id_shop.'","chat with our expert", \''.$content_block4_fr.'\'),
			( "5", "'.$id_en.'","'.$id_shop.'","Free account", \''.$content_block5.'\'),
			( "5", "'.$id_fr.'","'.$id_shop.'","Free account", \''.$content_block5_fr.'\'),
			( "6","'.$id_en.'","'.$id_shop.'","Banner Home 1", \''.$content_block6.'\'),
			( "6", "'.$id_fr.'","'.$id_shop.'","Banner Home 1", \''.$content_block6_fr.'\'),
			( "7", "'.$id_en.'","'.$id_shop.'","Banner Home Right", \''.$content_block7.'\'),
			( "7", "'.$id_fr.'","'.$id_shop.'","Banner Home Right", \''.$content_block7_fr.'\'),
			( "8", "'.$id_en.'","'.$id_shop.'","Follow Us", \''.$content_block8.'\'),
			( "8", "'.$id_fr.'","'.$id_shop.'","Follow Us", \''.$content_block8_fr.'\');')
		)
			return false;
		return true;
		
	}
	
	
	
	public function install()
	{		
	 	if (parent::install() == false OR !$this->registerHook('header'))
	 		return false;
		foreach ($this->myHook AS $hook){
			if ( !$this->registerHook($hook))
				return false;
		}
	 	if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'staticblock (`id_block` int(10) unsigned NOT NULL AUTO_INCREMENT, `identifier_block` varchar(255) NOT NULL DEFAULT \'\', `hook` int(10) unsigned, `is_active` tinyint(1) NOT NULL DEFAULT \'1\', PRIMARY KEY (`id_block`),UNIQUE KEY `identifier_block` (`identifier_block`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'staticblock_shop (`id_block` int(10) unsigned NOT NULL,`id_shop` int(10) unsigned NOT NULL,`is_active` tinyint(1) NOT NULL DEFAULT \'1\',PRIMARY KEY (`id_block`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		if (!Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'staticblock_lang (`id_block` int(10) unsigned NOT NULL, `id_lang` int(10) unsigned NOT NULL,`id_shop` int(10) unsigned NOT NULL, `title` varchar(255) NOT NULL DEFAULT \'\', `content` mediumtext, PRIMARY KEY (`id_block`,`id_lang`,`id_shop`)) ENGINE=InnoDB default CHARSET=utf8'))
	 		return false;
		$this->init_data();
	 	return true;
	}
	
	public function uninstall()
	{
	 	if (parent::uninstall() == false)
	 		return false;
	 	if (!Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'staticblock') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'staticblock_shop') OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'staticblock_lang'))
	 		return false;
		foreach($this->myHook as $hook)
		{
			$this->clearCacheBlockForHook($hook);
		}
	 	return true;
	}
	
	private function _displayHelp()
	{
		$this->_html .= '
		<br/>
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Static block Helper').'</legend>
			<div>This module customize static contents on the site. Static contents are displayed at the position of the hook : top, left, home,right, footer.</div>
		</fieldset>';
	}
	
	public function getContent()
   	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		$this->_postProcess();
		if (Tools::isSubmit('addBlock'))
			$this->_displayAddForm();
		elseif (Tools::isSubmit('editBlock'))
			$this->_displayUpdateForm();
		else
			$this->_displayForm();
		$this->_displayHelp();
		return $this->_html;
	}
	
	private function _postProcess()
	{
		global $currentIndex;
		$errors = array();
		if (Tools::isSubmit('saveBlock'))
		{
			$block = new StaticBlockClass(Tools::getValue('id_block'));
			$block->copyFromPost();
			$errors = $block->validateController();		
			if (sizeof($errors))
			{
				$this->_html .= $this->displayError(implode('<br />', $errors));
			}
			else
			{
				Tools::getValue('id_block') ? $block->update() : $block->add();
				$this->clearCacheBlockForHook(Tools::getValue('hook'));
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&saveBlockConfirmation');
			}
		}
		elseif (Tools::isSubmit('changeStatusStaticblock') AND Tools::getValue('id_block'))
		{
			$stblock = new StaticBlockClass(Tools::getValue('id_block'));
			$stblock->updateStatus(Tools::getValue('status'));
			$this->clearCacheBlockForHook(Tools::getValue('hook'));
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		elseif (Tools::isSubmit('deleteBlock') AND Tools::getValue('id_block'))
		{
			$block = new StaticBlockClass(Tools::getValue('id_block'));
			$block->delete();
			$this->clearCacheBlockForHook(Tools::getValue('hook'));
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteBlockConfirmation');
		}
		elseif (Tools::isSubmit('saveBlockConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Static block has been saved successfully'));
		elseif (Tools::isSubmit('deleteBlockConfirmation'))
			$this->_html = $this->displayConfirmation($this->l('Static block deleted successfully'));
		
	}
	
	private  function clearCacheBlockForHook($hook)
	{
		
		$this->_clearCache('csstaticblocks_'.strtolower($this->getHookName($hook)).'.tpl');
	}

	private function getBlocks()
	{
		$this->context = Context::getContext();
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;
	 	if (!$result = Db::getInstance()->ExecuteS(
			'SELECT b.id_block, b.identifier_block, b.hook, bs.is_active, bl.`title`, bl.`content` 
			FROM `'._DB_PREFIX_.'staticblock` b 
			LEFT JOIN `'._DB_PREFIX_.'staticblock_shop` bs ON (b.`id_block` = bs.`id_block` )
			LEFT JOIN `'._DB_PREFIX_.'staticblock_lang` bl ON (b.`id_block` = bl.`id_block`'.( $id_shop ? 'AND bl.`id_shop` = '.$id_shop : ' ' ).') 
			WHERE bl.id_lang = '.(int)$id_lang.
			( $id_shop ? ' AND bs.`id_shop` = '.$id_shop : ' ' )))
	 		return false;
	 	return $result;
	}
	
	private function getHookTitle($id_hook,$name=false)
	{
		if (!$result = Db::getInstance()->getRow('
			SELECT `name`,`title`
			FROM `'._DB_PREFIX_.'hook` 
			WHERE `id_hook` = '.(int)($id_hook)))
			return false;
		return (($result['title'] != "" && $name) ? $result['title'] : $result['name']);
	}
	
	private function getHookName($id_hook,$name=false)
	{
		if (!$result = Db::getInstance()->getRow('
			SELECT `name`,`title`
			FROM `'._DB_PREFIX_.'hook` 
			WHERE `id_hook` = '.(int)($id_hook)))
			return false;
		return $result['name'];
	}
	
	private function _displayForm()
	{
		global $currentIndex, $cookie;
	 	$this->_html .= '
		
	 	<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('List of static blocks').'</legend>
			<p><a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addBlock"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> '.$this->l('Add a new block').'</a></p><br/>
			<table width="100%" class="table" cellspacing="0" cellpadding="0">
			<thead>
			<tr class="nodrag nodrop">
				<th>'.$this->l('ID').'</th>
				<th class="center">'.$this->l('Title').'</th>
				<th class="center">'.$this->l('Identifier').'</th>
				<th class="center">'.$this->l('Hook into').'</th>
				<th class="right">'.$this->l('Active').'</th>
			</tr>
			</thead>
			<tbody>';
		$s_blocks = $this->getBlocks();
		if (is_array($s_blocks))
		{
			static $irow;
			foreach ($s_blocks as $block)
			{
				$this->_html .= '
				<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
					<td class="pointer" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editBlock&id_block='.$block['id_block'].'\'">'.$block['id_block'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editBlock&id_block='.$block['id_block'].'\'">'.$block['title'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editBlock&id_block='.$block['id_block'].'\'">'.$block['identifier_block'].'</td>
					<td class="pointer center" onclick="document.location = \''.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&editBlock&id_block='.$block['id_block'].'\'">'.(Validate::isInt($block['hook']) ? $this->getHookTitle($block['hook']) : '').'</td>
					<td class="pointer center"> <a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changeStatusStaticblock&id_block='.$block['id_block'].'&status='.$block['is_active'].'&hook='.$block['hook'].'">'.($block['is_active'] ? '<img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" />' : '<img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" />').'</a> </td>
				</tr>';
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
		$divLangName = 'titlediv¤contentdiv';
		// TinyMCE
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		$this->_html .=  '
		<script type="text/javascript">	
		var iso = \''.$isoTinyMCE.'\' ;
		var pathCSS = \''._THEME_CSS_DIR_.'\' ;
		var ad = \''.$ad.'\' ;
		</script>
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
		<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>	
		<script type="text/javascript">
		$(document).ready(function(){		
			tinySetup({});});
		</script>
		';
		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('New block').'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<label>'.$this->l('Title:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="titlediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="title_'.$language['id_lang'].'" value="'.Tools::getValue('title_'.$language['id_lang']).'" size="55" /><sup> *</sup>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Identifier:').'</label>
				<div class="margin-form">
					<div id="identifierdiv" style="float: left;">
						<input type="text" name="identifier_block" value="'.Tools::getValue('identifier_block').'" size="55" /><sup> *</sup>
					</div>
					<p class="clear">'.$this->l('Identifier must be unique').'. '.$this->l('Match a-zA-Z-_0-9').'</p>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Hook into:').'</label>
				<div class="margin-form">
					<div id="hookdiv" style="float: left;">
						<select name="hook">
							<option value="0">'.$this->l('None').'</option>';

		foreach ($this->myHook AS $hook){
			$id_hook = Hook::getIdByName($hook);
			$this->_html .= '<option value="'.$id_hook.'"'.($id_hook == Tools::getValue('hook') ? 'selected="selected"' : '').'>'.$this->getHookTitle($id_hook).'</option>';
		}
		
		$this->_html .= '
						</select>
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Active:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" name="is_active" value="1"'.(Tools::getValue('is_active',1) ? 'checked="checked"' : '').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" name="is_active" value="0"'.(Tools::getValue('is_active',1) ? '' : 'checked="checked"').' />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Content:').'</label>
				<div class="margin-form">';									
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="contentdiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<textarea class="rte" name="content_'.$language['id_lang'].'" id="contentInput_'.$language['id_lang'].'" cols="100" rows="20">'.Tools::getValue('content_'.$language['id_lang']).'</textarea>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'contentdiv', true);
					$this->_html .= '
					<div class="clear"></div>
				</div>			
				<div class="margin-form">';
					$this->_html .= '<input type="submit" class="button" name="saveBlock" value="'.$this->l('Save Block').'" id="saveBlock" />
									';
					$this->_html .= '					
				</div>
				
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
	}
	
	private function _displayUpdateForm()
	{
		global $currentIndex, $cookie;
		if (!Tools::getValue('id_block'))
		{
			$this->_html .= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>';
			return;
		}

		$block = new StaticBlockClass((int)Tools::getValue('id_block'));
	 	// Language 
	 	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$divLangName = 'titlediv¤contentdiv';
		// TinyMCE
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		$this->_html .=  '
		<script type="text/javascript">	
		var iso = \''.$isoTinyMCE.'\' ;
		var pathCSS = \''._THEME_CSS_DIR_.'\' ;
		var ad = \''.$ad.'\' ;
		</script>
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
		<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>	
		<script type="text/javascript">
		$(document).ready(function(){		
			tinySetup({});});
		</script>
		';
		// Form
		$this->_html .= '
		<fieldset>
			<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->l('Edit block').' '.$block->identifier_block.'</legend>
			<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
				<input type="hidden" name="id_block" value="'.(int)$block->id_block.'" id="id_block" />
				<div class="margin-form">
					<input type="submit" class="button " name="deleteBlock" value="'.$this->l('Delete Block').'" id="deleteBlock" onclick="if (!confirm(\'Are you sure that you want to delete this static blocks?\')) return false "/>
				</div>
				<label>'.$this->l('Title:').'</label>
				<div class="margin-form">';
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="titlediv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<input type="text" name="title_'.$language['id_lang'].'" value="'.(isset($block->title[$language['id_lang']]) ? $block->title[$language['id_lang']] : '').'" size="55" /><sup> *</sup>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlediv', true);	
					$this->_html .= '
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Identifier:').'</label>
				<div class="margin-form">
					<div id="identifierdiv" style="float: left;">
						<input type="text" name="identifier_block" value="'.$block->identifier_block.'" size="55" /><sup> *</sup>
					</div>
					<p class="clear">'.$this->l('Identifier must be unique').'. '.$this->l('Match a-zA-Z-_0-9').'</p>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Hook into:').'</label>
				<div class="margin-form">
					<div id="hookdiv" style="float: left;">
						<select name="hook">
							<option value="0">'.$this->l('None').'</option>';
		foreach ($this->myHook AS $hook){
			$id_hook = Hook::getIdByName($hook);
			$this->_html .= '<option value="'.$id_hook.'"'.($id_hook == $block->hook ? 'selected="selected"' : '').'>'.$this->getHookTitle($id_hook).'</option>';
		}
		$this->_html .= '
						</select>
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Status:').'</label>
				<div class="margin-form">
					<div id="activediv" style="float: left;">
						<input type="radio" name="is_active" '.($block->is_active ? 'checked="checked"' : '').' value="1" />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'enabled.gif" alt="Enabled" title="Enabled" /></label>
						<input type="radio" name="is_active" '.($block->is_active ? '' : 'checked="checked"').' value="0" />
						<label class="t"><img src="'._PS_ADMIN_IMG_.'disabled.gif" alt="Disabled" title="Disabled" /></label>
					</div>
					<div class="clear"></div>
				</div>
				
				<label>'.$this->l('Content:').'</label>
				<div class="margin-form">';									
					foreach ($languages as $language)
					{
						$this->_html .= '
					<div id="contentdiv_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
						<textarea class="rte" name="content_'.$language['id_lang'].'" id="contentInput_'.$language['id_lang'].'" cols="100" rows="20">'.(isset($block->content[$language['id_lang']]) ? $block->content[$language['id_lang']] : '').'</textarea>
					</div>';
					}
					$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'contentdiv', true);
					$this->_html .= '
					<div class="clear"></div>
				</div>			
				<div class="margin-form">';
					$this->_html .= '<input type="submit" class="button" name="saveBlock" value="'.$this->l('Save Block').'" id="saveBlock" />';
					$this->_html .= '					
				</div>
				
			</form>
			<a href="'.$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><img src="'._PS_ADMIN_IMG_.'arrow2.gif" alt="" />'.$this->l('Back to list').'</a>
		</fieldset>';
	}

	public function contentById($id_block)
	{
		global $cookie;

		$staticblock = new StaticBlockClass($id_block);
		return ($staticblock->is_active ? $staticblock->content[(int)$cookie->id_lang] : '');
	}
	
	public function contentByIdentifier($identifier)
	{
		global $cookie;

		if (!$result = Db::getInstance()->getRow('
			SELECT `id_block`,`identifier_block`
			FROM `'._DB_PREFIX_.'staticblock` 
			WHERE `identifier_block` = \''.$identifier.'\''))
			return false;
		$staticblock = new StaticBlockClass($result['id_block']);
		return ($staticblock->is_active ? $staticblock->content[(int)$cookie->id_lang] : '');
	}
	
	private function getBlockInHook($hook_name)
	{
		$block_list = array();
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_hook = Hook::getIdByName($hook_name);
		if ($id_hook)
		{
			$results = Db::getInstance()->ExecuteS('SELECT b.`id_block` FROM `'._DB_PREFIX_.'staticblock` b
			LEFT JOIN `'._DB_PREFIX_.'staticblock_shop` bs ON (b.id_block = bs.id_block)
			WHERE bs.is_active = 1 AND (bs.id_shop = '.(int)$id_shop.') AND b.`hook` = '.(int)($id_hook));
			foreach ($results as $row)
			{
				$temp = new StaticBlockClass($row['id_block']);
				$block_list[] = $temp;
			}
		}	
		
		return $block_list;
	}
	
	public function hookDisplayTop()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displaytop.tpl', $this->getCacheId('csstaticblocks_displaytop')))
		{
		$block_list = $this->getBlockInHook('displaytop');
		
		$smarty->assign(array(
			'block_list' => $block_list
		));
		}
		return $this->display(__FILE__, 'csstaticblocks_displaytop.tpl', $this->getCacheId('csstaticblocks_displaytop'));
	}
	
	public function hookDisplayLeftColumn()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displayleftColumn.tpl', $this->getCacheId('csstaticblocks_displayleftColumn')))
		{
		$block_list = $this->getBlockInHook('displayleftColumn');
		
		$smarty->assign(array(
			'block_list' => $block_list
		));
		}
		return $this->display(__FILE__, 'csstaticblocks_displayleftColumn.tpl', $this->getCacheId('csstaticblocks_displayleftColumn'));
	}
	
	public function hookDisplayFooter()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displayfooter.tpl', $this->getCacheId('csstaticblocks_displayfooter')))
		{
			$block_list = $this->getBlockInHook('displayfooter');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_displayfooter.tpl', $this->getCacheId('csstaticblocks_displayfooter'));
	}
	
	public function hookDisplayHome()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displayhome.tpl', $this->getCacheId('csstaticblocks_displayhome')))
		{
			$block_list = $this->getBlockInHook('displayhome');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		
		return $this->display(__FILE__, 'csstaticblocks_displayhome.tpl',$this->getCacheId('csstaticblocks_displayhome'));
	}
	
	function hookHeader($params)
	{
		global $smarty;
		$smarty->assign(array(
			'HOOK_CS_TOP_BOTTOM' => Hook::Exec('displaytopbottom'),
			'HOOK_CS_FOOTER_TOP' => Hook::Exec('displayfootertop'),
			'HOOK_CS_FOOTER_BOTTOM' => Hook::Exec('displayfooterbottom')
		));
	}
	
	public function hookCsSlideshow()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_csslideshow.tpl', $this->getCacheId('csstaticblocks_csslideshow')))
		{
			$block_list = $this->getBlockInHook('csslideshow');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_csslideshow.tpl',$this->getCacheId('csstaticblocks_csslideshow'));
	}
	public function hookDisplayTopBottom()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displaytopbottom.tpl', $this->getCacheId('csstaticblocks_displaytopbottom')))
		{
			$block_list = $this->getBlockInHook('displaytopbottom');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_displaytopbottom.tpl',$this->getCacheId('csstaticblocks_displaytopbottom'));
	}
	
	public function hookHomeRight()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_homeright.tpl', $this->getCacheId('csstaticblocks_homeright')))
		{
			$block_list = $this->getBlockInHook('homeright');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_homeright.tpl',$this->getCacheId('csstaticblocks_homeright'));
	}
	
	public function hookDisplayFooterTop()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displayfootertop.tpl', $this->getCacheId('csstaticblocks_displayfootertop')))
		{
			$block_list = $this->getBlockInHook('displayfootertop');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_displayfootertop.tpl',$this->getCacheId('csstaticblocks_displayfootertop'));
	}
	public function hookDisplayFooterBottom()
	{
		global $smarty, $cookie;
		if (!$this->isCached('csstaticblocks_displayfooterbottom.tpl', $this->getCacheId('csstaticblocks_displayfooterbottom')))
		{
			$block_list = $this->getBlockInHook('displayfooterbottom');
			
			$smarty->assign(array(
				'block_list' => $block_list
			));
		}
		return $this->display(__FILE__, 'csstaticblocks_displayfooterbottom.tpl', $this->getCacheId('csstaticblocks_displayfooterbottom'));
	}
}
?>
