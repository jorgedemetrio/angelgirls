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
class AngelgirlsViewtemas extends JViewLegacy
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
			
		$tema =& JRequest::getVar('tema');
		$app = JFactory::getApplication();
		$document =& JFactory::getDocument();
		$pathway = $app->getPathway();
		$pathway->addItem('Temas de fotografia', JRoute::_('index.php?option=com_angelgirls&task=listTema'));

		//$document->setMetadata('content-language', 'pt-br');
		$document->setMetadata('APPLICATION-NAME','Angel Girls');
		if($tema !=null){
			//JToolBarHelper::title(JText::_('Temas ').$tema->nome, 'angelgirls');
			$pathway->addItem($tema->nome, '');
			$document->setTitle($document->getTitle()." - ".JText::_('Tema ') . $tema->nome);
			$document->setDescription($tema->meta_descricao);
			$document->setMetadata('Keywords','sessao de foto, sessao, foto, photo, photoset, photo set, photo shot,temas fotografia,'. $tema->nome.','.str_replace(' ',',',$tema->nome) );
			
// 			$document->setMetadata('al:ios:url','example://applinks');
// 			$document->setMetadata('al:ios:app_store_id','12345');
// 			$document->setMetadata('al:ios:app_name','Example App');
// 			$document->setMetadata('og:title','example page title');
// 			$document->setMetadata('og:type','website');
			
			$document->setMetadata('author', $tema->criador);
			$document->setMetadata('reply-to','contato@angelgirls.com.br');
			//$document->setMetadata('robots', 'index,follow');
		}
		else{
			//JToolBarHelper::title(JText::_('Temas de fotografia'), 'angelgirls');
			//$document->setMetadata('robots', 'noindex,follow');
			$document->setTitle($document->getTitle()." - ".JText::_('Temas de fotografia'));
			$document->setDescription('Temas de fotografias sensuais usadas em nosso SETs, como: boudoir, MIMP, pinup');
			$document->setMetadata('Keywords', 
					'sessao de foto, sessao, foto, photo, photoset, photo set, photo shot,temas fotografia, boudoir, mimp, pinup');
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
		//$document->setTitle(JText::_('Angelgirls Manager - Administrator'));
	}
}
?>