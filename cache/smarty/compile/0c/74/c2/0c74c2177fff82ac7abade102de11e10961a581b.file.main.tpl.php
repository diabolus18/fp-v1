<?php /* Smarty version Smarty-3.1.13, created on 2013-09-26 11:10:23
         compiled from "C:\wamp\www\fp-v1\admin0057\themes\default\template\controllers\translations\helpers\view\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:132695243f9ffe462d0-59999221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c74c2177fff82ac7abade102de11e10961a581b' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\controllers\\translations\\helpers\\view\\main.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
    '8b268ed877eaccb8e3b9f1f7a55065283a239f78' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin0057\\themes\\default\\template\\helpers\\view\\view.tpl',
      1 => 1374231320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132695243f9ffe462d0-59999221',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'show_toolbar' => 0,
    'toolbar_btn' => 0,
    'toolbar_scroll' => 0,
    'title' => 0,
    'name_controller' => 0,
    'hookName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5243fa00f1aab0_32701905',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5243fa00f1aab0_32701905')) {function content_5243fa00f1aab0_32701905($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['show_toolbar']->value){?>
	<?php echo $_smarty_tpl->getSubTemplate ("toolbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('toolbar_btn'=>$_smarty_tpl->tpl_vars['toolbar_btn']->value,'toolbar_scroll'=>$_smarty_tpl->tpl_vars['toolbar_scroll']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value), 0);?>

<?php }?>

<div class="leadin"></div>


	<script type="text/javascript">
		function chooseTypeTranslation(id_lang)
		{
			getE('translation_lang').value = id_lang;
			document.getElementById('typeTranslationForm').submit();
		}

		function addThemeSelect()
		{
			var list_type_for_theme = ['front', 'modules', 'pdf', 'mails'];
			var type = $('select[name=type]').val();

			$('select[name=theme]').hide();
			for (i=0; i < list_type_for_theme.length; i++)
				if (list_type_for_theme[i] == type)
				{
					$('select[name=theme]').show();
					if (type == 'front')
						$('select[name=theme]').children('option[value=""]').attr('disabled', true)
					else
						$('select[name=theme]').children('option[value=""]').attr('disabled', false)
				}
				else
					$('select[name=theme]').val('<?php echo $_smarty_tpl->tpl_vars['theme_default']->value;?>
');
		}

		$(document).ready(function(){
			addThemeSelect();
			$('select[name=type]').change(function() {
				addThemeSelect();
			});
		});
	</script>
	
	<fieldset>
		<legend><img src="../img/admin/translation.gif" /><?php echo smartyTranslate(array('s'=>'Modify translations'),$_smarty_tpl);?>
</legend>
		<?php echo smartyTranslate(array('s'=>'Here you can modify translations for every line of code inside PrestaShop.'),$_smarty_tpl);?>
<br />
		<?php echo smartyTranslate(array('s'=>'First, select a section (such as Back Office or Installed modules), and then click the flag representing the language you want to edit.'),$_smarty_tpl);?>
<br /><br />
		<form method="get" action="index.php" id="typeTranslationForm">
			<input type="hidden" name="controller" value="AdminTranslations" />
			<input type="hidden" name="lang" id="translation_lang" value="0" />
			<select name="type" style="float:left;margin-right:10px">
				<?php  $_smarty_tpl->tpl_vars['array'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['array']->_loop = false;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['translations_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['array']->key => $_smarty_tpl->tpl_vars['array']->value){
$_smarty_tpl->tpl_vars['array']->_loop = true;
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['array']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['array']->value['name'];?>
</option>
				<?php } ?>
			</select>
			<select name="theme" style="float:left;margin-right:10px">
				<option value=""><?php echo smartyTranslate(array('s'=>'Core (no theme selected)'),$_smarty_tpl);?>
</option>
				<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value){
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value==$_smarty_tpl->tpl_vars['theme']->value->id){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
				<?php } ?>
			</select>
			<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
				<a href="javascript:chooseTypeTranslation('<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
');">
					<img src="<?php echo $_smarty_tpl->tpl_vars['theme_lang_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
" />
				</a>
			<?php } ?>
			<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />
		</form>
	</fieldset>
	
	<br /><h2><?php echo smartyTranslate(array('s'=>'Translation exchange'),$_smarty_tpl);?>
</h2>
	<form action="<?php echo $_smarty_tpl->tpl_vars['url_submit']->value;?>
" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>
				<img src="../img/admin/import.gif" /><?php echo smartyTranslate(array('s'=>'Add / Update a language'),$_smarty_tpl);?>

			</legend>
			<div id="submitAddLangContent" style="float:left;">
				<p><?php echo smartyTranslate(array('s'=>'You can add or update a language directly from the PrestaShop website here:'),$_smarty_tpl);?>
</p>
				<div class="warn">
					<?php echo smartyTranslate(array('s'=>'If you choose to update an existing language pack, all of your previous customization\'s in the theme named "Default" will be lost. This includes Front Office expressions and default email templates.'),$_smarty_tpl);?>

				</div>
				<?php if ($_smarty_tpl->tpl_vars['packs_to_update']->value||$_smarty_tpl->tpl_vars['packs_to_install']->value){?>
					<div style="font-weight:bold; float:left;"><?php echo smartyTranslate(array('s'=>'Please select the language you want to add or update:'),$_smarty_tpl);?>

						<select id="params_import_language" name="params_import_language">
							<optgroup label="<?php echo smartyTranslate(array('s'=>'Update a language'),$_smarty_tpl);?>
">
								<?php  $_smarty_tpl->tpl_vars['lang_pack'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang_pack']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['packs_to_update']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang_pack']->key => $_smarty_tpl->tpl_vars['lang_pack']->value){
$_smarty_tpl->tpl_vars['lang_pack']->_loop = true;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['iso_code'];?>
|<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['version'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['name'];?>
</option>
								<?php } ?>
							</optgroup>
							<optgroup label="<?php echo smartyTranslate(array('s'=>'Add a language'),$_smarty_tpl);?>
">		
								<?php  $_smarty_tpl->tpl_vars['lang_pack'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang_pack']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['packs_to_install']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang_pack']->key => $_smarty_tpl->tpl_vars['lang_pack']->value){
$_smarty_tpl->tpl_vars['lang_pack']->_loop = true;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['iso_code'];?>
|<?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['version'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_pack']->value['name'];?>
</option>
								<?php } ?>
							</optgroup>
						</select> &nbsp;
						<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Add or update a language'),$_smarty_tpl);?>
" name="submitAddLanguage" class="button" />
					</div>
				<?php }else{ ?>
					<br /><br /><p class="error"><?php echo smartyTranslate(array('s'=>'Cannot connect to the PrestaShop website to get the language list.'),$_smarty_tpl);?>
</p></div>
				<?php }?>
			</div>
		</fieldset>
	</form><br /><br />
	
	<form action="<?php echo $_smarty_tpl->tpl_vars['url_submit']->value;?>
" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>
				<img src="../img/admin/import.gif" /><?php echo smartyTranslate(array('s'=>'Import a language pack manually'),$_smarty_tpl);?>

			</legend>
			<div id="submitImportContent">
				<p>
					<?php echo smartyTranslate(array('s'=>'If the language file format is: isocode.gzip (e.g. us.gzip), and the language corresponding to this package does not exist, it will automatically be created.'),$_smarty_tpl);?>

					<?php echo smartyTranslate(array('s'=>'Warning: This will replace all of the existing data inside the destination language.'),$_smarty_tpl);?>

				</p>
				<p><label for="importLanguage"><?php echo smartyTranslate(array('s'=>'Language pack to import:'),$_smarty_tpl);?>
</label><input type="file" name="file" id="importLanguage"/>&nbsp;</p>
				<p>
					<label for="selectThemeForImport"><?php echo smartyTranslate(array('s'=>'Select your theme:'),$_smarty_tpl);?>
</label>
					<select name="theme[]" id="selectThemeForImport" <?php if (count($_smarty_tpl->tpl_vars['themes']->value)>1){?>multiple="multiple"<?php }?> >
						<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value){
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
 &nbsp;</option>
						<?php } ?>
					</select>
				</p>
				<p class="margin-form"><input type="submit" value="<?php echo smartyTranslate(array('s'=>'   Import   '),$_smarty_tpl);?>
" name="submitImport" class="button" /></p>
			</div>
		</fieldset>
	</form>
	<br /><br />
	
	<form action="<?php echo $_smarty_tpl->tpl_vars['url_submit']->value;?>
" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend><img src="../img/admin/export.gif" /><?php echo smartyTranslate(array('s'=>'Export a language'),$_smarty_tpl);?>
</legend>
			<p><?php echo smartyTranslate(array('s'=>'Export data from one language to a file (language pack).'),$_smarty_tpl);?>
<br />
			<?php echo smartyTranslate(array('s'=>'Choose which theme you\'d like to export your translations to. '),$_smarty_tpl);?>
<br />
			<select name="iso_code" style="margin-top:10px;">
				<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
				<?php } ?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<select name="theme" style="margin-top:10px;">
				<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value){
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value==$_smarty_tpl->tpl_vars['theme']->value->id){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
				<?php } ?>
			</select>&nbsp;&nbsp;
			<input type="submit" class="button" name="submitExport" value="<?php echo smartyTranslate(array('s'=>'Export'),$_smarty_tpl);?>
" />
		</fieldset>
	</form>
	<br /><br />
	<form action="<?php echo $_smarty_tpl->tpl_vars['url_submit']->value;?>
" method="post">
		<fieldset>
			<legend><img src="../img/admin/copy_files.gif" /><?php echo smartyTranslate(array('s'=>'Copy'),$_smarty_tpl);?>
</legend>
			<p><?php echo smartyTranslate(array('s'=>'Copies data from one language to another.'),$_smarty_tpl);?>
<br />
			<?php echo smartyTranslate(array('s'=>'Warning: This will replace all of the existing data inside the destination language.'),$_smarty_tpl);?>
<br />
			<?php echo smartyTranslate(array('s'=>'If necessary'),$_smarty_tpl);?>
, <b><a href="<?php echo $_smarty_tpl->tpl_vars['url_create_language']->value;?>
"><?php echo smartyTranslate(array('s'=>'you must first create a new language.'),$_smarty_tpl);?>
</a></b>.</p>
			<div style="float:left;">
				<p>
					<div style="width:75px; font-weight:bold; float:left;"><?php echo smartyTranslate(array('s'=>'From:'),$_smarty_tpl);?>
</div>
					<select name="fromLang">
						<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
						<?php } ?>
					</select>
					&nbsp;&nbsp;&nbsp;
					<select name="fromTheme">
						<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value){
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value==$_smarty_tpl->tpl_vars['theme']->value->id){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
						<?php } ?>
					</select> <span style="font-style: bold; color: red;">*</span>
				</p>
				<p>
					<div style="width:75px; font-weight:bold; float:left;"><?php echo smartyTranslate(array('s'=>'To:'),$_smarty_tpl);?>
</div>
					<select name="toLang">
						<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</option>
						<?php } ?>
					</select>
					&nbsp;&nbsp;&nbsp;
					<select name="toTheme">
						<?php  $_smarty_tpl->tpl_vars['theme'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['theme']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->key => $_smarty_tpl->tpl_vars['theme']->value){
$_smarty_tpl->tpl_vars['theme']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value->directory;?>
" <?php if ($_smarty_tpl->tpl_vars['id_theme_current']->value==$_smarty_tpl->tpl_vars['theme']->value->id){?>selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['theme']->value->name;?>
</option>
						<?php } ?>
					</select>
				</p>
			</div>
			<div style="float:left;">
				<input type="submit" value="<?php echo smartyTranslate(array('s'=>'   Copy   '),$_smarty_tpl);?>
" name="submitCopyLang" class="button" style="margin:25px 0px 0px 25px;" />
			</div>
			<p style="clear: left; padding: 16px 0px 0px 0px;"><span style="font-style: bold; color: red;">*</span> <?php echo smartyTranslate(array('s'=>'Language files must be complete to allow copying of translations.'),$_smarty_tpl);?>
</p>
		</fieldset>
	</form>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminView'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)){?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }elseif(isset($_GET['controller'])){?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>