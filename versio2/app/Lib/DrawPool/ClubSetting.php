<?php
/**
 * Description of ClubSetting
 *
 * @author Miikka
 */
class ClubSetting extends DrawPoolSettingBase{
   public function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace) {
      /*
       * Tarkistetaan pooleista saman seuran pelaajia, mikäli poolissa on saman seuran henkilöitä,
       * tarkistetaan toinen pooli, jos on sellanen pooli missä ei ole saman seuran pelaajia niin
       * palauta 0, jos kaikissa on saman seuran pelaajia niin palauta numero välillä ]0...1[
       * riippuen kuinka monta pelaajaa tässä poolissa on samasta seurasta, verrattuna sellaseen pooliin
       * missä on vähiten tämän seuran edustajia. Mikäli tässä on vähiten tai ei yhtään tämän seuran edustajia, niin palauta 1.
       * 
       */
      foreach($currentpool AS $playerID)
      {
         
      }
      return 0;
   }
}

?>
