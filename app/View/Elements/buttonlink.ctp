<?php
   $access = $this->requestAction("/app/checkAccess/". $controller. "/" . $action );

   if( $access )
   {
   
      $params = array_merge( array("controller" => $controller, "action" => $action), $params );
   
      echo $this->Html->link(
         $label, 
         $params,
         array(
            'class' => $class
         )
      );
   }
?>