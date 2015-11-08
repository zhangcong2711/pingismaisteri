<?php
App::uses('AppModel', 'Model');
/**
 * Game Model
 *
 */
class Game extends AppModel {

   
	public $belongsTo = array(
			'Pool' => array(
					'className' => 'Pool',
					'foreignKey' => 'pool_id',
					'dependent' => false
			),
			
			'A_Player' => array(
					'className' => 'Player',
					'foreignKey' => 'a_player_id',
					'dependent' => false
			),
			'B_Player' => array(
					'className' => 'Player',
					'foreignKey' => 'b_player_id',
					'dependent' => false
			)
	);
	
	
	public $hasMany = array(
		'Set' => array(
			'className' => 'Set',
			'foreignKey' => 'game_id',
			'dependent' => true,
			'order' => 'Set.seq_no'
		)
	);
	
	
	public function saveGame($game_data, $pool_id){
		$this->create();
		$data = array('a_player_id' => $game_data['a_player_id'], 
					'b_player_id' => $game_data['b_player_id'], 
					'seq_no'=>$game_data['seq_no'],
					'pool_id' => $pool_id);
		$this->save($data);
		$t_game_id=$this->id;
		$this->clear();
		return $t_game_id;
	}
	
	public function saveSet($set_data, $game_id){
		$this->Set->create();
		$data = array('a_point' => $set_data['a_point'], 
					'b_point' => $set_data['b_point'], 
					'seq_no' => $set_data['seq_no'],
					'win_status' => (intval($set_data['a_point'])>intval($set_data['b_point']))  ?  1  :  -1,
					'game_id' => $game_id);
		$this->Set->save($data);
		$t_set_id=$this->Set->id;
		$this->Set->clear();
		return $t_set_id;
	}
	

}
