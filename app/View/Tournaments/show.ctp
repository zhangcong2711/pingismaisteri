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
            
            <?php
            
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
                     'label' => __("download_info"), 
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
                     'label' => __("value_po"), 
                     'controller' => 'tournaments', 
                     'action' => 'drawPools', 
                     'params' => array($tournament['Tournament']['id'],10), 
                     'class' => 'btn btn-primary'
                  )
               );
               
            ?>
            
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
            
            <?php foreach( $class['Registration'] as $reg ) { ?>
               <li>
               <?php 
                  echo $reg['Player']['lastname'].", ".$reg['Player']['firstname']; 
               
                  if( isset( $reg['Player']['Club']['name'] ) ) {
                     echo ' ('. $reg['Player']['Club']['name']. ')'; 
                  }
               ?></li>
            <?php } 
            
            if( count( $class['Registration'] ) == 0 )
            {
               echo __('<li>no_reg</li>');
            }
            
            ?>
            </ul>
            
         <?php
            }
            
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
         ?>
         </div>
      </div>
   </div>
</div>