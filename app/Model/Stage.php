<?php
App::uses('AppModel', 'Model');



class Stage extends AppModel {
	
	public $belongsTo = array(
			'Tournament' => array(
					'className' => 'Tournament',
					'foreignKey' => 'tournament_id',
					'dependent' => false
			)
	);
	 
	public $hasMany = array(
			'Pool' => array(
					'className' => 'Pool',
					'foreignKey' => 'stage_id',
					'dependent' => true
			)
	);
}