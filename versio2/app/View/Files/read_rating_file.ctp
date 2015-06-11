<?php
   if(!isset($ratingRows))
   {
       echo $this->Form->create("RatingFile", array('type' => 'file'));
   
       echo $this->Form->input("UploadedFile", array("type" => "file", "class" => "form-control", "div" => "form-group") );
   
       echo $this->Form->submit(__("Lataa tiedosto"), array("class" => "btn btn-primary") );
   
       echo $this->Form->end();
   }
   else
   {
       echo  "<h2>Tiedosto on luettu. Tarkista tiedot alta, syötä ratingin päivämäärä ja hyväksy.</h2>";
	  
	   echo '<table class="table">';
	  
	   echo "<tr>";
	     echo "<th>Pelaaja</th>";
		 echo "<th>Rating</h>";
	   echo "</tr>";
      
	  
	  for( $i = 5; $i < 400; $i++) 
	  {
		 echo "<tr>";
	     echo "<td>".$ratingRows[$i]['B']."</td>";
		 echo "<td>".$ratingRows[$i]['F']."</td>";
		 echo "</tr>";
	  }
	  
	  
	  echo "</table>";
	  
	  echo $this->Form->create('ratingOk');
	  echo $this->Form->input('ratingDate', 
      array(
         "type" => "text",
          'label' => 'Rating julkaistu',
          "class" => "form-control datepicker",
          "data-date-format" => "dd.mm.yyyy", 
          "div" => "form-group"
       )
     );
	  echo $this->Form->button('Tallenna', array('type' => 'submit', "class" => "btn btn-primary"));
     echo " ";
     echo $this->Html->link('Hylkää', "", array("class" => "btn btn-primary"));	  
      
	  echo $this->Form->end();
	  
	  
   }
   
?>
