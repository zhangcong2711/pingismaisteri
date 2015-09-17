<?php
class TournamentClassesController extends AppController {
    
    public $helpers = array('Html', 'Form');
    public $uses = array('TournamentClass', 'Registration');

    public function view()
    {
         
      if( isset($this->request->params['named']['order'] ) ) {
         $order = str_replace(",", " ", $this->request->params['named']['order']);
      }
      else
      {
         $order = "id asc";
      }
      
      $this->set("order", $order);
    
      $this->set("tournamentclasses", 
         $this->TournamentClass->find("all",
            array(
               'conditions' => array(
                  'TournamentClass.hidden !=' => 1
               ),
               'order' => $order
            )
         )
      );
    }
    
    public function edit($id)
    {

        $tournamentclasses = $this->TournamentClass->findById($id);
        
        if (!$this->request->data)
        {
            $this->request->data = $tournamentclasses;
        }

        if ($this->request->is('post') || $this->request->is('put'))
        {
            $this->TournamentClass->id = $id;
            
            $data = array();
            
            $data['name'] = $this->request->data['TournamentClass']['name'];
            $data['description'] = $this->request->data['TournamentClass']['description'];
            
            switch( $this->request->data['TournamentClass']['sex'] )
            {
               case "M":
               case "F":
                  $data['sex'] = $this->request->data['TournamentClass']['sex'];
                  break;
               case "X":
               default:
                  $data['sex'] = NULL;
            }
            
            $ages = explode(",", $this->request->data['TournamentClass']['ageSlider']);
            
            if( count( $ages )  > 1)
            {
               if( $ages[0] != 0 )
               {
                  $data['minage'] = $ages[0];
               }
               else
               {
                  $data['minage'] = "";
               }
               
               if( $ages[1] != 100 )
               {
                  $data['maxage'] = $ages[1];
               }
               else
               {
                  $data['maxage'] = "";
               }
            }
            
            $ratings = explode(",", $this->request->data['TournamentClass']['ratingSlider']);
            
            if( count( $ratings ) > 1 )
            {
            
               if( $ratings[0] != 0 )
               {
                  $data['minrating'] = $ratings[0];
               }
               else
               {
                  $data['minrating'] = "";
               }
               
               if( $ratings[1] != 5000 )
               {
                  $data['maxrating'] = $ratings[1];
               }
               else
               {
                  $data['maxrating'] = "";
               }
               
            }
            
            $this->request->data['TournamentClass'] = $data;
            
            if ($this->TournamentClass->save($this->request->data))
            {
               $this->Session->setFlash( __('updated_cainfo'));
               $this->redirect( "/tournamentClasses/view" );
            }
            else
            {
               $this->Session->setFlash( __('ca_error'));
            }
            
            
        }
    }

    public function add() {
        
        if ($this->request->is('post'))
        {
            $this->TournamentClass->create();
            
            $data = array();
            
            $data['name'] = $this->request->data['TournamentClass']['name'];
            $data['description'] = $this->request->data['TournamentClass']['description'];
            
            switch( $this->request->data['TournamentClass']['sex'] )
            {
               case "M":
               case "F":
                  $data['sex'] = $this->request->data['TournamentClass']['sex'];
                  break;
               case "X":
               default:
                  $data['sex'] = NULL;
            }
            
            $ages = explode(",", $this->request->data['TournamentClass']['ageSlider']);
            
            if( count( $ages ) > 1 )
            {
               if( $ages[0] != 0 )
               {
                  $data['minage'] = $ages[0];
               }
               
               if( $ages[1] != 100 )
               {
                  $data['maxage'] = $ages[1];
               }
            }
            
            $ratings = explode(",", $this->request->data['TournamentClass']['ratingSlider']);
            
            if( count( $ratings ) > 1 )
            {
               
               if( $ratings[0] != 0 )
               {
                  $data['minrating'] = $ratings[0];
               }
               
               if( $ratings[1] != 5000 )
               {
                  $data['maxrating'] = $ratings[1];
               }
            }
            
            $this->request->data['TournamentClass'] = $data;
            
            
            if( $this->TournamentClass->save( $this->request->data ) )
            {
                $this->Session->setFlash(__('ncacreated'));
            }
            else
            {
                $this->Session->setFlash(__('ncafail'));
            }
            
            $this->redirect( "/tournament_classes/view" );
            
        }
    }
    
    public function delete($id) {
      
      $class = $this->TournamentClass->find("first",
         array(
            'conditions' => array(
               'TournamentClass.id' =>$id
            ),
            'contain' => array(
               'ClassInTournament'
            )
         )
      );

      if( isset( $class['TournamentClass']['id'] ) )
      {
      
         if( count($class['ClassInTournament']) > 0 )
         {
            $this->TournamentClass->id = $id;
            $this->TournamentClass->set("hidden", 1);
            $this->TournamentClass->save();
         }
         else
         {
           $this->TournamentClass->delete( $id );
         }
      }
      
      $this->redirect( $this->referer() );

    }

}