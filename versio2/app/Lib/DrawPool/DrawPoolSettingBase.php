<?php
App::import('DrawPool/IDrawPoolSetting', 'Lib');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DrawPoolSettingBase
 *
 * @author Miikka
 */
abstract class DrawPoolSettingBase implements IDrawPoolSetting{
   
   public abstract function evaluatePlacement(&$allpools, &$currentpool, $playerToPlace,&$otherPools = NULL);
   
}

?>
