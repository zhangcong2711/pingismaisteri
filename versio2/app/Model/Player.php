<?php
App::uses('AppModel', 'Model');
/**
 * Player Model
 *
 * @property Player $Player
 */
class Player extends AppModel {

	public $validate = array(

	);
   
   public $belongsTo = array(
      'Club' => array(
         'className' => 'Club',
         'foreignKey' => 'club_id',
         'dependent' => false
      )
   );
   
   public $hasMany = array(
      'Registration' => array(
         'className' => 'Registration',
         'foreignKey' => 'player_id',
         'dependent' => false
      ),
	  'PlayerInPool' => array (
	      'className' => 'PlayerInPool',
		  'foreignKey' => 'player_id'
	  )
   );
   
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'player_id',
         'associationForeignKey' => 'user_id',
			'dependent' => false,
			'fields' => 'User.id, User.email, User.created, User.name'
		)
	);
   
   var $virtualFields = array(
      'age' => "DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))"
   );

}
