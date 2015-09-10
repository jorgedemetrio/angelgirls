<?php
/*------------------------------------------------------------------------
# view.html.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.angelgirls.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Temas View
 */
class AngelgirlsViewbusca extends JViewLegacy
{
	/**
	 * Temas view display method
	 * @return void
	 */
	function display($tpl = null) 
	{


		// Set the document
		$this->setDocument();
		
		// Set the toolbar
		$this->addToolBar();

		$this->item = $tema;
		

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
			
		$termo =& JRequest::getVar('q');
		
		$app = JFactory::getApplication();
		$document =& JFactory::getDocument();
		$pathway = $app->getPathway();
		$pathway->addItem('Busca por '.$termo, JRoute::_('index.php?option=com_angelgirls&view=busca&q='.$termo));

		$document->setMetadata('APPLICATION-NAME','Angel Girls');
		$document->setTitle($document->getTitle()." - Busca em Angel Girls por ".$termo);
		$document->setDescription('Busca em Angel Girls por '.$termo);
		$document->setMetadata('Keywords','angelgirls,busca,'.$termo);

	}

	/**
	 * Method to set up the document properties
	 *
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
	}
}
?>