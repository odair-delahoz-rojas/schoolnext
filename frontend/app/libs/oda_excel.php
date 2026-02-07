<?php 
// =======================================
// DOCUEMNTACIÓN:
// https://xlswriter-docs.viest.me/
// =======================================

class OdaExcel extends XLSXWriter {

  private function getFileName(string $name): string 
  {
    return 'files/download/'.$name.'.xlsx';
  }

  public function ejemplo1(): void 
  {
    $header = array(
      'c1-text'=>'string',//text
      'c2-text'=>'@',//text
      'c3-integer'=>'integer',
      'c4-integer'=>'0',
      'c5-price'=>'price',
      'c6-price'=>'#,##0.00',//custom
      'c7-date'=>'date',
      'c8-date'=>'YYYY-MM-DD',
    );
    $rows = array(
      array('x101',102,103,104,105,106,'2018-01-07','2018-01-08'),
      array('x201',202,203,204,205,206,'2018-02-07','2018-02-08'),
      array('x301',302,303,304,305,306,'2018-03-07','2018-03-08'),
      array('x401',402,403,404,405,406,'2018-04-07','2018-04-08'),
      array('x501',502,503,504,505,506,'2018-05-07','2018-05-08'),
      array('x601',602,603,604,605,606,'2018-06-07','2018-06-08'),
      array('x701',702,703,704,705,706,'2018-07-07','2018-07-08'),
    );
    
    $writer = new XLSXWriter();
    $writer->writeSheetHeader(sheet_name: 'Sheet1', header_types: $header);

    foreach($rows as $row) {
      $writer->writeSheetRow(sheet_name: 'Sheet1', row: $row);
    }
    
    //$writer->writeSheet($rows,'Sheet1', $header); //or write the whole sheet in 1 call
    $writer->writeToFile( filename: $this->getFileName(name: __FUNCTION__) );
    //$writer->writeToStdOut();
    //echo $writer->writeToString();

  } //END


  public function ejemplo2() {    
    $header = array(
      'year'=>'string',
      'month'=>'string',
      'amount'=>'price',
      'first_event'=>'datetime',
      'second_event'=>'date',
    );
    $data1 = array(
      array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00'),
      array('2003','=B2', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
      array('2003',"'=B2", '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
    );
    $data2 = array(
      array('2003','01','343.12','4000000000'),
      array('2003','02','345.12','2000000000'),
    );

    $writer = new XLSXWriter();
    $writer->writeSheetHeader(sheet_name: 'Sheet1', header_types: $header);
    foreach($data1 as $row)
    $writer->writeSheetRow(sheet_name: 'Sheet1', row: $row);
    foreach($data2 as $row)
    $writer->writeSheetRow(sheet_name: 'Sheet2', row: $row);

    $writer->writeToFile( filename: $this->getFileName(name: __FUNCTION__) );
    //$writer->writeToStdOut();
    //echo $writer->writeToString();
    //exit(0);
  }//END

  public function ejemplo3(): void {
    $writer = new XLSXWriter();
    $styles1 = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center', 'border'=>'left,right,top,bottom');
    $styles2 = array( ['font-size'=>6],['font-size'=>8],['font-size'=>10],['font-size'=>16] );
    $styles3 = array( ['font'=>'Arial'],['font'=>'Courier New'],['font'=>'Times New Roman'],['font'=>'Comic Sans MS']);
    $styles4 = array( ['font-style'=>'bold'],['font-style'=>'italic'],['font-style'=>'underline'],['font-style'=>'strikethrough']);
    $styles5 = array( ['color'=>'#f00'],['color'=>'#0f0'],['color'=>'#00f'],['color'=>'#666']);
    $styles6 = array( ['fill'=>'#ffc'],['fill'=>'#fcf'],['fill'=>'#ccf'],['fill'=>'#cff']);
    $styles7 = array( 'border'=>'left,right,top,bottom');
    $styles8 = array( ['halign'=>'left'],['halign'=>'right'],['halign'=>'center'],['halign'=>'none']);
    $styles9 = array( array(),['border'=>'left,top,bottom'],['border'=>'top,bottom'],['border'=>'top,bottom,right']);


    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles1 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles2 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles3 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles4 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles5 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles6 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles7 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles8 );
    $writer->writeSheetRow('Sheet1', $rowdata = array(300,234,456,789), $styles9 );

    $writer->writeToFile( $this->getFileName(name: __FUNCTION__) );
  }//END
  

} //END-OdaExcel

?>