<?php

class GamesController extends AppController {

   public $helpers = array('Html', 'Form');
   
   public $uses = array( 'Tournament', 'TournamentClass', 'Registration', 'TournamentClasses', 'ClassInTournament', 'Rating', 'RatingRow', 'Player', 'Pool', 'PlayerInPool', 'Stage' ,'Game', 'Set');
   

   
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
		
		//.....................
	}
	
	
	
	
   public function add() {
   		
      	
      	
   }
   
   public function delete()
   {
      
      
   }
   
}
?>