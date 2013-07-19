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
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51e92cbaa9db58_30633854',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e92cbaa9db58_30633854')) {function content_51e92cbaa9db58_30633854($_smarty_tpl) {?><!-- CS Manufacturer module -->
<div class="manufacturerContainer">
	<div class="list_manufacturer responsive">
		<ul id="scroller">
																<li class="">
											<div class="menufacture-1">
					<a href="http://localhost/fp-v1/index.php?id_manufacturer=1&controller=manufacturer" title="Apple Computer, Inc">
					<img src="http://localhost/fp-v1/img/m/1-mf_default.jpg" alt="Apple Computer, Inc" /></a>
				</div>
																																						<div class="menufacture-1">
					<a href="http://localhost/fp-v1/index.php?id_manufacturer=2&controller=manufacturer" title="Shure Incorporated">
					<img src="http://localhost/fp-v1/img/m/2.jpg" alt="Shure Incorporated" /></a>
				</div>
													</li>
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