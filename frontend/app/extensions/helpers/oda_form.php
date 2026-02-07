<?php
/**
 * Helper para Formularios Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_form.php
 */
class OdaForm extends Form {
   private $version = '2024.01.03';
   private $_style = ' class="w3-input w3-border" ';
   private $_modelo = '';
   private $_fname   = '';
   private $_faction = '';
   private $_fmethod = '';
   private $_fattrs = '';
   private $_fhiddens = '';
   private $_ffields = array(1=>' ', 2=>' ');
   private $_url_back = '';
   private $_isEdit = false;
   private $_isMultipart = false;
   private $_fields_in_form = [];
   const ICO_SEARCH = '<i class="fa-solid fa-search w3-large"></i>';
   const ICO_SEARCH_SMALL = '<i class="fa-solid fa-search w3-small"></i>';

   const METHOD = [
      'POST' => 'post',
      'GET'  => "get",
   ];

  /**
   * @example echo $myForm = new OdaForm('Grado', 'admin/grados/create', 2);
   * @source  frontend\app\extensions\helpers\odaodaform.php
   */
  public function __construct(object $modelo, string $action, string $method = self::METHOD['POST'], $cols=1, bool $multipart=false, string $url_back='') {
    $this->_modelo   = $modelo;
    $this->_fname    = strtolower(OdaUtils::pluralize($modelo::class));
    $this->_faction  = $action;
    $this->_fmethod  = $method;
    $this->_ffields  = match ($cols) {
        1 => [1=>' '],
        2 => [1=>' ', 2=>' '],
        3 => [1=>' ', 2=>' ', 3=>' '],
        default => [1=>' '],
    };
    $this->_isMultipart = $multipart;
    $this->_url_back = $url_back;
  } // END

  public function __toString(): string {
    $cols_max = array_key_last($this->_ffields);
    $data_sets = '';
    if ($cols_max==2) {
      $fielset1   = self::createFieldset($this->_ffields[1], 'Columna 1', ' style="width:90%" ');
      $data_sets .= OdaTags::tag('div', $fielset1, 'class="w3-half w3-container"');
      $fielset2   = self::createFieldset($this->_ffields[2], 'Columna 2', ' style="width:90%" ');
      $data_sets .= OdaTags::tag('div', $fielset2, 'class="w3-half w3-container"');         
    } else {
      $fieldset   = self::createFieldset($this->_ffields[1], 'Registro', ' style="width:50%" ');
      $data_sets .= OdaTags::tag('div', $fieldset, 'class="w3-col w3-container"');
    }
    $form  = $this->getOpenForm();
    $form .= self::getHiddens();
    $form .= OdaTags::tag('div', $data_sets, 'class="row w3-row"');
    $form .= "<div class=\"w3-padding w3-bar\">
              {$this::getSubmit()} {$this->getBtnBack()}
              </div>";
    $form .= self::close();
    return $form;
  } // END

  /**
   * @deprecated
   */
  public function getFields(string $legend_fieldset): string { 
    return self::getHiddens().self::createFieldset($this->_ffields[1], $legend_fieldset); 
  } // END

  /**
   * @example echo $myForm->addInput('cantidad', 2, 'number', 'w3-red');
   */
  public function addInput(string $field, int $columna=1, string|bool $tipo=null, string $attr='', bool $inline=false): void {
    $this->_ffields[$columna] .= '<br>'.$this->getInput($field, $tipo, $attr, $inline);
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
   */
  public function getInput(string $field, string|bool $tipo=null, string $attrs='', bool $inline=false): string {
    $this->_fields_in_form[] = $field;
    $attr = $this->_style . (($attrs) ? $attrs : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname = $this->_fname.'.'.trim($field);
    $label = $this->getLabel($field, $inline);
    $help = $this->getHelp($field);

    $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $widget = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
    $campo_input = $this::input($widget, $fieldname, $attr, $value);
    return ($tipo=='hidden') ? $campo_input : "<label> $label" .$campo_input .$help ."</label>";
  } // END

  /**
   * Retorna un campos Input dependiendo del "tipo".
   * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
   * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
   */
  // public function addInput2(string $field, int $columna=1, string|bool $tipo=null, string $attr='', bool $inline=true): void {
  //   $this->_fields_in_form[] = $field;
  //   $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
  //   $fieldname  = $this->_fname.'.'.trim($field);
  //   $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
  //   $label      = $this->getLabel($field, $inline);
  //   $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

  //   $campo_input = $this::input($widget, $fieldname, $attr, $value);
  //   $this->_ffields[(int)$columna] .= ($tipo=='hidden') ? $campo_input : "<label>$label" .$campo_input."</label>";
  //  } // END

  public function addFile(string $field, int $columna=1, string $attr='', bool $inline=false): void {
    $this->_ffields[$columna] .= '<br>'.$this->getFile($field, $attr, $inline);
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
   */
  public function getFile(string $field, string $attr='', bool $inline=false): string {
    $this->_fields_in_form[] = $field;
    $attr = ( (strlen($attr)>0) ? $attr : ('class="w3-input w3-border w3-hover-text-black"' . $this->getAttrib($field) .$this->getPlaceholder($field)) ) ;
    $fieldname = trim($field);
    $label = $this->getLabel($field, $inline);
    $help = $this->getHelp($field);
    $campo_file = $this::file($fieldname, $attr);
    return "<label> $label" .$campo_file .$help ."</label>";
  } // END


  /**
   * 
   */
  public function addFile2(string $field, int $columna=1, string $attr='', bool $inline=false): void {
    $this->_ffields[$columna] .= '<br>'.$this->getFile2($field, $attr, $inline);
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
   */
  public function getFile2(string $field, string $attr='', bool $inline=false): string {
    $this->_fields_in_form[] = $field;
    $attr = ( (strlen($attr)>0) ? $attr : ('class="w3-input w3-border w3-hover-text-black"' . $this->getAttrib($field) .$this->getPlaceholder($field)) ) ;
    $fieldname = $this->_fname.'.'.trim($field);
    $label = $this->getLabel($field, $inline);
    $help = $this->getHelp($field);
    $campo_file = $this::file($fieldname, $attr);
    return "<label> $label" .$campo_file .$help ."</label>";
  } // END


  /**
   * @example echo $myForm->addTextarea('descripcion', 2, 'w3-red');
   */
  public function addTextarea(string $field, int $columna=1, string $attr='', bool $inline=true): void {
    $this->_ffields[$columna] .= '<br>'.$this->getTextarea($field, $attr, $inline);
  } // END
  
  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea
   */
  public function getTextarea(string $field, string $attr='', $inline=true): string {
    $this->_fields_in_form[] = $field;
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = $this->_fname.'.'.trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $campo_textarea = $this::textarea($fieldname, $attr, $value);

    return "<label>$label" .$campo_textarea .$help ."</label>";
  } // END

  /**
   * Retorna un campo Select.
   * @example $myForm->addSelect(2, 'seccion_id', '1', 'w3-red');
   */
  public function addSelect(string $field, int $columna=1, array $data=[], string $attr=''): void {
    $this->_ffields[$columna] .= '<br>'.$this->getSelect($field, $data, $attr);
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select
   */
  public function getSelect(string $field, array $data=[], string $attr=''): string {
    $this->_fields_in_form[] = $field;
    $attr = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname = trim($this->_fname.'.'.$field);
    $label     = $this->getLabel($field);
    $help      = $this->getHelp($field);
    $value     = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;
    $campo_select = $this::select($fieldname, $data, $attr, $value);

    return "<label>$label $campo_select $help</label>";
  } // END

  public function addCheck(string $field, int $columna=1, string|array $attr=''): void {
    $this->_ffields[$columna] .= '<br>'.$this->getCheck($field, $attr);
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox
   */
  public function getCheck(string $field, string|array $attr=''): string {
    $this->_fields_in_form[] = $field;
    $fieldname  = trim($this->_fname.'.'.$field);
    $label = $this->getLabel($field, true);
    $help  = $this->getHelp($field);
    $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $value = ($value) ? 1 : 0 ;
    $is_checked = ($value) ? true : false ;
    $check = Form::check($fieldname, $value, $attr, $is_checked).'<br>'.$help;

    return "<label>$label $check</label><br>";
  } // END

  public function addRadio(string $field, int $columna=1, string|array $attrs='', bool $checked=false): void {
    $this->_ffields[$columna] .= $this->getRadio($field, $attrs, $checked);
  } // END

  /**
   * @link  https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/radio
   */
  public function getRadio(string $field, string|array $attrs='', bool $checked=false): string {
    $this->_fields_in_form[] = $field;
    $value_defa = ($this->_isEdit) ? $this->_modelo->$field : 1;
    $help  = $this->getHelp($field);
    $radio_group = '<div class="form-check w3-bar">';
    foreach ($this->getDefault($field) as $key_radio => $value_radio) {
      $checked = ($value_defa==$key_radio) ? true : false ;
      $radio_group .= "<div class=\"w3-bar-item\">$value_radio&nbsp;&nbsp;".Form::radio($field, $key_radio, $attrs, $checked).'</div>  ';
    }
    $radio_group .= '</div>'.$help;
    $label = $this->getLabel($field);
    $campo_radio = self::createFieldset($radio_group, $label);

    return '<br>'.$campo_radio;
  } // END

  /**
   * Establece el Formulario en modo Edición
   */
  public function setEdit(): void { 
    $this->_isEdit = true; 
  } // END
  
  public function setColumnas(int $max_cols=1): void { 
    $this->_ffields  = array_fill(1, $max_cols, ' '); 
  } // END
  
  public function setAtrib(string|array $attrs = ''): void { 
    $this->_fattrs = Tag::getAttrs($attrs); 
  } // END
  
  private function isRequired(string $field): bool { 
    return str_contains($this->_modelo->getAttrib($field), 'required'); 
  } // END

  private function getDefault(string $field) { 
    return (($this->_modelo->getDefault($field)) ? $this->_modelo->getDefault($field) : ''); 
  } // END

  public function getLabel(string $field, bool $inline=false): string {
    $requerido = ($this->isRequired($field)) ? '<i class="fa-solid fa-bolt"></i> ' : '' ;
    $in_line = ($inline) ? '' : '<br>' ;
    return (($this->_modelo->getLabel($field)) ? '<b>'.$requerido.$this->_modelo->getLabel($field).$in_line.'</b>' : OdaUtils::nombrePersona($field)) ;
  } // END

  public function getDataLabel(string $field, bool $inline=false): string {
    $in_line = ($inline) ? '' : '<br>' ;
    $label = (($this->_modelo->getLabel($field)) ? '<b>'.$this->_modelo->getLabel($field).$in_line.'</b>' : OdaUtils::nombrePersona($field)) ;
    $data = $this->_modelo->$field;
    return $label.$data;
  }

  public function getDataOnly(string $field): string {
    return (string) $this->_modelo->$field;
  }

  private function getHelp(string $field): string { 
    return (($this->_modelo->getHelp($field)) ? '<br/><i class="bi bi-question-circle"></i><i class="fa-solid fa-circle-info"></i> <small class="text-muted">'.$this->_modelo->getHelp($field).'</small>' : ''); 
  } // END

  private function getPlaceholder(string $field): string { 
    return (($this->_modelo->getPlaceholder($field)) ? ' placeholder="'.$this->_modelo->getPlaceholder($field).'" ' : '') ; 
  } // END

  private function getAttrib(string $field): string { 
    return (($this->_modelo->getAttrib($field)) ? ' '.$this->_modelo->getAttrib($field).' ' : ''); 
  } // END

  private function getWidget(string $field) { 
    return (($this->_modelo->getWidget($field)) ? $this->_modelo->getWidget($field) : 'text'); 
  } // END
  
  public function addHiddens(string $fields='id'): void { 
    $this->_fhiddens = str_replace(' ', '', $fields); 
  } // END

  public function getHiddens(): string {
    $result = '';
    foreach (explode(',',$this->_fhiddens) as $campo) {
      $value_input = ($this->_isEdit) ? $this->_modelo->$campo : $this->getDefault($campo) ;
      $result .= form::hidden($this->_fname.'.'.trim($campo), '', $value_input);
    }
    return $result;
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
   */
  public static function inputSearch(string $input_search_id='inputSearch', string $table_id='mytable', string $placeholder="Filtrar"): string {
    $input = self::input(
      type: 'search', 
      field: $input_search_id, 
      attrs: "oninput=\"myFunctionFilter()\" class=\"w3-input w3-border\"  placeholder=\"$placeholder..\""
    );
    return  
       "<div class=\"w3-bar\">
          <div class=\"w3-bar-item\">".self::ICO_SEARCH."</div>
          <div class=\"w3-bar-item\">$input</div>
        </div>";
  } // END

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/fieldset
   **/
  private static function createFieldset(string $content, string $legend = '', $attrs = ''): string { 
    return "<fieldset $attrs> <legend>$legend</legend> $content </fieldset>"; 
  } // END

  /**
   * Devuelve el HTML de la apertura del formulario.
   **/
  public function getOpenForm(): string {
    if ($this->_isMultipart)
    { 
      return self::openMultipart($this->_faction, $this->_fattrs); 
    }
    return self::open($this->_faction, $this->_fmethod, $this->_fattrs);
  } //END

  public function getBtnBack(string $attrs = 'class="w3-button"'): string {
    return (($this->_url_back) ? OdaTags::linkButton(action: "$this->_url_back", text: 'Volver', attrs: $attrs) : '');
  }
  
  private static function getSubmit($attrs='class="w3-button"'): string {
    return form::submit('Guardar', $attrs);
  }

  public function getFieldsInForm(): array { 
    return $this->_fields_in_form; 
  } // END
  
  public function getFieldsNotInForm(string $tipo_form='edit'): array { 
    return array_diff($this->_modelo::getFieldsShow($tipo_form), $this->getFieldsInForm() ); 
  } // END

  public function v(): string {
    $version = \DateTime::createFromFormat(format: 'Y.m.d', datetime: $this->version);
    return 'PHP Helper OdaForm -> Version '.$version->format(format: 'd M Y');
  }//END
  
} // END-Class