<?php
trait TraitUuid {
  

  public function UUIDReal(int $lenght=36): string 
  {
    if ($lenght <= parent::$_tam_uuid_max) {
      if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
      } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
      } else {
        throw new Exception("no cryptographically secure random function available");
      }
    } else {
      throw new Exception('lenght must be <= '.parent::$_tam_uuid_max);
    }
    return substr(bin2hex($bytes), 0, $lenght);
  }
 
  
  public function xxh3Hash($modulo=null): string 
  {
    $data = date('ymdhis').rand(1, 1000).(string)$modulo;
    $data = date('ymdhis').rand(1, 1000);
    return hash("xxh3", $data, options: ["seed" => rand(1, 1000)]);
  }


  public function setHash(): void 
  {
    $this->uuid = $this->xxh3Hash();
  }


  public function setUUID(int $lenght=20): void 
  {
    $this->uuid = $this->UUIDReal($lenght);
  }


  public static function getByUUID(string $uuid, string $fields = '*') 
  {
    $sql = "SELECT $fields FROM ".static::getSource().' WHERE uuid = ?';
    return static::query($sql, [$uuid])->fetch();
  }


  public static function deleteByUUID(string $uuid): bool 
  {
    $source  = static::getSource();
    return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
  }


}