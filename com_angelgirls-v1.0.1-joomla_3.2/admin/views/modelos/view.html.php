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
class AngelgirlsViewmodelos extends JViewLegacy
{
	/**
	 * Modelos view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Include helper submenu
		AngelgirlsHelper::addSubmenu('modelos');

		// Set the toolbar
		$this->addToolBar();
		// Show sidebar
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$layout = JRequest::getVar('layout');
		
		JToolBarHelper::title(JText::_('Gerenciador de Modelos'), 'angelgirls');
		
		
		
		
		if($layout==null || $layout=='default'){
			JToolBarHelper::deleteList('', 'deleteModelo');
			JToolBarHelper::editList('editModelo');
			JToolBarHelper::addNew('addModelo');
		}
		elseif($layout!=null && $layout=='cadastro'){
			JToolBarHelper::apply('applayModelo');
			JToolBarHelper::save('saveModelo');
			JToolBarHelper::cancel('listModelo');
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