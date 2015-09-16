<?php
class Detect {
	
	public static function issetValueNull(&$mixed)
	{
		return (isset($mixed)) ? $mixed : null;
	}
}