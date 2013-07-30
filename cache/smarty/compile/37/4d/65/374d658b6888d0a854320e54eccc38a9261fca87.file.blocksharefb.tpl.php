<?php /* Smarty version Smarty-3.1.13, created on 2013-07-30 15:03:23
         compiled from "C:\wamp\www\fp-v1\modules\blocksharefb\blocksharefb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2966851f7b99b5cf840-35179200%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '374d658b6888d0a854320e54eccc38a9261fca87' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocksharefb\\blocksharefb.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2966851f7b99b5cf840-35179200',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_link' => 0,
    'product_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51f7b99b5e8ea2_04861539',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f7b99b5e8ea2_04861539')) {function content_51f7b99b5e8ea2_04861539($_smarty_tpl) {?>

<li id="left_share_fb">
	<a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['product_link']->value;?>
&amp;t=<?php echo $_smarty_tpl->tpl_vars['product_title']->value;?>
" class="js-new-window"><?php echo smartyTranslate(array('s'=>'Share on Facebook!','mod'=>'blocksharefb'),$_smarty_tpl);?>
</a>
</li><?php }} ?>