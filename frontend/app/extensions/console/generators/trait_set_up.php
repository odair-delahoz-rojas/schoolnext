require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait <?=$class?>TraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function __toString() {
    return "$this->id - $this->nombre";
  }
 
  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set('error_validacion', $exception->getFullMessage());
      return false;
    }
  } //END-validar

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    self::$_fields_show = [
      'all'      => ['id', 'uuid', 'nombre', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'list'     => ['is_active', 'nombre', 'updated_at'],
      'create'   => ['nombre'],
      'edit'     => ['nombre', 'is_active'],
      'editUuid' => ['nombre', 'is_active'],
    ];
  
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
      'nombre'   => 'required maxlength="50"',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
    ];
  
    self::$_labels = [
      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];

  }
} //END-SetUp