<?php

   $menuitems = array(
      array('label' => __("logIn"), 'controller' => 'Users', 'action' => 'login'),
      array('label' => __("signUp"), 'controller' => 'Users', 'action' => 'register'),
      array('label' => __("tournaments"), 'controller' => 'Tournaments', 'action' => 'view'),
      array('label' => __("tournamentCategory"), 'controller' => 'TournamentClasses', 'action' => 'view'),
   	  array('label' => __("gameResult"), 'controller' => 'Games', 'action' => 'view'),
      array('label' => __("clubs"), 'controller' => 'Clubs', 'action' => 'view'),
      array('label' => __("myAccount"), 'controller' => 'Users', 'action' => 'MyAccount')
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



<ul class="nav navbar-nav navbar-right">

   <li><?php echo $this->Html->link('Eng', '/changeLanguage/en'); ?></li>
   <li><?php echo $this->Html->link('Fin', '/changeLanguage/fin'); ?></li>
               
   <?php if( $this->requestAction("/app/checkAccess/users/logout" ) ) { ?>
   <li><?php echo $this->Html->link(__("logOut"), "/users/logout" ); ?></li>
   <?php } ?>
</ul> 

