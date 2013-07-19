<!-- CS Slider module -->
{if isset($sliders) && $sliders|@count >0}
{if $page_name == 'index'}
<div class="cs_mode_slideshow">
<div class="cs_slideshow clearfix {if $option->full_screen=='true'}cs_slide_full_screen{else}cs_slide_no_full_screen{/if}">
<script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery('#camera_slideshow').camera({
			alignment:'{$option->alignment}',
			autoAdvance: {$option->autoadvance},
			mobileAutoAdvance:{$option->mobileautoadvance},
			easing: '{$option->easing}',
			fx : '{$option->effect}',
			mobileFx : 'scrollBoth',
			time : {$option->animSpeed},
			transPeriod : {$option->transPeriod},
			navigation : {$option->navigation},
			navigationHover : {$option->navigationHover},
			pagination : {$option->pagination},
			{if $option->pagination == "true"}thumbnails : {$option->thumbnails},{/if}
			playPause :{$option->playPause},
			loader : '{$option->loader}',
			loaderColor: '{$option->loaderColor}',
			loaderBgColor: '{$option->loaderBgColor}',
			loaderOpacity: {$option->loaderOpacity},
			loaderPadding: {$option->loaderPadding},
			loaderStroke: {$option->loaderStroke},
			barDirection : '{$option->barDirection}',
			barPosition : '{$option->barPosition}',
			piePosition : '{$option->piePosition}',
			mobileNav : false,
			imagePath : '{$path}images/',
			height	: '{$option->height}',
			hover : {$option->hover},
			cols: {$option->cols},
			rows: {$option->rows},
			slicedCols: {$option->cols*2},
			slicedRows: {$option->rows*2},
			slideOn: '{$option->slideOn}'
		});
	});
</script>
<div id="camera_slideshow" class="camera_wrap camera_emboss">
{foreach from=$sliders item=slider}
	<div data-thumb="{$path}images/thumbs/{$slider.image}" data-src="{$path}images/{$slider.image}" data-video="hide">
		<div class="camera_caption fadeFromBottom">{$slider.caption}</div>
		{if isset($slider.video_id) && $slider.video_id!="" }
			{if isset($slider.video_type) && $slider.video_type==2 }
				<iframe src="http://player.vimeo.com/video/{$slider.video_id}?autoplay=1" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			{else}		
				<iframe class="youtube-player" type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/{$slider.video_id}?autoplay=1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
				</iframe>
			{/if}
		{/if}
	</div>
{/foreach}
</div>
<div style="clear:both; display:block;"></div>
</div>
</div>
{/if}
{/if}
<!-- /CS Slider module -->