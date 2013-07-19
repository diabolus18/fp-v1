<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:12
         compiled from "C:\wamp\www\fp-V1\themes\default\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2705951d18770436061-32354329%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24b958f1be86161da2e05189550985a8ab67e6f3' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\themes\\default\\category-count.tpl',
      1 => 1372670661,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2705951d18770436061-32354329',
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
  'unifunc' => 'content_51d1877046d3e4_62282808',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d1877046d3e4_62282808')) {function content_51d1877046d3e4_62282808($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>