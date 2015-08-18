<?php
App::uses('AppModel', 'Model');
/**
 * PlayerInPool Model
 *
 */
class PlayerInPool extends AppModel {
	
	
	public $useTable = 'player_in_pools';
	
	
	public $belongsTo = array (
			'Pool' => array (
					'className' => 'Pool',
					'foreignKey' => 'pool_id',
					'dependent' => false 
			),
			'Player' => array (
					'className' => 'Player',
					'foreignKey' => 'player_id',
					'dependent' => false 
			) 
	);

}
