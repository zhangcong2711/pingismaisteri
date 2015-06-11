   <h1>Muokkaa turnausta</h1>
   
   <?php echo $this->Form->create('Tournament'); ?>

   <div class="row">
      <div class="col-md-4">
      
         <h3>Turnauksen tiedot</h3>

         <?php
         
         echo $this->Form->input("id", array(
            'type' => 'hidden'
         ));

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

            <?php foreach( $this->request->data['ClassInTournament'] as $i => $class )
            {
            
               $date = DateTime::createFromFormat("Y-m-d", $class['date']);
               $price = str_replace(".", ",", $class['price']);
			   $poolSize = $class['pool_size'];
			   $placedPlayers = $class['placed_players'];
            
               echo $this->Form->input("TournamentClass.".$i.".id", array("type" => "hidden", "value" => $class['id']));
            ?>
               <tr>
                  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".tournament_class_id", array("options" => $tournamentclasses, "class" => "form-control", "label" => false, "default" => $class['tournament_class_id']) ); ?>
                  </td>
                  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".date", array("type" => "text", "class" => "form-control", "label" => false, "value" => $date->format("d.m.Y") )); ?>
                  </td>
                  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".price", array("type" => "text", "class" => "form-control", "label" => false, "value" => $price)); ?>
                  </td>
				  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".pool_size", array("type" => "text", "class" => "form-control", "label" => false, "value" => $poolSize)); ?>
                  </td>
				  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".placed_players", array("type" => "text", "class" => "form-control", "label" => false, "value" => $placedPlayers)); ?>
                  </td>
                  <td>
                     <?php 
                     echo $this->Html->link("Poista", "#", 
                        array(
                           "class" => "delete-row btn btn-primary",
                           "data-class" => "ClassInTournament",
                           "data-id" => $class['id'],
                           "data-url" => $this->Html->url("/ajax/removeRowFromClass")
                        ) 
                     ); 
                     ?>
                  </td>
               </tr>
            
         <?php
            }
         ?>
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
   
   echo $this->Form->submit( "Päivitä turnauksen tiedot", array("class" => "btn btn-primary") );

   echo $this->Form->end();
?>