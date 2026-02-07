/**
 * Modelo <?=$class?>
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  // ->create(array $data = []): bool {}
  // ->update(array $data = []): bool {}
  // ->save(array $data = []): bool {}
  // ::delete($pk): bool
  //
  // ::get($pk, $fields = '*')
  // ::all(string $sql = '', array $values = []): array
  // ::first(string $sql, array $values = []): static
  // ::filter(string $sql, array $values = []): array
*/
  
class <?=$class?> extends LiteRecord {

  use <?=$class?>TraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.<?=strtolower($class)?>');
    self::$_order_by_defa = 't.is_active DESC,t.nombre'; // 't.orden'
    $this->setUp();
  } //END-__construct


} //END-CLASS