<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
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
{
	$color_tp = $_COOKIE["color_template_".$id_shop.""];
}
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
	//echo $color_tp;
	$settings = simplexml_load_file($path.'setting_'.$color_tp.'.xml');
}
header("Content-type: text/css");    
?>
/* general - body */
/* page mode background */
<?php if(isset($settings->g_b_color) || isset($settings->g_b_pattern) || isset($settings->g_b_img) || isset($settings->g_b_repeat)) { ?>
#page
{
	<?php 
		if(isset($settings->g_b_img) && (!isset($settings->g_b_pattern) || (isset($settings->g_b_pattern) && ($settings->g_b_pattern == 'up_load_image_general') && $settings->g_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/general/background/<?php echo $settings->g_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->g_b_pattern)) { 
			if($settings->g_b_pattern != 'no_img.jpg' && $settings->g_b_pattern != 'up_load_image_general') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->g_b_pattern;?>");
		<?php } else { ?>
		background-image: none;background-repeat:repeat;
		<?php } } } ?>
		
		<?php if(isset($settings->g_b_repeat)) {?>
		background-repeat: <?php echo $settings->g_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->g_b_color)) {
			if(isset($settings->g_b_img) || (isset($settings->g_b_pattern) && $settings->g_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->g_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->g_b_color;?>;
		<?php } ?>
		border-color: <?php echo $settings->g_b_color;?>;
		<?php } ?>
}
<?php } ?>

/* body mode background */
<?php if(isset($settings->gb_b_color) || isset($settings->gb_b_pattern) || isset($settings->gb_b_img) || isset($settings->gb_b_repeat)) { ?>
body
{
	<?php 
		if(isset($settings->gb_b_img) && (!isset($settings->gb_b_pattern) || (isset($settings->gb_b_pattern) && ($settings->gb_b_pattern == 'up_load_image_general_body') && $settings->gb_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/general/background/<?php echo $settings->gb_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->gb_b_pattern)) { 
			if($settings->gb_b_pattern != 'no_img.jpg' && $settings->gb_b_pattern != 'up_load_image_general_body') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->gb_b_pattern;?>");
		<?php } else { ?>
		background-image: none;background-repeat:repeat;
		<?php } } } ?>
		
		<?php if(isset($settings->gb_b_repeat)) {?>
		background-repeat: <?php echo $settings->gb_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->gb_b_color)) {
			if(isset($settings->gb_b_img) || (isset($settings->gb_b_pattern) && $settings->gb_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->gb_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->gb_b_color;?>;
		<?php } ?>
		border-color: <?php echo $settings->gb_b_color;?>;
		<?php } ?>
}
<?php } ?>


<?php 
if(isset($_COOKIE['mode_css']) && $_COOKIE['mode_css'] !='')
{?>
	#page{
	width: <?php echo $_COOKIE['mode_css']?>;
}
<?php } else if($settings->bg_mode == "box_mode"){ ?>
#page{	width: 1200px;
    box-shadow: 0 0 8px #666666;
    margin: 0px auto;}

@media only screen and (min-width: 1024px) and (max-width: 1279px) {
	#page{	width: 960px;}
}
@media only screen and (max-width: 1023px)
	{
		#page{margin:0 auto;border-radius:0;
		box-shadow: 0 0 0 #fff;}
	}
@media only screen and (min-width: 768px) and (max-width: 1023px) {
	#page {width: 768px;}
}
@media only screen and (max-width: 767px)
{
	#page{width:100%;}
}
<?php } ?>

 
<?php if(isset($settings->g_link_color_normal)){?>
#page .block li a,
#page .myaccount_lnk_list li a,
#footer li a,
#my-account #page li a,
.ambiance .your_cart
{color:<?php echo $settings->g_link_color_normal;?>;}
<?php } ?>

<?php if(isset($settings->g_link_color_hover)){?>
#page a:hover,#page .block li a:hover,
#footer li a:hover,
#categories_block_left ul.tree a.selected,
.ambiance .your_cart:hover,
table#cart_summary  td.cart_description  p.s_title_block a:hover,
#page .s_title_block a:hover,#cs_header_link li a:hover,
#page #languages_block_footer li a:hover,
#page #currencies_block_footer li a:hover,
#page #header_right li a:hover,
#page #header_right p a:hover
{
color:<?php echo $settings->g_link_color_hover;?>;
}
<?php } ?>


<?php if(isset($settings->g_text_color) || isset($settings->g_fstyle_1) || isset($settings->g_fsize_1) || isset($settings->g_fweight_1)) {?>
body,
body #page,body #page p, body #page div,
body #page span,
body #page .block li p,
body #page p label,
body #page p.title_block,
body #page h2,
body #page h3,
#create-account_form h3, 
#authentication #login_form h3,
body #page .idTabs a,
li.address_title,table#cart_summary tfoot td,
ul.step li span, ul.step li a,
#more_info_sheets h5,
#pb-left-column #buy_block label,
#cart_summary .price,
#cart_block #cart_block_shipping_cost,
#page li,#page li a,
#page #languages_block_footer li,
#page #currencies_block_footer li,
#page #languages_block_footer li a,
#page #currencies_block_footer li a,a, p a ,
#page .cart_last_product_content a,
#page .cart_last_product_content .s_title_block a,
#page table#cart_summary td.cart_description p.s_title_block a
{
	<?php if(isset($settings->g_text_color)){?>
	color:<?php echo $settings->g_text_color;?>;
	<?php } ?>
	<?php if(isset($settings->g_fstyle_1)){?>
	font-family: <?php echo $settings->g_fstyle_1;?>;
	<?php } ?>
	<?php if(isset($settings->g_fsize_1)){?>
	font-size: <?php echo $settings->g_fsize_1;?>px;
	<?php } ?>
	<?php if(isset($settings->g_fweight_1)){?>
	font-style: <?php echo $settings->g_fweight_1;?>;
	<?php } ?>
}
<?php } ?>
/*color text custom class*/
<?php if(isset($settings->g_color_1)){?>
#page .g_color_1,
.g_color_1 {
	color:<?php echo $settings->g_color_1;?>;
}
<?php } ?>

<?php if(isset($settings->g_color_2)){?>
#page .g_color_2,
.g_color_2 {
	color:<?php echo $settings->g_color_2;?>;
}
<?php } ?>

<?php if(isset($settings->g_color_3)){?>
#page .g_color_3,.g_color_3 {
	color:<?php echo $settings->g_color_3;?>;
}
<?php } ?>
<?php if(isset($settings->g_b_color_custom)){?>
#page .g_b_color_custom,
.g_b_color_custom,
.idTabs .selected,
.idTabs  li a:hover,
ul.step li.step_current, ul.step li.step_current_end,
.ui-tabs .ui-tabs-nav li.ui-tabs-selected, 
.ui-tabs .ui-tabs-nav li:hover {
	background:<?php echo $settings->g_b_color_custom;?>;
	border: 1px solid <?php echo $settings->g_b_color_custom;?>;
}
<?php } ?>

/*Header */
/*Header mode background*/
<?php if(isset($settings->h_b_color) || isset($settings->h_b_img) || isset($settings->h_b_pattern) || isset($settings->h_b_repeat)) { ?>
.mode_header
{
	<?php 
		if(isset($settings->h_b_img) && (!isset($settings->h_b_pattern) || (isset($settings->h_b_pattern) && ($settings->h_b_pattern == 'up_load_image_header') && $settings->h_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/header/background/<?php echo $settings->h_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->h_b_pattern)) { 
			if($settings->h_b_pattern != 'no_img.jpg' && $settings->h_b_pattern != 'up_load_image_header') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->h_b_pattern;?>");
		<?php } else { ?>
		background-image: none;
		<?php } } } ?>
		
		<?php if(isset($settings->h_b_repeat)) {?>
		background-repeat: <?php echo $settings->h_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->h_b_color)) {
			if(isset($settings->h_b_img) || (isset($settings->h_b_pattern) && $settings->h_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->h_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->h_b_color;?>;
		<?php } ?>
		border-color: <?php echo $settings->h_b_color;?>;
		<?php } ?>
}
<?php } ?>
/*color text custom - header*/
 <?php if(isset($settings->h_color_1)){?>
#page .h_color_1,
.h_color_1,
#page #header_right,
#page #header_right li,
#page #header_right li a,
#page #header_right p,
#page #header_right p a,
#page #header_right span {
	color:<?php echo $settings->h_color_1;?>;
}
<?php } ?>
 <?php if(isset($settings->h_color_2)){?>
#page  .h_color_2,
.h_color_2,
#page #header_right span.h_color_2{
	color:<?php echo $settings->h_color_2;?>;
}
<?php } ?>
 <?php if(isset($settings->h_color_3)){?>
#page .h_color_3,
.h_color_3 {
	color:<?php echo $settings->h_color_3;?>;
}
<?php } ?>
 
/*font text custom - header*/
<?php if(isset($settings->h_fstyle_1) || isset($settings->h_fsize_1) || isset($settings->h_fweight_1)) {?>
#page .h_fstyle_1,
.h_fstyle_1,
#page #header,
.static_block_free_account,
form#searchbox label,
#languages_block_footer,
#currencies_block_footer,
#cs_header_link li,
.static_block_chat_with
	{	
		<?php if(isset($settings->h_fstyle_1)){?>
		font-family: "<?php echo $settings->h_fstyle_1;?>";
		<?php } ?>
		<?php if(isset($settings->h_fsize_1)){?>
		font-size: <?php echo $settings->h_fsize_1;?>px;
		<?php } ?>
		<?php if(isset($settings->h_fweight_1)){?>
		font-style: <?php echo $settings->h_fweight_1;?>;
		<?php } ?>
	}
<?php } ?>

<?php if(isset($settings->h_fstyle_2) || isset($settings->h_fsize_2) || isset($settings->h_fweight_2)) {?>
#page .h_fstyle_2,
.h_fstyle_2,
#page #shopping_cart a
	{	
		<?php if(isset($settings->h_fstyle_2)){?>
		font-family: "<?php echo $settings->h_fstyle_2;?>";
		<?php } ?>
		<?php if(isset($settings->h_fsize_2)){?>
		font-size: <?php echo $settings->h_fsize_2;?>px;
		<?php } ?>
		<?php if(isset($settings->h_fweight_2)){?>
		font-style: <?php echo $settings->h_fweight_2;?>;
		<?php } ?>
	}
<?php } ?>


/* Footer */
/* Footer mode background */
<?php if(isset($settings->f_b_color) || isset($settings->f_b_img) || isset($settings->f_b_pattern) || isset($settings->f_b_repeat)) { ?>
.mode_footer,
.mode_footer_content_bottom
{		
	<?php 
		if(isset($settings->f_b_img) && (!isset($settings->f_b_pattern) || (isset($settings->f_b_pattern) && ($settings->f_b_pattern == 'up_load_image_footer') && $settings->f_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/footer/background/<?php echo $settings->f_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->f_b_pattern)) { 
			if($settings->f_b_pattern != 'no_img.jpg' && $settings->f_b_pattern != 'up_load_image_footer') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->f_b_pattern;?>");
		<?php } else { ?>
		background-image: none;
		<?php } } } ?>
		
		<?php if(isset($settings->f_b_repeat)) {?>
		background-repeat: <?php echo $settings->f_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->f_b_color)) {
			if(isset($settings->f_b_img) || (isset($settings->f_b_pattern) && $settings->f_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->f_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->f_b_color;?>;
		<?php } ?>
		border-color: <?php echo $settings->f_b_color;?>;
		<?php } ?>
}
<?php } ?>

 /*color text custom - footer*/
 <?php if(isset($settings->f_color_1)){?>
#page .f_color_1,
.f_color_1,
#page #footer h4 ,
#page #footer h4 a,
#page .mode_footer h4,
.mode_footer,
.mode_footer li a,
.mode_footer a,
.mode_footer p a,
.cs_sample_block_footer .col p.Read_more a,
#footer,
.footer_copy_payment p.copy  {
	color:<?php echo $settings->f_color_1;?>;
}
<?php } ?>
 <?php if(isset($settings->f_color_2)){?>
#page .f_color_2,
.f_color_2,
#page #footer p,
#footer li a,
#block_contact_infos li,
.footer_copy_payment p.copy a {
	color:<?php echo $settings->f_color_2;?>;
}
<?php } ?>
 <?php if(isset($settings->f_color_3)){?>
#page .f_color_3,
.f_color_3 {
	color:<?php echo $settings->f_color_3;?>;
}
<?php } ?>
 
/*font text custom - footer*/
<?php if(isset($settings->f_fstyle_1) || isset($settings->f_fsize_1) || isset($settings->f_fweight_1)) {?>
#page .f_fstyle_1,
.f_fstyle_1,
#footer .title_block, 
#footer .title_block a,
#page #footer h4,
#page #footer .block h4,
#page #footer h4 a,
.block_popular_word_search h4,
#page .block.cs_sample_block_footer h4,
#page .mode_footer h4,
.mode_footer,
.mode_footer li a,
.mode_footer a,
.mode_footer p a,
#block_contact_infos li,
.cs_sample_block_footer .col p.Read_more a
	{	
		<?php if(isset($settings->f_fstyle_1)){?>
		font-family: <?php echo $settings->f_fstyle_1;?>;
		<?php } ?>
		<?php if(isset($settings->f_fsize_1)){?>
		font-size: <?php echo $settings->f_fsize_1;?>px;
		<?php } ?>
		<?php if(isset($settings->f_fweight_1)){?>
		font-style: <?php echo $settings->f_fweight_1;?>;
		<?php } ?>
	}
<?php } ?>

<?php if(isset($settings->f_fstyle_2) || isset($settings->f_fsize_2) || isset($settings->f_fweight_2)) {?>
#page .f_fstyle_2,,
#page #footer p,
#page #footer li a
	{	
		<?php if(isset($settings->f_fstyle_2)){?>
		font-family: <?php echo $settings->f_fstyle_2;?>;
		<?php } ?>
		<?php if(isset($settings->f_fsize_2)){?>
		font-size: <?php echo $settings->f_fsize_2;?>px;
		<?php } ?>
		<?php if(isset($settings->f_fweight_2)){?>
		font-style: <?php echo $settings->f_fweight_2;?>;
		<?php } ?>
	}
<?php } ?>


/* Menu */
/* Menu Parent */
<?php if(isset($settings->mp_b_color_normal) OR isset($settings->mp_b_img) OR isset($settings->mp_b_pattern)){?>
#page #menu,
#page div.sf-contener .sf-menu
	{
		<?php 
		if(isset($settings->mp_b_img) && (!isset($settings->mp_b_pattern) || (isset($settings->mp_b_pattern) && ($settings->mp_b_pattern == 'up_load_image_menuparent') && $settings->mp_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/menuparent/background/<?php echo $settings->mp_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->mp_b_pattern)) { 
			if($settings->mp_b_pattern != 'no_img.jpg' && $settings->mp_b_pattern != 'up_load_image_menuparent') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->mp_b_pattern;?>");
		<?php } else { ?>
		background-image: none;
		<?php } } } ?>
		
		<?php if(isset($settings->mp_b_repeat)) {?>
		background-repeat: <?php echo $settings->mp_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->mp_b_color_normal)) {
			if(isset($settings->mp_b_img) || (isset($settings->mp_b_pattern) && $settings->mp_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->mp_b_color_normal; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->mp_b_color_normal;?>;
		<?php } ?>
		border-color: <?php echo $settings->mp_b_color_normal;?>;
		<?php } ?>
		
	}
<?php } ?>
<?php if(isset($settings->mp_b_color_hover)){?>
#page #menu ul li.menu_item:hover,
#page div.sf-contener .sf-menu li:hover
	{
		background: <?php echo $settings->mp_b_color_hover;?>;
	}
#menu > ul li > div.options_list, #menu > ul li > div.sub_menu{border:1px solid <?php echo $settings->mp_b_color_hover;?>}
<?php } ?>

<?php if(isset($settings->mp_text_color_normal) || isset($settings->mp_text_fstyle) || isset($settings->mp_text_fsize) || isset($settings->mp_text_fweight)){?>	
#page #menu ul li a.title_menu_parent,
#page #header .sf-menu li a,
#cs_megamenu_more a.more
	{
		<?php if(isset($settings->mp_text_color_normal)){?>	
		color:<?php echo $settings->mp_text_color_normal;?>;
		<?php } ?>
		<?php if(isset($settings->mp_text_fstyle)){?>
		font-family: <?php echo $settings->mp_text_fstyle;?>;
		<?php } ?>
		<?php if(isset($settings->mp_text_fsize)){?>
		font-size: <?php echo $settings->mp_text_fsize;?>px;
		<?php } ?>
		<?php if(isset($settings->mp_text_fweight)){?>
		font-style: <?php echo $settings->mp_text_fweight;?>;
		<?php } ?>
	}
<?php } ?>
<?php if(isset($settings->mp_text_color_hover)){?>
#page #header div.sf-contener .sf-menu li a:hover,
#page #menu ul  li.menu_item a.title_menu_parent:hover,
#cs_megamenu_more a.more:hover
	{
	color:<?php echo $settings->mp_text_color_hover;?>;	
	}
<?php } ?>


/* Sub menu */
<?php if(isset($settings->ms_b_color_normal) OR isset($settings->ms_b_img) OR isset($settings->ms_b_pattern)){?>
#page #menu > ul li > div.options_list, 
#page #menu > ul li > div.sub_menu,
#page .sf-contener .sf-menu li ul
	{
		<?php 
		if(isset($settings->ms_b_img) && (!isset($settings->ms_b_pattern) || (isset($settings->ms_b_pattern) && ($settings->ms_b_pattern == 'up_load_image_menusub') && $settings->ms_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/menusub/background/<?php echo $settings->ms_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->ms_b_pattern)) { 
			if($settings->ms_b_pattern != 'no_img.jpg' && $settings->ms_b_pattern != 'up_load_image_menusub') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->ms_b_pattern;?>");
		<?php } else { ?>
		background-image: none;
		<?php } } } ?>
		
		<?php if(isset($settings->ms_b_repeat)) {?>
		background-repeat: <?php echo $settings->ms_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->ms_b_color_normal)) {
			if(isset($settings->ms_b_img) || (isset($settings->ms_b_pattern) && $settings->ms_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->ms_b_color_normal; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->ms_b_color_normal;?>;
		<?php } ?>
		border-color: <?php echo $settings->ms_b_color_normal;?>;
		<?php } ?>
	}
<?php } ?>


<?php if(isset($settings->ms_b_color_hover)){?>
#page #menu > ul > li .options_list li.category_item:hover,
#page #menu > ul > li .options_list li.category_item li:hover,
#page div.sf-contener .sf-menu li ul li:hover
	{
		background: <?php echo $settings->ms_b_color_hover;?>;
	}
<?php } ?>

/*color text custom - submenu*/
<?php if(isset($settings->ms_text1_color_normal)){?>
#page .ms_text1_color_normal,.ms_text1_color_normal,
#page #menu ul li .out_cat_parent a.ms_text1_color_normal,
#menu > ul li.menu_item > div a,
#menu ul li .div_static p,
#menu ul li .div_static h3,
#page #menu h5 {
	color : <?php echo $settings->ms_text1_color_normal;?>
}
<?php } ?>
<?php if(isset($settings->ms_text1_color_hover)){?>
#page .ms_text1_color:hover,
#page #menu ul li .out_cat_parent a.ms_text1_color_normal:hover,
#menu > ul > li div a:hover, 
#menu > ul li.menu_item > div a:hover, 
#menu ul li .product_item a:hover
{
	color : <?php echo $settings->ms_text1_color_hover;?>
}
<?php } ?>
<?php if(isset($settings->ms_text2_color_normal)){?>
#page .ms_text2_color,
#page #menu li ul li a,
#page #menu > ul li.menu_item > div a {
	color : <?php echo $settings->ms_text2_color_normal;?>
}
<?php } ?>
<?php if(isset($settings->ms_text2_color_hover)){?>
#page .ms_text2_color:hover,
#page #menu li ul li a:hover,
#page #menu > ul li.menu_item > div a:hover{
	color : <?php echo $settings->ms_text2_color_hover;?>
}
<?php } ?>
/*font text custom - submenu*/
<?php if(isset($settings->m_fstyle_1) || isset($settings->m_fsize_1) || isset($settings->m_fweight_1)) {?>
#page .m_fstyle_1,
#page #menu ul li a.title_menu_parent,
#cs_megamenu_more a.more
	{	
		<?php if(isset($settings->m_fstyle_1)){?>
		font-family: "<?php echo $settings->m_fstyle_1;?>";
		<?php } ?>
		<?php if(isset($settings->m_fsize_1)){?>
		font-size: <?php echo $settings->m_fsize_1;?>px;
		<?php } ?>
		<?php if(isset($settings->m_fweight_1)){?>
		font-style: <?php echo $settings->m_fweight_1;?>;
		<?php } ?>
	}
<?php } ?>
<?php if(isset($settings->m_fstyle_2) || isset($settings->m_fsize_2) || isset($settings->m_fweight_2)) {?>
#page .m_fstyle_2,
#page #menu > ul li.menu_item > div a,
#page #menu ul li .ajax_block_product h3 a,
#menu ul li .div_static p,
#menu ul li .div_static h3,
#page #menu h5
	{	
		<?php if(isset($settings->m_fstyle_2)){?>
		font-family: "<?php echo $settings->m_fstyle_2;?>";
		<?php } ?>
		<?php if(isset($settings->m_fsize_2)){?>
		font-size: <?php echo $settings->m_fsize_2;?>px;
		<?php } ?>
		<?php if(isset($settings->m_fweight_2)){?>
		font-style: <?php echo $settings->m_fweight_2;?>;
		<?php } ?>
	}
<?php } ?>


/*slideshow*/
<?php if(isset($settings->s_b_color) || isset($settings->s_b_pattern) || isset($settings->s_b_img)) { ?>
.cs_mode_slideshow {
	<?php 
		if(isset($settings->s_b_img) && (!isset($settings->s_b_pattern) || (isset($settings->s_b_pattern) && ($settings->s_b_pattern == 'up_load_image_slideshow') && $settings->s_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/slideshow/background/<?php echo $settings->s_b_img;?>");
		<?php } else {?>
		<?php 
		if(isset($settings->s_b_pattern)) { 
			if($settings->s_b_pattern != 'no_img.jpg' && $settings->s_b_pattern != 'up_load_image_slideshow') {
		?>
		background-image: url("images/general/patterns/<?php echo $settings->s_b_pattern;?>");
		<?php } else { ?>
		background-image: none;
		<?php } } } ?>
		
		<?php if(isset($settings->s_b_repeat)) {?>
		background-repeat: <?php echo $settings->s_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;

		<?php if(isset($settings->s_b_color)) {
			if(isset($settings->s_b_img) || (isset($settings->s_b_pattern) && $settings->s_b_pattern != 'no_img.jpg')){ ?>
		background-color: <?php echo $settings->s_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->s_b_color;?>;
		<?php } ?>
		border-color: <?php echo $settings->s_b_color;?>;
		<?php } ?>
}
<?php } ?>
/* color custom - slideshow */
<?php if(isset($settings->s_bt_b_color)){?>
#page  .s_bt_b_color,
.content_slider p.price {
	background-color: <?php echo $settings->s_bt_b_color;?>; 
}
<?php } ?> 


<?php if(isset($settings->s_color_1)){?>
#page .s_color_1 {
	color:<?php echo $settings->s_color_1;?>;
}
<?php } ?>
 <?php if(isset($settings->s_color_2)){?>
#page .s_color_2,
.content_slider .block_content p {
	color:<?php echo $settings->s_color_2;?>;
}
<?php } ?>
 <?php if(isset($settings->s_color_3)){?>
#page .s_color_3 {
	color:<?php echo $settings->s_color_3;?>;
}
<?php } ?>
 
/*font text custom - slideshow*/
<?php if(isset($settings->s_fstyle_1) || isset($settings->s_fsize_1) || isset($settings->s_fweight_1)) {?>
#page .s_fstyle_1,
.content_slider .block_content h5
	{	
		<?php if(isset($settings->s_fstyle_1)){?>
		font-family: <?php echo $settings->s_fstyle_1;?>;
		<?php } ?>
		<?php if(isset($settings->s_fsize_1)){?>
		font-size: <?php echo $settings->s_fsize_1;?>px;
		<?php } ?>
		<?php if(isset($settings->s_fweight_1)){?>
		font-style: <?php echo $settings->s_fweight_1;?>;
		<?php } ?>
	}
<?php } ?>

<?php if(isset($settings->s_fstyle_2) || isset($settings->s_fsize_2) || isset($settings->s_fweight_2)) {?>
#page .s_fstyle_2,
.content_slider .block_content p
	{	
		<?php if(isset($settings->s_fstyle_2)){?>
		font-family: <?php echo $settings->s_fstyle_2;?>;
		<?php } ?>
		<?php if(isset($settings->s_fsize_2)){?>
		font-size: <?php echo $settings->s_fsize_2;?>px;
		<?php } ?>
		<?php if(isset($settings->s_fweight_2)){?>
		font-style: <?php echo $settings->s_fweight_2;?>;
		<?php } ?>
	}
<?php } ?>


/*Product*/
/*Name product*/
<?php if(isset($settings->p_name_color) || isset($settings->p_fstyle_name) || isset($settings->p_fsize_name) || isset($settings->p_fweight_name)){?>

#page .name_product h3 a,
#page .product_name a,
#page h3 a,
#page h3.s_title_block a,
#best-sellers_block_right li h3 a,
#cart_block #cart_block_list dt a,
#special_block_right li h3 a,
#viewed-products_block_left h3 a,
#page #menu ul li .ajax_block_product h3 a,
#page .block.products_block li h3 a,
#productscategory_list li p.product_name a,
.accessories_block ul#product_list .name_product a,
.ambiance h3 a
	{
		<?php if(isset($settings->p_name_color)) {?>
		color:<?php echo $settings->p_name_color;?>;
		<?php } ?>
		<?php if(isset($settings->p_fstyle_name)) {?>
		font-family: "<?php echo $settings->p_fstyle_name;?>";
		<?php } ?>
		<?php if(isset($settings->p_fsize_name)) {?>
		font-size: <?php echo $settings->p_fsize_name;?>px;
		<?php } ?>
		<?php if(isset($settings->p_fweight_name)) {?>
		font-style: <?php echo $settings->p_fweight_name;?>;
		<?php } ?>
	}
<?php } ?>
/*Description product*/
<?php if(isset($settings->p_des_color) || isset($settings->p_fstyle_description) || isset($settings->p_fsize_description) || isset($settings->p_fweight_description)){?>
#page .product_desc,
.homecategoryfeature .product_desc {
	<?php if(isset($settings->p_des_color)) {?>
		color:<?php echo $settings->p_des_color;?>;
		<?php } ?>
		<?php if(isset($settings->p_fstyle_description)) {?>
		font-family: "<?php echo $settings->p_fstyle_description;?>";
		<?php } ?>
		<?php if(isset($settings->p_fsize_description)) {?>
		font-size: <?php echo $settings->p_fsize_description;?>px;
		<?php } ?>
		<?php if(isset($settings->p_fweight_description)) {?>
		font-style: <?php echo $settings->p_fweight_description;?>;
		<?php } ?>
}
<?php } ?>
/*Price*/
<?php if(isset($settings->p_price_color)) { ?>
#page .price,
#page .our_price_display,
#page #cart_block #cart_block_total.price,
#cart_block #cart_block_shipping_cost,
table#cart_summary td.cart_total .price
{
	color:<?php echo $settings->p_price_color;?>;
}
<?php } ?>
<?php if(isset($settings->p_spec_price_color)) { ?>
#page .price-discount {
	color:<?php echo $settings->p_spec_price_color;?>;
}
<?php } ?>

<?php if(isset($settings->p_fstyle_price) || isset($settings->p_fsize_price) || isset($settings->p_fweight_price)){?>
#page .price,
#page .price-discount,
#page .our_price_display,
.homecategoryfeature li .price{
	<?php if(isset($settings->p_fstyle_price)) {?>
	font-family: "<?php echo $settings->p_fstyle_price;?>";
	<?php } ?>
	<?php if(isset($settings->p_fsize_price)) {?>
	font-size: <?php echo $settings->p_fsize_price;?>px;
	<?php } ?>
	<?php if(isset($settings->p_fweight_price)) {?>
	font-style: <?php echo $settings->p_fweight_price;?>;
	<?php } ?>
}
<?php } ?>


/*  Button -- add to cart */
<?php if(isset($settings->bt_b_color_normal) || isset($settings->bt_b_pattern) || isset($settings->bt_b_img)){?>
input.button_mini, input.button_small, input.button, input.button_large, input.button_mini_disabled, input.button_small_disabled, input.button_disabled, input.button_large_disabled, input.exclusive_mini, input.exclusive_small, input.exclusive, input.exclusive_large, input.exclusive_mini_disabled, input.exclusive_small_disabled, input.exclusive_disabled, input.exclusive_large_disabled, a.button_mini, a.button_small, a.button, a.button_large, a.exclusive_mini, a.exclusive_small, a.exclusive, a.exclusive_large, span.button_mini, span.button_small, span.button, span.button_large, span.exclusive_mini, span.exclusive_small, span.exclusive, span.exclusive_large, span.exclusive_large_disabled,
#product_list li a.button, #pb-left-column #buy_block input.exclusive,
.cart_navigation .button, .cart_navigation .button_large,
#cart_block #cart-buttons .button_small,
.ajax_add_to_cart_button.exclusive,
.cart_voucher .submit input.button,
#authentication #login_form .submit input,
#authentication #account-creation_form p.cart_navigation.submit input#submitAccount
{
		<?php 
		if(isset($settings->bt_b_img) && (!isset($settings->bt_b_pattern) || (isset($settings->bt_b_pattern) && ($settings->bt_b_pattern == 'up_load_image_button') && $settings->bt_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/button/background/<?php echo $settings->bt_b_img;?>");
		border:none!important;
		<?php } else { ?>
		<?php if(isset($settings->bt_b_pattern)) { 
		if($settings->bt_b_pattern != 'no_img.jpg' && $settings->bt_b_pattern != 'up_load_image_button') {?>
				background-image: url("images/general/patterns/<?php echo $settings->bt_b_pattern;?>");
		<?php } else { ?>
				background-image: none;
				border:none!important;
		<?php } } } ?>
		
		<?php if(isset($settings->bt_b_repeat)) {?>
		background-repeat: <?php echo $settings->bt_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;
		
		<?php if(isset($settings->bt_b_color_normal)) {
			if(isset($settings->bt_b_img) || (isset($settings->bt_b_pattern) && $settings->bt_b_pattern != 'no_img.jpg') ){ ?>
		background-color: <?php echo $settings->bt_b_color_normal; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->bt_b_color_normal;?>;
		<?php } ?>
		border:none!important;
		<?php } ?>
		
}
<?php } ?>


#product_list li a.button:hover,
input.button_mini:hover, input.button_small:hover, input.button:hover, input.button_large:hover, input.button_mini_disabled:hover, input.button_small_disabled:hover, input.button_disabled:hover, input.button_large_disabled:hover, input.exclusive_mini:hover, input.exclusive_small:hover, input.exclusive:hover, input.exclusive_large:hover, input.exclusive_mini_disabled:hover, input.exclusive_small_disabled:hover, input.exclusive_disabled:hover, input.exclusive_large_disabled:hover, a.button_mini:hover, a.button_small:hover, a.button:hover, a.button_large:hover, a.exclusive_mini:hover, a.exclusive_small:hover, a.exclusive:hover, a.exclusive_large:hover, span.button_mini:hover, span.button_small:hover, span.button:hover, span.button_large:hover, span.exclusive_mini:hover, span.exclusive_small:hover, span.exclusive:hover, span.exclusive_large:hover, span.exclusive_large_disabled:hover, #product_list li a.button:hover, #pb-left-column #buy_block input.exclusive:hover, .cart_navigation .button:hover, .cart_navigation .button_large:hover,
#cart_block #cart-buttons .button_small:hover,
.cart_voucher .submit input.button:hover,
#authentication #login_form .submit input:hover,
#authentication #account-creation_form p.cart_navigation.submit input#submitAccount:hover
{
	<?php if(isset($settings->bt_b_color_hover)){?>
	background: <?php echo $settings->bt_b_color_hover;?>;
	border-left-color: <?php echo $settings->bt_b_color_hover;?>;
	border-right-color: <?php echo $settings->bt_b_color_hover;?>;
	#border-top-color: <?php echo $settings->bt_b_color_hover;?>;
	#border-bottom-color: <?php echo $settings->bt_b_color_hover;?>;
	<?php } ?>
}



<?php if(isset($settings->bt_text_color_normal)){?>
#product_list li a.button,#pb-left-column #buy_block input.exclusive,
#page .exclusive,
#page .button_mini,
#page .button,
#page .button_large,
#page .button_small,
#page .exclusive_large,
.cart_navigation .button, .cart_navigation .button_large,
#cart_block #cart-buttons .button_small,
#authentication #login_form .submit input,
#authentication #create-account_form p.submit input,
div.addresses #address_invoice_form a.button_large, 
div.addresses .address_add a.button_large
{
	color: <?php echo $settings->bt_text_color_normal;?>;
}
<?php } ?>

<?php if(isset($settings->bt_fstyle_text) || isset($settings->bt_fsize_text) || isset($settings->bt_fweight_text)){?>
#product_list li a.button,#pb-left-column #buy_block input.exclusive,
#page .exclusive,
#page .button_mini,
#page .button,
#page .button_large,
#page .button_small,
#page .exclusive_large,
.cart_navigation .button, .cart_navigation .button_large,
#cart_block #cart-buttons .button_small
{
	<?php if(isset($settings->bt_fstyle_text)){?>
	font-family:"<?php echo $settings->bt_fstyle_text;?>";
	<?php } ?>
	<?php if(isset($settings->bt_fsize_text)){?>
	font-size:<?php echo $settings->bt_fsize_text;?>px;
	<?php } ?>
	<?php if(isset($settings->bt_fweight_text)){?>
	font-style:<?php echo $settings->bt_fweight_text;?>;
	<?php } ?>	
}
<?php } ?>

/*Button 2*/
<?php if(isset($settings->bt2_b_color_normal) || isset($settings->bt2_b_pattern) || isset($settings->bt2_b_img)){?>
.cart_navigation .button, .cart_navigation .button_large,
#left_column input.button_mini, #left_column input.button_small, #left_column input.button, #left_column input.button_large, #left_column input.button_mini_disabled, #left_column input.button_small_disabled, #left_column input.button_disabled, #left_column input.button_large_disabled, #left_column input.exclusive_mini, #left_column input.exclusive_small, #left_column input.exclusive, #left_column input.exclusive_large, #left_column input.exclusive_mini_disabled, #left_column input.exclusive_small_disabled, #left_column input.exclusive_disabled, #left_column input.exclusive_large_disabled, #left_column a.button_mini, #left_column a.button_small, #left_column a.button, #left_column a.button_large, #left_column a.exclusive_mini, #left_column a.exclusive_small, #left_column a.exclusive, #left_column a.exclusive_large, #left_column span.button_mini, #left_column span.button_small, #left_column span.button, #left_column span.button_large, #left_column span.exclusive_mini, #left_column span.exclusive_small, #left_column span.exclusive, #left_column span.exclusive_large, #left_column span.exclusive_large_disabled, #right_column input.button_mini, #right_column input.button_small, #right_column input.button, #right_column input.button_large, #right_column input.button_mini_disabled, #right_column input.button_small_disabled, #right_column input.button_disabled, #right_column input.button_large_disabled, #right_column input.exclusive_mini, #right_column input.exclusive_small, #right_column input.exclusive, #right_column input.exclusive_large, #right_column input.exclusive_mini_disabled, #right_column input.exclusive_small_disabled, #right_column input.exclusive_disabled, #right_column input.exclusive_large_disabled, #right_column a.button_mini, #right_column a.button_small, #right_column a.button, #right_column a.button_large, #right_column a.exclusive_mini, #right_column a.exclusive_small, #right_column a.exclusive, #right_column a.exclusive_large, #right_column span.button_mini, #right_column span.button_small, #right_column span.button, #right_column span.button_large, #right_column span.exclusive_mini, #right_column span.exclusive_small, #right_column span.exclusive, #right_column span.exclusive_large, #right_column span.exclusive_large_disabled,
#cart_block #cart-buttons #button_order_cart,
p.cart_navigation.submit a.button,
#authentication #create-account_form p.submit input,
div.addresses #address_invoice_form a.button_large, div.addresses .address_add a.button_large
{
		<?php 
		if(isset($settings->bt2_b_img) && (!isset($settings->bt2_b_pattern) || (isset($settings->bt2_b_pattern) && ($settings->bt2_b_pattern == 'up_load_image_button2') && $settings->bt2_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/button2/background/<?php echo $settings->bt2_b_img;?>");
		border:none!important;
		<?php } else { ?>
		<?php if(isset($settings->bt2_b_pattern)) { 
		if($settings->bt2_b_pattern != 'no_img.jpg' && $settings->bt2_b_pattern != 'up_load_image_button2') {?>
				background-image: url("images/general/patterns/<?php echo $settings->bt2_b_pattern;?>");
		<?php } else { ?>
				background-image: none;
				border:none!important;
		<?php } } } ?>
		
		<?php if(isset($settings->bt2_b_repeat)) {?>
		background-repeat: <?php echo $settings->bt2_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		background-position:0 0;
		
		<?php if(isset($settings->bt2_b_color_normal)) {
			if(isset($settings->bt2_b_img) || (isset($settings->bt2_b_pattern) && $settings->bt2_b_pattern != 'no_img.jpg') ){ ?>
		background-color: <?php echo $settings->bt2_b_color_normal; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->bt2_b_color_normal;?>;
		<?php } ?>
		border:none!important;
		<?php } ?>
		
}
<?php } ?>

<?php if(isset($settings->bt2_b_color_hover)){?>
#page .bt2_b_color_hover,
#left_column input.button_mini:hover, #left_column input.button_small:hover, #left_column input.button:hover, #left_column input.button_large:hover, #left_column input.button_mini_disabled:hover, #left_column input.button_small_disabled:hover, #left_column input.button_disabled:hover, #left_column input.button_large_disabled:hover, #left_column input.exclusive_mini:hover, #left_column input.exclusive_small:hover, #left_column input.exclusive:hover, #left_column input.exclusive_large:hover, #left_column input.exclusive_mini_disabled:hover, #left_column input.exclusive_small_disabled:hover, #left_column input.exclusive_disabled:hover, #left_column input.exclusive_large_disabled:hover, #left_column a.button_mini:hover, #left_column a.button_small:hover, #left_column a.button:hover, #left_column a.button_large:hover, #left_column a.exclusive_mini:hover, #left_column a.exclusive_small:hover, #left_column a.exclusive:hover, #left_column a.exclusive_large:hover, #left_column span.button_mini:hover, #left_column span.button_small:hover, #left_column span.button:hover, #left_column span.button_large:hover, #left_column span.exclusive_mini:hover, #left_column span.exclusive_small:hover, #left_column span.exclusive:hover, #left_column span.exclusive_large:hover, #left_column span.exclusive_large_disabled:hover, #right_column input.button_mini:hover, #right_column input.button_small:hover, #right_column input.button:hover, #right_column input.button_large:hover, #right_column input.button_mini_disabled:hover, #right_column input.button_small_disabled:hover, #right_column input.button_disabled:hover, #right_column input.button_large_disabled:hover, #right_column input.exclusive_mini:hover, #right_column input.exclusive_small:hover, #right_column input.exclusive:hover, #right_column input.exclusive_large:hover, #right_column input.exclusive_mini_disabled:hover, #right_column input.exclusive_small_disabled:hover, #right_column input.exclusive_disabled:hover, #right_column input.exclusive_large_disabled:hover, #right_column a.button_mini:hover, #right_column a.button_small:hover, #right_column a.button:hover, #right_column a.button_large:hover, #right_column a.exclusive_mini:hover, #right_column a.exclusive_small:hover, #right_column a.exclusive:hover, #right_column a.exclusive_large:hover, #right_column span.button_mini:hover, #right_column span.button_small:hover, #right_column span.button:hover, #right_column span.button_large:hover, #right_column span.exclusive_mini:hover, #right_column span.exclusive_small:hover, #right_column span.exclusive:hover, #right_column span.exclusive_large:hover, #right_column span.exclusive_large_disabled:hover,
#cart_block #cart-buttons #button_order_cart:hover,
.cart_navigation .button:hover, .cart_navigation .button_large:hover,
p.cart_navigation.submit a.button:hover,
#authentication #create-account_form p.submit input:hover,
div.addresses #address_invoice_form a.button_large:hover, div.addresses .address_add a.button_large:hover
{
	<?php if(isset($settings->bt_b_color_hover)){?>
	background: <?php echo $settings->bt2_b_color_hover;?>;
	border-left-color: <?php echo $settings->bt2_b_color_hover;?>;
	border-right-color: <?php echo $settings->bt2_b_color_hover;?>;
	#border-top-color: <?php echo $settings->bt2_b_color_hover;?>;
	#border-bottom-color: <?php echo $settings->bt2_b_color_hover;?>;
	<?php } ?>
	
}
<?php }?>

/*Title*/
/*Tilte page*/
<?php if(isset($settings->t_p_color) || isset($settings->t_fstyle_page) || isset($settings->t_fsize_page) || isset($settings->t_fweight_page)){?>
#page #center_column h1
{
	<?php if(isset($settings->t_p_color)){?>
	color:<?php echo $settings->t_p_color;?>;
	<?php } ?>
	<?php if(isset($settings->t_fstyle_page)){?>
	font-family: <?php echo $settings->t_fstyle_page;?>;
	<?php } ?>
	<?php if(isset($settings->t_fsize_page)){?>
	font-size: <?php echo $settings->t_fsize_page;?>px;
	<?php } ?>
	<?php if(isset($settings->t_fweight_page)){?>
	font-style: <?php echo $settings->t_fweight_page;?>;
	<?php } ?>
}
<?php } ?>

/*title block*/
<?php if(isset($settings->t_t_color)){?>
#page .block .title_block,
	#page .block h4,
	#page .block .title_block a,
	#page .block h4 a,
	.cs_sample_block_footer .col p.Read_more a,
	form.std h3,
	.cart_last_product_header .left,	
	li.address_title,
	.view_more_link a,
	#cs_home_center_bottom_left  .ul_cat_popular li.view-all a,
	#category h1,
	h2.productscategory_h2 ,
	#cs_home_center_bottom_left .ul_cat_popular li.cat_group h3 a,
	#cs_home_center_bottom h4,.static_block_chat_with span,
#favoriteproducts_block_account  h2	{
		color: <?php echo $settings->t_t_color;?>;
	}
<?php }?>

<?php if(isset($settings->t_b_color) || isset($settings->t_b_pattern) || isset($settings->t_b_img)){?>
#page .block .title_block,
#cs_home_center_bottom h4,
#page .block h4,
.ui-tabs .ui-tabs-nav, .title_tab,
ul#order_step,
form.std h3,
.cart_last_product_header .left,
li.address_title,
.idTabs,
h2.productscategory_h2
{
		<?php 
		if(isset($settings->t_b_img) && (!isset($settings->t_b_pattern) || (isset($settings->t_b_pattern) && ($settings->t_b_pattern == 'up_load_image_blocktitle') && $settings->t_b_pattern != 'no_img.jpg')) ) { ?>
		background-image: url("images/blocktitle/background/<?php echo $settings->t_b_img;?>");
		<?php } else { ?>
		<?php if(isset($settings->t_b_pattern)) { 
		if($settings->t_b_pattern != 'no_img.jpg' && $settings->t_b_pattern != 'up_load_image_blocktitle') {?>
				background-image: url("images/general/patterns/<?php echo $settings->t_b_pattern;?>");
		<?php } else { ?>
				background-image: none;
				border:none!important;
		<?php } } } ?>
		
		<?php if(isset($settings->t_b_repeat)) {?>
		background-repeat: <?php echo $settings->t_b_repeat;?>;
		<?php } else { ?>
		background-repeat:repeat;
		<?php } ?>
		
		<?php if(isset($settings->t_b_color)) {
			if(isset($settings->t_b_img) || (isset($settings->t_b_pattern) && $settings->t_b_pattern != 'no_img.jpg') ){ ?>
		background-color: <?php echo $settings->t_b_color; ?>;
		border:none;
		<?php } else { ?>
		background: <?php echo $settings->t_b_color;?>;
		<?php } } ?>
}
<?php } ?>
<?php if(isset($settings->t_fstyle_block) || isset($settings->t_fsize_block) || isset($settings->t_fweight_block)){?>
#page .block .title_block,
#page .block h4,
#page .block .title_block a,
#page .block h4 a,
li.address_title,
h2.productscategory_h2,
#favoriteproducts_block_account  h2
{
	<?php if(isset($settings->t_fstyle_block)){?>
	font-family: <?php echo $settings->t_fstyle_block;?>;
	<?php } ?>
	<?php if(isset($settings->t_fsize_block)){?>
	font-size: <?php echo $settings->t_fsize_block;?>px;
	<?php } ?>
	<?php if(isset($settings->t_fweight_block)){?>
	font-style: <?php echo $settings->t_fweight_block;?>;
	<?php } ?>
}
<?php } ?>

/*breadcrumb*/
<?php if(isset($settings->t_f_bre_color)) { ?>
#page .breadcrumb a {
	color:<?php echo $settings->t_f_bre_color;?>;
}
<?php } ?>
<?php if(isset($settings->t_s_bre_color)) { ?>
#page .breadcrumb span,#page .breadcrumb {
	color:<?php echo $settings->t_s_bre_color;?>;
}
<?php } ?>

<?php if(isset($settings->t_fstyle_breadcrumb) || isset($settings->t_fsize_breadcrumb) || isset($settings->t_fweight_breadcrumb)){?>
#page .breadcrumb a,
#page .breadcrumb span,
#page .breadcrumb {
	<?php if(isset($settings->t_fstyle_breadcrumb)){?>
	font-family: <?php echo $settings->t_fstyle_breadcrumb;?>;
	<?php } ?>
	<?php if(isset($settings->t_fsize_breadcrumb)){?>
	font-size: <?php echo $settings->t_fsize_breadcrumb;?>px;
	<?php } ?>
	<?php if(isset($settings->t_fweight_breadcrumb)){?>
	font-style: <?php echo $settings->t_fweight_breadcrumb;?>;
	<?php } ?>
}
<?php } ?>





