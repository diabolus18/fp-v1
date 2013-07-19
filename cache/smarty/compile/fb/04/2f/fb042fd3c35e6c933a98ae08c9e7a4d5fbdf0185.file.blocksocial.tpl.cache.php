<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 13:19:25
         compiled from "C:\wamp\www\fp-v1\themes\default\modules\blocksocial\blocksocial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1923551d18c41897ac0-03088035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb042fd3c35e6c933a98ae08c9e7a4d5fbdf0185' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\default\\modules\\blocksocial\\blocksocial.tpl',
      1 => 1374231351,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1923551d18c41897ac0-03088035',
  'function' => 
  array (
  ),
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18c41909533_25705403',
  'variables' => 
  array (
    'facebook_url' => 0,
    'twitter_url' => 0,
    'rss_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c41909533_25705403')) {function content_51d18c41909533_25705403($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<div id="social_block">
	<p class="title_block"><?php echo smartyTranslate(array('s'=>'Follow us','mod'=>'blocksocial'),$_smarty_tpl);?>
</p>
	<ul>
		<?php if ($_smarty_tpl->tpl_vars['facebook_url']->value!=''){?><li class="facebook"><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['facebook_url']->value, 'html', 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['twitter_url']->value!=''){?><li class="twitter"><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['twitter_url']->value, 'html', 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['rss_url']->value!=''){?><li class="rss"><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['rss_url']->value, 'html', 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'RSS','mod'=>'blocksocial'),$_smarty_tpl);?>
</a></li><?php }?>
	</ul>
</div>
<?php }} ?>