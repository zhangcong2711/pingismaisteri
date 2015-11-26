<?php

App::uses('AppModel', 'Model');

App::import('Util', 'PoolOptimizing');

class Pool extends AppModel {
	
	
	
	//private $player_in_pool;
	
	public $belongsTo = array(
			'Stage' => array(
					'className' => 'Stage',
					'foreignKey' => 'stage_id',
					'dependent' => false
			)
	);
	
	public $hasMany = array(
			'PlayerInPool' => array(
					'className' => 'PlayerInPool',
					'foreignKey' => 'pool_id',
					'dependent' => true
			),
			
			'Game' => array(
					'className' => 'Game',
					'foreignKey' => 'pool_id',
					'dependent' => true,
					'order' => 'Game.seq_no'
			)
	);
	
	
	
	var $pool_op;
	
	function __construct() {
		
		parent:: __construct();
		$pool_op=new PoolOptimizing;
		
	}
	
	
	public function drawPools($list_of_class_id,$minimize_same_club,$minimize_same_player){
		
		
		$group_of_cit=array();
		
		
		foreach($list_of_class_id as &$class_id){
			$cit = $this->Stage->ClassInTournament->find("first",
					array(
							'conditions' => array(
									'ClassInTournament.id' => $class_id
							),
							'contain' => array(
									'Stage',
									'Registration' => array(
										'Player'
									)
							)
					)
			);
			
			$player_list = $this->Stage->ClassInTournament->Registration->Player->find("all",array(
					'joins' => array(
							array(
									'table' => 'registrations',
									'alias' => 'Registration',
									'type' => 'INNER',
									'conditions' => array(
											'Registration.player_id = Player.id'
									)
							),
							array(
									'table' => 'class_in_tournaments',
									'alias' => 'CIT',
									'type' => 'INNER',
									'conditions' => array(
											'CIT.id = Registration.tournament_class_id'
									)
							),
							array(
									'table' => 'rating_rows',
									'alias' => 'RatingRow',
									'type' => 'LEFT',
									'conditions' => array(
											'Player.id = RatingRow.player_id',
											'RatingRow.rating_id=1'
									)
							)
					),
					'conditions' => array(
							'CIT.id = ' => $class_id
					),
					'fields' => array('Player.*', 'Club.*', 'CIT.*', 'Registration.*', 'RatingRow.rating')));
			
			if(isset($cit['Stage']) && count($cit['Stage'])>0){
				
				//$first_stage=$cit['Stage'][0];
				
				
				
				if($cit['Stage'][0]['type']==constant('STAGE_POOL')){
					
					$new_pools=$this->generatePoolAgenda($player_list,
							$cit['Stage'][0],
							constant('POOL_OPTION_ONE'),
							$cit['ClassInTournament']['pool_num'],
							$minimize_same_club,
							$minimize_same_player,
							0,0);
				
					
					$cit['Stage'][0]['Pool']=$new_pools;
					array_push($group_of_cit, $cit);
					
					
				}else{
					throw new Exception('The stage in not pool type!');
				}
			}else{
				throw new Exception('There is no stage in this class of tournament!'); 
			}
			
			
			
			
		}
		
		if(count($group_of_cit)>0){
			
			if($minimize_same_player==1){
				$group_of_cit=$this->minimize_game_same_player($group_of_cit);
			}
			
			foreach ($group_of_cit as &$t_cit){
				$this->savePoolAgenda($t_cit);
			}
			
			return $group_of_cit;
		}else{
			return null;
		}
	
	}
	
	
	
	public function savePoolAgenda($cit){
		
		
			//transaction start
			$dataSource = $this->getDataSource();
			$dataSource->begin();
			
			
			
			$t_stage=$cit['Stage'][0];
			//get the drawed pools and their players
			$new_pools=$t_stage['Pool'];
			
			try {
				//delete all pools associated with the stage
				$this->deleteAll(array('Stage.id' => $t_stage['id']), true);
				
				
					
				//persistent pools and association with player
				if(isset($new_pools)){
					foreach ($new_pools as &$t_pool) {
						
						//save pool and player association
						$t_pool_id=$this->savePool($t_pool, $t_stage['id']);
						$pool_players=$t_pool['pool_players'];
						foreach ($pool_players as &$t_player) {
							$this->savePoolPlayer($t_player, $t_pool_id);
						}
						
						
						//generate games
						$player_matches=AppUtil::array_combination($pool_players, 2);
						
						$game_seq=1;
						foreach ($player_matches as &$player_pair) {
							$this->saveGame($player_pair[0], $player_pair[1],$game_seq, $t_pool_id);
							$game_seq++;
						}
						
						
					}
					unset($t_player);
					unset($t_pool);
				}
				
				
				$dataSource->commit();
			} catch (Exception $e) {
				
				//log...
				$dataSource->rollback();
				$this->clear();
				$this->PlayerInPool->clear();
				
			} finally {
				
			}
	}
	
	private function rating_sort($a_player, $b_player)
  	{
  		$a_rating=isset($a_player['RatingRow']['rating']) ? intval($a_player['RatingRow']['rating']) : 0;
  		$b_rating=isset($b_player['RatingRow']['rating']) ? intval($b_player['RatingRow']['rating']) : 0;
  		if ( $a_rating == $b_rating) return 0;
  		return ($a_rating > $b_rating) ? -1 : 1;
  	}
	
	public function generatePoolAgenda($playerList,
			$t_stage,
			$pool_opt_select,
			$pool_num,
			$minimize_same_club,
			$minimize_same_player,
			$fp_size,
			$np_size){
		 
		//resort the player array by rating from big to small
		usort($playerList,array($this, "rating_sort"));
		
		
		if($pool_opt_select==constant("POOL_OPTION_ONE")){
			
			$pool_order_num=intval(count($playerList)/$pool_num)+1;
			
			$pools=array();
			
			for($i=0;$i<$pool_num;$i++){
				array_push($pools,$this->createNewPool($i,$t_stage));
			}
			
			//assign every player into pools
			for($j=0;$j<$pool_order_num;$j++){
				//for the first order
				if($j==0){
					//insert the first several players (number is $pool_num) into pools in sequence
					for($pool_index=0; $pool_index<$pool_num;$pool_index++){
						
						$t_player=array_shift($playerList);
						$t_player['PoolOrder']=$j+1;
						array_push($pools[$pool_index]['pool_players'], $t_player);
					}
				}elseif($j==$pool_order_num-1){
					
					
					
					//for the last order, fill the pool from the last one
					//in order to reduce the number of games of the top one player
					for($pool_index=$pool_num-1; $pool_index>=0; $pool_index--){
					
						$t_player=array_shift($playerList);
						if(isset($t_player)){
							$t_player['PoolOrder']=$j+1;
							array_push($pools[$pool_index]['pool_players'], $t_player);
						}else{
							break;
						}
					}
					
					
					
				}else{
					
					//分开考虑
					if($minimize_same_club==1 && $minimize_same_player==1)
					{
						//先做minimize_same_club优化，记录最小的V_SC值的数组
						//若只有一个，无法优化
						//若有多个，比较V_SP值，取最小的最后一个
						//分配进组
						
						for($idx=0; $idx<$pool_num;$idx++){
							
							$selected_pool_index=-1;
							$t_player=array_shift($playerList);
							$t_player['PoolOrder']=$j+1;
							
							$pool_index_arr=$pool_op->shiftPoolIdxArr_M_NP_SC($pools, $t_player);
							if(count($pool_index_arr)==1)
							{
								$selected_pool_index=$pool_index_arr[0];
							}else
							{
								$idx_pool_pairs=[];
								for($k=0;$k<count($pool_index_arr);$k++)
								{
									array_push($idx_pool_pairs, ['index'=>$k, 'pool'=> $pools[$pool_index_arr[k]]]);
								}
								$selected_pool_index=$pool_op->shiftPool_M_V_SP($idx_pool_pairs, $t_player);
								//update V_SP after choose a pool
								$pool_op->write_V_SP($pools[$selected_pool_index], $t_player);
							}
							array_push($pools[$selected_pool_index]['pool_players'], $t_player);
						}
						
					}
					elseif($minimize_same_club==0 && $minimize_same_player==1)
					{
						//停止随机过程
						//计算V_SP 值，取最小的最后一个
						//分配进组
						
						
						for($idx=0; $idx<$pool_num;$idx++){
								
							$t_player=array_shift($playerList);
							$t_player['PoolOrder']=$j+1;
							$idx_pool_pairs=[];
							for($k=0;$k<count($pools);$k++)
							{
								array_push($idx_pool_pairs, ['index'=>$k, 'pool'=> $pools[$k]]);
							}
							$selected_pool_index=$pool_op->shiftPool_M_V_SP($idx_pool_pairs, $t_player);
							//update V_SP after choose a pool 
							$pool_op->write_V_SP($pools[$selected_pool_index], $t_player);
							array_push($pools[$selected_pool_index]['pool_players'], $t_player);
							
							
						}
						
						
						
					}
					elseif($minimize_same_club==1 && $minimize_same_player==0)
					{
						//如果优化same_club, 停止随机过程
						//提供两个方法， 1： 检测某pool的某个俱乐部队员数V_SC   
						//				2：从几个pool中返回最小的一组（pop形式）
						//分配进返回的组
						
						
						
						for($idx=0; $idx<$pool_num;$idx++){
							
							$t_player=array_shift($playerList);
							$t_player['PoolOrder']=$j+1;
							$selected_pool_index=$pool_op->shiftPool_M_NP_SC($pools, $t_player);
							array_push($pools[$selected_pool_index]['pool_players'], $t_player);
						}
						
					}else
					{
						//generate random order for player to be inserted into every pool
						$random_list=AppUtil::unique_rand(1,$pool_num,$pool_num);
	
						//for the middle, insert players by random way
						for($pool_index=0; $pool_index<$pool_num;$pool_index++){
							
							$t_player=array_shift($playerList);
							$t_player['PoolOrder']=$j+1;
							$random_order=$random_list[$pool_index];
							array_push($pools[$random_order-1]['pool_players'], $t_player);
						}
					}
				}
			}
			
			return $pools;
			
			
		}elseif ($pool_opt_select==constant("POOL_OPTION_TWO")){
			
			
			
		}
		
		 
	
		return null;
		 
	}
	 
	public function generateCupAgenda($id){
		 
	
	
		return null;
	}
	
	
	
	protected function minimize_game_same_club($pools){
		
		
		
		
		return null;
	}
	
	protected function minimize_game_same_player($list_of_class_in_tournament){
	
	
	
	
		return null;
	}
	
	protected function createNewPool($i,$t_stage){
		
		if($i>25){
			throw new Exception('Pool number is too big'); 
		}
		
		$t_p=array();
		$t_p['name']=chr(ord('A')+$i);
		$t_p['type']='P';
		$t_p['stage_id']=$t_stage['id'];
		$t_p['pool_players']=array();
		
		return $t_p;
	}
	
	protected function savePool($pool_data, $stage_id){
		$this->create();
		$data = array('name' => $pool_data['name'], 'type' => $pool_data['type'], 'stage_id' => $stage_id);
		$this->save($data);
		$t_pool_id=$this->id;
		$this->clear();
		return $t_pool_id;
	}
	 
	protected function savePoolPlayer($pool_player_data,$t_pool_id){
		$this->PlayerInPool->create();
		$data = array('player_id' => $pool_player_data['Player']['id'], 'pool_id' => $t_pool_id, 'order' => $pool_player_data['PoolOrder']);
		$this->PlayerInPool->save($data);
		$t_pool_player_id=$this->PlayerInPool->id;
		$this->PlayerInPool->clear();
		return $t_pool_player_id;
	}
	
	protected function saveGame($a_player, $b_player,$game_seq, $pool_id){
		$this->Game->create();
		$data = array('a_player_id' => $a_player['Player']['id'], 'b_player_id' => $b_player['Player']['id'], 'seq_no' => $game_seq, 'pool_id' => $pool_id);
		$this->Game->save($data);
		$t_game_id=$this->Game->id;
		$this->Game->clear();
		return $t_game_id;
	}
}