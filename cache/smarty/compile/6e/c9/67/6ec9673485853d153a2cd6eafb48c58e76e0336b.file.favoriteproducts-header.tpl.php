<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 13:19:20
         compiled from "C:\wamp\www\fp-v1\modules\favoriteproducts\views\templates\hook\favoriteproducts-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1472051dc3894af3c28-31766923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ec9673485853d153a2cd6eafb48c58e76e0336b' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\favoriteproducts\\views\\templates\\hook\\favoriteproducts-header.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1472051dc3894af3c28-31766923',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51dc3894b5e5e1_61093798',
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51dc3894b5e5e1_61093798')) {function content_51dc3894b5e5e1_61093798($_smarty_tpl) {?>
<script type="text/javascript">
	var favorite_products_url_add = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('favoriteproducts','actions',array('process'=>'add'),false);?>
';
	var favorite_products_url_remove = '<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('favoriteproducts','actions',array('process'=>'remove'),false);?>
';
<?php if (isset($_GET['id_product'])){?>
	var favorite_products_id_product = '<?php echo intval($_GET['id_product']);?>
';
<?php }?> 
</script>
<?php }} ?>