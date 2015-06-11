<?php
App::uses('AppModel', 'Model');
/**
 * Registration Model
 *
 * @property Registration $Registration
 */
class Registration extends AppModel {

	public $validate = array(

	);
   
   public $belongsTo = array(
      'Player' => array(
         'className' => 'Player',
         'foreignKey' => 'player_id',
         'dependent' => true
      ),
      'ClassInTournament' => array(
         'className' => 'ClassInTournament',
         'foreignKey' => 'tournament_class_id',
         'dependent' => true
      ),
   );

}
