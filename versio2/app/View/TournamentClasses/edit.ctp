<h2><?php echo __("Muokkaa turnausluokkaa"); ?></h2>

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
$minage = 0;
$maxage = 100;

if( isset($this->request->data['TournamentClass']['minage'] ) )
{
   $minage = $this->request->data['TournamentClass']['minage'];
}

if( isset($this->request->data['TournamentClass']['maxage']))
{
   $maxage = $this->request->data['TournamentClass']['maxage'];
}

echo $this->Form->label( __("Ikärajat") );

echo "<br />";

echo $this->Form->input('TournamentClass.ageSlider', 
   array(
      'label' => false,
      "class" => "dualslider",
      "data-slider-min" => "0",
      "data-slider-max" => "100",
      "data-slider-step" => "1",
      "data-slider-value" => "[" .$minage. "," .$maxage. "]",
      "div" => false
   )
);

?>
</div>



<div class="input slider-input">
<?php

$minrating = 0;
$maxrating = 5000;

if( isset($this->request->data['TournamentClass']['minrating']) )
{
   $minrating = $this->request->data['TournamentClass']['minrating'];
}

if( isset($this->request->data['TournamentClass']['maxrating']) )
{
   $maxrating = $this->request->data['TournamentClass']['maxrating'];
}

echo $this->Form->label( __("Ratingrajat") );

echo "<br />";

echo $this->Form->input('TournamentClass.ratingSlider', array(
   'label' => false,
   "class" => "dualslider",
   "data-slider-min" => "0",
   "data-slider-max" => "5000",
   "data-slider-step" => "50",
   "data-slider-value" => "[" .$minrating. "," .$maxrating. "]",
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

echo $this->Form->submit( __("Tallenna"), array("class" => "btn btn-primary") );

echo $this->Form->end();
?>
