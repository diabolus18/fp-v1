<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 10:14:26
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\product-compare.tpl" */ ?>
<?php /*%%SmartyHeaderCode:634451fa18e2098515-72608281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e2b51b99d6a74f1641eade244da8827d387729f' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\product-compare.tpl',
      1 => 1374235091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '634451fa18e2098515-72608281',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comparator_max_item' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa18e21cb432_58669478',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa18e21cb432_58669478')) {function content_51fa18e21cb432_58669478($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['comparator_max_item']->value){?>
<script type="text/javascript">
// <![CDATA[
	var min_item = '<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
';
	var max_item = "<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
";
//]]>
</script>

	<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('products-comparison');?>
" onsubmit="true" class="compare">
		<p>
		<input type="submit" id="bt_compare" class="button" value="<?php echo smartyTranslate(array('s'=>'Compare selected item(s)'),$_smarty_tpl);?>
" />
		<input type="hidden" name="compare_product_list" class="compare_product_list" value="" />
		</p>
	</form>
<?php }?>

<?php }} ?>