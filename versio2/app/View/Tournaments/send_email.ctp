<h1>Lähetä osallistujille sähköpostia</h1>


	<br>
	
	<?php
	echo $this->Form->create("Email");

	echo $this->Form->input(
      'Tournaments.EmailOtsikko',
      array(
         'label' => 'Otsikko', 
         'type' => 'text', 
         'escape' => false,
         'class' => "form-control"
      )
   );
   ?>
	<br>
	<?php
	echo $this->Form->input(
      'Tournaments.EmailViesti',
      array(
         'label' => 'Viesti', 
         'type' => 'textarea', 
         'escape' => false,
         'rows' => '20', 
         'cols' => '100',
         'class' => "form-control"
      )
	);
	
	?>
	<br>
	<?php
   echo $this->Form->submit(
      "Lähetä",
      array(
         "class" => "btn btn-primary",
         'value' => "Lähetä"
      ) 
   );
   
   
   echo $this->Form->end();

?>