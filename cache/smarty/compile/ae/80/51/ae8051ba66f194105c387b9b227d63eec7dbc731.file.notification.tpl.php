<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 16:05:03
         compiled from "C:\wamp\www\fp-v1\modules\gamification\views\templates\hook\notification.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1337151d18c8fe1b9f3-20253683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae8051ba66f194105c387b9b227d63eec7dbc731' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\gamification\\views\\templates\\hook\\notification.tpl',
      1 => 1372687248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1337151d18c8fe1b9f3-20253683',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current_id_tab' => 0,
    'current_level_percent' => 0,
    'current_level' => 0,
    'notification' => 0,
    'badges_to_display' => 0,
    'badge' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d18c8ff3d583_10792809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d18c8ff3d583_10792809')) {function content_51d18c8ff3d583_10792809($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?><script>
	var current_id_tab = <?php echo intval($_smarty_tpl->tpl_vars['current_id_tab']->value);?>
;
	var current_level_percent = <?php echo intval($_smarty_tpl->tpl_vars['current_level_percent']->value);?>
;
	var current_level = <?php echo intval($_smarty_tpl->tpl_vars['current_level']->value);?>
;
	var gamification_level = '<?php echo smartyTranslate(array('s'=>'Level','js'=>1),$_smarty_tpl);?>
';
</script>
<div id="gamification_notif" class="notifs">
		<?php if ($_smarty_tpl->tpl_vars['notification']->value){?>
		<span id="gamification_notif_number_wrapper" class="number_wrapper" style="display: inline;">
			<span id="gamification_notif_value"><?php echo intval($_smarty_tpl->tpl_vars['notification']->value);?>
</span>
		</span>
		<?php }?>
	<div id="gamification_notif_wrapper" class="notifs_wrapper" style="width:340px">
		<div id="gamification_top">
			<h3><?php echo smartyTranslate(array('s'=>'Your Merchant Expertise'),$_smarty_tpl);?>
</h3>
		</div>
		<div id="gamification_progressbar"><span class="gamification_progress-label"><?php echo smartyTranslate(array('s'=>'Level'),$_smarty_tpl);?>
 <?php echo intval($_smarty_tpl->tpl_vars['current_level']->value);?>
 : <?php echo intval($_smarty_tpl->tpl_vars['current_level_percent']->value);?>
 %</span></div>
		<div id="gamification_badges_container">
			<ul id="gamification_badges_list" style="<?php if (count($_smarty_tpl->tpl_vars['badges_to_display']->value)<=2){?> height:140px;<?php }?>">
				<?php  $_smarty_tpl->tpl_vars['badge'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['badge']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['badges_to_display']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['badge_list']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['badge']->key => $_smarty_tpl->tpl_vars['badge']->value){
$_smarty_tpl->tpl_vars['badge']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['badge_list']['iteration']++;
?>
				<?php if ($_smarty_tpl->tpl_vars['badge']->value->id){?>
					<li class="<?php if ($_smarty_tpl->tpl_vars['badge']->value->validated){?> unlocked <?php }else{ ?> locked <?php }?>" style="float:left;">
						<span class="<?php if ($_smarty_tpl->tpl_vars['badge']->value->validated){?> unlocked_img <?php }else{ ?> locked_img <?php }?>"></span>
						<div class="gamification_badges_title"><span><?php if ($_smarty_tpl->tpl_vars['badge']->value->validated){?> <?php echo smartyTranslate(array('s'=>'Last badge :'),$_smarty_tpl);?>
 <?php }else{ ?> <?php echo smartyTranslate(array('s'=>'Next badge :'),$_smarty_tpl);?>
 <?php }?></span></div>
						<div class="gamification_badges_img"><img src="<?php echo $_smarty_tpl->tpl_vars['badge']->value->getBadgeImgUrl();?>
"></div>
						<div class="gamification_badges_name"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['badge']->value->name, 'html', 'UTF-8');?>
</div>
					</li>
				<?php }else{ ?>
					<li style="height:130px"></li>
				<?php }?>
				<?php if (!(1 & $_smarty_tpl->getVariable('smarty')->value['foreach']['badge_list']['iteration'])&&count($_smarty_tpl->tpl_vars['badges_to_display']->value)>2){?>
						<div class="clear">&nbsp;</div>
					<?php }?>
				<?php } ?>
			</ul>
		</div>
		<a id="gamification_see_more" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminGamification');?>
"><?php echo smartyTranslate(array('s'=>'View my complete profile'),$_smarty_tpl);?>
</a>
	</div>
</div>
<?php }} ?>