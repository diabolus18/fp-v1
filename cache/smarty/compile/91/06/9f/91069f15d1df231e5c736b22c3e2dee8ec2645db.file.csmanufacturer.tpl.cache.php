<?php /* Smarty version Smarty-3.1.13, created on 2013-07-19 14:03:24
         compiled from "C:\wamp\www\fp-v1\modules\csmanufacturer\csmanufacturer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1248651e92b0c8f3f02-92587219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91069f15d1df231e5c736b22c3e2dee8ec2645db' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\csmanufacturer\\csmanufacturer.tpl',
      1 => 1374235264,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1248651e92b0c8f3f02-92587219',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manufacs' => 0,
    'ps_manu_img_dir' => 0,
    'manufacturer' => 0,
    'i' => 0,
    'link' => 0,
    'img_manu_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92b0c9f2616_66011478',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92b0c9f2616_66011478')) {function content_51e92b0c9f2616_66011478($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?><!-- CS Manufacturer module -->
<div class="manufacturerContainer">
	<div class="list_manufacturer responsive">
		<ul id="scroller">
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['manufacturer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manufacturer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manufacs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->key => $_smarty_tpl->tpl_vars['manufacturer']->value){
$_smarty_tpl->tpl_vars['manufacturer']->_loop = true;
?>
			<?php if (file_exists((($_smarty_tpl->tpl_vars['ps_manu_img_dir']->value).($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'])).('.jpg'))){?>
			<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['i']->value%2==1){?>
			<li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['product_list']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['product_list']['last']){?>last_item<?php }?>">
			<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['i']->value%2==1){?>
				<div class="menufacture-1">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['manufacturer']->value['link_rewrite']);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['name'], 'htmlall', 'UTF-8');?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;?>
<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'], 'htmlall', 'UTF-8');?>
-mf_default.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['name'], 'htmlall', 'UTF-8');?>
" /></a>
				</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['i']->value%2==0){?>
				<div class="menufacture-1">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['manufacturer']->value['link_rewrite']);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['name'], 'htmlall', 'UTF-8');?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_manu_dir']->value;?>
<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'], 'htmlall', 'UTF-8');?>
.jpg" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['manufacturer']->value['name'], 'htmlall', 'UTF-8');?>
" /></a>
				</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['i']->value%2==0||$_smarty_tpl->tpl_vars['i']->value==count($_smarty_tpl->tpl_vars['manufacs']->value)){?>
					</li>
				<?php }?>
			<?php }?>
		<?php } ?>
		</ul>
			<a id="prev_cs_manu" class="prev btn" href="javascript:void(0)">&lt;</a>
			<a id="next_cs_manu" class="next btn" href="javascript:void(0)">&gt;</a>
	</div>
</div>
<script type="text/javascript">
	$(window).load(function(){
		$("#scroller").carouFredSel({
			auto: false,
			responsive: true,
				width: '100%',
				height : 'variable',
				prev: '#prev_cs_manu',
				next: '#next_cs_manu',
				swipe: {
					onTouch : true
				},
				items: {
					width: 140,
					height: 'variable',
					visible: {
						min: 1,
						max: 6
					}
				},
				scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 500   //  The duration of the transition.
				}

		});
	});
</script>
<!-- /CS Manufacturer module -->

<?php }} ?>