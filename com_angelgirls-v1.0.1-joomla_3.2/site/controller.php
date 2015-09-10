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

	/**
	 * 
	 */
	public function cadastroVisitante(){
		$this->carregarCadastro();
		
		JRequest::setVar ( 'view', 'cadastro' );
		JRequest::setVar ( 'layout', 'visitante' );
		parent::display (true, false);
	}
	
	/**
	 * 
	 */
	public function cadastroFotografo(){
		$this->carregarCadastro();
		
		JRequest::setVar ( 'view', 'cadastro' );
		JRequest::setVar ( 'layout', 'fotografo' );
		parent::display (true, false);
	}
	
	/**
	 * 
	 */
	public function cadastroModelo(){
		$this->carregarCadastro();
		
		JRequest::setVar ( 'view', 'cadastro' );
		JRequest::setVar ( 'layout', 'modelo' );
		parent::display (true, false);
	}
	
	
	public function carregarCadastro(){
		
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		$query->select ( $db->quoteName ( array (
				'a.id',
				'a.nome',
				'a.uf'
		) ) )->from ( $db->quoteName ( '#__cidade', 'a' ) )->order ( 'a.nome, a.uf' );
		
		$db->setQuery ( $query );
		
		$result = $db->loadObjectList ();
		JRequest::setVar ( 'cidades', $result );
		
		$query = $db->getQuery ( true );
		$query->select ( $db->quoteName ( array (
				'a.uf'
		) ) )->from ( $db->quoteName ( '#__cidade', 'a' ) )->group ( $db->quoteName ( array (
				'a.uf'
		) ) )->order ( 'a.uf' );
		$db->setQuery ( $query );
		
		$result = $db->loadObjectList ();
		JRequest::setVar ( 'ufs', $result );
	}

	public function homepage(){
		$user = JFactory::getUser();
		if (! isset ( $user ) || ! JSession::checkToken ( 'post' )){
			$this->nologado();
		}
		else{
			$this->logado();
		}
	}
	
	public function logado(){
		
	}
	
	public function nologado(){
		//Nova modelo
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','meta_descricao','foto_perfil','nome_artistico'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' = \'ATIVA\' ' )
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'modelo', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'sessao', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->where ( $db->quoteName ( 'id' ) . ' <> ' . $result->id )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(4);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'sessoes', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select(" `id` ,`titulo` as nome,`meta_descricao` as descricao, `id_sessao` + '/' + `id` + 'm.jpg' as foto, `titulo` as alias ")
		->from ('#__angelgirls_foto_sessao')
		->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
		->order('data_criado DESC ')
		->setLimit(2);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'fotos', $result );
		
		
		
		
		$query = $db->getQuery ( true );
		$query->select("`id` ,`title` as nome,`introtext` as descricao,  id + ':' + alias as slug, catid, language,  MID(`images`,LOCATE(':',`images`)+2, LOCATE(',',`images`)-LOCATE(':',`images`)-2) as foto,alias")
		->from ('#__content')
		->where ( $db->quoteName ( 'publish_up' ) . '  <= NOW()  ' )
		->where ( $db->quoteName ( 'state' ) . ' = 1  ' )
		->order('created DESC ')
		->setLimit(3);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'conteudos', $result );
		
		$query = $db->getQuery ( true );
		$query->select("`id` ,`title` as nome,`introtext` as descricao,  id + ':' + alias  as slug, catid, language, MID(`images`,LOCATE(':',`images`)+2, LOCATE(',',`images`)-LOCATE(':',`images`)-2) as foto,alias")
		->from ('#__content')
		->where ( $db->quoteName ( 'publish_up' ) . '  <= NOW()  ' )
		->where ( $db->quoteName ( 'state' ) . ' = 1  ' )
		->where ( $db->quoteName ( 'catid' ) . ' = 8  ' )
		->order('created DESC ')
		->setLimit(4);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'makingofs', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_promocao')
				->where ( $db->quoteName ( 'status_dado' ) . ' = \'ATIVO\' ' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'promocao', $result );
		
		
		
		
		
		JRequest::setVar ( 'view', 'home' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display (true, false);
	}
}
?>