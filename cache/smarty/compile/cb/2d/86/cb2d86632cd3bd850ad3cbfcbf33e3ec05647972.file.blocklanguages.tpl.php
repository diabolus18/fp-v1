<?php /* Smarty version Smarty-3.1.13, created on 2013-08-30 17:24:13
         compiled from "C:\wamp\www\fp-v1\themes\bestchoice\modules\blocklanguages\blocklanguages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:163045220b91d55ebf6-89109997%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb2d86632cd3bd850ad3cbfcbf33e3ec05647972' => 
    array (
      0 => 'C:\\wamp\\www\\fp-v1\\themes\\bestchoice\\modules\\blocklanguages\\blocklanguages.tpl',
      1 => 1377693376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163045220b91d55ebf6-89109997',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'languages' => 0,
    'language' => 0,
    'lang_iso' => 0,
    'indice_lang' => 0,
    'lang_rewrite_urls' => 0,
    'link' => 0,
    'img_lang_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5220b91d5f29a4_76509595',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5220b91d5f29a4_76509595')) {function content_5220b91d5f29a4_76509595($_smarty_tpl) {?>

<!-- Block languages module -->
<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1){?>
<div id="languages_block_footer">
	<div id="countries">
	
		<p><?php echo smartyTranslate(array('s'=>"Languages:"),$_smarty_tpl);?>
</p>
		<ul id="first-languages" class="countries_ul">
		<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['language']->key;
?>
			<li <?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']==$_smarty_tpl->tpl_vars['lang_iso']->value){?>class="selected_language"<?php }?>>
			<?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']!=$_smarty_tpl->tpl_vars['lang_iso']->value){?>
				<?php $_smarty_tpl->tpl_vars['indice_lang'] = new Smarty_variable($_smarty_tpl->tpl_vars['language']->value['id_lang'], null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['lang_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value])){?>
					<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['lang_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
">
				<?php }else{ ?>
					<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getLanguageLink($_smarty_tpl->tpl_vars['language']->value['id_lang']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
">

				<?php }?>
			<?php }?>
			         <img src="<?php echo $_smarty_tpl->tpl_vars['img_lang_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
" width="40" height="20" />
					
					<!-- MISE EN COMMENTAIRE AFFICHAGE ISO CODE DE LA LANGUE
					<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>

					-->
			<?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']!=$_smarty_tpl->tpl_vars['lang_iso']->value){?>
				</a>
			<?php }?>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>
<?php }?>
<!-- /Block languages module -->
<?php }} ?>