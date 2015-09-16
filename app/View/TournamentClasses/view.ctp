<h1><?php echo __("savd_cat"); ?></h1>


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
               echo $this->Html->link(  __("cat_name"), "/tournament_classes/view/order:name,asc"); 
            }
            else
            {
               echo $this->Html->link(  __("cat_name"), "/tournament_classes/view/order:name,desc"); 
            }
         ?>
      </th>
      <th>
         <?php 
         
            echo __("constraints") ;
            
         ?>
      </th>
      <th>
         <?php echo __("additionalinfo"); ?>
      </th>
      <th>
         <?php echo __("act"); ?>
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
               echo __("age") . ": " . $class['minage'] . " - " . $class['maxage'] . "<br />";
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
                      $sex = __("female");
                      break;
                  case 'M':
                     $sex = __("male");
                     break;
                  default:
               }
            
               echo __("sex") . ": " . $sex;
            }
            
         ?></td>
         <td><?php echo $class['description']; ?></td>
         <td>
            <span>
         <?php
            echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => __("custom"), 
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
                     'label' => __("remove"), 
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
			__('create_ntc'),
			array('controller' => 'tournamentClasses', 'action' => 'add'),
         array(
            'class' => 'btn btn-primary'
         )
      ); 
?>