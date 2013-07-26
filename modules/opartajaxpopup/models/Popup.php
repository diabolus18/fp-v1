<?php
class Popup  extends ObjectModel
{
 	/** @var string Name */	
	public $width;
	public $height;
	public $responsive;
	public $title;
	public $code;
	
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'opartajaxpopup',
		'primary' => 'id_opartajaxpopup',
		'multilang' => true,
		'fields' => array(				
			'width' => 	array('type' => self::TYPE_INT, 'validate'=>'isInt','required' => true),
			'height' => array('type' => self::TYPE_INT, 'validate'=>'isInt','required' => true),
			'responsive' => array('type' => self::TYPE_INT, 'valide'=>'isInt','required' => true),
			// Lang fields
			'title' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
			'code' => 	array('type' => self::TYPE_HTML, 'lang' => true, 'validate'=> 'isString', 'size' => 3999999999999,'required' => true, )
		),
	);
}