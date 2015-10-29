<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */

require APP . 'Config' . DS . 'app_const.php';



App::uses('Controller', 'Controller');

App::import('Core', 'l10n');
App::import('Util','Detect');
App::import('Util','AppUtil');

class AppController extends Controller {

   public $uses = array('User', 'Role', 'AccessObject');

   public $components = array(
      'Auth' => array(
         'authorize' => 'Controller',
         'authenticate' => array(
            'Form' => array(
               'fields' => array('username' => 'email')
         )
        )
      ), 
      //'Security',
   	  'Cookie',
      'Session',
      'RequestHandler'
   );
   
   
   /* Let's put those components to good use */
   function beforeFilter() { 
   	
      $this->Auth->allow('display', 'checkAccess');
      $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'myAccount');
      $this->Auth->logoutRedirect = '/';
      $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
      $this->Auth->loginError = __("Käyttäjätunnuksesi tai salasanasi oli väärä");
      $this->Auth->authError = __("Käyttöoikeusvirhe: Et saa mennä sinne");
      
      
      // Security
      if(isset($this->Security) ) {
      	$this->Components->disable('Security');
      }
      
      
   }
   
   
   
   // Used for role based access checks
   function isAuthorized()
   {

      $controller = $this->request->controller;
      $action = $this->request->action;
   
      return $this->checkAccess($controller, $action);
      
   }

   // Global Configurations
   
   function checkAccess($controller, $action)
   {
      // Default: No access
      $access = false;
   
      $role = (int)$this->Auth->user('role_id');
      
      if( !is_int( $role ) )
      {
         $role = 0;
      }
      
      $controller = strtolower( $controller );
      $action = strtolower( $action );
      
      // Check access to action
      $accessObject = $this->AccessObject->find("first",
         array(
            'conditions' => array(
               'action' => '*',
               'controller' => $controller,
               'role_id' => $role
            )
         )
      );
      
      if( count($accessObject) > 0)
      {
         if( $accessObject['AccessObject']['type'] == 'allow' )
         {
            $access = true;
         }
         else
         {
            $access = false;
         }
      }
      
      // Check access to action
      $accessObject = $this->AccessObject->find("first",
         array(
            'conditions' => array(
               'action' => $action,
               'controller' => $controller,
               'role_id' => $role,
            )
         )
      );

      if( count($accessObject) > 0)
      {
         if( $accessObject['AccessObject']['type'] == 'allow' )
         {
            $access = true;
         }
         else
         {
            $access = false;
         }
      }

      return $access;
   }
   

}

