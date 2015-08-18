<?php
App::uses('AppModel', 'Model');



class Pool extends AppModel {
	
	public $belongsTo = array(
			'Stage' => array(
					'className' => 'Stage',
					'foreignKey' => 'stage_id',
					'dependent' => false
			)
	);
	 
	/*
	public $hasAndBelongsToMany = array(
			'Player' => array(
					'className' => 'Player',
					'joinTable' => 'player_in_pools',
					'foreignKey' => 'pool_id',
					'associationForeignKey' => 'player_id',
					'dependent' => false
			)
	);*/
	
	public $hasMany = array(
			'PlayerInPool' => array(
					'className' => 'PlayerInPool',
					'foreignKey' => 'pool_id',
					'dependent' => true
			)
	);
}