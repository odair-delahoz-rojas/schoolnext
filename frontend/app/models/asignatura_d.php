<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
include "asignatura/asignatura_trait_props_d.php";
include "asignatura/asignatura_trait_set_up_d.php";

class Asignatura extends LiteRecord {
  public int $rowid; // int(11) AUTO_INCREMENT
	public string $ref; // varchar(128)
	public ?string $label; // varchar(255)
	public int $status; // Índice	int(11)
	public ?int $fk_area; // int(11)
	public ?int $orden; // int(11)
	public ?string $abreviatura; // varchar(10)

	private string $date_creation; //	datetime
	private ?string $tms; //timestamp current_timestamp()	ON UPDATE CURRENT_TIMESTAMP()
	private int $fk_user_creat; // int(11)
	private ?int $fk_user_modif; // int(11)
	private ?string $last_main_doc; // varchar(255)
	private ?string $import_key; // varchar(14)
	private ?string $model_pdf; // varchar(255)

  use AsignaturaTraitSetUpD;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.asignaturas_d');
    self::$pk = 'rowid';
    self::$_order_by_defa = 't.status DESC, t.fk_area, t.label';
    $this->setUp();
  }

  public function getList(
    int|bool $estado=null, 
    string|bool $select=null, 
    string|bool $order_by=null,
    string|bool $where = null,
    array|bool $params = [],
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select(select: 't.*, a.label AS area_nombre')
        ->leftJoin('area', 'a')
        ->orderBy(self::$_order_by_defa);

    if (!is_null($order_by)) {
      $DQL->orderBy($order_by);
    }
    if (!is_null($estado)) { 
      $DQL->where('t.status=?')
          ->setParams([$estado]);
    }
    return $DQL->execute();
  }




}