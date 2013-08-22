<?php /* Smarty version Smarty-3.1.13, created on 2013-08-20 15:43:12
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\helpers\list\list_action_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101965213727087eeb7-55073983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd479c60d99f19771a0639ccf9940f6fe2c8c38fc' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\helpers\\list\\list_action_details.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101965213727087eeb7-55073983',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'params' => 0,
    'id' => 0,
    'action' => 0,
    'controller' => 0,
    'token' => 0,
    'json_params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521372708f1b01_52480290',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521372708f1b01_52480290')) {function content_521372708f1b01_52480290($_smarty_tpl) {?>

<a class="pointer" id="details_<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="display_action_details('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['controller']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
', <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['json_params']->value, ENT_QUOTES, 'UTF-8', true);?>
); return false">
	<img src="../img/admin/more.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a>
<?php }} ?>