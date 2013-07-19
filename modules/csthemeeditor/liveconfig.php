<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
//global $_COOKIE;
$id_shop = (int)Context::getContext()->shop->id;
/*load color default*/
$array_color = array ();
if (DIRECTORY_SEPARATOR == '/')
	$directory_color = _PS_ROOT_DIR_.'/modules/csthemeeditor/settings/default//';
else
	$directory_color = _PS_ROOT_DIR_.'\modules\csthemeeditor\settings\default\\';
$color_templates = glob($directory_color."*.xml");
foreach($color_templates as $k=>$template)
{
	if(substr(basename($template),8,-4) != "custom")
		$array_color[$k]=substr(basename($template),8,-4);
}
/*load color default*/
if(isset($_COOKIE["color_template_".$id_shop.""]))
	$color_tp = $_COOKIE["color_template_".$id_shop.""];
else
	$color_tp = Configuration::get('CS_COLOR_TEMPLATE_'.$id_shop,false,Shop::getGroupFromShop($id_shop),$id_shop);
if($color_tp == "custom")
	$color_tp .= '_shop'.$id_shop;
if($color_tp != '')
{
	$path = dirname(__FILE__).'/settings/';
	foreach($array_color as $cdf)
	{
		if($color_tp == $cdf)
			$path = dirname(__FILE__).'/settings/default/';
	}
	$settings = simplexml_load_file($path.'setting_'.$color_tp.'.xml');
}
header("Content-type: text/javascript");   
?>

$(window).ready(function() {
$('input[name=color_template]').click(function(){
			clearCookie();
			$.cookie('color_template_<?php echo $id_shop?>',$(this).val());
			location.reload();
	});	
$('input[name=radio_setting_column]').click(function(){
			$.cookie('setting_column_<?php echo $id_shop?>',$('select[name=setting_column]').val() + '&' + $(this).val() );
			location.reload();
	
	});	
			
$('input[value=' + $.cookie('color_template_<?php echo $id_shop?>') + ']').attr('checked', 'true');
$("#cs_reset_setting").click(function() {
		$.cookie('color_template_<?php echo $id_shop?>',null);
		$.cookie('setting_column_<?php echo $id_shop?>',null);
		
	});

<?php
 if(isset($_COOKIE['setting_column_'.$id_shop.'']) && $_COOKIE['setting_column_'.$id_shop.'']!=null) 
	{
		$cookie_column = explode("&",$_COOKIE['setting_column_'.$id_shop.'']);
		$active_select_column = $cookie_column[0];
		$active_radio_class = $cookie_column[1];
	}
	else
	{
		$active_select_column = $settings->column;
		$active_radio_class = $settings->column_class;
	}
?>
	$('select[name=setting_column] option[value=<?php echo $active_select_column ?>]').attr('selected', 'selected');
	$('div.<?php echo $active_select_column?>').show();
	$('input[value="<?php echo $active_radio_class?>"]').attr('checked', 'checked');
});
$(document).ready(function() {
<?php
	$font_list = array("g_fstyle_1","h_fstyle_1","h_fstyle_2","f_fstyle_1","f_fstyle_2","m_fstyle_1","m_fstyle_2","m_fstyle_2","s_fstyle_1","s_fstyle_2","p_fstyle_name","p_fstyle_description","p_fstyle_price","bt_fstyle_text","t_fstyle_page","t_fstyle_block","t_fstyle_breadcrumb");
	foreach($font_list as $font)
	{?>
<?php if(isset($settings->$font)){?>
	$('head').append('<link id="link_<?php echo $settings->$font ?>" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $settings->$font?>">');
	<?php } ?>
	
<?php } ?>
});
