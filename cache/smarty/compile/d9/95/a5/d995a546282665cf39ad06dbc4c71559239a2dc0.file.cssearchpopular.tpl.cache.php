<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 14:03:23
         compiled from "C:\wamp\www\fp-v1\modules\cssearchpopular\cssearchpopular.tpl" */ ?>
<?php /*%%SmartyHeaderCode:577551e92b0bf36563-74161051%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd995a546282665cf39ad06dbc4c71559239a2dc0' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\cssearchpopular\\cssearchpopular.tpl',
      1 => 1374235260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '577551e92b0bf36563-74161051',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'searchList' => 0,
    'search' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92b0c02be33_16738761',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92b0c02be33_16738761')) {function content_51e92b0c02be33_16738761($_smarty_tpl) {?><!-- MODULE search popular -->
<?php if ($_smarty_tpl->tpl_vars['searchList']->value){?>
<div class="block_popular_word_search clearfix">
	<h4 class="title_block"><?php echo smartyTranslate(array('s'=>"Most popular top searches",'mod'=>"cssearchpopular"),$_smarty_tpl);?>
</h4>
	<div class="block_content">
	<?php  $_smarty_tpl->tpl_vars['search'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['search']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['searchList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['search']->key => $_smarty_tpl->tpl_vars['search']->value){
$_smarty_tpl->tpl_vars['search']->_loop = true;
?>
	<a href="<?php ob_start();?><?php echo urlencode($_smarty_tpl->tpl_vars['search']->value['word']);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search',true,null,"search_query=".$_tmp1);?>
"><?php echo $_smarty_tpl->tpl_vars['search']->value['word'];?>
</a>
	<?php } ?>
	</div>
</div>
<?php }?>
<!-- MODULE search popular --><?php }} ?>