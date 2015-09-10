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
 * Modelos View
 */
class AngelgirlsViewcadastro extends JViewLegacy
{
	/**
	 * Modelos view display method
	 * @return void
	 */
	function display($tpl = null) 
	{

		// Set the toolbar
		$this->addToolBar();
		
		// Show sidebar
		$this->sidebar = JHtmlSidebar::render();

		// Set the document
		$this->setDocument();
		
		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() {
		
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$pathway = $app->getPathway();

		$document->setMetadata('APPLICATION-NAME','Angel Girls');

		$pathway->addItem("Cadastro de " . JRequest::getVar('layout'), '');
		$document->setTitle("Angel Girls - Cadastro de " . JRequest::getVar('layout') . 's' );
		$document->setDescription("Cadastro de " . JRequest::getVar('layout') . " para ter acessos exclusivo no site da Angel Girls." . 
				" Angel Girls as modelos mais lindas do Brasil.");
		$document->setMetadata('Keywords','register, cadastro, registrar, sessao de foto, sessao, photoset, photo set, photo shot,fotografia,'. JRequest::getVar('layout') );
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
		//$document->setTitle(JText::_('Angelgirls Manager - Administrator'));
	}
}
?>