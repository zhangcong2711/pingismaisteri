<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property Role $Role
 */
class Role extends AppModel {

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);
   
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'order' => 'User.lastname'
		)
	);
   
   public $hasOne = array(

   );
   
   public $belongsTo = array(
      'Role' => array(
         'className' => 'Role'
      )
   );
   
   public $hasAndBelongsToMany = array(

   );

}
