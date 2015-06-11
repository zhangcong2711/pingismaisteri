<?php

/**
 * Description of StartPoolMixingSetting
 *
 * @author Miikka
 */
class StartPoolMixingSetting extends DrawPoolSettingBase{
   
   public function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace, &$otherPools)
   {
      /*
       * Tarkistetaan mikäli pelaaja on vastaikkain jossain muissa pooleissa jo kysessä poolissa olevien henkilöiden kanssa,
       * Mikäli on, niin käydään muut kyseisen turnauksen poolit, läpi ja tarkistetaan, onko pelaaja heidän kanssa samassa poolissa jossain toisessa turnauksessa
       * Mikäli ei ole, niin palautetaan arvo 0 jos on olemassa pooli, jossa pelaajalla ei ole samoja vastustajia,
       * Mikäli muissakin pooleissa on samoja vastustajia, niin palautetaan 1. 
       * 
       */
     
      return 0;
      
   }
}

?>
