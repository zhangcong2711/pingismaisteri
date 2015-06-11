<?php
App::uses('AppModel', 'Model');
/**
 * Tournament Model
 *
 * @property Tournament $Tournament
 */
class Tournament extends AppModel {

	public $validate = array(

	);
   
   public $belongsTo = array(
      'User' => array(
         'className' => 'User',
         'foreignKey' => 'user_id'
      )
   );
   
   public $hasMany = array(
      'ClassInTournament' => array(
         'className' => 'ClassInTournament',
         'foreignKey' => 'tournament_id',
         'dependent' => false
      )
   );

}
