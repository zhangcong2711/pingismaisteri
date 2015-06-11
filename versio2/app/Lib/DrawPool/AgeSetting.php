<?php
App::import('DrawPool/DrawPoolSettingBase', 'Lib');
/**
 * Description of AgeSetting
 *
 * @author Miikka
 */
class AgeSetting extends DrawPoolSettingBase{
   
   private $priorityOfAge;
   
   public function AgeSetting($agePriority = 5)
   {
      $priorityOfAge = $agePriority;
   }
   
   public function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace) {
      
      /*
       *    Toteutustapa A:
       * 
       *    Otetaan keskiarvo currentpoolista, sitten otetaan keskiarvo
       *    muista pooleista, sitten verrataan keskiarvojen
       *    läheisyyttä asetettavan pelaajan ikään.
       * 
       *    Kommenteissa on selitetty tarkemmin miten tämä voidaan toteuttaa
       * 
       *    Mikäli tulee virhe, palautetaan -1. (esim ikää ei ole saatavilla)
       *    Mikäli muita pooleja ei vielä ole, palautetaan 1. (koska ainoa sopiva vaihtoehto)
       *    
       *    Mikäli on muita pooleja, niin arvoidaan keskiarvot siten, että
       *    Mitä lähempänä pelaajan ikä on currentpoolin keskiarvoa verrattuna muiden poolien keskiarvoon,
       *    sitä suurempi numero palautetaan. Ikä pitää kuitenkin suhteuttaa siten,
       *    että mikäli keskiarvon ja pelaajan iän välinen ero on suuruusluokaltaan
       *    muuttujan $PriorityOfAge:n kokoinen, arvon tulee pienetä selkeästi.
       *    Esim. Jos pelaajan ikä on 30, keksiarvo on 28 ja muiden keskiarvo on 29,
       *    tässä tapauksessa palautettava arvo saisi olla suuruudeltaan lähemmäs 0.9 mikäli käytetään oletusarvoa(5).
       *    Toisaalta, jos pelaajan ikä on 35, ja keskiarvo on 28, ja muiden keskiarvo on 32, ja agepriority on edelleen 5,
       *    tulisi arvio olla lähempänä 0.5
       *    AgePriorityä voidaan muuttaa, esimerkiksi jos pidetään turnaus
       *    missä ikä on suuri tekijä ja halutaan mahdollisimman
       *    pieni hajonta, niin tätä luokkaa tehdessä voidaan asettaa agepriority
       *    esim 1.
       *    Nyt hajonta jossa keskiarvo on 20, ja pelaajan ikä 22, ja muiden
       *    keskiarvo 21, niin pitäisi tulos olla jälleen lähempänä 0.5.
       * 
       * 
       *    Toteutustapa B:
       *    
       *    "Sijoitetaan" pelaaja jokaiseen luokkaan erikseen, ja lasketaan keskiarvo.
       *    Tämän jälkeen verrataan tämän hetken poolin keskiarvon MUUTOSTA, PIENIMMÄN
       *    muutoksen omaavaan pooliin, mikäli pooli on sama kuin current pool, tulos on 1,
       *    mikäli ei, niin se on välillä ]0...1[ riippuen muutoksen suurudesta.
       *    (jotenkin ehkä pelaaja määriin suhteutettuna)
       *    
       */
      
      return 0;
   }
}

?>
