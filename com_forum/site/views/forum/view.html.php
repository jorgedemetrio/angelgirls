<?php
/*------------------------------------------------------------------------
# view.html.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.alldreams.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Temas View
 */
class AngelgirlsViewforum extends JViewLegacy
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
			

		$layout = JRequest::getVar('layout');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$pathway = $app->getPathway();
		$pathway->addItem('Sess&otilde;es', JRoute::_('index.php?option=com_forum&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais'));

		//$document->setMetadata('content-language', 'pt-br');
		$document->setMetadata('APPLICATION-NAME','Angel Girls');
		if($layout=='sessao'){
			$sessao = JRequest::getVar('sessao');
			$descricao = $sessao->meta_descrica . ' Data: ' . JFactory::getDate($sessao->publicar)->format('d/m/Y');
			$pathway->addItem($sessao->titulo,'');
			$document->setTitle($sessao->titulo );
			$document->setDescription($sessao->meta_descricao);
			$document->setMetadata('Keywords', 'young, baby, novinha, safafinha, fotos, gostosas, gatas, bonitas, gostosas, musas, divas, musa, diva,foto'.$sessao->titulo.','.str_replace(' ', ',',$sessao->titulo)
					.$sessao->meta_descricao.','.str_replace(' ', ',',$sessao->meta_descricao));
		}
		elseif($layout=='foto'){
			$sessao = JRequest::getVar('foto');
			$descricao = $sessao->titulo;
			$pathway->addItem('Foto: ' . $sessao->titulo,'');
			$document->setTitle($sessao->titulo );
			$document->setDescription($sessao->titulo);
			$document->setMetadata('Keywords', 'young, baby, novinha, safafinha, fotos, gostosas, gatas, bonitas, gostosas, musas, divas, musa, diva,foto'.$sessao->titulo.','.str_replace(' ', ',',$sessao->titulo));
		}
		elseif($layout=='perfil'){
			$layout = JRequest::getVar('layout');
			$document = JFactory::getDocument();
			$pathway = JFactory::getApplication()->getPathway();
			
			
			$document->setMetadata('APPLICATION-NAME','Angel Girls');
			
			
			$objeto = JRequest::getVar('perfil');

			
			$descricao = ucwords(strtolower($objeto->tipo)) . ' ' . ucwords(strtolower($objeto->apelido));
			$pathway->addItem($descricao,'');
			$document->setTitle($descricao);
			$document->setDescription($objeto->meta_descricao);
			$document->setMetadata('Keywords',  ucwords(strtolower($objeto->tipo)) . ' '. $objeto->apelido.','.ucwords(strtolower($objeto->tipo)) . ',' . 
						$objeto->apelido.','.str_replace(' ', ',',$objeto->apelido).','.str_replace(' ', ',',$objeto->nome_completo));
		}
		else{
			$document->setTitle(JText::_('Sessões / SETs de fotos sensuais com as modelos mais gatas, bonitas e gostosas - Musas AngelGirls'));
			$document->setDescription('Encontre as sessões / SETs de fotos sensuais com as modelos mais gatas, bonitas e gostosas');
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
		$document->setTitle(JText::_('Angelgirls Manager - Administrator'));
	}
}
?>