<?php
App::uses('AppModel', 'Model');
/**
 * Pool Model
 *
 * @property Pool $Pool
 */
 class Pool extends AppModel {
 
    public $validate = array(

	);

   public $hasMany = array(
	   'PlayerInPool' => array (
	      'className' => 'PlayerInPool',
		  'foreignKey' => 'pool_id'
	   )
	 
	);
	
	public $belongsTo = array(
	   'ClassInTournament' => array (
	      'className' => 'classInTournament',
		  'foreignKey' => 'class_id'
	   )
	);
 }
 