<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 12:57:09
         compiled from "C:\wamp\www\prestashop\themes\default\modules\blockmyaccount\blockmyaccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2032751d17ca5912482-85885564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9349b125ecf9576f6197c3d2f30afa5050de903a' => 
    array (
      0 => 'C:\\wamp\\www\\prestashop\\themes\\default\\modules\\blockmyaccount\\blockmyaccount.tpl',
      1 => 1372670665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2032751d17ca5912482-85885564',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_BLOCK_MY_ACCOUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d17ca59f6981_29314138',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d17ca59f6981_29314138')) {function content_51d17ca59f6981_29314138($_smarty_tpl) {?>

<!-- Block myaccount module -->
<div class="block myaccount">
	<p class="title_block"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></p>
	<div class="block_content">
		<ul class="bullet">
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My orders','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My orders','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li>
			<?php if ($_smarty_tpl->tpl_vars['returnAllowed']->value){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My merchandise returns','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My merchandise returns','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li><?php }?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My credit slips','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My credit slips','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My addresses','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My addresses','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('identity',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My personal info','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My personal info','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li>
			<?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('discount',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My vouchers','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My vouchers','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></li><?php }?>
			<?php echo $_smarty_tpl->tpl_vars['HOOK_BLOCK_MY_ACCOUNT']->value;?>

		</ul>
		<p class="logout"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout");?>
" title="<?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockmyaccount'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockmyaccount'),$_smarty_tpl);?>
</a></p>
	</div>
</div>
<!-- /Block myaccount module -->
<?php }} ?>