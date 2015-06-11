<?php
App::uses('AppModel', 'Model');
/**
 * TournamentClass Model
 *
 * @property TournamentClass $TournamentClass
 */
class TournamentClass extends AppModel {

	public $validate = array(

	);
   
	public $hasMany = array(
		'ClassInTournament' => array(
			'className' => 'ClassInTournament',
			'foreignKey' => 'tournament_class_id',
			'dependent' => false
		)
	);

}
