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
JHtml::_('jquery.framework'); // load jquery
JHtml::_('jquery.ui');

/**
 * Temas View
 */
class AngelgirlsViewinbox extends JViewLegacy
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
		

		// Display the template
		parent::display($tpl);


	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
			
		
		$caixa = JRequest::getVar('caixa');
		$document = JFactory::getDocument();
		$pathway = JFactory::getApplication()->getPathway();
		$pathway->addItem('Inbox', JRoute::_('index.php?option=com_angelgirls&view=inbox&task=inboxMensagens'));

		//$document->setMetadata('content-language', 'pt-br');
		$document->setMetadata('APPLICATION-NAME','Angel Girls');
		


		$document->setTitle('Inbox - Mensagens');
		$document->setDescription('Inbox sua caixa de comuncaчуo.');
		//$document->setMetadata('mensagens, mensagem, inbox');			

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