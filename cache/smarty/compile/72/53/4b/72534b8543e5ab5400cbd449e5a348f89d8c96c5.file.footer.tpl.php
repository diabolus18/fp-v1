<?php /* Smarty version Smarty-3.1.13, created on 2013-07-31 11:06:37
         compiled from "C:\wamp\www\fp-v1\modules\attributewizardpro\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:511451f8d39d27a1e7-81116386%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '511451f8d39d27a1e7-81116386',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'awp_disable_hide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51f8d39d2b4437_39140041',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f8d39d2b4437_39140041')) {function content_51f8d39d2b4437_39140041($_smarty_tpl) {?><script>
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