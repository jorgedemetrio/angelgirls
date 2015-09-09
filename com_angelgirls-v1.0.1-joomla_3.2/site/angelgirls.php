<?php
/*------------------------------------------------------------------------
# angelgirls.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.angelgirls.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Added for Joomla 3.0
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
};

// Set the component css/js
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_angelgirls/assets/css/angelgirls.css');
$document->addStyleSheet('components/com_angelgirls/assets/css/bootstrap-theme.min.css');
$document->addStyleSheet('components/com_angelgirls/assets/css/bootstrap.min.css');


$document->addScript('components/com_angelgirls/assets/js/jquery.mask.min.js');
$document->addScript('components/com_angelgirls/assets/js/bootstrap.min.js');
$document->addScript('components/com_angelgirls/assets/js/npm.js');


// Require helper file
JLoader::register('AngelgirlsHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'angelgirls.php');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Angelgirls
$controller = JControllerLegacy::getInstance('Angelgirls');

// Perform the request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>