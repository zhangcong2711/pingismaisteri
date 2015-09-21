<?php
App::uses('AppModel', 'Model');



class Stage extends AppModel {
	
	public $belongsTo = array(
			'ClassInTournament' => array(
					'className' => 'ClassInTournament',
					'foreignKey' => 'class_in_tournament_id',
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