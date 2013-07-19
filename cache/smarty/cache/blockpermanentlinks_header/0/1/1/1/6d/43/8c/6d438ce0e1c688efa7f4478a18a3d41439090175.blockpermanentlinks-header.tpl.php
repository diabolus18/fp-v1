<?php /*%%SmartyHeaderCode:2123251d18c400e1f79-50384018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d438ce0e1c688efa7f4478a18a3d41439090175' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockpermanentlinks\\blockpermanentlinks-header.tpl',
      1 => 1372670645,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2123251d18c400e1f79-50384018',
  'variables' => 
  array (
    'link' => 0,
    'come_from' => 0,
    'meta_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18c40198235_38478276',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c40198235_38478276')) {function content_51d18c40198235_38478276($_smarty_tpl) {?>
<!-- Block permanent links module HEADER -->
<ul id="header_links">
	<li id="header_link_contact"><a href="http://localhost/fp-v1/index.php?controller=contact" title="contact">contact</a></li>
	<li id="header_link_sitemap"><a href="http://localhost/fp-v1/index.php?controller=sitemap" title="plan du site">plan du site</a></li>
	<li id="header_link_bookmark">
		<script type="text/javascript">writeBookmarkLink('http://localhost/fp-v1/index.php', 'Fontenille-Pataud', 'favoris');</script>
	</li>
</ul>
<!-- /Block permanent links module HEADER -->
<?php }} ?>