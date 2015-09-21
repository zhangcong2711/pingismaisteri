<?php
App::uses('AppModel', 'Model');



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
	
	public function savePoolAgenda($playerList,
				   						$t_stage,
				   						$pool_opt_select,
										$pool_num,
										$minimize_same_club,
										$minimize_same_player,
										$fp_size,
										$np_size){
			//transaction start
			$dataSource = $this->getDataSource();
			$dataSource->begin();
			
			
			try {
				//delete all pools associated with the stage
				$this->deleteAll(array('Stage.id' => $t_stage['Stage']['id']), true);
				
				//get the drawed pools and their players
				$new_pools=$this->generatePoolAgenda($playerList,
						$t_stage,
						$pool_opt_select,
						$pool_num,
						$minimize_same_club,
						$minimize_same_player,
						$fp_size,
						$np_size);
					
					
				//persistent pools and association with player
				if(isset($new_pools)){
					foreach ($new_pools as &$t_pool) {
						$t_pool_id=$this->savePool($t_pool, $t_stage['Stage']['id']);
						$pool_players=$t_pool['pool_players'];
						foreach ($pool_players as &$t_player) {
							$this->savePoolPlayer($t_player, $t_pool_id);
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
  		$a_rating=intval($a_player['RatingRow']['rating']);
  		$b_rating=intval($b_player['RatingRow']['rating']);
  		if ( $a_rating == $b_rating) return 0;
  		return ($a_rating > $b_rating) ? 1 : -1;
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
			
			
			if($minimize_same_club==1){
				//minimize the number of games between players in same clubs.
				$this->minimize_game_same_club($pools);
			}
			
			if($minimize_same_player==1){
				//....
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
	
	protected function minimize_game_same_player($pools){
	
	
	
	
		return null;
	}
	
	protected function createNewPool($i,$t_stage){
		
		if($i>25){
			throw new Exception('Pool number is too big'); 
		}
		
		$t_p=array();
		$t_p['name']=chr(ord('A')+$i);
		$t_p['type']='P';
		$t_p['stage_id']=$t_stage['Stage']['id'];
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
}