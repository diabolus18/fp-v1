<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:47
         compiled from "C:\wamp\www\fp-v1\admin\themes\default\template\controllers\not_found\content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197451d188fb286225-15930295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58d63d18f7f94cf9dc89866dd40a8b804fa158e8' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin\\themes\\default\\template\\controllers\\not_found\\content.tpl',
      1 => 1372670580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197451d188fb286225-15930295',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'controller' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d188fb2db372_38503238',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d188fb2db372_38503238')) {function content_51d188fb2db372_38503238($_smarty_tpl) {?>
<h1><?php echo smartyTranslate(array('s'=>'The controller %s is missing or invalid.','sprintf'=>$_smarty_tpl->tpl_vars['controller']->value),$_smarty_tpl);?>
</h1>
<ul>
<li><a href="index.php"><?php echo smartyTranslate(array('s'=>'Go to the dashboard.'),$_smarty_tpl);?>
</a></li>
<li><a href="#" onclick="window.history.back();"><?php echo smartyTranslate(array('s'=>'Back to the previous page.'),$_smarty_tpl);?>
</a></li>
</ul>
<?php }} ?>