<?php

   $this->PhpExcel->createWorksheet();
   $this->PhpExcel->setDefaultFont('Calibri', 12);

   // define table cells
   $table = array(
      array('label' => __('Sukunimi'), 'width' => 'auto', 'filter' => true),
      array('label' => __('Etunimi'), 'width' => 'auto', 'filter' => true),
      array('label' => __('Osoite'), 'width' => 'auto'),
      array('label' => __('Sähköposti'), 'width' => 'auto', 'wrap' => true),
      array('label' => __('Puhelin'), 'width' => 'auto')
   );

   // heading
   $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

   // data
   foreach ($data as $d) {
      $this->PhpExcel->addTableRow(array(
         $d['Player']['lastname'],
         $d['Player']['firstname'],
         $d['Player']['address']. ", ".$d['Player']['postalcode']. " ". $d['Player']['postarea'],
         $d['Player']['email'],
         $d['Player']['phone']
      ));
   }

   $this->PhpExcel->addTableFooter();
   $this->PhpExcel->output();

?>