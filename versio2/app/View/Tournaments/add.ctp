   <h1>Luo uusi turnaus</h1>
   
   <?php echo $this->Form->create('Tournament'); ?>

   <div class="row">
      
      <div class="col-md-4">
      
         <h3>Turnauksen tiedot</h3>

         <?php

         echo $this->Form->input('name', array(
             'label' => 'Turnauksen nimi',
             "class" => "form-control"
         ));

         echo $this->Form->input('organizer', array(
             'label' => 'Turnauksen järjestävä organisaatio',
             "class" => "form-control"
         ));
         echo $this->Form->input('contact', array(
             'label' => 'Yhteyshenkilö',
             "class" => "form-control"
         ));
         echo $this->Form->input('contactphone', array(
             'label' => 'Yhteyshenkilön puhelinnumero',
             "class" => "form-control"
         ));
         echo $this->Form->input('contactemail', array(
             'label' => 'Yhteyshenkilön sähköpostiosoite',
             "class" => "form-control"
         ));

         echo $this->Form->input('startdate', array(
            "type" => "text",
             'label' => 'Alkamispäivä',
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('enddate', array(
            "type" => "text",
             'label' => 'Päättymispäivä',
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('location', array(
             'label' => 'Sijainti',
             "class" => "form-control"
         ));

         echo $this->Form->input('registration_ends', array(
            "type" => "text",
             'label' => 'Viimeinen rekisteröitymispäivä',
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('cuttingdate', array(
            "type" => "text",
             'label' => 'Leikkauspäivä',
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('additionalinfo', array(
            'label' => 'Lisätietoa',
            'rows' => '4',
            "class" => "form-control"
         ));
         echo $this->Form->input('created', array (
            'type' => 'hidden',
         ));


         ?>

      </div>
      
      <div class="col-md-8">
   
         <h3>Turnauksen luokat</h3>

         <table class="table" id="tournamentClasses">
            <thead>
               <tr>
                  <th>Nimi</th>
                 <th>Päivämäärä</th>
                 <th>Hinta</th>
				 <th>Poolien koko</th>
				 <th>Sijoitettavien pelaajien lukumäärä</th>
                 <th>Poista</th>
               </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
               <tr class="newClassRow">
                  <td colspan="8">
                     <?php echo $this->Html->link(
                        "Lisää luokka", 
                        "/ajax/newTournamentClassRow", 
                        array(
                           "class" => "new-row-link btn btn-primary", 
                           "data-url" => $this->Html->url("/ajax/newTournamentClassRow"),
                           "data-target" => "#tournamentClasses tbody",
                           "data-count" => "#tournamentClasses tbody tr"
                        ) 
                     ); ?>
                  </td>
               </tr>
            </tfoot>

         </table>
      </div>
   </div>
   <br />
<?php
   
   echo $this->Form->submit( "Luo turnaus", array("class" => "btn btn-primary") );
   
  // echo $this->Security->unlockedFields = array('TournamentClass');

   echo $this->Form->end();
?>