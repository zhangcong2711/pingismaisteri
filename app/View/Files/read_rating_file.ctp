<?php

   echo $this->Form->create("RatingFile", array('type' => 'file'));
   
   echo $this->Form->input("UploadedFile", array("type" => "file") );
   
   echo $this->Form->submit(__("dl_file") );
   
   echo $this->Form->end();


?>