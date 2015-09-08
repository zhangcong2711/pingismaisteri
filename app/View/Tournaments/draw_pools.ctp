<?php 
require APP . 'Config' . DS . 'app_const.php';
?>


<h1>Poolien arvonta</h1>


   <div class="row">
      <div class="col-md-3">
	  <br>
		<?php
		
		
        echo $this->Form->create('PoolForm');
		
		echo "<b>".__('num_registered_player')."  " . $regs . "</b>";
		?>
		<br/>
		
		<?php 
		
		$options = array();
		//$options['-1']='Select a stage';
		
		foreach ($all_stages as &$st) {
			$options[$st['Stage']['id']]=$st['Stage']['name'].'_'.$st['Stage']['type'];
		}
		
		echo $this->Form->input(__('stage_select'), array(
			'id' => 'stage_select',
		    'type'    => 'select',
		    'options' => $options,
		    'empty'   => true,
			'class' => 'form-control',
			'onchange' => 'on_stage_select(this);'
		));
		
		?>
		
		  <div id="draw_setting" class="col-md-12">
		    <br>
		
			 
		  </div>
	  </div>
	  
	</div>
	<br>
	
	
<script type="text/javascript">

	

	//store the input html in vals for adding dynamically
	var pool_setting_html=here_is_doc(function(){/*
		<?php 
		
		$setting_opts=array('1'=>'Option 1', '2'=>'Option 2');
		echo $this->Form->input(__('pool_opt_select'), array(
			'id' => 'pool_opt_select',
		    'type'    => 'select',
		    'options' => $setting_opts,
		    'empty'   => true,
			'class' => 'form-control',
			'onchange' => 'on_pool_opt_select(this);'
		));
		?>
	 */});
	var pool_option1_html=here_is_doc(function(){/*
		<?php 
		echo $this->Form->input('pool_num', array(
				'label' => __('pool_num'),
				"class" => "form-control"
		));
		
		echo $this->Form->input('minimize_same_club', array(
				'label' => __('minimize_same_club'),
				'type' => 'checkbox'));
		echo $this->Form->input('minimize_same_player', array(
				'label' => __('minimize_same_player'),
				'type' => 'checkbox'));
		?>
	 */});
	var pool_option2_html=here_is_doc(function(){/*
		<?php 
		
		echo $this->Form->input('fp_size', array(
	             'label' => __('fp_size'),
	             "class" => "form-control"
	         ));
		echo $this->Form->input('np_size', array(
				'label' => __('np_size'),
				"class" => "form-control"
		));
		?>
	 */});

	
	var cup_setting_html='';
	

	var all_stages=JSON.parse('<?php echo json_encode($all_stages); ?>');

	var j_draw_setting=$('#draw_setting');
	
	function on_stage_select(obj){

		var index=obj.selectedIndex-1;
		
		j_draw_setting.empty();
		
		if(index>=0){
			var t_stage=all_stages[index];
			var t_type=t_stage['Stage']['type'];
			if(t_type=='<?php echo constant("STAGE_TYPE_POOL"); ?>'){
				//alert('pool');
				j_draw_setting.append(pool_setting_html);
			}
			if(t_type=='<?php echo constant("STAGE_TYPE_CUP"); ?>'){
				j_draw_setting.append(cup_setting_html);
			}
		}else{

			
		}
		
	}

	function on_pool_opt_select(obj){

		$(obj.parentElement).nextAll().remove();

		if(obj.value=='1'){
			j_draw_setting.append(pool_option1_html);
		}
		if(obj.value=='2'){
			j_draw_setting.append(pool_option2_html);
		}
		
		
	}
</script>
<?php

   echo $this->Form->submit( "Suorita arvonta",
   array("class" => "btn btn-primary") );
   
   echo $this->Form->end();

?>