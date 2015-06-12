<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

   // Common stuff
   public $uses = array('User', 'Player', 'Club', 'Registration');
   
   function beforeFilter() {
      parent::beforeFilter();
      $this->Auth->allow('register', 'validateEmail', 'forgotPassword');
   }


   /* Pages */
   public function index()
   {
   
   }
   
   public function myAccount()
   {
      $user = $this->User->find("first",
         array(
            'conditions' => array(
               'User.id' => $this->Auth->user('id')
            ),
            'contain' => array(
               'Player' => array(
                  'Registration' => array(
                     'ClassInTournament' => array(
                        'Tournament',
                        'TournamentClass'
                     )
                  ),
                  'Club'
               )
            )
         )
      );
      
      $this->set( "user", $user );
   }
   
   
   /* Other Functions */
   
   public function validateEmail($email, $validation)
   {
      // Find right user
      $user = $this->User->find("first", array(
            'conditions' => array(
               'User.email' => $email
            )
         )
      );
      
      $result = 0;
      
      if( isset( $user['User'] ) )
      {
         // Check validation code
         $this->User->id = $user['User']['id'];
      
         if( $user['User']['validation'] == $validation )
         {
            if($user['User']['validated'] == null)
            {
               $this->User->set('validated', date("Y-m-d H:i:s"));
               $result = 1;
            }
            else
            {
               $result = 2;
            }
         }
         // Make user validated
         $this->User->save();
      }
      
      // Set data for view
      $this->set("validationResult", $result);
      
   }
   
   public function forgotPassword()
   {
      
   }

	public function register() {
	
		// Check if User is logged in
      if($this->Auth->User('id')){
         $this->redirect(array('action' => 'myAccount'));
      }
      else // No logged in user
      {
	  
         // Check for request type (Form is sent)
         if ( $this->request->is('post') || $this->request->is("put") ) 
         {
         
            // Create new user
            $this->User->create();
            
            // Get Form data and add timestamp and formatted birthday
            $data['User'] = $this->request->data['User'];
				$data['User']['created'] = date('Y-m-d H:i:s');
          
            // Generate validation code
            $data['User']['validation'] = md5( $data['User']['email'].$data['User']['created']);
            
            // Save and check if successful
            if ($this->User->save($data)) 
            {
               $id = $this->User->getInsertID();
               
               $this->request->data['User'] = array_merge(
                  $data['User'],
                  array(
                     "password" => $data['User']['pwd'],
                     "id" => $id
                  )
               ); 
               
               // Set Flash
               $this->Session->setFlash( __('Rekisteröityminen onnistui'));
               
               if( $this->Auth->login() )
               {
               
                  // Redirect to My Account
                  $this->redirect(array('action' => 'myAccount'));
               }
            }
            else
            {
               // User Creation failed
               $this->Session->setFlash( __('Rekisteröityminen epäonnistui'));
            }

         }
      }
	}
   
   function login() 
   {
      // Data needs to come from a post-request 
      if ($this->request->is('post')) {
      
         // Let's use CakePHP login method
         if( $this->Auth->login() ) {
            
            // Login ok
           $this->redirect("/Tournaments/view");
            
         } else {
            
            // Login failed
            $this->Session->setFlash(__('Login failed!...') );
         }
      }
      
   }
   
   public function logout() {
      // CakePHP logout
      $this->redirect($this->Auth->logout());
	  	
   }
   
   	

   public function addPlayer() 
   {
      if ($this->request->is('post')) {
    
         //luodaan lomake
         $this->Player->create();
      
         $dataArray = array ( 
            "User" => array( 
               "id" => $this->Auth->user('id')
            ), 
            "Player" => $this->request->data['Player']
         );
      
         $birthday = DateTime::createFromFormat( 'd.m.Y', $this->request->data['Player']['birthday'] );
      
         $dataArray['Player']['birthday'] = $birthday->format("Y-m-d");
      
         $dataArray['Player']['created'] = date('Y-m-d H:i:s');
      
         if($this->Player->save($dataArray))
         {
            $this->Session->setFlash(__('Pelaaja lisätty'));
         
            $this->redirect("/users/myAccount");
         }
         else
         {
            $this->Session->setFlash(__('Pelaajaa ei voitu lisätä'));
         }              
      }
      
      $this->set("clubs", $this->Club->find('list') );
   }
   
   public function editPlayer($id)
   {
      if ( $this->request->is('post') || $this->request->is("put") ) {
    
         //luodaan lomake
         $this->Player->id = $id;
      
         $dataArray = array ( 
            "User" => array( 
               "id" => $this->Auth->user('id')
            ), 
            "Player" => $this->request->data['Player']
         );
      
         $birthday = DateTime::createFromFormat( 'd.m.Y', $this->request->data['Player']['birthday'] );
      
         $dataArray['Player']['birthday'] = $birthday->format("Y-m-d");
      
         if($this->Player->save($dataArray))
         {
            $this->Session->setFlash(__('Pelaajan tiedot tallennettu'));
         }
         else
         {
            $this->Session->setFlash(__('Tietojen tallennuksessa tapahtui virhe'));
         }              
      }
      else
      {
         $player = $this->Player->find("first",
            array(
               'conditions' => array(
                  'Player.id' => $id
               )
            )
         );
         
         $birthday = DateTime::createFromFormat("Y-m-d", $player['Player']['birthday']);
         $player['Player']['birthday'] = $birthday->format("d.m.Y");
         
         $this->request->data = $player;
      }
      
      $this->set("clubs", $this->Club->find('list') );
   }
   
   function changePassword()
   {
      // Check for Form data
      if($this->request->is('post') )
      {
      
         // ID must be current user id
         $id = $this->Auth->user('id');
         
         // Format password
         $old = $this->Auth->password($this->request->data['User']['oldPassword']);
         
         $user = $this->User->find("first", array(
               'conditions' => array(
                  'User.id' => $this->Auth->user('id'),
                  'User.password' => $old
               ),
               'contain' => array()
            )
         );
         
         // If Userdata was valid
         if( count($user) > 0)
         {
            // Get user data to Model
            $this->User->id = $id;
            
            // Save request data
            if( $this->User->save($this->request->data) )
            {
               // Success
               $this->Session->setFlash( __("Salasana vaihdettu onnistuneesti") );
               
               $this->redirect( array("controller" => "profiles", "action" => "settings" ) );
            }
            else
            {
               // Failed for some reason
               $this->Session->setFlash( __("Salasanan vaihto epäonnistui") );
               
               $this->redirect( array("controller" => "profiles", "action" => "settings" ) );
            }
            
         }
         else
         {
            // Password was wrong
            $this->Session->setFlash( __("Salasanan vaihto epäonnistui: Vanha salasana ei täsmää") );
            
            $this->redirect( array("controller" => "profiles", "action" => "settings" ) );
         }  
      }
   }

   public function cancelRegistration($id)
   {
      $this->Registration->delete($id);
      
      $this->redirect( $this->referer() );
   }
   
}