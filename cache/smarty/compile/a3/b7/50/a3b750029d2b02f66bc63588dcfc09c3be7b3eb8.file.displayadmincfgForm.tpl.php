<?php /* Smarty version Smarty-3.1.13, created on 2013-08-29 08:51:28
         compiled from "C:\wamp\www\fp-v1\modules\blocktestimonial\displayadmincfgForm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25421521eef702ea989-07393882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3b750029d2b02f66bc63588dcfc09c3be7b3eb8' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\blocktestimonial\\displayadmincfgForm.tpl',
      1 => 1377759057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25421521eef702ea989-07393882',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'requestUri' => 0,
    'recaptcha' => 0,
    'recaptchaPub' => 0,
    'recaptchaPriv' => 0,
    'recaptchaPerpage' => 0,
    'displayImage' => 0,
    'maximagesize' => 0,
    'backupfileExists' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521eef703af648_61571043',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521eef703af648_61571043')) {function content_521eef703af648_61571043($_smarty_tpl) {?>      <form action="<?php echo $_smarty_tpl->tpl_vars['requestUri']->value;?>
" method="post">
                   <fieldset>
                   <legend><img src="../img/admin/cog.gif" /><?php echo smartyTranslate(array('s'=>'Configuration','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</legend>
                     <table border="0" width="900" cellpadding="0" cellspacing="5" id="testimonialCfg">
				<div class="margin-form">
                     <label><?php echo smartyTranslate(array('s'=>'Use ReCaptcha Anti Spam','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
                                        
					<input type="radio" name="reCaptcha" id="recaptcha_on" value="1" <?php if ($_smarty_tpl->tpl_vars['recaptcha']->value==1){?>checked="yes" <?php }?>/>
					<label class="t" for="recaptcha_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="reCaptcha" id="recaptcha_off" value="0" <?php if ($_smarty_tpl->tpl_vars['recaptcha']->value==0){?>checked="yes" <?php }?> />
					<label class="t" for="recaptcha_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
                            	</div>
                                <div class="margin-form">
                                  <label><?php echo smartyTranslate(array('s'=>'ReCaptcha Public Key','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
                                  <input type="text" name="recaptchaPub" value="<?php echo $_smarty_tpl->tpl_vars['recaptchaPub']->value;?>
" />
                                 </div>

                                  <div class="margin-form">
                                  <label><?php echo smartyTranslate(array('s'=>'ReCaptcha Private Key','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
                                  <input type="text" name="recaptchaPriv" value="<?php echo $_smarty_tpl->tpl_vars['recaptchaPriv']->value;?>
" />
                                 </div>
				 <hr />
				<div class="margin-form">
                                  <label><?php echo smartyTranslate(array('s'=>'# of testimonials per page','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
                                  <input type="text" name="perPage" value="<?php echo $_smarty_tpl->tpl_vars['recaptchaPerpage']->value;?>
" />
                                 </div>
                                 <hr />


                                   <div class="margin-form">
                                        <label><?php echo smartyTranslate(array('s'=>'Allow Image Upload','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
					<input type="radio" name="displayImage" id="displayImage_on" value="1" <?php if ($_smarty_tpl->tpl_vars['displayImage']->value==1){?>checked="yes" <?php }?>/>
					<label class="t" for="displayImage_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="displayImage" id="displayImage_off" value="0" <?php if ($_smarty_tpl->tpl_vars['displayImage']->value==0){?>checked="yes" <?php }?> />
					<label class="t" for="displayImage_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
                                    </div>


                                  <div class="margin-form">
                                  <label><?php echo smartyTranslate(array('s'=>'Maximimum Image size in KiloBytes (KB)','mod'=>'blockTestimonial'),$_smarty_tpl);?>
</label>
                                  <input type="text" name="maximagesize" value="<?php echo $_smarty_tpl->tpl_vars['maximagesize']->value;?>
" />
                                 </div>

	                         <hr/>

				<div class="margin-form">
					<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'blockTestimonial'),$_smarty_tpl);?>
" name="submitConfig" class="button" />
                      			
				</div>
                     </table>
	      </fieldset>
          </form><br />

          <fieldset>
		  <legend>Backup Testimonials</legend>
                   <p><?php echo 'Use this to create backup of your testimonials in a CSV File.  This will create a file called backup.csv in this /modules/blocktestimonial directory';?>
</p>

 <form id="backupform" action="<?php echo $_smarty_tpl->tpl_vars['requestUri']->value;?>
" method="post" name="backupform" >
		  <input class="button" name="Backup" value="<?php echo 'Backup';?>
" type="submit" type="submit" style="width: 200px;"/>
		   <?php if ($_smarty_tpl->tpl_vars['backupfileExists']->value>0){?>
			<br><br> <span style="font-weight:bold"><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/blocktestimonial/backup.csv" > >>Download Backup File<< </a></span>
		  <?php }?>
		  </form>
              </fieldset>
			  <br />
              
<?php }} ?>