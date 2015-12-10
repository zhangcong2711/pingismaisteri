<?php
/**
 * 
 * 
 */
class ComparableObject{

	 
	public $comparedValue = 0;


	public $data=array();
	
	
	protected $_dynamicArray;
	
	public function __set($name, $value) {
		$this->_dynamicArray[$name] = $value;
	}
	
	public function __get($name) {
		return $this->_dynamicArray[$name];
	}
	
	public static function co_sort($a_obj, $b_obj) {
		$a_val = intval ( $a_obj->comparedValue);
		$b_val = intval ( $b_obj->comparedValue);
		if ($a_val == $b_val)
			return 0;
		return ($a_val > $b_val) ? 1 : - 1;
	}
	
	public static function constructCOs($player_list){
	
		$arr=[];
		foreach ($player_list as &$player){
			$t_co=new ComparableObject;
			$t_co->data=$player;
			array_push($arr, $t_co);
		}
		return $arr;
		 
	}
	 
	public static function deconstructCOs($comparableObjs){
		$arr=[];
		foreach ($comparableObjs as &$t_co){
			$obj=$t_co->data;
			array_push($arr, $obj);
		}
		return $arr;
	}


}