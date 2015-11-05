<h1><?php echo __('tournaments')?></h1>

<table class="table">
   <tr>
      <th>#</th>
      <th><?php echo __('name')?></th>
      <th><?php echo __('cate')?></th>
      <th><?php echo __('act')?></th>
   </tr>
   <?php foreach( $tournaments as $tournament )
   {
   ?>
      <tr>
         <td><?php echo $tournament['Tournament']['id']; ?></td>
         <td><?php 
            echo $this->Html->link(
               $tournament['Tournament']['name'],
               array(
                  "controller" => "tournaments", 
                  "action" => "show", 
                  $tournament['Tournament']['id']
              )
            ); ?><br /><small>
            <?php
               $start = DateTime::createFromFormat( 'Y-m-d', $tournament['Tournament']['startdate'] );
               echo $start->format("d.m.Y");
            ?> - 
            <?php
               $end = DateTime::createFromFormat( 'Y-m-d', $tournament['Tournament']['enddate'] );
               echo $end->format("d.m.Y");
            ?>,
            
            <?php echo $tournament['Tournament']['location']; ?>
            </small>
         </td>
         <td>
            <?php
             echo count($tournament['ClassInTournament']);
            ?>
         </td>
         <td>
         <?php

            echo $this->element(
               "buttonlink", 
               array(
                  'label' => __("signUp2"), 
                  'controller' => 'tournaments', 
                  'action' => 'register', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-primary' 
               )
            );
            
            echo " ";
            
            echo $this->element(
               "buttonlink", 
               array(
                  'label' => __("more_info"), 
                  'controller' => 'tournaments', 
                  'action' => 'show', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-primary' 
               )
            );
            
            echo " ";
            
            echo $this->element(
               "buttonlink", 
               array(
                  'label' => __("edit_info"), 
                  'controller' => 'tournaments', 
                  'action' => 'edit', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-primary'
               )
            );
            
            echo " ";
            
            echo $this->element(
            		"buttonlink",
            		array(
            				'label' => __("game_result"),
            				'controller' => 'games',
            				'action' => 'show',
            				'params' => array($tournament['Tournament']['id']),
            				'class' => 'btn btn-primary'
            		)
            );
            
            echo " ";
            
            echo $this->element(
               "buttonlink", 
               array(
                  'label' => __("remove"), 
                  'controller' => 'tournaments', 
                  'action' => 'deleteTournament', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-danger' 
               )
            );
		  ?>
        </td>
      </tr>
   <?php
   }
   
   if( count( $tournaments ) < 1 )
   {
   ?>
      <tr><td colspan="4">Järjestelmässä ei ole tällä hetkellä turnauksia.</td></tr>
   <?php
   }
   ?> 
</table>

<?php 

   echo $this->element(
      "buttonlink", 
      array(
         'label' => __("create_nt"), 
         'controller' => 'tournaments', 
         'action' => 'add', 
         'params' => array(), 
         'class' => 'btn btn-primary' 
      )
   );

?>