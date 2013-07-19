<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:49:53
         compiled from "C:\wamp\www\fp-v1\admin\themes\default\template\controllers\referrers\form_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1982651d18901b98a96-23585780%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8315a1fd5578b1f63b9abbef3e31ed62135fa56' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\admin\\themes\\default\\template\\controllers\\referrers\\form_settings.tpl',
      1 => 1372670580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1982651d18901b98a96-23585780',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current' => 0,
    'token' => 0,
    'tracking_dt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18901c642a1_30152530',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18901c642a1_30152530')) {function content_51d18901c642a1_30152530($_smarty_tpl) {?>

</div>

<div>
	<fieldset>
		<legend>
			<img src="../img/admin/tab-preferences.gif" /> <?php echo smartyTranslate(array('s'=>'Settings'),$_smarty_tpl);?>

		</legend>
		<form action="<?php echo $_smarty_tpl->tpl_vars['current']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" method="post" id="settings_form" name="settings_form">
			<label><?php echo smartyTranslate(array('s'=>'Save direct traffic?'),$_smarty_tpl);?>
</label>
			<div class="margin-left">
				<label class="t" for="tracking_dt_on"><img src="../img/admin/enabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
" /></label>
				<input type="radio" name="tracking_dt" id="tracking_dt_on" value="1" <?php if ($_smarty_tpl->tpl_vars['tracking_dt']->value){?>checked="checked"<?php }?> />
				<label class="t" for="tracking_dt_on"> <?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</label>
				<label class="t" for="tracking_dt_off"><img src="../img/admin/disabled.gif" alt="<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
" style="margin-left: 10px;" /></label>
				<input type="radio" name="tracking_dt" id="tracking_dt_off" value="0" <?php if (!$_smarty_tpl->tpl_vars['tracking_dt']->value){?>checked="checked"<?php }?>/>
				<label class="t" for="tracking_dt_off"> <?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</label>
			</div>
			<p><?php echo smartyTranslate(array('s'=>'Direct traffic can be quite resource-intensive. You should consider enabling it only if you have a strong need for it.'),$_smarty_tpl);?>
</p>
			<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'   Save   '),$_smarty_tpl);?>
" name="submitSettings" id="submitSettings" />
		</form>
		<div class="separation"></div>
		<form action="<?php echo $_smarty_tpl->tpl_vars['current']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" method="post" id="refresh_index_form" name="refresh_index_form">
			<h3><?php echo smartyTranslate(array('s'=>'Indexation'),$_smarty_tpl);?>
</h3>
			<p><?php echo smartyTranslate(array('s'=>'There is a huge quantity of data, so each connection corresponding to a referrer is indexed. You can also refresh this index by clicking the button above. This process may take awhile, and it\'s only needed if you modified or added a referrer, or if you want changes to be retroactive.'),$_smarty_tpl);?>
</p>
			<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'Refresh index'),$_smarty_tpl);?>
" name="submitRefreshIndex" id="submitRefreshIndex" />
		</form>
				<div class="separation"></div>
		<form action="<?php echo $_smarty_tpl->tpl_vars['current']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" method="post" id="refresh_cache_form" name="refresh_cache_form">
			<h3><?php echo smartyTranslate(array('s'=>'Cache'),$_smarty_tpl);?>
</h3>
			<p><?php echo smartyTranslate(array('s'=>'In order to sort and filter your data, it\'s cached. You can refresh the cache by clicking on the button above.'),$_smarty_tpl);?>
</p>
			<input type="submit" class="button" value="<?php echo smartyTranslate(array('s'=>'Refresh cache'),$_smarty_tpl);?>
" name="submitRefreshCache" id="submitRefreshCache" />
		</form>
	</fieldset>
</div>

<div class="clear">&nbsp;</div>

	<?php }} ?>