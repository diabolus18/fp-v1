<?php /* Smarty version Smarty-3.1.13, created on 2013-11-13 17:54:58
         compiled from "C:\wamp\www\fp-v1\modules\lofmodalcart\themes\default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:285705283aee2803652-33055086%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '674613fb030e08bfe0a96c92540dc127e0165cc6' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\lofmodalcart\\themes\\default\\header.tpl',
      1 => 1373542192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285705283aee2803652-33055086',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mcOverlayColor_1' => 0,
    'mcOverlayColor_2' => 0,
    'mcOverlayOpacity' => 0,
    'mcBorder' => 0,
    'mcBorderType' => 0,
    'mcBorderColor' => 0,
    'mcBorderRadius' => 0,
    'CUSTOMIZE_TEXTFIELD' => 0,
    'modalCartPath' => 0,
    'modalCartWidth' => 0,
    'img_ps_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5283aee28ccea7_04285062',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5283aee28ccea7_04285062')) {function content_5283aee28ccea7_04285062($_smarty_tpl) {?><style type="text/css">
  .nyroModalBg {
    background: -moz-linear-gradient(center top , <?php echo $_smarty_tpl->tpl_vars['mcOverlayColor_1']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['mcOverlayColor_2']->value;?>
) repeat scroll 0 0 transparent !important;
    opacity: <?php echo $_smarty_tpl->tpl_vars['mcOverlayOpacity']->value;?>
 !important;
  }
  .nyroModalCont {
    border: <?php echo $_smarty_tpl->tpl_vars['mcBorder']->value;?>
px <?php echo $_smarty_tpl->tpl_vars['mcBorderType']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['mcBorderColor']->value;?>
;
    border-radius: <?php echo $_smarty_tpl->tpl_vars['mcBorderRadius']->value;?>
px <?php echo $_smarty_tpl->tpl_vars['mcBorderRadius']->value;?>
px <?php echo $_smarty_tpl->tpl_vars['mcBorderRadius']->value;?>
px <?php echo $_smarty_tpl->tpl_vars['mcBorderRadius']->value;?>
px !important;
    opacity: <?php echo $_smarty_tpl->tpl_vars['mcOverlayOpacity']->value;?>
 !important;
  }
</style>
<script type="text/javascript">
//<![CDATA[
	var CUSTOMIZE_TEXTFIELD = '<?php echo $_smarty_tpl->tpl_vars['CUSTOMIZE_TEXTFIELD']->value;?>
';
	var customizationIdMessage = '<?php echo smartyTranslate(array('s'=>'Customization #','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	var removingLinkText = '<?php echo smartyTranslate(array('s'=>'remove this product from my cart','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	var modalCartPath = '<?php echo $_smarty_tpl->tpl_vars['modalCartPath']->value;?>
';
	var modalCartWidth = <?php echo $_smarty_tpl->tpl_vars['modalCartWidth']->value;?>
;
	ThickboxI18nImage = '<?php echo smartyTranslate(array('s'=>'Image','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	ThickboxI18nOf = '<?php echo smartyTranslate(array('s'=>'of','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	ThickboxI18nClose = '<?php echo smartyTranslate(array('s'=>'Close','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	ThickboxI18nOrEscKey = '<?php echo smartyTranslate(array('s'=>'or Esc key','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	ThickboxI18nNext = '<?php echo smartyTranslate(array('s'=>'Next &gt;','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	ThickboxI18nPrev = '<?php echo smartyTranslate(array('s'=>'&lt; Prev','mod'=>'lofmodalcart','js'=>1),$_smarty_tpl);?>
';
	tbmc_pathToImage = '<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
loadingAnimation.gif';
//]]>
</script>
<?php }} ?>