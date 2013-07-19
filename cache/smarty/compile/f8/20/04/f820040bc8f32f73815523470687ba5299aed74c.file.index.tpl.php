<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 12:57:00
         compiled from "C:\wamp\www\prestashop\themes\default\mobile\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:824151d17c9cf0ca75-40505506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f820040bc8f32f73815523470687ba5299aed74c' => 
    array (
      0 => 'C:\\wamp\\www\\prestashop\\themes\\default\\mobile\\index.tpl',
      1 => 1372670664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '824151d17c9cf0ca75-40505506',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d17c9cf1ee46_17365195',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d17c9cf1ee46_17365195')) {function content_51d17c9cf1ee46_17365195($_smarty_tpl) {?>
	<div data-role="content" id="content">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"DisplayMobileIndex"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->getSubTemplate ('./sitemap.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div><!-- /content -->
<?php }} ?>