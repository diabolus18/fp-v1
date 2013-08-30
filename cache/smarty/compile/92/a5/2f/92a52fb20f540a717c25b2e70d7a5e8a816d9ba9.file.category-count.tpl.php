<?php /* Smarty version Smarty-3.1.13, created on 2013-08-28 13:39:36
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12678521de178d31154-41709703%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '12678521de178d31154-41709703',
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
  'unifunc' => 'content_521de178d74599_30634079',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521de178d74599_30634079')) {function content_521de178d74599_30634079($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>