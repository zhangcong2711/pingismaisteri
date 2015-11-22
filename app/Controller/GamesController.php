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
							)
						)				
					)
		);
		if (!$pools) {
			throw new NotFoundException(__('Invalid post'));
		}
		
		$this->set('pools', $pools);
		//$this->set('game_id', $pools['Game']['id']);
	}
	
	
	
	
   public function add($game_id) {
   	if ($this->request->is('post')) {
   		$this->Set->create();
   		if ($this->Set->save($this->request->data)) {
   			//$this->Flash->success(__('Your result has been added.'));
   			//$poolid = $this->Game->find('first', array('condition' => array('Game.id' => $game_id)));
   			//return $this->redirect('/result/'.$poolid['pool_id']);
   			
   			$game=$this->Game->find('first',
   					array(
   							'conditions' => array('Game.id' => $game_id),
   							'contain' => array( 'Pool' )
   					)
   						
   			);
   			return $this->redirect('/games/result/'.$game['Pool']['id']);
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