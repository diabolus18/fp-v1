<?php /* Smarty version Smarty-3.1.13, created on 2013-08-27 11:58:49
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21055521c78599e0916-61588835%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb8ece48ec5dedca904a42388aa8f5b5abc8e4db' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\header.tpl',
      1 => 1374235091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21055521c78599e0916-61588835',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang_iso' => 0,
    'meta_title' => 0,
    'meta_description' => 0,
    'meta_keywords' => 0,
    'meta_language' => 0,
    'nobots' => 0,
    'nofollow' => 0,
    'favicon_url' => 0,
    'img_update_time' => 0,
    'css_files' => 0,
    'css_uri' => 0,
    'media' => 0,
    'css_dir' => 0,
    'content_dir' => 0,
    'base_uri' => 0,
    'static_token' => 0,
    'token' => 0,
    'priceDisplayPrecision' => 0,
    'currency' => 0,
    'priceDisplay' => 0,
    'roundMode' => 0,
    'js_files' => 0,
    'settings' => 0,
    'js_uri' => 0,
    'page_name' => 0,
    'js_dir' => 0,
    'HOOK_HEADER' => 0,
    'hide_left_column' => 0,
    'hide_right_column' => 0,
    'content_only' => 0,
    'restricted_country_mode' => 0,
    'geolocation_country' => 0,
    'HOOK_TOP' => 0,
    'HOOK_CS_TOP_BOTTOM' => 0,
    'base_dir' => 0,
    'shop_name' => 0,
    'logo_url' => 0,
    'CS_MEGA_MENU' => 0,
    'HOOK_CS_SLIDESHOW' => 0,
    'grid_column' => 0,
    'HOOK_LEFT_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521c7859cfd1a8_08354245',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521c7859cfd1a8_08354245')) {function content_521c7859cfd1a8_08354245($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
">
	<head>
		<title><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'htmlall', 'UTF-8');?>
</title>
<?php if (isset($_smarty_tpl->tpl_vars['meta_description']->value)&&$_smarty_tpl->tpl_vars['meta_description']->value){?>
		<meta name="description" content="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_description']->value, 'html', 'UTF-8');?>
" />
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['meta_keywords']->value)&&$_smarty_tpl->tpl_vars['meta_keywords']->value){?>
		<meta name="keywords" content="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_keywords']->value, 'html', 'UTF-8');?>
" />
<?php }?>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta http-equiv="content-language" content="<?php echo $_smarty_tpl->tpl_vars['meta_language']->value;?>
" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="<?php if (isset($_smarty_tpl->tpl_vars['nobots']->value)){?>no<?php }?>index,<?php if (isset($_smarty_tpl->tpl_vars['nofollow']->value)&&$_smarty_tpl->tpl_vars['nofollow']->value){?>no<?php }?>follow" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>			
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300italic,300,400italic,700,700italic' rel='stylesheet' type='text/css'>	
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />

<?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)){?>
	<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
	<link href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
" rel="stylesheet" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" />
	<?php } ?>
<?php }?>
<link href="<?php echo $_smarty_tpl->tpl_vars['css_dir']->value;?>
reponsive.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">
			var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
			var baseUri = '<?php echo $_smarty_tpl->tpl_vars['base_uri']->value;?>
';
			var static_token = '<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
';
			var token = '<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
';
			var priceDisplayPrecision = <?php echo $_smarty_tpl->tpl_vars['priceDisplayPrecision']->value*$_smarty_tpl->tpl_vars['currency']->value->decimals;?>
;
			var priceDisplayMethod = <?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
;
			var roundMode = <?php echo $_smarty_tpl->tpl_vars['roundMode']->value;?>
;
		</script>

<?php if (isset($_smarty_tpl->tpl_vars['js_files']->value)){?>
	<?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value){
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>	
		<?php if ($_smarty_tpl->tpl_vars['settings']->value->column=='1_column'){?>
			<?php if (!strpos($_smarty_tpl->tpl_vars['js_uri']->value,"blocklayered.js")){?>
				<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_uri']->value;?>
"></script>
			<?php }?>
		<?php }else{ ?>
			<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_uri']->value;?>
"></script>
		<?php }?>
	<?php } ?>
<?php }?>
<!--[if IE 7]><link href="<?php echo $_smarty_tpl->tpl_vars['css_dir']->value;?>
global-ie.css" rel="stylesheet" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" /><![endif]-->
<?php if ($_smarty_tpl->tpl_vars['page_name']->value=="category"||$_smarty_tpl->tpl_vars['page_name']->value=="new-products"||$_smarty_tpl->tpl_vars['page_name']->value=="best-sales"||$_smarty_tpl->tpl_vars['page_name']->value=="prices-drop"){?><!--list - gird-->
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.cookie.js"></script> 
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/list.gird.js"></script>
<?php }?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.carouFredSel-6.1.0-packed.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/getwidthbrowser.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.touchSwipe.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.ba-throttle-debounce.min.js"></script>
<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='products-comparison'){?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
codespot/jquery.nicescroll.min.js"></script>
<?php }?>
		<?php echo $_smarty_tpl->tpl_vars['HOOK_HEADER']->value;?>

	</head>
	
	<body <?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)){?>id="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['page_name']->value, 'htmlall', 'UTF-8');?>
"<?php }?> class="<?php if ($_smarty_tpl->tpl_vars['hide_left_column']->value){?>hide-left-column<?php }?> <?php if ($_smarty_tpl->tpl_vars['hide_right_column']->value){?>hide-right-column<?php }?> <?php if ($_smarty_tpl->tpl_vars['content_only']->value){?> content_only <?php }?>">
	<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
		<?php if (isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['restricted_country_mode']->value){?>
		<div id="restricted-country">
			<p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['geolocation_country']->value;?>
</span></p>
		</div>
		<?php }?>
		<div id="page">
			<!-- Header -->
			<div class="mode_header">
				<div class="container_24">
					<div id="header" class="grid_24 clearfix omega alpha">						
						<div id="header_right" class="grid_24 alpha omega">
							<?php echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;?>

							<?php echo $_smarty_tpl->tpl_vars['HOOK_CS_TOP_BOTTOM']->value;?>

						</div>
						<a id="header_logo" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['shop_name']->value, 'htmlall', 'UTF-8');?>
">
							<img class="logo" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['shop_name']->value, 'htmlall', 'UTF-8');?>
" />
						</a>
						<?php if (isset($_smarty_tpl->tpl_vars['CS_MEGA_MENU']->value)){?><?php echo $_smarty_tpl->tpl_vars['CS_MEGA_MENU']->value;?>
<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'){?>
						<!-- Breadcumb -->
						<script type="text/javascript">
							jQuery(document).ready(function() {
								if (jQuery("#old_bc").html()) {
									jQuery("#bc").html(jQuery("#old_bc").html());
									jQuery("#old_bc").hide();
								}
							});
						</script>
						<div class="bc_line">
							<div id="bc" class="breadcrumb"></div>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
			
			<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>
				<?php if (isset($_smarty_tpl->tpl_vars['HOOK_CS_SLIDESHOW']->value)){?><?php echo $_smarty_tpl->tpl_vars['HOOK_CS_SLIDESHOW']->value;?>
<?php }?>
			<?php }?>
			<div class="mode_container">
				<div class="container_24">
				<div id="columns" class="<?php if (isset($_smarty_tpl->tpl_vars['grid_column']->value)){?><?php echo $_smarty_tpl->tpl_vars['grid_column']->value;?>
<?php }?> grid_24 omega alpha">
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'){?>
					<?php if (isset($_smarty_tpl->tpl_vars['settings']->value)){?>
						<?php if ((($_smarty_tpl->tpl_vars['settings']->value->column=='2_column_left'||$_smarty_tpl->tpl_vars['settings']->value->column=='3_column'))){?>
							<!-- Left -->
							<div id="left_column" class="<?php echo $_smarty_tpl->tpl_vars['settings']->value->left_class;?>
 alpha">
								<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

							</div>
						<?php }?>
					<?php }else{ ?>
						<!-- Left -->
							<div id="left_column" class="grid_6 alpha">
								<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

							</div>
					<?php }?>
				<?php }?>
					<!-- Center -->
					<div id="center_column" class=" <?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>grid_24 omega alpha<?php }else{ ?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)){?><?php echo $_smarty_tpl->tpl_vars['settings']->value->center_class;?>
 <?php }else{ ?>grid_18 omega<?php }?><?php }?>">
		<?php }?>
<?php }} ?>