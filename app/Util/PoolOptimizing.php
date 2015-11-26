<?php

class PoolOptimizing {
	
	
	var $v_sp_map=[];
	
	
	public function write_V_SP(&$pool,&$player)
	{
			
	}
	
	
	public function get_V_SP_Map()
	{
		
	}
	
	
	public function get_V_SP(&$player_a, &$player_b)
	{
		
	}
	
	//V_SP值比较函数
	//检测对阵map，计算累计比赛数量，计算每次分配进组产生的比赛累计值的均值和累计值的最大值
	//max_gcount 小的优先， 然后avg_gcount小的优先
	//{pool_index, max_gcount, avg_gcount}
	public function shiftPool_M_V_SP($idx_pool_pairs,&$player)
	{
		$pool_index=-1;
		
		
		
		return $pool_index;
	}
	
	

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
	
	
	/**
	 *
	 * @param Array $pools
	 * @param Array $player
	 */
	public function shiftPoolIdxArr_M_NP_SC(&$pools,&$player)
	{
	
		$pool_index_arr=[];
	
	
		return $pool_index_arr;
	}
	
	
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