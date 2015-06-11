<?php

/**
 * Description of RaitingSetting
 *
 * @author Miikka
 */
class RaitingSetting extends DrawPoolSettingBase{
   
   public function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace) {
      /*
       * Tarkistetaan jokaisen poolin keskiarvo raiting ja otetaan se pooli käsittelyyn,
       * jossa on suurin ero pelaajan ja raitingien välillä,
       * Mikäli pool on currentpool, niin palautetaan 1, jos ei,
       * niin palautetaan arvo ]0...1[ riippuen pelaajan raitingin suurudesta,
       * suhteutettuna currentpoolin keskiarvoon
       * HUOM pelaaja sopii pooliin mitä suurempi ero hänen raitingillä on
       * verrattuna raitingin keskiarvoon
       * (Näin erotellaan suurimpien raitingien omaavat henkilöt omiin pooleihin)
       * Jos pelaajan raiting on alle keskiarvon, niin haetaan edelleen se missä on suurin raiting ja muuten sama.
       * 
       */
      return 0;
   }
}

?>
