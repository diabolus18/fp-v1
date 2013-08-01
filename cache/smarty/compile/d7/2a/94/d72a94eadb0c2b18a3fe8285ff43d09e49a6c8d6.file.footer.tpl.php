<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 12:13:17
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:485951fa34bd134484-44222974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd72a94eadb0c2b18a3fe8285ff43d09e49a6c8d6' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\footer.tpl',
      1 => 1374235091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '485951fa34bd134484-44222974',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'HOOK_CS_HOME_LEFT' => 0,
    'HOOK_CS_HOME_RIGHT' => 0,
    'content_only' => 0,
    'settings' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_CS_FOOTER_TOP' => 0,
    'HOOK_FOOTER' => 0,
    'PS_ALLOW_MOBILE_DEVICE' => 0,
    'link' => 0,
    'HOOK_CS_FOOTER_BOTTOM' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa34bd2cd5a7_10414599',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa34bd2cd5a7_10414599')) {function content_51fa34bd2cd5a7_10414599($_smarty_tpl) {?>

			
			<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>
				<div id="cs_home_center_bottom" class="grid_24 alpha omega">
				<?php if ($_smarty_tpl->tpl_vars['HOOK_CS_HOME_LEFT']->value){?>
					<div id="cs_home_center_bottom_left" class="grid_18 alpha">
						<?php echo $_smarty_tpl->tpl_vars['HOOK_CS_HOME_LEFT']->value;?>

					</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['HOOK_CS_HOME_RIGHT']->value){?>
					<div id="cs_home_center_bottom_right" class="grid_6 omega">
						<?php echo $_smarty_tpl->tpl_vars['HOOK_CS_HOME_RIGHT']->value;?>

					</div>
				<?php }?>
				</div>
			<?php }?>
			<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
					</div><!-- /Center -->
			<?php if (isset($_smarty_tpl->tpl_vars['settings']->value)){?>
				<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'){?>
					<?php if ((($_smarty_tpl->tpl_vars['settings']->value->column=='2_column_right'||$_smarty_tpl->tpl_vars['settings']->value->column=='3_column'))){?>
						<!-- Left -->
						<div id="right_column" class="<?php echo $_smarty_tpl->tpl_vars['settings']->value->right_class;?>
 omega">
							<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

						</div>
						<?php if ($_smarty_tpl->tpl_vars['settings']->value->column=='3_column'){?>
						<script type="text/javascript">
							if($("#right_column").children("#layered_block_left").length>0)
							{
								$("#right_column").children("#layered_block_left").css("display","none");
								$("#right_column").children("#layered_block_left").remove();
							}
						</script>
						<?php }?>
					<?php }?>
				<?php }?>
			<?php }?>
				</div><!--/columns-->
			</div><!--/container_24-->
			</div>
<!-- Footer -->
			<div class="mode_footer">
					<div class="container_24">	
						<?php if ($_smarty_tpl->tpl_vars['HOOK_CS_FOOTER_TOP']->value){?>
							<div id="footer-top" class="grid_24 clearfix  omega alpha">
								<?php echo $_smarty_tpl->tpl_vars['HOOK_CS_FOOTER_TOP']->value;?>

							</div>
						<?php }?>
						<div id="footer" class="grid_24 clearfix  omega alpha">
							<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

							<?php if ($_smarty_tpl->tpl_vars['PS_ALLOW_MOBILE_DEVICE']->value){?>
								<p class="center clearBoth"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true);?>
?mobile_theme_ok"><?php echo smartyTranslate(array('s'=>'Browse the mobile site'),$_smarty_tpl);?>
</a></p>
							<?php }?>
						</div>						
					</div>
					<?php if ($_smarty_tpl->tpl_vars['HOOK_CS_FOOTER_BOTTOM']->value){?>
					<div class="mode_footer_content_bottom">
						<div class="cs_bo_footer_bottom">
						<div id="footer-bottom" class="container_24">
							<?php echo $_smarty_tpl->tpl_vars['HOOK_CS_FOOTER_BOTTOM']->value;?>

						</div>
						</div>
					</div>
					<?php }?>
			</div>
		</div><!--/page-->
	<?php }?>
	</body>
</html>
<?php }} ?>