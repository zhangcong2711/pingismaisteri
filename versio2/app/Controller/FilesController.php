<?php

App::import('Vendor', 'PHPExcel/Classes/PHPExcel');

class FilesController extends AppController {

   public $helpers = array('Html', 'Form', 'PHPExcel');
   
   public $uses = array('Player', 'Tournament', 'Rating', 'RatingRow', 'TournamentClass', 'Club');
   
   function beforeFilter() {
      parent::beforeFilter();
   }
   
   function test()
   {
      $this->set( "data", $this->Player->find("all") );
   }
   
   function writeToDb($sheetData,$inputFileName, $ratingDate)
   {
	   $players = $this->Player->find('all', array( 
	    'fields' => array('Player.id', 'Player.firstName', 'Player.lastName', 'Player.club_id')
	   ));
	  
	  $clubs = $this->Club->find('all', array( //oli ->Players->
	  'fields' => array('Club.id','Club.name')
	  ));
	  
	  //palauta session muuttujasta $rating taulu
	  $rating = $sheetData;
	  
	  $ratingInfo = array(
	            "filename" => $inputFileName,
				"date" => $ratingDate
	              );
	  
	  //tallenna kantaan rating
	  $this->Rating->save($ratingInfo);
	  
	  //hae kannasta rating_id, get last_insert_id, tee muuttaja
	  $ratingId = $this->Rating->getLastInsertId();
	  $found = false;
	  $alldata = array();	
	  //silmukka joka käy läpi rating taulun
      foreach ($rating as $row)
      {		
		  
		  $found = false;	  
		  //tarkistaa onko rivi jonkun pelaajan rating
		  if(is_numeric($row['F']) && $row['B'] != "" && $row['E'] != "")
		  {
		     
			 $data = array();
			 $data['RatingRow']['rating_id'] = $ratingId;
			 $data['RatingRow']['rating'] = $row['F'];
             //debug($data);
			 
			 //käydään läpi pelaajat ja etsitään nimeä ja seuraa
			 foreach($players as $i => $prow)
			 {
				//yhdistä nimet yhdeksi stringiksi
		        $name = trim($prow['Player']['lastName']) . ' ' . trim($prow['Player']['firstName']);
		  
		        //pelaajan klubi id
		        $playersClubId= $prow['Player']['club_id'];
		  
	    	    // vastaavan klubin nimi
		        foreach ($clubs AS $club)
		        {
			      if ($playersClubId == $club['Club']['id'])
			      {
				    $playersClub = $club['Club']['name'];
			      }
		        }
				
				//tarkistaa pelaajan
				if ($row['B'] == $name && $row['E'] == $playersClub)
				{
				   $data['RatingRow']['player_id'] = $prow['Player']['id'];
					//unset($players[$i]);
					$found = true;
               $players[$i]['found'] = true;
				}
				
			 }
			 
			 if($found == true){
				array_push($alldata,$data['RatingRow']);		
			 } 
		 }
	  }
     
      foreach( $players as $player )
      {
         if( !isset($player['found']) )
         {
            $data['RatingRow'] = array();
            
            $data['RatingRow']['rating'] = 0;
            $data['RatingRow']['rating_id'] = $ratingId;
            $data['RatingRow']['player_id'] = $player['Player']['id'];
         
            array_push($alldata, $data['RatingRow']);
         }
      }
	  
	  if(count($alldata) > 0)
	  {
		if($this->RatingRow->saveMany($alldata))
		{
			$this->Session->setFlash( __("Ratingit tallennettu") );
		}
		else
		{
			$this->Session->setFlash( __("Raitingin tallennus kantaan epäonnistui") );
		}
	  }
	  else
	  {
		$this->Session->setFlash( __("Ei löytynyt raiting tietoja järjestelmässä oleville pelaajille") );
	  }
   }
   
   function readRatingFile()
   {
 
       if ($this->request->is('post') &&  isset($this->request->data['RatingFile']))
	   {
	      $file = $this->request->data['RatingFile']['UploadedFile'];
		  
		  //tarkista saatu array, errorit, typessä exel pääte
		  
		  $type = array (
		  "Excel12007",
		  "Excel5",
		  "OOCalc",
		  "application/vnd.ms-excel",
		  "application/msexcel",
		  "application/x-msexcel",
		  "application/x-ms-excel",
		  "application/x-excel",
		  "application/x-dos_ms_excel",
		  "application/xls",
		  "application/x-xls");
	
		
		$filetype = PHPExcel_IOFactory::identify($file['tmp_name']);
		
		if (in_array($filetype, $type)  && ($file['error'] == 0) )
		{		
			    $inputFileName = $file['tmp_name'];
				$sheetname = 'Rating järjestys';
				$objReader = PHPExcel_IOFactory::createReader($filetype);
			    $objReader->setReadDataOnly(true);
			    $objReader->setLoadSheetsOnly($sheetname);
			    $objPHPExcel = $objReader->load($inputFileName);
			  
			    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            

			}
			
			$this->Session->write('sheet', $sheetData);
			$this->Session->write('ratingFileName', $inputFileName);
			
			$this->set("ratingRows", $sheetData);
		
		    	
		}
		else if ($this->request->is('post') &&  isset($this->request->data['ratingOk']))
		{
            $this->writeToDb($this->Session->read('sheet'), $this->Session->read('ratingFileName'),$this->request->data['ratingOk']['ratingDate']);	
		}
   }
}