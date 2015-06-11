<h1>Turnaukset</h1>

<?php
echo $this->Html->tag("span",
		$this->Html->link("Lataa turnaustiedot", 
         array(
            "controller" => "tournaments",
            "action" => "downloadTournamentData",
         ),
         array(
            'class' => 'btn btn-primary'
         )
      )
   );
?>