<?php /* Smarty version Smarty-3.1.13, created on 2013-09-04 13:15:09
         compiled from "C:\wamp\www\fp-v1\modules\paypal\views\templates\back\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:123185227163dd92610-64733476%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22989b75f13112e063b91f28522977ccf4cdabfa' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\paypal\\views\\templates\\back\\header.tpl',
      1 => 1378293308,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123185227163dd92610-64733476',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PayPal_WPS' => 0,
    'PayPal_HSS' => 0,
    'PayPal_ECS' => 0,
    'PayPal_module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5227163ddf5e26_62178013',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5227163ddf5e26_62178013')) {function content_5227163ddf5e26_62178013($_smarty_tpl) {?><script type="text/javascript">
    var PayPal_WPS = '<?php echo $_smarty_tpl->tpl_vars['PayPal_WPS']->value;?>
';
    var PayPal_HSS = '<?php echo $_smarty_tpl->tpl_vars['PayPal_HSS']->value;?>
';
    var PayPal_ECS = '<?php echo $_smarty_tpl->tpl_vars['PayPal_ECS']->value;?>
';
</script>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['PayPal_module_dir']->value;?>
/views/templates/back/back_office.js"></script><?php }} ?>