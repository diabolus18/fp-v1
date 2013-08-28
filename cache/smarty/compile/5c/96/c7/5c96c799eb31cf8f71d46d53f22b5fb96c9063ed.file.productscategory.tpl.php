<?php /* Smarty version Smarty-3.1.13, created on 2013-08-28 10:53:55
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\modules\productscategory\productscategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25129521dbaa3b6ae17-12821830%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c96c799eb31cf8f71d46d53f22b5fb96c9063ed' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\modules\\productscategory\\productscategory.tpl',
      1 => 1374235096,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25129521dbaa3b6ae17-12821830',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryProducts' => 0,
    'categoryProduct' => 0,
    'link' => 0,
    'restricted_country_mode' => 0,
    'ProdDisplayPrice' => 0,
    'PS_CATALOG_MODE' => 0,
    'add_prod_display' => 0,
    'static_token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521dbaa3de9736_00941195',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521dbaa3de9736_00941195')) {function content_521dbaa3de9736_00941195($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\function.math.php';
if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>0&&$_smarty_tpl->tpl_vars['categoryProducts']->value!==false){?>
<div class="clearfix blockproductscategory">
	<h2 class="productscategory_h2"><?php echo count($_smarty_tpl->tpl_vars['categoryProducts']->value);?>
 <?php echo smartyTranslate(array('s'=>'other products in the same category:','mod'=>'productscategory'),$_smarty_tpl);?>
</h2>
	<div id="<?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>5){?>productscategory<?php }else{ ?>productscategory_noscroll<?php }?>">
		<div id="productscategory_list" class="list_carousel responsive">
			<ul id="carousel-productscategory" <?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>5){?>style="width: <?php echo smarty_function_math(array('equation'=>"width * nbImages",'width'=>107,'nbImages'=>count($_smarty_tpl->tpl_vars['categoryProducts']->value)),$_smarty_tpl);?>
px"<?php }?>>
				<?php  $_smarty_tpl->tpl_vars['categoryProduct'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categoryProduct']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categoryProducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categoryProduct']->key => $_smarty_tpl->tpl_vars['categoryProduct']->value){
$_smarty_tpl->tpl_vars['categoryProduct']->_loop = true;
?>
				<li <?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)<6){?>style="width:60px"<?php }?>>
				<div class="center_block">
					<div class="image"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'],$_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['category'],$_smarty_tpl->tpl_vars['categoryProduct']->value['ean13']);?>
" class="lnk_img product_img_link" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['id_image'],'home_default');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
" /></a></div>
					<div class="name_product"><h3><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product'],$_smarty_tpl->tpl_vars['categoryProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['categoryProduct']->value['category'],$_smarty_tpl->tpl_vars['categoryProduct']->value['ean13']);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryProduct']->value['name']);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['categoryProduct']->value['name'],45,'...'), 'htmlall', 'UTF-8');?>
</a></h3></div>
					<p class="category_name"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['categoryProduct']->value['category'], 'htmlall', 'UTF-8');?>
</p>
					
					<?php if (isset($_smarty_tpl->tpl_vars['categoryProduct']->value['available_for_order'])&&$_smarty_tpl->tpl_vars['categoryProduct']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)){?>
					<?php if (($_smarty_tpl->tpl_vars['categoryProduct']->value['allow_oosp']||$_smarty_tpl->tpl_vars['categoryProduct']->value['quantity']>0)){?>
						<span class="availability"><?php echo smartyTranslate(array('s'=>'Available','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
					<?php }elseif((isset($_smarty_tpl->tpl_vars['categoryProduct']->value['quantity_all_versions'])&&$_smarty_tpl->tpl_vars['categoryProduct']->value['quantity_all_versions']>0)){?>
						<span class="availability"><?php echo smartyTranslate(array('s'=>'Product available with different options'),$_smarty_tpl);?>
</span>
					<?php }else{ ?><span class="cs_out_of_stock"><?php echo smartyTranslate(array('s'=>'Out of stock','mod'=>'productscategory'),$_smarty_tpl);?>
</span><?php }?>
					<?php }?>

					<p class="product_desc"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['categoryProduct']->value['description_short']),90,'...');?>
</p>	
					
					<?php if ($_smarty_tpl->tpl_vars['ProdDisplayPrice']->value&&$_smarty_tpl->tpl_vars['categoryProduct']->value['show_price']==1&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value){?>
					<p class="price_display">
						<span class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['categoryProduct']->value['displayed_price']),$_smarty_tpl);?>
</span>
					</p>
					<?php }?>
					
					<?php if (($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product_attribute']==0||(isset($_smarty_tpl->tpl_vars['add_prod_display']->value)&&($_smarty_tpl->tpl_vars['add_prod_display']->value==1)))&&$_smarty_tpl->tpl_vars['categoryProduct']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['categoryProduct']->value['minimal_quantity']<=1&&$_smarty_tpl->tpl_vars['categoryProduct']->value['customizable']!=2&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value){?>
					<?php if (($_smarty_tpl->tpl_vars['categoryProduct']->value['allow_oosp']||$_smarty_tpl->tpl_vars['categoryProduct']->value['quantity']>0)){?>
						<?php if (isset($_smarty_tpl->tpl_vars['static_token']->value)){?>
							<a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_<?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
" href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',false,null,"add&amp;id_product=".$_tmp1."&amp;token=".((string)$_smarty_tpl->tpl_vars['static_token']->value),false);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Add to cart','mod'=>'productscategory'),$_smarty_tpl);?>
</a>
						<?php }else{ ?>
							<a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_<?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
" href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['categoryProduct']->value['id_product']);?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',false,null,"add&amp;id_product=".$_tmp2,false);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</a>
						<?php }?>						
					<?php }else{ ?>
						<span class="exclusive"><?php echo smartyTranslate(array('s'=>'Out of stock','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
					<?php }?>
				<?php }?>
				</div>
				</li>
				<?php } ?>
			</ul>
			<div class="cclearfix"></div>
			<a id="prev-productscategory" class="btn prev" href="#">&lt;</a>
			<a id="next-productscategory" class="btn next" href="#">&gt;</a>
		</div>
	</div>
	<script type="text/javascript">
		$(window).load(function(){
			//	Responsive layout, resizing the items
			$('#carousel-productscategory').carouFredSel({
				responsive: true,
				width: '100%',
				height : 'variable',
				prev: '#prev-productscategory',
				next: '#next-productscategory',
				auto: false,
				swipe: {
					onTouch : true
				},
				items: {
					width: 200,
					height : 'auto',
					visible: {
						min: 1,
						max: 3
					}
				}
			});
		});
	</script>
</div>
<?php }?>
<?php }} ?>