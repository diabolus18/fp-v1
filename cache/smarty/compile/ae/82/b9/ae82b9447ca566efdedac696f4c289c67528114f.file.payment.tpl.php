<?php /* Smarty version Smarty-3.1.13, created on 2013-10-01 12:12:40
         compiled from "C:\wamp\www\fp-v1\modules\cheque\views\templates\hook\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5268524aa018132b46-05274508%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae82b9447ca566efdedac696f4c289c67528114f' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\cheque\\views\\templates\\hook\\payment.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5268524aa018132b46-05274508',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'this_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_524aa01815c1a6_85814594',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524aa01815c1a6_85814594')) {function content_524aa01815c1a6_85814594($_smarty_tpl) {?>

<p class="payment_module">
	<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('cheque','payment',array(),true);?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by check.','mod'=>'cheque'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
cheque.jpg" alt="<?php echo smartyTranslate(array('s'=>'Pay by check.','mod'=>'cheque'),$_smarty_tpl);?>
" width="86" height="49" />
		<?php echo smartyTranslate(array('s'=>'Pay by check (order processing will take more time).','mod'=>'cheque'),$_smarty_tpl);?>

	</a>
</p>
<?php }} ?>