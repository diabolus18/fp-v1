<?php
  /**
   * $ModDesc
   *
   * @version   $Id: file.php $Revision
   * @package   modules
   * @subpackage  $Subpackage.
   * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
   * @license   GNU General Public License version 2
   */
  if( !class_exists('LofModalCartParams', false) ){
    class LofModalCartParams{
      public  $name   = '';
      public  $useed_texteditor   = false;
      protected $currentMod = null;

      /**
       * Constructor
       */
      public function LofModalCartParams( $current, $name, $configs){
        global $cookie;
        $this->currentMod = $current;
        $this->name = $name;

        foreach( $configs as $key => $config ){
          $d = Configuration::get( strtoupper($this->name.'_'.($key)) );
          $d = $d != ""? $d:$config;

          $this->_data[strtoupper($this->name.'_'.$key)] = $d ;
        }
      }
      /**
       * refreshConfig()
       */
      public function refreshConfig(){
        foreach( $this->_data as $key => $value ){
          $this->_data[$key] = Configuration::get( $key );
        }
        return $this;
      }

      /**
       * Get configuration's value
       */
      public function get( $name, $default="" ){
        $name = strtoupper($this->name.'_'.($name));
        if(isset($this->_data[$name])){
          return $this->_data[$name];
        }else{
          if(Configuration::get($name) != ''){
            $this->_data[$name] = Configuration::get($name);
            return Configuration::get($name);
          }elseif( isset($this->_data[$name]) ){
            return $this->_data[$name];
          }
        }
        return $default;
      }

      /**
       * Store configuration's value as temporary.
       */
      public function set( $key, $value ){
        $this->_data[$key] = $value;
      }

      /**
       * Delete configuration's name.
       */
      public function delete(){
        $res=true;
        if( !empty($this->_data) ){
          foreach( $this->_data as $key => $value ){
            $res &= Configuration::deleteByName( $key );
          }
        }
        return $res;
      }
      /**
       * Update value for single configuration.
       */
      public function update( $name ){
        $name = strtoupper($this->name.'_'.$name);
        Configuration::updateValue($name , Configuration::updateValue($name), true);
      }

      public function l( $lang ){
        return $this->currentMod->l( $lang );
      }

      /**
       * Update value for list of configurations.
       */
      public function batchUpdate( $configurations=array() ){
        $res = true;
        foreach( $configurations as $config => $key ){
          $v1 = Tools::getValue(strtoupper($this->name.'_'.$config), $key);
          $v = is_array($v1)?implode(',',$v1):$v1;

          $res &= Configuration::updateValue(strtoupper($this->name.'_'.$config), $v , true);
        }
        return $res;
      }

      public function inputTag( $label, $name, $value, $note="", $attrs='size="5"' ){
        $html = '
          <label>'.$this->l( $label ).'</label>
          <div class="margin-form">
            <input type="text" name="'.strtoupper($this->name.'_'.$name).'" id="'.$name.'" '.$attrs.' value="'.$value.'" /> '.$note.'
          </div>';
        return $html;
      }

      public function statusTag( $label, $name, $value, $id ){
        $html = '
          <label for="'.$name.'_on">'.$this->l($label ).'</label>
          <div class="margin-form">
            <img src="../img/admin/enabled.gif" alt="Yes" title="Yes" />
            <input type="radio" name="'.strtoupper($this->name.'_'.$name).'" id="'.$id.'_on" '.( $value == 1 ? 'checked="checked"' : '').' value="1" />
            <label class="t" for="'.$name.'_on">'.$this->l('Yes').'</label>
            <img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;" />
            <input type="radio" name="'.strtoupper($this->name.'_'.$name).'" id="'.$id.'_off" '.( $value == 0 ? 'checked="checked" ' : '').' value="0" />
            <label class="t" for="loop_off">'.$this->l('No').'</label>
          </div>';
        return $html;
      }
      private function getFieldName( $name ){
        return strtoupper( $this->name.'_'.$name );
      }

      public function inputTagDoubleColor( $label, $name, $value, $name1, $value1, $note="", $attrs='size="5"' ){
        Context::getContext()->controller->addJqueryPlugin(array('colorpicker'));
        $html = '
          <label>'.$this->l( $label ).'</label>
          <div class="margin-form">
           <input type="color" name="'.strtoupper($this->name.'_'.$name).'" id="'.$name.'" '.$attrs.' value="'.$value.'" class="color mColorPickerInput" data-hex="true"/>
           <br/>
           <input type="color" name="'.strtoupper($this->name.'_'.$name1).'" id="'.$name1.'" '.$attrs.' value="'.$value1.'" class="color mColorPickerInput" data-hex="true"/> '.$note.'
          </div>';
        return $html;
      }

      public function inputTagColor( $label, $name, $value, $note="", $attrs='size="5"' ){
        Context::getContext()->controller->addJqueryPlugin(array('colorpicker'));
        $html = '
          <label>'.$this->l( $label ).'</label>
          <div class="margin-form">
           <input type="color" name="'.strtoupper($this->name.'_'.$name).'" id="'.$name.'" '.$attrs.' value="'.$value.'" class="color mColorPickerInput" data-hex="true"/> '.$note.'
          </div>';
        return $html;
      }
      public function selectTag( $data, $label, $name, $value, $note='', $attrs='' ){
        $html = '<label for="'.$name.'">'.$this->l( $label ).'</label>
          <div class="margin-form">';
            $html .='<select name="'.$this->getFieldName($name).'" id="'.$name.'" '.$attrs.'>';
            foreach( $data as $key => $item ) {
              $selected = ($key == $value ) ? 'selected="selected"' : '';
              $html .= '<option value="'.$key.'" '. $selected .'>'.$item.'</option>';
            }
            $html .='</select>'.$note;
            $html .= '</div>';
        return $html;
      }

      public function textAreaTag( $label, $name, $values, $use_texteditor = true, $lang = false, $keysLang = '', $note='', $attrs='' ){
        $html = '';
        if($use_texteditor){
          if(!$this->useed_texteditor){
           Context::getContext()->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js');
            Context::getContext()->controller->addJS(__PS_BASE_URI__.'js/tinymce.inc.js');
            $isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.Context::getContext()->language->iso_code.'.js') ? Context::getContext()->language->iso_code : 'en');
            $ad = dirname($_SERVER["PHP_SELF"]);
            $html .= '<script type="text/javascript">
              var iso = \''.$isoTinyMCE.'\' ;
              var pathCSS = \''._THEME_CSS_DIR_.'\' ;
              var ad = \''.$ad.'\' ;
              tinySetup();
            </script>';
            $this->useed_texteditor = true;
          }
        }
        $html .= '<label for="'.$name.'">'.$this->l( $label ).'</label>
          <div class="margin-form">';
          if($lang){
            $languages = Language::getLanguages(false);
            $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
            foreach($languages as $language){
              $html .= '
                <div id="'.$name.'_'.$language['id_lang'].'" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . '; float: left;">
                  <textarea '.($use_texteditor ? 'class="rte"' : '').' cols="100" rows="20" name="'.$this->getFieldName($name).'_'.$language['id_lang'].'" '.$attrs.'>'.htmlentities($values[$language['id_lang']],ENT_QUOTES).'</textarea>
                </div>';
            }
            $html .= $this->currentMod->displayFlags($languages, $defaultLanguage, $keysLang, $name, true);
          }else{
            $html .= '<textarea '.($use_texteditor ? 'class="rte"' : '').' cols="100" rows="20" name="'.$this->getFieldName($name).'" '.$attrs.'>'.$values.'</textarea>';
          }
        $html .= '<div class="clear"></div>';
          $html .= $note;
        $html .= '</div>';
        return $html;
      }
    }
  }
?>
