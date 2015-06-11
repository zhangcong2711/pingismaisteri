<?php
App::import('Vendor', 'PHPExcel/Classes/PHPExcel');

class TournamentsController extends AppController {

    public $helpers = array('Html', 'Form');

    public $uses = array( 'Tournament', 'TournamentClass', 'Registration', 'TournamentClasses', 'ClassInTournament', 'Rating', 'RatingRow', 'Player','Club','Pool','PlayerInPool');
    
    public function beforeFilter(){
      $this->Security->unlockedFields = array('TournamentClass');
    }
    
    
    /* ------------------------- ACTIONS ----------------------------------------- */

    
    public function view() {
       $this->set("tournaments", $this->Tournament->find("all"));
    }
   
    public function edit($id) 
    {

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
      //debug('Test1');
      if ($this->request->is('post') || $this->request->is('put')) {
      //debug('Test2');
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
		
         if ($this->Tournament->save($dataArray)) {
		  //debug($this->request->data);
            $tournament_id = $dataArray['Tournament']['id'];
            
            //if( isset( $this->request->data['TournamentClass'] ) )
			if( isset( $this->request->data['ClassInTournament'] ) )
            {
			debug('Test4');
               //foreach ($this->request->data['TournamentClass'] AS $i => $class )
			   foreach ($this->request->data['ClassInTournament'] AS $i => $class )
               {
				  
               
                  pr( $class );
               
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
					 "pool_size" => $class['pool_size'],
					 "placed_players" => $class['placed_players']
                  );
				  $da = DateTime::createFromFormat("d.m.Y",  $dataArray['ClassInTournament']['date']);
                  $dataArray['ClassInTournament']['date'] = $da->format("Y-m-d");
                  $dataArray['ClassInTournament']['price'] = floatval(str_replace(',', '.', str_replace('.', '', $dataArray['ClassInTournament']['price'])));
                  
                  if($this->Tournament->ClassInTournament->save($dataArray))
				  {
				  
				  }
				  else
				  {
					debug('fail');
				  }
                  
               }
            }
            
             $this->Session->setFlash(__('Turnauksen tiedot päivitetty.'));
         } 
        else
		{
		  $this->Session->setFlash(__('Uuden turnauksen luominen epäonnistui.'));
		}
      }
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
               
                  if( $class['id'] != 0 )
                  {
                     $this->Tournament->ClassInTournament->create();
                              
                     $dataArray['ClassInTournament'] = array ( 
                        "tournament_class_id" => $class['tournament_class_id'],
                        "tournament_id" => $tournament_id,
                        "date" => $class['date'],
                        "price" => $class['price'],
						"pool_size" => $class['pool_size'],
						"placed_players" => $class['placed_players'],

                     );
                     
                     $dataArray['ClassInTournament']['date'] = DateTime::createFromFormat( "d.m.Y",  $dataArray['ClassInTournament']['date'] )->format("Y-m-d");
                     $dataArray['ClassInTournament']['price'] = floatval(str_replace(',', '.', str_replace('.', '', $dataArray['ClassInTournament']['price'])));

                     $this->Tournament->ClassInTournament->save($dataArray);
                  }
               }
            }
            
             $this->Session->setFlash(__('Uusi turnaus tehty.'));
         } 
         else
			{
				$this->Session->setFlash(__('Uuden turnauksen luominen epäonnistui.'));
			}
      }
   }
   
   public function register($tournament_id)
   {
   
      if( $this->request->is('post') )
      {
         
         $data = $this->request->data;
       
         // Get needed data
         $tournament = $data['Tournament']['id'];
         
         $success = true;
         // Add registrations
         foreach( $data['Player'] as $player )
         {
            $player_id = $player['player_id'];

            if( isset( $player['ClassInTournament'] ) )
            {
            
               foreach( $player['ClassInTournament'] as $class )
               {
                  if( $class['register'] )
                  {

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
            
            if( $success )
            {
               $this->Session->setFlash( __("Ilmoittautumiset on kirjattu") );
            }
            else
            {
               $this->Session->setFlash( __("Ilmoittautumisissa oli ongelma, tarkista ilmoittautumiset") );
            }
            
            $this->redirect( array("controller" => "tournaments", "action" => "show", $tournament) );
            
         }
         
      }
   
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
            ),
            'conditions' => array(
               'Tournament.id' => (int) $tournament_id
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
		//debug($raiting);
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

   /*
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
   */
   
   function downloadTournamentData()
   {
      //if()
   }
   
   
   //TARKISTAMATTA!
   //Funktio joka käy läpi turnauksen luokat ja kutsuu funktiota joka arpoo luokan poolit 
   public function cycleAndDrawClasses($tournament_id)
   {
		$tournament = $this->Tournament->find("first",
			 array(
				'conditions' => array(
				   'Tournament.id' => (int)$tournament_id
				),
				'contain' => array(
				   'ClassInTournament' => array(
					  'TournamentClass',
					  'order' => 'ClassInTournament.date ASC'
				   )
				)
			 )
		  );
		  
		//debug($tournament);
		
		$ratings = $this->Rating->find("first",
			array( 
			'conditions' =>
				array('Rating.date <=' => $tournament['Tournament']['cuttingdate']),
			'order' => 'Rating.date DESC'
		  )
		);
        
        $this->set("tournament", $tournament);
        
        // Alustetaan session tiedot
	    $this->Session->write('tournamentClassesWithPools', array());
        $this->Session->write('classInfos', array());
        $this->Session->write('playerData', array());
        $this->Session->write('playerRatings',array());
        
		if ($this->request->is('post'))
		{
		  //haetaan tournamentdataa, luokkien id:t ainakin
		  $tournamentPools = array();
		  $class = 0;
		  $classes = array();
		  foreach($tournament['ClassInTournament'] as $classinfo)
		  {
			 $classes[$classinfo['id']] = $classinfo;
			 $tournamentPools[$classinfo['id']] = $this->drawPools($classinfo['id'],$ratings);
			 $class =+ 1;
		  }
          //debug($tournamentPools);
		  //debug('test');
		  $this->Session->write('tournamentClassesWithPools', $tournamentPools);
		  $this->Session->write('classInfos', $classes);
          
          $this->redirect( array("controller" => "tournaments", "action" => "manualPlayerOrdering") );
		}
   }   
   
   /*Kimmon versio drawpoolsista, parametreinä tarvii monta poolia, monta pelaajaa sijoitetaan rankingin mukaan ja tuohon rankedList tarvitsemat tiedot, esim tournament_class_id?
   */
   public function getPlayersFromClass($classId)
   {	
		$players = $this->Registration->find("all", array('conditions' => array( 'Registration.tournament_class_id' => $classId )));
		return $players;
   }
   
   
   public function drawPools($classId, $ratings)
   {
      //valmistetaan taulukko johon kerätään pelaaja_id:t ja ratingit
	  $tmp_rankedList = array();
	  
	  //$pid = 18;
	  //$result = $this->RatingRow->find("first", array('condition' => array('player_id' => $pid)));
	  //debug($result);
	
	  
	  $player_ids = $this->getPlayersFromClass($classId);
      //debug($player_ids);
	  
	  //debug($player_ids);
	  $i = 0;
	  
	  $allPlayerData = $this->Session->read('playerData');
	  $allPlayerRatings = $this->Session->read('playerRatings');
	  
	  //yhdistetään pelaajan id ja rating
	  
	  foreach($player_ids as $player)
	  {
		if(isset($allPlayerData[$player['Player']['id']]) == false)
		{	
			$allPlayerData[$player['Player']['id']] = $player;
		}
		
		foreach($ratings['RatingRow'] as $rating_row)
		{
			if($rating_row['player_id'] == $player['Player']['id'])
			{
			   $tmp_rankedList[$i]['player'] = $rating_row['player_id'];
               $tmp_rankedList[$i]['rating'] = $rating_row['rating'];
               $i++;
			   $allPlayerRatings[$player['Player']['id']] = $rating_row['rating'];
			}
			else
			{
				// Jos pelaaja ei löydetä
			}
		}
	  }
	  
	  $this->Session->write('playerData', $allPlayerData);
	  $this->Session->write('playerRatings',$allPlayerRatings);
	  
	  //järjestetään saatu taulu rating elementin mukaan laskevaan järjestykseen
	  $tmp = array();
	  
	  foreach($tmp_rankedList as $key => $row)
      {
		 $tmp[$key] = $row['rating'];
	  }
	  
	  array_multisort($tmp, SORT_DESC, $tmp_rankedList);

	  //luoodaan lista johon pelaajien id:t tulevat rating arvon mukaan laskevassa järjestyksessä
      $rankedList = array();
      
	  foreach ($tmp_rankedList as $playerRow => $playerData)
      {
         $tmp_rankedList[$playerRow]['club'] = $allPlayerData[$playerData['player']]['Player']['club_id'];
      }
      
      //foreach($tmp_rankedList as $key => $row)	  
	 // {
	  //   $rankedList[$key] = $tmp_rankedList[$key]['player'];
	 // }
    	
	  //ota parametreistä sijoitusten määärä, poolien määrä, rekisteröityneet pelaajat, TÄYDENNÄ PARAMETRIT KUN SELVÄ TAULUN MUOTO
	  $poolSize = 4;
	  $no_of_pools = ceil(count($tmp_rankedList) / $poolSize);
      $no_from_ranks = $no_of_pools;
	  $no_of_players = count($tmp_rankedList);
	  
	  //taulukko johon poolit muodostuvat
	  $pools = array();
	  $key = 0;
      
      // Alustetaan arvoja
	  for($n = 0; $n < $no_of_pools; $n++)
	  {
		$pools[$n] = array();
	  }
      
	  //jaetaan parametreissa annettu määrä pelaajia rankingin mukaan pooleihin
      
	  for($i = 0; $i < $no_from_ranks; $i++)
      {
	     //debug($rankedList[$key]);
		 //otetaan pelaajan id ylös
         $tmp_rankedList[$i]['ranked'] = true;
         $pools[$i][0] = $tmp_rankedList[$i];
      }
	  // poistetaan raitingin mukaan asetetut pelaajat pelaajataulusta
	  for($y = 0; $y < $no_from_ranks; $y++)
	  {
	     unset($tmp_rankedList[$y]);
	  }
      // Sekoitetaan jäljelle jääneet pelaajat
	  
      //debug($allPlayerData);
      // Asetetaan loput pelaajat pooleihin
      
	  $pools = $this->insertPlayersToPool($no_from_ranks,$no_of_pools,$no_of_players,$pools,$tmp_rankedList,$poolSize,$allPlayerData,$classId);
      
      return $pools;
   }
   
   public function insertPlayersToPool($no_from_ranks,$no_of_pools,$no_of_players,$pools,$rankedList,$poolSize,$allPlayerData,$classId)
   {
	 $oldPools = $pools;
     $old = $rankedList;
     $rerolled = 0; 
     $end = false;
     
     while($end == false)
     {
         $pools = $oldPools;
         $rankedList = $old;
         $activePool = 0;
         $rank = 1;
         $playerNumber = 0;
         //debug($classId);
         
         for($i = 1; $i < $poolSize; $i++)
         {
            $currentPlayer = array();
            $playerNumber = 0;
            for($n = $no_of_pools*$rank; $n < ($rank+1)*$no_of_pools;$n++)
            {
               if(isset($rankedList[$n]))
               {
                  $currentPlayer[$playerNumber] = $rankedList[$n];
               }
               else
               {
                  break;
               }
               $playerNumber++;
            }

            shuffle($currentPlayer);
            $c = 0;
            for($n = $no_of_pools-1; $n >= 0; $n--)
            {
               if(isset($currentPlayer[$c]))
               {
                  $pools[$n][$rank] = $currentPlayer[$c];
               }
               else
               {
                  $pools[$n][$rank] = array('player' => -1, 'rating' => 0,'club' => 0);
               }
               $c++; 
            }
            $rank++;
         }
         $end = true;
         /*
         for( $i = 0; $i < count($rankedList); $i++)
         {
            if(count($pools[$activePool]) >= $poolSize)
            {
                $activePool++;
            }
            $pools[$activePool][count($pools[$activePool])] = $rankedList[$i];
         }

         //debug($pools);
         // tarkistetaan seurat
         $matchedplayers = array();
         $matches = 0;

         for($i = 0; $i < count($pools); $i++)
         {
           for($j = 0; $j < count($pools[$i]);$j++)
           {
              for($n = 0; $n < count($pools[$i]); $n++)
              {
                 if($pools[$i][$j]['player'] != $pools[$i][$n]['player'])
                 {
                    if($pools[$i][$j]['club'] == $pools[$i][$n]['club'])
                    {
                       $found = false;

                       if(!isset($matchedplayers[$pools[$i][$j]['player']]) && !isset($pools[$i][$j]['ranked']))
                       {
                          $matchedplayers[$pools[$i][$j]['player']] = true;
                          $found = true;
                       }
                       if(!isset($matchedplayers[$pools[$i][$n]['player']]) && !isset($pools[$i][$n]['ranked']))
                       {
                          $matchedplayers[$pools[$i][$n]['player']] = true;
                          $found = true;
                       }
                       if($found)
                       {
                          $found = false;
                          $matches++;
                       }
                    }
                 }
              }
           }
         }
         if($matches > 2)
         {
            $rerolled++;
            if($rerolled > 5)
            {
               $end = true;
            }
         }
         else
         {
            $end = true;
         }
          */
     }
     
     for($i = 0; $i < count($pools); $i++ )
     {
        for($j = 0; $j < count($pools[$i]);$j++)
        {
           $pools[$i][$j] = $pools[$i][$j]['player'];
        }
     }
	 return $pools;
   }
  
   /*
   public function arrangeMatchesTournament($pools)
   {
      $matchesTournament = array();
	  $class = 0;
	  
	  //käydään turnauksen eri luokat läpi ja syötetään funktioon jossa käsitellään yksittäiset poolit
	  foreach($pools as $classPools)
	  {
	     $matchesTournament[$class] = $this->arrangeMatchesClass($pools[$classPools]);
	     $class =+ 1;
	  }
	  return $matchesTournament;
   }
   
   //syöttää taulukossa saamansa luokan poolit funktion joka luo otteluparit poolikohtaisesti
   public function arrangeMatchesClass($pools)
   {
      
	  $matchesClass = array();
	  $pool = 0;
	  foreach($pools as $poolnro)
	  {
	     $matchesClass[$pool] = $this->arrangeMatchesPool($pools[$poolnro]);
		 $pool =+ 1;
	  }
      return $matchesClass;
   }
   
   
   //Funktio joka tekee saadun poolin otteluparit
   public function arrangeMatchesPool($pool)
   {
      $x = count($pool);
		 
	  $z = 0;
		 
      for($i = 0;$i < $x; $i++)
      {
         for($y = $i + 1; $y < $x; $y++)
		 {
		    $match["players"][0] = $pool[$i];
		    $match["players"][1] = $pool[$y];
		    $matches[$z] = $match;
            $z =+ 1;			   
	     }
      }
      return $matches;		 
   }
   */
   public function parsePools()
   {
      if ($this->request->is('post'))
      {
         //debug($this->request->data);
         
         $numberofclasses = $this->request->data['tournament']['classes'];
         $poolsinclass = json_decode($this->request->data['tournament']['poolsizesjson']);
        
         $classpools = array();
         $poolsinclassarray = array();
         
         foreach($poolsinclass as $classid => $amount)
         {
            $poolsinclassarray[(int)$classid] = $amount;
         }
         
         foreach(array_keys($poolsinclassarray) as $mykey)
         {
           $classpools[$mykey] = json_decode($this->request->data['tournament']['tableData'.$mykey]);
           if(!isset($classpools[$mykey]))
           {
              $classpools[$mykey] = array(array());
           }
         }
         
         $alldata = array();
         
         foreach($classpools as $classid => $classdata)
         {
            $allpools = array();
            $poolsinthisclass = $poolsinclassarray[(int)$classid];
            $row = 0;
            $playernumber = 0;
            foreach($classdata as $playercell)
            {
              
              if($playernumber < $poolsinthisclass)
              {
                 $allpools[$playernumber][$row] = $playercell[0];
              }
              else
              {
                 $playernumber = 0;
                 $row++;
                 $allpools[$playernumber][$row] = $playercell[0];
              }
              $playernumber++;
            }
            $alldata[$classid] = $allpools;
         }
		 
		 $errors = 0;
		 
         // $alldata is ready to be saved into the DB
         foreach( $alldata as $class_id => $class_data )
         {
			
            foreach( $class_data as $i => $pool )
            {
               $this->Pool->create();
               
               $pool_data = array();
               $pool_data['class_id'] = $class_id;
               
               if($this->Pool->save( $pool_data ))
               {
				  
                  $pool_id = $this->Pool->getInsertID();
				  
                  foreach( $pool as $player )
                  {
                     if( $player > 0 )
                     {
                        $this->PlayerInPool->create();
                       
                        $player_data = array();
                        $player_data['pool_id'] = $pool_id;
                        $player_data['player_id'] = $player;
                     
                        if(!$this->PlayerInPool->save($player_data))
                        {
                           $error++;
                        }
                     }
                  }
               }
               else
               {
                  $errors++;
               }
            }
         }
		 
         if( $errors == 0 )
         {  
            //$this->Session->setFlash(__('Tallennus kantaan onnistui!'));
            //$this->redirect( array("controller" => "tournaments", "action" => "view") );
         }
         else
         {
			//debug($this->validationErrors);
            //$this->Session->setFlash(__('Tallennus kantaan epäonnistui!'));
           // $this->redirect( array("controller" => "tournaments", "action" => "view") );
         }
		 
		 //debug($alldata);
		 $pfirstname = $this->Player->find('list', array('fields' => array('firstname')));
		 $plastname = $this->Player->find('list', array('fields' => array('lastname')));
		 $classes = $this->ClassInTournament->find('list', array('fields' => array('tournament_class_id')));
		 $classtempla = $this->TournamentClass->find('list',array('fields' => array('name')));
		 $club = $this->Club->find('list',array('fields' => array('name')));
		 $clubids = $this->Player->find('list',array('fields' => array('club_id')));
		 $tournaments = $this->Tournament->find('list',array('fields' => array('name')));
		 $ratings = $this->Tournament->find('list',array('fields' => array('cuttingdate')));
         
		 //debug($classes);
		 //debug($classtempla);
		 //debug($allplayers);
		 $playerintournament = array();
		 $temp = array();
		 $counter = 0;
		 $findtournamentid = true;
		 
		 $objExcel = new PHPExcel();
		 foreach($alldata as $class => $classdata)
		 {
			$objExcel->setActiveSheetIndex($counter);
			if($findtournamentid == true)
			{
				$tournamentid = $this->ClassInTournament->find('first', array('fields' => array('tournament_id'),'conditions' => array('ClassInTournament.id' => $class)));
				$tournamentid = $tournamentid['ClassInTournament']['tournament_id'];
                
                $tournamnetdate = $this->Tournament->find('first',array('conditions' => array('Tournament.id' => $tournamentid)));
                $tournamnetdate = $tournamnetdate['Tournament']['cuttingdate'];
                
                $rating = $this->Rating->find("first", array(
                           'conditions' => array(
                               'Rating.date <=' => $tournamnetdate
                           ),
                           'order' => 'date DESC',
                           'contain' => array(
                           'RatingRow' => array(
                              'Player'
                                 )
                              )
                           )
                           );
                $playerRatingData = array();
                
                foreach($rating['RatingRow'] as $ratingRow)
                {
                   $playerRatingData[$ratingRow['player_id']] = $ratingRow['rating'];
                }
                
				$objExcel->getProperties()->setTitle($tournaments[$tournamentid]);
				$findtournamentid = false;
			}
			
			if(isset($class))
			{
				$playerintournament[$classtempla[$classes[$class]]] = array();
				$objExcel->createSheet();
				$objExcel->getActiveSheet()->setTitle($classtempla[$classes[$class]]);
				$objExcel->getActiveSheet()->SetCellValue('B2', $tournaments[$tournamentid]);
				$objExcel->getActiveSheet()->SetCellValue('B3', $classtempla[$classes[$class]]);
				$classcounter = 0;
				foreach($classdata as $poolid => $pooldata)
				{
					$playerintournament[$classtempla[$classes[$class]]][$poolid] = array();
					$temp = array();
					
					$objExcel->getActiveSheet()->SetCellValue('B'.(($classcounter*14)+6), 'Rating');
					$objExcel->getActiveSheet()->SetCellValue('C'.(($classcounter*14)+6), 'Pool '.$poolid);
					$objExcel->getActiveSheet()->SetCellValue('D'.(($classcounter*14)+6), 'Seura');
					$objExcel->getActiveSheet()->SetCellValue('E'.(($classcounter*14)+6), 'Voitot');
					$objExcel->getActiveSheet()->SetCellValue('F'.(($classcounter*14)+6), 'Erät');
					$objExcel->getActiveSheet()->SetCellValue('G'.(($classcounter*14)+6), 'Pisteet');
					$objExcel->getActiveSheet()->SetCellValue('H'.(($classcounter*14)+6), 'Sija');
					
					$playercounter = 0;
                    
                     foreach($pooldata as $prank => $player)
                     {
                         if($player != -1)
                         {

                             $temp['name'] = $pfirstname[$player].' '.$plastname[$player];
                             $temp['club'] = $club[$clubids[$player]];
                             $temp['id'] = $player;
                             $temp['rating'] = $playerRatingData[$player];
                             $playerintournament[$classtempla[$classes[$class]]][$poolid][$prank] = $temp;
                         }
                         else
                         {
                             $temp['name'] = 'Tyhjä';
                             $temp['club'] = '-';
                             $temp['id'] = -1;
                             $temp['rating'] = '-';
                             $playerintournament[$classtempla[$classes[$class]]][$poolid][$prank] = $temp;
                         }
                         
                         $objExcel->getActiveSheet()->SetCellValue('A'.((($classcounter*14)+6+1)+$playercounter), $prank+1);
                         $objExcel->getActiveSheet()->SetCellValue('C'.((($classcounter*14)+6+1)+$playercounter), $temp['name']);
                         $objExcel->getActiveSheet()->SetCellValue('D'.((($classcounter*14)+6+1)+$playercounter), $temp['club']);
                         $objExcel->getActiveSheet()->SetCellValue('B'.((($classcounter*14)+6+1)+$playercounter), $temp['rating']);

                         $playercounter++;
                     }
                     $objExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                     $classcounter++;
				}
				$counter++;
			}
		 }
		 $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
		 //debug();
		 $fname = str_replace(':','_',str_replace(' ','_',$tournaments[$tournamentid]));
		 $dir = WWW_ROOT.'files'.DIRECTORY_SEPARATOR;
		
		 $end = '.xlsx';
		 //$dir = (__FILE__).DIRECTORY_SEPARATOR.str_replace(' ','_',$tournaments[$tournamentid]).'.xlsx';
		 //debug($dir);
		 
		 $oldfname = $fname;
		 $counter = 0;
		 
		 while(file_exists($dir.$fname.$end))
		 {
			$fname = $oldfname.$counter;
			$counter++;
		 }
		 
		 $dir = $dir.$fname.$end;
		 $objWriter->save($dir);
		 //debug($playerintournament);
	     //$this->response->download($dir);
		
		 // Return response object to prevent controller from trying to render
		 // a view
         $this->response->file(
			$dir,
			array('download' => true, 'name' => $fname.$end)
		);
		
         return $this->response;
         //debug($this->arrangeMatchesTournament($alldata));
         //$alldata is ready to be saved into the DB
         
         //$this->Session->setFlash(__('Tallennus (lähes)onnistui!'));
         //$this->redirect( array("controller" => "tournaments", "action" => "view") );
		 
		 
      }
      else
      {
         $this->Session->setFlash(__('Ei tarvittavia tietoja'));
         $this->redirect( array("controller" => "tournaments", "action" => "view") );
      }
   }
    public function manualPlayerOrdering()
    {
      $clubs = $this->Club->find('all');
      $ar = array();

      for($i = 0; $i < count($clubs); $i++)
      {
        $ar[$clubs[$i]['Club']['id']] = $clubs[$i]['Club']['name'];
      }
      $this->set('clubs',$ar);
      
	  function createEmptyCell()
	  {
		$output = '';
		$output .= '<ul id="-1" class="PlayerDataList">';
		$output .= '<li>';
		$output .= '</li>';
		$output .= '<li class="emptyCell">';
		$output .= '&ltTyhjä paikka&gt;';
		$output .= '</li>';
		$output .= '<li>';
		$output .= '</li>';
		$output .= '<li>';
		$output .= '</li>';
		$output .= '</ul>';
		return $output;
	  }
      function createPlayerCell($playerData,$playerRatings,$clubs)
      {
        $output = '';
        $output .= '<ul id='.$playerData['id'].' class="PlayerDataList">';
		$output .= '<li><b>';
		$output .= $playerData['firstname'].' '.$playerData['lastname'];
		$output .= '</b></li>';
		$output .= '<li>';
		$output .= $playerRatings[$playerData['id']];
		$output .= '</li>';
		$output .= '<li>';
		$output .= $clubs[$playerData['club_id']];
		$output .= '</li>';
        $output .= '</ul>';
        
        return $output;
      }
	  
      function createClassTable($data,$name,$classnbr,$playerData,$playerRatings,$clubs)
      {
         //debug($data);
         $outputColGroup = '<colgroup class="PoolColGroup">';
         $outputrows = array();

         $outputpoolnames = "<tr>";
         $counter = 0;
         
         if(isset($data) && isset($data[0]))
            $poolsize = count($data[0]);
         else
            $poolsize = 0;
         
         foreach ($data as $poolname => $pooldata)
         {

            $outputpoolnames .= '<th class="PoolNames mark">'.($poolname+1).'</th>';
            $outputColGroup .= '<col width="auto"/>';
            
            foreach ($pooldata as $playerid)
            {
               if(!isset($outputrows[$counter]))
               {
                  $outputrows[$counter] = '';
               }
               
               if(isset($playerData[$playerid]) && $playerData[$playerid] != -1)
               {
                  //$outputrows[$counter] = '<tr>';
                  $outputrows[$counter] .= '<td><div id="'.$playerid.'" class="drag">'.createPlayerCell($playerData[$playerid]['Player'],$playerRatings,$clubs).'</div></td>';
               }
               //else if($playerData[$playerid] != -1)
               //{
               //   $outputrows[$counter] .= '<td><div id="'.$playerid.'" class="drag">'.createPlayerCell($playerData[$playerid]['Player'],$playerRatings,$clubs).'</div></td>';
               //}
               else
               {
                  $outputrows[$counter] .= '<td><div id="-1" class="drag">'.createEmptyCell().'</div></td>';
               }
               $counter++;
            }
            $counter = 0;
			/*if( $counter < $poolsize)
			{
				for($i = $counter; $i < $poolsize; $i++)
				{
                    $outputrows[$i] .= '<td><div id="-1" class="drag">'.createEmptyCell().'</div></td>';
				}
			}*/
            
         }
         $outputColGroup .= '</colgroup>';
         $output = '<div>';
         $output .= '<div id="drag'.$classnbr.'"><div id="className"></div>';
         
         $output .= '<table id="dragtable'.$classnbr.'" class = "ClassTable">';
         
         
         $output .= $outputColGroup;
         $output .= '<thead>';
         
         $output .= $outputpoolnames."</tr>";
         $output .= '</thead>';
         $output .= '<tbody>';
         foreach($outputrows as $str)
         {
            $output .= "</tr>".$str.'</tr>';
         }
         if(!isset($outputrows) || count($outputrows) <= 0 )
         {
            $output .= "<div>Ei ilmoittautuneita pelaajia</div>";
         }
         $output .= '</tbody>';
         $output .= '</table>';
         $output .= '</div>';
         $output .= '</div>';

         return $output; 
      }
      
      function createClassHeads($data,$classInfos)
      {  
         $output = '<ul id="tabul">';
         $classes = count($data);
        
         for($i = 0; $i < $classes; $i++)
         {
            $output .= '<li><a href="#tabs-'.$i.'">'.$classInfos[$data[$i]]["TournamentClass"]["name"].'</a></li>';
         }
         $output .= '</ul>';
         return $output;
      }
      // Create table of playerIDs to running numbers
      // as in table['1'] = playerIDx
    }
	
	/*
   public function drawClasses($tournament_id)
   {
   		if ($this->request->is('post'))
		{
				cycleAndDrawClasses($param);
		}

   
   
		// luokkaan rekisteröityjen pelaajien lukumäärä
		/*
		$registeredPlayers = $this->Registration->find("count",
		array(
			'conditions' => array(
			'Registration.tournament_id =' => $tournament_id,
			'Registration.tournament_class_id ='=> $tournament_class_id
			)));
		$this->set('regs', $registeredPlayers);
		}
		*/
		
    public function sendEmail($tournament_id)
	{    
		$tournament = $this->Tournament->find("first",
         array(
            'conditions' => array(
               'Tournament.id' => (int)$tournament_id
            )));
			
		$tournamentName = $tournament['Tournament']['name'];
		$contactEmail = $tournament['Tournament']['contactemail'];
		
		// taulukko, johon kerätään emailit joille lähetetään maili
		$sendTo = array();
		
		// pistetään turnaukseen osallistujien emailit $sendTo-taulukkoon
		$regs = $this->Registration->find("all");
		
		foreach($regs as $r)
		{
				$ClassTournamentId = $r['ClassInTournament']['tournament_id'];
				
				if ($ClassTournamentId == $tournament['Tournament']['id'])
				{
					if ( !in_array($r['Player']['email'], $sendTo))
					{
						array_push($sendTo, $r['Player']['email']);
					}
				}
		}		
   
   		if ($this->request->is('post'))
		{
			$subject = $this->request->data['Tournaments']['EmailOtsikko'];
			$message = $this->request->data['Tournaments']['EmailViesti'];
			
			foreach($sendTo as $s)
			{	
				$email = new CakeEmail();
				
				$email->from(array($contactEmail => $tournamentName));
				$email->to($s);
				
				$email->subject($subject);
				$email->send('$message');
			}
		}  
   }
}
?>