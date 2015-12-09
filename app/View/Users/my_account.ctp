<h1><?php echo __('myAccount')?></h1>

   <h2><?php echo __('myInfo')?></h2>
   
   <div class="personal-data">
      <strong class="personal-data-label"><?php echo __('name')?></strong>
      <span class="personal-data-value"><?php echo $user['User']['name']; ?></span>
   </div>
   
   <div class="personal-data">
      <strong class="personal-data-label"><?php echo __('email')?></strong>
      <span class="personal-data-value"><?php echo $user['User']['email']; ?></span>
   </div>
   
   <div class="personal-data">
      <strong class="personal-data-label"><?php echo __('phone')?></strong>
      <span class="personal-data-value"><?php echo $user['User']['phone']; ?></span>
   </div>

   <h2><?php echo  __('added_account')?></h2>
   
   <table class="personal-players table">
      <tr>
         <th><?php echo __('name')?></th>
         <th><?php echo __('address')?></th>
         <th><?php echo __('age')?></th>
         <th><?php echo __('sex')?></th>
         <th><?php echo __('club_id')?></th>
         <th><?php echo __('contact')?></th>
         <th><?php echo __('registrations')?></th>
      </tr>

   <?php
      foreach( $user['Player'] as $player )
      {
   ?>
         <tr>
            <td><?php echo $player['lastname'].", ".$player['firstname']; ?></td>
            <td><?php echo $player['address']. "<br />". $player['postalcode']." ".$player['postarea']; ?></td>
            <td><?php echo $player['age']; ?></td>
            <td><?php echo $player['sex']; ?></td>
            <td><?php
            
            if( isset( $player['Club']['name'] ) )
               echo $player['Club']['name']; 
               
            ?></td>
            <td><?php echo $this->Html->link($player['email'], "mailto:".$player['email']). "<br />". $this->Html->link($player['phone'], "tel:".$player['phone']); ?></td>
            <td><?php 
               if( count($player['Registration']) < 1 )
               {
                  echo '<span class="label label-default">Ei ilmoittautumisia</span>';
               }
               else
               {
                  echo $this->Html->link(__('show_all').' ('.count($player['Registration']).') <span class="caret"></span>', "/users/listRegistrations/".$player['id'], array("data-target" => "#registrations".$player['id'] ,"class" => "btn btn-primary show-table-rows", "escape" => false) ); ?></td>
            <?php
               }
            ?>
         </tr>
   <?php
         if( count( $player['Registration'] ) > 0 )
         {
   ?>
         <tr class="hidden-row" id="registrations<?php echo $player['id']; ?>">
            <td></td>
            <td colspan="5">
               <table>
                  <tr>
                     <th><?php echo __('tournament')?></th>
                     <th><?php echo __('time')?></th>
                     <th><?php echo __('categories')?></th>
                     <th><?php echo __('cancel_registration')?></th>
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
                     <td><?php echo $this->Html->link(__("user_peru_reg"), "/users/cancelRegistration/".$registration['id'] , array("class" => "btn btn-danger") ); ?></td>
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
            <td colspan="6"><?php echo __("no_registrations"); ?></td>
         </tr>
      <?php
         }
      }
   ?>
   </table>
   
   <?php echo $this->Html->link(
			__('add_new'),
			array('controller' => 'users', 'action' => 'addPlayer'),
         array(
            'class' => 'btn btn-primary'
         )
      );
   ?>