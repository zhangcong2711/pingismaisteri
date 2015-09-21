<?php
App::uses('AppModel', 'Model');
/**
 * Set Model
 *
 */
class Set extends AppModel {

   
	public $belongsTo = array(
			'Game' => array(
					'className' => 'Game',
					'foreignKey' => 'game_id',
					'dependent' => false
			)
	);
	
}