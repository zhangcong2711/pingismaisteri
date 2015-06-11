<?php

App::import('Vendor', 'PHPExcel/Classes/PHPExcel');

class FilesController extends AppController {

   public $helpers = array('Html', 'Form', 'PHPExcel');
   
   public $uses = array('Player', 'Tournament', 'TournamentClass', 'Club');
   
   function beforeFilter() {
      parent::beforeFilter();
   }
   
   function test()
   {
      $this->set( "data", $this->Player->find("all") );
   }
   
   function readRatingFile()
   {
       if ($this->request->is('post'))
	   {
	      $file = $this->request->data['RatingFile']['UploadedFile'];
		  //tarkista saatu array, errorit, typessä exel pääte
		  $type = array (
		  "application/vnd.ms-excel",
		  "application/msexcel",
		  "application/x-msexcel",
		  "application/x-ms-excel",
		  "application/x-excel",
		  "application/x-dos_ms_excel",
		  "application/xls",
		  "application/x-xls");
		  
		if (in_array($file['type'], $type)  && ($file['error'] == 0) )
			{
				$inputFileName = $file['tmp_name'];
				$sheetname = 'Rating järjestys';
				
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			  
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objReader->setReadDataOnly(true);
			    $objReader->setLoadSheetsOnly($sheetname);
			    $objPHPExcel = $objReader->load($inputFileName);
			  
			    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            

            //pr( $sheetData );
			}
			
			FilesController::writeToDb($sheetData);
		}
   }
   
   function writeToDb($sheetData)
   {
	  $players = $this->Player->find('all', array( 
	  'fields' => array('Player.id', 'Player.firstName', 'Player.lastName', 'Player.rating_id', 'Player.club_id')
	  ));
	  
	 $clubs = $this->Club->find('all', array( //oli ->Players->
	  'fields' => array('Club.id','Club.name')
	  ));
	  
	  //silmukka joka käy läpi pelaajataulun
      foreach ($players AS $player)
      {
	      //yhdistä nimet yhdeksi stringiksi
		  $name = $player['Player']['lastName'] . ' ' . $player['Player']['firstName'];
		  
		  //pelaajan klubi id
		  $playersClubId= $player['Player']['club_id'];
		  
		  // vastaavan klubin nimi
		  foreach ($clubs AS $club)
		  {
			if ($playersClubId == $club['Club']['id'])
			{
				$playersClub = $club['Club']['name'];
			}
		  }
		  
		  //käydään läpi ratingtaulu ja etsitään pelaaja
		  for ($i = 1; $i < count($sheetData); $i++)
		  {
			$row = $sheetData[$i];
		     //tarkista sheetdasta onko "pelaajarivi"
			if (is_numeric($row['F']) == true && $row > 0 )
			{
				//vertaa nimet ja seura 
				if ($row['B'] == $name && $row['E'] == $playersClub)
				{
					//Päivitetään pelaajan rating ja poistetaan kyseinen rivi pelaajataulusta
					
					$this->Player->id = $player['Player']['id'];
					$this->Player->saveField('rating_id', $row['F']);

					array_pop($row);
					break;
				}
			}
	     }
	  }
   }
}
