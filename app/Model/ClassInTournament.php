<?php
App::uses('AppModel', 'Model');

App::import('Util', 'ComparableObject');
/**
 * Club Model
 *
 * @property Club $Club
 */
class ClassInTournament extends AppModel {

   public $useTable = 'class_in_tournaments';
   
	public $belongsTo = array(
		'Tournament' => array(
			'className' => 'Tournament',
			'foreignKey' => 'tournament_id',
			'dependent' => false
		),
      'TournamentClass' => array(
			'className' => 'TournamentClass',
			'foreignKey' => 'tournament_class_id',
			'dependent' => false
      )
	);
   
   public $hasMany = array(
      'Registration' => array(
         'className' => 'Registration',
         'foreignKey' => 'tournament_class_id',
         'dependent' => true
      ),
   		
   	  'Stage' => array(
   		  'className' => 'Stage',
   		  'foreignKey' => 'class_in_tournament_id',
   		  'dependent' => true
   	  )
   );
   
   
   public function getCupAgenda($class_in_tournament){
   	
	   	$cit = $this->find("first",
	   			array(
	   					'conditions' => array(
	   							'ClassInTournament.id' => $class_in_tournament
	   					),
	   					'contain' => array(
	   							'Stage' => array(
	   									'Pool'=>array(
	   											'Game'=>array(
	   												'Set'
	   											)
	   									)
	   							)
	   					)
	   			)
	   	);
	   	
	   	
	   	
	   	
	   	$totalPlayerArr=[];
   		foreach($cit['Stage'][0]['Pool'] as $pool){
   			
   			$t_top_two=$this->getTopTwoPlayersCO($pool);
   			array_push($totalPlayerArr, $t_top_two[0]);
   			array_push($totalPlayerArr, $t_top_two[1]);
   		}
	   	
   		if(count($totalPlayerArr)<=2){
   			throw new Exception('So little people ? Does it really need a cup stage game?');
   		}
   		
   		usort ( $totalPlayerArr, array (
   				$this,
   				"sort_player_by_win_game"
   		) );
   		$totalPlayerArr=array_reverse($totalPlayerArr);
   		$totalPlayerArr=ComparableObject::deconstructCOs($totalPlayerArr);
   		
   		//排对阵表
	   	//....
	   	$single_num=1;
   		do {
   			$single_num=$single_num*2;
   		} while ($single_num < count($totalPlayerArr));
   		
   		$pair_num=$single_num/2;
   		
   		$pair_list=[];
   		
   		for($i=0;$i<$pair_num;$i++){
   			$t_pl=array_shift($totalPlayerArr);
   			array_push($pair_list, [$t_pl]);
   		}
   		
   		for($i=$pair_num-1;$i>=0;$i--){
   			
   			$t_pl=array_shift($totalPlayerArr);
   			if(isset($t_pl)){
   				array_push($pair_list[$i], $t_pl);
   			}else{
   				break;
   			}
   		}
   		
   		
   		
   		
   		
	   	return $pair_list;
   		
   }
   
   private function sort_player_by_win_game($a_obj, $b_obj) {
   	$a_val = intval ( $a_obj->win_game_num);
   	$b_val = intval ( $b_obj->win_game_num);
   	if ($a_val == $b_val)
   		return 0;
   	return ($a_val > $b_val) ? 1 : - 1;
   }

   
   
   public function getTopTwoPlayers($pool){
   	
   		$arr=$this->getOrderdPlayer($pool);
   		
   		return [$arr[0],$arr[1]];
   }
   
   public function getTopTwoPlayersCO($pool){
   
	   	$arr=$this->getOrderdPlayerCO($pool);
	   	 
	   	return [$arr[0],$arr[1]];
   }
   
   public function getOrderdPlayer($pool){
   		return ComparableObject::deconstructCOs($this->getOrderdPlayerCO($pool));
   }
   
   public function getOrderdPlayerCO($pool){
   
   		$all_games=$pool['Game'];
   		
   		$query_sql = <<<EOF
SELECT 
    `Player`.*,
    `PlayerInPool`.*,
    (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d'))) AS `age`
FROM
    `pingismaisteri`.`pingis2_players` AS `Player`
        LEFT JOIN
    `pingismaisteri`.`pingis2_player_in_pools` AS `PlayerInPool` ON (`Player`.`id` = `PlayerInPool`.`player_id`)
WHERE
 `PlayerInPool`.`pool_id` = ?
EOF;
   		
   		$pool_id=(isset($pool['id'])) ? $pool['id'] : $pool['Pool']['id'];
   		$db = ConnectionManager::getDataSource ( 'default' );
   		$all_players = $db->fetchAll ( $query_sql, array (
   				$pool_id
   		) );
   		
   		
   	
   		//construct comparable object
   		$all_players_co=ComparableObject::constructCOs($all_players);
   	
   		
   		$winNumArr=[];
   		
   		
   		//calc the win games
   		foreach ($all_players_co as &$t_player_co){
   			
   			$t_pp=$t_player_co->data;
   			$t_win_game_num=0;
   			$t_lose_game_num=0;
   			$t_win_set_num=0;
   			$t_lose_set_num=0;
   			foreach($all_games as &$tppg)
   			{
   				$g_ap_id=$tppg['a_player_id'];
   				$g_bp_id=$tppg['b_player_id'];
   					
   					
   				foreach($tppg['Set'] as $tps)
   				{
   					if($t_pp ['Player'] ['id']==$g_ap_id)
   					{
   						if(1==$tps['win_status'])
   						{
   							$t_win_set_num++;
   						}else{
   							$t_lose_set_num++;
   						}
   					}
   					if($t_pp ['Player'] ['id']==$g_bp_id)
   					{
   						if(1==$tps['win_status'])
   						{
   			
   							$t_lose_set_num++;
   						}else{
   							$t_win_set_num++;
   						}
   					}
   				}
   				
   				if($t_pp ['Player'] ['id']==$g_ap_id || $t_pp ['Player'] ['id']==$g_bp_id){
   					if($t_win_set_num>$t_lose_set_num)
   					{
   						$t_win_game_num++;
   					}else{
   						$t_lose_game_num++;
   					}
   				}
   					
   			}
   			$t_player_co->comparedValue=$t_win_game_num;
   			$t_player_co->win_game_num=$t_win_game_num;
   			
   		}
   		
   		usort ( $all_players_co, array (
   				'ComparableObject',
   				"co_sort"
   		) );
   		$all_players_co=array_reverse($all_players_co);
   	
   		
   		
   		
   		foreach ($all_players_co as &$t_player_co){
   			
   			$t_key='win_games_'.$t_player_co->comparedValue;
   			if(!array_key_exists($t_key,$winNumArr)){
   				$new_win_class=[$t_player_co];
   				array_push($winNumArr, $new_win_class);
   			}else{
   				array_push($winNumArr[$t_key], $t_player_co);
   			}
   		}
   		
   		$orderedPlayerCOs=[];
   		foreach($winNumArr as &$each_class){
   			if(count($each_class)==1){
   				array_push($orderedPlayerCOs,$each_class[0]);
   			}elseif (count($each_class)>1){
   				$subOrderedPlayerCOs=$this->calcPlayersBySet($all_games,$each_class);
   				foreach ($subOrderedPlayerCOs as &$soplayer){
   					array_push($orderedPlayerCOs,$soplayer);
   				}
   			}else{
   				throw new Exception('This class of win number contain no elements!');
   			}
   		}
   	
   	
   		
   		
   		
   		
   		
   		return $orderedPlayerCOs;
   }
   
   
   public function calcPlayersBySet($all_games,$playerlist_comparableObjs){
   	
   		$filteredGames=$this->getFilteredGames($all_games,$playerlist_comparableObjs);
   		
   		
   		foreach ($playerlist_comparableObjs as &$t_player_co){
   		
   			$t_pp=$t_player_co->data;
   			$t_win_game_num=0;
   			$t_lose_game_num=0;
   			$t_win_set_num=0;
   			$t_lose_set_num=0;
   			foreach($filteredGames as &$tppg)
   			{
   				$g_ap_id=$tppg['a_player_id'];
   				$g_bp_id=$tppg['b_player_id'];
   		
   		
   				foreach($tppg['Set'] as $tps)
   				{
   					if($t_pp ['Player'] ['id']==$g_ap_id)
   					{
   						if(1==$tps['win_status'])
   						{
   							$t_win_set_num++;
   						}else{
   							$t_lose_set_num++;
   						}
   					}
   					if($t_pp ['Player'] ['id']==$g_bp_id)
   					{
   						if(1==$tps['win_status'])
   						{
   		
   							$t_lose_set_num++;
   						}else{
   							$t_win_set_num++;
   						}
   					}
   				}
   		
   		
   			}
   			$t_player_co->comparedValue=$t_win_set_num;
   			
   		}
   		
   		
   		usort ( $playerlist_comparableObjs, array (
   				'ComparableObject',
   				"co_sort"
   		) );
   		$playerlist_comparableObjs=array_reverse($playerlist_comparableObjs);
   		 
   		 
   		$winSetNumArr=[];
   		foreach ($playerlist_comparableObjs as &$t_player_co){
   		
   			$t_key='win_sets_'.$t_player_co->comparedValue;
   			if(!array_key_exists($t_key,$winSetNumArr)){
   				$new_win_class=[$t_player_co];
   				array_push($winSetNumArr, $new_win_class);
   			}else{
   				array_push($winSetNumArr[$t_key], $t_player_co);
   			}
   		}
   		 
   		$orderedPlayerCOs=[];
   		foreach($winSetNumArr as &$each_class){
   			if(count($each_class)==1){
   				array_push($orderedPlayerCOs,$each_class[0]);
   			}elseif (count($each_class)>1){
   				$subOrderedPlayerCOs=$this->calcPlayersByPoint($filteredGames,$each_class);
   				foreach ($subOrderedPlayerCOs as &$soplayer){
   					array_push($orderedPlayerCOs,$soplayer);
   				}
   			}else{
   				throw new Exception('This class of win number contain no elements!');
   			}
   		}
   		
   		return $orderedPlayerCOs;	
   }
   
   
   public function calcPlayersByPoint($all_games,$playerlist_comparableObjs){
   
   		$filteredGames=$this->getFilteredGames($all_games,$playerlist_comparableObjs);
   		
	   	foreach ($playerlist_comparableObjs as &$t_player_co){
	   		 
	   		$t_pp=$t_player_co->data;
	   		$t_total_win_pt=0;
			$t_total_lose_pt=0;
	   		
	   		foreach($filteredGames as &$tppg)
	   		{
	   			$g_ap_id=$tppg['a_player_id'];
	   			$g_bp_id=$tppg['b_player_id'];
	   			 
	   			 
	   			foreach($tppg['Set'] as $tps)
	   			{
	   				if($t_pp ['Player'] ['id']==$g_ap_id)
	   				{
	   					$t_total_win_pt+=intval($tps['a_point']);
						$t_total_lose_pt+=intval($tps['b_point']);
	   				}
	   				if($t_pp ['Player'] ['id']==$g_bp_id)
	   				{
	   					$t_total_win_pt+=intval($tps['b_point']);
						$t_total_lose_pt+=intval($tps['a_point']);
	   				}
	   			}
	   			 
	   			 
	   		}
	   		$t_player_co->comparedValue=$t_total_win_pt;
	   	
	   	}
   	 
   	 
	   	usort ( $playerlist_comparableObjs, array (
	   			'ComparableObject',
	   			"co_sort"
	   	) );
	   	$playerlist_comparableObjs=array_reverse($playerlist_comparableObjs);
   	
   	
	   	$winPointNumArr=[];
	   	foreach ($playerlist_comparableObjs as &$t_player_co){
	   		 
	   		$t_key='win_points_'.$t_player_co->comparedValue;
	   		if(!array_key_exists($t_key,$winPointNumArr)){
	   			$new_win_class=[$t_player_co];
	   			array_push($winPointNumArr, $new_win_class);
	   		}else{
	   			array_push($winPointNumArr[$t_key], $t_player_co);
	   		}
	   	}
   	
	   	$orderedPlayerCOs=[];
	   	foreach($winPointNumArr as &$each_class){
	   		if(count($each_class)>0){
	   			foreach ($each_class as &$soplayer){
	   				array_push($orderedPlayerCOs,$soplayer);
	   			}
	   		}else{
	   			throw new Exception('This class of win number contain no elements!');
	   		}
	   	}
   	 
   		return $orderedPlayerCOs;
   }
   
   
   
   
   
   
   private function getFilteredGames($all_games,$player_list){
   	
   		$egvalues=$this->getFilteredGameEigenvalues($player_list);
   		$arr=[];
   		foreach ($egvalues as &$egval){
   			
   			foreach ($all_games as &$t_game){
   				$gameEGV=$this->gamePlayersEigenvalue($t_game);
   				if($egval==$gameEGV){
   					array_push($arr,$t_game);
   				}
   			}
   		}
   		return $arr;
   }
   
   
   private function getFilteredGameEigenvalues($player_list){
   		
   		$cblist=AppUtil::array_combination($player_list, 2);
   		$arr=[];
   		
   		foreach($cblist as &$t_cb){
   			array_push($arr, $this->playersEigenvalue($t_cb[0],$t_cb[0]));
   		}
   		
   		return $arr;
   }
   
   
   private function gamePlayersEigenvalue($game){
   
	   	$p1_id=intval($game['a_player_id']);
	   	$p2_id=intval($game['b_player_id']);
	   	if($p1_id<$p2_id){
	   		return $p1_id.'_'.$p2_id;
	   	}else{
	   		return $p2_id.'_'.$p1_id;
	   	}
   }
   
   private function playersEigenvalue($p1,$p2){
   	
   		$p1_id=intval($p1['id']);
   		$p2_id=intval($p2['id']);
   		
   		if($p1_id<$p2_id){
   			return $p1_id.'_'.$p2_id;
   		}else{
   			return $p2_id.'_'.$p1_id;
   		}
   		
   }
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   public function gameWin($gameID){
   	$sets = $this->find("all", 
   			array('conditions'=>array('Set.game_id' => $gameID))
   			);
   	$sum = 0;
   	foreach ($sets as $set){
   		$sum += $set['win_status'];
   	}
   	if($sum>0){
   		return 1;
   	}
   	else{
   		return 0;
   	}
   }
   
   public function sortGame($poolID){
   	$games = $this->find("all",
   			array('conditions'=>array('Game.pool_id' => $poolID))
   	);
   	$board1 = array();
   	foreach($games as $game){
   		$winner = gameWin($game['id']);
   		if ($winner = 1){
   			array_push($board1, $game['a_player_id']);
   		}
   		else{
   			array_push($board1, $game['b_player_id']);
   		}
   	}
   	$board2 = array_count_values($board1);
   	arsort($board2);
   	return $board2;
   }
}
	
	