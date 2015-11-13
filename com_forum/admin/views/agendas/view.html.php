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
 * Agendas View
 */
class AngelgirlsViewagendas extends JViewLegacy
{
	/**
	 * Agendas view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		
		// Include helper submenu
		AngelgirlsHelper::addSubmenu('agendas');

		// Set the toolbar
		$this->addToolBar();
		
		// Show sidebar
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
		
				
		// Check for tag type
		//$this->checkTags = JHelperTags::getTypes('objectList', array($this->state->get('category.extension') . '.category'), true);
		
		
		$agenda =& JRequest::getVar('agenda');
		
		$this->item = $agenda; 

	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$layout = JRequest::getVar('layout');
		
		JToolBarHelper::title(JText::_('Gerenciador de Agenda'), 'angelgirls');
		
		
		
		
		if($layout==null || $layout=='default'){
			JToolBarHelper::deleteList('', 'deleteAgenda');
			JToolBarHelper::editList('editAgenda');
			JToolBarHelper::addNew('addAgenda');
		}
		elseif($layout!=null && $layout=='cadastro'){
			JToolBarHelper::apply('applayAgenda');
			JToolBarHelper::save('saveAngenda');
			JToolBarHelper::cancel('listAgenda');
		}
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
		$document->setTitle(JText::_('Angelgirls Manager - Administrator'));
	}
}
?>