<?php
App::uses('AppModel', 'Model');
/**
 * Rating Model
 *
 * @property Rating $Rating
 */
 class Rating extends AppModel {
 
    public $validate = array(

	);
 
    public $hasMany = array(
	   'RatingRow' => array(
           'className' => 'RatingRow',
		   'foreignKey' => 'rating_id',
		   //'order' => 'Rating.date DESC',
		   'dependent' => false
	       )
       );
 }
 