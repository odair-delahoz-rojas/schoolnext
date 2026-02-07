<?php
/**
  * Modelo
  * @category App
  * @package Models 
  */


#[AllowDynamicProperties]
class CargaProfesor extends LiteRecord
{
    protected static $table = 'sweb_salon_asignat_profesor';
    
    public function __toString(): string 
    { 
      return (string)$this->id;
    }

    
    public function getCarga($user_id) 
    {
      $DQL = "SELECT sap.*, s.grado_id, 
                s.nombre as salon, 
                a.nombre as asignatura, 
                CONCAT(u.nombres, ' ', u.apellido1, ' ', u.apellido2) as profesor,
                s.tot_estudiantes as tot_estud
                FROM ".self::$table." as sap
                    LEFT JOIN ".Config::get('tablas.salones')." as s ON sap.salon_id=s.id  
                    LEFT JOIN ".Config::get('tablas.asignaturas')." as a ON sap.asignatura_id=a.id
                    LEFT JOIN ".Config::get('tablas.grados')." as g ON s.grado_id=g.id
                    LEFT JOIN ".Config::get('tablas.usuarios')."  as u ON sap.user_id=u.id
                WHERE s.is_active=1";
      
      if ($user_id<>1) {
        $DQL .= " AND sap.user_id=$user_id";
      }

      $DQL .= " ORDER BY s.position, a.nombre";
      return $this::all($DQL);
    }

    
    public function getSalonesCarga($user_id): array 
    {
      $DQL = "SELECT salon_id FROM ".Config::get('tablas.salon_asignat_profe');
      
      if ($user_id<>1) {
        $DQL .= " WHERE user_id=$user_id ";
      }
      
      return $this::all($DQL);
    }

    
    public function getByPk($pk, $fields='*') 
    {
      return $this::get($pk, $fields = '*');
    }

    
    public function deleteByPk($pk): bool
    {
      if($this->is_active==1) {
        return false; 
      }
    
      return $this::delete($pk);
    }


}