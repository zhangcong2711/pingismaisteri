<?php

class ClubsController extends AppController {

   public $helpers = array('Html', 'Form');
   
   public $uses = array( 'Club', 'User', 'Player' );

	public function view() {
      $this->set( "clubs", $this->Club->find("all",   
         array(
            'contain' => array(
               'Player' => array(
                  'order' => 'sex, lastname, firstname ASC'
               )
            )
         )
      ) );
	}
	
   public function add() {
   
      if ($this->request->is('post')) {
            $this->Club->create();
            if ($this->Club->save($this->request->data)) {
            
                $this->Session->setFlash(__('Seura on tallennettu.'));
                $this->redirect( "/clubs/view" );
                
            } else
			{
				$this->Session->setFlash(__('Seuran tallennus epäonnistui.'));
			}
         
      }
      
   }
   
   public function delete($club_id)
   {
      $club = $this->Club->find("first",
         array(
            'conditions' => array(
               'Club.id' => (int) $club_id
            )
         )
      );
      
      if( isset( $club['Club']['id'] ) )
      {
         if( $this->Club->delete( $club_id ) )
         {
            $this->Player->updateAll(
               array(
                  "Player.club_id" => null
               ),
               array(
                  "Player.club_id" => $club_id
               )
            );
         
            $this->Session->setFlash( __("Seura poistettu") );
         }
         else
         {
            $this->Session->setFlash( __("Seuran poisto epäonnistui") );
         }
         
         $this->redirect( "/clubs/view");
         
      }
      
   }
   
}
?>