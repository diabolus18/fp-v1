<?php /* Smarty version Smarty-3.1.13, created on 2013-09-04 14:32:54
         compiled from "C:\wamp\www\fp-v1\modules\csheaderlink\csheaderlink.tpl" */ ?>
<?php /*%%SmartyHeaderCode:307015227287612f607-16289245%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '141c722dd3e2c1dd04f2a778f0a2a4c42ba0db39' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csheaderlink\\csheaderlink.tpl',
      1 => 1375447131,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '307015227287612f607-16289245',
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
  'unifunc' => 'content_522728761b38b1_42184882',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_522728761b38b1_42184882')) {function content_522728761b38b1_42184882($_smarty_tpl) {?>

<!-- CS Block header links -->
<div id="cs_header_link">
	<ul id="cs_header_links">	
		<li id="cs_header_user_info">
		<?php echo smartyTranslate(array('s'=>'Welcome','mod'=>'csheaderlink'),$_smarty_tpl);?>

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
		<?php }?>
		</li>
		<li id="cs_your_account"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'csheaderlink'),$_smarty_tpl);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'My Account','mod'=>'csheaderlink'),$_smarty_tpl);?>
</a></li>
	</ul>
	
</div>
<!-- /Block user information module HEADER -->
<?php }} ?>