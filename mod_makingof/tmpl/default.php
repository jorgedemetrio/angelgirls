<?php
/**
 * @version     1.0
 * @package     mod_makingof
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @author      Jorge Demetrio
 */
//No Direct Access
defined('_JEXEC') or die;
?>
<div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <?php 
        foreach ($results as &$makingof) :
        	$urlRedirect = JRoot::_
        	
        ?>
        <div class="col-md-4">
        	<h2><a href=""><?php echo($makingof->title); ?></a></h2>
        	<p><a class="btn btn-default" href="#" role="button">View details �</a></p>
        </div>
        <?php endforeach; ?>
        
          
          
          
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details �</a></p>
          
          
          
        
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details �</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details �</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>� Company 2014</p>
      </footer>
</div>