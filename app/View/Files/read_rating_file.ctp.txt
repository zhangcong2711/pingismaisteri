<?php

   echo $this->Form->create("RatingFile", array('type' => 'file'));
   
   echo $this->Form->input("UploadedFile", array("type" => "file") );
   
   echo $this->Form->submit(__("Lataa tiedosto") );
   
   echo $this->Form->end();


?>