<?php
   $return = '<tr>
   
   <td>
      '.$this->Form->input("Stage.".$iterator.".name", array("type" => "text", "class" => "form-control", "label" => false)) .'
   </td>
   <td>
      '. $this->Form->input("Stage.".$iterator.".type", array("options" => $types, "class" => "form-control", "label" => false) ) . '
   </td>
   <td>
      '.$this->Html->link(__('remove'), "#", array("class" => "remove-form-row-button btn btn-primary") ) .'
   </td>
</tr>';

$data = array(
      "content" => $return
   );


echo base64_encode( json_encode($data) );

?>