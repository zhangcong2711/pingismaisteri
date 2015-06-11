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
			'dependent' => true
		),
      'TournamentClass' => array(
			'className' => 'TournamentClass',
			'foreignKey' => 'tournament_class_id',
			'dependent' => true
      )
	);
   
   public $hasMany = array(
      'Registration' => array(
         'className' => 'Registration',
         'foreignKey' => 'tournament_class_id',
         'dependent' => false
      ),
	  'Pool' => array(
	     'className' => 'Pool',
		 'foreignKey' => 'class_id'
	  )
   );
   

}
