<?php /* Smarty version Smarty-3.1.13, created on 2013-11-13 17:54:58
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\modules\csheaderlink\csheaderlink.tpl" */ ?>
<?php /*%%SmartyHeaderCode:274945283aee2f08b55-74575045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4395b88bd599f0d590a37fcb06343d89fcb9a23' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\modules\\csheaderlink\\csheaderlink.tpl',
      1 => 1380569329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '274945283aee2f08b55-74575045',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logged' => 0,
    'link' => 0,
    'cookie' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5283aee30ce6b1_25282606',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5283aee30ce6b1_25282606')) {function content_5283aee30ce6b1_25282606($_smarty_tpl) {?>

<!-- CS Block header links -->
<div id="testimonials"><a href="http://www.fontenille-pataud.com/preprod/index.php?id_cms=14&controller=cms"><?php echo smartyTranslate(array('s'=>'Testimonials','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a></div>
<div id="cs_header_link">
	<ul id="cs_header_links">	
				
		<li id="cs_header_user_info">
		<!--<?php echo smartyTranslate(array('s'=>'Welcome','mod'=>'csheaderlink'),$_smarty_tpl);?>
-->
		<?php if ($_smarty_tpl->tpl_vars['logged']->value){?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'csheaderlink'),$_smarty_tpl);?>
" class="account" rel="nofollow"><span><?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
</span></a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout");?>
" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'csheaderlink'),$_smarty_tpl);?>
" class="logout" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Log out','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a>
		<?php }else{ ?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Login to your customer account','mod'=>'csheaderlink'),$_smarty_tpl);?>
" class="login" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Login','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Login to your customer account','mod'=>'csheaderlink'),$_smarty_tpl);?>
" class="login" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Wholesale','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a>
		<?php }?>
		</li>
		<!--
		<li id="cs_your_account"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'csheaderlink'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'My Account','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a></li>
		-->
	</ul>
	
</div>
<!-- /Block user information module HEADER -->
<?php }} ?>