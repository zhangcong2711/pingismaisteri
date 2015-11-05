<h2><?php echo 'Pool and Game info of '.$tournament['Tournament']['name']?></h2>
<p>Click pool name to view and edit game result</p>



<?php foreach($tournament['ClassInTournament'] as $class) {?>
<div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
	              <strong>
	              <?php echo $class['TournamentClass']['name']?>
	              </strong>
              </h3>
            </div>
            <div class="panel-body">
              <?php 
              
              
              foreach($class['Stage'] as $t_stage){
              	
              	echo '<h4>Stage '.$t_stage['name'].'</h4>';
              	
              	if(isset($t_stage['Pool']) && count($t_stage['Pool'])>0){
              		
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
              	}
              	
              }
              	
              ?>
            </div>
          </div>
        </div>
</div>

<?php }?>