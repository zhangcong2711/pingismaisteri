<?php
App::uses('AppModel', 'Model');
/**
 * Player Model
 *
 * @property Player $Player
 */
class Player extends AppModel {

	public $validate = array(
      'firstname' => array(
         'rule' => 'notEmpty',
         'required' => 'create',
         'message' => "Syötä etunimi"
      ),
      'lastname' => array(
         'rule' => 'notEmpty',
         'required' => 'create',
         'message' => "Syötä sukunimi"
      ),
     'birthday' => array(
         'rule'       => 'date',
         'message'    => 'Syötä syntymäpäivä',
         'allowEmpty' => false,
         'required' => true
     ),
     'sex' => array(
         'allowedChoice' => array(
             'rule'    => array('inList', array('M', 'F')),
             'message' => 'Valitse sukupuoli',
             'required' => true,
             'allowEmpty' => false
         )
     )
     
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
         'dependent' => true
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
