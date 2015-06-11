<h1><?php echo $tournament['Tournament']['name']; ?></h1>

<div class="row">
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            Turnauksen tiedot
         </div>
         <div class="panel-body">
            <strong class="data-label">Turnauksen nimi</strong> <?php echo $tournament['Tournament']['name']; ?><br />
            <strong class="data-label">Järjestäjä</strong> <?php echo $tournament['Tournament']['organizer']; ?><br />
            
            <p><?php echo $tournament['Tournament']['additionalinfo']; ?></p>

            <hr />
            
            <strong class="data-label">Ajankohta</strong> <?php 
               
               $start = DateTime::createFromFormat( 'Y-m-d', $tournament['Tournament']['startdate'] );
               echo $start->format("d.m.Y");
               
            ?>
            -
            <?php 
            
               $end = DateTime::createFromFormat( 'Y-m-d', $tournament['Tournament']['enddate'] );
               echo $end->format("d.m.Y");
               
            ?><br />
            <strong class="data-label">Sijainti</strong> <?php echo $tournament['Tournament']['location']; ?>
            
            <hr />
            
            <strong class="data-label">Leikkuripäivä</strong>
            <?php 
            
               $cutter = DateTime::createFromFormat( 'Y-m-d', $tournament['Tournament']['cuttingdate'] );
               echo $cutter->format("d.m.Y");
               
            ?>
            
            <hr />
            
            <strong class="data-label">Lisätiedot</strong><br />
            <?php
               echo $tournament['Tournament']['contact'] ."<br />";
               echo $tournament['Tournament']['contactphone'] ."<br />";
               echo $tournament['Tournament']['contactemail'];
            ?>
            
            <?php if( $this->requestAction("/app/checkAccess/tournaments/collectTournamentData/") ) { ?>
            
            <hr />
            
            <strong class="data-label">Toiminnot</strong><br /><br />
            
            <?php } ?>
            
            <p><?php
            
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
                     'label' => "Lataa tiedot", 
                     'controller' => 'tournaments', 
                     'action' => 'collectTournamentData', 
                     'params' => array($tournament['Tournament']['id']), 
                     'class' => 'btn btn-primary'
                  )
               );
               
               echo " ";
               
               echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => "Arvo poolit", 
                     'controller' => 'tournaments', 
                     'action' => 'cycleAndDrawClasses', 
                     'params' => array($tournament['Tournament']['id']), 
                     'class' => 'btn btn-primary'
                  )
               );

               echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => "Lähetä osallistujille sähköpostia", 
                     'controller' => 'tournaments', 
                     'action' => 'sendEmail', 
                     'params' => array($tournament['Tournament']['id']), 
                     'class' => 'btn btn-primary'
                  )
               );
               
            ?></p>
            
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            Ilmoittautuneet
         </div>
         <div class="panel-body">
         <?php
            $date = "";
         
            foreach( $tournament['ClassInTournament'] as $class )
            {
            
               if( $class['date'] != $date )
               {
                  $date = $class['date'];
                  
                  $format = DateTime::createFromFormat("Y-m-d", $date);
                  
                  echo "<h4>".$format->format("d.m.Y")."</h4>";
               }
            
         ?>
            <strong><?php echo $class['TournamentClass']['name']; ?></strong><br />
            
            <ul>
            
            <?php foreach( $class['Registration'] as $reg ) { 
               
               $flag = false;
               
               if( $class['TournamentClass']['maxage'] != "" && $reg['Player']['age'] > $class['TournamentClass']['maxage'] )
               {
                  $flag = true;
                  $error_message = "Tarkista ikä";
               }

               if( $class['TournamentClass']['minage'] != "" && $reg['Player']['age'] < $class['TournamentClass']['minage'] )
               {
                  $flag = true;
                  $error_message = "Tarkista ikä";
               }
               
               if( $flag ) 
               {
                  $error = "error";
               }
               else
               {
                  $error = "";
               }
               
            ?>
               <li class="<?php echo $error; ?>">
               <?php 
                  echo $reg['Player']['lastname'].", ".$reg['Player']['firstname']; 
               
                  if( isset( $reg['Player']['Club']['name'] ) ) {
                     echo ' ('. $reg['Player']['Club']['name']. ')'; 
                  }
               ?></li>
            <?php } 
            
            if( count( $class['Registration'] ) == 0 )
            {
               echo '<li>Ei ilmoittautuneita</li>';
            }
            
            ?>
            </ul>
            
         <?php
            }
         ?>
         </div>
      </div>
   </div>
</div>