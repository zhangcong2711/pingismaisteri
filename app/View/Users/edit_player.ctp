<h1><?php __("Lisää pelaaja"); ?></h1>

<?php

   echo $this->Form->create('Player');

   echo $this->Form->input("firstname", 
      array( 
         "label" => "Etunimi",
         "class" => "form-control"
      )
   );

   echo $this->Form->input("lastname",
      array( 
         "label" => __("lastname"),
         "class" => "form-control"
      )
   );

   echo $this->Form->input("birthday", 
      array( 
         "label" => __("birthday"),
         "type" => "text",
         "class" => "form-control datepicker",
         "data-date-format" => "dd.mm.yyyy",
      )
   );

   echo $this->Form->input("address", 
      array( 
         "label" => __("address"),
         "class" => "form-control"
      )
   );

   echo $this->Form->input("postalcode", 
      array( 
         "label" => __("postalcode"),
         "class" => "form-control"
      )
   );
   
   echo $this->Form->input("postarea", 
      array( 
         "label" => __("postarea"),
         "class" => "form-control"
      )
   );

   echo $this->Form->input("club_id", 
      array( 
         "label" => __("club_id"),
         "class" => "form-control",
         'options' => $clubs,
         "empty" => "Valitse seura"
      )
   );

   echo $this->Form->input("email", 
      array( 
         "label" => __("email"),
         "class" => "form-control"
      )
   );

   echo $this->Form->input("phone", 
      array( 
         "label" => __("phone"),
         "class" => "form-control"
      )
   );
?>

<div class="input selection">
<?php
echo $this->Form->label( __("Sukupuoli") );

echo "<br />";

echo $this->Form->input('Player.sex', array(
    'legend' => false,
    'label' => false,
    "type" => "radio",
    "div" => array(
      "class" => "btn-group",
      'data-toggle' => 'buttons'
    ),
    "before" => '<label class="btn btn-default">',
    'separator' => '</label><label class="btn btn-default">',
    'after' => '</label>',
    'options' => array("M" => __("Mies"), "F" => __("Nainen") ),
    "default" => "x"
));
?>
</div>
<br />

<?php

   echo $this->Form->submit( __("Tallenna pelaaja"), array("class" => "btn btn-primary") );

   echo $this->Form->end();

?>

