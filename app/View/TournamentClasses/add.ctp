<h2><?php echo __("Luo uusi turnausluokka"); ?></h2>

<div class="row">
   <div class="col-md-6">

<?php
echo $this->Form->create('TournamentClass');

echo $this->Form->input('TournamentClass.name', array(
    'label' => 'Nimi',
    "class" => "form-control"
));

echo $this->Form->input('TournamentClass.description', array(
    'label' => __('Lisätiedot'),
    "class" => "form-control"
));

echo "<h3>".__("Rajoitteet")."</h3>";

?>

<div class="input slider-input">

<?php
echo $this->Form->label( __("Ikärajat") );

echo "<br />";

echo $this->Form->input('TournamentClass.ageSlider', 
   array(
      'label' => false,
      "class" => "dualslider",
      "data-slider-min" => "0",
      "data-slider-max" => "100",
      "data-slider-step" => "1",
      "data-slider-value" => "[0,100]",
      "div" => false
   )
);

?>
</div>



<div class="input slider-input">
<?php

echo $this->Form->label( __("Ratingrajat") );

echo "<br />";

echo $this->Form->input('TournamentClass.ratingSlider', array(
   'label' => false,
   "class" => "dualslider",
   "data-slider-min" => "0",
   "data-slider-max" => "5000",
   "data-slider-step" => "50",
   "data-slider-value" => "[0,5000]",
   "div" => false
));
?>
</div>

<div class="input selection">
<?php
echo $this->Form->label( __("Sukupuoli") );

echo "<br />";

echo $this->Form->input('TournamentClass.sex', array(
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
    'options' => array("M" => __("Mies"), "F" => __("Nainen"), "x" => __("Ei rajoitusta") ),
    "default" => "x"
));
?>
</div>
<br />
<?php

$this->Form->unlockField('TournamentClass.sex');
$this->Form->unlockField('TournamentClass.ageSlider');
$this->Form->unlockField('TournamentClass.ratingSlider');

echo $this->Form->submit( __("Luo luokka"), array("class" => "btn btn-primary") );

echo $this->Form->end();
?>
   </div>
   <div class="col-md-6">
      
   </div>
</div>
