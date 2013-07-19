<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:48
         compiled from "C:\wamp\www\fp-v1\themes\default\mobile\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1310951d188fc6dc607-08266486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2789022d498d78d3c9ecadf6fcc80f77e4e23d2' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\default\\mobile\\index.tpl',
      1 => 1372670664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1310951d188fc6dc607-08266486',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d188fc6f0593_42817980',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d188fc6f0593_42817980')) {function content_51d188fc6f0593_42817980($_smarty_tpl) {?>
	<div data-role="content" id="content">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"DisplayMobileIndex"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->getSubTemplate ('./sitemap.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div><!-- /content -->
<?php }} ?>