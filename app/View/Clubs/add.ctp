<h1><?php echo __("creat_nclub"); ?></h1>
<?php
   echo $this->Form->create("Club");
   
   echo $this->Form->input("Club.name", array("class" => "form-control") );
   
   echo "<br />";
   
   echo $this->Form->submit( __("sav"), array("class" => "btn btn-primary") );
   
   echo $this->Form->end( );
?>