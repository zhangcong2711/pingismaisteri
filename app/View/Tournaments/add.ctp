   <h1>Luo uusi turnaus</h1>
   
   <?php echo $this->Form->create('Tournament'); ?>

   <div class="row">
      
      <div class="col-md-4">
      
         <h3>Turnauksen tiedot</h3>

         <?php

         echo $this->Form->input('name', array(
             'label' => __('t_name'),
             "class" => "form-control"
         ));

         echo $this->Form->input('organizer', array(
             'label' => __('t_organizer'),
             "class" => "form-control"
         ));
         echo $this->Form->input('contact', array(
             'label' => __('contact'),
             "class" => "form-control"
         ));
         echo $this->Form->input('contactphone', array(
             'label' => __('contactphone'),
             "class" => "form-control"
         ));
         echo $this->Form->input('contactemail', array(
             'label' => __('contactemail'),
             "class" => "form-control"
         ));

         echo $this->Form->input('startdate', array(
            "type" => "text",
             'label' => __('startdate'),
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('enddate', array(
            "type" => "text",
             'label' => __('enddate'),
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('location', array(
             'label' => __('location'),
             "class" => "form-control"
         ));

         echo $this->Form->input('registration_ends', array(
            "type" => "text",
             'label' => __('registration_ends'),
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('cuttingdate', array(
            "type" => "text",
             'label' => __('cuttingdate'),
             "class" => "form-control datepicker",
             "data-date-format" => "dd.mm.yyyy"
         ));

         echo $this->Form->input('additionalinfo', array(
            'label' => __('additionalinfo'),
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
                  <th><?php echo __('name')?></th>
                 <th><?php echo __('date')?></th>
                 <th><?php echo __('price')?></th>
                 <th><?php echo __('remove')?></th>
               </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
               <tr class="newClassRow">
                  <td colspan="4">
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
   
   echo $this->Form->submit( __("creat_t"), array("class" => "btn btn-primary") );
   
  // echo $this->Security->unlockedFields = array('TournamentClass');

   echo $this->Form->end();
?>