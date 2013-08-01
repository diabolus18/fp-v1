<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 13:59:57
         compiled from "C:\wamp\www\fp-v1\modules\crcomlivre\views\templates\front\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1627951fa4dbd5ce242-65862779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e66f8aca9829cff43944f14296bd69d9948a753' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\crcomlivre\\views\\templates\\front\\index.tpl',
      1 => 1375356916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1627951fa4dbd5ce242-65862779',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'logged' => 0,
    'request_uri' => 0,
    'cookie' => 0,
    'invite' => 0,
    'livres' => 0,
    'page' => 0,
    'base_dir' => 0,
    'nbre_pages' => 0,
    'par_page' => 0,
    'livre' => 0,
    'clients' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa4dbd75dda0_69086575',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa4dbd75dda0_69086575')) {function content_51fa4dbd75dda0_69086575($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['message']->value)){?><p class="confirmation"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p><?php }?>
<h2><?php echo smartyTranslate(array('s'=>'Share your opinion on our site !','mod'=>'crcomlivre'),$_smarty_tpl);?>
</h2>
<p><?php echo smartyTranslate(array('s'=>'In this space, you can leave your testimonials and reviews on our site and products. This guestbook is for you!','mod'=>'crcomlivre'),$_smarty_tpl);?>
</p>

<?php if ($_smarty_tpl->tpl_vars['logged']->value){?>
    <div id="crcomlivre">
        <h2><?php echo smartyTranslate(array('s'=>'Add a new comment','mod'=>'crcomlivre'),$_smarty_tpl);?>
</h2>
        <form action="<?php echo $_smarty_tpl->tpl_vars['request_uri']->value;?>
" name="my_form" method="post">
            <input type="hidden" name="client" value="<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_customer;?>
" />
            <table>
                <tr>
                    <td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Message title','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                    <td><input type="text" name="titre" /></td>
                </tr>
                 <tr>
                    <td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Note','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                    <td><input type="text" name="note" style="width:50px;" /> /10</td>
                </tr>
                <tr>
                    <td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Your message','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                    <td><textarea name="message" rows="3" cols="30"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="bouton" value="<?php echo smartyTranslate(array('s'=>'Send','mod'=>'crcomlivre'),$_smarty_tpl);?>
" class="button" /></td>
                </tr>
            </table>    
        </form>
   	</div>
<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['invite']->value==0){?>
    <p class="error"><?php echo smartyTranslate(array('s'=>'You must be logged in to leave a message','mod'=>'crcomlivre'),$_smarty_tpl);?>
</p>
    <?php }else{ ?>
        <div id="crcomlivre">
            <h2><?php echo smartyTranslate(array('s'=>'Add a new comment','mod'=>'crcomlivre'),$_smarty_tpl);?>
</h2>
            <form action="<?php echo $_smarty_tpl->tpl_vars['request_uri']->value;?>
" name="my_form" method="post">
                <input type="hidden" name="client" value="0" />
                <table>
                    <tr>
                        <td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Message title','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                        <td><input type="text" name="titre" /></td>
                    </tr>
                    <tr>
                    	<td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Note','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                    	<td><input type="text" name="note" style="width:50px;" /> /10</td>
               		</tr>
                    <tr>
                        <td style="text-align:right"><?php echo smartyTranslate(array('s'=>'Your message','mod'=>'crcomlivre'),$_smarty_tpl);?>
</td>
                        <td><textarea name="message" rows="3" cols="30"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="bouton" value="<?php echo smartyTranslate(array('s'=>'Send','mod'=>'crcomlivre'),$_smarty_tpl);?>
" class="button" /></td>
                    </tr>
                </table>    
            </form>
      	</div>
    <?php }?>
    
<?php }?>

<div id="crcomlivre" style="margin-top:25px;">
    <h2><?php echo smartyTranslate(array('s'=>'Latest testimonials and Opinions','mod'=>'crcomlivre'),$_smarty_tpl);?>
</h2>
    
    <?php if (isset($_smarty_tpl->tpl_vars['livres']->value)&&!empty($_smarty_tpl->tpl_vars['livres']->value)){?>
        <form action="<?php echo $_smarty_tpl->tpl_vars['request_uri']->value;?>
" method="post" name="my_form_2">
            <?php if ($_smarty_tpl->tpl_vars['page']->value!=1){?><input style="margin:0" type="image" name="page_precedent" src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/crcomlivre/img/previous.gif" /><?php }?>&nbsp;<?php echo smartyTranslate(array('s'=>'Page number','mod'=>'crcomlivre'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
 <?php echo smartyTranslate(array('s'=>'of','mod'=>'crcomlivre'),$_smarty_tpl);?>
 <?php echo ceil($_smarty_tpl->tpl_vars['nbre_pages']->value);?>
&nbsp;
            <?php if ($_smarty_tpl->tpl_vars['page']->value<$_smarty_tpl->tpl_vars['nbre_pages']->value){?><input style="margin:0" type="image" name="page_suivant" src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/crcomlivre/img/next.gif" /><?php }?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo smartyTranslate(array('s'=>'Number of results per page','mod'=>'crcomlivre'),$_smarty_tpl);?>

            <select name="par_page" onChange='this.form.submit()'>
                <option value="10" <?php if (isset($_smarty_tpl->tpl_vars['par_page']->value)&&$_smarty_tpl->tpl_vars['par_page']->value==10){?>selected="selected"<?php }?>>10</option>
                <option value="20" <?php if (isset($_smarty_tpl->tpl_vars['par_page']->value)&&$_smarty_tpl->tpl_vars['par_page']->value==20){?>selected="selected"<?php }?>>20</option>
                <option value="50" <?php if (isset($_smarty_tpl->tpl_vars['par_page']->value)&&$_smarty_tpl->tpl_vars['par_page']->value==50){?>selected="selected"<?php }?>>50</option>
            </select>	
        </form>
        <?php  $_smarty_tpl->tpl_vars['livre'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['livre']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['livres']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['livre']->key => $_smarty_tpl->tpl_vars['livre']->value){
$_smarty_tpl->tpl_vars['livre']->_loop = true;
?>
            <div class="message">
            <?php echo smartyTranslate(array('s'=>'Date:','mod'=>'crcomlivre'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['livre']->value['date'];?>
<br  />
            <?php  $_smarty_tpl->tpl_vars['client'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['client']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['clients']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['client']->key => $_smarty_tpl->tpl_vars['client']->value){
$_smarty_tpl->tpl_vars['client']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['livre']->value['id_customer']==$_smarty_tpl->tpl_vars['client']->value['id_customer']&&$_smarty_tpl->tpl_vars['client']->value['id_customer']!=0){?>
                    <?php echo smartyTranslate(array('s'=>'Rating given by','mod'=>'crcomlivre'),$_smarty_tpl);?>
 <strong style="text-transform:capitalize"><?php echo $_smarty_tpl->tpl_vars['client']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['client']->value['lastname'];?>
</strong>
                <?php }?>
            <?php } ?>
            <?php if ($_smarty_tpl->tpl_vars['livre']->value['id_customer']==0){?>
                    <?php echo smartyTranslate(array('s'=>'Comment left by a guest','mod'=>'crcomlivre'),$_smarty_tpl);?>

                <?php }?>
                <br />
             <h4><?php echo $_smarty_tpl->tpl_vars['livre']->value['titre'];?>
</h4>
             <p>Note: <?php echo $_smarty_tpl->tpl_vars['livre']->value['note'];?>
/10</p>
                <div class="message_2"><?php echo $_smarty_tpl->tpl_vars['livre']->value['message'];?>
</div>
             </div>
        <?php } ?>
    <?php }else{ ?>
        <p><?php echo smartyTranslate(array('s'=>'There are no reviews yet','mod'=>'crcomlivre'),$_smarty_tpl);?>
</p>
    <?php }?>
</div><?php }} ?>