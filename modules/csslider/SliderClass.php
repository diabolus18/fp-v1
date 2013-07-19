<?php

class SliderClass extends ObjectModel
{
	public $id_slider;
	public $url;
	public $position;
	public $display;
	public $image;
	public $caption;
	public $video_type;
	public $video_id;
	public $thumb_width = 45;
	public $thumb_height = 45;
	
	
	public static $definition = array(
		'table' => 'csslider',
		'primary' => 'id_slider',
		'multilang' => true,
		'multilang_shop' => true,
		'fields' => array(
			// Lang fields
			'image' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
			'caption' =>			array('type' => self::TYPE_HTML, 'lang' => true, 'size' => 2255, 'validate' => 'isString'),
			'video_type' =>		array('type' => self::TYPE_INT,'lang' => true, 'validate' => 'isunsignedInt'),
			'video_id' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
			//Shop fields
			'url' => 	array('type' => self::TYPE_STRING,'shop' => true, 'validate' => 'isString', 'size' => 255),
			'position' =>		array('type' => self::TYPE_INT,'shop' => true, 'validate' => 'isunsignedInt'),
			'display'  => 		array('type' => self::TYPE_BOOL,'shop' => true),
		)
	);
	
	public	function __construct($id_tab = null, $id_lang = null, $id_shop = null)
	{
		
		parent::__construct($id_tab, $id_lang, $id_shop);
		Shop::addTableAssociation('csslider', array('type' => 'shop'));
		Shop::addTableAssociation('csslider_lang', array('type' => 'fk_shop'));
		if ($this->id)
		{
			$this->position = $this->getFieldShop('position');
			$this->display = $this->getFieldShop('display');
		}
	}
	
	public function getFieldShop($field)
	{
		$id_shop = (int)Context::getContext()->shop->id;
		$sql = 'SELECT ss.'.$field.' FROM '._DB_PREFIX_.'csslider s
		LEFT JOIN '._DB_PREFIX_.'csslider_shop ss ON (s.id_slider = ss.id_slider)
		WHERE s.id_slider = '.$this->id.' AND ss.id_shop = '.$id_shop.'';
		$position = Db::getInstance()->getValue($sql);
		return $position;
	}
	public function copyFromPost()
	{
		foreach ($_POST AS $key => $value)
			if (key_exists($key, $this) AND $key != 'id_'.$this->table)
				$this->{$key} = $value;

		if (sizeof($this->fieldsValidateLang))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages AS $language)
				foreach ($this->fieldsValidateLang AS $field => $validation)
					if (isset($_POST[$field.'_'.(int)($language['id_lang'])]))
						$this->{$field}[(int)($language['id_lang'])] = $_POST[$field.'_'.(int)($language['id_lang'])];
		}
	}
	
	public function add($autodate = true, $null_values = false)
	{
		parent::add($autodate, true);
		if (Shop::getContext() != Shop::CONTEXT_SHOP)
		{
			foreach (Shop::getContextListShopID() as $id_shop)
			{
				$this->updatePositionMax($id_shop);
				$this->updateInforImage($id_shop);
			}
		}
		else
		{
			$id_shop = (int)Context::getContext()->shop->id;
			$this->updatePositionMax($id_shop);
			$this->updateInforImage($id_shop);
		}
		
	}
	
	public function updatePositionMax($id_shop)
	{
		$result = (Db::getInstance()->Execute('
					UPDATE `'._DB_PREFIX_.'csslider_shop`
					SET `position`='.$this->getNextPosition($id_shop).'
					WHERE `id_shop` = '.$id_shop.' AND `id_slider`='.(int)($this->id)));
		return $result;
	}
	
	
	public static function getNextPosition($id_shop)
	{
		$max = Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'csslider_shop` WHERE '.($id_shop ? ' `id_shop` = '.$id_shop : '1').' ');
		return ($max ? $max : 0);
	}
	
	public static function getNextId()
	{
		$max = Db::getInstance()->getValue('SELECT MAX(id_slider) FROM `'._DB_PREFIX_.'csslider`');
		return ($max ? $max + 1 : 1);
	}
	public function updateInforImage($id_shop)
	{
		$slider_update = Db::getInstance()->getRow(
					'SELECT ss.* FROM `'._DB_PREFIX_.'csslider_lang` ss
					WHERE (ss.id_shop = '.(int)$id_shop.')
					AND ss.`id_slider` = '.(int)($this->id));
					$new_name = (int)($id_shop).'_'.$slider_update['image'];
					$sql = '
					UPDATE `'._DB_PREFIX_.'csslider_lang`
					SET `image` = \''.$new_name.'\'
					WHERE `id_shop` = '.$id_shop.' AND `id_slider` = '.(int)($this->id);
					$return &= Db::getInstance()->Execute($sql);
					copy(_PS_MODULE_DIR_.'csslider/images/'.$slider_update['image'],_PS_MODULE_DIR_.'csslider/images/'.$new_name);
					copy(_PS_MODULE_DIR_.'csslider/images/thumbs/'.$slider_update['image'],_PS_MODULE_DIR_.'csslider/images/thumbs/'.$new_name);
		return $return;
	}
	
	public function uploadImage($id_slider = null)
	{
		
		$errors = "";
		$languages = Language::getLanguages(false);
		foreach ($languages AS $language)
		{
			if (isset($_FILES['image_'.$language['id_lang']]) AND isset($_FILES['image_'.$language['id_lang']]['tmp_name']) AND !empty($_FILES['image_'.$language['id_lang']]['tmp_name']))
			{
				if ($er = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']], Tools::convertBytes(ini_get('upload_max_filesize'))))
				{
					$errors .= $er;
				}
				elseif ($dot_pos = strrpos($_FILES['image_'.$language['id_lang']]['name'],'.'))
				{
					$ext = substr($_FILES['image_'.$language['id_lang']]['name'], $dot_pos+1);
					$newname = ($id_slider ? $id_slider : $this->getNextId()).'_'.$language['id_lang'];
					if (!move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'],_PS_MODULE_DIR_.'csslider/images/'.$newname.'.'.$ext))
						$errors .= Tools::displayError('Error move uploaded file');
					else
					{
						$this->image[(int)($language['id_lang'])] = $newname.'.'.$ext;
						ImageManager::resize(_PS_MODULE_DIR_.'csslider/images/'.$newname.'.'.$ext, _PS_MODULE_DIR_.'csslider/images/thumbs/'.$newname.'.'.$ext, $this->thumb_width, $this->thumb_height);
					}
				}
			}
		}
		return ($errors != "" ? $errors : false);
	}
	
	public function validateController($htmlentities = true, $copy_post = false)
	{
		$errors = array();
		
		if( $error = $this->uploadImage($this->id_slider))
		{
			$errors[] = $error;
			return $errors;
		}
		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$field = "image";
		if (!$this->{$field} OR !sizeof($this->{$field}) OR ($this->{$field}[$defaultLanguage] !== '0' AND empty($this->{$field}[$defaultLanguage])))
			$errors[] = '<b>Image</b> '.Tools::displayError('is empty for default language.');

		$validate = new Validate();
		foreach ($this->fieldsValidateLang as $fieldArray => $method)
		{
			if (!is_array($this->{$fieldArray}))
				continue ;
			foreach ($this->{$fieldArray} as $k => $value)
				if (!method_exists($validate, $method))
					die (Tools::displayError('Validation function not found.').' '.Tools::safeOutput($method));
				elseif (!empty($value) AND !call_user_func(array('Validate', $method), $value))
				{
					$errors[] = Tools::displayError('The following field is invalid according to the validate method ').'<b>'.$method.'</b>:<br/> ('.self::displayFieldName($fieldArray, get_class($this), $htmlentities).' = '.$value.' '.Tools::displayError('for language').' '.$k;
				}
		}
		
		return $errors;
	}
	
	public function updatePosition($way, $position)
	{
		if (!isset($position))
			return false;
			$id = (int)Context::getContext()->shop->id;
			$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
			$slider_move = Db::getInstance()->getRow(
					'SELECT ss.* FROM `'._DB_PREFIX_.'csslider_shop` ss
					WHERE (ss.id_shop = '.(int)$id_shop.')
					AND ss.`id_slider` = '.(int)($this->id_slider));
			$result = (Db::getInstance()->Execute('
				UPDATE `'._DB_PREFIX_.'csslider_shop`
				SET `position`= `position` '.($way ? '- 1' : '+ 1').'
				WHERE `id_shop` = '.$id_shop.' AND `position`
				'.($way
					? '> '.(int)($slider_move['position']).' AND `position` <= '.(int)($position)
					: '< '.(int)($slider_move['position']).' AND `position` >= '.(int)($position)))
			AND Db::getInstance()->Execute('
				UPDATE `'._DB_PREFIX_.'csslider_shop`
				SET `position` = '.(int)($position).'
				WHERE `id_shop` = '.$id_shop.' AND `id_slider`='.(int)($this->id_slider)));
		return $result;
	}
	
	public function updateStatus($status)
	{
		
		$id = (int)Context::getContext()->shop->id;
		$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
		if (!isset($status))
			return false;
		if($status == 0)
			$status = 1;
		else 
			$status = 0;
		$result = (Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'csslider_shop`
			SET `display`='.$status.'
			WHERE `id_shop` = '.$id_shop.' AND `id_slider`='.(int)($this->id_slider)));
		return $result;
	}
	
	
	
	
	public static function cleanPositions()
	{
		$return = true;
		$id = (int)Context::getContext()->shop->id;
		$id_shop = $id ? $id: Configuration::get('PS_SHOP_DEFAULT');
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_slider`
		FROM `'._DB_PREFIX_.'csslider_shop`
		WHERE `id_shop` = '.$id_shop.'
		ORDER BY `position`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; $i++){
				$sql = '
				UPDATE `'._DB_PREFIX_.'csslider_shop`
				SET `position` = '.(int)($i).'
				WHERE `id_shop` = '.$id_shop.' AND `id_tab` = '.(int)($result[$i]['id_tab']);
				$return &= Db::getInstance()->Execute($sql);
			}
		return $return;
	}
}

?>
