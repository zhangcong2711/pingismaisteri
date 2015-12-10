


<h1><?php echo __("draw_pools"); ?></h1>


<?php

echo $this->Form->create('PoolForm');

?>

<div class="row">
	<div class="col-md-12">

		<table class="table" id="tournamentClasses">
			<thead>
			<tr>
				<th></th>
				<th><?php echo __('name') ?></th>
				<th><?php echo __('date') ?></th>
				<th><?php echo __('price') ?></th>
				<th><?php echo __('stage_type') ?></th>
				<th><?php echo __('registered_player_num') ?></th>
				<th><?php echo __('pool_num') ?></th>
				<th><?php echo __('is_result_input') ?></th>
				<th><?php echo __('is_drawed') ?></th>
				<th><?php echo __('downloadDraw') ?></th>
				<th><?php echo __('downloadCup') ?></th>
			</tr>
			</thead>
			<tbody>

			<?php

			
			$stage_type_opts = array();
			$stage_type_opts[constant('STAGE_TYPE_POOLS_CUP')] = 'POOLS -> CUP';
			$stage_type_opts[constant('STAGE_TYPE_POOLS_POOLS')] = 'POOLS -> POOLS';
			$stage_type_opts[constant('STAGE_TYPE_POOLS')] = 'POOLS';
			$stage_type_opts[constant('STAGE_TYPE_CUP')] = 'CUP';
			

			foreach ($tournament['ClassInTournament'] as $i => $class) {

				$date = DateTime::createFromFormat("Y-m-d", $class['date']);
				$price = str_replace(".", ",", $class['price']);
				$cname = $class['TournamentClass']['name'];
				$pool_num = $class['pool_num'];
				$stage_type = $class['stage_type'];
				$registeredNum=count($class['Registration']);
				
				$is_drawed=false;
				$is_result_input=true;
				
				if(isset($class['Stage']) && count($class['Stage'])>0){
					
					$pools=$class['Stage'][0]['Pool'];
					if($pool_num==count($pools)){
						$is_drawed=true;
					}
					
					foreach($pools as &$p){
						if(!isset($p['Game']) || count($p['Game'])<=0){
							$is_result_input=false;
							break;
						}else{
							$has_set=true;
							foreach ($p['Game'] as &$t_g){
								if (!isset($t_g['Set']) || count($t_g['Set'])<=0){
									$has_set=false;
									break;
								}
							}
							if(!$has_set){
								$is_result_input=false;
								break;
							}
						}
					}
				}
				
				if(!$is_drawed){
					$is_result_input=false;
				}


				echo $this->Form->input("ClassInTournament." . $i . ".id", array("type" => "hidden", "value" => $class['id']));
				?>
				<tr>
					<td>
						<?php echo $this->Form->checkbox("ClassInTournament." . $i . ".is_to_draw", array('hiddenField' => false));?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".name", array("type" => "text", "readonly" => true, "class" => "form-control", "label" => false, "value" => $cname)); ?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".date", array("type" => "text", "readonly" => true,  "class" => "form-control", "label" => false, "value" => $date->format("d.m.Y"))); ?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".price", array("type" => "text", "readonly" => true,  "class" => "form-control", "label" => false, "value" => $price)); ?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".stage_type", array("type" => "text", "readonly" => true,  "class" => "form-control", "label" => false, "value" => $stage_type_opts[$stage_type])) ?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".registerdPlayerNum", array("type" => "text", "readonly" => true, "class" => "form-control", "label" => false, "value" => $registeredNum)) ?>
					</td>
					<td>
						<?php echo $this->Form->input("ClassInTournament." . $i . ".pool_num", array("type" => "text", "class" => "form-control", "label" => false, "value" => $pool_num)); ?>
					</td>
					<td>
						<?php 
						if($is_result_input){
						
							echo $this->Html->image('yes_32px.png', array('alt' => 'Yes'));
						}else{
						
							echo $this->Html->image('no_32px.png', array('alt' => 'No'));
						}
						?>
					</td>
					<td>
						<?php 
						if($is_drawed){
						
							echo $this->Html->image('yes_32px.png', array('alt' => 'Yes'));
						}else{
						
							echo $this->Html->image('no_32px.png', array('alt' => 'No'));
						}
						?>
					</td>
					<td>
						<?php 
						if($is_drawed){
							
							echo $this->Html->image("download_32px.png", array(
									'url' => array('controller' => 'tournaments', 'action' => 'downloadPoolInfo', $class['id'])
							));
						}
						?>
					</td>
					<td>
						<?php 
						if($is_drawed && $is_result_input){
							
							echo $this->Html->image("download_32px.png", array(
									'url' => array('controller' => 'tournaments', 'action' => 'downloadCupInfo', $class['id'])
							));
						}
						?>
					</td>
				</tr>

				<?php
			}
			?>
			</tbody>
			<tfoot>
			</tfoot>

		</table>


		<br/><br/>

		<?php 
		echo $this->Form->input('minimize_same_club', array(
				'label' => __('minimize_same_club'),
				'type' => 'checkbox'));
		echo $this->Form->input('minimize_same_player', array(
				'label' => __('minimize_same_player'),
				'type' => 'checkbox'));
		?>
	</div>

</div>
<br>


<script type="text/javascript">


</script>
<?php

	echo $this->Html->tag('span', __("draw_attention"), array('style' => 'color:red'));
   echo $this->Form->submit( 
   		__("go_draw"),
   		array(
   				"class" => "btn btn-primary"
   		) 
   	);

   echo $this->Form->end();

?>
