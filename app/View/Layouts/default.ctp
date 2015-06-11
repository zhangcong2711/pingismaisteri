<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>

<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('styles');
      
      echo $this->Html->script("jquery");
      echo $this->Html->script("bootstrap");
      echo $this->Html->script("plugins");
      echo $this->Html->script("ui");

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container body">
      <div class="row">
         <div class="col-md-12">
            <h1>PINGISMAISTERI</h1>
         
            <div class="navbar navbar-default">
            <?php 
            
               echo $this->element("mainmenu");
            
            ?>
            </div>
         </div>
      </div>
      <div class="content">
         <div class="row">
            <div class="col-md-12">
            
               <?php echo $this->Session->flash(); ?>

               <?php echo $this->fetch('content'); ?>
               
            </div>
         </div>
		<div class="footer">
         <div class="row">
            <div class="col-md-12">
               <?php echo $this->element('sql_dump'); ?>
            </div>
         </div>
	</div>
</body>
</html>
