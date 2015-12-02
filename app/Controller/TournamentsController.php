<?php
App::uses ( 'CakeEmail', 'Network/Email' );

App::import ( 'Config', 'app_const' );
App::import ( 'Vendor', 'PHPExcel/Classes/PHPExcel' );
class TournamentsController extends AppController {
	public $helpers = array (
			'Html',
			'Form',
			'PHPExcel' 
	);
	public $uses = array (
			'Tournament',
			'TournamentClass',
			'Registration',
			'TournamentClasses',
			'ClassInTournament',
			'Rating',
			'RatingRow',
			'Player',
			'Pool',
			'PlayerInPool',
			'Stage',
			'Game',
			'Set' 
	);
	public function beforeFilter() {
		// $this->Security->unlockedFields = array('TournamentClass');
	}
	
	/* ------------------------- ACTIONS ----------------------------------------- */
	public function view() {
		$this->set ( "tournaments", $this->Tournament->find ( "all" ) );
	}
	public function edit($id) {
		if ($this->request->is ( 'post' ) || $this->request->is ( 'put' )) {
			
			$dataArray ['Tournament'] = $this->request->data ['Tournament'];
			
			$startdate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['startdate'] );
			$enddate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['enddate'] );
			$cuttingdate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['cuttingdate'] );
			$registration_ends = DateTime::createFromFormat ( "d.m.Y H:i:s", $dataArray ['Tournament'] ['registration_ends'] );
			
			$dataArray ['Tournament'] ['startdate'] = $startdate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['enddate'] = $enddate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['cuttingdate'] = $cuttingdate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['registration_ends'] = $registration_ends->format ( "Y-m-d H:i:s" );
			
			$this->Tournament->id = $this->request->data ['Tournament'] ['id'];
			
			$this->Tournament->save ( $dataArray );
			
			$tournament_id = $dataArray ['Tournament'] ['id'];
			
			if (isset ( $this->request->data ['TournamentClass'] )) {
				
				foreach ( $this->request->data ['TournamentClass'] as $i => $class ) {
					// add flag
					$new_create = false;
					
					if (isset ( $class ['id'] )) {
						// get rid of deleted tournamentclass
						$d_count = $this->Tournament->ClassInTournament->find ( 'count', array (
								'conditions' => array (
										'ClassInTournament.id' => $class ['id'] 
								) 
						) );
						if ($d_count == 0) {
							continue;
						}
						$this->Tournament->ClassInTournament->id = $class ['id'];
					} else {
						$this->Tournament->ClassInTournament->create ();
						$new_create = true;
					}
					
					$dataArray ['ClassInTournament'] = array (
							"tournament_class_id" => $class ['tournament_class_id'],
							"tournament_id" => $tournament_id,
							"date" => $class ['date'],
							"price" => $class ['price'] 
					);
					
					$dataArray ['ClassInTournament'] ['date'] = isset ( $dataArray ['ClassInTournament'] ['date'] ) ? DateTime::createFromFormat ( "d.m.Y", $dataArray ['ClassInTournament'] ['date'] )->format ( "Y-m-d" ) : '';
					$dataArray ['ClassInTournament'] ['price'] = floatval ( str_replace ( ',', '.', str_replace ( '.', '', $dataArray ['ClassInTournament'] ['price'] ) ) );
					$dataArray ['ClassInTournament'] ['pool_num'] = intval ( trim ( $class ['pool_num'] ) );
					
					if ($new_create) {
						$dataArray ['ClassInTournament'] ['stage_type'] = trim ( $class ['stage_type'] );
					}
					
					$this->Tournament->ClassInTournament->save ( $dataArray );
					
					if ($new_create) {
						if (isset ( $dataArray ['ClassInTournament'] ['stage_type'] )) {
							
							$class_in_tournament_id = $this->Tournament->ClassInTournament->getLastInsertID ();
							$stage_type = $dataArray ['ClassInTournament'] ['stage_type'];
							if ($stage_type == constant ( 'STAGE_TYPE_POOLS_CUP' )) {
								
								$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
								$this->createStage ( $class_in_tournament_id, 'Cup', constant ( 'STAGE_CUP' ) );
							} elseif ($stage_type == constant ( 'STAGE_TYPE_POOLS_POOLS' )) {
								
								$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
								$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
							} elseif ($stage_type == constant ( 'STAGE_TYPE_POOLS' )) {
								$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
							} elseif ($stage_type == constant ( 'STAGE_TYPE_CUP' )) {
								$this->createStage ( $class_in_tournament_id, 'Cup', constant ( 'STAGE_CUP' ) );
							}
						}
					}
				}
			}
			
			$this->Session->setFlash ( __ ( 'tinfo_update' ) );
			$this->redirect ( "/Tournaments/show/" . $tournament_id );
		}
		
		$tournament = $this->Tournament->find ( "first", array (
				'conditions' => array (
						'Tournament.id' => $id 
				),
				'contain' => array (
						'ClassInTournament' => array (
								'TournamentClass',
								'Stage' 
						) 
				) 
		) );
		
		$this->set ( "tournamentclasses", $this->TournamentClass->find ( "list" ) );
		
		$tournament ['Tournament'] ['startdate'] = DateTime::createFromFormat ( "Y-m-d", $tournament ['Tournament'] ['startdate'] )->format ( "d.m.Y" );
		$tournament ['Tournament'] ['enddate'] = DateTime::createFromFormat ( "Y-m-d", $tournament ['Tournament'] ['enddate'] )->format ( "d.m.Y" );
		$tournament ['Tournament'] ['cuttingdate'] = DateTime::createFromFormat ( "Y-m-d", $tournament ['Tournament'] ['cuttingdate'] )->format ( "d.m.Y" );
		$tournament ['Tournament'] ['registration_ends'] = DateTime::createFromFormat ( "Y-m-d H:i:s", $tournament ['Tournament'] ['registration_ends'] )->format ( "d.m.Y H:i:s" );
		
		$this->request->data = $tournament;
	}
	public function add() {
		
		// $this->set("tournaments", $this->Tournament->find("all"));
		$this->set ( "tournamentclasses", $this->TournamentClass->find ( "list" ) );
		
		if ($this->request->is ( 'post' )) {
			
			$dataArray ['Tournament'] = $this->request->data ['Tournament'];
			
			$startdate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['startdate'] );
			$enddate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['enddate'] );
			$cuttingdate = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['cuttingdate'] );
			$registration_ends = DateTime::createFromFormat ( "d.m.Y", $dataArray ['Tournament'] ['registration_ends'] );
			
			$dataArray ['Tournament'] ['startdate'] = $startdate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['enddate'] = $enddate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['cuttingdate'] = $cuttingdate->format ( "Y-m-d" );
			$dataArray ['Tournament'] ['registration_ends'] = $registration_ends->format ( "Y-m-d" );
			
			// transaction start
			$dataSource = ConnectionManager::getDataSource ( 'default' );
			$dataSource->begin ();
			
			try {
				if ($this->Tournament->save ( $dataArray )) {
					
					$tournament_id = $this->Tournament->getLastInsertID ();
					
					if (isset ( $this->request->data ['TournamentClass'] )) {
						
						foreach ( $this->request->data ['TournamentClass'] as $i => $class ) {
							
							if ($class ['tournament_class_id'] != 0) {
								$this->Tournament->ClassInTournament->create ();
								
								$dataArray ['ClassInTournament'] = array (
										"tournament_class_id" => $class ['tournament_class_id'],
										"tournament_id" => $tournament_id,
										"date" => $class ['date'],
										"price" => $class ['price'],
										"stage_type" => $class ['stage_type'] 
								);
								
								$dataArray ['ClassInTournament'] ['date'] = DateTime::createFromFormat ( "d.m.Y", $dataArray ['ClassInTournament'] ['date'] )->format ( "Y-m-d" );
								$dataArray ['ClassInTournament'] ['price'] = floatval ( str_replace ( ',', '.', str_replace ( '.', '', $dataArray ['ClassInTournament'] ['price'] ) ) );
								$dataArray ['ClassInTournament'] ['pool_num'] = intval ( trim ( $class ['pool_num'] ) );
								$dataArray ['ClassInTournament'] ['stage_type'] = trim ( $class ['stage_type'] );
								
								$this->Tournament->ClassInTournament->save ( $dataArray );
								
								if (isset ( $dataArray ['ClassInTournament'] ['stage_type'] )) {
									
									$class_in_tournament_id = $this->Tournament->ClassInTournament->getLastInsertID ();
									$stage_type = $dataArray ['ClassInTournament'] ['stage_type'];
									if ($stage_type == constant ( 'STAGE_TYPE_POOLS_CUP' )) {
										
										$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
										$this->createStage ( $class_in_tournament_id, 'Cup', constant ( 'STAGE_CUP' ) );
									} elseif ($stage_type == constant ( 'STAGE_TYPE_POOLS_POOLS' )) {
										
										$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
										$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
									} elseif ($stage_type == constant ( 'STAGE_TYPE_POOLS' )) {
										$this->createStage ( $class_in_tournament_id, 'Pools', constant ( 'STAGE_POOL' ) );
									} elseif ($stage_type == constant ( 'STAGE_TYPE_CUP' )) {
										$this->createStage ( $class_in_tournament_id, 'Cup', constant ( 'STAGE_CUP' ) );
									}
								}
							}
						}
					}
					
					$dataSource->commit ();
					
					$this->Session->setFlash ( __ ( 'Uusi turnaus tehty.' ) );
					$this->redirect ( "/Tournaments/show/" . $tournament_id );
				} else {
					$this->Session->setFlash ( __ ( 'Uuden turnauksen luominen epäonnistui.' ) );
				}
			} catch ( Exception $e ) {
				
				// log Exception...
				$dataSource->rollback ();
				$this->Session->setFlash ( __ ( 'Uuden turnauksen luominen epäonnistui.' ) );
			}
		}
	}
	private function createStage($class_in_tournament_id, $name, $type) {
		$this->Tournament->ClassInTournament->Stage->create ();
		$dataArray ['Stage'] = array (
				"class_in_tournament_id" => $class_in_tournament_id,
				"name" => $name,
				"type" => $type 
		);
		
		$this->Tournament->ClassInTournament->Stage->save ( $dataArray );
	}
	public function register($tournament_id) {
		$tournament = $this->Tournament->find ( "first", array (
				'conditions' => array (
						'Tournament.id' => ( int ) $tournament_id 
				),
				'contain' => array (
						'ClassInTournament' => array (
								'TournamentClass',
								'Registration',
								'order' => 'ClassInTournament.date' 
						) 
				) 
		) );
		
		if ($this->request->is ( 'post' )) {
			
			$data = $this->request->data;
			$registered = 0;
			$success = true;
			// Add registrations
			foreach ( $data ['Player'] as $player ) {
				$player_id = $player ['player_id'];
				
				if (isset ( $player ['ClassInTournament'] )) {
					
					foreach ( $player ['ClassInTournament'] as $class ) {
						
						if (isset ( $class ['register'] )) {
							$registered = 1;
							$this->Registration->create ();
							
							$registration ['Registration'] ['player_id'] = $player_id;
							$registration ['Registration'] ['tournament_class_id'] = $class ['tournament_class_id'];
							
							if ($this->Registration->save ( $registration )) {
								$success = $success;
							} else {
								$success = false;
							}
						}
					}
				}
				
				if ($registered) {
					$this->Session->setFlash ( __ ( "reg_recorded" ) );
					
					$email = $this->Auth->user ( "email" );
					$start = DateTime::createFromFormat ( "Y-m-d", $tournament ['Tournament'] ['startdate'] );
					
					$message = "Kiitos ilmoittautumisesta turnaukseen " . $tournament ['Tournament'] ['name'] . "\r\n";
					
					$message .= "Turnaus järjestetään " . $start->format ( "d.m.Y" );
					
					if ($tournament ['Tournament'] ['enddate'] != "" && $tournament ['Tournament'] ['enddate'] = $tournament ['Tournament'] ['startdate']) {
						$end = DateTime::createFromFormat ( "Y-m-d", $tournament ['Tournament'] ['enddate'] );
						$message .= " - " . $end->format ( "d.m.Y" );
					}
					
					$message .= "\r\n" . "\r\n";
					
					$message .= __ ( "received_reg" ) . "\r\n";
					
					foreach ( $data ['Player'] as $player ) {
						$message .= $player ['name'] . "\r\n";
						$price = 0;
						
						foreach ( $player ['ClassInTournament'] as $class ) {
							if (isset ( $class ['register'] )) {
								$price = $price + $class ['price'];
								$date = DateTime::createFromFormat ( "Y-m-d", $class ['date'] );
								$message .= "   " . $class ['name'] . " " . $date->format ( "d.m.Y" ) . " " . number_format ( $class ['price'], 2, ",", " " ) . "\r\n";
							}
						}
						
						$message .= "Yhteensä: " . number_format ( $price, 2, ",", " " ) . "\r\n";
						
						$message .= "--------------------------------------------------------------- \r\n";
					}
					
					$message .= "\r\n" . "Terveisin,\r\n Pingismaisteri";
					
					// Sends email to user
					
					$Email = new CakeEmail ();
					$Email->from ( array (
							'pingismaisteri@gmail.com' => 'Pingismaisteri' 
					) );
					$Email->to ( $email );
					$Email->subject ( 'Pingismaisteri ilmoittautumisvahvistus' );
					$Email->send ( $message );
				} else {
					$this->Session->setFlash ( __ ( "Ilmoittautumisissa oli ongelma, tarkista ilmoittautumiset" ) );
				}
				
				// $this->redirect( array("controller" => "tournaments", "action" => "show", $tournament) );
			}
		}
		
		$players = $this->User->find ( "first", array (
				'contain' => array (
						'Player' => array (
								'Registration' 
						) 
				),
				'conditions' => array (
						'User.id' => $this->Auth->user ( "id" ) 
				) 
		) );
		
		$this->set ( "tournament", $tournament );
		$this->set ( "players", $players );
	}
	public function show($tournament_id) {
		$tournament = $this->Tournament->find ( "first", array (
				'conditions' => array (
						'Tournament.id' => ( int ) $tournament_id 
				),
				'contain' => array (
						'ClassInTournament' => array (
								'TournamentClass',
								'Registration' => array (
										'Player' => array (
												'Club' 
										) 
								),
								'order' => 'ClassInTournament.date ASC' 
						)
						 
				) 
		) );
		
		/*
		 * $stages=$this->Stage->find('all',
		 *
		 * array(
		 * 'conditions' => array(
		 * 'Stage.tournament_id' => (int)$tournament_id,
		 * )
		 * )
		 * );
		 */
		
		$this->set ( "tournament", $tournament );
		// $this->set("stages", $stages);
	}
	public function deleteTournament($id) {
		$this->Tournament->delete ( $id );
		
		$this->redirect ( $this->referer () );
	}
	public function collectTournamentData($tournament_id) {
		// get tournament and registration data
		$tournament = $this->Tournament->find ( "first", array (
				'contain' => array (
						'ClassInTournament' => array (
								'TournamentClass',
								'Registration' => array (
										'Player' 
								) 
						) 
				) 
		) );
		
		// debug($tournament);
		
		// get cuttingdate
		$cuttingdate = $tournament ['Tournament'] ['cuttingdate'];
		
		// toimivuus testata vielä
		$rating = $this->Rating->find ( "first", array (
				'conditions' => array (
						'Rating.date <=' => $tournament ['Tournament'] ['cuttingdate'] 
				),
				'order' => 'date DESC',
				'contain' => array (
						'RatingRow' => array (
								'Player' 
						) 
				) 
		) );
		
		// json olio
		$data = array (
				$tournament,
				$rating 
		);
		
		$tournamentJsonFileName = $tournament ['Tournament'] ['name'] . "_" . $tournament ['Tournament'] ['startdate'] . ".pmt";
		
		$this->response->body ( json_encode ( $data ) );
		$this->response->type ( 'json' );
		
		// Optionally force file download
		$this->response->download ( $tournamentJsonFileName );
		
		// Return response object to prevent controller from trying to render
		// a view
		return $this->response;
	}
	public function downloadTournamentData() {
		$this->viewClass = 'Media';
		
		$p = array (
				'id' => $this->Session->read ( "tournamentJsonFileName" ),
				'name' => $this->Session->read ( "fileSaveName" ),
				'download' => true,
				'extension' => 'json',
				'path' => APP . 'webroot/' . DS 
		);
		
		$this->set ( $p );
	}
	
	// Poolien arvontaan
	public function drawPools($tournament_id) {
		$tournament = $this->Tournament->find ( "first", array (
				'conditions' => array (
						'Tournament.id' => $tournament_id 
				),
				'contain' => array (
						'ClassInTournament' => array (
								'TournamentClass',
								'Stage' => array (
										'Pool' => array (
												'Game' => array (
														'Set' 
												) 
										) 
								),
								'Registration' => array (
										'Player' 
								) 
						)
						 
				) 
		) );
		
		$this->set ( 'tournament', $tournament );
		
		// draw pool
		if ($this->request->is ( 'post' )) {
			
			// get parameters
			$minimize_same_club = Detect::issetValueNull ( $this->request->data ['PoolForm'] ['minimize_same_club'] );
			$minimize_same_player = Detect::issetValueNull ( $this->request->data ['PoolForm'] ['minimize_same_player'] );
			
			// get selected class
			$selected_class = array_filter ( $this->request->data ['ClassInTournament'], function ($class) {
				if (array_key_exists ( 'is_to_draw', $class ) && $class ['is_to_draw'] == 1) {
					return true;
				} else {
					return false;
				}
			} );
			
			// update pool num
			foreach ( $selected_class as &$t_class ) {
				$class_data = array ();
				$class_data ['ClassInTournament'] = array ();
				$class_data ['ClassInTournament'] ['id'] = $t_class ['id'];
				$class_data ['ClassInTournament'] ['pool_num'] = $t_class ['pool_num'];
				$this->Tournament->ClassInTournament->save ( $class_data );
			}
			
			// do draw pools
			$class_id_arr = AppUtil::extractNewArray ( $selected_class, [ 
					'id' 
			] );
			$groups_of_pools = $this->Pool->drawPools ( $class_id_arr, $minimize_same_club, $minimize_same_player );
			
			return $this->redirect ( '/tournaments/drawPools/' . $tournament_id );
			
			/*
			 * $t_stage=$this->Stage->find('first',
			 * array(
			 * 'conditions' => array(
			 * 'Stage.id' => $stage_select_id
			 * )
			 * )
			 * );
			 *
			 *
			 * if($t_stage['Stage']['type']==constant('STAGE_TYPE_POOL')){
			 *
			 * $this->Pool->savePoolAgenda($playerList,
			 * $t_stage,
			 * $pool_opt_select,
			 * $pool_num,
			 * $minimize_same_club,
			 * $minimize_same_player,
			 * $fp_size,
			 * $np_size);
			 *
			 * }elseif ($t_stage['Stage']['type']==constant('STAGE_TYPE_CUP')){
			 *
			 *
			 *
			 *
			 * }else{
			 *
			 *
			 *
			 * }
			 *
			 * //return download excel
			 * $this->exportAgendaExcel($tournament_id,$t_stage,$class_in_tournament_id);
			 */
		}
	}
	public function downloadPoolInfo($class_in_tournament_id) {
		$cit = $this->ClassInTournament->find ( "first", array (
				'conditions' => array (
						'ClassInTournament.id' => $class_in_tournament_id 
				),
				'contain' => array (
						'Stage' 
				) 
		)
		 );
		
		return $this->exportAgendaExcel ( $cit ['ClassInTournament'] ['tournament_id'], $cit ['Stage'] [0], $class_in_tournament_id );
	}
	protected function exportAgendaExcel($tournament_id, $t_stage, $class_in_tournament_id) {
		$t_tournament = $this->Tournament->find ( 'first', array (
				'conditions' => array (
						'Tournament.id' => $tournament_id 
				) 
		) );
		
		$cit = $this->ClassInTournament->find ( 'first', array (
				
				'conditions' => array (
						'ClassInTournament.id' => $class_in_tournament_id 
				),
				'fields' => array (
						'ClassInTournament.*' 
				) 
		) );
		
		$tournament_class = $this->TournamentClass->find ( 'first', array (
				'conditions' => array (
						'TournamentClass.id' => $cit ['ClassInTournament'] ['tournament_class_id'] 
				) 
		) );
		/*
		 * $pool_list=$this->Pool->find('all',
		 * array('contain' => true),
		 * array(
		 * 'conditions' => array('Stage.id' => $t_stage['id'])
		 * )
		 * );
		 */
		
		$pool_list = $this->Pool->find ( 'all', 

		array (
				'conditions' => array (
						'Pool.stage_id' => $t_stage ['id'] 
				),
				'contain' => array (
						'PlayerInPool',
						'Game' => array (
								'order' => 'Game.seq_no',
								'Set' => array (
										'order' => 'Set.seq_no' 
								) 
						) 
				),
				'order' => '' 
		) );
		
		$pool_capacity = 0;
		foreach ( $pool_list as &$each_pool ) {
			if (count ( $each_pool ['PlayerInPool'] ) > $pool_capacity) {
				$pool_capacity = count ( $each_pool ['PlayerInPool'] );
			}
		}
		
		if ($t_stage ['type'] == constant ( 'STAGE_POOL' )) {
			
			$objPHPExcel = new PHPExcel ();
			
			$objPHPExcel->getProperties ()->setCreator ( "Pingismaisteri" )->setLastModifiedBy ( "Pingismaisteri" )->setTitle ( "AgendaExport" )->setSubject ( "AgendaExport" )->setDescription ( "AgendaExport" )->setKeywords ( "excel" )->setCategory ( "result file" );
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			$this->writeTitleInExcel ( $objPHPExcel, $t_tournament, $tournament_class, $t_stage, 2, 'B' );
			
			$height_index = 6;
			foreach ( $pool_list as &$pool_data ) {
				
				$delta_height = $this->writePoolInExcel ( $objPHPExcel, $pool_data, $pool_capacity, $height_index, 'A' );
				$height_index += $delta_height + 3;
				// $delta_2_height=$this->writePoolResultInExcel($objPHPExcel,$pool_data,$pool_capacity, $height_index, 'C');
				// $height_index+=$delta_2_height+1;
			}
			
			header ( 'Content-Type:application/download' );
			header ( 'Content-Type:application/force-download' );
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="Agenda_' . $t_stage ['id'] . '_' . $t_stage ['type'] . '_' . date ( "h-i-sa" ) . '.xls"' );
			header ( 'Cache-Control: max-age=0' );
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			$objWriter->save ( 'php://output' );
			exit ();
		} elseif ($t_stage ['type'] == constant ( 'STAGE_CUP' )) {
		}
	}
	protected function writeTitleInExcel($objPHPExcel, $t_tournament, $tournament_class, $t_stage, $start_x_index, $start_y_index) {
		foreach ( range ( 'A', 'Z' ) as $letter ) {
			$objPHPExcel->getActiveSheet ()->getColumnDimension ( $letter )->setAutoSize ( true );
		}
		
		// $this->writeCell($objPHPExcel,$t_tournament['Tournament']['name'],'setTitleStyle',$start_x_index,$start_y_index);
		$objPHPExcel->getActiveSheet ()->setCellValue ( strval ( $start_y_index ) . strval ( $start_x_index ), $t_tournament ['Tournament'] ['name'] );
		$this->setTitleStyle ( $objPHPExcel, $start_x_index, $start_y_index );
		// $this->writeCell($objPHPExcel,$tournament_class['TournamentClass']['name'],'setSubTitleStyle',$start_x_index+1,$start_y_index);
		$objPHPExcel->getActiveSheet ()->setCellValue ( strval ( $start_y_index ) . strval ( $start_x_index + 1 ), $tournament_class ['TournamentClass'] ['name'] );
		$this->setSubTitleStyle ( $objPHPExcel, $start_x_index + 1, $start_y_index );
	}
	protected function writePoolInExcel($objPHPExcel, $pool_data, $pool_capacity, $start_x_index, $start_y_index) {
		$this->writeCell ( $objPHPExcel, 'RN', '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 1 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_p' ) . ' ' . $pool_data ['Pool'] ['name'], '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 2 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_s' ), '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 3 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_v' ), '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 4 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_e' ), '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 5 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_pi' ), '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 6 ) );
		$this->writeCell ( $objPHPExcel, __ ( 'pool_xls_col_si' ), '', $start_x_index, chr ( ord ( strval ( $start_y_index ) ) + 7 ) );
		
		// modify styles of cell by range
		$style_array = array (
				'borders' => array (
						'top' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'left' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'bottom' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'right' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						) 
				),
				'font' => array (
						'name' => 'Arial',
						'size' => '11' 
				) 
		)
		;
		$highestColumn = chr ( ord ( strval ( $start_y_index ) ) + 7 );
		$highestRow = $start_x_index + $pool_capacity;
		$objPHPExcel->getActiveSheet ()->getStyle ( $start_y_index . $start_x_index . ':' . $highestColumn . $highestRow )->applyFromArray ( $style_array, false );
		
		for($i = 0; $i < $pool_capacity; $i ++) {
			$this->writeCell ( $objPHPExcel, $i + 1, '', $start_x_index + $i + 1, $start_y_index );
		}
		
		$player_ids = array ();
		foreach ( $pool_data ['PlayerInPool'] as &$t_pip ) {
			array_push ( $player_ids, $t_pip ['player_id'] );
		}
		
		$query_sql = <<<EOF
SELECT 
    `Player`.*,
    `RatingRow`.*,
    `Club`.*,
    `PlayerInPool`.*,
    (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))) AS `Player__age`
FROM
    `pingismaisteri`.`pingis2_players` AS `Player`
        LEFT JOIN
    `pingismaisteri`.`pingis2_rating_rows` AS `RatingRow` ON (`Player`.`id` = `RatingRow`.`player_id`
        AND `RatingRow`.`rating_id` = 1)
        LEFT JOIN
    `pingismaisteri`.`pingis2_player_in_pools` AS `PlayerInPool` ON (`Player`.`id` = `PlayerInPool`.`player_id`
        AND `PlayerInPool`.`pool_id` = ?)
        LEFT JOIN
    `pingismaisteri`.`pingis2_clubs` AS `Club` ON (`Player`.`club_id` = `Club`.`id`)
WHERE
    `Player`.`id` IN (
EOF;
		
		$query_sql = $query_sql . implode ( ',', $player_ids ) . ')';
		
		$db = ConnectionManager::getDataSource ( 'default' );
		$pool_players = $db->fetchAll ( $query_sql, array (
				$pool_data ['Pool'] ['id'] 
		) );
		
		// resort the player array by pool order
		usort ( $pool_players, array (
				$this,
				"pool_order_sort" 
		) );
		
		for($i = 0; $i < $pool_capacity; $i ++) {
			
			$t_pp = array_shift ( $pool_players );
			if (isset ( $t_pp )) {
				$this->writeCell ( $objPHPExcel, $t_pp ['RatingRow'] ['rating'], '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 1 ) );
				$this->writeCell ( $objPHPExcel, $t_pp ['Player'] ['firstname'] . ' ' . $t_pp ['Player'] ['lastname'], '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 2 ) );
				$this->writeCell ( $objPHPExcel, $t_pp ['Club'] ['name'], '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 3 ) );
			} else {
				$this->writeCell ( $objPHPExcel, '', '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 1 ) );
				$this->writeCell ( $objPHPExcel, '', '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 2 ) );
				$this->writeCell ( $objPHPExcel, '', '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 3 ) );
			}
		}
		
		$result_x_index = $start_x_index + $pool_capacity + 2;
		// $start_y_index + 2个字母
		$result_y_index = chr ( ord ( strval ( $start_y_index ) ) + 2 );
		
		// 计算最大行数num_game+1
		$result_row_num = count ( $pool_data ['Game'] ) + 1;
		// 计算最大列数 最大set数量+3
		$max_num_set = 0;
		foreach ( $pool_data ['Game'] as &$t_game ) {
			$set_num = count ( $t_game ['Set'] );
			if ($set_num > $max_num_set) {
				$max_num_set = $set_num;
			}
		}
		$result_col_num = $max_num_set + 3;
		
		if ($result_row_num > 0 && $result_col_num > 3) {
			$this->writeCell ( $objPHPExcel, '', '', $start_x_index + $i + 1, chr ( ord ( strval ( $start_y_index ) ) + 1 ) );
			for($j = 0; $j < $max_num_set; $j ++) {
				$this->writeCell ( $objPHPExcel, ($j + 1) . ' ' . __ ( 'draw_set' ), '', $result_x_index, chr ( ord ( strval ( $result_y_index ) ) + $j + 1 ) );
			}
			$this->writeCell ( $objPHPExcel, __ ( 'draw_excel_match' ), '', $result_x_index, chr ( ord ( strval ( $result_y_index ) ) + $j + 1 ) );
			$this->writeCell ( $objPHPExcel, __ ( 'draw_excel_judge' ), '', $result_x_index, chr ( ord ( strval ( $result_y_index ) ) + $j + 2 ) );
			
			$pool_games = $pool_data ['Game'];
			
			for($j = 0; $j < count ( $pool_games ); $j ++) {
				
				$t_pg = $pool_games [$j];
				$t_g_sets = $t_pg ['Set'];
				
				$aplayer_no = intval ( array_search ( $t_pg ['a_player_id'], $player_ids ) ) + 1;
				$bplayer_no = intval ( array_search ( $t_pg ['b_player_id'], $player_ids ) ) + 1;
				$this->writeCell ( $objPHPExcel, $aplayer_no . '-' . $bplayer_no, '', $result_x_index + $j + 1, $result_y_index );
				
				for($k = 0; $k < count ( $t_g_sets ); $k ++) {
					$t_set = $t_g_sets [$k];
					$this->writeCell ( $objPHPExcel, $t_set ['a_point'] . '-' . $t_set ['b_point'], '', $result_x_index + $j + 1, chr ( ord ( strval ( $result_y_index ) ) + $k + 1 ) );
				}
			}
			
			// Set style
			$result_highestColumn = chr ( ord ( strval ( $result_y_index ) ) + $result_col_num - 1 );
			$result_highestRow = $result_x_index + $result_row_num - 1;
			$objPHPExcel->getActiveSheet ()->getStyle ( $result_y_index . $result_x_index . ':' . $result_highestColumn . $result_highestRow )->applyFromArray ( $style_array, false );
			
			// 返回增加了result的行数
			return $pool_capacity + 2 + $result_row_num;
		} else {
			return $pool_capacity + 2;
		}
	}
	protected function writePoolResultInExcel($objPHPExcel, $pool_data, $pool_capacity, $start_x_index, $start_y_index) {
	}
	private function pool_order_sort($a_player, $b_player) {
		$a_order = intval ( $a_player ['PlayerInPool'] ['order'] );
		$b_order = intval ( $b_player ['PlayerInPool'] ['order'] );
		if ($a_order == $b_order)
			return 0;
		return ($a_order > $b_order) ? 1 : - 1;
	}
	protected function writeCupInExcel() {
	}
	protected function writeCell($objPHPExcel, $value, $styleFunc, $start_x_index, $start_y_index) {
		$objPHPExcel->getActiveSheet ()->setCellValue ( strval ( $start_y_index ) . strval ( $start_x_index ), $value );
		// call_user_func(array($this, $styleFunc), $objPHPExcel, $start_x_index, $start_y_index);
	}
	protected function setTitleStyle($objActSheet, $start_x_index, $start_y_index) {
		
		// get the style of this cell
		$objStyle = $objActSheet->getActiveSheet ()->getStyle ( strval ( $start_y_index ) . strval ( $start_x_index ) );
		
		$objFont = $objStyle->getFont ();
		$objFont->setName ( 'Arial' );
		$objFont->setSize ( 14 );
		$objFont->setBold ( true );
		/*
		 * $objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
		 * $objFontA5->getColor()->setARGB('FF999999');
		 * $objAlignA5 = $objStyleA5->getAlignment();
		 * $objAlignA5->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		 * $objAlignA5->setVertical(PHPExcel_Style_Alignment::VERTIER);
		 */
		/*
		 * // set border
		 * $objBorderA5 = $objStyleA5->getBorders();
		 * $objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 * $objBorderA5->getTop()->getColor()->setARGB('FF000000');// color
		 * $objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 * $objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 * $objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_BORDER_THIN);
		 */
		/*
		 * //set color
		 * $objFillA5 = $objStyleA5->getFill();
		 * $objFillA5->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		 * $objFillA5->getStartColor()->setARGB('FFEEEEEE');
		 */
	}
	protected function setSubTitleStyle($objActSheet, $start_x_index, $start_y_index) {
		
		// get the style of this cell
		$objStyle = $objActSheet->getActiveSheet ()->getStyle ( strval ( $start_y_index ) . strval ( $start_x_index ) );
		
		$objFont = $objStyle->getFont ();
		$objFont->setName ( 'Arial' );
		$objFont->setSize ( 12 );
	}
	
	/*
	 * protected function setTextCellStyle($objPHPExcel,$start_x_index,$start_y_index){
	 *
	 * //get the style of this cell
	 * $objStyle= $objPHPExcel->getActiveSheet()->getStyle(strval($start_y_index).strval($start_x_index));
	 *
	 * $objFont= $objStyle->getFont();
	 * $objFont->setName('Arial');
	 * $objFont->setSize(11);
	 *
	 * // set border
	 * $objBorder = $objStyle->getBorders();
	 * $objBorder->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 * $objBorder->getTop()->getColor()->setARGB('FF000000');
	 * $objBorder->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 * $objBorder->getBottom()->getColor()->setARGB('FF000000');
	 * $objBorder->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 * $objBorder->getLeft()->getColor()->setARGB('FF000000');
	 * $objBorder->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 * $objBorder->getRight()->getColor()->setARGB('FF000000');
	 *
	 * }
	 */
	public function newStageTypeRow($i) {
		$types = array (
				constant ( "STAGE_POOL" ) => 'POOL_STAGE',
				constant ( "STAGE__CUP" ) => 'CUP_STAGE' 
		);
		
		$this->set ( "types", $types );
		// $this->set("iterator", $i);
	}
	public function sendEmail($id) {
		// Sends email to all registered players
		$Email = new CakeEmail ();
		$Email->from ( array (
				'pingismaisteri@gmail.com' => 'Pingismaisteri' 
		) );
		$Email->to ( 'jere@datavalas.net' );
		$Email->subject ( 'About' );
		$Email->send ( 'My message' );
	}
	public function downloadCupInfo($class_in_tournament_id) {
		$cupInfo = $this->ClassInTournament->getCupAgenda ( $class_in_tournament_id );
		
		// .....输出excel
	}
}
?>