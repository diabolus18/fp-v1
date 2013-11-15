<?php
  /**
   * Lof Modal Cart Module
   *
   * @version		$Id: file.php $Revision
   * @package		modules
   * @subpackage	$Subpackage.
   * @copyright	Copyright (C) June 2013 LeoTheme.Com <@emai:leotheme@gmail.com>.All rights reserved.
   * @license		GNU General Public License version 2
   */

  /**
   * @since 1.5.0
   * @version 1.0 (2013-06-20)
   */

  if (!defined('_PS_VERSION_'))
    exit;

    $this->_html .= '<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">';
    $this->_html .= '<fieldset><legend>
                      <img src="'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/logo.gif" alt="" /> '.$this->l('Modal Cart configurations').
                    '</legend>';

    $this->_html .= $params->inputTag( $this->l('Modal width:'), 'width', $this->getParams()->get('width'), 'px',' size="30" ' );

    $this->_html .= $params->inputTagDoubleColor( $this->l('Overlay color:'), 'overlay_color', $this->getParams()->get('overlay_color'), 'overlay_color1', $this->getParams()->get('overlay_color1'), '',' size="30" ' );

    $this->_html .= $params->inputTag( $this->l('Overlay opacity:'), 'overlay_opacity', $this->getParams()->get('overlay_opacity'), '%',' size="30" ' );

    $this->_html .= $params->inputTagColor( $this->l('Modal title color:'), 'title_color', $this->getParams()->get('title_color'), '',' size="30" ' );

    $this->_html .= $params->inputTag( $this->l('Modal title size:'), 'title_size', $this->getParams()->get('title_size'), 'px',' size="30" ' );

    $this->_html .= $params->inputTag( $this->l('Modal border:'), 'border', $this->getParams()->get('border'), 'px',' size="30" ' );
    //-------------
    $types = array(
      'solid'			=> $this->l('Border Solid'),
      'dotted'		=> $this->l('Border Dotted'),
      'dashed'		=> $this->l('Border Dashed'),
      'double'		=> $this->l('Border Double')
    );
    $this->_html .= $params->selectTag($types,$this->l('Modal border type:'),'border_type',$this->getParams()->get('border_type'),'');
    $this->_html .= $params->inputTagColor( $this->l('Modal border color:'), 'border_color', $this->getParams()->get('border_color'), '',' size="30" ' );
    //-------------
    $this->_html .= $params->inputTag( $this->l('Modal border radius:'), 'border_radius', $this->getParams()->get('border_radius'), 'px',' size="30" ' );

    //--------------selectTag summary type
    $types= array(
      '1' => $this->l('Last product added'),
      '2' => $this->l('Cart Summary'),
    );
    $this->_html .= $params->selectTag( $types, $this->l('Cart summary type:'), 'summary_type', $this->getParams()->get('summary_type'), '' );
    //--------------selectTag imageSize
    $images = array();
    $format = ImageType::getImagesTypes('products');
    foreach($format as $img){
      $images[$img['name']] = $img['name'].' ('.$img['width'].'x'.$img['height'].')';
    }
    $this->_html .= $params->selectTag( $images, $this->l('Image Size:'), 'image_size', $this->getParams()->get('image_size','home_default'));

    $this->_html .= $params->statusTag( $this->l('Show attributes:'), 'show_attribute', $this->getParams()->get('show_attribute',1), 'md_show_attribute' );
    //--------------selectTag Redirect
    $types= array(
      '1' => $this->l('Show all button'),
      '2' => $this->l('Show Order button'),
      '3' => $this->l('Show Shopping button'),
      '4' => $this->l('None button'),
    );
     $this->_html .= $params->selectTag( $types, $this->l('Order button redirect to:'), 'show_button', $this->getParams()->get('show_button'), '' );
    //--------------Text Editor For Above and Bellow
    $langs = Language::getLanguages(false);
    $values = array();
    $values1 = array();
    foreach( $langs  as $lang){
      $values[$lang['id_lang']] = $this->getParams()->get( 'display_above_'.$lang['id_lang'], '');
      $values1[$lang['id_lang']] = $this->getParams()->get( 'display_bellow_'.$lang['id_lang'], '');
    }
    $this->_html .= $params->textAreaTag( $this->l('Text to display above the modal content:'), 'display_above', $values, true, true, 'display_above','', 'cols="100" rows="20"' );
    $this->_html .= $params->textAreaTag( $this->l('Text to display below the modal content :'), 'display_bellow', $values1, true, true, 'display_bellow','', 'cols="100" rows="20"' );
    //------------------Text Editor for
    $this->_html .= '<br><br>';
    /* Save */
    $this->_html .= '
      <div class="margin-form">
        <input type="submit" class="button" name="saveModalConfig" value="'.$this->l('Save Changes').'" />
      </div>';
    $this->_html .= '</fieldset></form>';
?>
