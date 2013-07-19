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
  'cache_lifetime' => 31536000,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e920bd3b96e0_49664116',
  'variables' => 
  array (
    'facebook_url' => 0,
    'twitter_url' => 0,
    'rss_url' => 0,
  ),
  'has_nocache_code' => false,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e920bd3b96e0_49664116')) {function content_51e920bd3b96e0_49664116($_smarty_tpl) {?>
<div id="social_block">
	<p class="title_block">Nous suivre</p>
	<ul>
		<li class="facebook"><a href="http://www.facebook.com/prestashop">Facebook</a></li>		<li class="twitter"><a href="http://www.twitter.com/prestashop">Twitter</a></li>		<li class="rss"><a href="http://www.prestashop.com/blog/en/feed/">RSS</a></li>	</ul>
</div>
<?php }} ?>