<?php
   $allData = $this->Session->read('tournamentClassesWithPools');
   $classIDs = array_keys($allData);
   $classInfos = $this->Session->read('classInfos');
   $playerData = $this->Session->read('playerData');
   
   $playerRatings = $this->Session->read('playerRatings');
   
   $numberofclasses = count($classIDs);
   
   $first = true;
   $poolsizes = array();
   
   foreach(array_keys($allData) as $mykey)
   {
      $poolsizes[$mykey] = count($allData[$mykey]);
   }
   $poolsizes = json_encode($poolsizes);
   
   echo $this->Html->script('redips-drag-min');
   echo $this->Html->script('redips-drag-source');
   
   echo $this->Html->script('jquery');
   echo $this->Html->script('jquery-ui');
   echo $this->Html->css('ui-lightness/jquery-ui-1.10.4.custom');
   echo $this->Html->css('pool_style', null, array('inline' => false));
   ?>
<script>
/*
 *   RedipsScript needs to be here for PHP injection
 */
   
/* enable strict mode */
"use strict";

// define redipsInit variable
var redipsInit;

// redips initialization
redipsInit = function () {
	var rd = REDIPS.drag;	// reference to the REDIPS.drag class
    
	// DIV container initialization
	var numberofclasses = <?php echo $numberofclasses ?>;
    
    for(var i = 0; i < numberofclasses; i++)
    {
       rd.init('drag'+i.toString());
    }
    rd.dropMode = "switch";
};

function mysave() {
  var table_contents = new Array();
  var numofclasses = <?php echo $numberofclasses ?>;
  var classids  = <?php $output = '['; foreach($classIDs as $classID) { $output .= $classID.','; } echo substr($output,0,-1).']'; ?>;
  for(var i = 0; i < numofclasses; i++)
  {
    table_contents[i] = REDIPS.drag.saveContent('dragtable'+i.toString(),'json');
  }
  
  if(!table_contents)
  {
    alert('Tables cannot be saved!');
    return false;
  }
  else
  {
     var field = null;
     
     for(var i = 0; i < classids.length; i++)
     {
        field = document.getElementById('allTableData'+classids[i].toString());
        field.value = table_contents[i];
     }
     return true;
  }
}


// add onload event listener
if (window.addEventListener) {   
	window.addEventListener('load', redipsInit, false);
}
else if (window.attachEvent) {
	window.attachEvent('onload', redipsInit);
}

</script>
<script>

  /*
   * jQuery Script
   */
   
  $(function() {
    var tabs = $( "#tabs" ).tabs();
    $(".pooloutput").hide();
  });
 </script>
  
<?php
   echo '<div id="tabs">';
   echo createClassHeads($classIDs,$classInfos);
   
   $len = count($classIDs);
   $output = '';
   
   for($i = 0; $i < $len; $i++)
   {
      $output .= '<div id="tabs-'.$i.'">';
         $output .= createClassTable($allData[$classIDs[$i]], $classInfos[$classIDs[$i]],$i,$playerData,$playerRatings,$clubs);
      $output .= '</div>';
   }
   echo $output;
   echo '</div>';
   echo $this->Form->create('tournament', array('action' => 'parsePools','type'=>'post','onSubmit'=>'return mysave()'));
   echo $this->Form->input('classes',array('type' => 'hidden','id'=>'classes','value' => $len));
   echo $this->Form->input('poolsizesjson',array('type' => 'hidden','id'=>'poolsizesjson','value' => $poolsizes));
   foreach($classIDs as $classid)
   {
      echo $this->Form->input('tableData'.$classid,array('type' => 'text','id'=>'allTableData'.$classid,'label'=>false,'class' => 'pooloutput'));
   }
   echo $this->Form->button('Tallenna');
   echo $this->Form->end();
 ?>

