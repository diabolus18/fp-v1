<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 14:17:24
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\mobile\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1905051e92e547febf4-49066600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6076a8a030df16fddeae613dd1bdf2a7efaa0d32' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\mobile\\index.tpl',
      1 => 1374235094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1905051e92e547febf4-49066600',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92e548423f2_69953689',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92e548423f2_69953689')) {function content_51e92e548423f2_69953689($_smarty_tpl) {?>
	<div data-role="content" id="content">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"DisplayMobileIndex"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->getSubTemplate ('./sitemap.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div><!-- /content -->
<?php }} ?>