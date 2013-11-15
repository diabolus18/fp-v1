<?php /* Smarty version Smarty-3.1.13, created on 2013-11-12 17:06:45
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1730152825215b0c299-65028649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf92f3d9f74decbd444e04773c5385d501028901' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\category.tpl',
      1 => 1381415879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1730152825215b0c299-65028649',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'scenes' => 0,
    'link' => 0,
    'subcategories' => 0,
    'subcategory' => 0,
    'img_cat_dir' => 0,
    'categoryNameComplement' => 0,
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52825215ccddd0_25414493',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52825215ccddd0_25414493')) {function content_52825215ccddd0_25414493($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if (isset($_smarty_tpl->tpl_vars['category']->value)){?>
	<?php if ($_smarty_tpl->tpl_vars['category']->value->id&&$_smarty_tpl->tpl_vars['category']->value->active){?>	
		
		<?php if ($_smarty_tpl->tpl_vars['scenes']->value||$_smarty_tpl->tpl_vars['category']->value->description||$_smarty_tpl->tpl_vars['category']->value->id_image){?>
		<div class="content_scene_cat">
			<?php if ($_smarty_tpl->tpl_vars['scenes']->value){?>
				<!-- Scenes -->
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./scenes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('scenes'=>$_smarty_tpl->tpl_vars['scenes']->value), 0);?>

			<?php }else{ ?>
				
				
				<!-- Category image -->
				<?php if ($_smarty_tpl->tpl_vars['category']->value->id_image){?>
				<div class="align_center">
				<!-- MISE EN COMMENTAIRE AFFICHAGE IMAGE CATEGORIES
					<img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['category']->value->link_rewrite,$_smarty_tpl->tpl_vars['category']->value->id_image,'category_default');?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['category']->value->name, 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['category']->value->name, 'htmlall', 'UTF-8');?>
" id="categoryImage"/>
				-->
				
				</div>
				<?php }?>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['category']->value->description){?>
				<div class="cat_desc">
				<?php if (strlen($_smarty_tpl->tpl_vars['category']->value->description)>600){?>
					<p id="category_description_short"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value->description,120);?>
</p>
					<p id="category_description_full" style="display:none"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</p>
					<a href="#" onclick="$('#category_description_short').hide(); $('#category_description_full').show(); $(this).hide(); return false;" class="lnk_more"><?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
</a>
				<?php }else{ ?>
					<p><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</p>
				<?php }?>
				</div>
			<?php }?>
		</div>
		<?php }?>
				
		
		<?php if (isset($_smarty_tpl->tpl_vars['subcategories']->value)){?>
		<!-- Subcategories -->
		<div id="subcategories">
			<h3><?php echo smartyTranslate(array('s'=>'Subcategories'),$_smarty_tpl);?>
</h3>
			<ul class="inline_list">
			<?php  $_smarty_tpl->tpl_vars['subcategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subcategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->key => $_smarty_tpl->tpl_vars['subcategory']->value){
$_smarty_tpl->tpl_vars['subcategory']->_loop = true;
?>
				<li class="clearfix">
					<a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['subcategory']->value['id_category'],$_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite']), 'htmlall', 'UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['subcategory']->value['name'], 'htmlall', 'UTF-8');?>
" class="img">
						<?php if ($_smarty_tpl->tpl_vars['subcategory']->value['id_image']){?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite'],$_smarty_tpl->tpl_vars['subcategory']->value['id_image'],'medium_default');?>
" alt="" />
						<?php }else{ ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
default-medium_default.jpg" alt="" />
						<?php }?>
					</a>
					<a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['subcategory']->value['id_category'],$_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite']), 'htmlall', 'UTF-8');?>
" class="cat_name"><h1><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['subcategory']->value['name'], 'htmlall', 'UTF-8');?>
</h1></a>
					<?php if ($_smarty_tpl->tpl_vars['subcategory']->value['description']){?>
						<p class="cat_desc"><?php echo $_smarty_tpl->tpl_vars['subcategory']->value['description'];?>
</p>
					<?php }?>
				</li>
			<?php } ?>
			</ul>
			<br class="clear"/>
		</div>
		<?php }?>
		<h1>
			<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['category']->value->name, 'htmlall', 'UTF-8');?>
<?php if (isset($_smarty_tpl->tpl_vars['categoryNameComplement']->value)){?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['categoryNameComplement']->value, 'htmlall', 'UTF-8');?>
<?php }?>
			<span class="resumecat category-product-count">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./category-count.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</span>
		</h1>
		
		<?php if ($_smarty_tpl->tpl_vars['products']->value){?>
			<div class="content_sortPagiBar">			
				<div class="sortPagiBar">	
					<?php echo $_smarty_tpl->getSubTemplate ("./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

					<?php echo $_smarty_tpl->getSubTemplate ("./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

				</div>
				
			</div>
			
			<?php echo $_smarty_tpl->getSubTemplate ("./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>

			
			<div class="content_sortPagiBar bottom">
				<div class="sortPagiBar">
					<?php echo $_smarty_tpl->getSubTemplate ("./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

				</div>
				<?php echo $_smarty_tpl->getSubTemplate ("./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

			</div>
		<?php }?>
	<?php }elseif($_smarty_tpl->tpl_vars['category']->value->id){?>
		<p class="warning"><?php echo smartyTranslate(array('s'=>'This category is currently unavailable.'),$_smarty_tpl);?>
</p>
	<?php }?>
<?php }?>
<?php }} ?>