function changeOptionColumn(column)
{
	$('div.option_columns div').hide();
	$('div.' + column + '').show();
	$('input[name="column_class"]').attr('checked', false);
	$('div.' + column + ' input[name="column_class"]:first').attr("checked","checked");
}
function changeColorTemplate()
{
	$("select#color_template > option").each(function(index, element) {
		if($(element).val() == 'custom')
			$(element).attr("selected","selected");
			});
}

function showResultChooseFont(id,id_result)
{
	changeColorTemplate();
	$("#" + id_result).html("" + $("#" + id).val() + "");
	$("#" + id_result).css("font-family","" + $("#" + id).val() + "");
	$('link#link_' + id).remove();
	if($("#" + id).val() != "")
		$('head').append('<link id="link_' + id + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + $("#" + id).val() + '">');
}

function loadGoogleFont(elem)
{
	if($("#result_" + elem + "").html() != "")
	$('head').append('<link id="link_' + elem + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + $("#result_" + elem + "").html() + '">');
$("select#" + elem + " > option").each(function(index, element) {
			if($(element).val() == $("#result_" + elem + "").html())
				$(element).attr("selected","selected");
	  });
}

$(window).load(function() {
	var font_list= Array("g_fstyle_1","h_fstyle_1","h_fstyle_2","f_fstyle_1","f_fstyle_2","m_fstyle_1","m_fstyle_2","m_fstyle_2","s_fstyle_1","s_fstyle_2","p_fstyle_name","p_fstyle_description","p_fstyle_price","bt_fstyle_text","t_fstyle_page","t_fstyle_block","t_fstyle_breadcrumb");
	for (var i = 0 ; i<font_list.length; i++)
	{
		loadGoogleFont(font_list[i])
	}
	
});
function ShowUploadImage(elem)
{
	$('input[name=' + elem + ']').each(function(index, element) {
			$(element).click(function(){
			changeColorTemplate();
				if($(element).attr('checked')) {
					if($(element).val() == pattern_list[elem] )
						$("#show_" + pattern_list[elem] + "").show();
					else 
						$("#show_" + pattern_list[elem] + "").hide();
				}
			});
			if($(element).attr('checked')) {
					if($(element).val() == pattern_list[elem] )
						$("#show_" + pattern_list[elem] + "").show();
					else 
						$("#show_" + pattern_list[elem] + "").hide();
				}
		});
}

$(window).ready(function() {
	pattern_list= {'g_b_pattern': 'up_load_image_general','gb_b_pattern': 'up_load_image_general_body','h_b_pattern':'up_load_image_header','f_b_pattern':'up_load_image_footer','mp_b_pattern':'up_load_image_menuparent','ms_b_pattern':'up_load_image_menusub','s_b_pattern':'up_load_image_slideshow','bt_b_pattern':'up_load_image_button','bt2_b_pattern':'up_load_image_button2','t_b_pattern':'up_load_image_blocktitle'};
	for (var elem in pattern_list)
	{
		ShowUploadImage(elem);		
	}
	var repeat_list= Array("g_b_repeat","gb_b_repeat","h_b_repeat","f_b_repeat","mp_b_repeat","ms_b_repeat","s_b_repeat","bt_b_repeat","bg_mode","column_class","g_b_img","gb_b_img","h_b_img","f_b_img","mp_b_img","ms_b_img","s_b_img","bt_b_img","t_b_repeat");
	for (var i = 0 ; i<repeat_list.length; i++)
	{
		$('input[name=' + repeat_list[i] + ']').click(function(){
		changeColorTemplate();
		});
	}
	
	
	
});
 