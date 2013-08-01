<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 10:48:43
         compiled from "C:\wamp\www\fp-v1\modules\attributewizardpro\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2961351fa20eb3221e6-20148418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72534b8543e5ab5400cbd449e5a348f89d8c96c5' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\attributewizardpro\\footer.tpl',
      1 => 1374854437,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2961351fa20eb3221e6-20148418',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'awp_disable_hide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa20eb3736e7_04931037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa20eb3736e7_04931037')) {function content_51fa20eb3736e7_04931037($_smarty_tpl) {?><script>
var awp_disable_atc = "";
$('a.ajax_add_to_cart_button').each(function(){
	awp_disable_atc += (awp_disable_atc == ""?"":",")+$(this).attr('rel').replace('ajax_id_product_','');
});
$.ajax({
	type: 'POST',
	url: baseDir + 'modules/attributewizardpro/disable_json.php',
	async: false,
	cache: false,
	dataType : "json",
	data: {'products':awp_disable_atc},
	success:function(feed)
	{ 
       // Do something with the response
        if (feed.awp_disable)
        {
       		var disable_arr = feed.awp_disable.split(',');
          	for (awp_id in disable_arr)
          	{
          		if ($('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').attr('class'))
          		{
          			<?php if ($_smarty_tpl->tpl_vars['awp_disable_hide']->value=="1"){?>
          			$('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').hide();
          			<?php }else{ ?>
          			var awp_class = $('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').attr('class').replace("ajax_add_to_cart_button","");
          			var awp_add_text = $('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').html();
          			$('a[rel=ajax_id_product_'+disable_arr[awp_id]+']').replaceWith('<span class="'+awp_class+'">'+awp_add_text+'</span>');
          			<?php }?>
          		}
          	}
          }
	}
});
</script><?php }} ?>