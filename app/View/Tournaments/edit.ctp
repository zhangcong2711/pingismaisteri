   <h1><?php echo __("tournament_edit");?></h1>
   
   <?php echo $this->Form->create('Tournament'); ?>

   <div class="row">
      <div class="col-md-3">
      
         <h3><?php echo __("tournament_info");?></h3>

         <?php
         
         echo $this->Form->input("id", array(
            'type' => 'hidden'
         ));

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
      
      <div class="col-md-9">
   
         <h3><?php echo __("tournament_class");?></h3>

         <table class="table" id="tournamentClasses">
            <thead>
               <tr>
                  <th><?php echo __('name')?></th>
                 <th><?php echo __('date')?></th>
                 <th><?php echo __('price')?></th>
                 <th><?php echo __('stage_type')?></th>
                 <th><?php echo __('pool_num')?></th>
                 <th><?php echo __('remove')?></th>
               </tr>
            </thead>
            <tbody>

            <?php 
            
            $stage_type_opts = array();
            $stage_type_opts[constant('STAGE_TYPE_POOLS_CUP')]='POOLS -> CUP';
            $stage_type_opts[constant('STAGE_TYPE_POOLS_POOLS')]='POOLS -> POOLS';
            $stage_type_opts[constant('STAGE_TYPE_POOLS')]='POOLS';
            $stage_type_opts[constant('STAGE_TYPE_CUP')]='CUP';
            
            foreach( $this->request->data['ClassInTournament'] as $i => $class )
            {
            
               $date = DateTime::createFromFormat("Y-m-d", $class['date']);
               $price = str_replace(".", ",", $class['price']);
               $pool_num = $class['pool_num'];
               $stage_type = $class['stage_type'];
               
               /*
               $stage_name_arr=array();
               foreach($class['Stage'] as &$t_stage){
               		array_push($stage_name_arr, $t_stage['name']);
               }*/
               
            
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
				     <?php echo $this->Form->input("TournamentClass.".$i.".stage_type", array(
							'id' => 'stage_type_select',
				      		'label' => false,
				     		'disabled' => true,
						    'type'    => 'select',
						    'options' => $stage_type_opts,
						    'empty'   => false,
				     		'value'	=> $stage_type,
							'class' => 'form-control'
						)) ?>
				  </td>
                  <td>
                     <?php echo $this->Form->input("TournamentClass.".$i.".pool_num", array("type" => "text", "class" => "form-control", "label" => false, "value" => $pool_num)); ?>
                  </td>
                  <td>
                     <?php 
                     echo $this->Html->link(__("remove"), "#", 
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
                  <td colspan="4">
                     <?php 
                     echo $this->Html->link(
                        __("tournament_add_category"), 
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
   
   echo $this->Form->submit( __("update_t"), array("class" => "btn btn-primary") );

   echo $this->Form->end();
?>