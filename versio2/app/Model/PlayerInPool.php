<?php
App::uses('AppModel', 'Model');
/**
 * PlayerInPool Model
 *
 * @property Pool $Pool
 */
 class PlayerInPool extends AppModel {
 
    public $validate = array(

	);
	
	public $belongsTo = array(
	   
	   'Player' => array(
	      'className' => 'Player',
		  'foreignKey' => 'player_id'
	   ),
	   'Pool' => array (
	      'className' => 'Pool',
		  'foreignKey' => 'pool_id'
	   )
	);
 }
 