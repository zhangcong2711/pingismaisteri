<?php

class PoolOptimizing {
	
	
	
// 	public function initialize()
// 	{
// 		$GLOBALS['v_sp_map']= [];
// 	}
	
	public function get_V_SP_Map()
	{
		return $GLOBALS['v_sp_map'];
	}
	
	
	public function write_V_SP(&$pool,&$player)
	{
		//$v_sp_map=&$this->get_V_SP_Map();
		
		foreach ($pool['pool_players'] as &$t_p )
		{
			$tp_id=intval($t_p['Player']['id']);
			$p_id=intval($player['Player']['id']);
			
			$d_key = ($tp_id > $p_id) ? $p_id.'_vs_'.$tp_id : $tp_id.'_vs_'.$p_id;
			if(array_key_exists($d_key,$GLOBALS['v_sp_map']))
			{
				$GLOBALS['v_sp_map'][$d_key]=intval($GLOBALS['v_sp_map'][$d_key])+1;
			}
			else
			{
				$GLOBALS['v_sp_map'][$d_key]=1;
			}
		}
	}
	
	
	
	public function get_V_SP(&$player_a, &$player_b)
	{
		$v_sp_map=$this->get_V_SP_Map();
		
		$a_id=intval($player_a['Player']['id']);
		$b_id=intval($player_b['Player']['id']);
		$d_key = ($a_id > $b_id) ? $b_id.'_vs_'.$a_id : $a_id.'_vs_'.$b_id;
		
		if(array_key_exists($d_key,$v_sp_map))
		{
			return intval($v_sp_map[$d_key]);
		}
		else
		{
			return 0;
		}
		
	}
	
	//V_SP值比较函数
	//检测对阵map，计算累计比赛数量，计算每次分配进组产生的比赛累计值的均值和累计值的最大值
	//max_gcount 小的优先， 然后avg_gcount小的优先
	//{pool_index, max_gcount, avg_gcount}
	public function shiftPool_M_V_SP($idx_pool_pairs,&$player)
	{
		
		$v_sp_map=$this->get_V_SP_Map();
		
		
		
		//filter pools in which player has been added in this round
		$min_pcount=count($idx_pool_pairs[0]['pool']['pool_players']);
		foreach($idx_pool_pairs as &$t_ipp){
			if(count($t_ipp['pool']['pool_players'])<$min_pcount){
				$min_pcount=count($t_ipp['pool']['pool_players']);
			}
		}
		
		
		
		
		$candidate_idx_pool_pairs=[];
		foreach($idx_pool_pairs as &$t_ipp){
			if(count($t_ipp['pool']['pool_players'])==$min_pcount){
				array_push($candidate_idx_pool_pairs, $t_ipp);
			}
		}
		
		
		$array=$candidate_idx_pool_pairs;
		$count=count($array);
		for($i=0;$i<$count;$i++){
			for($j=$count-1;$j>$i;$j--){
				if ($this->compareTwoPool_V_SP($array[$j-1],$array[$j],$player)==1)
				{
					$tmp =$array[$j];
					$array[$j] =$array[$j-1];
					$array[$j-1] =$tmp;
				}
			}
		}
		
		return intval($array[0]['index']);
	}
	
	
	/**
	 * 
	 * @param Array $pool_a
	 * @param Array $pool_b
	 * @param Array $player
	 */
	protected function compareTwoPool_V_SP($pool_a,$pool_b,$player){
		
		$v_sp_map=$this->get_V_SP_Map();
		
		$a_v_sp_arr=[];
		foreach ($pool_a['pool']['pool_players'] as &$t_p )
		{
			array_push($a_v_sp_arr, $this->get_V_SP($t_p,$player));
		}
		
		
		$b_v_sp_arr=[];
		foreach ($pool_b['pool']['pool_players'] as &$t_p )
		{
			array_push($b_v_sp_arr, $this->get_V_SP($t_p,$player));
		}
		
		$min_a=min($a_v_sp_arr);
		$min_b=min($b_v_sp_arr);
		$avg_a=array_sum($a_v_sp_arr)/count($a_v_sp_arr);
		$avg_b=array_sum($b_v_sp_arr)/count($b_v_sp_arr);
		
		if($min_a<$min_b)
		{
			return -1;
		}
		else if($min_a>$min_b)
		{
			return 1;
		}
		else
		{
			return ($avg_a<=$avg_b) ? -1 : 1;
		}
	}
	
	

	/**
	 * 
	 * @param Array $pool
	 * @param int $club_id
	 */
	public function get_NP_SC(&$pool,$club_id)
	{
		
		$v_sp_map=$this->get_V_SP_Map();
		
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
	
		$v_sp_map=$this->get_V_SP_Map();
		
		//filter pools in which player has been added in this round
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
		
		$pool_index_arr=[];
		foreach($pools as &$ttp){
			$tpp_pcount=count($ttp['pool_players']);
			if($tpp_pcount==$min_pcount){
				$tpp_NP_SC=$this->get_NP_SC($ttp, $player['Club']['id']);
				if($tpp_NP_SC==$min_NP_SC){
					$pool_index=array_search($ttp,$pools);
					array_push($pool_index_arr, $pool_index);
				}
			}
		}
		
		
		return $pool_index_arr;
	}
	
	
	/**
	 * 
	 * @param Array $pools
	 * @param Array $player
	 */
	public function shiftPool_M_NP_SC(&$pools,&$player)
	{
		
		$v_sp_map=$this->get_V_SP_Map();
		
		//filter pools in which player has been added in this round
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