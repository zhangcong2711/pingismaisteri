<?php
$stage_type_opts = array ();
$stage_type_opts [constant ( 'STAGE_TYPE_POOLS_CUP' )] = 'POOLS -> CUP';
$stage_type_opts [constant ( 'STAGE_TYPE_POOLS_POOLS' )] = 'POOLS -> POOLS';
$stage_type_opts [constant ( 'STAGE_TYPE_POOLS' )] = 'POOLS';
$stage_type_opts [constant ( 'STAGE_TYPE_CUP' )] = 'CUP';

$return = '<tr>
   <td>
      ' . $this->Form->input ( "TournamentClass." . $iterator . ".tournament_class_id", array (
		"options" => $classes,
		"class" => "form-control",
		"label" => false 
) ) . '
   </td>
   <td>
      ' . $this->Form->input ( "TournamentClass." . $iterator . ".date", array (
		"type" => "text",
		"class" => "form-control",
		"label" => false 
) ) . '
   </td>
   <td>
      ' . $this->Form->input ( "TournamentClass." . $iterator . ".price", array (
		"type" => "text",
		"class" => "form-control",
		"label" => false 
) ) . '
   </td>
   <td>
      ' . $this->Form->input ( "TournamentClass." . $iterator . ".stage_type", array (
		'id' => 'stage_type_select',
		'label' => false,
		'type' => 'select',
		'options' => $stage_type_opts,
		'empty' => false,
		'class' => 'form-control' 
) ) . '
   </td>
	<td>
      ' . $this->Form->input ( "TournamentClass." . $iterator . ".pool_num", array (
		"type" => "text",
		"class" => "form-control",
		"label" => false 
) ) . '
   </td>
   <td>
      ' . $this->Html->link ( __ ( "remove" ), "#", array (
		"class" => "remove-form-row-button btn btn-primary" 
) ) . '
   </td>
</tr>';

$data = array (
		"content" => $return 
);

echo base64_encode ( json_encode ( $data ) );

?>