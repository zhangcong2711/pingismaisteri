<div class="row">
   <div class="col-md-8">
   
   <h2><?php echo __("logIn"); ?></h2>
   
<?php 

   echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "login") ) );
   
   echo $this->Form->input("User.email", 
      array(
         "label" => __("emailAddress"),
         "class" => "form-control"
      )
   );
   echo $this->Form->input("User.password", 
      array(
         "type" => "password", 
         "label" => __("password"),
         "class" => "form-control"
      )
   );
   
   echo "<br />";
   
   echo $this->Form->submit( __("logIn"), array("class" => "btn btn-primary") );
   
   echo $this->Form->end();

?>
   </div>
</div>