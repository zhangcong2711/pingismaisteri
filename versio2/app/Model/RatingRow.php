<?php
App::uses('AppModel', 'Model');
/**
 * RatingRow Model
 *
 * @property RatingRow $RatingRow
 */
 class RatingRow extends AppModel {
 
    public $validate = array(

	);
 
    public $belongsTo = array(
	   'Rating' => array(
           'className' => 'Rating',
		   'foreignKey' => 'rating_id',
		   'order' => 'Rating.date DESC',
		   'dependent' => false
	    ),
		'Player' => array(
		   'classname' => 'Player',
		   'foreignkey' => 'player_id',
		   'dependent' => false
		)
    );
	
 }