<?php
   $return = '<tr>
   <td>
      '. $this->Form->input("TournamentClass.".$iterator.".tournament_class_id", array("options" => $classes, "class" => "form-control", "label" => false) ) . '
   </td>
   <td>
      '.$this->Form->input("TournamentClass.".$iterator.".date", array("type" => "text", "class" => "form-control", "label" => false)) .'
   </td>
   <td>
      '.$this->Form->input("TournamentClass.".$iterator.".price", array("type" => "text", "class" => "form-control", "label" => false)) .'
   </td>
   <td>
      '.$this->Form->input("TournamentClass.".$iterator.".pool_size", array("type" => "text", "class" => "form-control", "label" => false)) .'
   </td>
   <td>
      '.$this->Form->input("TournamentClass.".$iterator.".placed_players", array("type" => "text", "class" => "form-control", "label" => false)) .'
   </td>
   <td>
      '.$this->Html->link("Poista", "#", array("class" => "remove-form-row-button btn btn-primary") ) .'
   </td>
</tr>';

   $data = array(
      "content" => $return
   );


echo base64_encode( json_encode($data) );

?>