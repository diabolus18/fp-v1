<?php /* Smarty version Smarty-3.1.13, created on 2013-09-03 11:25:01
         compiled from "C:\wamp\www\fp-v1\modules\attributewizardpro\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:247145225aaed326ef5-58285219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '247145225aaed326ef5-58285219',
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
  'unifunc' => 'content_5225aaed3739d6_04223819',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5225aaed3739d6_04223819')) {function content_5225aaed3739d6_04223819($_smarty_tpl) {?><script type="text/javascript">
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