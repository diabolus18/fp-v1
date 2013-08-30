<?php

class CrComLivre extends Module
{
	function __construct()
		{
			$this->name = 'crcomlivre';
			$this->tab = 'front_office_features';
			$this->version = '1.0';
			parent::__construct();
			$this->page = basename(__FILE__, '.php');
			$this->displayName = $this->l('Guestbook and Testimonials');
			$this->description = $this->l('Let your customers give their opinion on your store and your products');
		}
	function install()
		{
			if(!parent::install() OR !$this->registerHook('LeftColumn') OR !$this->registerHook('Header')
								OR !Db::getInstance()->Execute('CREATE TABLE '._DB_PREFIX_.'livre (`id` int(2) NOT NULL AUTO_INCREMENT, 
			`id_customer` INT(8) NOT NULL,`titre` varchar(255) NOT NULL,`note` INT(2) NOT NULL,`message` TEXT NOT NULL,`valid` int(2) NOT NULL, `date` DATE NOT NULL,PRIMARY KEY(`id`)) ENGINE='._MYSQL_ENGINE_.' default CHARSET=utf8'))
			return false;
			return true;
		}
	
	public function uninstall()
 		{
			if (!parent::uninstall()OR !Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'livre'))
			return false;
			return true;
 		}
	function PostProcess()
		{
			//Edition globale des commentaires déjà validés
			if(Tools::isSubmit('tout_editer'))
				{
					$listes=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1');
					foreach($listes as $liste)
						{
							Db::getInstance()->ExecuteS('update '._DB_PREFIX_.'livre set titre="'.Tools::getValue('titre2_'.$liste['id']).'",message="'.Tools::getValue('message2_'.$liste['id']).'",note='.Tools::getValue('note2_'.$liste['id']).' where id='.$liste['id']);
						}
					$this->output.=$this->displayConfirmation($this->l('All comments edited !'));	
				}
			
			//Process configuration client <-> Invité
			if(Tools::isSubmit('bout_1'))
				{
					Configuration::updateValue('INVITE',Tools::getValue('invite'));
					$this->output.=$this->displayConfirmation($this->l('Configuration updated !'));
				}
			
			$listes=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=0');
			foreach($listes as $liste)
				{
					//Suppression d'un commentaire à valider
					if(Tools::isSubmit('suppr_'.$liste['id']))
						{
							Db::getInstance()->ExecuteS('delete from '._DB_PREFIX_.'livre where id='.$liste['id']);
							$this->output.=$this->displayConfirmation($this->l('Comment deleted !'));
						}
					//Validation d'un commentaire
					if(Tools::isSubmit('add_'.$liste['id']))
						{
							$titre=Tools::getValue('titre_'.$liste['id']);$message=Tools::getValue('message_'.$liste['id']);
							$note=Tools::getValue('note_'.$liste['id']);
							Db::getInstance()->ExecuteS('update '._DB_PREFIX_.'livre set valid=1,titre="'.$titre.'",message="'.$message.'",note='.$note.' where id='.$liste['id']);
							$this->output.=$this->displayConfirmation($this->l('Comment validated !'));
						}
				}
			$listes2=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1');
			foreach($listes2 as $liste)
				{
					//Edition d'un commentaire déjà validé
					if(Tools::isSubmit('edit_'.$liste['id']))
						{
							$titre2=Tools::getValue('titre2_'.$liste['id']);$message2=Tools::getValue('message2_'.$liste['id']);
							$note2=Tools::getValue('note2_'.$liste['id']);
							Db::getInstance()->ExecuteS('update '._DB_PREFIX_.'livre set titre="'.$titre2.'",message="'.$message2.'",note='.$note2.' where id='.$liste['id']);
							$this->output.=$this->displayConfirmation($this->l('Comment edited !'));
						}
					//Suppression d'unn commentaire déjà validé
					if(Tools::isSubmit('suppr2_'.$liste['id']))
						{
							Db::getInstance()->ExecuteS('delete from '._DB_PREFIX_.'livre where id='.$liste['id']);
							$this->output.=$this->displayConfirmation($this->l('Comment deleted !'));
						}
				}
		}
	public function menu()
		{
			$this->output.="<script type='text/javascript'>
				function change_onglet(name)
					{
							document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
							document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
							document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
							document.getElementById('contenu_onglet_'+name).style.display = 'block';
							anc_onglet = name;
					}
				</script>";
			$this->output.='<link href="'._MODULE_DIR_.'crcomlivre/css/menu.css" rel="stylesheet" type="text/css" />
			<div class="systeme_onglets">
				<div class="onglets">
					<span class="onglet_0 onglet" id="onglet_parametres" onclick="javascript:change_onglet(\'parametres\');">'.$this->l('Settings').'</span>
					<span class="onglet_0 onglet" id="onglet_commentaires" onclick="javascript:change_onglet(\'commentaires\');">'.$this->l('Management comments validated').'</span>
				</div>';
			
		}
	function getcontent()
		{
			$this->output='';
			$this->PostProcess();
			$this->menu();
			
			//Début affichage des onglets
			$this->output.='<div class="contenu_onglets">';
			//Début affichage des onglets
			
			
			//Premier onglet modération des commentaires + configuration
			$this->output.='<div class="contenu_onglet" id="contenu_onglet_parametres">';
			//Affichage adresse (URL) de la page livre d'or
			$link = new Link();
       		$mon_lien=$link->getModuleLink('crcomlivre', 'default');
			$this->output.='<fieldset><legend>'.$this->l('Address of the guest book').'</legend>'.
							$this->l('The address of your guest book page is here:').'<br />
				<a href="'.$mon_lien.'" target="_blank">'.$mon_lien.'</a>
							</fieldset>';
			$this->output.='<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
				<fieldset style="margin-top:10px;"><legend>'.$this->l('Comment moderation').'</legend>
					'.$this->l('Below are the latest comments left on the shop you need moderate');
			$comments=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=0 order by id asc');
			$this->output.='<table class="table">
						<tr class="nodrag nodrop">
							<th>ID client</th>
							<th>Prénom/Nom du client</th>
							<th>Pseudo</th>
							<th>Note</th>
							<th>Message</th>
							<th>Action</th>
						</tr>';
			if(!empty($comments))
				{
					foreach($comments as $comment)
						{
							//Affichage des commentaires à valider pour les clients
							if($comment['id_customer']!=0)
								{
									$customer=new Customer($comment['id_customer']);
									$this->output.='<tr>
													<td class="center">'.$customer->id.'</td>
													<td class="center">'.$customer->firstname.' '.$customer->lastname.'</td>
													<td class="center"><input type="text" name="titre_'.$comment['id'].'" value="'.$comment['titre'].'" /></td>
													<td class="center"><input type="text" style="width:50px;" name="note_'.$comment['id'].'" value="'.$comment['note'].'" /></td>
													<td class="center"><textarea name="message_'.$comment['id'].'">'.$comment['message'].'</textarea></td>
													<td class="center">
														<input type="image" src="../img/admin/enabled.gif" name="add_'.$comment['id'].'" />&nbsp;
														<input type="image" src="../img/admin/delete.gif" name="suppr_'.$comment['id'].'" /></td>
												</tr>';
								}
							//Affichage des commentaires à valider pour les invités
							else
								{
									$this->output.='<tr>
													<td class="center">0</td>
													<td class="center">Invité</td>
													<td class="center"><input type="text" name="titre_'.$comment['id'].'" value="'.$comment['titre'].'" /></td>
													<td class="center"><input type="text" style="width:50px;" name="note_'.$comment['id'].'" value="'.$comment['note'].'" /></td>
													<td class="center"><textarea name="message_'.$comment['id'].'">'.$comment['message'].'</textarea></td>
													<td class="center">
														<input type="image" src="../img/admin/enabled.gif" name="add_'.$comment['id'].'" />&nbsp;
														<input type="image" src="../img/admin/delete.gif" name="suppr_'.$comment['id'].'" /></td>
												</tr>';
								}
						}
				}
			else
				{
					$this->output.='<tr><td colspan="5">'.$this->l('No comments Yet').'</td></tr>';
				}
			$this->output.='</table></fieldset>';
			//Autoriser les invités à poster des commentaires ou pas
			$invite=Configuration::get('INVITE');
			$this->output.='<fieldset style="margin-top:10px;"><legend>'.$this->l('Configuration').'</legend>
				'.$this->l('Allow guests to comment: ').'
				<img src="../img/admin/enabled.gif" /><input type="radio" name="invite" value="1"';if($invite==1)$this->output.='checked="checked"';$this->output.=' /> Oui&nbsp;
				<img src="../img/admin/disabled.gif" /><input type="radio" name="invite" value="0"';if($invite==0)$this->output.='checked="checked"';$this->output.=' /> Non
			<br /><br /><input type="submit" name="bout_1" value="Envoyer" class="button" />
			</fieldset>
			</form></div>';
			//Fin du premier Onglet configuration + modération des commentaires
			
			//Début deuxième onglet gestion des commentaires validés
			$comments=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1 order by id asc');
			$this->output.='<div class="contenu_onglet" id="contenu_onglet_commentaires">';
			$this->output.='<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
							<fieldset><legend>'.$this->l('management of comments already validated').'</legend>';
			$this->output.='<table class="table">
						<tr class="nodrag nodrop">
							<th>ID client</th>
							<th>Prénom/Nom du client</th>
							<th>Pseudo</th>
							<th>Note</th>
							<th>Message</th>
							<th>Action</th>
						</tr>';
			if(!empty($comments))
				{
					foreach($comments as $comment)
						{
							//Affichage des commentaires validés pour les clients
							if($comment['id_customer']!=0)
								{
									$customer=new Customer($comment['id_customer']);
									$this->output.='<tr>
													<td class="center">'.$customer->id.'</td>
													<td class="center">'.$customer->firstname.' '.$customer->lastname.'</td>
													<td class="center"><input type="text" name="titre2_'.$comment['id'].'" value="'.$comment['titre'].'" /></td>
													<td class="center"><input style="width:50px;" type="text" name="note2_'.$comment['id'].'" value="'.$comment['note'].'" /></td>
													<td class="center"><textarea name="message2_'.$comment['id'].'">'.$comment['message'].'</textarea></td>
													<td class="center">
														<input type="image" src="../img/admin/edit.gif" name="edit_'.$comment['id'].'" />&nbsp;
														<input type="image" src="../img/admin/delete.gif" name="suppr2_'.$comment['id'].'" /></td>
												</tr>';
								}
							//Affichage des commentaires validés pour les invités
							else
								{
									$this->output.='<tr>
													<td class="center">0</td>
													<td class="center">Invité</td>
													<td class="center"><input type="text" name="titre2_'.$comment['id'].'" value="'.$comment['titre'].'" /></td>
													<td class="center"><input type="text" style="width:50px;" name="note2_'.$comment['id'].'" value="'.$comment['note'].'" /></td>
													<td class="center"><textarea name="message2_'.$comment['id'].'">'.$comment['message'].'</textarea></td>
													<td class="center">
														<input type="image" src="../img/admin/edit.gif" name="edit_'.$comment['id'].'" />&nbsp;
														<input type="image" src="../img/admin/delete.gif" name="suppr2_'.$comment['id'].'" /></td>
												</tr>';
								}
						}
				}
			else
				{
					$this->output.='<tr><td colspan="5">'.$this->l('No comments Yet').'</td></tr>';
				}
			$this->output.='</table></fieldset>';
			$this->output.='<br /><input type="submit" name="tout_editer" Value="'.$this->l('Edit all').'" class="button" /></form>';
			$this->output.='</div>';
			//Fin deuxième onglet gestion des commentaires validés
			
			//Fin affichage des onglets
			$this->output.='</div>';
			
			//Script menu à onglets
			$this->output.='<script type="text/javascript">
        	//<!--
                var anc_onglet = \'parametres\';
                change_onglet(anc_onglet);
        	//-->
        	</script>';
			
			return $this->output;
		}
	function HookLeftColumn($params)
		{
			$link = new Link();
       		$mon_lien=$link->getModuleLink('crcomlivre', 'default');
			$comments=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1 order by date desc limit 2');
			$this->context->smarty->assign('commentaires',$comments);
			$this->context->smarty->assign('mon_lien',$mon_lien);
			
			return $this->display(__FILE__, 'crcomlivre.tpl');
			
		}
	function HookRightColumn($params)
		{
			return $this->HookLeftColumn($params);
		}
	function HookFooter($params)
		{
			return $this->HookLeftColumn($params);
		}	
	function HookHeader($params)
		{
			$this->context->controller->addCSS(($this->_path).'css/crcomlivre.css','all');
		}
}



?>


