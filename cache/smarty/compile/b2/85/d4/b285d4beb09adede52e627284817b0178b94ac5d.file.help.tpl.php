<?php /* Smarty version Smarty-3.1.13, created on 2013-09-16 10:06:49
         compiled from "C:\wamp\www\fp-v1\modules\opartajaxpopup\views\templates\admin\help.tpl" */ ?>
<?php /*%%SmartyHeaderCode:286385236bc194ea468-01325398%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b285d4beb09adede52e627284817b0178b94ac5d' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\opartajaxpopup\\views\\templates\\admin\\help.tpl',
      1 => 1374594741,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '286385236bc194ea468-01325398',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5236bc19564044_91141236',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5236bc19564044_91141236')) {function content_5236bc19564044_91141236($_smarty_tpl) {?><fieldset>
	<legend><?php echo smartyTranslate(array('s'=>'Help','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</legend>
	<h3><?php echo smartyTranslate(array('s'=>'How can i display CMS page content','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</h3>
	<?php echo smartyTranslate(array('s'=>'Copy this example where you want then edit it with your values','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
:<br />
	<div style="padding: 10px; margin: 10px; border: 1px solid #CCCED7; background: #FFF;">
		&lt;a href="#" onClick="showOpartAjaxPopup(<span style="color:red; font-weight:bold;">1</span>,<span style="color:blue; font-weight:bold;">450</span>,<span style="color:blue; font-weight:bold;">100</span>,<span style="color:green; font-weight:bold;">'cms'</span>,<span style="color:maroon; font-weight:bold;">'0'</span>); return false;"&gt;<?php echo smartyTranslate(array('s'=>'Your text','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
&lt;/a&gt;<br />
	</div>
	<span style="color:red; font-weight:bold;"><?php echo smartyTranslate(array('s'=>'1 is your CMS ID, you can find it on the cms admin list','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</span><br />
	<span style="color:blue; font-weight:bold;"><?php echo smartyTranslate(array('s'=>'450 is the width of your popup','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</span><br />
	<span style="color:blue; font-weight:bold;"><?php echo smartyTranslate(array('s'=>'100 is the height of your popup','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</span><br />
	<span style="color:green; font-weight:bold;"><?php echo smartyTranslate(array('s'=>'cms is using for specify to the script what kind of content is expected','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</span><br />
	<span style="color:maroon; font-weight:bold;"><?php echo smartyTranslate(array('s'=>'0 is using for specify if your popup will be responsive or not (0=no, 1=yes)','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</span><br />
</fieldset>
<br />
<fieldset>
	<legend><?php echo smartyTranslate(array('s'=>'Find more help on the readme file (in french)','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</legend>
	<a style="color:red" href="../modules/opartajaxpopup/readme_fr.pdf" target="blank"><?php echo smartyTranslate(array('s'=>'Click here to open help file','mod'=>'opartajaxpopup'),$_smarty_tpl);?>
</a>	
</fieldset>
<?php }} ?>