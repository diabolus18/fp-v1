<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:58
         compiled from "C:\wamp\www\fp-v1\admin\themes\default\template\helpers\form\form_group.tpl" */ ?>
<?php /*%%SmartyHeaderCode:657651d18906e7c820-07581493%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2771cc217f305decf4ceb24de57852a9c8fd6c5' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin\\themes\\default\\template\\helpers\\form\\form_group.tpl',
      1 => 1372670582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '657651d18906e7c820-07581493',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'groups' => 0,
    'key' => 0,
    'group' => 0,
    'id_checkbox' => 0,
    'fields_value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d189070a2d12_32196046',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d189070a2d12_32196046')) {function content_51d189070a2d12_32196046($_smarty_tpl) {?>

<?php if (count($_smarty_tpl->tpl_vars['groups']->value)&&isset($_smarty_tpl->tpl_vars['groups']->value)){?>
<table cellspacing="0" cellpadding="0" class="table" style="width:28em;">
	<tr>
		<th>
			<input type="checkbox" name="checkme" id="checkme" class="noborder" onclick="checkDelBoxes(this.form, 'groupBox[]', this.checked)" />
		</th>
		<th><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Group name'),$_smarty_tpl);?>
</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['group']->key;
?>
		<tr <?php if ($_smarty_tpl->tpl_vars['key']->value%2){?>class="alt_row"<?php }?>>
			<td>
				<?php $_smarty_tpl->tpl_vars['id_checkbox'] = new Smarty_variable((('groupBox').('_')).($_smarty_tpl->tpl_vars['group']->value['id_group']), null, 0);?>
				<input type="checkbox" name="groupBox[]" class="groupBox" id="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" <?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['id_checkbox']->value]){?>checked="checked"<?php }?> />
			</td>
			<td><?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
</td>
			<td><label for="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
" class="t"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</label></td>
		</tr>
	<?php } ?>
</table>
<?php }else{ ?>
<p><?php echo smartyTranslate(array('s'=>'No group created'),$_smarty_tpl);?>
</p>
<?php }?><?php }} ?>