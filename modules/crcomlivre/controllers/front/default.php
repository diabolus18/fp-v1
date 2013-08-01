<?php
class crcomlivreDefaultModuleFrontController extends ModuleFrontController {

public function initContent() 
	{
  		parent::initContent();
		
		global $cookie;global $smarty;
		//Process du formulaire d'ajout de commentaire
		if(Tools::isSubmit('bouton'))
			{
				$note=Tools::getValue('note');$id_customer=Tools::getValue('client');$titre=Tools::getValue('titre');$message=Tools::getValue('message');
				$livres=Db::getInstance()->	ExecuteS('insert into '._DB_PREFIX_.'livre (id_customer,titre,message,valid,date,note) values ('.$id_customer.',"'.$titre.'","'.$message.'",0,NOW(),'.$note.')');
				$smarty->assign('message','Votre commentaire a été prit en compte. Il doit être validé par un modérateur avant d\'apparaître.');
			}
				
		//Pagination des commentaires
		if(Tools::isSubmit('page_suivant')){Configuration::updateValue('PAGE',Configuration::get('PAGE')+1);}
		elseif(Tools::isSubmit('page_precedent')){Configuration::updateValue('PAGE',Configuration::get('PAGE')-1);}
		else{Configuration::updateValue('PAGE',1);}
		
		if(Tools::isSubmit('par_page')){Configuration::updateValue('PAR_PAGE',Tools::getValue('par_page'));}
		else{Configuration::updateValue('PAR_PAGE',10);}
					
		$par_page = Configuration::get('PAR_PAGE');$page=Configuration::get('PAGE');
		$limit_deb=($page - 1)*$par_page;
		Db::getInstance()->	ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1 order by date');
		$nbre_lignes=Db::getInstance()->NumRows();
		$nbre_pages=ceil($nbre_lignes/$par_page);
		//Fin pagination commentaires
		
		
		
		//Sélection des commentaires et envoi via Smarty
		$livres=Db::getInstance()->	ExecuteS('select * from '._DB_PREFIX_.'livre where valid=1 order by date desc limit '.$limit_deb.','.$par_page);
		$clients=Customer::getCustomers();
		$smarty->assign(array('livres'=>$livres,'clients'=>$clients,'page'=>$page,'par_page'=>$par_page,'nbre_pages'=>$nbre_pages,'invite'=>Configuration::get('INVITE')));
		
  		$this->setTemplate('index.tpl');
	}

}
?>