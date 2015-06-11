<h1>Oma tili</h1>

   <h2>Omat tiedot</h2>
   
   <div class="personal-data">
      <strong class="personal-data-label">Nimi</strong>
      <span class="personal-data-value"><?php echo $user['User']['name']; ?></span>
   </div>
   
   <div class="personal-data">
      <strong class="personal-data-label">Sähköpostiosoite</strong>
      <span class="personal-data-value"><?php echo $user['User']['email']; ?></span>
   </div>
   
   <div class="personal-data">
      <strong class="personal-data-label">Puhelinnumero</strong>
      <span class="personal-data-value"><?php echo $user['User']['phone']; ?></span>
   </div>

   <h2>Tiliin lisätyt pelaajat</h2>
   
   <table class="personal-players table">
      <tr>
         <th>Lisenssi</th>
         <th>Nimi</th>
         <th>Osoite</th>
         <th>Ikä</th>
         <th>Sukupuoli</th>
         <th>Seura</th>
         <th>Yhteystiedot</th>
         <th>Ilmoittautumiset</th>
         <th>Poista listasta</th>
      </tr>

   <?php
      foreach( $user['Player'] as $player )
      {
   ?>
         <tr>
            <td><?php echo $player['license_code']; ?></td>
            <td><?php echo $player['lastname'].", ".$player['firstname']; ?></td>
            <td><?php echo $player['address']. "<br />". $player['postalcode']." ".$player['postarea']; ?></td>
            <td><?php echo $player['age']; ?></td>
            <td><?php echo $player['sex']; ?></td>
            <td><?php
            
            if( isset( $player['Club']['name'] ) )
               echo $player['Club']['name']; 
               
            ?></td>
            <td><?php echo $this->Html->link($player['email'], "mailto:".$player['email']). "<br />". $this->Html->link($player['phone'], "tel:".$player['phone']); ?></td>
            <td><?php echo $this->Html->link('Näytä ilmoittautumiset <span class="caret"></span>', "/users/listRegistrations/".$player['id'], array("data-target" => "#registrations".$player['id'] ,"class" => "btn btn-primary show-table-rows", "escape" => false) ); ?></td>
            <td>
            <?php
               echo $this->element(
                  "buttonlink", 
                  array(
                     'label' => __('Poista'), 
                     'controller' => 'Users', 
                     'action' => 'deletePlayer', 
                     'params' => array($player['id']), 
                     'class' => 'btn btn-danger',
                     'confirm' => 'Haluatko varmasti poistaa tämän pelaajan hallittavien pelaajien listasta?'
                  )
               );
            ?>
            </td>
         </tr>
   <?php
         if( count( $player['Registration'] ) > 0 )
         {
   ?>
         <tr class="hidden-row" id="registrations<?php echo $player['id']; ?>">
            <td></td>
            <td colspan="6">
               <table>
                  <tr>
                     <th>Turnaus</th>
                     <th>Aika</th>
                     <th>Luokat</th>
                     <th>Peru ilmoittautuminen</th>
                  </tr>
   <?php
            
            $tournament = 0;
   
            foreach( $player['Registration'] as $registration )
            {
               $starts = new DateTime( $registration['ClassInTournament']['Tournament']['startdate'] );
               $ends = new DateTime( $registration['ClassInTournament']['Tournament']['enddate'] );
            
      ?>
                  <tr>
                     <td><?php
                        if( $tournament != $registration['ClassInTournament']['tournament_id'] )
                        {
                           echo $registration['ClassInTournament']['Tournament']['name'];
                           
                        }
                     ?></td>
                     <td><?php
                        if( $tournament != $registration['ClassInTournament']['tournament_id'] )
                        {
                           echo $starts->format("d.m.Y"). " - ".$ends->format("d.m.Y"); 
                           $tournament = $registration['ClassInTournament']['tournament_id'];
                        }
                     ?></td>
                     <td><?php echo $registration['ClassInTournament']['TournamentClass']['name']; ?><br /><?php 
                        $date = DateTime::createFromFormat("Y-m-d", $registration['ClassInTournament']['date']);
                        echo $date->format("d.m.Y"); ?></td>
                     <td><?php echo $this->Html->link("Peru ilmoittautuminen", "/users/cancelRegistration/".$registration['id'] , array("class" => "btn btn-danger") ); ?></td>
                  </tr>
      <?php
            }
      ?>
               </table>
            </td>
         </tr>
      <?php
         }
         else
         {
      ?>
         <tr class="hidden-row" id="registrations<?php echo $player['id']; ?>">
            <td></td>
            <td colspan="6"><?php echo __("Ei ilmoittautumisia"); ?></td>
         </tr>
      <?php
         }
      }
   ?>
   </table>
   
   <?php echo $this->Html->link(
			'Lisää uusi pelaaja',
			array('controller' => 'users', 'action' => 'addPlayer'),
         array(
            'class' => 'btn btn-primary'
         )
      );
   ?>