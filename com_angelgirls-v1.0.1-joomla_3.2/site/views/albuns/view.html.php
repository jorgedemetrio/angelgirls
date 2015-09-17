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
class AngelgirlsViewalbuns extends JViewLegacy
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
		$layout = JRequest::getVar('layout');
		$document = JFactory::getDocument();
		$pathway = JFactory::getApplication()->getPathway();
		$pathway->addItem('Albuns', JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarAlbuns&id=albuns'));
		
		//$document->setMetadata('content-language', 'pt-br');
		$document->setMetadata('APPLICATION-NAME','Angel Girls');
		
		
		if($layout=='album'){
			$sessao = JRequest::getVar('album');
			$descricao = $sessao->meta_descrica . ' Data: ' . JFactory::getDate($sessao->publicar)->format('d/m/Y');
			$pathway->addItem($sessao->titulo,'');
			$document->setTitle($sessao->titulo);
			$document->setDescription($descricao);
			$document->setMetadata('Keywords', 'young, baby, novinha, safafinha, fotos, gostosas, gatas, bonitas, gostosas, musas, divas, musa, diva,foto'.$sessao->titulo.','.str_replace(' ', ',',$sessao->titulo)
					.$sessao->meta_descricao.','.str_replace(' ', ',',$sessao->meta_descricao));
		}
		if($layout=='foto'){
			$sessao = JRequest::getVar('foto');
			$descricao = $sessao->titulo;
			$pathway->addItem('Foto: ' . $sessao->titulo,'');
			$document->setTitle($sessao->titulo );
			$document->setDescription($sessao->titulo);
			$document->setMetadata('Keywords', 'young, baby, novinha, safafinha, fotos, gostosas, gatas, bonitas, gostosas, musas, divas, musa, diva,foto'.$sessao->titulo.','.str_replace(' ', ',',$sessao->titulo));
		}
		else{
			$document->setTitle(JText::_('Albuns de fotos - Musas AngelGirls'));
			$document->setDescription('Encontre os Albuns de fotos');
			$document->setMetadata('Keywords', 'young, baby, novinha, safafinha, fotos, gostosas, gatas, bonitas, gostosas, musas, divas, musa, diva');
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