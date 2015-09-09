<?php
/*------------------------------------------------------------------------
# controller.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.angelgirls.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Angelgirls Component Controller
 */
class AngelgirlsController extends JControllerLegacy{
	
	function display($cachable = false, $urlparams = false) {
		// set default view if not set
		JRequest::setVar ( 'view', JRequest::getCmd ( 'view', 'Angelgirls' ) );
	
		// call parent behavior
		parent::display ( $cachable );
	
		// set view
		$view = strtolower ( JRequest::getVar ( 'view' ) );
	
		// Set the submenu
		AngelgirlsHelper::addSubmenu ( $view );
	}
	

	public function homepage(){
		
		//Nova modelo
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','meta_descricao','foto_perfil'), 
									  array('id','nome','descricao','foto')))
		->from ('#__angelgirls_modelo')
		->where ( $db->quoteName ( 'status_modelo' ) . ' = \'ATIVA\' ' )
		->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
		->order('data_criado DESC ')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'modelo', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto'),
				array('id','nome','descricao','foto')))
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->order('data_criado DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'sessao', $result );
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','title','meta_descricao','nome_foto'),
				array('id','nome','descricao','foto')))
				->from ('#__content')
				->where ( $db->quoteName ( 'published' ) . ' = \'1\' ' )
				->order('created DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'sessao', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto'),
				array('id','nome','descricao','foto')))
				->from ('#__angelgirls_promocao')
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->order('created DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'promocao', $result );

		
		

		
		JRequest::setVar ( 'view', 'home' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display (true);
	}
}
?>