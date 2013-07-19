fontInputList= {'text_body_font': 'body','title_page_font':'#center_column h1','title_block_font':'.block .title_block,.block h4,.block .title_block a,.block h4 a,#footer .title_block, #footer .title_block a,#cs_home_center_bottom h4,.ui-tabs .ui-tabs-nav li a, .title_tab','name_product_font':'.ajax_block_product h3 a,.products h3 a,.ajax_block_product h5 a,.products h5 a,.s_title_block a,.product_name a','menu_parent_font':'.cs_mega_menu ul li a,.sf-menu li a','menu_sub_font':'.cs_mega_menu ul li .options_list li a,.sf-menu li li a'};
ColorApplyList_bg= {'bg_color':'#page','bg_menu_parent':'#menu,#menu ul.ul_mega_menu,div.sf-contener .sf-menu','bg_menu_sub':'#menu > ul li > div.options_list, #menu > ul li > div.sub_menu,#cs_megamenu_more .more-menu ul.cms,.sf-menu ul li','bg_footer':'.mode_footer,.mode_footer_content_bottom,.cs_bo_footer_bottom','bg_button':'input.button_mini, input.button_small, input.button, input.button_large, input.button_mini_disabled, input.button_small_disabled, input.button_disabled, input.button_large_disabled, input.exclusive_mini, input.exclusive_small, input.exclusive, input.exclusive_large, input.exclusive_mini_disabled, input.exclusive_small_disabled, input.exclusive_disabled, input.exclusive_large_disabled, a.button_mini, a.button_small, a.button, a.button_large, a.exclusive_mini, a.exclusive_small, a.exclusive, a.exclusive_large, span.button_mini, span.button_small, span.button, span.button_large, span.exclusive_mini, span.exclusive_small, span.exclusive, span.exclusive_large, span.exclusive_large_disabled'};
ColorApplyList_text= {'text_body_color':'body','title_page':'#center_column h1',"title_block":'.block .title_block,.block h4,.block .title_block a,.block h4 a,#cs_home_center_bottom h4,.ui-tabs .ui-tabs-nav li a, .title_tab','text_name_product':'.ajax_block_product h3 a,.products h3 a,#cart_block #cart_block_list dt a,.ajax_block_product h5 a,.products h5 a,.s_title_block a,.product_name a,.product_images li h3 a','text_menu_parent':'.cs_mega_menu ul li a,.sf-menu li a','text_menu_sub':'.cs_mega_menu ul li .options_list li a,.sf-menu li li a,#menu ul li .out_cat_parent a.ms_text1_color_normal, #menu ul li .div_static h5,#menu ul li .div_static,#menu #cs_megamenu_more .more-menu li a.title_menu_parent,#menu .category_name'};
cookie_list = Array ('cookie_bg_pattern','cookie_bg_pattern_class','bg_color','bg_menu_parent','bg_menu_sub','bg_footer','bg_button','text_body_color','title_page','title_block','text_name_product','text_menu_parent','text_menu_sub','text_body_font','title_page_font','title_block_font','name_product_font','menu_parent_font','menu_sub_font','mode_css');
function showResultChooseFont(id,id_result)
{
	$("#" + id_result).html("" + $("#" + id).val() + "");
	$("#" + id_result).css("font-family","" + $("#" + id).val() + "");
	$('link#link_' + id).remove();
	if($("#" + id).val() != "")
	{
		$('head').append('<link id="link_' + id + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + $("#" + id).val() + '">');
		$.cookie(''+ id +'',$("#" + id).val());
		for (var elem in fontInputList)
		{
			if($.cookie(elem))
			{
				$('' + fontInputList[elem] + '').css('font-family',$.cookie(elem));
			}
		}

	}
}
function changeOptionColumn(column)
{
	$('div.option_columns div').hide();
	$('div.' + column + '').show();
}
function isMobile() {
		if( navigator.userAgent.match(/Android/i) ||
			navigator.userAgent.match(/webOS/i) ||
			navigator.userAgent.match(/iPad/i) ||
			navigator.userAgent.match(/iPhone/i) ||
			navigator.userAgent.match(/iPod/i)
			){
				return true;
		}
		return false;
	}


(function($){
	function dk (i,j)
	{
		$('#' + i).ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#' + i).css('background', '#' + hex); //custom event change
				//$('#result_' + i).val('#' + hex);
				$.cookie('' + i + '', '#' + hex);
				$('' + j + '').css('background', $.cookie('' + i + ''));
			}
		});
	}
	function dk_text (i,j)
	{
		$('#' + i).ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#' + i).css('background', '#' + hex); //custom event change
				$.cookie('' + i + '', '#' + hex);
				$('' + j + '').css('color', $.cookie('' + i + ''));
			}
		});
	}
	var initLayout = function() {
	for (var i_color_bg in ColorApplyList_bg)
	{ 
		dk(i_color_bg,ColorApplyList_bg[i_color_bg]);
	}
	for (var i_color_text in ColorApplyList_text)
	{ 
		dk_text(i_color_text,ColorApplyList_text[i_color_text]);
	}
	};
	EYE.register(initLayout, 'init');
	
})(jQuery)

jQuery(document).ready(function($) {
	if(isMobile())
	{
		$('.cpanel_icon').hide();
	}
	var styleTextbox = '<style id="setconfig">#page{	width: 1200px; box-shadow: 0 0 8px #666666;    margin: 00px auto;}@media only screen and (min-width: 1024px) and (max-width: 1279px) {	#page{	width: 960px;}}@media only screen and (max-width: 1023px){#page{margin:0 auto;border-radius:0;box-shadow: 0 0 0 #fff;}}@media only screen and (min-width: 768px) and (max-width: 1023px) {	#page {width: 768px;}}@media only screen and (max-width: 767px){#page{width:100%;}}</style>';
	if($.cookie('mode_css'))
	{
		if($.cookie('mode_css') == '1200px')
		{
			$('#page').css('width','');
			$('body').append(styleTextbox);
		}
		else
		{
			$('body style#setconfig').remove();
			$("#page").css('width',$.cookie('mode_css'));
		}
	}
	$('input[name=mode_css][value=box]').click(function(){
			$('#page').css('width','');
			if ( !$("link#setconfig").length ) {
				$('body').append(styleTextbox);
			}
			
			$.cookie('mode_css', '1200px');
	});	
	$('input[name=mode_css][value=wide]').click(function(){
			$('#page').css('width','100%');
			$('body style#setconfig').remove();
			$.cookie('mode_css', '100%');
	});	
		
	$("#cs_reset_setting").click(function() {
		for (var i = 0 ; i<cookie_list.length; i++)
		{
			if($.cookie(cookie_list[i]))
				$.cookie(cookie_list[i],null);
		}
		$(".pattern_item").removeClass("active");
		location.reload();
	});
		for (var elem in fontInputList)
		{
			if($.cookie(elem))
			{
				$('head').append('<link id="link_' + fontInputList[elem] + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + $.cookie(elem) + '">');
				$('' + fontInputList[elem] + '').css('font-family',$.cookie(elem));
				$('#result_' + elem).html($.cookie(elem));
				$('#result_' + elem).css('font-family',$.cookie(elem));
				$('#' + elem + '').val($.cookie(elem));
				if($('#' + elem + '').val() == $.cookie(elem))
					$('#' + elem + '').attr("selected","selected");
			}
		}
		for (var elemcolor_bg in ColorApplyList_bg)
		{
			if($.cookie(elemcolor_bg))
			{
				$('' + ColorApplyList_bg[elemcolor_bg] + '').css('background',$.cookie(elemcolor_bg));
			//	$('#result_' + elemcolor_bg).css('background', $.cookie(elemcolor_bg)); 
			//	$('#result_' + elemcolor_bg).val($.cookie(elemcolor_bg));
				$('#' + elemcolor_bg).css('background', $.cookie(elemcolor_bg)); 
				//$('#result_' + elemcolor_bg).val($.cookie(elemcolor_bg));
			}
		}
		for (var elemcolor_text in ColorApplyList_text)
		{
			if($.cookie(elemcolor_text))
			{
				$('' + ColorApplyList_text[elemcolor_text] + '').css('color',$.cookie(elemcolor_text));
				$('#' + elemcolor_text).css('background', $.cookie(elemcolor_text)); 
				//$('#result_' + elemcolor_text).val($.cookie(elemcolor_text));
			}
		}
		

	initCPanel();
		function initCPanel() {
			var $marginRighty = $('.cpanelContainer .cpanel_content_container');
			$marginRighty.animate({
				marginLeft: -($marginRighty.outerWidth()-40)
			});
			$marginRighty.addClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_closed" : "cpanel_opened").removeClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_opened" : "cpanel_closed");
		}
		$('.cpanelContainer .cpanel_icon').click(function() {
			$('.cpanelContainer .cpanel_content_container').show(); 
			
			var $marginRighty = $('.cpanelContainer .cpanel_content_container');
			$marginRighty.animate({
				marginLeft: parseInt($marginRighty.css('marginLeft'),10) == 0 ? -($marginRighty.outerWidth()-40) : 0
			});
			
			$marginRighty.addClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_closed" : "cpanel_opened").removeClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_opened" : "cpanel_closed");
		});
		$('#improved .head').click(function(){
			var thisitem=$(this).parent('li').find('.content');
			$('#improved li .content').not(thisitem).hide();
			$(this).parent('li').find('.content').slideToggle('slow');
		});

		if($.cookie('cookie_bg_pattern')) {
			$('#page').css('background-image', 'url("' + $.cookie('cookie_bg_pattern') + '")');
			$('#page').css('background-repeat', 'repeat');
		}
		
		
});
function  clearCookie()
{
		for (var i = 0 ; i<cookie_list.length; i++)
		{
			if($.cookie(cookie_list[i]))
				$.cookie(cookie_list[i],null);
		}
		$(".pattern_item").removeClass("active");
	
}