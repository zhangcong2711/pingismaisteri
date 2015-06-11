<h1>Poolien arvonta</h1>

<table class="table">
<th>
	<?php

		echo ("Luokan nimi"); 

	?>
	</th>

	<?php
    foreach( $tournament['ClassInTournament'] as $class )
    {
	?><tr>
		<td>
		<?php
		echo $class['TournamentClass']['name'];
		?>
		</td></tr>
		<?php
    }
	
	?>


	</table>
	
	
<?php

   echo $this->Form->submit( "Suorita arvonta",
   array("class" => "btn btn-primary") );
   
   	?><br><?php

   echo $this->Form->submit( "Tallenna poolit",
   array("class" => "btn btn-primary") );
   
   echo $this->Form->end();

?>