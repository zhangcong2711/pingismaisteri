<h1><?php echo __("Seurat"); ?></h1>


<table class="table">

   <tr>
      <th>ID</th>
      <th>Nimi</th>
      <th>Jäseniä</th>
      <th>Poista</th>
   </tr>
<?php
   foreach( $clubs as $club )
   {
?>
   <tr>
      <td><?php echo $club['Club']['id']; ?></td>
      <td><?php echo $club['Club']['name']; ?></td>
      <td><?php 
         echo count($club['Player']) . " ". $this->Html->tag( "span", __("Näytä jäsenet"), array("class" => "btn btn-primary btn-xs show-table-rows", "id" => "club-players-".$club['Club']['id'], "data-target" => ".club-".$club['Club']['id']."-players") );
         
      ?></td>
      <td><?php echo $this->Html->link(__("Poista seura"), "/clubs/delete/".$club['Club']['id'], array("class" => "btn btn-danger") ); ?></td>
   </tr>
   <tr class="club-<?php echo $club['Club']['id']; ?>-players hidden-row">
      <td></td>
      <td colspan="2">
         <table class="table">
            <tr>
               <th>Nimi</th>
               <th>Toiminnot</th>
            </tr>
            <?php foreach( $club['Player'] as $player ) {  ?>
            <tr>
               <td><?php echo $player['lastname'] .", ".$player['firstname']; ?></td>
               <td><?php 
                  
                  echo $this->element(
                     "buttonlink", 
                     array(
                        'label' => "Muokkaa tietoja", 
                        'controller' => 'users', 
                        'action' => 'editPlayer', 
                        'params' => array($player['id']), 
                        'class' => 'btn btn-primary'
                     )
                  );
               
               ?></td>
            </tr>
            <?php } ?>
         </table>
      </td>
      <td></td>
   </tr>
<?php
   }
?>

   <tr>
      <td colspan="4">
         <?php echo $this->Html->link( __("Uusi seura"), "/clubs/add/", array("class" => "btn btn-primary") ); ?>
      </td>
   </tr>

</table>