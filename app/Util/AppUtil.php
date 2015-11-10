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
	

	/**
	 * 
	 * calculate combination of a array
	 * @param array $elements
	 * @param unknown $chosen
	 */
	public static function array_combination(array $elements, $chosen)
	{
		if(isset($elements) && count($elements)>2){
			$result = array();
			
			for ($i = 0; $i < $chosen;   $i++) { $vecm[$i] = $i; }
			for ($i = 0; $i < $chosen-1; $i++) { $vecb[$i] = $i; }
			$vecb[$chosen - 1] = count($elements) - 1;
			$result[] = $vecm;
			
			$mark = $chosen - 1;
			while (true) {
				if ($mark == 0) {
					$vecm[0]++;
					$result[] = $vecm;
					if ($vecm[0] == $vecb[0]) {
						for ($i = 1; $i < $chosen; $i++) {
							if ($vecm[$i] < $vecb[$i]) {
								$mark = $i;
								break;
							}
						}
						if (($i == $chosen) && ($vecm[$chosen - 1] == $vecb[$chosen - 1])) { break; }
					}
				} else {
					$vecm[$mark]++;
					$mark--;
					for ($i = 0; $i <= $mark; $i++) {
						$vecb[$i] = $vecm[$i] = $i;
					}
					$vecb[$mark] = $vecm[$mark + 1] - 1;
					$result[] = $vecm;
				}
			}
			
			
			$result_elements=array();
			foreach($result as &$oc){
				array_push($result_elements, [$elements[$oc[0]], $elements[$oc[1]]]);
			}
			
			return $result_elements;
		}elseif(isset($elements) && count($elements)==2){
			return [[$elements[0], $elements[1]]];
		}else{
			return null;
		}
	    
	}
	
	
	
	
}