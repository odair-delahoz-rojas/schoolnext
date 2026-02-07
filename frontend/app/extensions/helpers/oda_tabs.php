<?php
/**
 * OdaTabs: Helper para crear TABS Odair.
 * 
 * @author  ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source  frontend\app\extensions\helpers\oda_tabs.php
 */


class OdaTabs {
  private $_orientacion = 'h';
  private $_tab_cnt = 0;
  private $_arrTabs = [];
  private $_arrContenido = [];

  public function __construct(
    private string $_attrs='w3-bar w3-theme w3-card',
  ) {
  }

  public function __toString(): string {
    return "<div class=\"w3-bar w3-theme w3-card\">"
          .$this->getTabs()
          ."</div>"
          .$this->getContenidos();
  }
  
  public function addTab(
    string $tabId, 
    string $tabCaption,
    string $tabContent,
    bool $show_index = false,
  ): void 
  {
    $this->_tab_cnt +=1;
    $display  = (1!=$this->_tab_cnt) ? "style=\"display:none\"" : '' ;
    $theme_act = (1==$this->_tab_cnt) ? "w3-theme-action" : '' ;
    $tabCaption = ($show_index) ? "$this->_tab_cnt. $tabCaption" : $tabCaption ;
    $this->_arrTabs[$this->_tab_cnt] = "<div class=\"w3-bar-item w3-mobile w3-button tablink $theme_act\" onclick=\"openTab(event,'$tabId')\">$tabCaption</div>";
    $this->_arrContenido[$this->_tab_cnt] = "<div id=\"$tabId\" class=\"tab w3-card-4 w3-padding w3-animate-opacity\" $display> $tabContent </div>";
  }

  public function getTabs(): string {
    $tabs = '';
    foreach ($this->_arrTabs as $tab_key => $tab) {
      $tabs .= $tab;
    }
    return $tabs;
  }

  public function getContenidos(): string {
    $contenidos = '';
    foreach ($this->_arrContenido as $cont_key => $conten) {
      $contenidos .= $conten;
    }
    return $contenidos;
  }

  public static function getJs() {
   return '
   <script>
    function openTab(evt,tabName) {
      var i, x, tablinks;
      x = document.getElementsByClassName("tab");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-theme-action", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " w3-theme-action";
    }
  </script>';
  }

} // END-OdaTabs