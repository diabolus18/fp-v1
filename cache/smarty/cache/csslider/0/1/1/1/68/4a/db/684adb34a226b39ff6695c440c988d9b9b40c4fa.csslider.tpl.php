<?php /*%%SmartyHeaderCode:3216251e92b0bc58e67-09951651%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '684adb34a226b39ff6695c440c988d9b9b40c4fa' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csslider\\csslider.tpl',
      1 => 1374235260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3216251e92b0bc58e67-09951651',
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e936667050e1_16471945',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e936667050e1_16471945')) {function content_51e936667050e1_16471945($_smarty_tpl) {?><!-- CS Slider module -->
<div class="cs_mode_slideshow">
<div class="cs_slideshow clearfix cs_slide_no_full_screen">
<script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery('#camera_slideshow').camera({
			alignment:'center',
			autoAdvance: true,
			mobileAutoAdvance:true,
			easing: 'easeInOutExpo',
			fx : 'random',
			mobileFx : 'scrollBoth',
			time : 5000,
			transPeriod : 1500,
			navigation : true,
			navigationHover : true,
			pagination : true,
			thumbnails : true,			playPause :false,
			loader : 'none',
			loaderColor: '#e631e6',
			loaderBgColor: '#31e63d',
			loaderOpacity: .8,
			loaderPadding: 2,
			loaderStroke: 7,
			barDirection : 'leftToRight',
			barPosition : 'top',
			piePosition : 'rightTop',
			mobileNav : false,
			imagePath : '/fp-v1/modules/csslider/images/',
			height	: '30%',
			hover : true,
			cols: 6,
			rows: 4,
			slicedCols: 12,
			slicedRows: 8,
			slideOn: 'random'
		});
	});
</script>
<div id="camera_slideshow" class="camera_wrap camera_emboss">
	<div data-thumb="/fp-v1/modules/csslider/images/thumbs/1_5.jpg" data-src="/fp-v1/modules/csslider/images/1_5.jpg" data-video="hide">
		<div class="camera_caption fadeFromBottom"><div class='content_slider'> <div class='block_content'> 	<h5 class='s_color_1'>assassins creed iii</h5> 	<p>Lorem ipsum dolor sit amet  consectetur adipiscing elit. Phasellus ultrices condimentum  Phasellus porttitor posuere sapien non dictum nisi convallis... </p> </div> <p class='price'><span>$259.00</span></p> </div></div>
			</div>
	<div data-thumb="/fp-v1/modules/csslider/images/thumbs/2_5.jpg" data-src="/fp-v1/modules/csslider/images/2_5.jpg" data-video="hide">
		<div class="camera_caption fadeFromBottom"><div class='content_slider'> <div class='block_content'> 	<h5 class='s_color_1'>assassins creed iii</h5> 	<p>Lorem ipsum dolor sit amet  consectetur adipiscing elit. Phasellus ultrices condimentum  Phasellus porttitor posuere sapien non dictum nisi convallis... </p> </div> <p class='price'><span>$259.00</span></p> </div></div>
			</div>
	<div data-thumb="/fp-v1/modules/csslider/images/thumbs/3_5.jpg" data-src="/fp-v1/modules/csslider/images/3_5.jpg" data-video="hide">
		<div class="camera_caption fadeFromBottom"><div class='content_slider'> <div class='block_content'> 	<h5 class='s_color_1'>assassins creed iii</h5> 	<p>Lorem ipsum dolor sit amet  consectetur adipiscing elit. Phasellus ultrices condimentum  Phasellus porttitor posuere sapien non dictum nisi convallis... </p> </div> <p class='price'><span>$259.00</span></p> </div></div>
			</div>
</div>
<div style="clear:both; display:block;"></div>
</div>
</div>
<!-- /CS Slider module --><?php }} ?>