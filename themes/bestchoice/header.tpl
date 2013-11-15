{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso}"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso}"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
{/if}
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta http-equiv="content-language" content="{$meta_language}" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>			
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300italic,300,400italic,700,700italic' rel='stylesheet' type='text/css'>	
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />

{if isset($css_files)}
	{foreach from=$css_files key=css_uri item=media}
	<link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
	{/foreach}
{/if}
<link href="{$css_dir}reponsive.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">
			var baseDir = '{$content_dir}';
			var baseUri = '{$base_uri}';
			var static_token = '{$static_token}';
			var token = '{$token}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>

{if isset($js_files)}
	{foreach from=$js_files item=js_uri}	
		{if $settings->column == '1_column'}
			{if !strpos($js_uri,"blocklayered.js")}
				<script type="text/javascript" src="{$js_uri}"></script>
			{/if}
		{else}
			<script type="text/javascript" src="{$js_uri}"></script>
		{/if}
	{/foreach}
{/if}
<!--[if IE 7]><link href="{$css_dir}global-ie.css" rel="stylesheet" type="text/css" media="{$media}" /><![endif]-->
{if $page_name == "category" OR $page_name == "new-products" OR $page_name == "best-sales" OR $page_name=="prices-drop"}<!--list - gird-->
	<script type="text/javascript" src="{$js_dir}codespot/jquery.cookie.js"></script> 
	<script type="text/javascript" src="{$js_dir}codespot/list.gird.js"></script>
{/if}
	<script type="text/javascript" src="{$js_dir}codespot/jquery.carouFredSel-6.1.0-packed.js"></script>
	<script type="text/javascript" src="{$js_dir}codespot/getwidthbrowser.js"></script>
	<script type="text/javascript" src="{$js_dir}codespot/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="{$js_dir}codespot/jquery.touchSwipe.min.js"></script>
	<script type="text/javascript" src="{$js_dir}codespot/jquery.ba-throttle-debounce.min.js"></script>
{if $page_name == 'products-comparison'}
	<script type="text/javascript" src="{$js_dir}codespot/jquery.nicescroll.min.js"></script>
{/if}
		{$HOOK_HEADER}
	</head>
	
	<body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{if $hide_left_column}hide-left-column{/if} {if $hide_right_column}hide-right-column{/if} {if $content_only} content_only {/if}">
	{if !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
		<div id="restricted-country">
			<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
		</div>
		{/if}
		<div id="page">
			<!-- Header -->
			<div class="mode_header">
				<div class="container_24">
					<div id="header" class="grid_24 clearfix omega alpha">						
						<div id="header_right" class="grid_24 alpha omega">
							{$HOOK_TOP}
							{$HOOK_CS_TOP_BOTTOM}
						</div>
						<a id="header_logo" href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
							<img class="logo" src="{$logo_url}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" />
						</a>
						{if isset($CS_MEGA_MENU)}{$CS_MEGA_MENU}{/if}
						{if $page_name != 'index'}
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
						{/if}
					</div>
				</div>
			</div>
			
			{if $page_name == 'index'}
				{if isset($HOOK_CS_SLIDESHOW)}{$HOOK_CS_SLIDESHOW}{/if}
			{/if}
			<div class="mode_container">
				<div class="container_24">
				<div id="columns" class="{if isset($grid_column)}{$grid_column}{/if} grid_24 omega alpha">
				{if $page_name != 'index'}
					{if isset($settings)}
						{if (($settings->column == '2_column_left' || $settings->column == '3_column'))}
							<!-- Left -->
							<div id="left_column" class="{$settings->left_class} alpha">
								{$HOOK_LEFT_COLUMN}
							</div>
						{/if}
					{else}
						<!-- Left -->
							<div id="left_column" class="grid_6 alpha">
								{$HOOK_LEFT_COLUMN}
							</div>
					{/if}
				{/if}
					<!-- Center -->
					<div id="center_column" class=" {if $page_name == 'index'}grid_24 omega alpha{else}{if isset($settings)}{$settings->center_class} {else}grid_18 omega{/if}{/if}">
		{/if}
