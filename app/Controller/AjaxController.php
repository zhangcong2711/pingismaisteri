<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Ajax Controller
 *
 */
class AjaxController extends AppController {

   public $uses = array('User', 'TournamentClass', 'ClassInTournament', 'Stage');
   
   public function beforeFilter() {
      parent::beforeFilter();
    
      
      // Security
      if(isset($this->Security) ) {
         $this->Components->disable('Security');
      }

      /*
      // Not ajax
      if ( !$this->request->is('ajax') ) {

         $this->Security->blackHole($this, 'You are not authorized to process this request!');
      } 
      */
      
//       $this->Auth->allow('newStageTypeRow', 'newTournamentClassRow');
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
   
   public function newStageTypeRow($i)
   {
   		$types=array(
   				constant("STAGE_TYPE_POOL")=>'POOL_STAGE',
   				constant("STAGE_TYPE_CUP")=>'CUP_STAGE'
   		);
   	
   		$this->set("types", $types);
   		$this->set("iterator", $i);
   }
   
}

?>