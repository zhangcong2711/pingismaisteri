<?php 

   echo $this->Form->create("User", array("url" => array("controller" => "users", "action" => "register") ) );
   
   echo $this->Form->input("User.firstname", array("label" => __("Etunimi"), "class" => "form-control",
         'div' => 'form-group'));
   echo $this->Form->input("User.lastname", array("label" => __("Sukunimi"), "class" => "form-control",
         'div' => 'form-group'));
   echo $this->Form->input("User.email", array("label" => __("Sähköpostiosoite"), "class" => "form-control",
         'div' => 'form-group'));
   echo $this->Form->input("User.phone", array("label" => __("Puhelinnumero"), "class" => "form-control",
         'div' => 'form-group'));
   echo $this->Form->input("User.pwd", array("type" => "password", "label" => __("Salasana"), "class" => "form-control",
         'div' => 'form-group'));
   echo $this->Form->input("User.pwd2", array("type" => "password", "label" => __("Salasana uudestaan"), "class" => "form-control",
         'div' => 'form-group'));
   
   echo '<div class="form-group">';
   
   echo $this->Form->label( __("Rooli") );

   echo "<br />";
   
   echo $this->Form->input('User.role', array(
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
      'options' => array("1" => __("Pelaaja"), "2" => __("Joukkueenjohtaja/Muu käyttäjä") ),
      "default" => "x"
   ));
?>
   </div>
   <div class="player-extra-data">
<?php
   
   echo $this->Form->input("Player.birthday", 
      array( 
         "label" => "Syntymäpäivä",
         "type" => "text",
         "class" => "form-control datepicker",
         "data-date-format" => "dd.mm.yyyy",
         'div' => 'form-group'
      )
   );

   echo $this->Form->input("Player.address", 
      array( 
         "label" => "Osoite",
         "class" => "form-control",
         'div' => 'form-group'
      )
   );

   echo $this->Form->input("Player.postalcode", 
      array( 
         "label" => "Postinumero",
         "class" => "form-control",
         'div' => 'form-group'
      )
   );
   
   echo $this->Form->input("Player.postarea", 
      array( 
         "label" => "Postitoimipaikka",
         "class" => "form-control",
         'div' => 'form-group'
      )
   );

   echo $this->Form->input("Player.club_id", 
      array( 
         "label" => "Seura",
         "class" => "form-control",
         'options' => $clubs,
         "empty" => "Valitse seura",
         'div' => 'form-group'
      )
   );
?>
   </div>
<?php
   
   $this->Form->unlockField('TournamentClass.role');
   
   echo $this->Form->submit(__("Rekisteröidy"), array("class" => "btn btn-primary", "div" => "form-group") );

   echo $this->Form->end();

?>