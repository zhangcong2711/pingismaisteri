<h1><?php echo __("user_tournament_reg").$tournament['Tournament']['name']; ?></h1>

<?php
   echo $this->Form->create("Registration");
   echo $this->Form->input("Tournament.id", array("type" => "hidden", "value" => $tournament['Tournament']['id'] ) );
?>
<table class="table">
   <tr>
      <th>Pelaaja</th>
      <?php
      foreach( $tournament['ClassInTournament'] as $cit )
      {
         $class = $cit['TournamentClass'];
         
         $date = DateTime::createFromFormat("Y-m-d", $cit['date']);
      
      ?>
      <th><?php echo $class['name']; ?><br />
      <small><?php echo $date->format("d.m.Y"); ?></small></th>
      <?php
      }
      ?>
   </tr>
<?php
   foreach( $players['Player'] as $i => $player) {
      echo $this->Form->input( "Player.".$i.".player_id", array("type" => "hidden", "value" => $player['id']) );
      echo $this->Form->input( "Player.".$i.".name", array("type" => "hidden", "value" => $player['lastname'].", ".$player['firstname']) );
      
      $registrations = array();
      
      foreach( $player['Registration'] as $reg )
      {
         $registrations[] = $reg['tournament_class_id'];
      }
      
?>
   <tr>
      <td><?php echo $player['lastname'].", ".$player['firstname']; ?></td>
<?php
      foreach( $tournament['ClassInTournament'] as $j => $cit )
      {
      
         $class = $cit['TournamentClass'];
       
         $allowed = true;
         
         // Check limitations
         if( $class['maxage'] != "" && $player['age'] > $class['maxage'] )
         {
            $allowed = false;
         }
         
         if( $class['minage'] != "" && $player['age'] < $class['minage'] )
         {
            $allowed = false;
         }
         
         if( $class['sex'] == "F" && $player['sex'] != $class['sex'] )
         {
            $allowed = false;
         }
         
         if( $allowed )
         {
            
            if( in_array( $cit['id'], $registrations ) )
            {
            ?>
               <td><span class="badge"><?php echo __("registered"); ?></span></td>
            <?php
            }
            else
            {
?>
         <td>
         
         <div class="input selection">
            <?php
               echo $this->Form->input("Player.".$i.".ClassInTournament.".$j.".register", array(
                   'legend' => false,
                   'label' => false,
                   "type" => "checkbox",
                   "div" => array(
                     "class" => "btn-group",
                     'data-toggle' => 'buttons'
                   ),
                   "before" => '<label class="btn btn-default">',
                   'after' => __("signUp2").'</label>',
                   "value" => "1",
                   "hiddenField" => false
               ));
               
               $this->Form->unlockField("Player.".$i.".ClassInTournament.".$j.".register");
            ?>
         </div>
         <?php 
            
            echo $this->Form->input("Player.".$i.".ClassInTournament.".$j.".tournament_class_id", array("type" => "hidden", "value" => $cit['id']) ); 
            echo $this->Form->input("Player.".$i.".ClassInTournament.".$j.".price", array("type" => "hidden", "value" => $cit['price']) ); 
            echo $this->Form->input("Player.".$i.".ClassInTournament.".$j.".name", array("type" => "hidden", "value" => $cit['TournamentClass']['name'] ) ); 
            echo $this->Form->input("Player.".$i.".ClassInTournament.".$j.".date", array("type" => "hidden", "value" => $cit['date']) ); 
         
         ?>
         </td>
<?php
            }
         }
         else
         {
?>
         <td></td>
<?php
         }
      }
?>
   </tr>
<?php
   }
?>
</table>

<?php

   echo $this->Form->submit( __("signUp2"), array( "class" => "btn btn-primary") );

   echo $this->Form->end();
?>