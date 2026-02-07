<?php
/**
 * OdaTable: Helper para TABLAS Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_table.php
 */
class OdaTable {
   private string $tableHead    = '';
   private string $tableRows    = '';
   private string $tableFooter  = '';
   private string $tableCaption = '';
   private int    $body_counter = 0;
   const ICO_SEARCH_SMALL = '<i class="fa-solid fa-search w3-small"></i>';

   public function __construct(
      private string|array $_attrs='id="myTable" class="w3-table w3-responsive w3-striped w3-bordered"',
      private string $theme = '',
      private array $searchCol = [1],
      private bool $showTotalRegs = false,
   ) {
    //$this->theme = ($theme) ? $theme : Session::get('theme');
    $this->theme = Session::get('theme') ?? 'dark';
   }

   /**
    * Muestra la tabla
    */
   public function __toString() { 
      $total_regs = ($this->showTotalRegs) ? "<h5>Total Registros: $this->body_counter</h5>" : '' ;
      return "<div class=\"w3-container\"> $total_regs
               <table $this->_attrs>
                     $this->tableCaption
                     $this->tableHead
                     <tbody id=\"searchBody\">
                        $this->tableRows
                     </tbody>
                     $this->tableFooter
                  </table>
             </div>";
   }
   
   /**
    * Formatea el encabezado de la Tabla.
    *
    * @example echo $tabla->setableHead(
    *     data_head: ['Actions', 'Estudiante', 'Cambiar Salon'], 
    *     attrs:    'class="w3-theme"', 
    *     attrs_th:   ['style="width:10%;"','style="width:60%;"','style="width:30%;"']
    *  );
    */
   public function setHead(
      string|array $data_head = '', 
      string|array $attrs    = 'class="w3-theme"', 
      array        $arr_attrs_th = array()
   )
   {
      $data_head = str_replace('*', self::ICO_SEARCH_SMALL, $data_head) ;
      $attrs = self::getAttrs($attrs);

      $col_head = '';
      foreach (self::strToArray($data_head) as $key => $th) {
        $att_th = (array_key_exists($key, $arr_attrs_th)) ? $arr_attrs_th[$key] : '' ;
        $col_head .= "<th $att_th>".trim($th)."</th>";
      }
      $this->tableHead = "<tHead $attrs><tr>".$col_head.'</tr></tHead>';
      return $this;
   }

   
   /**
    * Añade una fila (row) al Body de la Tabla.
    *
    * @example echo $tabla->addRow(
            data: $data, 
            attrs_td: ['class="searchTdata w3-center"', 'class="searchTdata"']
         );
    */
    public function addRow (
      string|array $data, 
      string|array $attrs  = '', 
      string|array $attrs_td = [],
   )
   {
      $arr_data  = self::strToArray($data);
      $attrs = self::getAttrs($attrs);

      $this->body_counter +=1;
      $t = substr($this->theme, 0, 1);
      if (!$attrs) {
        $impar = ($t=='d')?'d4':'l5';
        $par   = ($t=='d')?'d1':'l1';
        $attrs = ($this->body_counter%2==0) ?  "class=\"item w3-theme-$par\"" :  "class=\"item w3-theme-$impar\"" ;
      }
      $this->tableRows.= "<tr $attrs>";
      foreach ($arr_data as $key => $td) {
         $atr2 = '';
         if ($attrs_td) {
            $atr2 = (array_key_exists($key, $attrs_td)) ? $attrs_td[$key] : '' ;
         }

         if (array_search($key, $this->searchCol)) {
            if (str_contains($atr2, 'class')) {
               $atr2 = str_replace('class="', 'class="searchTdata ', $atr2);
            } else {
               $atr2 .= ' class="searchTdata" ';
            }
         }
         
         $this->tableRows.= "<td $atr2>".$td.'</td>';
      }
      $this->tableRows.= '</tr>';
      return $this;
   }


   private function setColumnData(string $tdata, string $attr='') {
      //$this->searchCol
      return "<td $attr>".trim($tdata).'</td>';
   }

   /**
    * Formatea el pie de la Tabla.
    *
    * @example echo $tabla->setFoot(
         arr_foot: ['', 'Total: ', 100000], 
         attrs:    'class="w3-theme"'
      );
    */
   public function setFoot(string|array $arr_foot, string|array $attrs = '')
   {
      $foot = '';
      foreach (self::strToArray($arr_foot) as $td) {
         $foot .= "<td>".trim($td)."</td>";
      }
      $this->tableFooter = '<tfoot '.self::getAttrs($attrs).'><tr>'.$foot.'</tr></tfoot>';
      return $this;
   }

   /**
    * Establece la etiqueta CAPTION de la Tabla.
    * @example echo $tabla->setCaption(arr_foot: "Titulo de la tabla");
    */
   public function setCaption(
      string $caption, 
      string|array $attrs='class="w3-left-align w3-bottombar w3-border-blue"'
   )
   {
      $this->tableCaption = '<caption '.self::getAttrs($attrs).'><h3>'.$caption.'</h3></caption>';
      return $this;
   } // END-setCaption

   /**
    * crea múltiples tags html 
    */
   public static function multiTags(string|array $data, string $tag='span', string|array $attrs=''): string {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $tags='';
      foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
      return $tags;
   } // END-multiTags
   
   /**
    * Convierte un string separado por comas en un array.
    */
   public static function strToArray(string|array $params, string $separator=','):array {
      if (!is_string($params)) { return (array) $params; }
      return explode($separator, $params);
   } // END-strToArray

   /**
    * 
    */
   public static function getAttrs(string|array $params): string {
       if (!is_array($params)) { return (string)$params; }
       $data = '';
       foreach ($params as $k => $v) { $data .= "$k=\"$v\" "; }
       return trim($data);
   } // END-getAttrs
   
} // END-OdaTable