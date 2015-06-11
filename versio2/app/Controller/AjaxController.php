<?php
App::uses('AppController', 'Controller');
/**
 * Ajax Controller
 *
 */
class AjaxController extends AppController {

   public $uses = array('User', 'TournamentClass', 'ClassInTournament');
   
   public function beforeFilter() {
      parent::beforeFilter();
    
      // Security
      if(isset($this->Security) ) {
         $this->Components->disable('Security');
      }

      // Not ajax
      if ( !$this->request->is('ajax') ) {

         $this->Security->blackHole($this, 'You are not authorized to process this request!');
      } 
   }
   
   // Authorization requires isAuthorized
   public function isAuthorized()
   {
         return true; 
   }
   
   
   public function newTournamentClassRow($i)
   {
      $this->set("classes", $this->TournamentClass->find("list") );
      $this->set("iterator", $i);
   }
   
   public function removeRowFromClass($class, $id)
   {
      $this->$class->delete($id);
   }
   
}

?>