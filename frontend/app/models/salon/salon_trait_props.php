<?php

trait SalonTraitProps {
 
  public function __toString() { return $this->nombre; } 

  public function isDirector(int $user_id): bool { 
    return (false !== ( (new Salon)::first('Select t.id from sweb_salones as t where t.director_id=? or t.codirector_id=?', [$user_id, $user_id]) ) );
  } //END-isDirector
  
  public function getImgFirmaDirector(string $attrs="style=\"width:100%;max-width:180px\""): string { 
    $Director = (new Usuario)::get($this->director_id??0);
    $filename = $Director->documento."_firma.png";
    return OdaTags::img(src: "upload/users/$filename", alt: 'firma', attrs: $attrs , err_message: "");
  }

  public function getNombreDirector(): string { 
    return (new Usuario)::get($this->director_id??0);
  }

  public static function getSalonesArray() { 
    $arrResult = [];
    foreach ((new Salon())->getList(1) as $salon) { $arrResult[$salon->id] = $salon->nombre; }
    return $arrResult;
  } //END-getSalonesArray


  public static function getSelectSalones(string $id, string $name, int $salon_selected_id=0): string { 
    $opts = '';
    $grado_ant = 0;
    foreach ((new Salon())->getList(1) as $key => $salon) {
      if ($salon->grado_id <> $grado_ant) {
        $opts .= ((0==$key) ? "<optgroup label=\"$salon->grado_nombre\">" : "</optgroup><optgroup label=\"$salon->grado_nombre\">");
      }
      $salon_sel = ($salon->id == $salon_selected_id) ? 'selected' : '' ;
      $opts .= "<option value=\"$salon->id\" $salon_sel>$salon->nombre</option>";
      $grado_ant = $salon->grado_id;
    }
    return "<select id=\"$id\" name=\"$name\"  class=\"w3-input w3-border\">$opts</select>";
  } //END-getSelectSalones


} //END-Trait