<div class="row">
   <div class="col-md-8">
   
   <h2><?php echo __("Kirjaudu sisään"); ?></h2>
   
<?php 

   echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login") ) );
   
   echo $this->Form->input("User.email", 
      array(
         "label" => __("Sähköpostiosoite"),
         "class" => "form-control"
      )
   );
   echo $this->Form->input("User.password", 
      array(
         "type" => "password", 
         "label" => __("Salasana"),
         "class" => "form-control"
      )
   );
   
   echo "<br />";
   
   echo $this->Form->submit( __("Kirjaudu sisään"), array("class" => "btn btn-primary") );
   
   echo $this->Form->end();

?>
   </div>
</div>