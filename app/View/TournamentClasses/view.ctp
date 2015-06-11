<h1><?php echo __("Tallennetut turnausluokat"); ?></h1>


<table class="table">
   <tr>
      <th>
         <?php 
            if( $order != "id asc" )
            {
               echo $this->Html->link(  __("#"), "/tournament_classes/view/order:id,asc"); 
            }
            else
            {
               echo $this->Html->link(  __("#"), "/tournament_classes/view/order:id,desc"); 
            }
         ?>
      </th>
      <th>
         <?php 
            if( $order != "name asc" )
            {
               echo $this->Html->link(  __("Luokan nimi"), "/tournament_classes/view/order:name,asc"); 
            }
            else
            {
               echo $this->Html->link(  __("Luokan nimi"), "/tournament_classes/view/order:name,desc"); 
            }
         ?>
      </th>
      <th>
         <?php 
         
            echo __("Rajoitteet") ;
            
         ?>
      </th>
      <th>
         <?php echo __("Lisätiedot"); ?>
      </th>
      <th>
         <?php echo __("Toiminnot"); ?>
      </th>
   </tr>

   <?php foreach( $tournamentclasses as $tc )
   {
   
      $class = $tc['TournamentClass'];
   
   ?>
      <tr>
         <td><?php echo $class['id']; ?></td>
         <td><?php echo $class['name']; ?></td>
         <td><?php 
            if( $class['minage'] != ""  ||  $class['maxage'] != "" )
            {
               echo __("Ikä") . ": " . $class['minage'] . " - " . $class['maxage'] . "<br />";
            }
            
            if( $class['maxrating'] != "" || $class['minrating'] != "" )
            {
               echo __("Rating") . ": " . $class['minrating'] . " - " . $class['maxrating'] . "<br />";
            }
            
            if( $class['sex'] != "" )
            {
            
               switch( strtoupper($class['sex']) )
               {
                  case 'F':
                      $sex = __("Nainen");
                      break;
                  case 'M':
                     $sex = __("Mies");
                     break;
                  default:
               }
            
               echo __("Sukupuoli") . ": " . $sex;
            }
            
         ?></td>
         <td><?php echo $class['description']; ?></td>
         <td>
            <span>
         <?php
            echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => "Muokkaa", 
                     'controller' => 'tournamentClasses', 
                     'action' => 'edit', 
                     'params' => array($class['id']), 
                     'class' => 'btn btn-primary'
                  )
               );
         ?>
            </span>
            <span>
            <?php
            
               echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => "Poista", 
                     'controller' => 'tournamentClasses', 
                     'action' => 'delete', 
                     'params' => array($class['id']), 
                     'class' => 'btn btn-danger'
                  )
               );
            ?>
            </span>
         </td>
      </tr>
   <?php
   }
   
   if( count( $tournamentclasses ) < 1 )
   {
   ?>
      <tr><td colspan="4">Järjestelmässä ei ole tällä hetkellä turnausluokkia.</td></tr>
   <?php
   }
   ?> 
</table>

<?php echo $this->Html->link(
			'Luo uusi luokka',
			array('controller' => 'tournamentClasses', 'action' => 'add'),
         array(
            'class' => 'btn btn-primary'
         )
      ); 
?>