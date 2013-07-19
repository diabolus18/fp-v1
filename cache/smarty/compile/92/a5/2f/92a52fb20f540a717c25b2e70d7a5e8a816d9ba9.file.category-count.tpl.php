<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 14:11:21
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:861251e92ce9a240f2-66680049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92a52fb20f540a717c25b2e70d7a5e8a816d9ba9' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\category-count.tpl',
      1 => 1374235090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '861251e92ce9a240f2-66680049',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92ce9a6c6b7_90729261',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92ce9a6c6b7_90729261')) {function content_51e92ce9a6c6b7_90729261($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>