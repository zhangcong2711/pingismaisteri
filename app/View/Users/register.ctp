<?php 

   echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "register") ) );
   
   echo $this->Form->input("User.name", array("label" => __("Nimi"), "class" => "form-control"));
   echo $this->Form->input("User.email", array("label" => __("Sähköpostiosoite"), "class" => "form-control"));
   echo $this->Form->input("User.phone", array("label" => __("Puhelinnumero"), "class" => "form-control"));
   echo $this->Form->input("User.pwd", array("type" => "password", "label" => __("Salasana"), "class" => "form-control"));
   echo $this->Form->input("User.pwd2", array("type" => "password", "label" => __("Salasana uudestaan"), "class" => "form-control"));
   
   echo "<br />";
   
   echo $this->Form->submit(__("Rekisteröidy"), array("class" => "btn btn-primary") );
   echo $this->Form->end();

?>