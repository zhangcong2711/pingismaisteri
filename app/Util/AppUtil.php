<?php

class AppUtil{
	
	
	public static function unique_rand($min, $max, $num) {
		$count = 0;
		$return = array();
		while ($count < $num) {
			$return[] = mt_rand($min, $max);
			$return = array_flip(array_flip($return));
			$count = count($return);
		}
		shuffle($return);
		return $return;
	}
	
	
}