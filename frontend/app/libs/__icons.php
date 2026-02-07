<?php

/**
 * Helper para la gestión ICONOS.
 *
 * @category   SchoolNEXT
 * @package    Helpers
 */
class _Icons
{
  const SOLID = [ 
    'refresh', 'square-pen', 'plus', 'ban', 'check', 'xmark', 'trash-can', 'face-smile', 'face-frown', 
    'clover', 'coins', 'arrow-rotate-left', 'arrow-trend-up', 'arrow-up-right-from-square', 
    'arrow-down-short-wide', 'apple-whole', 'award', 'arrows-up-to-line', 'arrow-down-z-a', 
    'arrow-up-right-from-square', 'arrow-up-right-dots', 'arrow-right-from-bracket', 'atom', 
    'arrow-rotate-right', 'arrow-left', 'arrow-down-wide-short', 'arrows-to-dot', 'arrows-to-eye', 
    'arrow-right', 'arrow-right-to-bracket', 'arrow-trend-down', 'angles-up', 'angles-left', 'angles-down', 
    'angle-right', 'address-card', 'angle-left', 'arrows-down-to-line', 'angle-down', 'arrows-spin', 'arrow-up-short-wide', 
    'arrow-up-wide-short', 'address-book', 'angle-up', 'angles-right', 'arrows-spin', 'arrow-up-from-bracket', 
    'arrow-down-a-z', 'briefcase', 'bullseye', 'baby', 'book-open-reader', 'bell-slash', 'building', 'bars-progress', 
    'bars-staggered', 'bell', 'building-user', 'book-bookmark', 'box-archive', 'ban', 'book', 'bullhorn', 'business-time', 
    'book-open', 'bolt', 'certificate', 'cake-candles', 'children', 'chart-pie', 'circle-info', 'cloud-arrow-down', 
    'cloud-arrow-up', 'chart-simple', 'circle-question', 'calendar-days', 'circle-exclamation', 'computer', 'calculator', 
    'chalkboard-user', 'circle-nodes', 'clipboard-question', 'clipboard-user', 'copyright', 'clock-rotate-left', 'copy', 
    'compass', 'church', 'chart-line', 'clipboard', 'cubes', 'clone', 'cube', 'display', 'envelope-circle-check', 'envelope', 
    'exclamation', 'envelope-open', 'eye', 'eye-low-vision', 'eye-slash', 'file-circle-exclamation', 'file-circle-minus', 
    'folder', 'file-circle-xmark', 'floppy-disk', 'folder-tree', 'file-pen', 'folder-plus', 'file-circle-check', 'file', 
    'flag', 'folder-minus', 'file-circle-question', 'file-csv', 'file-shield', 'folder-open', 'file-pdf', 'file-circle-plus', 
    'graduation-cap', 'gear', 'globe', 'highlighter', 'headset', 'hotel', 'heart-circle-check', 'heart-circle-plus', 
    'hand-holding-hand', 'heart-circle-xmark', 'hammer', 'id-card', 'life-ring', 'laptop-code', 'landmark', 'list-check', 
    'laptop', 'laptop-file', 'lightbulb', 'mug-saucer', 'money-bills', 'masks-theater', 'mobile-screen', 'mobile-retro', 
    'magnifying-glass-chart', 'marker', 'money-bill-transfer', 'microscope', 'music', 'network-wired', 'person-circle-check', 
    'percent', 'person-digging', 'print', 'person-chalkboard', 'person-walking-arrow-right', 'person-walking', 'pen-to-square', 
    'people-group', 'person-arrow-down-to-line', 'phone', 'phone-volume', 'phone-slash', 'phone-flip', 'person-circle-xmark', 
    'pen-nib', 'people-arrows-left-right', 'paperclip', 'power-off', 'person', 'person-walking-luggage', 'people-roof', 
    'people-line', 'plane-up', 'person-circle-plus', 'person-arrow-up-from-line', 'plug', 'person-dress', 'person-circle-minus', 
    'question', 'ranking-star', 'radiation', 'registered', 'right-left', 'recycle', 'right-from-bracket', 'signature', 
    'shield-heart', 'square-phone', 'sack-dollar', 'search', 'shop', 'snowflake', 'suitcase-medical', 'syringe', 'share-from-square', 
    'splotch', 'school-circle-check', 'school-flag', 'shapes', 'school-circle-exclamation', 'school-circle-xmark', 'shuffle', 
    'sheet-plastic', 'scale-balanced', 'scissors', 'sun', 'school', 'truck', 'tarp', 'tower-broadcast', 'triangle-exclamation', 
    'tag', 'trash-can', 'tags', 'thumbtack', 'trademark', 'timeline', 'user-plus', 'user', 'user-tie', 'user-check', 'user-clock', 
    'user-gear', 'user-graduate', 'user-minus', 'users', 'users-between-lines', 'users-line', 'users-viewfinder', 'upload', 
    'users-rectangle', 'virus', 'virus-covid', 'wallet', 'wifi', 'wheelchair-move', 'xmarks-lines',
  ];
  const BRANDS = [ 
    'php', 'react', 'cc-mastercard', 'cc-diners-club', 'cc-visa', 'css3-alt', 'dropbox', 'edge', 'facebook', 'facebook-f', 'facebook-messenger', 'facebook-square', 'chrome', 'bluetooth', 'google-drive', 'html5', 'instagram', 'instagram-square', 'sketch', 'sith', 'skype', 'slack', 'superpowers', 'telegram', 'twitter', 'twitter-square', 'ubuntu', 'usb', 'whatsapp', 'whatsapp-square', 'xbox', 'yelp', 'youtube', 'youtube-square', 'wpexplorer', 'whmcs', 'unity', 'unsplash', 'think-peaks', 'sourcetree'
  ];
  
  
    /**
     * Crea un icono Font Awesome SOLID
     *
     * @example <?= _Icons::solid('flag', 'w3-small'); ?>
     *
     * @param string|null $icon: nombre del ícono solid
     * @param string|null $size: tamaño w3-tiny. w3-small, w3-large, w3-xlarge, w3-xxlarge, w3-xxxlarge, w3-jumbo]
     * 
     * @return string
     *
     */
    public static function solid($icon='snowflake', $size='w3-large') 
    {
      if ( empty($icon) ) 
      {
        return ''; 
      }

      return ((in_array($icon, self::SOLID, true)) ? 
        "<i class=\"fa-solid fa-$icon $size\"></i>" : 
        "<i class=\"fa-solid fa-snowflake $size\"></i>");
    }
    

    /**
     * Crea un icono Font Awesome BRANDS
     *
     * @example <?= _Icons::brands('php', 'w3-small'); ?>
     *
     * @param string|null $icon: nombre del ícono solid
     * @param string|null $size: tamaño w3-tiny. w3-small, w3-large, w3-xlarge, w3-xxlarge, w3-xxxlarge, w3-jumbo]
     * 
     * @return string
     *
     */
    public static function brands($icon='', $size='w3-large') {
      return ((in_array($icon, self::BRANDS, true)) ? "<i class=\"fa-brands fa-$icon $size\"></i>" : "<i class=\"fa-brands fa-sourcetree $size\"></i>");
    } // END-icon_brand
    
    
    public static function getAllIconsSolid() {
      $result = '<table>';
      $ICONS=OdaUtils::orderArray(self::SOLID,'0', 'ASC');
      $cadena = '';
      $anterior = '';
      foreach ($ICONS as $key => $icon) {
        
        if ($anterior==$icon) {
          $mark = '<span style="color:red">repetido</span>';
        } else {
          $mark = '';
          $cadena .= "'$icon', ";
        }
        $result .=  "<tr><td>$key</td><td>".self::solid($icon,'w3-xxlarge')."</td><td>$icon $mark</td></tr>";
        $anterior = $icon;
      }
      $result .=  "<tr><td></td><td>".self::solid('icono-que-no-existe')."</td><td><span style=\"color:red\">icono-que-no-existe</span></td></tr>";
      $result .= '</table>';
      $result .= str_repeat('<br>',3).$cadena;
      return $result;
    }

    public static function getAllIconsBrand() {
      $result = '<table>';
      $ICONS=OdaUtils::orderArray(self::BRANDS,'0', 'ASC');
      $cadena = '';
      $anterior = '';
      foreach ($ICONS as $key => $icon) {
        
        if ($anterior==$icon) {
          $mark = '<span style="color:red">repetido</span>';
        } else {
          $mark = '';
          $cadena .= "'$icon', ";
        }
        $result .=  "<tr><td>$key</td><td>".self::brands($icon,'w3-xxlarge')."</td><td>$icon $mark</td></tr>";
        $anterior = $icon;
      }
      $result .=  "<tr><td></td><td>".self::brands('icono-que-no-existe')."</td><td><span style=\"color:red\">icono-que-no-existe</span></td></tr>";
      $result .= '</table>';
      $result .= str_repeat('<br>',3).$cadena;
      return $result;
    }

    public static function getAleatorio($size='w3-large') {
      $tam = count(self::SOLID);
      $aleat = random_int(0,$tam-1);
      return self::solid(self::SOLID[$aleat], $size);
    }
};