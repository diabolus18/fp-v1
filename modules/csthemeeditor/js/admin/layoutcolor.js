ColorInputList= Array("g_b_color","gb_b_color","g_link_color_normal","g_link_color_hover","g_text_color","g_color_1","g_color_2","g_color_3","g_b_color_custom","h_b_color","h_color_1","h_color_2","h_color_3","f_b_color","f_color_1","f_color_2","f_color_3","mp_b_color_normal","mp_b_color_hover","mp_text_color_normal","mp_text_color_hover","ms_b_color_normal","ms_b_color_hover","ms_text1_color_normal","ms_text1_color_hover","ms_text2_color_normal","ms_text2_color_hover","s_b_color","s_bt_b_color","s_color_1","s_color_2","s_color_3","p_name_color","p_des_color","p_price_color","p_spec_price_color","p_color_1","p_color_2","p_color_3","bt_b_color_normal","bt_b_color_hover","bt_text_color_normal","bt2_b_color_normal","bt2_b_color_hover","bt2_text_color_normal","bt2_text_color_hover","t_p_color","t_t_color","t_b_color","t_f_bre_color","t_s_bre_color");
(function($){
	function dk (i)
	{
		$('#' + ColorInputList[i]).ColorPicker({
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
			$("select#color_template > option").each(function(index, element) {
			if($(element).val() == 'custom')
				$(element).attr("selected","selected");
				});
				$('#result_' + ColorInputList[i]).css('background', '#' + hex); //custom event change
				$('#result_' + ColorInputList[i]).val('#' + hex);
			}
		});
	}
	var initLayout = function() {
	for (var i = 0 ; i<ColorInputList.length; i++)
	{ 
		dk(i);
	}
	};
	EYE.register(initLayout, 'init');
})(jQuery)
function changeColorInput (i)
{
	$('#result_' + ColorInputList[i] + '').keypress(function() {
			changeColorTemplate();
		});
	$('#result_' + ColorInputList[i] + '').bind("paste",function(e){
			changeColorTemplate();
	});
	$('#result_' + ColorInputList[i] + '').blur(function() {
		$('#result_' + ColorInputList[i] + '').css('background', $(this).val());
	});
	
}
$(window).ready(function() {
	for (var i = 0 ; i<ColorInputList.length; i++)
	{
		changeColorInput(i);
	}
});