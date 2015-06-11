<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/*
 * Validation rules
 *
 */
	public $validate = array(
      'email' => array(
         'email' => array(
            'rule' => 'email',
            'on' => 'create',
            'required' => true,
            'message' => 'Syötä oikea sähköpostiosoite'
         )
      ),
      'pwd' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'on' => 'create'
			),
			'minlength' => array(
				'rule' => array('minlength', 6),
            'message' => 'Salasanan täytyy olla vähintään kuusi (6) merkkiä pitkä',
				'on' => 'create'
			),
		),
      'pwd2' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'on' => 'create'
			),
			'minlength' => array(
				'rule' => array('minlength', 6),
				'message' => 'Salasanan täytyy olla vähintään kuusi (6) merkkiä pitkä',
				'required' => true,
				'on' => 'create'
			),
         'identicalFieldValues' => array(
            'rule' => array('identicalFieldValues', 'pwd' ),
            'message' => 'Salasanat eivät vastaa toisiaan',
            'on' => 'create'
         )
      ) 
	);
   
   
   // Check for password double to be identical
   public function beforeSave($options = array())
   {
   
      if(!isset($this->data['User']['pwd']) )
      {
         return true;
      }
      else
      if($this->data['User']['pwd'] == $this->data['User']['pwd2'])
      {
         $this->data['User']['password'] = AuthComponent::password($this->data['User']['pwd']);
         return true;
      }
      
      return false;
   }
   
   function identicalFieldValues( $field=array(), $compare_field=null ) 
   {
      foreach( $field as $key => $value )
      {
         $v1 = $value;
         $v2 = $this->data[$this->name][ $compare_field ];                 
         if($v1 == $v2) {
            return true;
         }
      }
      return false;
   } 
   
   
   
   // Associations
   
	public $hasMany = array(

	);
   
   public $hasOne = array(

   );
   
   public $belongsTo = array(
      'Role' => array(
         'className' => 'Role'
      )
   );
   
   public $hasAndBelongsToMany = array(
      'Player' => array(
			'className' => 'Player',
			'foreignKey' => 'user_id',
         'associationForeignKey' => 'player_id',
			'dependent' => false
		)
   );
   
}