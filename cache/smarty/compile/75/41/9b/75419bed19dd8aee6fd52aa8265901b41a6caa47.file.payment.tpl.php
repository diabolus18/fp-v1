<?php /* Smarty version Smarty-3.1.13, created on 2013-10-01 12:12:40
         compiled from "C:\wamp\www\fp-v1\modules\bankwire\views\templates\hook\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2877524aa018182c76-15708119%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75419bed19dd8aee6fd52aa8265901b41a6caa47' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\bankwire\\views\\templates\\hook\\payment.tpl',
      1 => 1374231326,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2877524aa018182c76-15708119',
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
  'unifunc' => 'content_524aa0181a7254_28510738',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524aa0181a7254_28510738')) {function content_524aa0181a7254_28510738($_smarty_tpl) {?>

<p class="payment_module">
	<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('bankwire','payment');?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by bank wire','mod'=>'bankwire'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
bankwire.jpg" alt="<?php echo smartyTranslate(array('s'=>'Pay by bank wire','mod'=>'bankwire'),$_smarty_tpl);?>
" width="86" height="49"/>
		<?php echo smartyTranslate(array('s'=>'Pay by bank wire (order process will be longer)','mod'=>'bankwire'),$_smarty_tpl);?>

	</a>
</p><?php }} ?>