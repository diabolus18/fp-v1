<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:12
         compiled from "C:\wamp\www\fp-V1\admin\themes\default\template\controllers\cart_rules\product_rule_itemlist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2898151d187707ab423-19176273%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cb36375facc3aac0d73af0a7deb8156495d6449' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\admin\\themes\\default\\template\\controllers\\cart_rules\\product_rule_itemlist.tpl',
      1 => 1372670578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2898151d187707ab423-19176273',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_rule_group_id' => 0,
    'product_rule_id' => 0,
    'product_rule_itemlist' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d187708a0f47_20260420',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d187708a0f47_20260420')) {function content_51d187708a0f47_20260420($_smarty_tpl) {?><table>
	<tr>
		<td style="padding-left:20px">
			<p><strong><?php echo smartyTranslate(array('s'=>'Unselected'),$_smarty_tpl);?>
</strong></p>
			<select
				id="product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_1"
				style="border:1px solid #AAAAAA;width:400px;height:160px"
				multiple
			>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_rule_itemlist']->value['unselected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['item']->value['id']);?>
">&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
				<?php } ?>
			</select><br /><br />
			<a
				id="product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_add"
				style="cursor:pointer;text-align:center;display:block;border:1px solid #aaa;text-decoration:none;background-color:#fafafa;color:#123456;margin:2px;padding:2px"
			>
				<?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 &gt;&gt;
			</a>
		</td>
		<td>
			<p><strong><?php echo smartyTranslate(array('s'=>'Selected'),$_smarty_tpl);?>
</strong></p>
			<select
				name="product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
[]"
				id="product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_2"
				class="product_rule_toselect"
				style="border:1px solid #AAAAAA;width:400px;height:160px"
				multiple
			>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_rule_itemlist']->value['selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['item']->value['id']);?>
">&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
				<?php } ?>
			</select><br /><br />
			<a
				id="product_rule_select_<?php echo $_smarty_tpl->tpl_vars['product_rule_group_id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['product_rule_id']->value;?>
_remove"
				style="cursor:pointer;text-align:center;display:block;border:1px solid #aaa;text-decoration:none;background-color:#fafafa;color:#123456;margin:2px;padding:2px"
			>
				&lt;&lt; <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>

			</a>
		</td>
	</tr>
</table>

<script type="text/javascript">
	$('#product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_remove').click(function() { removeCartRuleOption(this); updateProductRuleShortDescription(this); });
	$('#product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_add').click(function() { addCartRuleOption(this); updateProductRuleShortDescription(this); });
	$(document).ready(function() { updateProductRuleShortDescription($('#product_rule_select_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['product_rule_id']->value);?>
_add')); });
</script><?php }} ?>