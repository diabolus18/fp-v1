<?php /* Smarty version Smarty-3.1.13, created on 2013-07-30 15:04:38
         compiled from "C:\wamp\www\fp-v1\modules\csslider\csslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3269051f7b9e6275273-19988990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '3269051f7b9e6275273-19988990',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sliders' => 0,
    'page_name' => 0,
    'option' => 0,
    'path' => 0,
    'slider' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51f7b9e6455834_35938016',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f7b9e6455834_35938016')) {function content_51f7b9e6455834_35938016($_smarty_tpl) {?><!-- CS Slider module -->
<?php if (isset($_smarty_tpl->tpl_vars['sliders']->value)&&count($_smarty_tpl->tpl_vars['sliders']->value)>0){?>
<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>
<div class="cs_mode_slideshow">
<div class="cs_slideshow clearfix <?php if ($_smarty_tpl->tpl_vars['option']->value->full_screen=='true'){?>cs_slide_full_screen<?php }else{ ?>cs_slide_no_full_screen<?php }?>">
<script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery('#camera_slideshow').camera({
			alignment:'<?php echo $_smarty_tpl->tpl_vars['option']->value->alignment;?>
',
			autoAdvance: <?php echo $_smarty_tpl->tpl_vars['option']->value->autoadvance;?>
,
			mobileAutoAdvance:<?php echo $_smarty_tpl->tpl_vars['option']->value->mobileautoadvance;?>
,
			easing: '<?php echo $_smarty_tpl->tpl_vars['option']->value->easing;?>
',
			fx : '<?php echo $_smarty_tpl->tpl_vars['option']->value->effect;?>
',
			mobileFx : 'scrollBoth',
			time : <?php echo $_smarty_tpl->tpl_vars['option']->value->animSpeed;?>
,
			transPeriod : <?php echo $_smarty_tpl->tpl_vars['option']->value->transPeriod;?>
,
			navigation : <?php echo $_smarty_tpl->tpl_vars['option']->value->navigation;?>
,
			navigationHover : <?php echo $_smarty_tpl->tpl_vars['option']->value->navigationHover;?>
,
			pagination : <?php echo $_smarty_tpl->tpl_vars['option']->value->pagination;?>
,
			<?php if ($_smarty_tpl->tpl_vars['option']->value->pagination=="true"){?>thumbnails : <?php echo $_smarty_tpl->tpl_vars['option']->value->thumbnails;?>
,<?php }?>
			playPause :<?php echo $_smarty_tpl->tpl_vars['option']->value->playPause;?>
,
			loader : '<?php echo $_smarty_tpl->tpl_vars['option']->value->loader;?>
',
			loaderColor: '<?php echo $_smarty_tpl->tpl_vars['option']->value->loaderColor;?>
',
			loaderBgColor: '<?php echo $_smarty_tpl->tpl_vars['option']->value->loaderBgColor;?>
',
			loaderOpacity: <?php echo $_smarty_tpl->tpl_vars['option']->value->loaderOpacity;?>
,
			loaderPadding: <?php echo $_smarty_tpl->tpl_vars['option']->value->loaderPadding;?>
,
			loaderStroke: <?php echo $_smarty_tpl->tpl_vars['option']->value->loaderStroke;?>
,
			barDirection : '<?php echo $_smarty_tpl->tpl_vars['option']->value->barDirection;?>
',
			barPosition : '<?php echo $_smarty_tpl->tpl_vars['option']->value->barPosition;?>
',
			piePosition : '<?php echo $_smarty_tpl->tpl_vars['option']->value->piePosition;?>
',
			mobileNav : false,
			imagePath : '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
images/',
			height	: '<?php echo $_smarty_tpl->tpl_vars['option']->value->height;?>
',
			hover : <?php echo $_smarty_tpl->tpl_vars['option']->value->hover;?>
,
			cols: <?php echo $_smarty_tpl->tpl_vars['option']->value->cols;?>
,
			rows: <?php echo $_smarty_tpl->tpl_vars['option']->value->rows;?>
,
			slicedCols: <?php echo $_smarty_tpl->tpl_vars['option']->value->cols*2;?>
,
			slicedRows: <?php echo $_smarty_tpl->tpl_vars['option']->value->rows*2;?>
,
			slideOn: '<?php echo $_smarty_tpl->tpl_vars['option']->value->slideOn;?>
'
		});
	});
</script>
<div id="camera_slideshow" class="camera_wrap camera_emboss">
<?php  $_smarty_tpl->tpl_vars['slider'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slider']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sliders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slider']->key => $_smarty_tpl->tpl_vars['slider']->value){
$_smarty_tpl->tpl_vars['slider']->_loop = true;
?>
	<div data-thumb="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
images/thumbs/<?php echo $_smarty_tpl->tpl_vars['slider']->value['image'];?>
" data-src="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
images/<?php echo $_smarty_tpl->tpl_vars['slider']->value['image'];?>
" data-video="hide">
		<div class="camera_caption fadeFromBottom"><?php echo $_smarty_tpl->tpl_vars['slider']->value['caption'];?>
</div>
		<?php if (isset($_smarty_tpl->tpl_vars['slider']->value['video_id'])&&$_smarty_tpl->tpl_vars['slider']->value['video_id']!=''){?>
			<?php if (isset($_smarty_tpl->tpl_vars['slider']->value['video_type'])&&$_smarty_tpl->tpl_vars['slider']->value['video_type']==2){?>
				<iframe src="http://player.vimeo.com/video/<?php echo $_smarty_tpl->tpl_vars['slider']->value['video_id'];?>
?autoplay=1" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php }else{ ?>		
				<iframe class="youtube-player" type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['slider']->value['video_id'];?>
?autoplay=1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
				</iframe>
			<?php }?>
		<?php }?>
	</div>
<?php } ?>
</div>
<div style="clear:both; display:block;"></div>
</div>
</div>
<?php }?>
<?php }?>
<!-- /CS Slider module --><?php }} ?>