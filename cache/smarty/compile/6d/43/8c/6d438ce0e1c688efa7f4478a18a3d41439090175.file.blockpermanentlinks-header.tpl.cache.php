<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 13:19:20
         compiled from "C:\wamp\www\fp-v1\modules\blockpermanentlinks\blockpermanentlinks-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2123251d18c400e1f79-50384018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d438ce0e1c688efa7f4478a18a3d41439090175' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockpermanentlinks\\blockpermanentlinks-header.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2123251d18c400e1f79-50384018',
  'function' => 
  array (
  ),
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18c40185ac5_82244400',
  'variables' => 
  array (
    'link' => 0,
    'come_from' => 0,
    'meta_title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c40185ac5_82244400')) {function content_51d18c40185ac5_82244400($_smarty_tpl) {?>

<!-- Block permanent links module HEADER -->
<ul id="header_links">
	<li id="header_link_contact"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true);?>
" title="<?php echo smartyTranslate(array('s'=>'contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_sitemap"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('sitemap');?>
" title="<?php echo smartyTranslate(array('s'=>'sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_bookmark">
		<script type="text/javascript">writeBookmarkLink('<?php echo $_smarty_tpl->tpl_vars['come_from']->value;?>
', '<?php echo addslashes(addslashes($_smarty_tpl->tpl_vars['meta_title']->value));?>
', '<?php echo smartyTranslate(array('s'=>'bookmark','mod'=>'blockpermanentlinks','js'=>1),$_smarty_tpl);?>
');</script>
	</li>
</ul>
<!-- /Block permanent links module HEADER -->
<?php }} ?>