<?php /* Smarty version Smarty-3.1.13, created on 2013-08-28 10:54:19
         compiled from "C:\wamp\www\fp-v1\modules\cshometab\cshometab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14433521dbabb188f17-48025550%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02d18dc500c33aeeec71fcdacd61678b86b39d30' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\cshometab\\cshometab.tpl',
      1 => 1377612687,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14433521dbabb188f17-48025550',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tabs' => 0,
    'option' => 0,
    'cookie' => 0,
    'tab' => 0,
    'product' => 0,
    'link' => 0,
    'restricted_country_mode' => 0,
    'priceDisplay' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521dbabb48a4f1_97754798',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521dbabb48a4f1_97754798')) {function content_521dbabb48a4f1_97754798($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\wamp\\www\\fp-v1\\tools\\smarty\\plugins\\modifier.escape.php';
?><!-- CS Home Tab module -->
<div class="home_top_tab">
<?php if (count($_smarty_tpl->tpl_vars['tabs']->value)>0){?>
<div id="tabs">
	<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="true"){?>
	<ul id="ul_cs_tab">
		<?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['tab']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->iteration++;
 $_smarty_tpl->tpl_vars['tab']->last = $_smarty_tpl->tpl_vars['tab']->iteration === $_smarty_tpl->tpl_vars['tab']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['last'] = $_smarty_tpl->tpl_vars['tab']->last;
?>
			<li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['last']){?>last<?php }?> refreshCarousel">
				<a href="#tabs-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
" <?php if ($_smarty_tpl->tpl_vars['option']->value->scrollPanel=="true"){?> onclick="return updateCarousel(<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
);" <?php }else{ ?>onclick="return updateNotCarousel(<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
);"<?php }?>><?php echo $_smarty_tpl->tpl_vars['tab']->value->title[(int)$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
</a>
			</li>
		<?php } ?>
	</ul>
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['tab']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->iteration++;
 $_smarty_tpl->tpl_vars['tab']->last = $_smarty_tpl->tpl_vars['tab']->iteration === $_smarty_tpl->tpl_vars['tab']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['last'] = $_smarty_tpl->tpl_vars['tab']->last;
?>
		<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="false"){?>
			<div class="title_tab"><?php echo $_smarty_tpl->tpl_vars['tab']->value->title[(int)$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
</div>
		<?php }?>
		<div class="title_tab_hide_show" style="display:none">
			<?php echo $_smarty_tpl->tpl_vars['tab']->value->title[(int)$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>

			<input type='hidden' value='<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
' />
		</div>
	<div class="tabs-carousel" id="tabs-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
">
		<div class="cycleElementsContainer" id="cycle-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
">
			
			<div id="elements-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
">
				<?php if (count($_smarty_tpl->tpl_vars['tab']->value->product_list)>0){?>
				<div class="list_carousel responsive">
					<div class="view_more_link"><a href="<?php echo $_smarty_tpl->tpl_vars['tab']->value->view_more;?>
"><span><?php echo smartyTranslate(array('s'=>"View more",'mod'=>'cshometab'),$_smarty_tpl);?>
</span></a></div>
					<ul id="carousel<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
" class="product-list">
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tab']->value->product_list; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product_list']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product_list']['first'] = $_smarty_tpl->tpl_vars['product']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product_list']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product_list']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
						<li class="ajax_block_product <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['product_list']['first']){?>first_item<?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['product_list']['last']){?>last_item<?php }?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['product_list']['iteration']%$_smarty_tpl->tpl_vars['option']->value->show==0){?> last_item_of_line<?php }?>">
						<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'html', 'UTF-8');?>
" class="product_image"><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'p_menu_default');?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'html', 'UTF-8');?>
" /></a>
						
						<h3><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'htmlall', 'UTF-8');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],50,'...'), 'htmlall', 'UTF-8');?>
</a></h3>
						<p class="category_name"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['category'], 'htmlall', 'UTF-8');?>
</p>
						
						<!-- MISE EN COMMENTAIRE AFFICHAGE ETOILES EVALUATION
						<div class="star_content clearfix">
							<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['name'] = "i";
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total']);
?>
								<?php if ($_smarty_tpl->tpl_vars['product']->value['ratting']<=$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']){?>
									<div class="star"></div>
								<?php }else{ ?>
									<div class="star star_on"></div>
								<?php }?>
							<?php endfor; endif; ?>
						</div>
						-->
						
						
						<div class="products_list_price">
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)){?>
								<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value&&$_smarty_tpl->tpl_vars['product']->value['reduction']){?><span class="price-discount"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction']),$_smarty_tpl);?>
</span><?php }?>
								<span class="price"><?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
<?php }else{ ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?></span>
							<?php }?>
						</div>
						<br/>
						
						<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'htmlall', 'UTF-8');?>
" class="button" style="margin:auto;"><?php echo smartyTranslate(array('s'=>'See this knife ','mod'=>'cshometab'),$_smarty_tpl);?>
</a>
						
						
					</li>
					<?php } ?>
					</ul>
					<div class="cclearfix"></div>
					<?php if ($_smarty_tpl->tpl_vars['option']->value->scrollPanel=="true"){?>
					<a id="prev<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
" class="prev" href="#">&lt;</a>
					<a id="next<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
" class="next" href="#">&gt;</a>
					<?php }?>
				</div>
				<?php }?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		cs_resize();
		if(!isMobile())
		{
			initCarousel();
		}
		if(getWidthBrowser() < 767)
		{
			$('#tabs').on('click', '.title_tab_hide_show', function() {
				var id = $(this).find('input').val();
				
				if($(this).hasClass('selected')) {
					$(this).removeClass('selected');
					$('#tabs-'+id).hide();
				} else {
					
					$('#tabs .title_tab_hide_show').removeClass('selected');
					$('#tabs .tabs-carousel').hide();
					
					$(this).addClass('selected');	
					$('#tabs-'+id).show();
					initCarouselMobile();
				}
			});
		}
	});

	$(window).resize(function() {
		if(!isMobile())
		{
			cs_resize();
		}
	});
	function cs_resize()	{
		if(getWidthBrowser() < 767){ 
		<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="true"){?>
			$('#tabs').tabs('destroy');
			initCarousel();
		<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="false"){?>
				$('.title_tab').hide();
			<?php }?>
			$('.tabs-carousel').hide();
			$('#ul_cs_tab').hide();
			$('#tabs div.title_tab_hide_show').show();
		} else {
			<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="true"){?>
				$('#tabs').tabs();
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['option']->value->js_tab=="false"){?>
				$('.title_tab').show();
			<?php }?>
			$('.tabs-carousel').show();
			
			$('#ul_cs_tab').show();
			$('#tabs div.title_tab_hide_show').hide();
			
		}
	}
	
	function initCarousel() {
		<?php if ($_smarty_tpl->tpl_vars['option']->value->scrollPanel=="true"){?>
			<?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['tab']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->iteration++;
 $_smarty_tpl->tpl_vars['tab']->last = $_smarty_tpl->tpl_vars['tab']->iteration === $_smarty_tpl->tpl_vars['tab']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['last'] = $_smarty_tpl->tpl_vars['tab']->last;
?>
			//	Responsive layout, resizing the items
			$('#carousel<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
').carouFredSel({
				responsive: true,
				width: '100%',
				prev: '#prev<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
',
				next: '#next<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
',
				auto: false,
				swipe: {
					onTouch : true
				},
				items: {
					width: 155,
					height: 280,	//	optionally resize item-height
					visible: {
						min: 1,
						max: <?php echo $_smarty_tpl->tpl_vars['option']->value->show;?>

					}
				},
				scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
			});
			<?php } ?>
		<?php }?>
	}
	
	function initCarouselMobile() {
		<?php if ($_smarty_tpl->tpl_vars['option']->value->scrollPanel=="true"){?>
			<?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['tab']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->iteration++;
 $_smarty_tpl->tpl_vars['tab']->last = $_smarty_tpl->tpl_vars['tab']->iteration === $_smarty_tpl->tpl_vars['tab']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tabs']['last'] = $_smarty_tpl->tpl_vars['tab']->last;
?>
			//	Responsive layout, resizing the items
			$('#carousel<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
').carouFredSel({
				responsive: true,
				width: '100%',
				prev: '#prev<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
',
				next: '#next<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tabs']['iteration'];?>
',
				auto: true,
				swipe: {
					onTouch : true
				},
				items: {
					width: 155,
					height: 280,	//	optionally resize item-height
					visible: {
						min: 1,
						max:<?php echo $_smarty_tpl->tpl_vars['option']->value->show;?>

					}
				},
				scroll: {
					items:1,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
			});
			<?php } ?>
		<?php }?>
	}
	
	function updateNotCarousel(idx){
		jQuery(".tabs-carousel").hide();
		jQuery("#tabs-"+idx).show();
	}

	function updateCarousel(idx){
		$('#carousel'+idx).trigger("destroy", true);
		jQuery(".tabs-carousel").hide();
		jQuery("#tabs-"+idx).show();
		
		$('#carousel'+idx).carouFredSel({
			responsive: true,
			width: '100%',
			prev: '#prev'+idx,
			next: '#next'+idx,
			auto: false,
			swipe: {
				onTouch : true
			},
			items: {
				width: 155,
				height: 280,	//	optionally resize item-height
				visible: {
					min: 1,
					max: <?php echo $_smarty_tpl->tpl_vars['option']->value->show;?>

				}
			},
			scroll: {
					items:3,
					direction : 'left',    //  The direction of the transition.
					duration  : 300   //  The duration of the transition.
				}
		});
	}
	
	function isMobile() {
		if(navigator.userAgent.match(/iPod/i)){
				return true;
		}
		return false;
	}

</script>
<?php }?>
</div>
<!-- /CS Home Tab module -->
<?php }} ?>