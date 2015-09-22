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
jimport('joomla.application.component.helper');
include_once JPATH_BASE .DS.'components/com_content/models/article.php';
require_once JPATH_BASE .DS.'components/com_content/helpers/route.php';
require_once JPATH_BASE .DS.'components/com_content/helpers/query.php';
jimport( 'joomla.application.module.helper' );



class StatusDado {
	const PUBLICADO = 'PUBLICADO';
	const ATIVO = 'ATIVO';
	const REMOVIDO = 'REMOVIDO';
	const REPROVADO = 'REPROVADO';
	const NOVO = 'NOVO';
}


class NivelAcesso {
	const ACESSO_PUBLICO = 1;
	const ACESSO_GUEST = 5;
	const ACESSO_REGISTRED = 2;
	const ACESSO_FOTOGRAFO = 7;
	const ACESSO_MODELO = 8;
}

class GrupoAcesso {
	const PUBLICO = 1;
	const GUEST = 9;
	const REGISTRED = 2;
	const FOTOGRAFO = 10;
	const FOTOGRAFO_MODELO = 12;
	const MODELO = 11;
}

if(!defined('PATH_IMAGEM_VISITANTES')){
	define('PATH_IMAGEM_VISITANTES', JPATH_SITE . DS . 'images' . DS . 'visitantes' . DS);
};

if(!defined('PATH_IMAGEM_MODELOS')){
	define('PATH_IMAGEM_MODELOS', JPATH_SITE . DS . 'images' . DS . 'modelos' . DS);
};

if(!defined('PATH_IMAGEM_FOTOGRAFOS')){
	define('PATH_IMAGEM_FOTOGRAFOS', JPATH_SITE . DS . 'images' . DS . 'fotografos' . DS);
};

if(!defined('PATH_IMAGEM_TEMAS')){
	define('PATH_IMAGEM_TEMAS', JPATH_SITE . DS . 'images' . DS . 'temas' . DS);
};

if(!defined('PATH_IMAGEM_LOCACOES')){
	define('PATH_IMAGEM_LOCACOES', JPATH_SITE . DS . 'images' . DS . 'locacoes' . DS);
};

if(!defined('PATH_IMAGEM_SESSOES')){
	define('PATH_IMAGEM_SESSOES', JPATH_SITE . DS . 'images' . DS . 'sessoes' . DS);
};


if(!defined('PATH_IMAGEM_ALBUNS')){
	define('PATH_IMAGEM_ALBUNS', JPATH_SITE . DS . 'images' . DS . 'albuns' . DS);
};

if(!defined('PATH_IMAGEM_FIGURINOS')){
	define('PATH_IMAGEM_FIGURINOS', JPATH_SITE . DS . 'images' . DS . 'figurinos' . DS);
};

/**
 * Angelgirls Component Controller
 */
class AngelgirlsController extends JControllerLegacy{
	
	const LIMIT_DEFAULT = 24;
	const CATEGORIA_MAKINGOF = 10;
	

	
	
	function display($cachable = false, $urlparams = false) {
		// set default view if not set
		JRequest::setVar ( 'view', JRequest::getCmd ( 'view', 'Angelgirls' ) );
	
		// call parent behavior
		parent::display ( $cachable );
	
		// set view
		$view = strtolower ( JRequest::getVar ( 'view' ) );
	
		// Set the submenu
		//AngelgirlsHelper::addSubmenu ( $view );
	}
	
	
	/**
	 * Sitemap content
	 */
	function sitemapContent(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select("`id` , id + ':' + alias as slug, catid, language, modified  ")
		->from ('#__content')
		->where ('(' . $db->quoteName ( 'publish_up' ) . '  <= NOW()  OR '
				. $db->quoteName ( 'publish_up' ) . ' IS NULL OR '
				. $db->quoteName ( 'publish_up' ) . " = '0000-00-00 00:00:00' )" )
				->where ( $db->quoteName ( 'state' ) . ' = 1  ' )
				->order('created DESC')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_(ContentHelperRoute::getArticleRoute($result->slug, $result->catid, $result->language));
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.3</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
	/**
	 * Sitemap dos menus
	 */
	function sitemapMenus(){
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}

	/**
	 * Sitemap das JTags
	 */
	function sitemapTags(){
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
	/**
	 * Sitemap do perfil da modelos.
	 */
	function sitemapModelos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$result->id.':modelo-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.5</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=cadastroModelo&id=:cadastre-se-modelo-fotografica-sensual-angel-girls',false);
		$xml = $xml . "\t<url>\n";
		$xml = $xml . "\t\t<changefreq>never</changefreq>\n";
		$xml = $xml . "\t\t<priority>0.2</priority>\n";
		$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
		$xml = $xml . "\t</url>\n";
		$xml = $xml . '</urlset>';
		
		
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
 
	
	public function sitemapFotografos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_fotografo')
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		/*'<?xml version="1.0" encoding="UTF-8"?>\n';*/
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$result->id.':fotografo-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.2</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=cadastroFotografo&id=:cadastre-se-fotografo-sensual-angel-girls',false);
		$xml = $xml . "\t<url>\n";
		$xml = $xml . "\t\t<changefreq>never</changefreq>\n";
		$xml = $xml . "\t\t<priority>0.2</priority>\n";
		$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
		$xml = $xml . "\t</url>\n";
		$xml = $xml . '</urlset>';
		
		
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	

	
	function sitemapSessao(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$result->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.9</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	

	
	function sitemapFotos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_foto_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'id_sessao' ) . ' IN (select id FROM #__angelgirls_sessao WHERE status_dado IN (' . $db->quote(StatusDado::PUBLICADO) . ' ) AND  publicar<= NOW()) ') 
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$result->id.':foto-sensual-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.9</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
	/**
	 * Sitemap de albuns
	 */
	function sitemapAlbuns(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_album')
				->where ( $db->quoteName ( 'status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarAlbum&id='.$result->id.':album-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.9</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
	
	/**
	 * Sitemap de fotos
	 */
	function sitemapAlbumFotos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_foto_album')
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'id_album' ) . ' IN (select id FROM #__angelgirls_album WHERE status_dado IN (' . $db->quote(StatusDado::PUBLICADO) . ' ) AND  publicar<= NOW()) ')
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarFotoAlbum&id='.$result->id.':foto-album-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-d\TH:i:sP')  . "</lastmod>\n";
			$xml = $xml . "\t\t<changefreq>monthly</changefreq>\n";
			$xml = $xml . "\t\t<priority>0.9</priority>\n";
			$xml = $xml . "\t\t<loc>http://" .  $url . "</loc>\n";
			$xml = $xml . "\t</url>\n";
		}
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
	}
	
	
	function sitemapCategorias(){
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$xml = $xml . '</urlset>';
		header('Content-type: application/xml');
		echo($xml);
		exit();
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
	
	public function validarUsuarioExisteJson(){
		$db = JFactory::getDbo ();
		$usuario = strtolower(trim(JRequest::getString('usuario', '','POST')));
		$json = '{"existe":"'. ($this->existeUsuario($usuario)?'SIM':'NAO') .'"}';
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	

	
	public function RegistroNaoEncontado(){
		header("HTTP/1.0 404 Not Found"); 
		header("Status: 404 Not Found");
		JRequest::setVar ( 'view', 'erro' );
		JRequest::setVar ( 'layout', '404' );
		parent::display (true, false);
	}
	
	public function carregarFotografo(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_fotografo' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
		
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`data_nascimento`,
						`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`, `f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,
						`cnasceu`.`uf` as `estado_nasceu`, `cnasceu`.`nome` as `cidade_nasceu`,
						`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`,
						CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
		->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
		->join ( 'LEFT', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
		->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_f ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_f.id_fotografo'))
		->join ( 'LEFT', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
		->join ( 'LEFT', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'))
		->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
		->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		
		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
		JRequest::setVar ( 'usuario', $result );
		
		
		//Tema preferido
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome` AS `nome`, count(1) as total')
		->from ( $db->quoteName ( '#__angelgirls_tema', 'f' ) )
		->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_tema = f.id ')
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
		->where ( 's.id_tema IS NOT NULL')
		->order('total DESC,`f`.`nome`')
		->group(' `f`.`id`, `f`.`nome`')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'tema', $result );
		
		//Locacao preferido
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome` AS `nome`, count(1) as total')
		->from ( $db->quoteName ( '#__angelgirls_locacao', 'f' ) )
		->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_locacao = f.id ')
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where ( 's.id_locacao IS NOT NULL')
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('total DESC,`f`.`nome`')
		->group(' `f`.`id`, `f`.`nome`')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'locacao', $result );
		
		//Quantos trabalhos
		$query = $db->getQuery ( true );
		$query->select(' count(1) as total')
		->from($db->quoteName ('#__angelgirls_sessao', 's' ))
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'total', $result );
		
		
		//Modelo preferida
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`, count(1) as total')
						->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
						->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_modelo_principal = f.id OR s.id_modelo_secundaria = f.id')
						->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
						->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
						->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
						->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
						->order('total DESC,`f`.`nome_artistico`')
						->group(' `f`.`id`, `f`.`nome_artistico`')
						->setLimit(3);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'preferidos', $result );
		
		
		
		//Carregar 5 Sessoes que trabalhou mais gostadas
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
		->order('`s`.`publicar` DESC ')
		->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'ultimas', $results );
		
		//Carregar 3 Sessoes que trabalhou mais recentes
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
		->order('s.audiencia_gostou DESC,s.audiencia_view DESC, `s`.`publicar` DESC ');
		$query->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'gostaram', $results );
		
		
		//Carregar 3 Sessoes que trabalhou mais recentes
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $id . ')')
		->order('s.audiencia_view DESC, s.audiencia_gostou DESC, `s`.`publicar` DESC ');
		$query->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'vistas', $results );
		
		
		

		
		JRequest::setVar ( 'view', 'fotografo' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display (true, false);
	}
	
	public function carregarModelo(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_modelo' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
		
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`data_nascimento`,
						`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`, `f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,
					   `f`.`altura`,  `f`.`peso`, 
					   `f`.`busto`,  `f`.`calsa`,  `f`.`calsado`, `f`.`olhos`,  `f`.`pele`,  `f`.`etinia`,  `f`.`cabelo`,  `f`.`tamanho_cabelo`, `f`.`cor_cabelo`,  `f`.`outra_cor_cabelo`,
								`cnasceu`.`uf` as `estado_nasceu`, `cnasceu`.`nome` as `cidade_nasceu`,
								`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`,
								CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
								->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
								->join ( 'LEFT', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
								->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_f ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_f.id_modelo'))
								->join ( 'LEFT', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
								->join ( 'LEFT', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'))
								->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
								->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		
		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
		
		
		JRequest::setVar ( 'usuario', $result );
		
		
		
		//Tema preferido
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome` AS `nome`, count(1) as total')
		->from ( $db->quoteName ( '#__angelgirls_tema', 'f' ) )
		->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_tema = f.id ')
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where ( 's.id_tema IS NOT NULL')
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('total DESC,`f`.`nome`')
		->group(' `f`.`id`, `f`.`nome`')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'tema', $result );
		
		//Locacao preferido
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome` AS `nome`, count(1) as total')
		->from ( $db->quoteName ( '#__angelgirls_locacao', 'f' ) )
		->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_locacao = f.id ')
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where ( 's.id_locacao IS NOT NULL')
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('total DESC,`f`.`nome`')
		->group(' `f`.`id`, `f`.`nome`')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'locacao', $result );
		
		//Quantos trabalhos
		$query = $db->getQuery ( true );
		$query->select(' count(1) as total')
		->from($db->quoteName ('#__angelgirls_sessao', 's' ))
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'total', $result );
		
		
		//Modelo preferida
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`, count(1) as total')
		->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
		->join ('INNER',$db->quoteName ('#__angelgirls_sessao', 's' ) . ' ON s.id_fotografo_principal = f.id OR s.id_fotografo_secundario = f.id')
		->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('total DESC,`f`.`nome_artistico`')
		->group(' `f`.`id`, `f`.`nome_artistico`')
		->setLimit(3);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'preferidos', $result );
		
		
		
		//Carregar 5 Sessoes que trabalhou mais gostadas
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('`s`.`publicar` DESC ');
		$query->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'ultimas', $results );
		
		//Carregar 3 Sessoes que trabalhou mais recentes
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('s.audiencia_gostou DESC,s.audiencia_view DESC, `s`.`publicar` DESC ');
		$query->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'gostaram', $results );
		
		
		//Carregar 3 Sessoes que trabalhou mais recentes
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
		->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $id . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $id . ')')
		->order('s.audiencia_view DESC, s.audiencia_gostou DESC, `s`.`publicar` DESC ');
		$query->setLimit(6);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'vistas', $results );
		
		
		
		
		
		JRequest::setVar ( 'view', 'modelo' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display (true, false);
	}
	
	public function gostarJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$view = JRequest::getString('view','');
		$jsonRetorno='';
		if(isset($id) && $id!=0){
			if(isset($user) && isset($user->id) && $user->id!=0){
				$campoId=null;
				$tabelaVotoId=null;
				$tabelaRegistroId=null;
				
				if($view=='fotosessao'){
					$campoId='id_foto';
					$tabelaVotoId='#__angelgirls_vt_foto_sessao';
					$tabelaRegistroId='#__angelgirls_foto_sessao';
				}
				elseif($view=='sessao'){
					$campoId='id_sessao';
					$tabelaVotoId='#__angelgirls_vt_sessao';
					$tabelaRegistroId='#__angelgirls_sessao';
				}
				elseif($view=='fotografo'){
					$campoId='id_fotografo';
					$tabelaVotoId='#__angelgirls_vt_fotografo';
					$tabelaRegistroId='#__angelgirls_fotografo';
				}
				elseif($view=='modelo'){
					$campoId='id_modelo';
					$tabelaVotoId='#__angelgirls_vt_modelo';
					$tabelaRegistroId='#__angelgirls_modelo';
				}
				elseif($view=='fotoalbum'){
					$campoId='id_foto';
					$tabelaVotoId='#__angelgirls_vt_foto_album';
					$tabelaRegistroId='#__angelgirls_foto_album';
				}
				elseif($view=='album'){
					$campoId='id_galeria';
					$tabelaVotoId='#__angelgirls_vt_album';
					$tabelaRegistroId='#__angelgirls_album';
				}
				if(isset($campoId) && isset($tabelaVotoId) &&	isset($tabelaRegistroId)){
					$query = $db->getQuery ( true );
					$query->select('`f`.`data_criado` as `data`')
					->from ( $db->quoteName ( $tabelaVotoId, 'f' ) )
					->where (' f.'.$campoId.' = ' . $id )
					->where (' f.id_usuario = ' . $user->id );
					$db->setQuery ( $query );
					$modelo = $db->loadObject();
						
					$gostar = !(isset($modelo) && isset($modelo->data));
					if($gostar){
						$query = $db->getQuery ( true );
						$query->insert( $db->quoteName ( $tabelaVotoId ) )
						->columns (array (
							$db->quoteName ( $campoId ),
							$db->quoteName ( 'id_usuario' ),
							$db->quoteName ( 'data_criado' )))
							->values(implode(',', array ($id, $user->id, 'NOW()')));
						$db->setQuery( $query );
						$db->execute();
					}
					else{
						$query = $db->getQuery ( true );
						$query->delete( $db->quoteName ($tabelaVotoId ) )
						->where ($campoId.' = ' . $id )
						->where (' id_usuario = ' . $user->id );
						$db->setQuery( $query );
						$db->execute();
					}
					$query = $db->getQuery ( true );
					$query->update($db->quoteName($tabelaRegistroId));
					if($gostar){
						$query->set(array($db->quoteName ( 'audiencia_gostou' ) . '  =  ('.$db->quoteName ( 'audiencia_gostou' ).' + 1)'));
						$jsonRetorno='{"status":"ok","mesage":"Adicionado","codigo":"200"}';
					}
					else{
						$query->set(array($db->quoteName ( 'audiencia_gostou' ) . '  =  ('.$db->quoteName ( 'audiencia_gostou' ).' - 1)'));
						$jsonRetorno='{"status":"ok","mesage":"Removido","codigo":"200"}';
					}
					
					$query->where ($db->quoteName ( 'id' ) . ' = ' . $id);
					$db->setQuery ( $query );
					$db->execute ();
				}
				else{
					$jsonRetorno='{"status":"nok","mesage":"Area n&aatilde;o reconhecida.","codigo":"403"}';
				}
			}
			else{
				$jsonRetorno='{"status":"nok","mesage":"N&aatilde;o logado","codigo":"401"}';
			}
		}
		else{
			$jsonRetorno='{"status":"nok","mesage":"Area n&aatilde;o reconhecida.","codigo":"403"}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function existeUsuario($usuarioP){ 
		$db = JFactory::getDbo ();
		$usuario =$db->quote( strtolower(trim($usuarioP)));
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`')
		->from ( $db->quoteName ( '#__users', 'f' ) )
		->where (' trim(lower('. $db->quoteName ( 'f.username' ) . ')) = ' . $usuario);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		
		return (isset($result) && isset($result->id) && $result->id!=0);
	}
	
	
	public function validarCPFJson(){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$cpf =  $db->quote(trim(strtolower(str_replace("-","",str_replace(".","",JRequest::getString('cpf', '','POST'))))));
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`')
		->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) );
		if(isset($user) && $user->id != 0){
			$query->where ( $db->quoteName ( 'f.id_usuario' ) . ' <> ' .  $user->id);
		}
		$query->where (' trim(REPLACE(REPLACE('. $db->quoteName ( 'f.cpf' ) . ",'.',''),'-','')) = " . $cpf );
		$db->setQuery ( $query );
		$modelo = $db->loadObject();
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`')
		->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) );
		if(isset($user) && $user->id != 0){
			$query->where ( $db->quoteName ( 'f.id_usuario' ) . ' <> ' .  $user->id);
		}
		$query->where (' trim(REPLACE(REPLACE('. $db->quoteName ( 'f.cpf' ) . ",'.',''),'-','')) = " . $cpf);
		$db->setQuery ( $query );
		$fotografo = $db->loadObject();
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`')
		->from ( $db->quoteName ( '#__angelgirls_visitante', 'f' ) );
		if(isset($user) && $user->id != 0){
			$query->where ( $db->quoteName ( 'f.id_usuario' ) . ' <> ' .  $user->id);
		}
		$query->where (' trim(REPLACE(REPLACE('. $db->quoteName ( 'f.cpf' ) . ",'.',''),'-','')) = " . $cpf);
		$db->setQuery ( $query );
		$visitante = $db->loadObject();
		
		$json = '{"modelo":"'.(isset($modelo) && isset($modelo->id)?'SIM':'NAO').'","fotografo":"'.(isset($fotografo) && isset($fotografo->id)?'SIM':'NAO').'","visitante":"'.(isset($visitante) && isset($visitante->id)?'SIM':'NAO').'"}';		
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
	
		exit();
	}
	
	function validaCPF($cpf = null) {
	
		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}
	
		// Elimina possivel mascara
		$cpf = preg_replace('[^0-9]', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		 
		// Verifica se o numero de digitos informados &eacute; igual a 11
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' ||
				$cpf == '11111111111' ||
				$cpf == '22222222222' ||
				$cpf == '33333333333' ||
				$cpf == '44444444444' ||
				$cpf == '55555555555' ||
				$cpf == '66666666666' ||
				$cpf == '77777777777' ||
				$cpf == '88888888888' ||
				$cpf == '99999999999') {
			return false;
			// Calcula os digitos verificadores para verificar se o
			// CPF é válido
		} else {
			 
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}
	
	
	/**
	 * TODO
	 */
	public function TemMensagenNaoLidaJson(){
		
	}
	
	/**
	 * TODO
	 */
	public function inbox(){
		
		JRequest::setVar( 'view', 'inbox');
		JRequest::setVar( 'layout', 'default');
		parent::display();
	}
	
	/**
	 * TODO
	 */
	public function carregarMensagem(){
	
		JRequest::setVar( 'view', 'inbox');
		JRequest::setVar( 'layout', 'mensagem');
		parent::display();
	}
	
	/**
	 * TODO
	 */
	public function enviarMensagem(){
	
		JRequest::setVar( 'view', 'inbox');
		JRequest::setVar( 'layout', 'enviado');
		parent::display();
	}

	
	public function carregarFoto(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
	
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`,`f`.`titulo`,`f`.`descricao`,`f`.`meta_descricao`,`f`.`id_sessao`,`f`.`audiencia_gostou`,
						`s`.`id` AS `id_sessao`,`s`.`titulo` AS `titulo_sessao`,`s`.`nome_foto`,
						`s`.`executada`,`s`.`descricao` AS `descricao_sessao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
						`s`.`comentario_equipe`,`s`.`meta_descricao` AS `meta_descricao_sessao`,`s`.`id_agenda`,
						`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
						`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
						`s`.`audiencia_gostou` AS audiencia_gostou_sessao,`s`.`audiencia_ngostou`,`f`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
						`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
						`tema`.`nome` AS `nome_tema`,`tema`.`descricao` AS `descricao_tema`,`tema`.`nome_foto` AS `foto_tema`,`tema`.`audiencia_gostou` AS `gostou_tema`,
						CASE isnull(`vt_foto`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_foto`,
						CASE isnull(`vt_fo1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot1`,
						CASE isnull(`vt_fo2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot2`,
						CASE isnull(`mod1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod1`,
						CASE isnull(`mod2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod2`,
						`fot1`.`nome_artistico` AS `fotografo1`,`fot1`.`audiencia_gostou` AS `gostou_fot1`,`fot1`.`nome_foto` AS `foto_fot1`, `fot1`.`meta_descricao` AS `desc_fot1` ,
						`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`, `fot2`.`meta_descricao` AS `desc_fot1` ,
						`loc`.`nome` AS `nome_locacao`,`loc`.`nome_foto` AS `foto_locacao`,`loc`.`audiencia_gostou` AS `gostou_locacao`,
						`mod1`.`nome_artistico` AS `modelo1`,`mod1`.`foto_perfil` AS `foto_mod1`,`mod1`.`audiencia_gostou` AS `gostou_mo1`, `mod1`.`meta_descricao` AS `desc_mo1` ,
						`mod2`.`nome_artistico` AS `modelo2`,`mod2`.`foto_perfil` AS `foto_mod2`,`mod2`.`audiencia_gostou` AS `gostou_mo2`, `mod2`.`meta_descricao` AS `desc_mo2` ,
						`fig1`.`nome` AS `figurino1`,`fig1`.`audiencia_gostou` AS `gostou_fig1`,
						`fig2`.`nome` AS `figurino2`,`fig2`.`audiencia_gostou` AS `gostou_fig2`')
 				->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 'f' ) )
 				->join ( 'INNER', $db->quoteName ( '#__angelgirls_sessao', 's' ) . ' ON (' . $db->quoteName ( 'f.id_sessao' ) . ' = ' . $db->quoteName ( 's.id' ) . ')' )
				->join ( 'INNER', $db->quoteName ( '#__angelgirls_modelo', 'mod1' ) . ' ON (' . $db->quoteName ( 'mod1.id' ) . ' = ' . $db->quoteName ( 's.id_modelo_principal' ) . ')' )
				->join ( 'INNER', $db->quoteName ( '#__angelgirls_fotografo', 'fot1' ) . ' ON (' . $db->quoteName ( 'fot1.id' ) . ' = ' . $db->quoteName ( 's.id_fotografo_principal' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_tema', 'tema' ) . ' ON (' . $db->quoteName ( 'tema.id' ) . ' = ' . $db->quoteName ( 's.id_tema' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_modelo', 'mod2' ) . ' ON (' . $db->quoteName ( 'mod2.id' ) . ' = ' . $db->quoteName ( 's.id_modelo_secundaria' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_figurino', 'fig1' ) . ' ON (' . $db->quoteName ( 'fig1.id' ) . ' = ' . $db->quoteName ( 's.id_figurino_principal' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_figurino', 'fig2' ) . ' ON (' . $db->quoteName ( 'fig2.id' ) . ' = ' . $db->quoteName ( 's.id_figurino_secundario' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_locacao', 'loc' ) . ' ON (' . $db->quoteName ( 'loc.id' ) . ' = ' . $db->quoteName ( 's.id_locacao' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_fotografo', 'fot2' ) . ' ON (' . $db->quoteName ( 'fot2.id' ) . ' = ' . $db->quoteName ( 's.id_fotografo_secundario' ) . ')' )
				->join ( 'LEFT', '(SELECT data_criado, id_foto FROM #__angelgirls_vt_foto_sessao WHERE id_usuario='.$user->id.') vt_foto ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_foto.id_foto'))
				->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_fo1 ON ' . $db->quoteName ( 'fot1.id' ) . ' = ' . $db->quoteName('vt_fo1.id_fotografo'))
				->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_fo2 ON ' . $db->quoteName ( 'fot2.id' ) . ' = ' . $db->quoteName('vt_fo2.id_fotografo'))
				->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_mod1 ON ' . $db->quoteName ( 'mod1.id' ) . ' = ' . $db->quoteName('vt_mod1.id_modelo'))
				->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_mod2 ON ' . $db->quoteName ( 'mod2.id' ) . ' = ' . $db->quoteName('vt_mod2.id_modelo'))				
				->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
				->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		
		
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
		
		JRequest::setVar ( 'foto', $result );
		
		
		
		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $result->id_sessao, 0) );
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'foto' );
		parent::display (true, false);
	}
	
	
	
	public function carregarCadastrarLocacao(){
	
		JRequest::setVar ( 'ufs', $this->getUFs());
	
		require_once 'views/sessoes/tmpl/adicionar_locacao.php';
		exit();
	}
	
	
	public function salvarLocacao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$nome = JRequest::getString('nome',null);
		$descricao = JRequest::getString('descricao',null);
		$endereco = JRequest::getString('endereco',null);
		$numero = JRequest::getString('numero',null);
		$bairro = JRequest::getString('bairro',null);
		$complemento = JRequest::getString('complemento',null);
		$cep = JRequest::getString('cep',null);
		$idCidade = JRequest::getInt('id_cidade',null);
		$site = JRequest::getString('site',null);
		$telefone = JRequest::getString('telefone',null);
		$email = JRequest::getString('email',null);
		
		
		
	
		$foto_perfil = $_FILES ['imagem'];
	
		$mensagens=array();
		
		if(!isset($nome) || strlen(trim($nome))<5){
			$mensagens[] = 'Nome &eacute; um campo obrigat&oacute;rio e deve conter 5 caracteres no minimo.' ;
		}
		if(!isset($descricao) || strlen(trim($descricao))<=0){
			$mensagens[] = 'Descri&ccedil;&atilde;o &eacute; um campo obrigat&oacute;rio.';
		}
		if(!isset($endereco) || strlen(trim($endereco))<=0){
			$mensagens[] = 'Endere&ccedil;o &eacute; um campo obrigat&oacute;rio.' ;
		}
		if(!isset($bairro) || strlen(trim($bairro))<=0){
			$mensagens[] = 'Bairro &eacute; um campo obrigat&oacute;rio.' ;
		}
		if(!isset($cep) || strlen(trim($cep))<=0){
			$mensagens[] = 'CEP &eacute; um campo obrigat&oacute;rio.' ;
		}
		if(!isset($idCidade) || strlen(trim($idCidade))<=0){
			$mensagens[] = 'Cidade/Estado s&atilde;o campos obrigat&oacute;rios.' ;
		}

		if(!isset($foto_perfil) || !JFile::exists ( $foto_perfil ['tmp_name'] )){
			$mensagens[] = 'Imagem &eacute; um campo obrigat&oacute;rio.';
		}
		
		$query = $db->getQuery ( true );
		$query->select('l.nome')
		->from ($db->quoteName ('#__angelgirls_locacao', 'l' ))
		->where ('trim(upper(l.nome)) = ' . $db->quote(strtoupper(trim( $nome))) );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(isset($result)){
			$mensagens[] = 'J&aacute; existe um tema com esse nome.';
		}
		
		if(sizeof($mensagens)>0){
			JRequest::setVar('mensagem',$mensagens );
			$this->carregarCadastrarLocacao();
 			return;
		}
	
		$nomearquivo = "";
	
		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
			$nomearquivo = $this->GerarNovoNomeArquivo($fileName);
			$fileTemp = $foto_perfil ['tmp_name'];
			$newfile = PATH_IMAGEM_LOCACOES . $nomearquivo;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				JRequest::setVar('mensagem','Falha ao salvar o arquivo.');
				$this->carregarCadastrarLocacao();
				return;
			}
		}

		
		$query = $db->getQuery ( true );
		$query->insert( '#__angelgirls_locacao' )
		->columns (array (
				$db->quoteName ( 'nome' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'nome_foto' ),
				$db->quoteName ( 'endereco' ),
				$db->quoteName ( 'numero' ),
				$db->quoteName ( 'bairro' ),
				$db->quoteName ( 'complemento' ),
				$db->quoteName ( 'cep' ),
				$db->quoteName ( 'id_cidade' ),
				$db->quoteName ( 'site' ),
				$db->quoteName ( 'ddd_telefone' ),
				$db->quoteName ( 'telefone' ),
				$db->quoteName ( 'email' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'data_alterado' )))
				->values(implode(',', array ($db->quote($nome),$db->quote($descricao),$db->quote($descricao),$db->quote($nomearquivo),
						$db->quote($endereco),
						$db->quote($numero),
						$db->quote($bairro),
						$db->quote($complemento),
						$db->quote($cep),
						$db->quote($idCidade),
						$db->quote($site),
						$db->quote(substr($telefone,1,2)),
						$db->quote(substr($telefone,5)),
						$db->quote($email),
						$user->id,$user->id, 'NOW()', 'NOW()')));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		require_once 'views/sessoes/tmpl/adicionar_tema.php';
		echo("<script>jQuery('#locacao',parent.document).append(new Option('$nome',$id));jQuery('#locacao',parent.document).val($id);jQuery('#locacao',parent.document).removeClass('error');jQuery('#locacao',parent.document).addClass('valid');jQuery('#locacao',parent.document).focus();parent.document.AngelGirls.FrameModalHide();</script>");
		exit();
	}
	
	public function carregarCadastrarFigurino(){
	
		require_once 'views/sessoes/tmpl/adicionar_figurino.php';
		exit();
	}
	
	
	public function salvarFigurino(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$nome = JRequest::getString('nome',null);
		$descricao = JRequest::getString('descricao',null);
		$nomeCampo = JRequest::getVar('campo');
		
		$foto_perfil = $_FILES ['imagem'];
	
		$mensagens=array();
	
		if(!isset($nome) || strlen(trim($nome))<5){
			$mensagens[] = 'Nome do tema &eacute; um campo obrigat&oacute;rio e deve conter 5 caracteres no minimo.' ;
		}
		if(!isset($descricao) || strlen(trim($descricao))<=0){
			$mensagens[] = 'Descri&ccedil;&atilde;o do tema &eacute; um campo obrigat&oacute;rio.';
		}
		if(!isset($foto_perfil) || !JFile::exists ( $foto_perfil ['tmp_name'] )){
			$mensagens[] = 'Imagem do tema &eacute; um campo obrigat&oacute;rio.';
		}
	
		$query = $db->getQuery ( true );
		$query->select('t.nome')
		->from ($db->quoteName ('#__angelgirls_figurino', 't' ))
		->where ('trim(upper(t.nome)) = ' . $db->quote(strtoupper(trim($nome))) );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(isset($result)){
			$mensagens[] = 'J&aacute; existe um tema com esse nome.';
		}
	
	
	
		if(sizeof($mensagens)>0){
			JRequest::setVar('mensagem',$mensagens );
			$this->carregarCadastrarTema();
			return;
		}
	
		$nomearquivo = "";
	
		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
			$nomearquivo = $this->GerarNovoNomeArquivo($fileName);
			$fileTemp = $foto_perfil ['tmp_name'];
			$newfile = PATH_IMAGEM_FIGURINOS . $nomearquivo;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload( $fileTemp, $newfile )) {
				JRequest::setVar('mensagem','Falha ao salvar o arquivo.');
				$this->carregarCadastrarTema();
				return;
			}
		}
	
		$query = $db->getQuery ( true );
		$query->insert( '#__angelgirls_figurino' )
		->columns (array (
				$db->quoteName ( 'nome' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'nome_foto' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'data_alterado' )))
				->values(implode(',', array ($db->quote(trim($nome)),$db->quote(trim($descricao)),$db->quote(trim($descricao)),$db->quote($nomearquivo), $user->id,$user->id, 'NOW()', 'NOW()')));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		require_once 'views/sessoes/tmpl/adicionar_figurino.php';
		echo("<script>jQuery('.figurino',parent.document).append(new Option('$nome',$id));jQuery('#$nomeCampo',parent.document).val($id);jQuery('#$nomeCampo',parent.document).removeClass('error');jQuery('#$nomeCampo',parent.document).addClass('valid');jQuery('#$nomeCampo',parent.document).focus();parent.document.AngelGirls.FrameModalHide();</script>");
		exit();
	}
	
	public function carregarCadastrarTema(){
		
		
		
		require_once 'views/sessoes/tmpl/adicionar_tema.php';
		exit();
	}
	
	
	public function salvarTema(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$nome = JRequest::getString('nome',null);
		$descricao = JRequest::getString('descricao',null);
		
		$foto_perfil = $_FILES ['imagem'];
		
		$mensagens=array();
		
		if(!isset($nome) || strlen(trim($nome))<5){
			$mensagens[] = 'Nome do tema &eacute; um campo obrigat&oacute;rio e deve conter 5 caracteres no minimo.' ;
		}
		if(!isset($descricao) || strlen(trim($descricao))<=0){
			$mensagens[] = 'Descri&ccedil;&atilde;o do tema &eacute; um campo obrigat&oacute;rio.';
		}
		if(!isset($foto_perfil) || !JFile::exists ( $foto_perfil ['tmp_name'] )){
			$mensagens[] = 'Imagem do tema &eacute; um campo obrigat&oacute;rio.';
		}
		
		$query = $db->getQuery ( true );
		$query->select('t.nome')
		->from ($db->quoteName ('#__angelgirls_tema', 't' ))
		->where ('trim(upper(t.nome)) = ' . $db->quote(strtoupper(trim($nome))) );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(isset($result)){
			$mensagens[] = 'J&aacute; existe um tema com esse nome.';
		}
		
		
		
		if(sizeof($mensagens)>0){
			JRequest::setVar('mensagem',$mensagens );
			$this->carregarCadastrarTema();
 			return;
		}
		
		$nomearquivo = "";
		
		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
			$nomearquivo = $this->GerarNovoNomeArquivo($fileName);
			$fileTemp = $foto_perfil ['tmp_name'];
			$newfile = PATH_IMAGEM_TEMAS . $nomearquivo;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload( $fileTemp, $newfile )) {
				JRequest::setVar('mensagem','Falha ao salvar o arquivo.');
				$this->carregarCadastrarTema();
				return;
			} 
		}
		
		$query = $db->getQuery ( true );
		$query->insert( '#__angelgirls_tema' )
		->columns (array (
				$db->quoteName ( 'nome' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'nome_foto' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'data_alterado' )))
				->values(implode(',', array ($db->quote(trim($nome)),$db->quote(trim($descricao)),$db->quote(trim($descricao)),$db->quote($nomearquivo), $user->id,$user->id, 'NOW()', 'NOW()')));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		require_once 'views/sessoes/tmpl/adicionar_tema.php';
		echo("<script>jQuery('#tema',parent.document).append(new Option('$nome',$id));jQuery('#tema',parent.document).val($id);jQuery('#tema',parent.document).removeClass('error');jQuery('#tema',parent.document).addClass('valid');jQuery('#tema',parent.document).focus();parent.document.AngelGirls.FrameModalHide();</script>");
		exit();
	}
	
	private function GerarNovoNomeArquivo($fileName, $prefixo = null){
		$uploadedFileNameParts = explode ( '.', $fileName );
		$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
		//$nomearquivo = date('YmdHi').hash('sha256', $fileName . date('YmdHis')).'@'.md5($fileName . date('YmdHis')) . '.' . $uploadedFileExtension;
		//$nomearquivo = (isset($prefixo)?$prefixo.'_':'') . date('YmdHis') . hash('sha256', $fileName . date('YmdHisu')) . '.' . $uploadedFileExtension;
		$nomearquivo = (isset($prefixo)?$prefixo.'_':'') . date('YmdHis') . md5($fileName . date('YmdHisu')) . '.' . $uploadedFileExtension;
		return $nomearquivo;
	}
	
	private function GerarToken($chave, $ComDataNoPrefixo = false, $large= false){
		$chaveValor =  (isset($chave) && strlen(trim($chave))> 0 ? $chave : date('YmdHis'));
		return ($ComDataNoPrefixo?date('YmdHis'):'').($large?sha1($chaveValor):'').md5($chaveValor);
	}

	
	/**
	 * 
	 */
	public function carregarEditarSessao(){
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$user = JFactory::getUser();
		
		
		$perfil = $this->getPerfilLogado();
		
		if(!isset($perfil)){
			$this->nologado();
			return;
		}
		
		if($perfil->tipo != 'MODELO' && $perfil->tipo != 'FOTOGRAFO'){
			JError::raiseWarning(100,JText::_('Área permitida apenas para modelos ou fotografos.'));
			$this->logado();
			return;
		}
		
		JRequest::setVar ('modelos', $this->getAllModelos() );
		
		JRequest::setVar ('fotografos', $this->getAllFotografos() );
		JRequest::setVar ('temas', $this->getAllTemas());
		JRequest::setVar ('figurinos', $this->getAllFigurinos());
		JRequest::setVar ('locacoes', $this->getAllLocacoes());
		
		JRequest::setVar ('perfil', $this->getPerfilLogado() );
		
		$sessao = $this->getSessaoById($id);
		
		if(isset($sessao) && $sessao->status_dado == StatusDado::PUBLICADO){
			JError::raiseWarning(100,JText::_('A Sessão que tentou acessar já foi publicada por isso não pode ser editada.'));
			$sessao == null;
			$id = 0;
		}
		
		JRequest::setVar ( 'sessao', $sessao);
		
		
		
		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $id, $this::LIMIT_DEFAULT) );
		
		JRequest::setVar('view', 'sessoes');
		JRequest::setVar('layout', 'editar');
		parent::display();
	}
	
	/**
	 * 
	 */
	public function salvarSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		


	
		JRequest::setVar('view', 'sessoes');
		JRequest::setVar('layout', 'editar');
		parent::display();
	}

	
	/**
	 *
	 */
	public function enviarFotosSessao(){
	
		JRequest::setVar('view', 'sessoes');
		JRequest::setVar('layout', 'editar');
		parent::display();
	}
	
	
	
	private function getSessaoById($id ){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		
		
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`nome_foto`,`s`.`executada`,`s`.`descricao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
			`s`.`comentario_equipe`,`s`.`meta_descricao`,`s`.`id_agenda`,`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
			`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
			`s`.`audiencia_gostou`,`s`.`audiencia_ngostou`,`s`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
			`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
			`tema`.`nome` AS `nome_tema`,`tema`.`descricao` AS `descricao_tema`,`tema`.`nome_foto` AS `foto_tema`,`tema`.`audiencia_gostou` AS `gostou_tema`,
			CASE isnull(`vt_sessao`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_sessao`,
			CASE isnull(`vt_fo1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot1`,
			CASE isnull(`vt_fo2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot2`,
			CASE isnull(`mod1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod1`,
			CASE isnull(`mod2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod2`,
			`fot1`.`nome_artistico` AS `fotografo1`,`fot1`.`audiencia_gostou` AS `gostou_fot1`,`fot1`.`nome_foto` AS `foto_fot1`, `fot1`.`meta_descricao` AS `desc_fot1` ,
			`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`, `fot2`.`meta_descricao` AS `desc_fot1` ,
			`loc`.`nome` AS `nome_locacao`,`loc`.`nome_foto` AS `foto_locacao`,`loc`.`audiencia_gostou` AS `gostou_locacao`,
			`mod1`.`nome_artistico` AS `modelo1`,`mod1`.`foto_perfil` AS `foto_mod1`,`mod1`.`audiencia_gostou` AS `gostou_mo1`, `mod1`.`meta_descricao` AS `desc_mo1` ,
			`mod2`.`nome_artistico` AS `modelo2`,`mod2`.`foto_perfil` AS `foto_mod2`,`mod2`.`audiencia_gostou` AS `gostou_mo2`, `mod2`.`meta_descricao` AS `desc_mo2` ,
			`fig1`.`nome` AS `figurino1`,`fig1`.`audiencia_gostou` AS `gostou_fig1`,
			`fig2`.`nome` AS `figurino2`,`fig2`.`audiencia_gostou` AS `gostou_fig2`')
			->from ('#__angelgirls_sessao AS s')
			->join ( 'INNER', '#__angelgirls_modelo AS mod1 ON (mod1.id = s.id_modelo_principal)' )
			->join ( 'INNER', '#__angelgirls_fotografo AS fot1 ON (fot1.id = s.id_fotografo_principal)' )
			->join ( 'LEFT', '#__angelgirls_tema AS tema  ON (tema.id = s.id_tema)' )
			->join ( 'LEFT', '#__angelgirls_modelo AS mod2 ON (mod2.id = s.id_modelo_secundaria)' )
			->join ( 'LEFT', '#__angelgirls_figurino AS fig1 ON (fig1.id = s.id_figurino_principal)' )
			->join ( 'LEFT', '#__angelgirls_figurino AS fig2 ON (fig2.id = s.id_figurino_secundario)' )
			->join ( 'LEFT', '#__angelgirls_locacao AS loc ON (loc.id = s.id_locacao)' )
			->join ( 'LEFT', '#__angelgirls_fotografo AS fot2 ON (fot2.id = s.id_fotografo_secundario)' )
			->join ( 'LEFT', '(SELECT data_criado, id_sessao FROM #__angelgirls_vt_sessao WHERE id_usuario='.$user->id.') vt_sessao ON s.id = vt_sessao.id_sessao')
			->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_fo1 ON fot1.id = vt_fo1.id_fotografo')
			->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_fo2 ON fot2.id = vt_fo2.id_fotografo')
			->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_mod1 ON mod1.id = vt_mod1.id_modelo')
			->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_mod2 ON mod2.id = vt_mod2.id_modelo')
			->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
			->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
			->where ( $db->quoteName ( 's.id' ) . " =  " . $id );
		
		
		
		$db->setQuery ( $query );
		$result = $db->loadObject();
		return $result; 
	}
	
	
	/**
	 * 
	 */
	public function carregarSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}



		
		$result = $this->getSessaoById($id);

		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_sessao' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
		
		JRequest::setVar ( 'sessao', $result );


		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $id, $this::LIMIT_DEFAULT) );
		
		JRequest::setVar ( 'perfil', $this->getPerfilLogado() );
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'sessao' );
		parent::display (true, false);
	}
	
	public function carregarFotosContinuaHtml(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		

		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
		
		$posicao = JRequest::getString( 'posicao');
		
		$results = $this->runFotoSessao($user, $posicao, $id,$this::LIMIT_DEFAULT );
		
		JRequest::setVar('fotos', $results);
		
		
		
		require_once 'views/sessoes/tmpl/fotos.php';		


		exit();	
	}
	

	
	public function runFotoSessao($user, $posicao, $iSessao, $limit = 0 ){
		$db = JFactory::getDbo ();
	
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`descricao`,`s`.`meta_descricao`, `s`.`audiencia_gostou`,
			CASE isnull(`vt_sessao`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`, `s`.`id_sessao` as `sessao`')
			->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
			->join ( 'LEFT', '(SELECT data_criado, id_foto FROM #__angelgirls_vt_foto_sessao WHERE id_usuario='.$user->id.') vt_sessao ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName('vt_sessao.id_foto'))
			->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
			->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $iSessao)
			->order('`s`.`ordem` ');
		if($limit>0){
			$query->setLimit($limit, $posicao);
		}
		$db->setQuery ( $query );

		$results = $db->loadObjectList();
		//JRequest::setVar ( 'fotos', $results );
		return $results;
	}
	
	public function loadImage(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$tipo = JRequest::getString('descricao','');
		$view = JRequest::getString( 'view','');
		$arquivo = "";
		$mime = 'image/jpeg';


		if($view=='fotosessao'){
			$detalhe = explode ( ' ', $tipo );
			
			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_foto` AS `foto`, `f`.`token` AS foto_token, s.token AS sessao_token')
			->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 'f' ) )
			->join ('INNER', $db->quoteName ( '#__angelgirls_sessao', 's' ) . ' ON f.id_sessao = s.id')
			->where ( $db->quoteName ( 'f.id' ) . ' = ' . $id )
			->where (' f.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
			->where (' s.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
			if(isset($result)){
				if ($detalhe[1]=='full'){
					$arquivo =  PATH_IMAGEM_SESSOES .  $result->sessao_token . DS . $result->foto_token  . '.jpg';
					
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
							->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id);
					$db->setQuery ( $query );
					$db->execute ();
				}
				else{
					$arquivo =  PATH_IMAGEM_SESSOES . $result->sessao_token . DS . $detalhe[1] . '_' . $result->foto_token  . '.jpg';
				}
			}
		}
		else if($view=='sessoes'){
			$query = $db->getQuery ( true );
			$query->select('`s`.`nome_foto` AS `foto`, `s`.`token`')
			->from ( $db->quoteName ( '#__angelgirls_sessao', 'sf' ) )
			->where ( $db->quoteName ( 's.id' ) . " =  " . $id )
			->where (' s.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_SESSOES . $result->token . DS  . $result->foto;
			}
		}
		else if($view=='fotoalbum'){
			$detalhe = explode ( ' ', $tipo );
			if ($detalhe[1]=='full'){
				$arquivo =  $path .  DS. 'albuns' .DS . $detalhe[0] . DS . $id  . '.jpg';
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_foto_album' ))
					->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
					->where ($db->quoteName ( 'id' ) . ' = ' . $id)
					->where (' f.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
					->where (' a.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
				$db->setQuery ( $query );
				$db->execute ();
			}

			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_arquivo` AS `foto`, `f`.`id_album`, `f`.`token`, `f`.`token` AS foto_token, a.token AS album_token')
			->from ( $db->quoteName ( '#__angelgirls_foto_album', 'f' ) )
			->join('INNER', $db->quoteName ( '#__angelgirls_album', 'a' ) . ' ON f.id_album = a.id' )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $id )
			->where (' f.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
			->where (' a.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_ALBUNS . $result->album_token . DS .  ($detalhe[1]=='full' ? '': '_' . $detalhe[1])  . $result->foto;
			}
		}
		else if($view=='albuns'){
			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_arquivo` AS `foto`, `f`.`token`, `f`.`token` AS foto_token, a.token AS album_token' )
			->from ( $db->quoteName ( '#__angelgirls_album', 'a' ) )
			->join ( 'LEFT', '#__angelgirls_foto_album f ON ' . $db->quoteName ( 'a.id_foto_capa' ) . ' = ' . $db->quoteName ( 'f.id' )  )
			->where (' a.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_ALBUNS .  $result->album_token . DS . $result->foto;
			}
		}
		else if($view=='modelo'){
			$detalhe = explode ( ' ', $tipo );
			$query = $db->getQuery ( true );
			if ($detalhe[1]=='ico'){
				$query->select('`f`.`foto_perfil` AS `foto`');
			}
			else if ($detalhe[1]=='medium'){
				$query->select('`f`.`foto_inteira` AS `foto`');
			}
			else if ($detalhe[1]=='horizontal'){
				$query->select('`f`.`foto_inteira_horizontal` AS `foto`');
			}
			else {
				$query->select('`f`.`foto_perfil` AS `foto`');
			}
			$query->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $id )
			->where (' status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_MODELOS . $result->foto;
			}
		}
		else if($view=='fotografo'){
			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_foto` AS `foto`')
				->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $id )
				->where (' status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_FOTOGRAFOS . $result->foto;
			}
		}
		header("Cache-Control: public ");
		if(JFile::exists( $arquivo )){
			$imageInfo = getimagesize($arquivo);
			switch ($imageInfo[2]) {
				case IMAGETYPE_JPEG:
					$mime="Content-Type: image/jpg";
					break;
				case IMAGETYPE_GIF:
					$mime="Content-Type: image/gif";
					break;
				case IMAGETYPE_PNG:
					$mime="Content-Type: image/png";
					break;
				default:
					$mime="Content-Type: image/jpg";
			}
			header ($mime);
			header("Content-Length: " . filesize($arquivo));
			//$fp = fopen($arquivo, 'rb');
			//echo file_get_contents($fp);
			readfile($arquivo );
		}
		else{
			$arquivo = JPATH_BASE.DS.'components'.DS.'com_angelgirls'.DS. 'no_image2.png';
			header ('Content-Type: image/png');
			header("Content-Length: " . filesize($arquivo));
			//$fp = fopen($arquivo, 'rb');
			//echo file_get_contents($fp);
			readfile($arquivo);			
		}
		exit();
	}
	
	
	
	
	public function runQueryFilterSessoes($user, $nome, $posicao, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem ){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
		->where ('(s.status_dado  IN (' . $db->quote(StatusDado::PUBLICADO) . ') OR (s.id_usuario_criador = '.$user->id.' AND  s.status_dado NOT IN (' . $db->quote(StatusDado::REMOVIDO) . '))')
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " );
		
		if(isset($nome) && trim($nome) != ""){
			$query->where (  " ( upper(s.titulo) like " . $db->quote(strtoupper(trim($nome)).'%') . " OR
					SOUNDEX(upper(s.titulo)) like SOUNDEX(" . $db->quote(strtoupper(trim($nome)).'%') . "))");
		}
		if(isset($dataInicio) && trim($dataInicio) != ""){
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataInicio)->format('Y-m-d');
			$query->where (  " s.publicar >= " . $db->quote($dataFormatadaBanco));
		}
		if(isset($dataFim) && trim($dataFim) != ""){
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataFim)->format('Y-m-d');
			$query->where (  " s.publicar <= " . $db->quote($dataFormatadaBanco));
		}
		if(isset($idModelo) && $idModelo != 0 ){
			$query->where (  ' ( ' . $db->quoteName ('s.id_modelo_principal') . ' = ' . $idModelo . ' OR ' . $db->quoteName ('s.id_modelo_secundaria') . ' = ' . $idModelo . ')');
		}
		if(isset($idFotografo) && $idFotografo != 0 ){
			$query->where (  ' ( ' . $db->quoteName ('s.id_fotografo_principal') . ' = ' . $idFotografo . ' OR ' . $db->quoteName ('s.id_fotografo_secundario') . ' = ' . $idFotografo . ')');
		}
		
		
		if(isset($ordem) && $ordem != 0 ){
			if($ordem == 1){
				$query->order('`s`.`publicar` DESC ');
			}
			elseif($ordem == 2){
				$query->order('`s`.`publicar` ASC ');
			}
			elseif($ordem == 3){
				$query->order('`s`.`titulo` ASC ');
			}
			elseif($ordem == 4){
				$query->order('`s`.`titulo` DESC ');
			}
			else{
				$query->order('`s`.`publicar` DESC ');
			}
		}
		else{
			$query->order('`s`.`publicar` DESC ');
		}
		$query->setLimit($this::LIMIT_DEFAULT, $posicao);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();

		
		return $results;
	} 
	

	
	public function carregarSessoesContinuaJson(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null);
	
		$posicao = JRequest::getInt( 'posicao', null);
	
		$idModelo = JRequest::getInt( 'id_modelo', null);
		$idFotografo = JRequest::getInt( 'id_fotografo', null);
		$dataInicio = JRequest::getString( 'data_inicio', null);
		$dataFim = JRequest::getString( 'data_fim', null);
		$ordem = JRequest::getInt( 'ordem', null);
		

		$results = $this->runQueryFilterSessoes($user, $nome, $posicao, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem );
		JRequest::setVar ( 'sessoes', $results );
		require_once 'views/sessoes/tmpl/sessoes_html.php';
		exit();		
	}
	
	
	private function getAllModelos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','nome_artistico','foto_perfil'),
				array('id','nome','alias','foto')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'status_dado' ) . '  IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . " <> '' " )
				->order('nome_artistico')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results; 
	}
	
	private function getAllTemas(){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome','descricao','nome_foto'),
				array('id','nome','descricao','foto')))
			->from ('#__angelgirls_tema')
				->where ('((status_dado IN (' . $db->quote(StatusDado::ATIVO) . ')) OR (id_usuario_criador = '.$user->id.' AND status_dado NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ')))' )
			->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
			->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
			->order('nome')
			->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	
	private function getAllLocacoes(){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome','descricao','nome_foto','endereco','numero','cep'),
				array('id','nome','descricao','foto','endereco','numero','cep')))
				->from ('#__angelgirls_locacao')
				->where ('((status_dado IN (' . $db->quote(StatusDado::ATIVO) . ')) OR (id_usuario_criador = '.$user->id.' AND status_dado NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ')))' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('nome')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	private function getAllFigurinos(){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome','descricao','nome_foto'),
				array('id','nome','descricao','foto')))
				->from ('#__angelgirls_figurino')
				->where ('((status_dado IN (' . $db->quote(StatusDado::ATIVO) . ')) OR (id_usuario_criador = '.$user->id.' AND status_dado NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ')))' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('nome')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	private function getAllFotografos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','nome_artistico','nome_foto'),
				array('id','nome','alias','foto')))
				->from ('#__angelgirls_fotografo')
				->where ( $db->quoteName ( 'status_dado' ) . '  IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('nome_artistico')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	public function carregarSessoes(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null);
		
		$posicao = JRequest::getInt( 'posicao', null);
		
		$idModelo = JRequest::getInt( 'id_modelo', null);
		$idFotografo = JRequest::getInt( 'id_fotografo', null);
		$dataInicio = JRequest::getString( 'data_inicio', null);
		$dataFim = JRequest::getString( 'data_fim', null);
		$ordem = JRequest::getInt( 'ordem', null);
		$db = JFactory::getDbo ();
		
		JRequest::setVar ( 'sessoes', $this->runQueryFilterSessoes($user, $nome, 0, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem ));

		JRequest::setVar ( 'modelos', $this->getAllModelos() );

		JRequest::setVar ( 'fotografos', $this->getAllFotografos() );
		
		JRequest::setVar ( 'perfil', $this->getPerfilLogado() );
		
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display ();
	}
	
	
	/**
	 *
	 */
	public function carregarAlbum(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
	
		$id = JRequest::getString( 'id',0);
	
	
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`nome_foto`,`s`.`executada`,`s`.`descricao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
						`s`.`comentario_equipe`,`s`.`meta_descricao`,`s`.`id_agenda`,`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
						`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
						`s`.`audiencia_gostou`,`s`.`audiencia_ngostou`,`s`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
						`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
						`tema`.`nome` AS `nome_tema`,`tema`.`descricao` AS `descricao_tema`,`tema`.`nome_foto` AS `foto_tema`,`tema`.`audiencia_gostou` AS `gostou_tema`,
						CASE isnull(`vt_album`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_album`')
							->from ( $db->quoteName ( '#__angelgirls_album', 's' ) )
							->join ( 'LEFT', '(SELECT data_criado, id_album FROM #__angelgirls_vt_album WHERE id_usuario='.$user->id.') vt_album ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName('vt_album.id_album'))
							->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
							->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
							->where ( $db->quoteName ( 's.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
		JRequest::setVar ( 'album', $result );
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_album' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
		
	
	
		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $id, $this::LIMIT_DEFAULT) );
	
		JRequest::setVar ( 'view', 'albuns' );
		JRequest::setVar ( 'layout', 'album' );
		parent::display (true, false);
	}
	
	
	public function carregarFotoAlbum(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
	
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
	
	
	
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`,`f`.`titulo`,`f`.`descricao`,`f`.`meta_descricao`,`f`.`id_album`,`f`.`audiencia_gostou`,
						`s`.`titulo` AS `titulo_album`,`s`.`nome_arquivo` AS `nome_foto`,
						`s`.`executada`,`s`.`descricao` AS `descricao_album`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
						`s`.`comentario_equipe`,`s`.`meta_descricao` AS `meta_descricao_album`,`s`.`id_agenda`,
						`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
						`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
						`s`.`audiencia_gostou` AS audiencia_gostou_album,`s`.`audiencia_ngostou`,`f`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
						`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
						CASE isnull(`vt_foto`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_foto`,
					')
							->from ( $db->quoteName ( '#__angelgirls_foto_album', 'f' ) )
							->join ( 'INNER', $db->quoteName ( '#__angelgirls_album', 's' ) . ' ON (' . $db->quoteName ( 'f.id_album' ) . ' = ' . $db->quoteName ( 's.id' ) . ')' )
							->join ( 'LEFT', '(SELECT data_criado, id_foto FROM #__angelgirls_vt_foto_album WHERE id_usuario='.$user->id.') vt_foto ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_foto.id_foto'))
							->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
							->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
							->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
	
	
		$db->setQuery ( $query );
		$result = $db->loadObject();
		if(!isset($result)){
			$this->RegistroNaoEncontado();
			exit();
		}
	
		JRequest::setVar ( 'foto', $result );
	
	
	
		JRequest::setVar ( 'fotos', $this->runFotoAlbum($user, 0, $result->id_album, 0) );
	
		JRequest::setVar ( 'view', 'albuns' );
		JRequest::setVar ( 'layout', 'foto' );
		parent::display (true, false);
	}
	
	
	


	/**
	 * Carrega Fotos por chamada Ajax
	 */
	public function carregarFotosAlbumContinuaHtml(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$posicao = JRequest::getString( 'posicao');
		$results = $this->runFotoAlbum($user, $posicao, $id, $this::LIMIT_DEFAULT );
		header('Content-Type: text/html; charset=utf8');
		foreach($results as $foto){
			$url = JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarFotoAlbum&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo)));
				$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotoalbum&task=loadImage&id='.$foto->id.':'.$foto->album.'thumbnail');?>
		<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
			<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" /></a>
		</div>
	<?php
		}
 		$contador = sizeof($results);
 		if($contador>0):
 			echo("<script>lidos+=$contador\n</script>");
 		endif;
		exit();	
	}
	
	/**
	 * Query que busca fotos de um album
	 */
	public function runFotoAlbum($user, $posicao, $iAlbum, $limit = 0 ){
		$db = JFactory::getDbo ();
	
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`descricao`,`s`.`meta_descricao`, `s`.`audiencia_gostou`,
			CASE isnull(`vt_album`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`, `s`.`id_album` as `album`')
			->from ( $db->quoteName ( '#__angelgirls_foto_album', 's' ) )
			->join ( 'LEFT', '(SELECT data_criado, id_foto FROM #__angelgirls_vt_foto_album WHERE id_usuario='.$user->id.') vt_album ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName('vt_album.id_foto'))
			->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
			->where ( $db->quoteName ( 's.id_album' ) . " =  " . $iAlbum)
			->order('`s`.`ordem` ');
		if($limit>0){
			$query->setLimit($limit, $posicao);
		}
		$db->setQuery ( $query );

		$results = $db->loadObjectList();
		//JRequest::setVar ( 'fotos', $results );
		return $results;
	}
	
	
	
	
	
	
	/**
	 * Query que busca albuns
	 */
	public function runQueryFiltrarAlbuns($user, $nome, $posicao, $dataInicio, $dataFim, $ordem ){
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `foto`.`nome_arquivo` AS `foto`,
				    `s`.`executada` AS `realizada`,
				    `s`.`audiencia_gostou` AS `gostou`,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` "
		)
		->from ($db->quoteName ('#__angelgirls_album', 's' ))
		->join ( 'LEFT', '(SELECT `data_criado`, `id_album` FROM `#__angelgirls_vt_album` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_album' )  )
		->join ( 'LEFT', '#__angelgirls_foto_album foto ON ' . $db->quoteName ( 's.id_foto_capa' ) . ' = ' . $db->quoteName ( 'foto.id' )  )
		->where ( $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
		->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " );
		
		if(isset($nome) && trim($nome) != ""){
			$query->where (  " ( upper(s.titulo) like " . $db->quote(strtoupper(trim($nome)).'%') . " OR
					SOUNDEX(upper(s.titulo)) like SOUNDEX(" . $db->quote(strtoupper(trim($nome)).'%') . "))");
		}
		if(isset($dataInicio) && trim($dataInicio) != ""){
			//$dataFormatadaBanco = substr($dataInicio,6,10) . '-' . substr($dataInicio,4,5) . '-' . substr($dataInicio,0,2);
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataInicio)->format('Y-m-d');
			$query->where (  " s.publicar >= " . $db->quote($dataFormatadaBanco));
		}
		if(isset($dataFim) && trim($dataFim) != ""){
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataFim)->format('Y-m-d');
			$query->where (  " s.publicar <= " . $db->quote($dataFormatadaBanco));
		}

		
		
		if(isset($ordem) && $ordem != 0 ){
			if($ordem == 1){
				$query->order('`s`.`publicar` DESC ');
			}
			elseif($ordem == 2){
				$query->order('`s`.`publicar` ASC ');
			}
			elseif($ordem == 3){
				$query->order('`s`.`titulo` ASC ');
			}
			elseif($ordem == 4){
				$query->order('`s`.`titulo` DESC ');
			}
			else{
				$query->order('`s`.`publicar` DESC ');
			}
		}
		else{
			$query->order('`s`.`publicar` DESC ');
		}
		$query->setLimit($this::LIMIT_DEFAULT, $posicao);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();

		
		return $results;
	} 
	


	
	public function carregarAlbunsContinuaJson(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null);
	
		$posicao = JRequest::getInt( 'posicao', null);

		$dataInicio = JRequest::getString( 'data_inicio', null);
		$dataFim = JRequest::getString( 'data_fim', null);
		$ordem = JRequest::getInt( 'ordem', null);
		

		$results = $this->runQueryFiltrarAlbuns($user, $nome, $posicao, $dataInicio, $dataFim, $ordem );
		header('Content-Type: text/html; charset=utf8');
		


		foreach($results as $conteudo){ ?>
<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
	<div class="thumbnail">
	<?php  
	$url = JRoute::_('index.php?option=com_angelgirls&view=albums&task=carregarAlbum&id='.$conteudo->id.':album-'.strtolower(str_replace(" ","-",$conteudo->alias))); 
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=albums&task=loadImage&id='.$conteudo->id.':ico');
	?>
						<h5 class="list-group-item-heading"
			style="width: 100%; text-align: center; background-color: grey; color: white; padding: 10px;">
			<a href="<?php echo($url);?>" style="color: white;"><?php echo($conteudo->nome);?></a>
				<div class="gostar" data-gostei='<?php echo($conteudo->eu);?>' data-id='<?php echo($conteudo->id);?>' data-area='album' data-gostaram='<?php echo($conteudo->gostou);?>'></div></h5>
	<?php 			if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
						<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" 	title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>" /></a>
					<?php 
					}?>
					<div class="caption">

			<p class="text-center"><?php echo($conteudo->descricao);?></p>
			<p class="text-center">
				<a href="<?php echo($url);?>" class="btn btn-primary" role="button"
					style="text-overflow: ellipsis; max-width: 150px; overflow: hidden; direction: ltr;"><?php echo($conteudo->nome);?>
	
					</a>
			</p>
		</div>
	</div>
</div>
<?php
		}
		$contador = sizeof($results);
		echo("<script>lidos+=$contador\n");
		if($contador<$this::LIMIT_DEFAULT):
			echo('jQuery("#carregando").css("display","none");temMais=false;');	
		endif;
		echo("</script>");
		
		exit();		
	}
	

	public function carregarAlbuns(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null);
		
		$posicao = JRequest::getInt( 'posicao', null);
		
		$idModelo = JRequest::getInt( 'id_modelo', null);
		$idFotografo = JRequest::getInt( 'id_fotografo', null);
		$dataInicio = JRequest::getString( 'data_inicio', null);
		$dataFim = JRequest::getString( 'data_fim', null);
		$ordem = JRequest::getInt( 'ordem', null);
		$db = JFactory::getDbo ();
		
		$results  = $this->runQueryFiltrarAlbuns($user, $nome, 0, $dataInicio, $dataFim, $ordem );
		
		
		JRequest::setVar ( 'albuns', $results );
		

		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','nome_artistico','foto_perfil'),
				array('id','nome','alias','foto')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'status_dado' ) . '  IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . " <> '' " )
				->order('nome_artistico')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'modelos', $results );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','nome_artistico','nome_foto'),
				array('id','nome','alias','foto')))
				->from ('#__angelgirls_fotografo')
				->where ( $db->quoteName ( 'status_dado' ) . '  IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('nome_artistico')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'fotografos', $results );
		
		
		JRequest::setVar ( 'view', 'albuns' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display ();
	}
		
	
	
	/**
	 * 
	 * @return usuario salvo
	 */
	private function salvarUsuario($tipo){
		$user = JFactory::getUser();
		$usuario = trim(strtolower( JRequest::getString( 'username', '', 'POST' )));
		$senha = trim(JRequest::getString( 'password', '', 'POST' ));
		$senha2 = trim(JRequest::getString( 'password1', null, 'POST' ));		
		$nome = trim(JRequest::getString( 'name', null, 'POST' ));
		
		
		if(!isset($user) || !isset($user->id) || $user->id==0){
			$user = JFactory::getUser(0);

			$usersParams = JComponentHelper::getParams('com_users');
			$userdata = array();
			$userdata['username'] = $usuario;
			$defaultUserGroup = $usersParams->get('new_usertype', 2);

			$userdata['email'] = trim(JRequest::getString( 'email', '', 'POST' ));
			$userdata['email1'] = JRequest::getString( 'email1', null, 'POST' );
			$userdata['name'] = $nome;
			$userdata['password'] = $senha;
			$userdata['password2'] = $senha2;
			$userdata['block'] = 0;
			
			if(strtolower($tipo)=='fotografo'){
				$userdata['groups']=array($defaultUserGroup,GrupoAcesso::FOTOGRAFO_MODELO,GrupoAcesso::FOTOGRAFO);
			}
			elseif(strtolower($tipo)=='modelo'){
				$userdata['groups']=array($defaultUserGroup,GrupoAcesso::FOTOGRAFO_MODELO,GrupoAcesso::MODELO);
			}
			else{
				$userdata['groups']=array($defaultUserGroup);
			}
			if (!$user->bind($userdata)) {
				JError::raiseWarning(100,JText::_( $user->getError()));
				return null;
			}
		}
		else{
			$user->name = $nome;
		}

		if (!$user->save()) {
			JError::raiseWarning(100, JText::_( $user->getError())); 
		}
		return $user;
	}
	
	
	
	
	
	
	private function salvarVisitante( $usuario){


		$sucesso=true;
		
		
		$erro = false;
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$email = JRequest::getString ( 'email', null, 'POST' );
		$username = JRequest::getString ( 'username', null, 'POST' );
		$password = JRequest::getString ( 'password', null, 'POST' );
		$telefone = JRequest::getString ( 'telefone', null, 'POST' );
		$name = JRequest::getString ( 'name', null, 'POST' );
		$descricao = JRequest::getString ( 'descricao', null, 'POST' );
		$metaDescricao = JRequest::getString ( 'meta_descricao', null, 'POST' );
		$nomeArtistico = JRequest::getString ( 'nome_artistico', null, 'POST' );
		$profissao = JRequest::getString ( 'profissao', null, 'POST' );
		$nascionalidade = JRequest::getString ( 'nascionalidade', '', 'POST' );
		$idCidadeNasceu = JRequest::getInt ( 'id_cidade_nasceu', null, 'POST' );
		$dataNascimento = JRequest::getString ( 'data_nascimento', null, 'POST' );
		$site = JRequest::getString ( 'site', null, 'POST' );
		$sexo = JRequest::getString ( 'sexo', null, 'POST' );
		$cpf = JRequest::getString ( 'cpf', null, 'POST' );
		$banco = JRequest::getString ( 'banco', null, 'POST' );
		$agencia = JRequest::getString ( 'agencia', null, 'POST' );
		$conta = JRequest::getString ( 'conta', null, 'POST' );
		$custoMedioDiaria = JRequest::getString ( 'custo_medio_diaria', null, 'POST' );
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$dataFormatadaBanco = 'null';

		
		
		$foto_perfil = $_FILES ['foto_perfil'];

		
		$db = JFactory::getDbo ();
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(JRequest::getVar('dataAniversarioConvertida')->format('Y-m-d'));
		}
		

		
		
		if (isset($usuario)  && $usuario->id != 0) {// UPDATE
			$usuario = JFactory::getUser();
			$query = $db->getQuery ( true );
			$query->update ( $db->quoteName ( '#__angelgirls_visitante' ) )->set ( array (
					$db->quoteName ( 'data_alterado' ) . ' = NOW() ',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $usuario->id,
					$db->quoteName ( 'apelido' ) . ' = ' . $db->quote($nomeArtistico),
					$db->quoteName ( 'sobre' ) . ' = ' . $db->quote($descricao),
					$db->quoteName ( 'meta_descricao' ) . ' = ' . $db->quote($metaDescricao),
					$db->quoteName ( 'profissao' ) . ' = ' . ($profissao == null ? ' null ' : $db->quote($profissao)),
					$db->quoteName ( 'nascionalidade' ) . ' = ' . ($nascionalidade == null ? ' null ' : $db->quote($nascionalidade)),
					$db->quoteName ( 'id_cidade_nasceu' ) . ' = ' . ($idCidadeNasceu == null ? ' null ' : $db->quote($idCidadeNasceu)),
					$db->quoteName ( 'data_nascimento' ) . ' = ' . $dataNascimento,
					$db->quoteName ( 'site' ) . ' = ' . ($site == null ? ' null ' : $db->quote($site)),
					$db->quoteName ( 'sexo' ) . ' = ' . ($sexo == null ? ' null ' : $db->quote($sexo)),
					$db->quoteName ( 'cpf' ) . ' = ' . ($cpf == null ? ' null ' : $db->quote($cpf)),
					$db->quoteName ( 'banco' ) . ' = ' . ($banco == null ? ' null ' : $db->quote($banco)),
					$db->quoteName ( 'agencia' ) . ' = ' . ($agencia == null ? ' null ' : $db->quote($agencia)),
					$db->quoteName ( 'conta' ) . ' = ' . ($conta == null ? ' null ' : $db->quote($conta)),
					$db->quoteName ( 'custo_medio_diaria' ) . ' = ' . ($custoMedioDiaria == null ? ' null ' : $db->quote($custoMedioDiaria)),
					$db->quoteName ( 'qualificao_equipe' ) . ' = ' . ($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
					$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade))
			))
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );
			$db->execute ();
		} else {
				$query = $db->getQuery ( true );
				$query->insert( $db->quoteName ( '#__angelgirls_visitante' ) )->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'apelido' ),
					$db->quoteName ( 'sobre' ),
					$db->quoteName ( 'meta_descricao' ),
					$db->quoteName ( 'profissao' ),
					$db->quoteName ( 'nascionalidade' ),
					$db->quoteName ( 'id_cidade_nasceu' ),
					$db->quoteName ( 'data_nascimento' ),
					$db->quoteName ( 'site' ),
					$db->quoteName ( 'sexo' ),
					$db->quoteName ( 'cpf' ),
					$db->quoteName ( 'banco' ),
					$db->quoteName ( 'agencia' ),
					$db->quoteName ( 'conta' ),
					$db->quoteName ( 'custo_medio_diaria' ),
					$db->quoteName ( 'qualificao_equipe' ),
					$db->quoteName ( 'id_cidade' )))
				->values ( implode ( ',', array (
					'\'NOVO\'',
					'NOW()',
					$usuario->id,
					'NOW()',
					$usuario->id,
					$usuario->id,
					$db->quote($nomeArtistico),
					$db->quote($descricao),
					$db->quote($metaDescricao),
					(isset($profissao) == null ? ' null ' : $db->quote($profissao)),
					(isset($nascionalidade) == null ? ' null ' : $db->quote($nascionalidade)),
					(isset($idCidadeNasceu) == null ? ' null ' : $db->quote($idCidadeNasceu)),
					$dataFormatadaBanco,
					(isset($site) == null ? ' null ' : $db->quote($site)),
					(isset($sexo) == null ? ' null ' : $db->quote($sexo)),
					(isset($cpf) == null ? ' null ' : $db->quote($cpf)),
					(isset($banco) == null ? ' null ' : $db->quote($banco)),
					(isset($agencia) == null ? ' null ' : $db->quote($agencia)),
					(isset($conta) == null ? ' null ' : $db->quote($conta)),
					(isset($custoMedioDiaria) == null ? ' null ' : $db->quote($custoMedioDiaria)),
					(isset($qualificaoEquipe) == null ? ' null ' : $db->quote($qualificaoEquipe)),
					(isset($idCidade) == null ? ' null ' : $db->quote($idCidade))
				)));
				$db->setQuery( $query );
				$db->execute();
				$id = $db->insertid();
				
				$query = $db->getQuery ( true );
				$query->insert( $db->quoteName ( '#__angelgirls_email' ) )
					->columns ( array (
						$db->quoteName ( 'status_dado' ),
						$db->quoteName ( 'data_criado' ),
						$db->quoteName ( 'id_usuario_criador' ),
						$db->quoteName ( 'data_alterado' ),
						$db->quoteName ( 'id_usuario_alterador' ),
						$db->quoteName ( 'id_usuario' ),
						$db->quoteName ( 'principal' ),
						$db->quoteName ( 'email' ),
						$db->quoteName ( 'ordem' )))
					->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$usuario->id,
							'NOW()',
							$usuario->id,
							$usuario->id,
							$db->quote('S'),
							$db->quote($email),
							'0')));
				$db->setQuery( $query );
				$db->execute();
				
				
				$query = $db->getQuery ( true );
				$query->insert( $db->quoteName ( '#__angelgirls_telefone' ) )
				->columns ( array (
						$db->quoteName ( 'status_dado' ),
						$db->quoteName ( 'data_criado' ),
						$db->quoteName ( 'id_usuario_criador' ),
						$db->quoteName ( 'data_alterado' ),
						$db->quoteName ( 'id_usuario_alterador' ),
						$db->quoteName ( 'id_usuario' ),
						$db->quoteName ( 'tipo' ),
						$db->quoteName ( 'principal' ),
						$db->quoteName ( 'ddd' ),
						$db->quoteName ( 'telefone' ),
						$db->quoteName ( 'ordem' )))
				->values ( implode ( ',', array (
								'\'NOVO\'',
								'NOW()',
								$usuario->id,
								'NOW()',
								$usuario->id,
								$usuario->id,
								$db->quote(strlen($telefone) > 14 ? 'CELULAR': 'OUTRO'),
								$db->quote('S'),
								$db->quote(substr($telefone,1,2)),
								$db->quote(substr($telefone,5)),
								
						'0')));
				$db->setQuery( $query );
				$db->execute();
		}

		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
			$fileTemp = $foto_perfil ['tmp_name'];
			$newFileName = $this->GerarNovoNomeArquivo($fileName, $id . '_prfl');
			$newfile = PATH_IMAGEM_VISITANTES . $newFileName;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload ( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			} else {
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_visitante' ) )->set ( array (
						$db->quoteName ( 'nome_foto' ) . ' = ' . $db->quote ( $newFileName )
				) )->where ( array (
						$db->quoteName ( 'id' ) . ' = ' . $id
				) );
				$db->setQuery ( $query );
				$db->execute ();
			}
		}
		return true;
	}
	
	
	private function salvarFotografo($usuario){
		$sucesso=true;
		
		$erro = false;
		
		$id =  $usuario->id;
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$email = JRequest::getString ( 'email', null, 'POST' );
		$username = JRequest::getString ( 'username', null, 'POST' );
		$password = JRequest::getString ( 'password', null, 'POST' );
		$telefone = JRequest::getString ( 'telefone', null, 'POST' );
		$name = JRequest::getString ( 'name', null, 'POST' );
		$descricao = JRequest::getString ( 'descricao', null, 'POST' );
		$metaDescricao = JRequest::getString ( 'meta_descricao', null, 'POST' );
		$nomeArtistico = JRequest::getString ( 'nome_artistico', null, 'POST' );
		$profissao = JRequest::getString ( 'profissao', null, 'POST' );
		$nascionalidade = JRequest::getString ( 'nascionalidade', '', 'POST' );
		$idCidadeNasceu = JRequest::getInt ( 'id_cidade_nasceu', null, 'POST' );
		$dataNascimento = JRequest::getString ( 'data_nascimento', null, 'POST' );
		$site = JRequest::getString ( 'site', null, 'POST' );
		$sexo = JRequest::getString ( 'sexo', null, 'POST' );
		$cpf = JRequest::getString ( 'cpf', null, 'POST' );
		$banco = JRequest::getString ( 'banco', null, 'POST' );
		$agencia = JRequest::getString ( 'agencia', null, 'POST' );
		$conta = JRequest::getString ( 'conta', null, 'POST' );
		$custoMedioDiaria = JRequest::getString ( 'custo_medio_diaria', null, 'POST' );
		
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$dataFormatadaBanco = 'null';

		$foto_perfil = $_FILES ['foto_perfil'];

		
		$db = JFactory::getDbo ();
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(JRequest::getVar('dataAniversarioConvertida')->format('Y-m-d'));
		}
		
		if (isset($usuario) && $usuario->id != 0) { // UPDATE
			$query = $db->getQuery ( true );
			$query->update ( $db->quoteName ( '#__angelgirls_fotografo' ) )->set ( array (
					$db->quoteName ( 'data_alterado' ) . ' = NOW() ',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $usuario->id,
					$db->quoteName ( 'nome_artistico' ) . ' = ' . $db->quote($nomeArtistico),
					$db->quoteName ( 'descricao' ) . ' = ' . $db->quote($descricao),
					$db->quoteName ( 'meta_descricao' ) . ' = ' . $db->quote($metaDescricao),
					$db->quoteName ( 'profissao' ) . ' = ' . ($profissao == null ? ' null ' : $db->quote($profissao)),
					$db->quoteName ( 'nascionalidade' ) . ' = ' . ($nascionalidade == null ? ' null ' : $db->quote($nascionalidade)),
					$db->quoteName ( 'id_cidade_nasceu' ) . ' = ' . ($idCidadeNasceu == null ? ' null ' : $db->quote($idCidadeNasceu)),
					$db->quoteName ( 'data_nascimento' ) . ' = ' . $dataFormatadaBanco,
					$db->quoteName ( 'site' ) . ' = ' . ($site == null ? ' null ' : $db->quote($site)),
					$db->quoteName ( 'sexo' ) . ' = ' . ($sexo == null ? ' null ' : $db->quote($sexo)),
					$db->quoteName ( 'cpf' ) . ' = ' . ($cpf == null ? ' null ' : $db->quote($cpf)),
					$db->quoteName ( 'banco' ) . ' = ' . ($banco == null ? ' null ' : $db->quote($banco)),
					$db->quoteName ( 'agencia' ) . ' = ' . ($agencia == null ? ' null ' : $db->quote($agencia)),
					$db->quoteName ( 'conta' ) . ' = ' . ($conta == null ? ' null ' : $db->quote($conta)),
					$db->quoteName ( 'custo_medio_diaria' ) . ' = ' . ($custoMedioDiaria == null ? ' null ' : $db->quote($custoMedioDiaria)),
					$db->quoteName ( 'qualificao_equipe' ) . ' = ' . ($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
					$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade))
			))
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );
			$db->execute ();
		} else {
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_fotografo' ) )->columns ( array (
				$db->quoteName ( 'status_dado' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'id_usuario' ),
				$db->quoteName ( 'nome_artistico' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'profissao' ),
				$db->quoteName ( 'nascionalidade' ),
				$db->quoteName ( 'id_cidade_nasceu' ),
				$db->quoteName ( 'data_nascimento' ),
				$db->quoteName ( 'site' ),
				$db->quoteName ( 'sexo' ),
				$db->quoteName ( 'cpf' ),
				$db->quoteName ( 'banco' ),
				$db->quoteName ( 'agencia' ),
				$db->quoteName ( 'conta' ),
				$db->quoteName ( 'custo_medio_diaria' ),
				$db->quoteName ( 'qualificao_equipe' ),
				$db->quoteName ( 'id_cidade' )))
			->values ( implode ( ',', array (
				'\'NOVO\'',
				'NOW()',
				$usuario->id,
				'NOW()',
				$usuario->id,
				$usuario->id,
				$db->quote($nomeArtistico),
				$db->quote($descricao),
				$db->quote($metaDescricao),
				($profissao == null ? ' null ' : $db->quote($profissao)),
				($nascionalidade == null ? ' null ' : $db->quote($nascionalidade)),
				($idCidadeNasceu == null ? ' null ' : $db->quote($idCidadeNasceu)),
				$dataFormatadaBanco,
				($site == null ? ' null ' : $db->quote($site)),
				($sexo == null ? ' null ' : $db->quote($sexo)),
				($cpf == null ? ' null ' : $db->quote($cpf)),
				($banco == null ? ' null ' : $db->quote($banco)),
				($agencia == null ? ' null ' : $db->quote($agencia)),
				($conta == null ? ' null ' : $db->quote($conta)),
				($custoMedioDiaria == null ? ' null ' : $db->quote($custoMedioDiaria)),
				($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
				($idCidade == null ? ' null ' : $db->quote($idCidade))
			)));
			$db->setQuery( $query );
			$db->execute();
			$id = $db->insertid();
			
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_email' ) )
				->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'principal' ),
					$db->quoteName ( 'email' ),
					$db->quoteName ( 'ordem' )))
				->values ( implode ( ',', array (
						'\'NOVO\'',
						'NOW()',
						$usuario->id,
						'NOW()',
						$usuario->id,
						$usuario->id,
						$db->quote('S'),
						$db->quote($email),
						'0')));
			$db->setQuery( $query );
			$db->execute();
			
			
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_telefone' ) )
			->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'tipo' ),
					$db->quoteName ( 'principal' ),
					$db->quoteName ( 'ddd' ),
					$db->quoteName ( 'telefone' ),
					$db->quoteName ( 'ordem' )))
			->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$usuario->id,
							'NOW()',
							$usuario->id,
							$usuario->id,
							$db->quote(strlen($telefone) > 14 ? 'CELULAR': 'OUTRO'),
							$db->quote('S'),
							$db->quote(substr($telefone,1,2)),
							$db->quote(substr($telefone,5)),
							
					'0')));
			$db->setQuery( $query );
			$db->execute();
		}
		

		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
				
			$fileTemp = $foto_perfil ['tmp_name'];
			$newFileName = $this->GerarNovoNomeArquivo($fileName, $id . '_prfl');
			$newfile = PATH_IMAGEM_FOTOGRAFOS . $newFileName;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload ( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			} else {
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_fotografo' ) )->set ( array (
						$db->quoteName ( 'nome_foto' ) . ' = ' . $db->quote ( $newFileName )
				) )->where ( array (
						$db->quoteName ( 'id' ) . ' = ' . $id
				) );
				$db->setQuery ( $query );
				$db->execute ();
			}
		}

		return true;
	}
	
	/**
	 * Validar antes de salvar perfil.
	 */
	public function salvarPerfil(){
		if(!JSession::checkToken('post')) die ('Restricted access');
		$user = JFactory::getUser();
		$sucesso=true;
		$erro = false;
	
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		
		$email = JRequest::getString ( 'email', null, 'POST' );
		$username = JRequest::getString ( 'username', null, 'POST' );
		$password = JRequest::getString ( 'password', null, 'POST' );
		$telefone = JRequest::getString ( 'telefone', null, 'POST' );
		$name = JRequest::getString ( 'name', null, 'POST' );
		$descricao = JRequest::getString ( 'descricao', null, 'POST' );
		$metaDescricao = JRequest::getString ( 'meta_descricao', null, 'POST' );
		$nomeArtistico = JRequest::getString ( 'nome_artistico', null, 'POST' );
		$altura = JRequest::getFloat ( 'altura', null, 'POST' );
		$peso = JRequest::getFloat ( 'peso', null, 'POST' );
		$busto = JRequest::getFloat ( 'busto', null, 'POST' );
		$calsa = JRequest::getInt ( 'calsa', null, 'POST' );
		$calsado = JRequest::getInt ( 'calsado', null, 'POST' );
		$olhos = JRequest::getString ( 'olhos', null, 'POST' );
		$pele = JRequest::getString ( 'pele', null, 'POST' );
		$etinia = JRequest::getString ( 'etinia', null, 'POST' );
		$cabelo = JRequest::getString ( 'cabelo', null, 'POST' );
		$tamanhoCabelo = JRequest::getString ( 'tamanho_cabelo', null, 'POST' );
		$corCabelo = JRequest::getString ( 'cor_cabelo', null, 'POST' );
		$outraCorCabelo = JRequest::getString ( 'outra_cor_cabelo', null, 'POST' );
		$profissao = JRequest::getString ( 'profissao', null, 'POST' );
		$nascionalidade = JRequest::getString ( 'nascionalidade', '', 'POST' );
		$idCidadeNasceu = JRequest::getInt ( 'id_cidade_nasceu', null, 'POST' );
		$dataNascimento = JRequest::getString ( 'data_nascimento', null, 'POST' );
		$site = JRequest::getString ( 'site', null, 'POST' );
		$sexo = JRequest::getString ( 'sexo', null, 'POST' );
		$cpf = JRequest::getString ( 'cpf', null, 'POST' );
		$banco = JRequest::getString ( 'banco', null, 'POST' );
		$agencia = JRequest::getString ( 'agencia', null, 'POST' );
		$conta = JRequest::getString ( 'conta', null, 'POST' );
		$custoMedioDiaria = JRequest::getString ( 'custo_medio_diaria', null, 'POST' );
		$statusModelo = JRequest::getString ( 'status_modelo', null, 'POST' );
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$tipo = JRequest::getString( 'tipo', 'VISITANTE', 'POST' );
		$dataFormatadaBanco = 'null';
	
		$db = JFactory::getDbo ();
		$dataObjetoNascimento =null;

		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataObjetoNascimento = DateTime::createFromFormat('d/m/Y H:i:s', $dataNascimento.' 00:00:00');
			JRequest::setVar('dataAniversarioConvertida', $dataObjetoNascimento);
			$dataFormatadaBanco= $db->quote($dataObjetoNascimento->format('Y-m-d'));
		}
		$erro =false;
	

	
		$cpfValidar = strtolower(trim(str_replace("-","",str_replace(".","",$cpf))));
		
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`')
		->from ( $db->quoteName ( '#__angelgirls_'.strtolower($tipo), 'f' ) );
		if(isset($user) && $user->id!=0){
			$query->where (' id_usuario <> ' . $user->id);
		}
		$query->where (' REPLACE(REPLACE('. $db->quoteName ( 'f.cpf' ) . ",'.',''),'-','') = " . $db->quote($cpfValidar) );
		if ($id != null && $id != 0) {
			$query->where (' id <> ' .$id );
		}
		$db->setQuery ( $query );
		$objeto = $db->loadObject();
	
		if(isset($objeto) && isset($objeto->id)){
			$erro =true;
			JError::raiseWarning( 100, 'CPF j&aacute; cadastrado.' );
		}
		
	
		if(!isset($user) || $user->id==0){
			if(!isset($email)){
				$erro =true;
				JError::raiseWarning( 100, 'E-mail &eacute; um campo obrigat&oacute;rio.' );
			}
			if(isset($email) && strpos($email, '@' )===false){
				$erro =true;
				JError::raiseWarning( 100, 'E-mail &eacute; um campo obrigat&oacute;rio. Insira um e-mail v&aacute;lido.' );
			}
			if(!isset($username) || strlen(trim($username))<5){
				$erro =true;
				JError::raiseWarning( 100, 'Usu&aacute;rio &eacute; um campo obrigat&oacute;rio. Deve conter no minimo 5 digitos.' );
			}
			if($this->existeUsuario($username)){
				$erro =true;
				JError::raiseWarning( 100, 'O usu&aacute;rio j&aacute; está cadastrado.' );
			}
			if(!isset($password)  || strlen(trim($password))<8){
				$erro =true;
				JError::raiseWarning( 100, 'Senha &eacute; um campo obrigat&oacute;rio. E deve conter no minimo 8 digitos.' );
			}
			if(!isset($telefone)  || strlen(trim($telefone))<14){
				$erro =true;
				JError::raiseWarning( 100, 'Telefone &eacute; um campo obrigat&oacute;rio. E deve conter no minimo 14 digitos com o DDD.' );
			}
		}
	
		if(!isset($name)  || strlen(trim($name))<=0){
			$erro =true;
			JError::raiseWarning( 100, 'Nome completo &eacute; um campo obrigat&oacute;rio. E deve conter no minimo 14 digitos com o DDD.' );
		}
	
		
		if(!isset($cpf)  || strlen(trim($cpf)) < 14 || !$this->validaCPF($cpfValidar)){
			$erro =true;
			JError::raiseWarning( 100, 'CPF &eacute; um campo obrigat&oacute;rio. E deve conter no minimo 14 digitos ser v&aacute;lido e com a formata&ccedil;&atilde;o.' );
		}
	
		if(!isset($sexo)  || strlen(trim($sexo))<=0 || ($sexo!='F' && $sexo!='M')){
			$erro =true;
			JError::raiseWarning( 100, 'Sexo &eacute; um campo obrigat&oacute;rio.' );
		}
	
		
		
		if(!isset($dataNascimento)  || strlen(trim($dataNascimento))<10){
			$erro =true;
			JError::raiseWarning( 100, 'Sexo &eacute; um campo obrigat&oacute;rio. E deve estar no formato DD/MM/AAAA (EX: 21/04/1983).' );
		}
		elseif(isset($dataObjetoNascimento)){
			$dataFormatadaBanco = intval($dataObjetoNascimento->format('Ymd'));
			$dataHoje = intval(date('Ymd'));
			if(($dataFormatadaBanco + 180000)>$dataHoje){
				$erro =true;
				JError::raiseWarning( 100, 'Cadastro n&ailte;o permitido para menores de idade.' );
			}
		}
		if(!isset($idCidade) || $idCidade==0){
			$erro =true;
			JError::raiseWarning( 100, 'Cidade que mora &eacute; um campo obrigat&oacute;rio.' );
		}
		if($tipo=='MODELO'){
			if(!isset($altura)){
				$erro =true;
				JError::raiseWarning( 100, 'Altura &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($peso)){
				$erro =true;
				JError::raiseWarning( 100, 'Peso &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($busto)){
				$erro =true;
				JError::raiseWarning( 100, 'Busto &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($busto)){
				$erro =true;
				JError::raiseWarning( 100, 'Peso &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($calsa)){
				$erro =true;
				JError::raiseWarning( 100, 'Calsa &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($calsado)){
				$erro =true;
				JError::raiseWarning( 100, 'Calsado &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($olhos)){
				$erro =true;
				JError::raiseWarning( 100, 'Olhos &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($pele)){
				$erro =true;
				JError::raiseWarning( 100, 'Tom de pele &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($etinia)){
				$erro =true;
				JError::raiseWarning( 100, 'Etinia &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($cabelo)){
				$erro =true;
				JError::raiseWarning( 100, 'Tipo de cabelo &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($tamanhoCabelo)){
				$erro =true;
				JError::raiseWarning( 100, 'Tamanho do cabelo &eacute; um campo obrigat&oacute;rio.' );
			}
			if(!isset($corCabelo)){
				$erro =true;
				JError::raiseWarning( 100, 'Cor do cabelo &eacute; um campo obrigat&oacute;rio.' );
			}
		}
		if(!isset($idCidadeNasceu)){

			$erro =true;
			JError::raiseWarning( 100, 'Cidade que nasceu &eacute; um campo obrigat&oacute;rio.' );
		}
		$usuario=null;
		if($erro){
			if(isset($user) && $user->id != 0){
				$this->carregarPerfil();
			}
			else{
				if($tipo=='MODELO'){
					$this->cadastroModelo();
				}
				elseif($tipo=='FOTOGRAFO'){
					$this->cadastroFotografo();
				}
				else{
					$this->cadastroVisitante();
				}
			}
			return;
		}
		else{
			$usuario = $this->salvarUsuario($tipo);
			if(!(isset($usuario) && isset($usuario->id) && $usuario->id != 0)){
				JError::raiseWarning( 100, 'Falha no cadastro.' );
				if($tipo=='MODELO'){
					$this->cadastroModelo();
				}
				elseif($tipo=='FOTOGRAFO'){
					$this->cadastroFotografo();
				}
				else{
					$this->cadastroVisitante();
				}
				return;
			}
		}
		if($tipo=='MODELO'){
			if(!$this->salvarModelo($usuario)){
				$this->cadastroModelo();
				return;
			}
		}
		elseif($tipo=='FOTOGRAFO'){
			if(!$this->salvarFotografo($usuario)){
				$this->cadastroFotografo();
				return;
			}
		}
		else{
			if(!$this->salvarVisitante($usuario)){
				$this->cadastroVisitante();
				return;
			}
		}
		
		$this->carregarPerfil();
	}
	
	
	public function buscarModeloModal(){
		$nome = JRequest::getString('nome',null);
		$idCidade  = JRequest::getInt('id_cidade',null);
		$estado  = JRequest::getInt('estado',null);
		
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`data_nascimento`,
			`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`, `f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,
   			`f`.`altura`,  `f`.`peso`,
   			`f`.`busto`,  `f`.`calsa`,  `f`.`calsado`, `f`.`olhos`,  `f`.`pele`,  `f`.`etinia`,  `f`.`cabelo`,  `f`.`tamanho_cabelo`, `f`.`cor_cabelo`,  `f`.`outra_cor_cabelo`,
			`cnasceu`.`uf` as `estado_nasceu`, `cnasceu`.`nome` as `cidade_nasceu`,
			`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`')
			->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
			->join ( 'INNER', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
			->join ( 'INNER', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
			->join ( 'INNER', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'));
		if(isset($nome) && strlen(trim($nome))>=3 ){
			$nomeFormatado = $db->quote(trim(strtoupper($nome)).'%');
			if(isset($idCidade) && $idCidade!="" && $idCidade>0){
				$query->where ( 'cvive.id =  ' . $idCidade);
			}
			if(isset($estado) && $estado!="" ){
				$query->where ( 'cvive.uf =  ' . $db->quote(trim($estado)));
			}
			$query->where('(upper(trim(f.nome_artistico)) like ' .$nomeFormatado .' OR upper(trim(u.name)) like ' .$nomeFormatado .')');
			
		}
		else{
			JRequest::setVar('mensagens','Para realizar a busca deve digita pelo menos ');
		}
		$query->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
		->where ( $db->quoteName ( 'f.status_modelo' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
		->order('f.nome_artistico')
		->limit(100);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar('modelos',$result);
		
		JRequest::setVar('ufs',$this->getUFs());
		

		require_once 'views/modelo/tmpl/selecionar_modelo.php';
		exit();
	}
	
	private function salvarModelo($usuario){
		

		$sucesso=true;
		
		
		$erro = false;
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$id = explode(':',$id)[0];
		}
		$email = JRequest::getString ( 'email', null, 'POST' );
		$username = JRequest::getString ( 'username', null, 'POST' );
		$password = JRequest::getString ( 'password', null, 'POST' );
		$telefone = JRequest::getString ( 'telefone', null, 'POST' );
		$name = JRequest::getString ( 'name', null, 'POST' );
		$descricao = JRequest::getString ( 'descricao', null, 'POST' );
		$metaDescricao = JRequest::getString ( 'meta_descricao', null, 'POST' );
		$nomeArtistico = JRequest::getString ( 'nome_artistico', null, 'POST' );
		$altura = JRequest::getFloat ( 'altura', null, 'POST' );
		$peso = JRequest::getFloat ( 'peso', null, 'POST' );
		$busto = JRequest::getFloat ( 'busto', null, 'POST' );
		$calsa = JRequest::getInt ( 'calsa', null, 'POST' );
		$calsado = JRequest::getInt ( 'calsado', null, 'POST' );
		$olhos = JRequest::getString ( 'olhos', null, 'POST' );
		$pele = JRequest::getString ( 'pele', null, 'POST' );
		$etinia = JRequest::getString ( 'etinia', null, 'POST' );
		$cabelo = JRequest::getString ( 'cabelo', null, 'POST' );
		$tamanhoCabelo = JRequest::getString ( 'tamanho_cabelo', null, 'POST' );
		$corCabelo = JRequest::getString ( 'cor_cabelo', null, 'POST' );
		$outraCorCabelo = JRequest::getString ( 'outra_cor_cabelo', null, 'POST' );
		$profissao = JRequest::getString ( 'profissao', null, 'POST' );
		$nascionalidade = JRequest::getString ( 'nascionalidade', '', 'POST' );
		$idCidadeNasceu = JRequest::getInt ( 'id_cidade_nasceu', null, 'POST' );
		$dataNascimento = JRequest::getString ( 'data_nascimento', null, 'POST' );
		$site = JRequest::getString ( 'site', null, 'POST' );
		$sexo = JRequest::getString ( 'sexo', null, 'POST' );
		$cpf = JRequest::getString ( 'cpf', null, 'POST' );
		$banco = JRequest::getString ( 'banco', null, 'POST' );
		$agencia = JRequest::getString ( 'agencia', null, 'POST' );
		$conta = JRequest::getString ( 'conta', null, 'POST' );
		$custoMedioDiaria = JRequest::getString ( 'custo_medio_diaria', null, 'POST' );
		$statusModelo = JRequest::getString ( 'status_modelo', null, 'POST' );
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$dataFormatadaBanco = 'null';

		
		
		$foto_perfil = $_FILES ['foto_perfil'];
		$foto_inteira = $_FILES ['foto_inteira'];
		$foto_inteira_horizontal = $_FILES ['foto_inteira_horizontal'];
		
		$db = JFactory::getDbo ();
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(JRequest::getVar('dataAniversarioConvertida')->format('Y-m-d'));
		}
		

		if (isset($usuario) && $usuario->id != 0) { // UPDATE
			$query = $db->getQuery ( true );
			$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
					$db->quoteName ( 'data_alterado' ) . ' = NOW() ',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $usuario->id,
					$db->quoteName ( 'nome_artistico' ) . ' = ' . $db->quote($nomeArtistico),
					$db->quoteName ( 'descricao' ) . ' = ' . $db->quote($descricao),
					$db->quoteName ( 'meta_descricao' ) . ' = ' . $db->quote($metaDescricao),
					$db->quoteName ( 'altura' ) . ' = ' . ($altura == null ? ' null ' : $db->quote($altura)),
					$db->quoteName ( 'peso' ) . ' = ' . ($peso == null ? ' null ' : $db->quote($peso)),
					$db->quoteName ( 'busto' ) . ' = ' . ($busto == null ? ' null ' : $db->quote($busto)),
					$db->quoteName ( 'calsa' ) . ' = ' . ($calsa == null ? ' null ' : $db->quote($calsa)),
					$db->quoteName ( 'calsado' ) . ' = ' . ($calsado == null ? ' null ' : $db->quote($calsado)),
					$db->quoteName ( 'olhos' ) . ' = ' . ($olhos == null ? ' null ' : $db->quote($olhos)),
					$db->quoteName ( 'pele' ) . ' = ' . ($pele == null ? ' null ' : $db->quote($pele)),
					$db->quoteName ( 'etinia' ) . ' = ' . ($etinia == null ? ' null ' : $db->quote($etinia)),
					$db->quoteName ( 'cabelo' ) . ' = ' . ($cabelo == null ? ' null ' : $db->quote($cabelo)),
					$db->quoteName ( 'tamanho_cabelo' ) . ' = ' . ($tamanhoCabelo == null ? ' null ' : $db->quote($tamanhoCabelo)),
					$db->quoteName ( 'cor_cabelo' ) . ' = ' . ($corCabelo == null ? ' null ' : $db->quote($corCabelo)),
					$db->quoteName ( 'outra_cor_cabelo' ) . ' = ' . ($outraCorCabelo == null ? ' null ' : $db->quote($outraCorCabelo)),
					$db->quoteName ( 'profissao' ) . ' = ' . ($profissao == null ? ' null ' : $db->quote($profissao)),
					$db->quoteName ( 'nascionalidade' ) . ' = ' . ($nascionalidade == null ? ' null ' : $db->quote($nascionalidade)),
					$db->quoteName ( 'id_cidade_nasceu' ) . ' = ' . ($idCidadeNasceu == null ? ' null ' : $db->quote($idCidadeNasceu)),
					$db->quoteName ( 'data_nascimento' ) . ' = ' . $dataFormatadaBanco,
					$db->quoteName ( 'site' ) . ' = ' . ($site == null ? ' null ' : $db->quote($site)),
					$db->quoteName ( 'sexo' ) . ' = ' . ($sexo == null ? ' null ' : $db->quote($sexo)),
					$db->quoteName ( 'cpf' ) . ' = ' . ($cpf == null ? ' null ' : $db->quote($cpf)),
					$db->quoteName ( 'banco' ) . ' = ' . ($banco == null ? ' null ' : $db->quote($banco)),
					$db->quoteName ( 'agencia' ) . ' = ' . ($agencia == null ? ' null ' : $db->quote($agencia)),
					$db->quoteName ( 'conta' ) . ' = ' . ($conta == null ? ' null ' : $db->quote($conta)),
					$db->quoteName ( 'custo_medio_diaria' ) . ' = ' . ($custoMedioDiaria == null ? ' null ' : $db->quote($custoMedioDiaria)),
					$db->quoteName ( 'status_modelo' ) . ' = ' . ($statusModelo == null ? ' null ' : $db->quote($statusModelo)),
					$db->quoteName ( 'qualificao_equipe' ) . ' = ' . ($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
					$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade))
			))
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );

			$db->execute ();
		} else {
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_modelo' ) )->columns ( array (
				$db->quoteName ( 'status_dado' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'id_usuario' ),
				$db->quoteName ( 'nome_artistico' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'altura' ),
				$db->quoteName ( 'peso' ),
				$db->quoteName ( 'busto' ),
				$db->quoteName ( 'calsa' ),
				$db->quoteName ( 'calsado' ),
				$db->quoteName ( 'olhos' ),
				$db->quoteName ( 'pele' ),
				$db->quoteName ( 'etinia' ),
				$db->quoteName ( 'cabelo' ),
				$db->quoteName ( 'tamanho_cabelo' ),
				$db->quoteName ( 'cor_cabelo' ),
				$db->quoteName ( 'outra_cor_cabelo' ),
				$db->quoteName ( 'profissao' ),
				$db->quoteName ( 'nascionalidade' ),
				$db->quoteName ( 'id_cidade_nasceu' ),
				$db->quoteName ( 'data_nascimento' ),
				$db->quoteName ( 'site' ),
				$db->quoteName ( 'sexo' ),
				$db->quoteName ( 'cpf' ),
				$db->quoteName ( 'banco' ),
				$db->quoteName ( 'agencia' ),
				$db->quoteName ( 'conta' ),
				$db->quoteName ( 'custo_medio_diaria' ),
				$db->quoteName ( 'status_modelo' ),
				$db->quoteName ( 'qualificao_equipe' ),
				$db->quoteName ( 'id_cidade' )))
			->values ( implode ( ',', array (
				'\'NOVO\'',
				'NOW()',
				$usuario->id,
				'NOW()',
				$usuario->id,
				$usuario->id,
				$db->quote($nomeArtistico),
				$db->quote($descricao),
				$db->quote($metaDescricao),
				($altura == null ? ' null ' : $db->quote($altura)),
				($peso == null ? ' null ' : $db->quote($peso)),
				($busto == null ? ' null ' : $db->quote($busto)),
				($calsa == null ? ' null ' : $db->quote($calsa)),
				($calsado == null ? ' null ' : $db->quote($calsado)),
				($olhos == null ? ' null ' : $db->quote($olhos)),
				($pele == null ? ' null ' : $db->quote($pele)),
				($etinia == null ? ' null ' : $db->quote($etinia)),
				($cabelo == null ? ' null ' : $db->quote($cabelo)),
				($tamanhoCabelo == null ? ' null ' : $db->quote($tamanhoCabelo)),
				($corCabelo == null ? ' null ' : $db->quote($corCabelo)),
				($outraCorCabelo == null ? ' null ' : $db->quote($outraCorCabelo)),
				($profissao == null ? ' null ' : $db->quote($profissao)),
				($nascionalidade == null ? ' null ' : $db->quote($nascionalidade)),
				($idCidadeNasceu == null ? ' null ' : $db->quote($idCidadeNasceu)),
				$dataFormatadaBanco,
				($site == null ? ' null ' : $db->quote($site)),
				($sexo == null ? ' null ' : $db->quote($sexo)),
				($cpf == null ? ' null ' : $db->quote($cpf)),
				($banco == null ? ' null ' : $db->quote($banco)),
				($agencia == null ? ' null ' : $db->quote($agencia)),
				($conta == null ? ' null ' : $db->quote($conta)),
				($custoMedioDiaria == null ? ' null ' : $db->quote($custoMedioDiaria)),
				($statusModelo == null ? ' null ' : $db->quote($statusModelo)),
				($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
				($idCidade == null ? ' null ' : $db->quote($idCidade))
			)));
			$db->setQuery( $query );
			$db->execute();
			$id = $db->insertid();
			
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_email' ) )
				->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'principal' ),
					$db->quoteName ( 'email' ),
					$db->quoteName ( 'ordem' )))
				->values ( implode ( ',', array (
						'\'NOVO\'',
						'NOW()',
						$usuario->id,
						'NOW()',
						$usuario->id,
						$usuario->id,
						$db->quote('S'),
						$db->quote($email),
						'0')));
			$db->setQuery( $query );
			$db->execute();
			
			
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_telefone' ) )
			->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'tipo' ),
					$db->quoteName ( 'principal' ),
					$db->quoteName ( 'ddd' ),
					$db->quoteName ( 'telefone' ),
					$db->quoteName ( 'ordem' )))
			->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$usuario->id,
							'NOW()',
							$usuario->id,
							$usuario->id,
							$db->quote(strlen($telefone) > 14 ? 'CELULAR': 'OUTRO'),
							$db->quote('S'),
							$db->quote(substr($telefone,1,2)),
							$db->quote(substr($telefone,5)),
							
					'0')));
			$db->setQuery( $query );
			$db->execute();
		}
		

		if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
			$fileName = $foto_perfil ['name'];
			$uploadedFileNameParts = explode ( '.', $fileName );
			$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
				
			$fileTemp = $foto_perfil ['tmp_name'];
			$newFileName = $id . '_perfil.' . $uploadedFileExtension;
			$newfile = PATH_IMAGEM_MODELOS . $newFileName;
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload ( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			} else {
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
						$db->quoteName ( 'foto_perfil' ) . ' = ' . $db->quote ( $newFileName )
				) )->where ( array (
						$db->quoteName ( 'id' ) . ' = ' . $id
				) );
				$db->setQuery ( $query );
				$db->execute ();
			}
		}
		

		
		if (isset ( $foto_inteira ) && JFile::exists ( $foto_inteira ['tmp_name'] )) {
			$fileName = $foto_inteira ['name'];
			$uploadedFileNameParts = explode ( '.', $fileName );
			$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
		
			$fileTemp = $foto_inteira ['tmp_name'];
			$newFileName = $id . '_inteira.' . $uploadedFileExtension;
			$newfile = PATH_IMAGEM_MODELOS . $newFileName ;
		
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
		
			if (! JFile::upload ( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			} else {
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
						$db->quoteName ( 'foto_inteira' ) . ' = ' . $db->quote ($newFileName )
				) )->where ( array (
						$db->quoteName ( 'id' ) . ' = ' . $id
				) );
				$db->setQuery ( $query );
				$db->execute ();
			}
		}
		
		if (isset ( $foto_inteira_horizontal ) && JFile::exists ( $foto_inteira_horizontal ['tmp_name'] )) {
			$fileName = $foto_inteira_horizontal['name'];
			$uploadedFileNameParts = explode ( '.', $fileName );
			$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
				
			$fileTemp = $foto_inteira_horizontal['tmp_name'];
			$newFileName = $id . '_inteira_h.' . $uploadedFileExtension;
			$newfile = PATH_IMAGEM_MODELOS . $newFileName;
				
			if (JFolder::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
				
			if (! JFile::upload ( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			} else {
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
						$db->quoteName ( 'foto_inteira_horizontal' ) . ' = ' . $db->quote ( $newFileName )
				) )->where ( array (
						$db->quoteName ( 'id' ) . ' = ' . $id
				) );
				$db->setQuery ( $query );
				$db->execute ();
			}
		}
		
		return true;
	}
	
	/**
	 * Padr&atilde;o endere&ccedil;o
	 */
	public function padraoEnderecoJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_endereco' ))
				->set(array (
					$db->quoteName ( 'principal' ) . ' = ' . $db->quote('N'),
					$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
					$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
				->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if(!$db->execute()){
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_endereco' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	/**
	 * Remover Endereco
	 */
	public function removerEnderecoJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_endereco' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	/**
	 * Salvar o endereco via JSON
	 */
	public function salvarEnderecoJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
		
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$tipo = JRequest::getString ( 'tipo', null, 'POST' );
		$principal = '';
		$cep = JRequest::getString ( 'cep', null, 'POST' );
		$rua = JRequest::getString ( 'rua', null, 'POST' );
		$numero = JRequest::getString ( 'numero', null, 'POST' );
		$complemento = JRequest::getString ( 'complemento', null, 'POST' );
		$bairro = JRequest::getString ( 'bairro', null, 'POST' );
		$estado = JRequest::getString ( 'estado', null, 'POST' );
		$cidade = JRequest::getInt( 'cidade', null, 'POST' );
		$jsonRetorno="";

		$mensagensErro = "";
		
		if(!isset($rua)){
			$mensagensErro = $mensagensErro . "Rua &eacute; um campo obrigat&oacute;rio.<br/>"; 
		}
		if(!isset($cep) || strlen($cep)<8){
			$mensagensErro = $mensagensErro . "CEP &eacute; um campo obrigat&oacute;rio e deve estar no formato: 09999-000.<br/>";
		}
		if(!isset($cidade)){
			$mensagensErro = $mensagensErro . "Cidade &eacute; um campo obrigat&oacute;rio.<br/>";
		}
		if(!isset($estado)){
			$mensagensErro = $mensagensErro . "Estado &eacute; um campo obrigat&oacute;rio.<br/>";
		}
		if($mensagensErro==""){
			if(!isset($id) || $id==0){
				try {
					$principal='N';
					$ordem = 0;
					
					$query = $db->getQuery ( true );
					$query->select('max(end.`ordem`) AS total')
									->from ('#__angelgirls_endereco AS end')
									->where ( $db->quoteName ('end.id_usuario').' = ' . $user->id )
									->where ( $db->quoteName ('end.status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO));
					$db->setQuery ( $query );
					$result = $db->loadObject();
					

					if(!isset($result) || sizeof($result)<=0 || !isset($result->total)){
						$principal='S';
					}else{
						$ordem = $result->total+1;
					}
					
					$query = $db->getQuery ( true );
					$query->insert( $db->quoteName ( '#__angelgirls_endereco' ) )
					->columns (array (
							$db->quoteName ( 'tipo' ),
							$db->quoteName ( 'principal' ),
							$db->quoteName ( 'endereco' ),
							$db->quoteName ( 'numero' ),
							$db->quoteName ( 'bairro' ),
							$db->quoteName ( 'complemento' ),
							$db->quoteName ( 'cep' ),
							$db->quoteName ( 'id_cidade' ),
							$db->quoteName ( 'id_usuario' ),
							$db->quoteName ( 'status_dado' ),
							$db->quoteName ( 'id_usuario_criador' ),
							$db->quoteName ( 'id_usuario_alterador' ),
							$db->quoteName ( 'data_criado' ),
							$db->quoteName ( 'data_alterado' ),
							$db->quoteName ( 'ordem' )))
						->values(implode(',', array(
							$db->quote($tipo),
							$db->quote($principal),
							(isset($rua)?$db->quote($rua):'null'),
							(isset($numero)?$db->quote($numero):'null'),
							(isset($bairro)?$db->quote($bairro):'null'),
							(isset($complemento)?$db->quote($complemento):'null'),
							(isset($cep)?$db->quote($cep):'null'),
							(isset($cidade)?$cidade:'null'),
							$user->id,
							$db->quote(StatusDado::NOVO),
							$user->id, 
							$user->id, 'NOW()', 'NOW()',
								$ordem)));
		
							$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
			else{
				try {
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_endereco' ))
						->set(array (
							$db->quoteName ( 'tipo' ) . ' = ' . $db->quote($tipo),
							$db->quoteName ( 'endereco' ) . ' = ' . (isset($rua)?$db->quote($rua):'null'),
							$db->quoteName ( 'numero' ) . ' = ' . (isset($numero)?$db->quote($numero):'null'),
							$db->quoteName ( 'bairro' ) . ' = ' . (isset($bairro)?$db->quote($bairro):'null'),
							$db->quoteName ( 'complemento' ) . ' = ' . (isset($complemento)?$db->quote($complemento):'null'),
							$db->quoteName ( 'cep' ) . ' = ' . (isset($cep)?$db->quote($cep):'null'),
							$db->quoteName ( 'id_cidade' ) . ' = ' . (isset($cidade)?$cidade:'null'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
						$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"'.$mensagensErro.'"}';
		}
		
		
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function carregarEndereco(){
		JRequest::setVar ( 'enderecos', $this->getEnderecosPefil());
		require_once 'views/perfil/tmpl/enderecos.php';
		exit();
	}
	
/************************************* TELEFONES **********************************/
	
	/**
	 * Padr&atilde;o endere&ccedil;o
	 */
	public function padraoTelefoneJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_telefone' ))
				->set(array (
						$db->quoteName ( 'principal' ) . ' = ' . $db->quote('N'),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if(!$db->execute()){
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
	
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_telefone' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	/**
	 * Remover telefone
	 */
	public function removerTelefoneJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_telefone' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	/**
	 * Salvar o telefone via JSON
	 */
	public function salvarTelefoneJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$tipo = JRequest::getString ( 'tipo', null, 'POST' );
		$principal = '';
		$operadora = JRequest::getString ( 'operadora', null, 'POST' );
		$ddd = JRequest::getString ( 'ddd', null, 'POST' );
		$telefone = JRequest::getString ( 'telefone', null, 'POST' );



		
		
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(!isset($operadora)){
			$mensagensErro = $mensagensErro . "Operadora &eacute; um campo obrigat&oacute;rio.<br/>";
		}
		if(!isset($ddd) || strlen($ddd)<2){
			$mensagensErro = $mensagensErro . "DDD &eacute; um campo obrigat&oacute;rio e deve estar no formato: 11.<br/>";
		}
		if(!isset($telefone) || strlen($telefone)<8){
			$mensagensErro = $mensagensErro . "Telefone &eacute; um campo obrigat&oacute;rio e deve estar no formato: 09999-000.<br/>";
		}
		if($mensagensErro==""){
			if(!isset($id) || $id==0){
				try {
					$principal='N';
					$ordem = 0;
						
					$query = $db->getQuery ( true );
					$query->select('max(end.`ordem`) AS total')
					->from ('#__angelgirls_telefone AS end')
					->where ( $db->quoteName ('end.id_usuario').' = ' . $user->id )
					->where ( $db->quoteName ('end.status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO));
					$db->setQuery ( $query );
					$result = $db->loadObject();
						
	
					if(!isset($result) || sizeof($result)<=0 || !isset($result->total)){
						$principal='S';
					}else{
						$ordem = $result->total+1;
					}
						
					$query = $db->getQuery ( true );
					$query->insert( $db->quoteName ( '#__angelgirls_telefone' ) )
					->columns (array (
							$db->quoteName ( 'tipo' ),
							$db->quoteName ( 'principal' ),
							$db->quoteName ( 'operadora' ),
							$db->quoteName ( 'ddd' ),
							$db->quoteName ( 'telefone' ),
							$db->quoteName ( 'id_usuario' ),
							$db->quoteName ( 'status_dado' ),
							$db->quoteName ( 'id_usuario_criador' ),
							$db->quoteName ( 'id_usuario_alterador' ),
							$db->quoteName ( 'data_criado' ),
							$db->quoteName ( 'data_alterado' ),
							$db->quoteName ( 'ordem' )))
							->values(implode(',', array(
									$db->quote($tipo),
									$db->quote($principal),
									(isset($operadora)?$db->quote($operadora):'null'),
									(isset($ddd)?$db->quote($ddd):'null'),
									(isset($telefone)?$db->quote($telefone):'null'),
									$user->id,
									$db->quote(StatusDado::NOVO),
									$user->id,
									$user->id, 'NOW()', 'NOW()',
									$ordem)));
	
							$db->setQuery( $query );
							if($db->execute()){
								$jsonRetorno='{"ok":"ok", "menssagem":""}';
							}
							else{
								$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
							}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
			else{
				try {
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_telefone' ))
					->set(array (
							$db->quoteName ( 'tipo' ) . ' = ' . $db->quote($tipo),
							$db->quoteName ( 'operadora' ) . ' = ' . (isset($operadora)?$db->quote($operadora):'null'),
							$db->quoteName ( 'ddd' ) . ' = ' . (isset($ddd)?$db->quote($ddd):'null'),
							$db->quoteName ( 'telefone' ) . ' = ' . (isset($telefone)?$db->quote($telefone):'null'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"'.$mensagensErro.'"}';
		}
	
	
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function carregarTelefone(){
		JRequest::setVar ( 'telefones', $this->getTelefonesPefil());
		require_once 'views/perfil/tmpl/telefones.php';
		exit();
	}
	
	
/*************** EMAILS ********************************/
	/**
	 * Padr&atilde;o endere&ccedil;o
	 */
	public function padraoEmailJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_email' ))
				->set(array (
						$db->quoteName ( 'principal' ) . ' = ' . $db->quote('N'),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if(!$db->execute()){
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
	
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_email' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__users' ))
						->set(array (
							$db->quoteName ( 'email' ) . ' = (SELECT email FROM #__angelgirls_email WHERE id = '.$id.' )')) 
						->where ($db->quoteName ( 'id' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					$db->execute();
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	/**
	 * Remover email
	 */
	public function removerEmailJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_email' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	/**
	 * Salvar o email via JSON
	 */
	public function salvarEmailJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$tipo = JRequest::getString ( 'tipo', null, 'POST' );
		$principal = '';
		$email = JRequest::getString ( 'email', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	

		if(!isset($email) || strlen($email)<5){
			$mensagensErro = $mensagensErro . "E-mail &eacute; um campo obrigat&oacute;rio e deve estar no formato: email@dominio.com.<br/>";
		}
		if($mensagensErro==""){
			if(!isset($id) || $id==0){
				try {
					$principal='N';
					$ordem = 0;
						
					$query = $db->getQuery ( true );
					$query->select('max(end.`ordem`) AS total')
					->from ('#__angelgirls_email AS end')
					->where ( $db->quoteName ('end.id_usuario').' = ' . $user->id )
					->where ( $db->quoteName ('end.status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO));
					$db->setQuery ( $query );
					$result = $db->loadObject();
						
	
					if(!isset($result) || sizeof($result)<=0 || !isset($result->total)){
						$principal='S';
					}else{
						$ordem = $result->total+1;
					}
						
					$query = $db->getQuery ( true );
					$query->insert( $db->quoteName ( '#__angelgirls_email' ) )
					->columns (array (
							$db->quoteName ( 'principal' ),
							$db->quoteName ( 'email' ),
							$db->quoteName ( 'id_usuario' ),
							$db->quoteName ( 'status_dado' ),
							$db->quoteName ( 'id_usuario_criador' ),
							$db->quoteName ( 'id_usuario_alterador' ),
							$db->quoteName ( 'data_criado' ),
							$db->quoteName ( 'data_alterado' ),
							$db->quoteName ( 'ordem' )))
							->values(implode(',', array(
									$db->quote($principal),
									(isset($email)?$db->quote($email):'null'),
									$user->id,
									$db->quote(StatusDado::NOVO),
									$user->id,
									$user->id, 'NOW()', 'NOW()',
									$ordem)));
	
							$db->setQuery( $query );
							if($db->execute()){
								$jsonRetorno='{"ok":"ok", "menssagem":""}';
							}
							else{
								$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
							}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
			else{
				try {
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_email' ))
					->set(array (
							$db->quoteName ( 'email' ) . ' = ' . (isset($email)?$db->quote($email):'null'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"'.$mensagensErro.'"}';
		}
	
	
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function carregarEmail(){
		JRequest::setVar ( 'emails', $this->getEmailsPefil());
		require_once 'views/perfil/tmpl/emails.php';
		exit();
	}
	
/******************************** REDES SOCIAIS **************************************************/
	/**
	 * Padr&atilde;o endere&ccedil;o
	 */
	public function padraoRedeSocialJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_redesocial' ))
				->set(array (
						$db->quoteName ( 'principal' ) . ' = ' . $db->quote('N'),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if(!$db->execute()){
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
	
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_redesocial' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  '))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	/**
	 * Remover rede_social
	 */
	public function removerRedeSocialJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id' );
		$jsonRetorno="";
	
		$mensagensErro = "";


		if(isset($id) && $id!=0){
			try {
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_redesocial' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  '))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	/**
	 * Salvar o rede_social via JSON
	 */
	public function salvarRedeSocialJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery (true);
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$tipo = JRequest::getString ( 'tipo', null, 'POST' );
		$rede = JRequest::getString ( 'rede', null, 'POST' );
		$contato = JRequest::getString ( 'contato', null, 'POST' );


		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(!isset($rede)){
			$mensagensErro = $mensagensErro . "Rede Social um campo obrigat&oacute;rio.<br/>";
		}
		if(!isset($contato) || strlen($contato)<1){
			$mensagensErro = $mensagensErro . "Contato um campo obrigat&oacute;rio .<br/>";
		}

		if($mensagensErro==""){
			if(!isset($id) || $id==0){
				try {
					$principal='N';
					$ordem = 0;
						
					$query = $db->getQuery ( true );
					$query->select('max(end.`ordem`) AS total')
					->from ('#__angelgirls_redesocial AS end')
					->where ( $db->quoteName ('end.id_usuario').' = ' . $user->id )
					->where ( $db->quoteName ('end.status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO));
					$db->setQuery ( $query );
					$result = $db->loadObject();
						

					
					if(!isset($result) || sizeof($result)<=0 || !isset($result->total)){
						$principal='S';
					}else{
						$ordem = $result->total+1;
					}
;
					
					$query = $db->getQuery ( true );
					$query->insert( $db->quoteName ( '#__angelgirls_redesocial' ) )
					->columns (array (
							$db->quoteName ( 'principal' ),
							$db->quoteName ( 'rede_social' ),
							$db->quoteName ( 'url_usuario' ),
							$db->quoteName ( 'id_usuario' ),
							$db->quoteName ( 'status_dado' ),
							$db->quoteName ( 'id_usuario_criador' ),
							$db->quoteName ( 'id_usuario_alterador' ),
							$db->quoteName ( 'data_criado' ),
							$db->quoteName ( 'data_alterado' ),
							$db->quoteName ( 'ordem' )))
							->values(implode(',', array(
									$db->quote($principal),
									(isset($rede)?$db->quote($rede):'null'),
									(isset($contato)?$db->quote($contato):'null'),
									$user->id,
									$db->quote(StatusDado::NOVO),
									$user->id,
									$user->id, 'NOW()', 'NOW()',
									$ordem)));
	
							$db->setQuery( $query );
							if($db->execute()){
								$jsonRetorno='{"ok":"ok", "menssagem":""}';
							}
							else{
								$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
							}
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				}
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"'.$mensagensErro.'"}';
		}
	
	
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function carregarRedeSocial(){
		JRequest::setVar ( 'redes', $this->getRedesSociaisPefil());
		require_once 'views/perfil/tmpl/redesociais.php';
		exit();
	}
	
	public function carregarCadastro(){
		JRequest::setVar ( 'ufs', $this->getUFs());
	}
	
	private function getUFs(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( $db->quoteName ( array ('a.ds_uf_sigla','a.ds_uf_nome'),array ('uf','nome') ) )
		->from ( $db->quoteName ( '#__uf', 'a' ) )
		->order ( 'a.ds_uf_sigla' );
		$db->setQuery ( $query );
		return $db->loadObjectList();
	}
	
	
	
	function cidadeJson(){
		$uf = 	JRequest::getString( 'uf','','POST');
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		$query->select ( $db->quoteName ( array (
				'a.id',
				'a.nome')))
		->from ( $db->quoteName ('#__cidade', 'a' ))
		->where ( $db->quoteName ('a.uf').' = ' .$db->quote($uf) )
		->order ( 'a.nome' );
		$db->setQuery ( $query );
		$cidades = $db->loadObjectList ();
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($cidades);
		exit();
	}
	

	public function homepage(){
		$user = JFactory::getUser();
		if (!isset ( $user ) || $user->id == 0 ){
			$this->nologado();
		}
		else{
			$this->logado();
		}
	}
	
	public function logado(){
		$db = JFactory::getDbo();
		
		$perfil = $this->getPerfilLogado();
		
		if(!isset($perfil)){
			$this->nologado();
			return;
		}
			
			
		JRequest::setVar ( 'perfil', $perfil );
		
		$query = $db->getQuery ( true );
		$query->select('id,  tipo,  titulo, descricao, prioridade, data_publicado, audiencia, acessos, rnd, opt1, opt2, opt3, opt4')
				->from ('#__timeline')
				->where ( '(tipo=\'CONTENT\' AND  ' . $db->quoteName ( 'audiencia' ) . ' IN (' . NivelAcesso::ACESSO_PUBLICO . ', ' . NivelAcesso::ACESSO_GUEST . 
						( $perfil->tipo=='MODELO' ? ',' . NivelAcesso::ACESSO_MODELO : $perfil->tipo=='FOTOGRAFO'?','.NivelAcesso::ACESSO_FOTOGRAFO:'')
						. ') OR (tipo<>\'CONTENT\'))' )
				->setLimit(15);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'conteudos', $result );
		JRequest::setVar ( 'view', 'home' );
		JRequest::setVar ( 'layout', 'logado' );
		parent::display ();
	}
	
	
	private function getPerfilLogado(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`id`,`tipo`,`usuario`,`nome_completo`,`email_principal`,`id_usuario`,`apelido`,`descricao`,`meta_descricao`,`foto_perfil`,
					`foto_adicional1`,`foto_adicional2`,`altura`,`peso`,`busto`,`calsa`,`calsado`,`olhos`,`pele`,`etinia`,`cabelo`,
					`tamanho_cabelo`,`cor_cabelo`,`outra_cor_cabelo`,`profissao`,`nascionalidade`,`id_cidade_nasceu`,`uf_nasceu`,`data_nascimento`,`site`,
					`sexo`,`cpf`,`banco`,`agencia`,	`conta`,`custo_medio_diaria`,`outro_status`,`qualificao_equipe`,`audiencia_gostou`,
					`audiencia_ngostou`,`audiencia_view`,`id_cidade`,`uf`,`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,
					`data_criado`,`data_alterado`')
							->from ('#__angelgirls_perfil')
							->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
							->setLimit(1);
		$db->setQuery ( $query );
		return $db->loadObject();
	}
	
	private function getEnderecosPefil(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('end.`id`,end.`tipo`,end.`principal`,end.`endereco`,end.`numero`,end.`bairro`,end.`complemento`,
				end.`cep`,end.`id_cidade`,end.`id_usuario`,end.`ordem`,end.`status_dado`,end.`id_usuario_criador`,
				end.`id_usuario_alterador`,end.`data_criado`,end.`data_alterado`,c.nome as cidade,c.uf,uf.ds_uf_nome as estado')
						->from ('#__angelgirls_endereco AS end')
						->join ( 'INNER', '#__cidade AS c ON ' . $db->quoteName ( 'end.id_cidade' ) . ' = ' . $db->quoteName('c.id'))
						->join ( 'INNER', '#__uf AS uf ON ' . $db->quoteName ( 'c.uf' ) . ' = ' . $db->quoteName('uf.ds_uf_sigla'))
						->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
						->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
						->order('ordem');
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	} 
	
	private function getTelefonesPefil(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`id`,`principal`,`tipo`,`operadora`,`ddi`,`telefone`,`ddd`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
				`id_usuario_alterador`,`data_criado`,`data_alterado`')
						->from ('#__angelgirls_telefone')
						->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
						->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
						->order('ordem');
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	
	private function getRedesSociaisPefil(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`id`,`principal`,`publico`,`rede_social`,`url_usuario`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
				`id_usuario_alterador`,`data_criado`,`data_alterado`')
						->from ('#__angelgirls_redesocial')
						->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
						->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
						->order('ordem');
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		return $results;
	}
	
	private function getEmailsPefil(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`id`,`principal`,`email`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
				`id_usuario_alterador`,`data_criado`,`data_alterado`')
						->from ('#__angelgirls_email')
						->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
						->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
						->order('ordem');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		return $results;
	}	
	
	
	

	
	public function carregarPerfil(){
		$user = JFactory::getUser();
		$this->carregarCadastro();
		
		if(!isset($user) || $user->id==0){
			JError::raiseWarning(100,JText::_('Usu&aacute;rio n&atilde;o est&aacute; logado.'));
			$this->nologado();
			return;
		}
		

		
		JRequest::setVar ( 'perfil', $this->getPerfilLogado() );
		
		//Dados
		JRequest::setVar ( 'enderecos', $this->getEnderecosPefil());
		JRequest::setVar ( 'emails', $this->getEmailsPefil());
		JRequest::setVar ( 'redes', $this->getRedesSociaisPefil());
		JRequest::setVar ( 'telefones', $this->getTelefonesPefil());
		//Carregar Cadstro já busca Ufs
		//JRequest::setVar ( 'ufs', $this->getUFs());
		
		JRequest::setVar ( 'view', 'perfil' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display();
	}
	
	public function nologado(){
		//Nova modelo
		$db = JFactory::getDbo ();

		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','meta_descricao','foto_perfil','nome_artistico'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ') ' )
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
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
				->where ( $db->quoteName ( 'status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
				->where ( $db->quoteName ( 'publicar' ) . ' <= NOW() ' )
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
				->where ( $db->quoteName ( 'status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') ' )
				->where ( $db->quoteName ( 'publicar' ) . ' <= NOW() ' );
		if(isset($result) && isset($result->id)){
			$query->where ( $db->quoteName ( 'id' ) . ' <> ' . $result->id );
		}
		$query->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(4);
		$db->setQuery ( $query );
		$result = $db->loadObjectList();
		JRequest::setVar ( 'sessoes', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select(" `id` ,`titulo` as nome,`meta_descricao` as descricao,`id_sessao`, `id_sessao` + '/' + `id` + 'm.jpg' as foto, `titulo` as alias ")
			->from ('#__angelgirls_foto_sessao')
			->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
			->where ( $db->quoteName ( 'id_sessao' ) . ' IN (select id FROM #__angelgirls_sessao WHERE status_dado IN (' . $db->quote(StatusDado::PUBLICADO) . ' ) AND  publicar<= NOW()) ')
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
			->where ( $db->quoteName ( 'access' ) . ' IN (' . NivelAcesso::ACESSO_PUBLICO . ', ' . NivelAcesso::ACESSO_GUEST . ')' )
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
			->where ( $db->quoteName ( 'catid' ) . ' = ' . $this::CATEGORIA_MAKINGOF )
			->where ( $db->quoteName ( 'access' ) . ' IN (' . NivelAcesso::ACESSO_PUBLICO . ', ' . NivelAcesso::ACESSO_GUEST . ')' )
			->order('created DESC ')
			->setLimit(4);
		$db->setQuery ( $query );
		

		
		
		$result = $db->loadObjectList();
		JRequest::setVar ( 'makingofs', $result );
		
		
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo'),
				array('id','nome','descricao','foto', 'alias')))
				->from ('#__angelgirls_promocao')
				->where ( $db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::ATIVO) . ' ' )
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
	
	
	public function trocarSenha(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		
		
		
		
		$user = JFactory::getUser();
		$usuario = trim(strtolower( JRequest::getString( 'username', '', 'POST' )));
		$senha = trim(JRequest::getString( 'password', '', 'POST' ));
		$senha2 = trim(JRequest::getString( 'password1', null, 'POST' ));
		$nome = trim(JRequest::getString( 'name', null, 'POST' ));
		if(!isset($user) || !isset($user->id) || $user->id==0){
			$user = JFactory::getUser(0);
		
			$usersParams = JComponentHelper::getParams('com_users');
			$userdata = array();
			$userdata['username'] = $usuario;
			$defaultUserGroup = $usersParams->get('new_usertype', 2);
		
			$userdata['email'] = trim(JRequest::getString( 'email', '', 'POST' ));
			$userdata['email1'] = JRequest::getString( 'email1', null, 'POST' );
			$userdata['name'] = $nome;
			$userdata['password'] = $senha;
			$userdata['password2'] = $senha2;
			$userdata['block'] = 0;
				
			if(strtolower($tipo)=='fotografo'){
				$userdata['groups']=array($defaultUserGroup,GrupoAcesso::FOTOGRAFO_MODELO,GrupoAcesso::FOTOGRAFO);
			}
			elseif(strtolower($tipo)=='modelo'){
				$userdata['groups']=array($defaultUserGroup,GrupoAcesso::FOTOGRAFO_MODELO,GrupoAcesso::MODELO);
			}
			else{
				$userdata['groups']=array($defaultUserGroup);
			}
			if (!$user->bind($userdata)) {
				JError::raiseWarning(100,JText::_( $user->getError()));
				return null;
			}
		}
		else{
			$user->name = $nome;
		}
		
		if (!$user->save()) {
			JError::raiseWarning(100, JText::_( $user->getError()));
		}
		return $user;
	}
	
	

		
}