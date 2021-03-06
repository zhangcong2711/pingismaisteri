<h1>Turnaukset</h1>

<table class="table">
   <tr>
      <th>#</th>
      <th>Nimi</th>
      <th>Luokkia</th>
      <th>Toiminnot</th>
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
                  'label' => "Ilmoittaudu", 
                  'controller' => 'tournaments', 
                  'action' => 'register', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-primary',
               )
            );
            
            echo " ";
            
            echo $this->element(
               "buttonlink", 
               array(
                  'label' => "Lisätietoja", 
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
                  'label' => "Muokkaa tietoja", 
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
                  'label' => "Poista", 
                  'controller' => 'tournaments', 
                  'action' => 'deleteTournament', 
                  'params' => array($tournament['Tournament']['id']), 
                  'class' => 'btn btn-danger',
                  'confirm' => 'Haluatko varmasti poistaa turnauksen tiedot?'
               )
            );
		  ?>
        </td>
      </tr>
   <?php
   }
   ?> 
</table>

<?php  
      echo $this->element(
         "buttonlink", 
         array(
            'label' => "Uusi turnaus", 
            'controller' => 'tournaments', 
            'action' => 'add', 
            'params' => array(), 
            'class' => 'btn btn-primary',
         )
      );
?>