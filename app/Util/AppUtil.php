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
	
	
	/**
	 * 
	 * Extract new array from a array by hierarchy, eg. original array = [ array[attr01=> x, attr02=> y], ...]
	 * extractNewArray(original array, 'attr01') = new array [attr01 in first element, attr01 in second element, ...]
	 * @param original array $array
	 * @param hierarchy attributes ...$args
	 */
	public static function extractNewArray($arr, $args) {
		
		if(isset($arr) && count($arr)>0){
			
			$t_arg=array_shift($args);
			if(isset($t_arg)){
				$next_arr=array();
				foreach($arr as &$element){
					if(array_key_exists($t_arg, $element)){
						array_push($next_arr,$element[$t_arg]);
					}else{
						throw new Exception('No attribute ('.$t_arg.') in the array.');
					}
					
				}
				return AppUtil::extractNewArray($next_arr, $args);
			}else{
				return $arr;
			}
		}else{
			return null;
		}
		
		
	}
	
	
	
	
}