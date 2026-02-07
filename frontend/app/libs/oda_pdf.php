<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @category   Kumbia
 * @package    Core
 *
 * @copyright  Copyright (c) 2005 - 2021 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    https://github.com/KumbiaPHP/KumbiaPHP/blob/master/LICENSE   New BSD License
 */

#[\Deprecated(message: "use mpdf")]
class OdaPdf extends Fpdf
{
  public function __construct(
    $orientation = 'P',
    $unit = 'mm',
    $size = 'letter'
  ) {
    parent::__construct( $orientation, $unit, $size );
  }

function Header() {
    $this->Image(ABS_PUBLIC_PATH.'/img/logo.png',10,8,33);
    $this->SetFont('Arial','B',15);
    $this->Cell(80);
    $this->Cell(30,10,'Title',1,0,'C');
    $this->Ln(20);
}

function Footer()
{
    $this->SetY(-15); // Posición: a 1,5 cm del final
    $this->SetFont('Arial','I',8); // Arial italic 8
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C'); // Número de página
}

}
// END-CLASS-OdaPdf
