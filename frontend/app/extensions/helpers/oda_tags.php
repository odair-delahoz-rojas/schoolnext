<?php

class OdaTags {
  
  public static function js_module($src, $cache = TRUE): string { // Incluye un archivo javascript
    $src = "javascript/$src.js";
    if (!$cache) {
      $src .= '?nocache=' . uniqid();
    }
    return '<script src="'.PUBLIC_PATH.$src.'"  type="module"></script>';
  } //END-js_module

  /**
  * @deprecated usar OdaTags::tag
  */
  public static function createTag(string $tag, string|null $content = null, string|array $attrs = ''): string {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    if (is_null($content)) { return "<$tag $attrs/>"; }
    return "<$tag $attrs>$content</$tag>";
  } //END-createTag
   
  public static function tag(string $tag, string|null $content = null, string|array $attrs = ''): string {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    if (is_null($content)) { return "<$tag $attrs/>"; }
    return "<$tag $attrs>$content</$tag>";
  }

  public static function Badges(string|null $caption, string|int $value, $color =''): string 
  {
    return "<span class=\"w3-bar-item w3-tag w3-small w3-$color w3-round w3-margin-right\">
                $caption <span class=\"w3-badge w3-white w3-margin-left\">$value</span> 
           </span>";
  }

  public static function multiTags( $tag='span', $data=array(), $attrs='' ) {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    $tags='';
    foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
    return $tags;
  } // END-multiTags

   public static function getAttrs($params) {
     if (!is_array($params)) { return (string)$params; }
     $data = '';
     foreach ($params as $k => $v) {
       $data .= "$k=\"$v\" ";
     }
     return trim($data);
   } // END-getAttrs

   public static function link($action='', $text='Inicio', $attrs = '') {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    return '<a href="'.PUBLIC_PATH."$action\" $attrs>$text</a>";
   } // END-link
   
   public static function linkBarItem($action, $text, $icon='home') { 
    return '<span class="w3-bar-item w3-hover-blue">'
        ._Icons::solid($icon, "w3-large").'&nbsp;'
        .self::link($action, $text)
      .'</span>';
  } // END-linkBarItem

  public static function linkExterno($url, $text, $attrs = '') {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    return "<a href=\"$url\" $attrs  target=\"_blank\">$text</a>";
  } // END-linkExterno

  public static function linkButton($action, $text, $icon='', $attrs = 'class="w3-button w3-green"') { 
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    return self::link($action, _Icons::solid($icon).'&nbsp;'.$text, $attrs);
  } // END-linkButton

  public static function linkIcon($action='', $icon='', $attr='') {
    return self::link($action, _Icons::solid($icon), $attr).'&nbsp;';
  } // END-linkIcon

  public static function linkBC($action, $text) {  // link Breadcrumb
    return '&nbsp;'._Icons::solid('angles-right', "w3-small").'&nbsp;'
      .self::link($action, $text, "title=\"Volver a $text\"");
  } // END-linkBC
  
  public static function img($src, $alt = '', $attrs = '', $err_message='no image') 
  {
    if (!file_exists(ABS_PUBLIC_PATH."/img/$src")) 
    {
      return $err_message;
    }
    return '<img src="'.PUBLIC_PATH."img/$src\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
  }

  public static function img_source($src, $alt = '', $attrs = '', $err_message='no image') 
  {
    return ABS_PUBLIC_PATH."/img/$src";
  }

  public static function fileimg($src, $alt = '', $attrs = '', $err_message='no image') {
    if (!file_exists(ABS_PUBLIC_PATH."/files/upload/$src")) {
     return $err_message;
    }
    return '<img src="'.PUBLIC_PATH."files/upload/$src\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
  } // END-fileimg

  /**
   * @deprecated No Usar
   */
  public static function img_estudiante($estudiante_id, $sexo='', $alt = '', $attrs = '') {
    if (!file_exists(ABS_PUBLIC_PATH."/img/upload/estudiantes/$estudiante_id.png")) {
    $file_name = 'user'.(($sexo) ? '_'.strtolower(substr($sexo,0,1)) : '');
    return '<img src="'.PUBLIC_PATH."img/upload/estudiantes/$file_name.png\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
    }
    return '<img src="'.PUBLIC_PATH."img/upload/estudiantes/$estudiante_id.png\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
  } // END-img_estudiante

  /**
   * @deprecated No Usar
   */
  public static function img_docente($user_doc, $sexo='', $alt = '', $attrs = '') {
    if (!file_exists(ABS_PUBLIC_PATH."/img/upload/users/$user_doc.png")) {
    $file_name = 'user'.(($sexo) ? '_'.strtolower(substr($sexo,0,1)) : '');
    return '<img src="'.PUBLIC_PATH."img/upload/users/$file_name.png\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
    }
    return '<img src="'.PUBLIC_PATH."img/upload/users/$user_doc.png\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
  } // END-img_docente

   // HELPERS PARA LISTS
   public static function list($array, $type = 'ul', $attrs = 'class="w3-ul w3-card-4 w3-hoverable"') {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    $list = "<$type $attrs>".PHP_EOL;
    foreach ($array as $item) { $list .= "<li>$item</li>".PHP_EOL; }
    return "$list</$type>".PHP_EOL;
   }
 
  /**
   * @source https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML/Advanced_text_formatting
   */
  public static function dlist(array $arr_description, array|string $attrs = 'class="w3-ul w3-card-4 w3-hoverable"') {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    $type = 'dl';

    $list = "<$type $attrs>".PHP_EOL;
    foreach ($arr_description as $term => $definition) { 
      $list .= "<dt>$term</dt><dd>$definition</dd>".PHP_EOL; 
    }
    return "$list</>".PHP_EOL;
  } //END-

  public static function meter($nivel, $titulo='', $rango=array(33,66,80)){
    return "<label>$titulo:
     <meter
         min=\"0\" max=\"100\"
         low=\"$rango[0]\" high=\"$rango[1]\" optimum=\"$rango[2]\"
         value=\"$nivel\">
      $nivel/100
     </meter>
    </label>".PHP_EOL;
  } //END-meter

  /**
   * @deprecated No Usar
   */
  public static function tooltip(string $text, string $tip){
    return '<span class="w3-tooltip">'.$text.'<span style="position:absolute;left:0;bottom:18px" class="w3-text w3-tag">'.$tip.'</span></span>';
  } //END-tooltip

  public static function quarter($titulo, $valor, $link=null, $icon=null) {
    return "<div class=\"w3-quarter w3-padding w3-center\">
        <div class=\"w3-card w3-container w3-round-large w3-theme-l3 w3-hover-theme\">
          <header class=\"w3-container\">
          <h4 class=\"w3-left\">$titulo</h>
          </header>
          <p class=\"w3-left\">$icon</p>
          <h3 class=\"w3-right w3-xxxlarge\">$valor</h3>
          <footer class=\"w3-container\">
          <h5 class=\"w3-\">$link</h5>
          </footer>
        </div>
      </div>";
  } //END-quarter

  public static function buttonBars(array $arrButtons=[]) {
    $btns = '';
    foreach ($arrButtons as $key => $button) {
      $btns .= "<div class=\"w3-bar-item\"><button id=\"btn-$key\" class=\"w3-button w3-theme\" onclick=\"".$button['action']."\">".$button['caption']."</button></div>";
    }
    return "<div class=\"w3-bar\">$btns</div>";
  } //END-

  public static function dataList(string $id='list', $arrValores=[]) {
    $opts = '';
    foreach ($arrValores as $key => $value) { 
      $opts .= "<option value=\"$value\"></option>"; 
    }
    return "<datalist id=\"$id\">$opts</datalist>";
  } //END-dataList

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/range
   */
  public static function inputRango(string $id_name, string $caption='', int $value=0, int $min=0, int $max=100, int $step=1) {
  return ($min<=$value && $value<=$max) ?
      "<input type=\"range\" id=\"range_$id_name\" name=\"range\" min=\"$min\" max=\"$max\" value=\"$value\" step=\"$step\">"
       : "inputRange : valor fuera de rango" ;
  } //END-inputRango

  public static function inputRangoJs ($range_id) {
  return 
  "const rangeD = document.getElementById(\"range_$range_id\");
   const valorD = document.getElementById(\"notas_definitiva_$range_id\");
   const rangePA = document.getElementById(\"range_$range_id\");
   const valorPA = document.getElementById(\"notas_plan_apoyo_$range_id\");
   const rangeNF = document.getElementById(\"range_$range_id\");
   const valorNF = document.getElementById(\"notas_nota_final_$range_id\");
  
  rangeD.addEventListener('input', (event) => {
    valorD.value = event.target.value;
  });
  rangePA.addEventListener('input', (event) => {
    valorPA.value = event.target.value;
  });
  rangeNF.addEventListener('input', (event) => {
    valorNF.value = event.target.value;
  });
  ";
  }
  
 /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details
  */
  public static function detailsTag(string $summary, string $contenido, $attrs ='class="w3-padding"'): string { 
    return "<details $attrs>
    <summary>$summary</summary>
    $contenido
    </details>";
  } //END-detailsTag
  
  public static function card(string $header, string $contenido, $footer, $attrs = ['class="w3-container w3-blue"', 'class="w3-container"', 'class="w3-container w3-pale-green"']): string { 
    return "
      <div class=\"w3-card\">
        <header $attrs[0]>$header</header>
        <div $attrs[1]>$contenido</div>
        <footer $attrs[2]>$footer</footer>
  </div>";
  }


} // END-OdaTag