<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:43
         compiled from "C:\wamp\www\fp-v1\themes\default\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1428651d188f711df19-66698178%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7bd7baffff326580716941c2e451a9f569840c52' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\default\\category-count.tpl',
      1 => 1372670661,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1428651d188f711df19-66698178',
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
  'unifunc' => 'content_51d188f71576a8_83467313',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d188f71576a8_83467313')) {function content_51d188f71576a8_83467313($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>