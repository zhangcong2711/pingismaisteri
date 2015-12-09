<h2><?php echo 'The Detail Game Result of Pool  '.$pools['Pool']['name']?></h2>


<?php foreach($pools['Game'] as $game) {?>
<div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
	              <strong>
	              <?php 
	             
	              	 echo 'Game '.'&nbsp&nbsp&nbsp';
	              	 
	              	 	$playerA_name = $game['A_Player']['firstname'].' '.$game['A_Player']['lastname'];
	              	 	$playerB_name = $game['B_Player']['firstname'].' '.$game['B_Player']['lastname'];
	              	 	
	              	 		
	              	 echo '&nbsp&nbsp'.$playerA_name.'&nbsp&nbsp'.'VS'.'&nbsp&nbsp'.$playerB_name.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$this->element(
               				"buttonlink", 
               				array(
                  			'label' => 'Add Result', 
                  			'controller' => 'games', 
                  			'action' => 'add',
               				'params' => array($game['id']),
                  			'class' => 'btn btn-success' 
               					)
            	);
	              ?>
	              </strong>
              </h3>
            </div>
            <div class="panel-body">
              <?php 
              
              
              foreach($game['Set'] as $g_set){
              	
              	//echo '<h4>Stage '.$t_stage['name'].'</h4>';
              	
              	/*if( && count($t_stage['Pool'])>0){
              		
              		foreach ($t_stage['Pool'] as $t_pool) {
              			
              			$player_names=array();
              			foreach($t_pool['PlayerInPool'] as $pip){
              				array_push($player_names, $pip['Player']['firstname'].' '.$pip['Player']['lastname']);
              			}
              			
              			echo '<li>&nbsp;'.$this->Html->link(
              					$t_pool['name'],
              					array(
              							"controller" => "games",
              							"action" => "result",
              							$t_pool['id']
              					)
              			).'&nbsp;&nbsp;&nbsp;'.implode(', ', $player_names).'</li><br/>';
              		}
              	}*/
              	echo '<h3>&nbsp&nbsp&nbsp'.$g_set['seq_no'].'&nbsp&nbsp&nbsp&nbsp'.$g_set['a_point'].' - '.$g_set['b_point'].'&nbsp&nbsp&nbsp&nbsp'.
                	$this->element(
               				"buttonlink", 
               				array(
                  			'label' => 'Delete', 
                  			'controller' => 'games', 
                  			'action' => 'deleteR', 
                  			'params' => array($g_set['id']), 
                  			'class' => 'btn btn-danger' 
               					)
            	).'</h3>';
              		
              	
              }
              	
              ?>
            </div>
          </div>
        </div>
</div>

<?php }?>



<?php 

echo $this->element(
		"buttonlink",
		array(
				'label' => 'Back',
				'controller' => 'games',
				'action' => 'show',
				'params' => array($pools['Stage']['ClassInTournament']['Tournament']['id']),
				'class' => 'btn btn-primary'
		)
);

?>