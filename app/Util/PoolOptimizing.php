<?php

class PoolOptimizing {

	/**
	 * 
	 * @param Array $pool
	 * @param int $club_id
	 */
	public function get_NP_SC(&$pool,$club_id)
	{
		$count=0;
		foreach ($pool['pool_players'] as &$t_player )
		{
			if($t_player['Club']['id']==$club_id)
			{
				
				$count++;
			}
		}
		return $count;
	}
	
// 	/**
// 	 * 
// 	 * @param Array $pools
// 	 * @param int $club_id
// 	 */
// 	public function getPool_M_NP_SC(&$pools,$club_id)
// 	{
// 		$min_np_p=null;
// 		$min_np_sc_count=99999;
// 		foreach($pools as &$t_p){
// 			$t_p_np_sc=$this->get_NP_SC($t_p, $club_id);
// 			if($t_p_np_sc<$min_np_sc_count){
// 				$min_np_p=&$t_p;
// 				$min_np_sc_count=$t_p_np_sc;
// 			}
// 		}
		
// 		return $min_np_p;
// 	}
	
	/**
	 * 
	 * @param Array $pools
	 * @param Array $player
	 */
	public function shiftPool_M_NP_SC(&$pools,&$player)
	{
		
		
		
		$min_pcount=count($pools[0]['pool_players']);
		foreach($pools as &$ttp){
			if(count($ttp['pool_players'])<$min_pcount){
				$min_pcount=count($ttp['pool_players']);
			}
		}
		
		$pool_index=-1;
		$min_NP_SC=99999999;
		foreach($pools as &$ttp){
			$tpp_pcount=count($ttp['pool_players']);
			if($tpp_pcount==$min_pcount){
				$tpp_NP_SC=$this->get_NP_SC($ttp, $player['Club']['id']);
				if($tpp_NP_SC<=$min_NP_SC){
					$min_NP_SC=$tpp_NP_SC;
					$pool_index=array_search($ttp,$pools);
				}
			}
		}
		
		return $pool_index;
	}
	
	
}