<?php /* Smarty version Smarty-3.1.13, created on 2013-08-29 08:51:28
         compiled from "C:\wamp\www\fp-v1\modules\blocktestimonial\displayadmintestimonialsForm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28162521eef70452520-34063607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '755601b86160458abb917f24a29f0ec19a7cbb63' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocktestimonial\\displayadmintestimonialsForm.tpl',
      1 => 1377759057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28162521eef70452520-34063607',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_path' => 0,
    'requestUri' => 0,
    'testimonials' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521eef70548973_98769579',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521eef70548973_98769579')) {function content_521eef70548973_98769579($_smarty_tpl) {?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
js/displayadmintestimonial.js"></script>
<link href="<?php echo $_smarty_tpl->tpl_vars['this_path']->value;?>
css/admintestimonial.css" rel="stylesheet" type="text/css" media="all" />
<form action="<?php echo $_smarty_tpl->tpl_vars['requestUri']->value;?>
" method="post" name="form1">
	<fieldset>
	  <legend><img src="../img/admin/slip.gif" /><?php echo smartyTranslate(array('s'=>'View / Manage Testimonials','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</legend>
	  <div style="display:none;" id="controls">
			<input  class="button" name="Enable" value="<?php echo smartyTranslate(array('s'=>'Enable Selected','mod'=>'blockTestimonial'),$_smarty_tpl);?>
" type="submit" type="submit" style="width: 200px;"/>
			<input class="button"  name="Disable" value="<?php echo smartyTranslate(array('s'=>'Disable Selected','mod'=>'blockTestimonial'),$_smarty_tpl);?>
" type="submit" type="submit" style="width: 200px;"/>
			<input class="button"  name="Delete" onClick="return confirmSubmit('<?php echo smartyTranslate(array('s'=>'Okay to Delete this Testimonial(s)?','mod'=>'blockTestimonial'),$_smarty_tpl);?>
')" value="<?php echo smartyTranslate(array('s'=>'Delete Selected','mod'=>'blockTestimonial'),$_smarty_tpl);?>
" type="submit" type="submit" style="width: 200px;"/>
			<input class="button"  name="Update" value="<?php echo smartyTranslate(array('s'=>'Update Selected','mod'=>'blockTestimonial'),$_smarty_tpl);?>
" type="submit" type="submit" style="width: 200px;"/>
	   </div>
			<table id="box-table-a" >
			<th><?php echo smartyTranslate(array('s'=>'Select','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Select Column Header-->
			  <th><?php echo smartyTranslate(array('s'=>'Status','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Status Column Header-->
			  <th><?php echo smartyTranslate(array('s'=>'Name','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Name Column Header-->
			  <th><?php echo smartyTranslate(array('s'=>'Date','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Date Column Header-->
			  <th><?php echo smartyTranslate(array('s'=>'Testimonial','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Testimonial  Column Header-->
                          <th><?php echo smartyTranslate(array('s'=>'Testimonial Image','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</th> <!-- Testimonial Image  Column Header-->
			  <?php if ($_smarty_tpl->tpl_vars['testimonials']->value!=null){?>
				  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['nr'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['name'] = 'nr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['testimonials']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['nr']['total']);
?>
						  <tr>
							<td> <!--Check Box -->
							<INPUT class="testimonialselect" TYPE=checkbox VALUE="<?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_id'];?>
" NAME="moderate[]">
							</td>
						  
							<td> <!-- Status Column -->
							 <?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['status'];?>

							</td>
							
							<td> <!-- Name Column -->
							 <?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_submitter_name'];?>

							</td>
							
							<td> <!-- Date Column -->
							 <?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['date_added']);?>

							</td>
							
							<td> <!-- Testimonial Column -->
							<textarea name="testimonial_main_message_<?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_id'];?>
" > <?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_main_message'];?>
 </textarea>
							</td>

							<td> <!-- Testimonial Image -->
                                                           <?php if ($_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_img']!=null){?>
							    <img width="35" height="35" src="http://localhost<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_img'];?>
" >
                                                            <?php echo $_smarty_tpl->tpl_vars['testimonials']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nr']['index']]['testimonial_img'];?>

                                                           <?php }?>
							</td>
						  </tr>

				   <?php endfor; endif; ?>
				    <?php }else{ ?>
					 <tr><td><?php echo smartyTranslate(array('s'=>'No Testimonials Yet','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</td></tr>
                <?php }?>
			</table>
			
	</fieldset>
</form>
<?php }} ?>