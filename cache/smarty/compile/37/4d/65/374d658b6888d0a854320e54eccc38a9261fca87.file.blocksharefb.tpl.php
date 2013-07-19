<?php /* Smarty version Smarty-3.1.13, created on 2013-07-09 18:21:41
         compiled from "C:\wamp\www\fp-v1\modules\blocksharefb\blocksharefb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2057851dc3895e3ea49-63005721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '374d658b6888d0a854320e54eccc38a9261fca87' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocksharefb\\blocksharefb.tpl',
      1 => 1372670645,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2057851dc3895e3ea49-63005721',
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
  'unifunc' => 'content_51dc3895e50296_48275322',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51dc3895e50296_48275322')) {function content_51dc3895e50296_48275322($_smarty_tpl) {?>

<li id="left_share_fb">
	<a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['product_link']->value;?>
&amp;t=<?php echo $_smarty_tpl->tpl_vars['product_title']->value;?>
" class="js-new-window"><?php echo smartyTranslate(array('s'=>'Share on Facebook!','mod'=>'blocksharefb'),$_smarty_tpl);?>
</a>
</li><?php }} ?>