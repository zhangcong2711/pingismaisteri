<h1><?php echo __("Seurat"); ?></h1>


<table class="table">

   <tr>
      <th>ID</th>
      <th><?php echo _('name')?></th>
      <th><?php echo _('members')?></th>
      <th><?php echo _('remove')?></th>
   </tr>
<?php
   foreach( $clubs as $club )
   {
?>
   <tr>
      <td><?php echo $club['Club']['id']; ?></td>
      <td><?php echo $club['Club']['name']; ?></td>
      <td><?php 
         echo count($club['Player']) . " ". $this->Html->tag( "span", __("view_memb"), array("class" => "btn btn-primary btn-xs show-table-rows", "id" => "club-players-".$club['Club']['id'], "data-target" => ".club-".$club['Club']['id']."-players") );
         
      ?></td>
      <td><?php echo $this->Html->link(__("del_club"), "/clubs/delete/".$club['Club']['id'], array("class" => "btn btn-danger") ); ?></td>
   </tr>
   <tr class="club-<?php echo $club['Club']['id']; ?>-players hidden-row">
      <td></td>
      <td colspan="2">
         <table class="table">
            <tr>
               <th><?php echo __('name')?></th>
               <th>Toiminnot</th>
            </tr>
            <?php foreach( $club['Player'] as $player ) {  ?>
            <tr>
               <td><?php echo $player['lastname'] .", ".$player['firstname']; ?></td>
               <td><?php 
                  
                  echo $this->element(
                     "buttonlink", 
                     array(
                        'label' => __("edit_info"), 
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
         <?php echo $this->Html->link( __("creat_nclub"), "/clubs/add/", array("class" => "btn btn-primary") ); ?>
      </td>
   </tr>

</table>