<?php
App::uses('AppModel', 'Model');
/**
 * Club Model
 *
 * @property Club $Club
 */
class ClassInTournament extends AppModel {

   public $useTable = 'class_in_tournaments';
   
	public $belongsTo = array(
		'Tournament' => array(
			'className' => 'Tournament',
			'foreignKey' => 'tournament_id',
			'dependent' => false
		),
      'TournamentClass' => array(
			'className' => 'TournamentClass',
			'foreignKey' => 'tournament_class_id',
			'dependent' => false
      )
	);
   
   public $hasMany = array(
      'Registration' => array(
         'className' => 'Registration',
         'foreignKey' => 'tournament_class_id',
         'dependent' => true
      ),
   		
   	  'Stage' => array(
   		  'className' => 'Stage',
   		  'foreignKey' => 'class_in_tournament_id',
   		  'dependent' => true
   	  )
   );
   
   
   public function getCupAgenda($class_in_tournament){
   	
	   	$cit = $this->find("first",
	   			array(
	   					'conditions' => array(
	   							'Stage.class_in_tournament_id' => $class_in_tournament
	   					),
	   					'contain' => array(
	   									'Pool'=>array(
	   											'Game'=>array(
	   												'Set'
	   											)
	   									)
	   							)
	   					)
	   			);
	   	$outter = array();
   		foreach($cit['Pool'] as $pool){
   			$win = sortGame($pool['id']);
   			
   		}
	   	
   		/* $pool_model=$this->Stage->Pool;
   		$game_model=$this->Stage->Pool->Game;
   		$set_model=$this->Stage->Pool->Game->Set; */
   		
   		
	   	
	   	return null;
   		
   }

   public function gameWin($gameID){
   	$sets = $this->find("all", 
   			array('conditions'=>array('Set.game_id' => $gameID))
   			);
   	$sum = 0;
   	foreach ($sets as $set){
   		$sum += $set['win_status'];
   	}
   	if($sum>0){
   		return 1;
   	}
   	else{
   		return 0;
   	}
   }
   
   public function sortGame($poolID){
   	$games = $this->find("all",
   			array('conditions'=>array('Game.pool_id' => $poolID))
   	);
   	$board1 = array();
   	foreach($games as $game){
   		$winner = gameWin($game['id']);
   		if ($winner = 1){
   			array_push($board1, $game['a_player_id']);
   		}
   		else{
   			array_push($board1, $game['b_player_id']);
   		}
   	}
   	$board2 = array_count_values($board1);
   	arsort($board2);
   	return $board2;
   }
}
	
	