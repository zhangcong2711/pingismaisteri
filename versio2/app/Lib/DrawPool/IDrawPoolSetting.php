<?php

/**
 *
 * @author Miikka
 */
interface IDrawPoolSetting {
   /*
    * Käytetään arvioimaan jonkin pelaaja sijoituksen sopivuutta
    * 
    * Palauttaa: -1 = virhe, 0 = ei sovi, välillä ]0...1[ = sopivuuden arvio,
    * mitä suurempi, sitä sopivampi ja 1 = sopii täysin 
    * 
    * &$otherpools = NULL, tarkoittaa vapaaehtoista parametria, johon voidaan sijoittaa
    * esimerkisi toisen turnauksen pooleja, mikäli ne voivat vaikuttaa tulokseen
    * (Tätä tarvitaan esimerkiksi samojen pelaajien aloituspoolien sekoittamisessa)
    */
   
   public function evaluatePlacement(&$allpools,&$currentpool,$playerToPlace, &$otherPools = NULL);
}

?>
