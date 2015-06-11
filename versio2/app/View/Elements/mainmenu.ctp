<?php

   $menuitems = array(
      array('label' => "Kirjaudu sisään", 'controller' => 'Users', 'action' => 'login'),
      array('label' => "Rekisteröidy", 'controller' => 'Users', 'action' => 'register'),
      array('label' => "Turnaukset", 'controller' => 'Tournaments', 'action' => 'view'),
      array('label' => "Turnausluokat", 'controller' => 'TournamentClasses', 'action' => 'view'),
      array('label' => "Seurat", 'controller' => 'Clubs', 'action' => 'view'),
      array("label" => "Päivitä ratingit", "controller" => "Files", "action" => "readRatingFile"),
      array('label' => "Oma tili", 'controller' => 'Users', 'action' => 'MyAccount')
   );
   
?>

<ul class="nav navbar-nav">

<?php
   
   foreach( $menuitems as $item )
   {
      $access = $this->requestAction("/app/checkAccess/". $item['controller'] . "/" . $item['action'] );
      
      if( $access )
      {
   ?>
   <li><?php echo $this->Html->link($item['label'], array('controller' => $item['controller'], 'action' => $item['action']) ); ?></li>
   <?php
      }
      
   }
   
?>

</ul>

<?php if( $this->requestAction("/app/checkAccess/users/logout" ) ) { ?>

<ul class="nav navbar-nav navbar-right">
   <li><?php echo $this->Html->link("Kirjaudu ulos", "/users/logout" ); ?></li>
</ul> 

<?php } ?>