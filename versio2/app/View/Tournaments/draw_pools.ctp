<h1>Poolien arvonta</h1>

   <div class="row">
      <div class="col-md-3">
	  <br>
		<?php
        echo $this->Form->create('PoolForm');
		
		echo "<b>Rekisteröityneitä pelaajia " . $regs . "</b>";
		?>
		<br><br>
		<?php
        echo $this->Form->input('numberOfPools', array(
             'label' => 'Poolien lukumäärä',
             "class" => "form-control"
         ));
		 ?>
		<br>
		<?php
		echo $this->Form->input('placedPlayers', array(
             'label' => 'Sijoitettavien pelaajien lukumäärä',
             "class" => "form-control"
         ));
		 ?>

		</div>
	</div>
	<br>
<?php

   echo $this->Form->submit( "Suorita arvonta",
   array("class" => "btn btn-primary") );
   
   echo $this->Form->end();

?>