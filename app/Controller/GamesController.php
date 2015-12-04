<?php

class GamesController extends AppController {

   public $helpers = array('Html', 'Form');
   
   public $uses = array( 'Tournament', 'TournamentClass', 'Registration', 'TournamentClasses', 
   						'ClassInTournament', 'Rating', 'RatingRow', 'Player', 'Pool', 'PlayerInPool', 'Stage' ,'Game', 'Set', 'A_Player', 'B_Player');
   

   
	public function view() {
		
		
		/*
		$pools=$this->Pool->find('all',
				
				array(
					'condition'=>array(
						'Stage.id'=>1
					)
				)
		);
		
		
		
		foreach($pools as &$t_pool){
			$this->Game->deleteAll(array('Pool.id' => $t_pool['Pool']['id']), true);
		}
		
		
		$pool_01=$pools[0];
		
		$game_data=array();
		$game_data['a_player_id']=$pool_01['PlayerInPool'][0]['player_id'];
		$game_data['b_player_id']=$pool_01['PlayerInPool'][1]['player_id'];
		$game_data['seq_no']='1';
		$game_01_id=$this->Game->saveGame($game_data,$pool_01['Pool']['id']);
		
		$set_data=array();
		$set_data['a_point']='11';
		$set_data['b_point']='3';
		$set_data['seq_no']='1';
		$set_01_id=$this->Game->saveSet($set_data,$game_01_id);
		
		
		$game_data2=array();
		$game_data2['a_player_id']=$pool_01['PlayerInPool'][0]['player_id'];
		$game_data2['b_player_id']=$pool_01['PlayerInPool'][2]['player_id'];
		$game_data2['seq_no']='2';
		$game_02_id=$this->Game->saveGame($game_data2,$pool_01['Pool']['id']);
		
		$set_data2=array();
		$set_data2['a_point']='11';
		$set_data2['b_point']='9';
		$set_data2['seq_no']='1';
		$set_02_id=$this->Game->saveSet($set_data2,$game_02_id);
		
		
		
		$new_pools=$this->Pool->find('all',
		
				array(
						'condition'=>array(
								'Stage.id'=>1
						),
						'field' => array(
								'Pool.*',
								'Game.*',
								'PlayerInPool.*'
						)
				)
		);
		
		
		$this->set("pools", $new_pools);
		
		
		*/
	}
	
	public function show($tournament_id) {
		 
		
		$tournament = $this->Tournament->find("first",
				array(
						'conditions' => array(
								'Tournament.id' => $tournament_id
						),
						'contain' => array(
								'ClassInTournament' => array(
										'TournamentClass',
										'Stage' => array(
												'Pool' => array(
														'PlayerInPool' => array(
																'Player'
														)
												)
										)
								)
						)
				)
		);
		
		$this->set('tournament', $tournament);
	
	
	}
	
	public function result($pool_id) {
		if (!$pool_id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$pools = $this->Pool->find('first',array(
				'conditions' => array('Pool.id' => $pool_id
				),
				'contain' => array(
							'Game' => array(
									'Set',
									'A_Player',
									'B_Player'
							),
							'Stage' => array(
									'ClassInTournament' => array(
											'Tournament'
									)
							)
						)				
					)
		);
		if (!$pools) {
			throw new NotFoundException(__('Invalid post'));
		}
		
		$this->set('pools', $pools);
	}
	
	
	
	
   public function add($game_id) {
   	
   	
   	$querysql=<<<EOF
SELECT 
    `Game`.`id`,
    `Game`.`a_player_id`,
    `Game`.`b_player_id`,
    `Game`.`seq_no`,
    `Game`.`pool_id`,
    `Game`.`result_set`,
    `Pool`.`id`,
    `Pool`.`class_id`,
    `Pool`.`name`,
    `Pool`.`type`,
    `Pool`.`stage_id`,
    `Pool`.`game_num`,
    `A_Player`.`id`,
    `A_Player`.`firstname`,
    `A_Player`.`lastname`,
    `A_Player`.`address`,
    `A_Player`.`postalcode`,
    `A_Player`.`postarea`,
    `A_Player`.`birthday`,
    `A_Player`.`sex`,
    `A_Player`.`club_id`,
    `A_Player`.`license_code`,
    `A_Player`.`license_status`,
    `A_Player`.`license_renewed`,
    `A_Player`.`license_type`,
    `A_Player`.`email`,
    `A_Player`.`phone`,
    `A_Player`.`created`,
    `A_Player`.`added_by`,
    `A_Player`.`rating_id`,
    `A_Player`.`sptl_id`,
   	`B_Player`.`id`,
    `B_Player`.`firstname`,
    `B_Player`.`lastname`,
    `B_Player`.`address`,
    `B_Player`.`postalcode`,
    `B_Player`.`postarea`,
    `B_Player`.`birthday`,
    `B_Player`.`sex`,
    `B_Player`.`club_id`,
    `B_Player`.`license_code`,
    `B_Player`.`license_status`,
    `B_Player`.`license_renewed`,
    `B_Player`.`license_type`,
    `B_Player`.`email`,
    `B_Player`.`phone`,
    `B_Player`.`created`,
    `B_Player`.`added_by`,
    `B_Player`.`rating_id`,
    `B_Player`.`sptl_id`
FROM
    `pingismaisteri`.`pingis2_games` AS `Game`
        LEFT JOIN
    `pingismaisteri`.`pingis2_pools` AS `Pool` ON (`Game`.`pool_id` = `Pool`.`id`)
        LEFT JOIN
    `pingismaisteri`.`pingis2_players` AS `A_Player` ON (`Game`.`a_player_id` = `A_Player`.`id`)
        LEFT JOIN
    `pingismaisteri`.`pingis2_players` AS `B_Player` ON (`Game`.`b_player_id` = `B_Player`.`id`)
WHERE
    `Game`.`id` = ?
LIMIT 1
EOF;
   	
   	$db = ConnectionManager::getDataSource ( 'default' );
   	$the_game = $db->fetchAll ( $querysql, array (
   			$game_id
   	) );
   	
   	
   	$this->set('the_game', $the_game[0]);
   	
   	if ($this->request->is('post')) {
   		$set_data=$this->request->data;
   		$set_data['Set']['win_status']=(intval($set_data['Set']['a_point']) > intval($set_data['Set']['b_point'])) ? 1 : -1;
   		$this->Set->create();
   		if ($this->Set->save($set_data)) {
   			//$this->Flash->success(__('Your result has been added.'));
   			//$poolid = $this->Game->find('first', array('condition' => array('Game.id' => $game_id)));
   			//return $this->redirect('/result/'.$poolid['pool_id']);
   			
   			
   			return $this->redirect('/games/result/'.$the_game[0]['Pool']['id']);
   		}   		
   		//$this->Flash->error(__('Unable to add your post.'));
   	}
     $this->set('gameId', $game_id);     
   }
   
   public function deleteR($id)
   {
   	$this->Set->delete($id);
   	
   	return $this->redirect($this->referer());
   	
      
   }
   
}
?>