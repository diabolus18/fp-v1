<?php /* Smarty version Smarty-3.1.13, created on 2013-08-26 17:57:17
         compiled from "C:\wamp\www\fp-v1\modules\attributewizardpro\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22339521b7add608036-94517951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22691ea91bef7f274d6b434a2641db47b531130e' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\attributewizardpro\\header.tpl',
      1 => 1374854437,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22339521b7add608036-94517951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'awp_add_to_cart' => 0,
    'awp_include_files' => 0,
    'module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521b7add62a325_23497244',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521b7add62a325_23497244')) {function content_521b7add62a325_23497244($_smarty_tpl) {?><script type="text/javascript">
var awp_add_to_cart_display = "<?php echo $_smarty_tpl->tpl_vars['awp_add_to_cart']->value;?>
";
</script>
<?php if (isset($_smarty_tpl->tpl_vars['awp_include_files']->value)){?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
css/awp.css">
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
js/awp_product.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
js/jquery.scrollfollow.js"></script>
<?php }?><?php }} ?>