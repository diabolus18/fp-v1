<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 15:38:17
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\controllers\modules\content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3371521371492a2032-59455213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07c78ad0acf3110e8a77bc6e8e823737b14b1a14' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\controllers\\modules\\content.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3371521371492a2032-59455213',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521371493d9848_17466006',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521371493d9848_17466006')) {function content_521371493d9848_17466006($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['module_content']->value)){?>
	<?php echo $_smarty_tpl->tpl_vars['module_content']->value;?>

<?php }else{ ?>
	<?php if (!isset($_GET['configure'])){?>
		<?php echo $_smarty_tpl->getSubTemplate ('controllers/modules/js.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<?php if (isset($_GET['select'])&&$_GET['select']=='favorites'){?>
			<?php echo $_smarty_tpl->getSubTemplate ('controllers/modules/favorites.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<?php }else{ ?>
			<?php echo $_smarty_tpl->getSubTemplate ('controllers/modules/page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<?php }?>
	<?php }?>
<?php }?>
<?php }} ?>