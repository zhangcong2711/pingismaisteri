<?php
App::uses('CakeEmail', 'Network/Email');

class TournamentsController extends AppController {

   public $helpers = array('Html', 'Form');
   
   public $uses = array( 'Tournament', 'TournamentClass', 'Registration', 'TournamentClasses', 'ClassInTournament', 'Rating', 'RatingRow', 'Player', 'Pool', 'PlayerInPool', 'Stage' );
   
   public function beforeFilter(){
      //$this->Security->unlockedFields = array('TournamentClass');
   }
   
   
   /* ------------------------- ACTIONS ----------------------------------------- */
   
   public function view() 
   {
      $this->set("tournaments", $this->Tournament->find("all"));
   }
    
    public function edit($id) 
    {
      if ($this->request->is('post') || $this->request->is('put')) {
      
         $dataArray['Tournament'] = $this->request->data['Tournament'];
         
         $startdate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['startdate'] );
         $enddate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['enddate'] );
         $cuttingdate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['cuttingdate'] );
         $registration_ends = DateTime::createFromFormat( "d.m.Y H:i:s",  $dataArray['Tournament']['registration_ends'] );
         
         $dataArray['Tournament']['startdate'] = $startdate->format("Y-m-d");
         $dataArray['Tournament']['enddate'] = $enddate->format("Y-m-d");
         $dataArray['Tournament']['cuttingdate'] = $cuttingdate->format("Y-m-d");
         $dataArray['Tournament']['registration_ends'] = $registration_ends->format("Y-m-d H:i:s");
         
         $this->Tournament->id = $this->request->data['Tournament']['id'];
		
         $this->Tournament->save($dataArray);
      
         $tournament_id = $dataArray['Tournament']['id'];
            
         if( isset( $this->request->data['TournamentClass'] ) )
         {
      
            foreach ($this->request->data['TournamentClass'] AS $i => $class )
            {

               if( isset($class['id']) )
               {
                  $this->Tournament->ClassInTournament->id = $class['id'];
               }
               else
               {
                  $this->Tournament->ClassInTournament->create();
               }
               
               $dataArray['ClassInTournament'] = array ( 
                  "tournament_class_id" => $class['tournament_class_id'],
                  "tournament_id" => $tournament_id,
                  "date" => $class['date'],
                  "price" => $class['price'],
               );
               
               $dataArray['ClassInTournament']['date'] = DateTime::createFromFormat( "d.m.Y",  $dataArray['ClassInTournament']['date'] )->format("Y-m-d");
               $dataArray['ClassInTournament']['price'] = floatval(str_replace(',', '.', str_replace('.', '', $dataArray['ClassInTournament']['price'])));
               
               $this->Tournament->ClassInTournament->save($dataArray);
               
            }
         }
         
         $this->Session->setFlash(__('Turnauksen tiedot päivitetty.')); 
      }
      

      $tournament = $this->Tournament->find("first",
         array(
            'conditions' => array(
               'Tournament.id' => $id
            ),
            'contain' => array(
               'ClassInTournament' => array(
                  'TournamentClass'
               )
            )
         )
      );
      
      $this->set("tournamentclasses", $this->TournamentClass->find("list"));
      
      $tournament['Tournament']['startdate'] = DateTime::createFromFormat( "Y-m-d",  $tournament['Tournament']['startdate'] )->format("d.m.Y");
      $tournament['Tournament']['enddate'] = DateTime::createFromFormat( "Y-m-d",  $tournament['Tournament']['enddate'] )->format("d.m.Y");
      $tournament['Tournament']['cuttingdate'] = DateTime::createFromFormat( "Y-m-d",  $tournament['Tournament']['cuttingdate'] )->format("d.m.Y");
      $tournament['Tournament']['registration_ends'] = DateTime::createFromFormat( "Y-m-d H:i:s",  $tournament['Tournament']['registration_ends'] )->format("d.m.Y H:i:s");
      
      $this->request->data = $tournament;
    }
	
   public function add() {
   
         $this->set("tournaments", $this->Tournament->find("all")); 
         
         $this->set( "tournamentclasses", $this->TournamentClass->find("list") );

      if ($this->request->is('post')) {

         $dataArray['Tournament'] = $this->request->data['Tournament'];
         
         $startdate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['startdate'] );
         $enddate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['enddate'] );
         $cuttingdate = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['cuttingdate'] );
         $registration_ends = DateTime::createFromFormat( "d.m.Y",  $dataArray['Tournament']['registration_ends'] );
         
         $dataArray['Tournament']['startdate'] = $startdate->format("Y-m-d");
         $dataArray['Tournament']['enddate'] = $enddate->format("Y-m-d");
         $dataArray['Tournament']['cuttingdate'] = $cuttingdate->format("Y-m-d");
         $dataArray['Tournament']['registration_ends'] = $registration_ends->format("Y-m-d");
		
         if ($this->Tournament->save($dataArray)) {
      
            $tournament_id = $this->Tournament->getLastInsertID();
            
            if( isset( $this->request->data['TournamentClass'] ) )
            {
         
               foreach ($this->request->data['TournamentClass'] AS $i => $class )
               {
               
                  if( $class['tournament_class_id'] != 0 )
                  {
                     $this->Tournament->ClassInTournament->create();
                              
                     $dataArray['ClassInTournament'] = array ( 
                        "tournament_class_id" => $class['tournament_class_id'],
                        "tournament_id" => $tournament_id,
                        "date" => $class['date'],
                        "price" => $class['price'],
                     );
                     
                     $dataArray['ClassInTournament']['date'] = DateTime::createFromFormat( "d.m.Y",  $dataArray['ClassInTournament']['date'] )->format("Y-m-d");
                     $dataArray['ClassInTournament']['price'] = floatval(str_replace(',', '.', str_replace('.', '', $dataArray['ClassInTournament']['price'])));
                     
                     $this->Tournament->ClassInTournament->save($dataArray);
                  }
               }
            }
            
             $this->Session->setFlash(__('Uusi turnaus tehty.'));
             $this->redirect( "/Tournaments/edit/".$tournament_id);
         } 
         else
			{
				$this->Session->setFlash(__('Uuden turnauksen luominen epäonnistui.'));
			}
      }
   }
   
   public function register($tournament_id)
   {
   
      $tournament = $this->Tournament->find("first",
         array(
            'conditions' => array(
               'Tournament.id' => (int) $tournament_id
            ),
            'contain' => array(
               'ClassInTournament' => array(
                  'TournamentClass',
                  'Registration',
                  'order' => 'ClassInTournament.date'
               )
            )
         )
      );
   
      if( $this->request->is('post') )
      {
         
         $data = $this->request->data;
         $registered = 0;
         $success = true;
         // Add registrations
         foreach( $data['Player'] as $player )
         {
            $player_id = $player['player_id'];

            if( isset( $player['ClassInTournament'] ) )
            {
            
               foreach( $player['ClassInTournament'] as $class )
               {
               
                  if( isset($class['register']) )
                  {
                     $registered = 1;
                     $this->Registration->create();
                     
                     $registration['Registration']['player_id'] = $player_id;
                     $registration['Registration']['tournament_class_id'] = $class['tournament_class_id'];
                     
                     if( $this->Registration->save( $registration ) ) 
                     {
                        $success = $success;
                     }
                     else
                     {
                        $success = false;
                     }
                  }
               }
               
            }
            
            if( $registered )
            {
               $this->Session->setFlash( __("Ilmoittautumiset on kirjattu") );
               
               $email = $this->Auth->user("email");
               $start = DateTime::createFromFormat("Y-m-d", $tournament['Tournament']['startdate']);
               
               $message  = "Kiitos ilmoittautumisesta turnaukseen ". $tournament['Tournament']['name']."\r\n";
               
               $message .= "Turnaus järjestetään ".$start->format("d.m.Y");
               
               if( $tournament['Tournament']['enddate'] != "" && $tournament['Tournament']['enddate'] = $tournament['Tournament']['startdate']  )
               {
                  $end = DateTime::createFromFormat("Y-m-d", $tournament['Tournament']['enddate']);
                  $message .= " - ". $end->format("d.m.Y");
               }
               
               $message .= "\r\n"."\r\n";
               
               $message .= "Vastaanotetut ilmoittautumiset: \r\n";
               
               foreach( $data['Player'] as $player )
               {
                  $message .= $player['name']."\r\n";
                  $price = 0;
                  
                  foreach( $player['ClassInTournament'] as $class )
                  {
                     if( isset($class['register']) )
                     {
                        $price = $price + $class['price'];
                        $date = DateTime::createFromFormat("Y-m-d", $class['date']);
                        $message .= "   ".$class['name'] . " " . $date->format("d.m.Y"). " ". number_format( $class['price'], 2, ",", " ")."\r\n";
                     }
                  }
                  
                  $message .= "Yhteensä: ". number_format( $price, 2, ",", " ")."\r\n";
                  
                  $message .= "--------------------------------------------------------------- \r\n";
                  
               }
               
               $message .= "\r\n". "Terveisin,\r\n Pingismaisteri";

               
               // Sends email to user
               
               $Email = new CakeEmail();
               $Email->from(array('pingismaisteri@gmail.com' => 'Pingismaisteri'));
               $Email->to($email);
               $Email->subject('Pingismaisteri ilmoittautumisvahvistus');
               $Email->send($message);
            }
            else
            {
               $this->Session->setFlash( __("Ilmoittautumisissa oli ongelma, tarkista ilmoittautumiset") );
            }
            
            //$this->redirect( array("controller" => "tournaments", "action" => "show", $tournament) );
            
         }
         
      }
      
      $players = $this->User->find("first",
         array(
            'contain' => array(
               'Player' => array(
                  'Registration'
               )
            ),
            'conditions' => array(
               'User.id' => $this->Auth->user("id")
            )
         )
      );
      
      $this->set("tournament", $tournament);
      $this->set("players", $players);
      
   }
   
   public function show($tournament_id)
   {
      $tournament = $this->Tournament->find("first",
         array(
            'conditions' => array(
               'Tournament.id' => (int)$tournament_id
            ),
            'contain' => array(
               'ClassInTournament' => array(
                  'TournamentClass',
                  'Registration' => array(
                     'Player' => array(
                        'Club'
                     )
                  ),
                  'order' => 'ClassInTournament.date ASC'
               )
            )
         )
      );
      
      $this->set("tournament", $tournament);
   }
   
   
   public function deleteTournament($id)
   {
      $this->Tournament->delete($id);
      
      $this->redirect( $this->referer() );
   }
   
      
   public function collectTournamentData($tournament_id)
   {
      //get tournament and registration data
      $tournament = $this->Tournament->find("first",
         array(
            'contain' => array(
               'ClassInTournament' => array(
                  'TournamentClass',
                  'Registration' => array(
                     'Player'
                  )
               )		 
           )
         )
      );
		
        //debug($tournament);

        //get cuttingdate
        $cuttingdate = $tournament['Tournament']['cuttingdate'];
		
		//toimivuus testata vielä
		$rating = $this->Rating->find("first", array(
				'conditions' => array(
					'Rating.date <=' => $tournament['Tournament']['cuttingdate']
				),
            'order' => 'date DESC',
            'contain' => array(
               'RatingRow' => array(
                  'Player'
               )
            )
         )
		);

      // json olio
      $data = array(
         $tournament,
         $rating
      );

      $tournamentJsonFileName	= $tournament['Tournament']['name'] ."_" . $tournament['Tournament']['startdate'] . ".pmt";
       
       $this->response->body(json_encode($data));
       $this->response->type('json');

       //Optionally force file download
       $this->response->download($tournamentJsonFileName);

       // Return response object to prevent controller from trying to render
       // a view
       return $this->response;
       
   }

   
   public function downloadTournamentData()
   {
        $this->viewClass = 'Media';

        $p = array(
                'id' => $this->Session->read("tournamentJsonFileName"),
                'name' => $this->Session->read("fileSaveName"),
                'download' => true,
                'extension' => 'json',
                'path' => APP . 'webroot/' . DS
        );

        $this->set($p);
   } 
   
   // Poolien arvontaan 
   public function drawPools($tournament_id, $tournament_class_id)
   {
   	
   		
   	
		// luokkaan rekisteröityjen pelaajien lukumäärä
		$registeredPlayers = $this->Registration->find("count",
		array(
			'conditions' => array(
			'Registration.tournament_class_id ='=> $tournament_class_id
			)));
		$this->set('regs', $registeredPlayers);
		
		
		//find all stages of this tournament
		$all_stages=$this->Stage->find("all",array(
									'conditions' => array('Tournament.id = ' => $tournament_id)
		));
		
		
		$playerList = $this->Player->find("all",array(
												'joins' => array(
											        array(
												        'table' => 'registrations',
												        'alias' => 'Registration',
												        'type' => 'INNER',
												        'conditions' => array(
												            'Registration.player_id = Player.id'
												        )
												    ),
												    array(
												        'table' => 'class_in_tournaments',
												        'alias' => 'CIT',
												        'type' => 'INNER',
												        'conditions' => array(
												        	'CIT.id = Registration.tournament_class_id'
												        )
												    ),
													array(
														'table' => 'rating_rows',
														'alias' => 'RatingRow',
														'type' => 'INNER',
														'conditions' => array(
															'Player.id = RatingRow.player_id',
															'RatingRow.rating_id=1'
														)
													)
											    ),
											    'conditions' => array(
											        'CIT.id = ' => $tournament_class_id
											    ),
											    'fields' => array('Player.*', 'CIT.*', 'Registration.*', 'RatingRow.rating')));
		

		// poolien asetukset
		if ($this->request->is('post'))
		{
			
			//get parameters
			$pool_num=$this->request->data['PoolForm']['pool_num'];
			
			
			//query tournament
			$tournament=$this->Tournament->find('first', array(
		        'conditions' => array('Tournament.id' => $tournament_id)
		    ));
			
			//query stages, select p stage where add pools
			$stages=$tournament['Stage'];
			foreach ($stages as &$st) {
				if($st['type']=='P'){
					
					//delete all pools associated with the stage
					$this->Pool->deleteAll(array('Stage.id' => $st['id']), true);
					
					
					//add pools
					
					$this->Pool->create();
					$pdata = array('name' => 'A', 'type' => 'P', 'stage_id' => $st['id']);
					$this->Pool->save($pdata);
					
					//add players in pools
					
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[0]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
					
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[1]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
					
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[2]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
					
					$this->Pool->clear();
					
					
					$this->Pool->create();
					$pdata = array('name' => 'B', 'type' => 'P', 'stage_id' => $st['id']);
					$this->Pool->save($pdata);
					
					//add players in pools
						
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[3]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
						
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[4]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
						
					$this->PlayerInPool->create();
					$pipdata = array('player_id' => $playerList[5]['Player']['id'], 'pool_id' => $this->Pool->id);
					$this->PlayerInPool->save($pipdata);
					$this->PlayerInPool->clear();
					
					$this->Pool->clear();
					
					$this->Pool->create();
					$pdata = array('name' => 'C', 'type' => 'P', 'stage_id' => $st['id']);
					$this->Pool->save($pdata);
					$this->Pool->clear();
						
					
				}
			}
			// $arr is now array(2, 4, 6, 8)
			unset($st); 
			
		}
		
		$this->set("all_stages", $all_stages);
   }
   
   public function sendEmail($id)
   {
      // Sends email to all registered players
      $Email = new CakeEmail();
      $Email->from(array('pingismaisteri@gmail.com' => 'Pingismaisteri'));
      $Email->to('jere@datavalas.net');
      $Email->subject('About');
      $Email->send('My message');
            
   }
}
?>