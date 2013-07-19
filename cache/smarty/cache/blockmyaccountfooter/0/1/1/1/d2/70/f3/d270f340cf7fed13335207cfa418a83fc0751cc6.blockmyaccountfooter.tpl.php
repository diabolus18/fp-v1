<?php /*%%SmartyHeaderCode:2761651e929ee225868-05443307%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd270f340cf7fed13335207cfa418a83fc0751cc6' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blockmyaccountfooter\\blockmyaccountfooter.tpl',
      1 => 1374231329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2761651e929ee225868-05443307',
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92cacd59460_09635469',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92cacd59460_09635469')) {function content_51e92cacd59460_09635469($_smarty_tpl) {?>
<!-- Block myaccount module -->
<div class="block myaccount">
	<h4 class="title_block"><a href="http://localhost/fp-v1/index.php?controller=my-account" title="Gérer mon compte client" rel="nofollow">Mon compte</a></h4>
	<div class="block_content">
		<ul class="bullet">
			<li><a href="http://localhost/fp-v1/index.php?controller=history" title="Mes commandes" rel="nofollow">Mes commandes</a></li>
						<li><a href="http://localhost/fp-v1/index.php?controller=order-slip" title="Mes avoirs" rel="nofollow">Mes avoirs</a></li>
			<li><a href="http://localhost/fp-v1/index.php?controller=addresses" title="Mes adresses" rel="nofollow">Mes adresses</a></li>
			<li><a href="http://localhost/fp-v1/index.php?controller=identity" title="Gérer mes informations personnelles" rel="nofollow">Mes informations personnelles</a></li>
						
<li class="favoriteproducts">
	<a href="http://localhost/fp-v1/index.php?fc=module&amp;module=favoriteproducts&amp;controller=account" title="Mes produits favoris">
				Mes produits favoris
	</a>
</li>

		</ul>
		<p class="logout"><a href="http://localhost/fp-v1/index.php?mylogout" title="Se déconnecter" rel="nofollow">Sign out</a></p>
	</div>
</div>
<!-- /Block myaccount module -->
<?php }} ?>