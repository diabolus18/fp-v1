<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 10:19:46
         compiled from "C:\wamp\www\fp-v1\modules\cscatalogpopular\cscatalogpopular.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1070051fa1a224612c3-80642154%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '847b04f335f4ba0698f841432738070cb8ee445c' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\cscatalogpopular\\cscatalogpopular.tpl',
      1 => 1375345116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1070051fa1a224612c3-80642154',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category_list' => 0,
    'i' => 0,
    'col' => 0,
    'category' => 0,
    'link' => 0,
    'sub' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa1a22933737_13562549',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa1a22933737_13562549')) {function content_51fa1a22933737_13562549($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?><!-- CS catalog popular -->
<?php if (isset($_smarty_tpl->tpl_vars['category_list']->value)){?>
<?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable(2, null, 0);?>
	<h4><?php echo smartyTranslate(array('s'=>'more way to shopping...','mod'=>'cscatalogpoppular'),$_smarty_tpl);?>
</h4>
	<div class="cat_popular">
	<ul class="ul_cat_popular">
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?>
	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['category_list']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['category_list']['iteration']++;
?>
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
		<li class="cat_group<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['category_list']['iteration']%$_smarty_tpl->tpl_vars['col']->value==0){?> even <?php }else{ ?> odd<?php }?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['category_list']['iteration']['last']){?> last<?php }?><?php if ($_smarty_tpl->tpl_vars['i']->value<=2){?> first<?php }?>">
		<div  class="cat-content">	
			<h3 class="cs-cat-title">
				<a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']), 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['category']->value['name'], 'htmlall', 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</a>
			</h3>
			
			<!-- MISE EN COMMENTAIRE AFFICHAGE SOUS CATEGORIES PAGE ACCUEIL
			<ul class="sub_cat">
				<?php  $_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value['subs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->key => $_smarty_tpl->tpl_vars['sub']->value){
$_smarty_tpl->tpl_vars['sub']->_loop = true;
?>
					<li ><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['sub']->value['id_category'],$_smarty_tpl->tpl_vars['sub']->value['link_rewrite']), 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['sub']->value['name'], 'htmlall', 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['sub']->value['name'];?>
</a></li>
				<?php } ?>
				
			</ul>
			
			-->
		</div>
		<div class="product-latest">
			<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value['product_latest']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'html', 'UTF-8');?>
" class="product_image"><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'home_default');?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'html', 'UTF-8');?>
" /></a>
			<?php } ?>
		</div>
		</li>
	<?php } ?>
	<li class="last view-all"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCategoryLink(2);?>
" title="View All"><span><?php echo smartyTranslate(array('s'=>"View All"),$_smarty_tpl);?>
</span></a></li>
	</ul>
	</div>
<?php }?>
<!-- CS catalog popular --><?php }} ?>