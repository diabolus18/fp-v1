<?php /* Smarty version Smarty-3.1.13, created on 2013-07-01 13:43:34
         compiled from "C:\wamp\www\fp-V1\themes\default\order-steps.tpl" */ ?>
<?php /*%%SmartyHeaderCode:673051d1878601ee78-75651407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a97b1041079ecb449d1ca8955f8dd7923c5ed672' => 
    array (
      0 => 'C:\\wamp\\www\\fp-V1\\themes\\default\\order-steps.tpl',
      1 => 1372670661,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '673051d1878601ee78-75651407',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'back' => 0,
    'multi_shipping' => 0,
    'opc' => 0,
    'current_step' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51d187861e89d1_25332550',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d187861e89d1_25332550')) {function content_51d187861e89d1_25332550($_smarty_tpl) {?>


<?php $_smarty_tpl->_capture_stack[0][] = array("url_back", null, null); ob_start(); ?>
<?php if (isset($_smarty_tpl->tpl_vars['back']->value)&&$_smarty_tpl->tpl_vars['back']->value){?>back=<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
<?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if (!isset($_smarty_tpl->tpl_vars['multi_shipping']->value)){?>
	<?php $_smarty_tpl->tpl_vars['multi_shipping'] = new Smarty_variable('0', null, 0);?>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value){?>
<!-- Steps -->
<ul class="step" id="order_step">
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='summary'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'||$_smarty_tpl->tpl_vars['current_step']->value=='login'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'||$_smarty_tpl->tpl_vars['current_step']->value=='login'){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&multi-shipping=".((string)$_smarty_tpl->tpl_vars['multi_shipping']->value));?>
">
			1. <?php echo smartyTranslate(array('s'=>'Summary'),$_smarty_tpl);?>

		</a>
		<?php }else{ ?>
			<span>1. <?php echo smartyTranslate(array('s'=>'Summary'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='login'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=1&multi-shipping=".((string)$_smarty_tpl->tpl_vars['multi_shipping']->value));?>
">
			2. <?php echo smartyTranslate(array('s'=>'Login'),$_smarty_tpl);?>

		</a>
		<?php }else{ ?>
			<span>2. <?php echo smartyTranslate(array('s'=>'Login'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='address'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=1&multi-shipping=".((string)$_smarty_tpl->tpl_vars['multi_shipping']->value));?>
">
			3. <?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>

		</a>
		<?php }else{ ?>
			<span>3. <?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='shipping'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=2&multi-shipping=".((string)$_smarty_tpl->tpl_vars['multi_shipping']->value));?>
">
			4. <?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>

		</a>
		<?php }else{ ?>
			<span>4. <?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li id="step_end" class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'){?>step_current_end<?php }else{ ?>step_todo<?php }?>">
		<span>5. <?php echo smartyTranslate(array('s'=>'Payment'),$_smarty_tpl);?>
</span>
	</li>
</ul>
<!-- /Steps -->
<?php }?>
<?php }} ?>