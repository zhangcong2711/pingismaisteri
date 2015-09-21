<h1>Input game result</h1>


<table class="table">
   <tr>
      <th>
         Pool 
      </th>
      <th>
         Game Num
      </th>
   </tr>

   <?php foreach( $pools as &$t_pool )
   {
   
      $games = $t_pool['Game'];
   ?>
   <tr>
     <td><?php echo $t_pool['Pool']['name']; ?></td>
     <td>
     <?php 
     	echo count($games);
     ?>
     </td>
   </tr>
   <?php 
   }
   ?>
</table>
<?php echo $this->Html->link(
			'Add game result',
			array('controller' => 'games', 'action' => 'add'),
	         array(
	            'class' => 'btn btn-primary'
	         )
      ); 
?>