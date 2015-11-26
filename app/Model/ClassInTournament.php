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
   	
   }

}
