<?php /* Smarty version Smarty-3.1.13, created on 2013-07-26 18:09:13
         compiled from "C:\wamp\www\fp-v1\modules\csthemeeditor\csthemeeditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1607851f29f290aac01-28713880%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d767b7160363495c5b74855ac1402da2825fe1c' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csthemeeditor\\csthemeeditor.tpl',
      1 => 1374235261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1607851f29f290aac01-28713880',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'patterns' => 0,
    'pattern' => 0,
    'id_pattern' => 0,
    'path' => 0,
    'color_templates' => 0,
    'color_template' => 0,
    'column_lists' => 0,
    'name_column' => 0,
    'value_column' => 0,
    'class_column' => 0,
    'temp_class' => 0,
    'pot_cut' => 0,
    'number' => 0,
    'colors' => 0,
    'color' => 0,
    'elem_color' => 0,
    'fonts' => 0,
    'font' => 0,
    'elem_font' => 0,
    'font_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51f29f2922a2a5_96694199',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f29f2922a2a5_96694199')) {function content_51f29f2922a2a5_96694199($_smarty_tpl) {?>
<script type="text/javascript">
if(!isMobile())
{
	jQuery(document).ready(function($) {
		<?php  $_smarty_tpl->tpl_vars['pattern'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pattern']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['patterns']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pattern']->key => $_smarty_tpl->tpl_vars['pattern']->value){
$_smarty_tpl->tpl_vars['pattern']->_loop = true;
?>
			<?php $_smarty_tpl->tpl_vars['id_pattern'] = new Smarty_variable(explode(".",$_smarty_tpl->tpl_vars['pattern']->value), null, 0);?>
			$("#b_<?php echo $_smarty_tpl->tpl_vars['id_pattern']->value[0];?>
").click(function() {
				$(".pattern_item").removeClass("active");
				$(this).addClass("active");
				var url_pattern = "<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
/images/general/patterns/<?php echo $_smarty_tpl->tpl_vars['pattern']->value;?>
";
				$.cookie('cookie_bg_pattern',url_pattern);
				$.cookie('cookie_bg_pattern_class','<?php echo $_smarty_tpl->tpl_vars['id_pattern']->value[0];?>
');
				$('#page').css('background-image', 'url("' + $.cookie('cookie_bg_pattern') + '")');	
				$('#page').css('background-repeat', 'repeat');
			});
			if($.cookie('cookie_bg_pattern_class'))
			{
				$("#" + $.cookie('cookie_bg_pattern_class') + "").addClass("active");
			}
		<?php } ?>
	});
}
</script>
<div class="cpanelContainer">
	<div class="cpanel_content_container cpanel_closed">
		<span class="theme_sett_heading"><?php echo smartyTranslate(array('s'=>'Theme settings','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</span>
		<div class="cpanel_icon">
			<span>icon</span>
		</div>
		<div class="out_improved">
		<ul id="improved">
			<li>
				<a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Template color','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
				<div class="content" style="display: none;">
					<div class="row">
					<?php  $_smarty_tpl->tpl_vars['color_template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color_template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['color_templates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color_template']->key => $_smarty_tpl->tpl_vars['color_template']->value){
$_smarty_tpl->tpl_vars['color_template']->_loop = true;
?>
						<p><input type="radio" name="color_template" value="<?php echo $_smarty_tpl->tpl_vars['color_template']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['color_template']->value;?>
</p>
					<?php } ?>
					</div>
				</div>
			</li>
			<li>
				<a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Product grid view','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
				<div class="content" style="display: none;">
					<select name="setting_column" onchange="changeOptionColumn($(this).val())">
						<?php  $_smarty_tpl->tpl_vars['value_column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value_column']->_loop = false;
 $_smarty_tpl->tpl_vars['name_column'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['column_lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value_column']->key => $_smarty_tpl->tpl_vars['value_column']->value){
$_smarty_tpl->tpl_vars['value_column']->_loop = true;
 $_smarty_tpl->tpl_vars['name_column']->value = $_smarty_tpl->tpl_vars['value_column']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['name_column']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name_column']->value;?>
</option>
						<?php } ?>
					</select>
					<div class="option_columns">
						<?php  $_smarty_tpl->tpl_vars['value_column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value_column']->_loop = false;
 $_smarty_tpl->tpl_vars['name_column'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['column_lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value_column']->key => $_smarty_tpl->tpl_vars['value_column']->value){
$_smarty_tpl->tpl_vars['value_column']->_loop = true;
 $_smarty_tpl->tpl_vars['name_column']->value = $_smarty_tpl->tpl_vars['value_column']->key;
?>
						<div class="<?php echo $_smarty_tpl->tpl_vars['name_column']->value;?>
 row" style="display:none">
							<?php  $_smarty_tpl->tpl_vars['class_column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['class_column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value_column']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['class_column']->key => $_smarty_tpl->tpl_vars['class_column']->value){
$_smarty_tpl->tpl_vars['class_column']->_loop = true;
?>
							<?php $_smarty_tpl->tpl_vars['temp_class'] = new Smarty_variable(explode("(",$_smarty_tpl->tpl_vars['class_column']->value), null, 0);?> 
							<?php $_smarty_tpl->tpl_vars["pot_cut"] = new Smarty_variable(strpos($_smarty_tpl->tpl_vars['temp_class']->value[1],")"), null, 0);?>
							<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['temp_class']->value[1],0,$_smarty_tpl->tpl_vars['pot_cut']->value), null, 0);?>
							
								<p><input type="radio" name="radio_setting_column" value="<?php echo $_smarty_tpl->tpl_vars['class_column']->value;?>
"/> <?php echo $_smarty_tpl->tpl_vars['class_column']->value;?>
</p>
								<span class="explain" style="margin-left:19px"><?php echo $_smarty_tpl->tpl_vars['number']->value;?>
<?php echo smartyTranslate(array('s'=>' products in a row','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</span>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</li>
			<li><a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Mode CSS','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
			<div class="content" style="display: none;">
				<input type="radio" name="mode_css" value="box"/> <?php echo smartyTranslate(array('s'=>'Box','mod'=>'csthemeeditor'),$_smarty_tpl);?>

				<input type="radio" name="mode_css" value="wide"/><?php echo smartyTranslate(array('s'=>'Wide','mod'=>'csthemeeditor'),$_smarty_tpl);?>
 
			</div>
			</li>
			<li>
				<a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Background image','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
				<div class="content" style="display: none;">
					<?php  $_smarty_tpl->tpl_vars['pattern'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pattern']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['patterns']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pattern']->key => $_smarty_tpl->tpl_vars['pattern']->value){
$_smarty_tpl->tpl_vars['pattern']->_loop = true;
?>
						<?php $_smarty_tpl->tpl_vars['id_pattern'] = new Smarty_variable(explode(".",$_smarty_tpl->tpl_vars['pattern']->value), null, 0);?>
						<div class="pattern_item" id="b_<?php echo $_smarty_tpl->tpl_vars['id_pattern']->value[0];?>
" style="background:url(<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
/images/general/patterns/<?php echo $_smarty_tpl->tpl_vars['pattern']->value;?>
)"></div>
					<?php } ?>
				</div>
			</li>
			<li>
				<a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Color','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
				<div class="content">
				<?php  $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color']->_loop = false;
 $_smarty_tpl->tpl_vars['elem_color'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['colors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color']->key => $_smarty_tpl->tpl_vars['color']->value){
$_smarty_tpl->tpl_vars['color']->_loop = true;
 $_smarty_tpl->tpl_vars['elem_color']->value = $_smarty_tpl->tpl_vars['color']->key;
?>
					<div class="color_item">
					<h4><?php echo $_smarty_tpl->tpl_vars['color']->value[0];?>
</h4>
					<div id="<?php echo $_smarty_tpl->tpl_vars['elem_color']->value;?>
" class="bg_color_setting" style="cursor:pointer">text</div>
					<div class="explain"><?php echo $_smarty_tpl->tpl_vars['color']->value[1];?>
</div>
					</div>
				<?php } ?>
				</div>
			</li>
			<li>
				<a href="#" class="head"><?php echo smartyTranslate(array('s'=>'Font','mod'=>'csthemeeditor'),$_smarty_tpl);?>
</a>
				<div class="content">
					<?php  $_smarty_tpl->tpl_vars['font'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['font']->_loop = false;
 $_smarty_tpl->tpl_vars['elem_font'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fonts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['font']->key => $_smarty_tpl->tpl_vars['font']->value){
$_smarty_tpl->tpl_vars['font']->_loop = true;
 $_smarty_tpl->tpl_vars['elem_font']->value = $_smarty_tpl->tpl_vars['font']->key;
?>
					<div class="font_item">
					<h4><?php echo $_smarty_tpl->tpl_vars['font']->value[0];?>
</h4>
					<select name="<?php echo $_smarty_tpl->tpl_vars['elem_font']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['elem_font']->value;?>
" onchange="showResultChooseFont('<?php echo $_smarty_tpl->tpl_vars['elem_font']->value;?>
','result_<?php echo $_smarty_tpl->tpl_vars['elem_font']->value;?>
')">
					<?php echo $_smarty_tpl->tpl_vars['font_list']->value;?>

					</select>
					<span id="result_<?php echo $_smarty_tpl->tpl_vars['elem_font']->value;?>
"></span>
					<div class="explain"><?php echo $_smarty_tpl->tpl_vars['font']->value[1];?>
</div>
					</div>
				<?php } ?>
				</div>
			</li>
		</ul>
		<input type="button" id="cs_reset_setting" value="<?php echo smartyTranslate(array('s'=>'Reset','mod'=>'csthemeeditor'),$_smarty_tpl);?>
" />
		</div>
	</div>
</div>
<?php }} ?>