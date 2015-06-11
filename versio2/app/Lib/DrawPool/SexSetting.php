<?php
/**
 * Description of SexSetting
 *
 * @author Miikka
 */
class SexSetting extends DrawPoolSettingBase{
   
   private $onlyOne;
   
   public function SexSetting($oneOnly = false)
   {
      $onlyOne = $oneOnly;
   }
   
   public function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace)
   {
      /*
       * 
       *  Arvioidaan pelaajan sukupuolta asetettujen pelaajien sukupuoli määriin
       *  Mikäli asetus oneOnly on asetettu true:ksi, Hyväksytään vain yhtä sukupuolta
       *  jokaista poolia kohden. ( ei välttämättä tarvi toteuttaa )
       * 
       *  Lasketaan kuinka players_sex/opposite_sex määrät, ja haetaan se pool, missä on
       *  pienin suhde, mikäli se pooli on current pool, palautetaan 1, mikäli ei, niin
       *  palautetaan arvo väliltä ]0...1[ riippuen current suhteen ja parhaimman
       *  suhteen ja pelaajien määrien suuruuksista
       * 
       *  Palautetaan -1 mikäli tulee virhe, esim pelaajalla ei ole asetettu tietoja tjsp.
       * (Huom. Mikäli joltain pelaajalta puuttuu sukupuoli jostain muusta poolista, voisi algoritmi ohittaa kyseisen pelaajan laskuista)
       * 
       */
      return 0;
   }
}

?>
