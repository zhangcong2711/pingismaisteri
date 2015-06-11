<?php
App::uses('AppModel', 'Model');
/**
 * Club Model
 *
 * @property Club $Club
 */
class Club extends AppModel {

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);
   
	public $hasMany = array(
		'Player' => array(
			'className' => 'Player',
			'foreignKey' => 'club_id',
			'dependent' => false,
			'order' => 'Player.lastname'
		)
	);

}
