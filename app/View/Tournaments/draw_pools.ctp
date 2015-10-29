


<h1>Poolien arvonta</h1>


<?php

echo $this->Form->create('PoolForm');

?>

<div class="row">
	<div class="col-md-12">

		<table class="table" id="tournamentClasses">
			<thead>
			<tr>
				<th><?php echo __('name') ?></th>
				<th><?php echo __('date') ?></th>
				<th><?php echo __('price') ?></th>
				<th><?php echo __('stage_type') ?></th>
				<th><?php echo __('registered_player_num') ?></th>
				<th><?php echo __('pool_num') ?></th>
				<th><?php echo __('is_result_input') ?></th>
				<th><?php echo __('is_drawed') ?></th>
				<th><?php echo __('downloadDraw') ?></th>
			</tr>
			</thead>
			<tbody>

			<?php

			$stage_type_opts = array();
			$stage_type_opts[constant('STAGE_TYPE_POOLS_CUP')] = 'POOLS -> CUP';
			$stage_type_opts[constant('STAGE_TYPE_POOLS_POOLS')] = 'POOLS -> POOLS';
			$stage_type_opts[constant('STAGE_TYPE_POOLS')] = 'POOLS';
			$stage_type_opts[constant('STAGE_TYPE_CUP')] = 'CUP';

			foreach ($this->request->data['ClassInTournament'] as $i => $class) {

				$date = DateTime::createFromFormat("Y-m-d", $class['date']);
				$price = str_replace(".", ",", $class['price']);
				$pool_num = $class['pool_num'];
				$stage_type = $class['stage_type'];


				echo $this->Form->input("TournamentClass." . $i . ".id", array("type" => "hidden", "value" => $class['id']));
				?>
				<tr>
					<td>
						<?php echo $this->Form->input("TournamentClass." . $i . ".tournament_class_id", array("options" => $tournamentclasses, "class" => "form-control", "label" => false, "default" => $class['tournament_class_id'])); ?>
					</td>
					<td>
						<?php echo $this->Form->input("TournamentClass." . $i . ".date", array("type" => "text", "class" => "form-control", "label" => false, "value" => $date->format("d.m.Y"))); ?>
					</td>
					<td>
						<?php echo $this->Form->input("TournamentClass." . $i . ".price", array("type" => "text", "class" => "form-control", "label" => false, "value" => $price)); ?>
					</td>
					<td>
						<?php echo $this->Form->input("TournamentClass." . $i . ".stage_type", array(
							'id' => 'stage_type_select',
							'label' => false,
							'disabled' => true,
							'type' => 'select',
							'options' => $stage_type_opts,
							'empty' => false,
							'value' => $stage_type,
							'class' => 'form-control'
						)) ?>
					</td>
					<td>
						<?php echo $this->Form->input("TournamentClass." . $i . ".pool_num", array("type" => "text", "class" => "form-control", "label" => false, "value" => $pool_num)); ?>
					</td>
					<td>
						<?php
						echo $this->Html->link(__("remove"), "#",
							array(
								"class" => "delete-row btn btn-primary",
								"data-class" => "ClassInTournament",
								"data-id" => $class['id'],
								"data-url" => $this->Html->url("/ajax/removeRowFromClass")
							)
						);
						?>
					</td>
				</tr>

				<?php
			}
			?>
			</tbody>
			<tfoot>
			<tr class="newClassRow">
				<td colspan="4">
					<?php echo $this->Html->link(
						__("add_category"),
						"/ajax/newTournamentClassRow",
						array(
							"class" => "new-row-link btn btn-primary",
							"data-url" => $this->Html->url("/ajax/newTournamentClassRow"),
							"data-target" => "#tournamentClasses tbody",
							"data-count" => "#tournamentClasses tbody tr"
						)
					); ?>
				</td>
			</tr>
			</tfoot>

		</table>


		<br/><br/>

		<?php

		$options = array();
		//$options['-1']='Select a stage';

		foreach ($all_stages as &$st) {
			$options[$st['Stage']['id']] = $st['Stage']['name'] . '_' . $st['Stage']['type'];
		}

		echo $this->Form->input('stage_select', array(
			'id' => 'stage_select',
			'label' => __('stage_select'),
			'type' => 'select',
			'options' => $options,
			'empty' => true,
			'class' => 'form-control',
			'onchange' => 'on_stage_select(this);'
		));

		?>

		<div id="draw_setting" class="col-md-12">
			<br>


		</div>
	</div>

</div>
<br>


<script type="text/javascript">


</script>
<?php

   echo $this->Form->submit( __("go_draw"),
   array("class" => "btn btn-primary") );

   echo $this->Form->end();

?>
