<?php /* Smarty version Smarty-3.1.13, created on 2013-08-01 16:26:27
         compiled from "C:\wamp\www\fp-v1\modules\crcomlivre\crcomlivre.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1451751fa7013456039-15277207%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b894a2f837755e8685f2c2ec01c9d61d3f4a5bc' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\modules\\crcomlivre\\crcomlivre.tpl',
      1 => 1375356916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1451751fa7013456039-15277207',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'commentaires' => 0,
    'base_url' => 0,
    'commentaire' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51fa7013497270_83279119',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa7013497270_83279119')) {function content_51fa7013497270_83279119($_smarty_tpl) {?><div class="block">
	<h4>Derniers commentaires</h4>
   	<div class="block_content">
        <?php if (isset($_smarty_tpl->tpl_vars['commentaires']->value)&&!empty($_smarty_tpl->tpl_vars['commentaires']->value)){?>
            <?php  $_smarty_tpl->tpl_vars['commentaire'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['commentaire']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['commentaires']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['commentaire']->key => $_smarty_tpl->tpl_vars['commentaire']->value){
$_smarty_tpl->tpl_vars['commentaire']->_loop = true;
?>
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
modules/crcomlivre/temoignages.php"><?php echo $_smarty_tpl->tpl_vars['commentaire']->value['titre'];?>
</a></h5>
                    <p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['commentaire']->value['message'],30,'...',true);?>
</p>
            <?php } ?>
        <?php }else{ ?>
            <p><?php echo smartyTranslate(array('s'=>'No comments yet','mod'=>'crcomlivre'),$_smarty_tpl);?>
</p>
        <?php }?>
   	</div>
</div>
           <?php }} ?>