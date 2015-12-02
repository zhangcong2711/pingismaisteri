<h1><?php echo 'Add New Result'?></h1>
   
   <?php echo $this->Form->create('Set'); ?>

   <div class="row">
      
      <div class="col-md-4">
      
         <?php


         echo $this->Form->input('a_point', array(
             'label' => $the_game['A_Player']['firstname'].' '.$the_game['A_Player']['lastname'].'Score',
             "class" => "form-control"
         ));
         echo $this->Form->input('b_point', array(
             'label' => 'PlayerB Score',
             "class" => "form-control"
         ));
         echo $this->Form->input('seq_no', array(
             'label' => 'Set Number',
             "class" => "form-control"
         ));
         echo $this->Form->input('win_status', array(
             'label' => 'Win Status',
             "class" => "form-control"
         )).'<br/><br/><br/>';
         
//          echo $this->Form->input('game_id', array(
//          		'label' => 'Game ID',
//          		"class" => "form-control"
//          ));
         
         echo $this->Form->input('game_id', array (
         		'type' => 'hidden','value'=>$gameId)
         );

         echo $this->Form->submit( 'Add Result', array("class" => "btn btn-primary") );
         
         echo $this->Form->end();


         ?>

      </div>