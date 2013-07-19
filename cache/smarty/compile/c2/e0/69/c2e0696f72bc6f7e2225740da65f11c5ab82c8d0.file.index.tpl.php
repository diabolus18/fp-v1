<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:18
         compiled from "C:\wamp\www\fp-V1\themes\default\mobile\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:690851d187762b20e8-37239360%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2e0696f72bc6f7e2225740da65f11c5ab82c8d0' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\themes\\default\\mobile\\index.tpl',
      1 => 1372670664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '690851d187762b20e8-37239360',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d187762be299_58158376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d187762be299_58158376')) {function content_51d187762be299_58158376($_smarty_tpl) {?>
	<div data-role="content" id="content">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"DisplayMobileIndex"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->getSubTemplate ('./sitemap.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div><!-- /content -->
<?php }} ?>