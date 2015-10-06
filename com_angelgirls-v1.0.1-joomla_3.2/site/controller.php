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
jimport( 'joomla.mail.mail' );

jimport('joomla.log.log');

class ConfirguacaoImagens {
	
	const TYPE_THUMB = 'thumb';
	const TYPE_THUMB_CUBE = 'cube';
	const TYPE_ICONE = 'ico';
	const TYPE_ICONE_CUBE = 'icocube';
	const TYPE_FULL = 'full';
	const TYPE_FULL_CUBE = 'fullcube';
	const TYPE_BACKUP = 'fullcube';
	
	var $THUMB = array(name=>TYPE_THUMB,prefix=>'thumb_', width=>300,height=>300, able=>TRUE, cube=>TRUE, logo=>TRUE, quality=>50);
	var $THUMB_CUBE = array(name=>TYPE_THUMB_CUBE,prefix=>'cube_', width=>300,height=>300, able=>TRUE, cube=>TRUE, logo=>TRUE, quality=>50);
	var $ICONE = array(name=>TYPE_ICONE,prefix=>'ico_', width=>150,height=>150, able=>TRUE, cube=>TRUE, logo=>TRUE, quality=>70);
	var $ICONE_CUBE = array(name=>TYPE_ICONE_CUBE,prefix=>'icocube_', width=>150,height=>150, able=>FALSE, cube=>TRUE, logo=>TRUE, quality=>70);
	var $FULL = array(name=>TYPE_FULL,prefix=>'', width=>2000,height=>2000, able=>TRUE, cube=>FALSE, logo=>TRUE, quality=>100);
	var $FULL_CUBE = array(name=>TYPE_FULL_CUBE,prefix=>'fullcube_', width=>2000,height=>2000, able=>FALSE, cube=>TRUE, logo=>TRUE, quality=>100);
	var $BACKUP = array(name=>TYPE_BACKUP,prefix=>'bk_', width=>null,height=>null, able=>FALSE, cube=>FALSE, logo=>FALSE, quality=>100);

	var $tipo=null;
	var $tipos =null;
	
	public static function getInstance(){
		if(!isset($tipo))
			$tipo = new ConfirguacaoImagens();
		return $tipo;
	}
	
	public static function getTipo($name){
		$retorno = null;
		switch ($name){
			case TYPE_THUMB:
				$retorno = $THUMB;
				break;
			case TYPE_THUMB_CUBE:
				$retorno = $THUMB_CUBE;
				break;
			case TYPE_ICONE:
				$retorno = $ICONE;
				break;
			case TYPE_ICONE_CUBE:
				$retorno = $ICONE_CUBE;
				break;
			case TYPE_FULL:
				$retorno = $FULL;
				break;
			case TYPE_FULL_CUBE:
				$retorno = $FULL_CUBE;
				break;
			case TYPE_BACKUP:
				$retorno = $BACKUP;
				break;
		}
		return $retorno;
	}
	
	public static function getTipos(){
		
		if(!isset($tipos))
			$tipos = array(ConfirguacaoImagens::getInstance()->THUMB,
				ConfirguacaoImagens::getInstance()->THUMB_CUBE,
				ConfirguacaoImagens::getInstance()->ICONE,
				ConfirguacaoImagens::getInstance()->ICONE_CUBE,
				ConfirguacaoImagens::getInstance()->FULL,
				ConfirguacaoImagens::getInstance()->FULL_CUBE,
				ConfirguacaoImagens::getInstance()->BACKUP);
		
		return $tipos;
	}
}

class StatusDado {
	const PUBLICADO = 'PUBLICADO';
	const ATIVO = 'ATIVO';
	const REMOVIDO = 'REMOVIDO';
	const REPROVADO = 'REPROVADO';
	const NOVO = 'NOVO';
	const ANALIZE = 'ANALIZE';
}

class StatusMensagem {
	const NOVO = 'NOVO';
	const RASCUNHO = 'RASCUNHO';
	const ENVIADO = 'ENVIADO';
	const LIXEIRA = 'LIXEIRA';
}


class TipoMensagens {
	const ENVIO_SESSAO_ANALIZE = 1;
	const SESSAO_REJEICAO_EQUIPE = 2;
	const SESSAO_APROVACAO_EQUIPE = 3;
	const SESSAO_APROVACAO_ADMIN = 4;
	const SESSAO_REJEICAO_ADMIN = 5;
	const SESSAO_PUBLICADA = 6;
	const SOLICITACAO_AMIZADE = 7;
	const REJEITOU_AMIZADE = 8;
	const ACEITOU_AMIZADE = 9;
	const MENSAGEM_SIMPLES = 10;
}

class TipoSessao {
	const VENDA = 'VENDA';
	const PONTOS = 'PONTOS';
	const PATROCINIO = 'PATROCINIO';
	const LEILAO = 'LEILAO';
	
}



class QuantidadePontos {
	const SESSAO_PONTOS_CADASTRO = 100;
	const SESSAO_OUTRA_CADASTRO = 5;
	const SESSAO_APROVAR = 10;
	const RELEASE_ENVIO = 10;
	const RELEASE_PUBLICADA = 50;
	const CONVITE_PUBLICADO = 50;
	const CONVITE_ACEITO = 150;
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

if(!defined('COMPONENT_AG_PATH')){
	define('COMPONENT_AG_PATH', JPATH_SITE . DS . 'components' . DS . 'com_angelgirls' . DS);
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
		parent::display ();
	}
	
	private function getPerfilFotografoById($id){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`token`, 
						`f`.`data_nascimento`,`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`,
						`f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,`u`.`email`,`cnasceu`.`uf` as `estado_nasceu`, 
						`cnasceu`.`nome` as `cidade_nasceu`,`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`,
						CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
				->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
				->join ( 'LEFT', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
				->join ( 'LEFT', '(SELECT data_criado, id_fotografo FROM #__angelgirls_vt_fotografo WHERE id_usuario='.$user->id.') vt_f ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_f.id_fotografo'))
				->join ( 'LEFT', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
				->join ( 'LEFT', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'))
				->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		

		
		return $db->loadObject();
	}
	
	public function carregarFotografo(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_fotografo' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
		
		
		$result = $this->getPerfilFotografoById($id);
		
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

	private function getPerfilModeloByToken($token, $tipo=null){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`token`,
						`f`.`data_nascimento`,`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`,
						`f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,`u`.`email`, `f`.`altura`,  `f`.`peso`,
					    `f`.`busto`,  `f`.`calsa`,  `f`.`calsado`, `f`.`olhos`,  `f`.`pele`,  `f`.`etinia`,  `f`.`cabelo`,
						`f`.`tamanho_cabelo`, `f`.`cor_cabelo`,  `f`.`outra_cor_cabelo`,`cnasceu`.`uf` as `estado_nasceu`,
						`cnasceu`.`nome` as `cidade_nasceu`,`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`,
						CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
							->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
							->join ( 'LEFT', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
							->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_f ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_f.id_modelo'))
							->join ( 'LEFT', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
							->join ( 'LEFT', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'))
							->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
							->where ( $db->quoteName ( 'f.token' ) . ' =  ' . $db->quote($token) );
				if(isset($tipo)){
					$query->where ( $db->quoteName ( 'f.tipo' ) . ' =  ' . $db->quote($tipo) );
				}
		$db->setQuery ( $query );
		$perfil = $db->loadObject();
			
			
		if(isset($perfil->enderecos)){	
			
			
			$query = $db->getQuery ( true );
			$query->select('end.`id`,end.`tipo`,end.`principal`,end.`endereco`,end.`numero`,end.`bairro`,end.`complemento`,
					end.`cep`,end.`id_cidade`,end.`id_usuario`,end.`ordem`,end.`status_dado`,end.`id_usuario_criador`,
					end.`id_usuario_alterador`,end.`data_criado`,end.`data_alterado`,c.nome as cidade,c.uf,uf.ds_uf_nome as estado')
								->from ('#__angelgirls_endereco AS end')
								->join ( 'INNER', '#__cidade AS c ON ' . $db->quoteName ( 'end.id_cidade' ) . ' = ' . $db->quoteName('c.id'))
								->join ( 'INNER', '#__uf AS uf ON ' . $db->quoteName ( 'c.uf' ) . ' = ' . $db->quoteName('uf.ds_uf_sigla'))
								->where ( $db->quoteName ('id_usuario').' = ' . $perfil->id_usuario)
								->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
								->order('ordem');
			$db->setQuery ( $query );
			
			$perfil->enderecos = $db->loadObjectList();
			
			
			$query = $db->getQuery ( true );
			$query->select('`id`,`principal`,`email`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
					`id_usuario_alterador`,`data_criado`,`data_alterado`')
								->from ('#__angelgirls_email')
								->where ( $db->quoteName ('id_usuario').' = ' . $perfil->id_usuario)
								->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
								->order('ordem');
			$db->setQuery($query);
			$perfil->emails = $db->loadObjectList();
				
				
			$query = $db->getQuery ( true );
			$query->select('`id`,`principal`,`tipo`,`operadora`,`ddi`,`telefone`,`ddd`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
					`id_usuario_alterador`,`data_criado`,`data_alterado`')
								->from ('#__angelgirls_telefone')
								->where ( $db->quoteName ('id_usuario').' = ' . $perfil->id_usuario)
								->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
								->order('ordem');
			$db->setQuery ( $query );
			$perfil->telefones = $db->loadObjectList();
				
				
			$query = $db->getQuery ( true );
			$query->select('`id`,`principal`,`publico`,`rede_social`,`url_usuario`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
					`id_usuario_alterador`,`data_criado`,`data_alterado`')
								->from ('#__angelgirls_redesocial')
								->where ( $db->quoteName ('id_usuario').' = ' . $perfil->id_usuario)
								->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
								->order('ordem');
			$db->setQuery ( $query );
			$perfil->redesSociaos = $db->loadObjectList();
			$session->set('perfil', $perfil);
			
		}
		
		return $perfil;
	}
	
	private function getPerfilModeloById($id){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`token`,
						`f`.`data_nascimento`,`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`,
						`f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,`u`.`email`, `f`.`altura`,  `f`.`peso`,
					    `f`.`busto`,  `f`.`calsa`,  `f`.`calsado`, `f`.`olhos`,  `f`.`pele`,  `f`.`etinia`,  `f`.`cabelo`,
						`f`.`tamanho_cabelo`, `f`.`cor_cabelo`,  `f`.`outra_cor_cabelo`,`cnasceu`.`uf` as `estado_nasceu`,
						`cnasceu`.`nome` as `cidade_nasceu`,`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`,
						CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
			->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
			->join ( 'LEFT', '#__users AS u ON ' . $db->quoteName ( 'f.id_usuario' ) . ' = ' . $db->quoteName('u.id'))
			->join ( 'LEFT', '(SELECT data_criado, id_modelo FROM #__angelgirls_vt_modelo WHERE id_usuario='.$user->id.') vt_f ON ' . $db->quoteName ( 'f.id' ) . ' = ' . $db->quoteName('vt_f.id_modelo'))
			->join ( 'LEFT', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'f.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
			->join ( 'LEFT', '#__cidade AS cvive ON ' . $db->quoteName ( 'f.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'))
			->where ( $db->quoteName ( 'f.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		return $db->loadObject();
	}
	
	public function carregarModelo(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_modelo' ))
		->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
		->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		$db->setQuery ( $query );
		$db->execute ();
//		$this->LogQuery($query);
		
		
		$result = $this->getPerfilModeloById($id);
		
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
			$var =explode(':',$id); 
			$id = $var[0];
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
							$db->quoteName ( 'data_criado' ),
							$db->quoteName ( 'host_ip' )))
							->values(implode(',', array ($id, $user->id, 'NOW()',$db->quote($this->getRemoteHostIp()))));
						$db->setQuery( $query );
						$db->execute();
						$this->LogQuery($query);
					}
					else{
						$query = $db->getQuery ( true );
						$query->delete( $db->quoteName ($tabelaVotoId ) )
						->where ($campoId.' = ' . $id )
						->where (' id_usuario = ' . $user->id );
						$db->setQuery( $query );
						$db->execute();
						$this->LogQuery($query);
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
					//$this->LogQuery($query);
				}
				else{
					$jsonRetorno='{"status":"nok","mesage":"Area n&atilde;o reconhecida.","codigo":"403"}';
				}
			}
			else{
				$jsonRetorno='{"status":"nok","mesage":"N&atilde;o logado","codigo":"401"}';
			}
		}
		else{
			$jsonRetorno='{"status":"nok","mesage":"Area n&atilde;o reconhecida.","codigo":"403"}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	private function existeUsuario($usuarioP){ 
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
	
	private function validaCPF($cpf = null) {
	
		// Verifica se um n&uacute;mero foi informado
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
		// Verifica se nenhuma das sequ&ecirc;ncias invalidas abaixo
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
			// CPF &eacute; v&aacute;lido
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
	public function carregarMensagem(){
	
		JRequest::setVar( 'view', 'inbox');
		JRequest::setVar( 'layout', 'mensagem');
		parent::display();
	}
	


	
	public function carregarFoto(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
	
	
		
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`,`f`.`titulo`,`f`.`descricao`,`f`.`meta_descricao`,`f`.`id_sessao`,`f`.`audiencia_gostou`,`f`.`token`,
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
						`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`, `fot2`.`meta_descricao` AS `desc_fot2` ,
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
				
				
				->where ('(((' . $db->quoteName ( 's.id_usuario_criador' ) . ' = ' . $user->id.' AND '. $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . '))
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_principal` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.')  AND `s`.`status_fotografo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_secundario` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.') AND `s`.`status_fotografo_secundario` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_principal` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_secundaria` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_secundaria` = 0 )
				) OR (' . $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') AND s.publicar <= NOW() ))' )
				

				
				
				
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
				if( !isset($user) || !isset($user->id) || $user->id <= 0){
					$query->where ( $db->quoteName ( 'f.possui_nudes' ) . " = 'N'");
				}
		
				//echo($query);exit();
				
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
	
	

	public function repovarFrom(){
		require_once 'views/sessoes/tmpl/repovar_from.php';
		exit();
	}
	
	
	public function reprovarSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$perfil = $this::getPerfilLogado();
		
		$id = JRequest::getString('id',0);
		$descricao = JRequest::getString('descricao','');
		
		$sessao = $this->getSessaoById($id);
		
		$erro = false;
		
		if($id==0 || !isset($sessao)){
			JError::raiseWarning( 100, 'Falha ao aprovar sess&atilde;o. Sess&atilde;o n&atilde;o loalizada.' );
			$erro = true;
		}
		
		
		
		$todosAprovaram = true;
		
		if($sessao->status_modelo_principal != 1 || $sessao->status_fotografo_principal != 1){
			$todosAprovaram = false;
		}
		
		if(isset($sessao->id_fotografo_secundario) && $sessao->id_fotografo_secundario>0
				&& $sessao->status_fotografo_secundario != 1){
			$todosAprovaram = false;
		}
		
		if(isset($sessao->id_modelo_secundaria) && $sessao->id_modelo_secundaria>0
				&& $sessao->status_modelo_secundaria != 1){
			$todosAprovaram = false;
		}
		
		
		//Montando o texto da mensgem.
		$titulo = 'Sess&atilde;o reprovada pel' . ($perfil->sexo=='M'?'o':'a') . ' ' . $perfil->nome;
		$texto = ' sua sess&atilde;o "' . $sessao->titulo . '" acaba de ser reprovada por um integrante.<br> ';
		

		
		$texto = $texto . 'O motivo foi: <br/>'.$descricao;
		
		
		$criador = $this->getPerfilById($sessao->id_usuario_criador);
		
		
		
		
		
		
		//Alterando status
		
		if($perfil->id == $sessao->id_fotografo_principal && $perfil->tipo == 'FOTOGRAFO'){
				
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_dado' ) . ' = ' . $db->quoteName(StatusDado::NOVO) ,
					$db->quoteName ( 'status_fotografo_principal' ) . ' = 0 ' ,
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id))
			->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_fotografo_secundario && $perfil->tipo=='FOTOGRAFO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_dado' ) . ' = ' . $db->quoteName(StatusDado::NOVO) ,
					$db->quoteName ( 'status_fotografo_secundario' ) . ' = 0 ' ,
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id))
			->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_modelo_principal && $perfil->tipo=='MODELO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::NOVO) ,
					$db->quoteName ( 'status_modelo_principal' ) . ' = 0 ' ,
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id))
			->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_modelo_secundaria && $perfil->tipo=='MODELO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_dado' ) . ' = ' . $db->quoteName(StatusDado::NOVO) ,
					$db->quoteName ( 'status_modelo_secundario' ) . ' = 0 ' ,
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id))
			->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		try{
			//	Enviando mensagem
			$this->EnviarMensagemEmail($criador->email, $criador->nome, TipoMensagens::SESSAO_REJEICAO_EQUIPE, $titulo, $texto);
			$this->EnviarMensagemInbox($titulo, $sessao->id_usuario_criador, $texto, TipoMensagens::SESSAO_REJEICAO_EQUIPE);
		}
		catch(Exception $e){
			JLog::add($e->getMessage(), JLog::WARNING);
		}

	
		require_once 'views/sessoes/tmpl/repovar_from.php';
		echo("<script>window.location='".JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarMinhasSessoes',false) ."'; \\parent.document.AngelGirls.FrameModalHide();
				</script>");
	}
	
	
	public function aprovarSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$perfil = $this::getPerfilLogado();
		
		$id = JRequest::getString('id',0);
		$sessao = $this->getSessaoById($id);
		
		$erro = false;
		
		if($id==0 || !isset($sessao)){
			JError::raiseWarning( 100, 'Falha ao aprovar sess&atilde;o. Sess&atilde;o n&atilde;o loalizada.' );
			$erro = true;
		}
		

		
		$todosAprovaram = true;

		if($sessao->status_modelo_principal != 1 || $sessao->status_fotografo_principal != 1){
			$todosAprovaram = false;
		}
		
		if(isset($sessao->id_fotografo_secundario) && $sessao->id_fotografo_secundario>0
				&& $sessao->status_fotografo_secundario != 1){
			$todosAprovaram = false;
		}
		
		if(isset($sessao->id_modelo_secundaria) && $sessao->id_modelo_secundaria>0
				&& $sessao->status_modelo_secundaria != 1){
			$todosAprovaram = false;
		}

		
		//Montando o texto da mensgem.
		$titulo = 'Sess&atilde;o aprovada pel' . ($perfil->sexo=='M'?'o':'a') . ' ' . $perfil->nome_completo;
		$texto = 'Parab&eacute;ns a sua sess&atilde;o "' . $sessao->titulo . '" acaba de ser apravada por mais um integrante.<br> ';
		
		if($todosAprovaram){ 
			if( $sessao->tipo == TipoSessao::VENDA){
				$texto = $texto . 'Agora a sua sess&atilde;o vai para analize da equipe interna da Angel Girls, eles iram anaizar tecnicamente para ver se possuem interesse de compra.';
			}
			elseif( $sessao->tipo == TipoSessao::LEILAO){
				$texto = $texto . 'Agora a sua sess&atilde;o vai para analize da equipe interna da Angel Girls, eles iram analizar tecnicamente e ver se atende a todos os criterios do tipo de sess&atilde;o, e logo agendaram a publica&ccedil;&atilde;o para que outros usu&aacute;rios possam comprar o seu set ou iram entrar em contato.';
			}
			elseif( $sessao->tipo == TipoSessao::PATROCINIO){
				$texto = $texto . 'Agora a sua sess&atilde;o vai para analize da equipe interna da Angel Girls, eles iram analizar tecnicamente e ver se atende a todos os criterios do tipo de sess&atilde;o, e logo agendaram a publica&ccedil;&atilde;o para  ou iram entrar em contato.';
			}
			elseif( $sessao->tipo == TipoSessao::PONTOS){
				$texto = $texto . 'Agora a sua sess&atilde;o vai para analize da equipe interna da Angel Girls, eles iram analizar tecnicamente e ver se atende a todos os criterios do tipo de sess&atilde;o, e logo agendaram a publica&ccedil;&atilde;o ou iram entrar em contato.';
			}
		}
		else{
			$texto = $texto . 'Estamos aguardando todos integrantes aprovarem, falta pouco j&aacute; j&aacute; estar&aacute; aprovado.';
		}

		$texto = $texto . '<br/>Continue participando. <br/>N&atilde;o deixe de ler os termos e condi&ccedil;&otilde;es no site e acompanhe as dicas para ter maior resultado em seus trabalhos. <br/>Boa sorte.';
		
		
		$criador = $this->getPerfilById($sessao->id_usuario_criador);
		
		


		

		//Alterando status
		
		if($perfil->id == $sessao->id_fotografo_principal && $perfil->tipo == 'FOTOGRAFO'){
			
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
				$db->quoteName ( 'status_fotografo_principal' ) . ' = 1 ' ),
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
				$db->quoteName ( 'data_alterado' ) . ' = NOW()',
				$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id)
			->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_fotografo_secundario && $perfil->tipo=='FOTOGRAFO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_fotografo_secundario' ) . ' = 1 ' ),
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id)
					->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_modelo_principal && $perfil->tipo=='MODELO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_modelo_principal' ) . ' = 1 ' ),
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id)
					->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		if($perfil->id == $sessao->id_modelo_secundaria && $perfil->tipo=='MODELO'){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
			->set (array(
					$db->quoteName ( 'status_modelo_secundario' ) . ' = 1 ' ),
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id)
					->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
		}
		
		//Enviando mensagem
		$this->EnviarMensagemEmail($criador->email, $criador->nome, TipoMensagens::SESSAO_APROVACAO_EQUIPE, $titulo, $texto);
		$this->EnviarMensagemInbox($titulo, $sessao->id_usuario_criador, $texto, TipoMensagens::SESSAO_APROVACAO_EQUIPE);
	
		$this->carregarMinhasSessoes();
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
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
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
						$user->id,$user->id, 'NOW()', 'NOW()',$db->quote($this->getRemoteHostIp()),$db->quote($this->getRemoteHostIp()))));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		$this->LogQuery($query);
		
		
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
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
		->values(implode(',', array ($db->quote(trim($nome)),$db->quote(trim($descricao)),$db->quote(trim($descricao)),$db->quote($nomearquivo), $user->id,$user->id, 'NOW()', 'NOW()',
		$db->quote($this->getRemoteHostIp()),
		$db->quote($this->getRemoteHostIp()))));
				
				
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();

		$this->LogQuery($query);
		
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
				$db->quoteName ( 'data_alterado' )		,
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
				->values(implode(',', array ($db->quote(trim($nome)),$db->quote(trim($descricao)),$db->quote(trim($descricao)),$db->quote($nomearquivo), $user->id,$user->id, 'NOW()', 'NOW()',
		$db->quote($this->getRemoteHostIp()),
		$db->quote($this->getRemoteHostIp()))));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		$this->LogQuery($query);
		
		
		require_once 'views/sessoes/tmpl/adicionar_tema.php';
		echo("<script>jQuery('#tema',parent.document).append(new Option('$nome',$id));jQuery('#tema',parent.document).val($id);jQuery('#tema',parent.document).removeClass('error');jQuery('#tema',parent.document).addClass('valid');jQuery('#tema',parent.document).focus();parent.document.AngelGirls.FrameModalHide();</script>");
		exit();
	}
	
	private function GerarNovoNomeArquivo($fileName, $prefixo = null){
		//$uploadedFileNameParts = explode ( '.', $fileName );
		//$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
		//$nomearquivo = date('YmdHi').hash('sha256', $fileName . date('YmdHis')).'@'.md5($fileName . date('YmdHis')) . '.' . $uploadedFileExtension;
		//$nomearquivo = (isset($prefixo)?$prefixo.'_':'') . date('YmdHis') . hash('sha256', $fileName . date('YmdHisu')) . '.' . $uploadedFileExtension;
		$nomearquivo = (isset($prefixo)?$prefixo.'_':'') . date('YmdHis') . md5($fileName . date('YmdHisu')) . '.' . JFile::getExt($fileName);
		return $nomearquivo;
	}
	
	private function GerarToken($chave,$prefixo='', $ComDataNoPrefixo = false, $large= false){
		$chaveValor =  (isset($chave) && strlen(trim($chave))> 0 ? $chave : date('YmdHis'));
		return ($ComDataNoPrefixo?date('YmdHis'):'').(isset($prefixo) && strlen(trim($prefixo)) > 0 ?$prefixo:'').($large?sha1($chaveValor):'').md5($chaveValor);
	}

	public function carregarAprovarSessao(){
		
	}
	
	/**
	 * 
	 */
	public function carregarEditarSessao(){
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
		$user = JFactory::getUser();
		
		$perfil = $this::getPerfilLogado();
		
		if(!isset($perfil)){
			$this->nologado();
			return;
		}
		
		if($perfil->tipo != 'MODELO' && $perfil->tipo != 'FOTOGRAFO'){
			JError::raiseWarning(100,JText::_('&Aacute;rea permitida apenas para modelos ou fotografos.'));
			$this->logado();
			return;
		}


		
		
		JRequest::setVar ('perfil', $this::getPerfilLogado() );
		
		$sessao = $this->getSessaoById($id);

		
		
		if(isset($sessao) && $sessao->status_dado == StatusDado::PUBLICADO){
			JError::raiseWarning(100,JText::_('A Sess&atilde;o que tentou acessar j&aacute; foi publicada por isso n&atilde;o pode ser editada.'));
			$sessao == null;
			$id = 0;
			$this->RegistroNaoEncontado();
			return;
		}
		if(!isset($sessao) && isset($id) && $id>0){
			JError::raiseWarning(404,JText::_('P&aacute;gina n&atilde;o encontrada.'));
			$this->RegistroNaoEncontado();
			return;
		}
		
		
		JRequest::setVar ('modelos', $this->getAllModelos() );
		
		JRequest::setVar ('fotografos', $this->getAllFotografos() );
		JRequest::setVar ('temas', $this->getAllTemas());
		JRequest::setVar ('figurinos', $this->getAllFigurinos());
		JRequest::setVar ('locacoes', $this->getAllLocacoes());
		
		
		JRequest::setVar ('sessao', $sessao);
		
		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $id, $this::LIMIT_DEFAULT) );
		JRequest::setVar ( 'videos', $this->runVideosSessao($user, $id) );
		
		
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select('count(s.id) AS total ')
					->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
					->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
					->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $id)
					->where ( $db->quoteName ( 's.possui_nudes' ) . " =  'N' ");
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar('sem_nudes', $result->total);
		
		$query = $db->getQuery ( true );
		$query->select('count(s.id) AS total ')
		->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
		->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
		->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $id);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar('total_fotos', $result->total);
		
		
		JRequest::setVar('view', 'sessoes');
		JRequest::setVar('layout', 'editar');
		parent::display();
	}
	
	/**
	 * 
	 */
	public function salvarSessao(){
		if(!JSession::checkToken('post')) die ('Restricted access');
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		
		$id  = JRequest::getInt('id',null,'POST');
		$termos = JRequest::getString('termos',null,'POST');
		$titulo = JRequest::getString('titulo',null,'POST');
		$data_realizada = JRequest::getString('data_realizada',null,'POST');
		$agenda  = JRequest::getInt('agenda',null,'POST');
		$meta_descricao = JRequest::getString('meta_descricao',null,'POST');
		$comentario = JRequest::getString('comentario',null,'POST');
		$tema  = JRequest::getInt('tema',null,'POST');
		$historia = JRequest::getString('historia',null,'POST');
		$locacao  = JRequest::getInt('locacao',null,'POST');
		
		$tipo_sessao = JRequest::getString('tipo_sessao',null,'POST');
		
		$id_figurino_principal  = JRequest::getInt('id_figurino_principal',null,'POST');
		$id_figurino_secundario  = JRequest::getInt('id_figurino_secundario',null,'POST');
		$id_modelo_principal  = JRequest::getInt('id_modelo_principal',null,'POST');
		$id_modelo_secundaria  = JRequest::getInt('id_modelo_secundaria',null,'POST');
		$id_fotografo_principal  = JRequest::getInt('id_fotografo_principal',null,'POST');
		$id_fotografo_secundario  = JRequest::getInt('id_fotografo_secundario',null,'POST');
		$descricao = JRequest::getString('descricao',null,'POST');
		$publicar = JRequest::getString('publicar','N','POST');

		$erros = false;
		$dataRealizadoSessao =null;
		$dataFormatadaBanco = null;
		$imagem = $_FILES ['imagem'];
		$perfil = $this::getPerfilLogado();
		$token = $this->GerarToken($titulo,'',true,false);

		if(!isset($perfil) || !isset($user) || $user->id == 0){
			JError::raiseWarning(100,JText::_('Voc&ecirc; n&atilde;o est&aacute; logado, por isso n&atilde;o pode executar essa a&ccedil;&atilde;o. Opera&ccedil;&atilde;o cancelada.'));
			$this->nologado();
			return;
		}
		elseif($perfil->tipo!='MODELO' && $perfil->tipo!='FOTOGRAFO'){
			JError::raiseWarning(100,JText::_('Est&aacute; &aacute;rea &eacute; permitida apenas para perfil tipo modelo ou fotografo. Opera&ccedil;&atilde;o cancelada.'));
			$this->RegistroNaoEncontado();
			return;
		}

		
		//Valida&ccedil;&atilde;o
		if((!isset($id) || $id == 0 || strlen(trim($id)) <=0 ) &&
				strlen(trim($termos)) <= 0){
			JError::raiseWarning(100,JText::_('Cadastro de uma sess&atilde;o nova &eacute; obrigat&oacute;rio que leia os termos e condi&ccedil;&otilde;es e confirme que est&aacute; de acordo.'));
			$erros = true;
		}
		
		if(isset($data_realizada) && strlen($data_realizada) >= 8){
			$dataRealizadoSessao = DateTime::createFromFormat('d/m/Y H:i:s', $data_realizada.' 00:00:00');
			
			if(intval($dataRealizadoSessao->format('Ymd')) >= intval(date('Ymd'))){
				JError::raiseWarning(100,JText::_('O campo "Data da realiza&ccedil;&atilde;o da sess&atilde;o" deve ser inferior a hoje. E deve estar no formato DD/MM/AAAA'));
				$erros = true;
			}
			
			$dataFormatadaBanco = $db->quote($dataRealizadoSessao->format('Y-m-d'));
		}
		else{
			JError::raiseWarning(100,JText::_('O campo "Data da realiza&ccedil;&atilde;o da sess&atilde;o" &eacute; um campo obrigat&oacute;rio. E deve estar no formato DD/MM/AAAA'));
			$erros = true;
		}		
		
		if(!isset($titulo) || strlen(trim($titulo)) <5 ){
			JError::raiseWarning(100,JText::_('O campo "Titulo" &eacute; um campo obrigat&oacute;rio. E deve contar no minimo 5 e m&aacute;ximo 250 caracteres.'));
			$erros = true;
		}
		
		if(!isset($tipo_sessao) || strlen(trim($tipo_sessao)) <=0){
			JError::raiseWarning(100,JText::_('O campo "Tipo" &eacute; um campo obrigat&oacute;rio.'));
			$erros = true;
		}
		
		if(strlen(trim($titulo)) >250 ){
			JError::raiseWarning(100,JText::_('O campo "Titulo" passou de 250 caracteres.'));
			$erros = true;
		}
		
		if(!isset($meta_descricao) || strlen(trim($meta_descricao)) <5 ){
			JError::raiseWarning(100,JText::_('O campo "Descri&ccedil;&atilde;o R&aacute;pida" &eacute; um campo obrigat&oacute;rio. E deve contar no minimo 5 e m&aacute;ximo 250 caracteres.'));
			$erros = true;
		}
		
		if(strlen(trim($meta_descricao)) >250 ){
			JError::raiseWarning(100,JText::_('O campo "Descri&ccedil;&atilde;o R&aacute;pida" passou de 250 caracteres.'));
			$erros = true;
		}
		
		if(strlen(trim($comentario)) >250 ){
			JError::raiseWarning(100,JText::_('O campo "Coment&aacute;rio" passou de 250 caracteres.'));
			$erros = true;
		}

		
		if(!isset($id_modelo_principal) || strlen(trim($id_modelo_principal)) <=0 ){
			JError::raiseWarning(100,JText::_('Deve selecionar uma modelo principal que participou da sess&atilde;o. Caso ela n&atilde;o esteja deve na lista deve solicitar que ela se cadastre ou entre em contato com contato@angelgirls.com.br.'));
			$erros = true;
		}
		
		if(!isset($id_fotografo_principal) || strlen(trim($id_fotografo_principal)) <=0 ){
			JError::raiseWarning(100,JText::_('Deve selecionar uma fotografo principal que executou da sess&atilde;o. Caso ela n&atilde;o esteja deve na lista deve solicitar que ela se cadastre ou entre em contato com contato@angelgirls.com.br.'));
			$erros = true;
		}
		

		
		
		if($erros){
			$this->carregarEditarSessao();
			return;
		}
		
		

		
		
		
		if(!isset($id) || $id==0 || strlen(trim($id)) <= 0 ){
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_sessao' ))
			->columns ( array (
				$db->quoteName ( 'status_dado' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'titulo' ),
				$db->quoteName ( 'executada' ),
				$db->quoteName ( 'descricao' ),
				$db->quoteName ( 'historia' ),
				$db->quoteName ( 'comentario_fotografo' ),
				$db->quoteName ( 'comentario_modelos' ),
				$db->quoteName ( 'meta_descricao' ),
				$db->quoteName ( 'id_agenda' ),
				$db->quoteName ( 'id_tema' ),
				$db->quoteName ( 'id_modelo_principal' ),
				$db->quoteName ( 'id_modelo_secundaria' ),
				$db->quoteName ( 'id_locacao' ),
				$db->quoteName ( 'id_fotografo_principal' ),
				$db->quoteName ( 'id_fotografo_secundario' ),
				$db->quoteName ( 'id_figurino_principal' ),
				$db->quoteName ( 'id_figurino_secundario' ),
				$db->quoteName ( 'status_modelo_principal' ),
				$db->quoteName ( 'status_fotografo_principal' ),
				$db->quoteName ( 'tipo' ),
			$db->quoteName ( 'host_ip_criador' ),
			$db->quoteName ( 'host_ip_alterador' )))
			->values ( implode ( ',', array (
					'\'NOVO\'',
					'NOW()',
					$user->id,
					'NOW()',
					$user->id,
					(!isset($titulo) || strlen(trim($titulo))<=0 ? ' null ' : $db->quote(trim($titulo))),
					(!isset($dataFormatadaBanco) || strlen(trim($dataFormatadaBanco))<=0 ? ' null ' : $dataFormatadaBanco),
					(!isset($descricao) || strlen(trim($descricao))<=0 ? ' null ' : $db->quote(trim($descricao))),
					(!isset($historia) || strlen(trim($historia))<=0 ? ' null ' : $db->quote(trim($historia))),
					((!isset($comentario) || strlen(trim($comentario))<=0) || $perfil->tipo!='FOTOGRAFO'?  ' null ' : $db->quote(trim($comentario))),
					((!isset($comentario) || strlen(trim($comentario))<=0) || $perfil->tipo!='MODELO'?  ' null ' : $db->quote(trim($comentario))),
					(!isset($meta_descricao) || strlen(trim($meta_descricao))<=0 ? ' null ' : $db->quote(trim($meta_descricao))),
					(!isset($agenda) || strlen(trim($agenda))<=0 || $agenda==0  ? ' null ' : $agenda),
					(!isset($tema) || strlen(trim($tema))<=0 || $tema==0 ? ' null ' : $tema),
					(!isset($id_modelo_principal) || strlen(trim($id_modelo_principal))<=0 || $id_modelo_principal==0 ? ' null ' : $id_modelo_principal),
					(!isset($id_modelo_secundaria) || strlen(trim($id_modelo_secundaria))<=0 || $id_modelo_secundaria==0 ? ' null ' : $id_modelo_secundaria),
					(!isset($locacao) || strlen(trim($locacao))<=0 || $locacao==0 ? ' null ' : $locacao),
					(!isset($id_fotografo_principal) || strlen(trim($id_fotografo_principal))<=0 || $id_fotografo_principal==0 ? ' null ' : $id_fotografo_principal),
					(!isset($id_fotografo_secundario) || strlen(trim($id_fotografo_secundario))<=0 || $id_fotografo_secundario==0 ? ' null ' : $id_fotografo_secundario),
					(!isset($id_figurino_principal) || strlen(trim($id_figurino_principal))<=0 || $id_figurino_principal==0 ? ' null ' : $id_figurino_principal),
					(!isset($id_figurino_secundario) || strlen(trim($id_figurino_secundario))<=0 || $id_figurino_secundario==0 ? ' null ' : $id_figurino_secundario),
					($perfil->tipo=='MODELO'?'1':'null'),
					($perfil->tipo=='FOTOGRAFO'?'1':'null'),
					(!isset($tipo_sessao) || strlen(trim($tipo_sessao))<=0  ? ' null ' :  $db->quote($tipo_sessao)),
					$db->quote($this->getRemoteHostIp()),
					$db->quote($this->getRemoteHostIp())
			)));
			$db->setQuery( $query );
			$db->execute();

			$id = $db->insertid();
			JRequest::setVar('id',$id);
			$this->LogQuery($query);
			
			

			
			
			$token = $this->GerarToken($titulo,$id,true,false);
			
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_sessao'))
					->set (array($db->quoteName ( 'token' ) . ' = ' . $db->quote($token)))
					->where (array($db->quoteName ( 'id' ) . ' = ' . $id));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
			
			
			
			
			if (isset ( $imagem ) && JFile::exists ( $imagem ['tmp_name'] )) {
					
				$this->SalvarUploadImagem($imagem,
						PATH_IMAGEM_SESSOES . $token,
						$this->GerarNovoNomeArquivo($imagem['name'], $id ),
						'#__angelgirls_sessao','nome_foto',$id,true,true);
			}
		}
		else{
			$query = $db->getQuery ( true );
			$query->select('token, nome_foto')
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'id_usuario_criador' ) . " =  " . $user->id )
				->where ( $db->quoteName ( 'id' ) . " =  " . $id );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
			if(isset($result)){
				$NomeArquivoAntigo =  $result->nome_foto;
				$token = $result->token;
	
				$query = $db->getQuery ( true );
				$query->update( $db->quoteName ( '#__angelgirls_sessao' ))
					  ->set (array(
					  		$db->quoteName ( 'data_alterado' ) . ' = NOW()',
					  		$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id,
					  		$db->quoteName ( 'titulo' ) . ' = ' . (!isset($titulo) || strlen(trim($titulo))<=0 ? ' null ' : $db->quote(trim($titulo))),
					  		$db->quoteName ( 'executada' ) . ' = ' . (!isset($dataFormatadaBanco) || strlen(trim($dataFormatadaBanco))<=0 ? ' null ' : $dataFormatadaBanco),
					  		$db->quoteName ( 'descricao' ) . ' = ' . (!isset($descricao) || strlen(trim($descricao))<=0 ? ' null ' : $db->quote(trim($descricao))),
					  		$db->quoteName ( 'historia' ) . ' = ' . (!isset($historia) || strlen(trim($historia))<=0 ? ' null ' : $db->quote(trim($historia))),
					  		($perfil->tipo!='FOTOGRAFO'? $db->quoteName ( 'comentario_fotografo' )  : $db->quoteName ( 'comentario_modelos' )  ). ' = ' . ((!isset($comentario) || strlen(trim($comentario))<=0) ?  ' null ' : $db->quote(trim($comentario))),
					  		$db->quoteName ( 'meta_descricao' ) . ' = ' . (!isset($meta_descricao) || strlen(trim($meta_descricao))<=0 ? ' null ' : $db->quote(trim($meta_descricao))),
					  		$db->quoteName ( 'id_agenda' ) . ' = ' . (!isset($agenda) || strlen(trim($agenda))<=0 || $agenda==0  ? ' null ' : $agenda),
					  		$db->quoteName ( 'id_tema' ) . ' = ' . (!isset($tema) || strlen(trim($tema))<=0 || $tema==0 ? ' null ' : $tema),
					  		$db->quoteName ( 'id_modelo_principal' ) . ' = ' . (!isset($id_modelo_principal) || strlen(trim($id_modelo_principal))<=0 || $id_modelo_principal==0 ? ' null ' : $id_modelo_principal),
					  		$db->quoteName ( 'id_modelo_secundaria' ) . ' = ' . (!isset($id_modelo_secundaria) || strlen(trim($id_modelo_secundaria))<=0 || $id_modelo_secundaria==0 ? ' null ' : $id_modelo_secundaria),
					  		$db->quoteName ( 'id_locacao' ) . ' = ' . (!isset($locacao) || strlen(trim($locacao))<=0 || $locacao==0 ? ' null ' : $locacao),
					  		$db->quoteName ( 'id_fotografo_principal' ) . ' = ' . (!isset($id_fotografo_principal) || strlen(trim($id_fotografo_principal))<=0 || $id_fotografo_principal==0 ? ' null ' : $id_fotografo_principal),
					  		$db->quoteName ( 'id_fotografo_secundario' ) . ' = ' . (!isset($id_fotografo_secundario) || strlen(trim($id_fotografo_secundario))<=0 || $id_fotografo_secundario==0 ? ' null ' : $id_fotografo_secundario),
					  		$db->quoteName ( 'id_figurino_principal' ) . ' = ' . (!isset($id_figurino_principal) || strlen(trim($id_figurino_principal))<=0 || $id_figurino_principal==0 ? ' null ' : $id_figurino_principal),
					  		$db->quoteName ( 'id_figurino_secundario' ) . ' = ' . (!isset($id_figurino_secundario) || strlen(trim($id_figurino_secundario))<=0 || $id_figurino_secundario==0 ? ' null ' : $id_figurino_secundario),
					  		$db->quoteName ( 'tipo' ) . ' = ' . (!isset($tipo_sessao) || strlen(trim($tipo_sessao))<=0  ? ' null ' : $db->quote($tipo_sessao)),
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
					  ))
					->where ( $db->quoteName ( 'id_usuario_criador' ) . " =  " . $user->id )
					->where ( $db->quoteName ( 'id' ) . " =  " . $id );
				$db->setQuery ( $query );
				if(!$db->execute()){
					return false;
				}
				$this->LogQuery($query);
				
				if (isset ( $imagem ) && JFile::exists ( $imagem ['tmp_name'] )) {
					$this->SalvarUploadImagem($imagem,
							PATH_IMAGEM_SESSOES . $token,
							$this->GerarNovoNomeArquivo($imagem['name'], $id ),
							'#__angelgirls_sessao','nome_foto',$id,true,true, $NomeArquivoAntigo);
				}
			}
			else{
				JError::raiseWarning( 100, 'O informa&ccedi;&atilde;o que tentou salvar n&atilde;o exite.' );
				$this->RegistroNaoEncontado();
				return;
			}
		}
		if($publicar=='S'){
			if($this->publicarSessao()){
				JFactory::getApplication()->enqueueMessage(JText::_('Sess&atilde;o publicada com sucesso!<br/>Aguardando aprova&ccedil;&atilde;o da(s) modelo(s) e fotografo(s) para ir para analize pelo comite.'));
				$this->carregarMinhasSessoes();
			}
			else{
				$this->carregarEditarSessao();
			}
		}
		else{
			JFactory::getApplication()->enqueueMessage(JText::_('Sess&atilde;o salva com sucesso!'));
			$this->carregarEditarSessao();
		}
	}
	
	
	
	private function publicarSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$id  = JRequest::getInt('id',null,'POST');
		$perfil = $this::getPerfilLogado();
		$sessao = $this->getSessaoById($id);
		
		
		
		$query = $db->getQuery ( true );
		$query->select('count(s.id) AS total ')
		->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
		->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
		->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $id)
		->where ( $db->quoteName ( 's.possui_nudes' ) . " =  'N' ");
		$db->setQuery ( $query );
		$result = $db->loadObject();
		$sem_nudes =  $result->total;
		
		$query = $db->getQuery ( true );
		$query->select('count(s.id) AS total ')
		->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
		->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
		->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $id);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		$total =  $result->total;
		
		
		$erros = false;
		
		if($sem_nudes < 5){
			JError::raiseWarning(100,JText::_('Devem ter no minimo 5 fotos sem nudes e semi nudes.'));
			$erros = true;
		}
		
		if(($total-$sem_nudes)<10){
			JError::raiseWarning(100,JText::_('Devem ter no minimo 10 fotos com nudes ou semi nudes.'));
			$erros = true;
		}
		
		
		if($total < 40 ){
			JError::raiseWarning(100,JText::_('Devem enviar no minimo 40 fotos por sess&atilde;o.'));
			$erros = true;
		}
		
		if(!isset($user) || !isset($user->id) || $user->id<=0){
			JError::raiseWarning( 100, 'Usu&aacute;rio n&atilde;o est&aacute; logado.');
			$this->nologado();
			return false;
		}
		if(!isset($sessao) || !isset($sessao->id) | $sessao->id <= 0){
			JError::raiseWarning( 100, 'A Sess&atilde;o n&atilde;o foi localizada');
			$this->RegistroNaoEncontado();
			return;
		}
		if($user->id != $sessao->id_usuario_criador){
			JError::raiseWarning( 100, 'A Sess&atilde;o n&atilde;o foi localizada.');
			return;
		}
		
		
		
		
		if($erros){
			return false;
		}
		
		
		$query = $db->getQuery ( true );
		$query->update( $db->quoteName ( '#__angelgirls_sessao' ))
		->set (array(
				$db->quoteName ( 'data_alterado' ) . ' = NOW()',
				$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id,
				$db->quoteName ( 'status_modelo_principal' ). ' = ' . ($perfil->tipo=='MODELO' && $sessao->id_modelo_principal == $perfil->id?'1':'0'),
				$db->quoteName ( 'status_modelo_secundaria' ). ' = 0 ' ,
				$db->quoteName ( 'status_fotografo_principal' ). ' =  ' . ($perfil->tipo=='FOTORGAFO' && $sessao->id_fotografo_principal == $perfil->id?'1':'0') ,
				$db->quoteName ( 'status_fotografo_secundario' ). ' = 0 ' ,
				$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::ANALIZE),
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
		))
		->where ( $db->quoteName ( 'id_usuario_criador' ) . " =  " . $user->id )
		->where ( $db->quoteName ( 'id' ) . " =  " . $id );
		$db->setQuery ( $query );
		if(!$db->execute()){
			return false;
		}
		
		
		
		
		
		

		

		

		

		try{
		
			
			
			$base = JUri::root(true) ;
			//$url = $_SERVER['SERVER_ADDR'] . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarAprovarSessao&id='.$sessao->id);
			$url = 'http://'.$_SERVER['HTTP_HOST']. JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id);
			
			$titulo = 'Publica&ccedil;&atilde;o de SET aguardando aprova&ccedil;&atilde;o.';
			
			$texto = "<img src='$base/components/com_angelgirls/angelgirls.png' style='width: 150px; float: left; height: auto; margin: 10px;'/><p>Ola %NOME%, <br/>"
					. ($peril->sexo=='F'?'A ':'O ') . $peril->nome ." cadastrou uma sess&atilde;o de fotos no site Angel Girls onde voc&ecirc; foi marcado(a) como %TIPO%.</p>
					<p><a href='$url'>Para aprovar ou repovar clique aqui</a> ou acesse o link <i><u>$url</u></i>.</p> 
					<p>Ser&aacute; necess&aacute;rio ter cadastro no site.</p>"  ;
			if($perfil->tipo == 'MODELO'){
				if(isset($sessao->id_fotografo_principal) && $sessao->id_fotografo_principal>0){
					
					$fotografo = $this->getPerfilFotografoById($sessao->id_fotografo_principal);
					$texto = str_replace('%NOME%', $fotografo->nome_completo, $texto);
					$texto = str_replace('%TIPO%', '"FOTOGRAFO PRINCIPAL"', $texto);
					
					$this->EnviarMensagemEmail($fotografo->email, $fotografo->nome, TipoMensagens::ENVIO_SESSAO_ANALIZE, $titulo, $texto);
					$this->EnviarMensagemInbox($titulo, '(SELECT id_usuario FROM  #__angelgirls_fotografo WHERE id = '.$sessao->id_fotografo_principal.')', $texto, 1);
				}
			}
			if($perfil->tipo == 'FOTOGRAFO'){
				if(isset($sessao->id_modelo_principal) && $sessao->id_modelo_principal>0){
					
					$modelo = $this->getPerfilModeloById($sessao->id_modelo_principal);
					
					$texto = str_replace('%NOME%', $modelo->nome_completo, $texto);
					$texto = str_replace('%TIPO%', '"MODELO"', $texto);
					
					$this->EnviarMensagemEmail($modelo->email, $modelo->nome, TipoMensagens::ENVIO_SESSAO_ANALIZE, $titulo, $texto);
					$this->EnviarMensagemInbox($titulo, '(SELECT id_usuario FROM  #__angelgirls_modelo WHERE id = '.$sessao->id_modelo_principal.')', $texto, 1);
				}
			}
			
			if(isset($sessao->id_modelo_secundaria) && $sessao->id_modelo_secundaria>0){
				
				$modelo = $this->getPerfilModeloById($sessao->id_modelo_secundaria);
				
				$texto = str_replace('%NOME%', $modelo->nome_completo, $texto);
				$texto = str_replace('%TIPO%', '"MODELO"', $texto);
				
				$this->EnviarMensagemEmail($modelo->email, $modelo->nome, TipoMensagens::ENVIO_SESSAO_ANALIZE, $titulo, $texto);
				$this->EnviarMensagemInbox($titulo, '(SELECT id_usuario FROM  #__angelgirls_modelo WHERE id = '.$sessao->id_modelo_secundaria.')', $texto, 1);
			}
			if(isset($sessao->id_fotografo_secundario) && $sessao->id_fotografo_secundario>0){
				$fotografo = $this->getPerfilFotografoById($sessao->id_fotografo_secundario);
				
				$texto = str_replace('%NOME%', $fotografo->nome_completo, $texto);
				$texto = str_replace('%TIPO%', '"FOTOGRAFO/EQUIPE"', $texto);
				
				$this->EnviarMensagemEmail($fotografo->email, $fotografo->nome, TipoMensagens::ENVIO_SESSAO_ANALIZE, $titulo, $texto);
				$this->EnviarMensagemInbox($titulo, '(SELECT id_usuario FROM  #__angelgirls_fotografo WHERE id = '.$sessao->id_fotografo_secundario.')', $texto, 1);
			}
			
			if($sessao->tipo=='PONTOS'){
				$this->SomarPontos('Cadastro da sess&atilde;o ' . $sessao->titulo, 'SESSAO.PONTOS.CADASTRO', QuantidadePontos::SESSAO_PONTOS_CADASTRO);
			}
			else{
				$this->SomarPontos('Cadastro da sess&atilde;o ' . $sessao->titulo, 'SESSAO.PONTOS.CADASTRO', QuantidadePontos::SESSAO_OUTRA_CADASTRO);
			}
		}
		catch(Exception $e){
			JLog::add($e->getMessage(), JLog::WARNING);
		}
		
		return true;
	} 
	
	
	
	
	private function MoverImagemoParapastaLixo($ArquivoAntigoApagavel, $dest){
		$user = JFactory::getUser();
		
		
		if(isset($ArquivoAntigoApagavel) && strlen(trim($ArquivoAntigoApagavel))>0
				&& JFile::exists (  $dest . DS . $ArquivoAntigoApagavel )){

				$arquivoAntigo = $dest  . DS .  $ArquivoAntigoApagavel;
				$arquivoAntigoBK = $dest  . DS . 'bk_' . $ArquivoAntigoApagavel;
				$arquivoAntigoICO = $dest . DS . 'ico_' . $ArquivoAntigoApagavel;
				$arquivoAntigoTHUMB = $dest  . DS . 'thumb_' . $ArquivoAntigoApagavel;
				$arquivoAntigoCUBE = $dest  . DS . 'cube_' . $ArquivoAntigoApagavel;
				
				
				$trahspath = $dest . DS . 'LIXO'  ;
				if(!JFolder::exists($trahspath)){
					JFolder::create($trahspath);
				}

				/*if(JFile::exists ($arquivoAntigoBK)){
					JFile::move($arquivoAntigoBK,  $trahspath . DS . 'bk_' . $ArquivoAntigoApagavel);
				}
				if(JFile::exists ($arquivoAntigoICO)){
					JFile::move($arquivoAntigoICO,  $trahspath . DS . 'ico_' . $ArquivoAntigoApagavel);
				}
				if(JFile::exists ($arquivoAntigoTHUMB)){
					JFile::move($arquivoAntigoTHUMB,  $trahspath . DS . 'thumb_' . $ArquivoAntigoApagavel);
				}
				if(JFile::exists ($arquivoAntigoCUBE)){
					JFile::move($arquivoAntigoCUBE,  $trahspath . DS . 'cube_' . $ArquivoAntigoApagavel);
				}
				if(JFile::exists ($arquivoAntigo)){
					JFile::move($arquivoAntigo,  $trahspath . DS .  $ArquivoAntigoApagavel);
				}*/
				
				$zip = new ZipArchive();
				if( $zip->open( $trahspath . DS . $ArquivoAntigoApagavel . '.zip' , ZipArchive::CREATE )  === true){
					$zip->addFile($arquivoAntigo, $ArquivoAntigoApagavel);
					$zip->addFile($arquivoAntigoBK, 'bk_' . $ArquivoAntigoApagavel);
					$zip->addFile($arquivoAntigoICO, 'ico_' . $ArquivoAntigoApagavel);
					$zip->addFile($arquivoAntigoTHUMB, 'thumb_' . $ArquivoAntigoApagavel);
					$zip->addFile($arquivoAntigoCUBE, 'cube_' . $ArquivoAntigoApagavel);
					$zip->addFromString('readme.txt' , 'Arquivo gerado por ' . $user->name  . "\n DATA " . date('d/m/Y H:i:s') );
					$zip->close();
				}
				
				
				JFile::delete($arquivoAntigo);
				JFile::delete($arquivoAntigoBK);
				JFile::delete($arquivoAntigoICO);
				JFile::delete($arquivoAntigoTHUMB);
				JFile::delete($arquivoAntigoCUBE);
			
		}
	}
	
	
	private function SalvarUploadVideo($upload, $dest, $arquivo, $descricao=''){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		

		
		$fileName = $upload ['name'];
		$fileTemp = $upload ['tmp_name'];
		$newfile = $dest . DS . 'VIDEOS' . DS  . $arquivo;
		if (JFile::exists ( $newfile )) {
			JFile::delete ( $newfile );
		}
		if (JFile::exists ( $newfile. '.zip' )) {
			JFile::delete ( $newfile. '.zip' );
		}
		if (! JFile::upload( $fileTemp, $newfile )) {
			JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
			return false;
		}
		
		$zip = new ZipArchive();
		if( $zip->open( $newfile . '.zip' , ZipArchive::CREATE )  === true){
			$zip->addFile( $newfile, $arquivo);
			$zip->addFromString('readme.txt' , 'Arquivo gerado por ' . $user->name  .  "\n DATA " . date('d/m/Y H:i:s') . "\n " . $descricao );
			$zip->close();
		}
		
		
		return true;
	}
	

	private function SalvarUploadImagem($upload, $dest, $arquivo, $tabela=null, $campo=null, $id = 0, $gerarImagens=true, $ComLogo=true, $ArquivoAntigoApagavel=null){
		$db = JFactory::getDbo();
		//Tamanho de imagens
		//    ICO   150x150 		ico		fixo
		//    Thumb 300x300			thumb
		//    Cube  300x300			cube	fixo
		//    FULL  2000x2000
		//    BACKUP				bk
		
		if(isset($upload) && JFile::exists ( $upload ['tmp_name'] )){
			
			if(isset($ArquivoAntigoApagavel) && JFile::exists ( $dest . DS . $ArquivoAntigoApagavel)){
				$this->MoverImagemoParapastaLixo($ArquivoAntigoApagavel, $dest);
			}
			
			$fileName = $upload ['name'];
			$fileTemp = $upload ['tmp_name'];
			$newfile = $dest . DS  . $arquivo;
			if (JFile::exists ( $newfile )) {
				JFile::delete ( $newfile );
			}
			if (! JFile::upload( $fileTemp, $newfile )) {
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				return false;
			} else {
				if(isset($tabela) && strlen(trim($tabela))>0 ){
					$query = $db->getQuery ( true );
					$query
						->update($db->quoteName ( $tabela ))
						->set (array ($db->quoteName ( $campo ) . ' = ' . $db->quote ( $arquivo )))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id);
					$db->setQuery ( $query );
					if(!$db->execute()){
						return false;
					}
					$this->LogQuery($query);				
				}
			}
			
			if($gerarImagens){
				//Cria backup
				JFile::copy($newfile, $dest . DS  .'bk_'. $arquivo);
//TODO USAR ESSE COMPONENTE
// 				$tipos = ConfirguacaoImagens::getTipos();
// 				foreach($tipos as $tipo){
// 				}
				$img = null;
				// Obter dados do arquivo de imagem
				$dados = getimagesize($newfile);
				
				// Determinar se o tipo de imagem e' suportado
				$tipo = $dados[2];
				if ($tipo & imagetypes()) {
					switch ($tipo) {
						case IMG_GIF:
							$img = imagecreatefromgif($newfile);
							break;
						case IMG_JPEG:
							$img = imagecreatefromjpeg($newfile);
							break;
						case IMG_PNG:
							$img = imagecreatefrompng($newfile);
							break;
						case IMG_WBMP:
							$img = imagecreatefromwbmp($newfile);
							break;
						case IMG_XPM:
							$img = imagecreatefromxpm($newfile);
							break;
						default:
							$conteudo = file_get_contents($newfile);
							$img = imagecreatefromstring($conteudo);
							break;
					}
				}
				list($width, $height) = getimagesize($newfile);
				$icowidth =  ($height < $width? $width / ($height/150): 150 );
				$icoheight = ($width < $height? $height / ($width/150): 150 );
				$thumbwidth = ($height > $width? $width / ($height/300): 300 );
				$thumbheight = ($width > $height? $height / ($width/300): 300 );
				
				$cubewidth = ($height < $width? $width / ($height/300): 300 );
				$cubeheight = ($width < $height? $height / ($width/300): 300 );
				
				$fullwidth = ($height > $width? $width / ($height/2000): 2000);
				$fullheight	= ($width > $height? $height / ($width/2000): 2000);	
	
				//ICONE É UM CUBO FIXO
				$ico = imagecreatetruecolor(150,150);
				$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
				$cube = imagecreatetruecolor(300, 300);
				$full = imagecreatetruecolor($fullwidth, $fullheight);
				
	// 			imagecopyresized($ico, $img, 0, 0, 0, 0, $icowidth, $icoheight, $width, $height );
	// 			imagecopyresized($ico, $img, 0, 0, 0, 0, $icowidth, $icoheight, $width, $height );
	// 			imagecopyresized($ico, $img, 0, 0, 0, 0, $icowidth, $icoheight, $width, $height );
				
				$logo = imagecreatefrompng(COMPONENT_AG_PATH . 'angelgirls.png');
				//$logo = imagecreatefromgif(COMPONENT_AG_PATH . 'angelgirls.gif');
				
				list($widthlogo, $heightlogo) = getimagesize(COMPONENT_AG_PATH . 'angelgirls.png');
				
				imagecopyresized($ico, $img, ($icowidth>300?(($icowidth-300)/2)*-1 :0), 0, 0, 0, $icowidth, $icoheight, $width, $height );
				imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height );
				//CENTRALIZAVA
				//imagecopyresized($cube, $img, ($cubewidth>300?(($cubewidth-300)/2)*-1 :0), ($cubeheight>300?(($cubeheight-300)/2)*-1:0), 0, 0, $cubewidth, $cubeheight, $width, $height );
				
				
				imagecopyresized($cube, $img, ($cubewidth>300?(($cubewidth-300)/2)*-1 :0), 0, 0, 0, $cubewidth, $cubeheight, $width, $height );
				imagecopyresampled($full, $img, 0, 0, 0, 0, $fullwidth, $fullheight, $width, $height );
				
				if($ComLogo){
					imagecopyresampled($ico, $logo, 80, 117, 0, 0, 65, 32, $widthlogo, $heightlogo );// FATOR 3,5076923076923076923076923076923
					imagecopyresampled($thumb, $logo, $thumbwidth-130, $thumbheight-70, 0, 0, 120, 58, $widthlogo, $heightlogo );//FATOR 1,9
					imagecopyresampled($cube, $logo, 175, 250, 0, 0, 120, 58, $widthlogo, $heightlogo );// FATO 1,9
					imagecopyresampled($full, $logo, $fullwidth - 510, $fullheight - 300, 0, 0, 500, 243, $widthlogo, $heightlogo );// FATOR 0,456
				}
				//FOTOR DO LOGO &eacute; 228x111  
	
				
				
				if(!imagejpeg($ico, $dest . DS . 'ico_' . $arquivo, 70)){
					return false;
				}
				if(!imagejpeg($thumb, $dest . DS . 'thumb_' . $arquivo, 50)){
					return false;
				}
				if(!imagejpeg($cube, $dest . DS . 'cube_' . $arquivo, 50)){
					return false;
				}
				if(!imagejpeg($full, $dest . DS . $arquivo,100)){
					return false;
				}
			}
			return true;
		}
		return false;
	}

	
	public function salvarAlteracaoFoto(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
		$id = JRequest::getInt('id', 0, 'POST');
		$titulo = JRequest::getVar('titulo', null, 'POST');
		$metaDescricao = JRequest::getVar('meta_descricao', null, 'POST');
		$descricao = JRequest::getVar('descricao', null, 'POST');
		$aplicarTodos = JRequest::getVar('aplicar_todos', 'N', 'POST');

		$erro = false;
		
		
		if($titulo=='' || strlen(trim($titulo))<=5){
			JError::raiseWarning(100,'Campo "Titulo" &eacute; obrigat&oacute;rio. Minimo de 5 caracteres.');
			$erro = true;
		}
		
		if($metaDescricao=='' || strlen(trim($metaDescricao))<=5){
			JError::raiseWarning(100,'Campo "Descri&ccedil;&atilde;o breve" &eacute; obrigat&oacute;rio. Minimo de 5 caracteres.');
			$erro = true;
		}
		
		if($metaDescricao=='' || strlen(trim($metaDescricao))<=5){
			JError::raiseWarning(100,'Campo "Descri&ccedil;&atilde;o" &eacute; obrigat&oacute;rio. Minimo de 5 caracteres.');
			$erro = true;
		}
		
		if($erro){
			$this->carregarEditarFoto();
			return;
		}
		$query = $db->getQuery ( true );
		$query->select('id_sessao')
		->from ('#__angelgirls_sessao as s')
		->join('INNER','#__angelgirls_foto_sessao as f ON s.id = f.id_sessao')
		->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		$sessao = $db->loadObject();
		
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
		->set(array (
				$db->quoteName ( 'titulo' ) . ' = ' . $db->quote(trim($titulo)),
				$db->quoteName ( 'descricao' ) . ' = ' . $db->quote(trim($descricao)),
				$db->quoteName ( 'meta_descricao' ) . ' = ' . $db->quote(trim($metaDescricao)),
				$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
		->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
		
		
		if($aplicarTodos!='S'){
			$query->where ($db->quoteName ( 'id' ) . ' = ' . $id);
		}
		else{
			$query->where ($db->quoteName ( 'id_sessao' ) . ' = ' . $sessao->id_sessao);
		}
		
		
		$db->setQuery( $query );
		$db->execute();
		$this->LogQuery($query);

		
		

		
		require_once 'views/sessoes/tmpl/editar_foto.php';
		if($aplicarTodos=='S'){
			echo("<script>jQuery('.labelsFotos',parent.document).html('".$titulo."');");
		}
		else{
			echo("<script>jQuery('#labelFoto". $id ."',parent.document).html('".$titulo."');");
		}
		echo("parent.document.AngelGirls.FrameModalHide();</script>");
		exit();
	}
	
	/**
	 * 
	 */
	public function alterarPossuiNudesFotoJSon(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id =  JRequest::getInt('id');
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
		->set(array (
				$db->quoteName ( 'possui_nudes' ) . " = CASE possui_nudes WHEN 'S' THEN 'N' ELSE 'S' END ",
				$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
				->where ($db->quoteName ( 'id' ) . ' = ' . $id)
				->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
		$db->setQuery( $query );
		$db->execute();
		$this->LogQuery($query);
		$jsonRetorno='{"ok":"ok"}';
		
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function carregarEditarFoto(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();	
		$id =  JRequest::getVar('id');
		
		$query = $db->getQuery ( true );
		$query->select('f.area_vip, f.possui_nudes, f.meta_descricao, f.descricao, f.titulo, s.token as token_sessao, f.token, f.token_imagem, f.titulo ')
		->from ('#__angelgirls_sessao as s')
		->join('INNER','#__angelgirls_foto_sessao as f ON s.id = f.id_sessao')
		->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
		->where ( $db->quoteName ( 'f.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
		->where ( $db->quoteName ( 'f.id_usuario_criador' ) . " =  " . $user->id )
		->where ( $db->quoteName ( 's.id_usuario_criador' ) . " =  " . $user->id )
		->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		
		JRequest::setVar ( 'foto', $result );
		
		require_once 'views/sessoes/tmpl/editar_foto.php';
		exit();
	}
	
	/**
	 * Remover Endereco
	 */
	public function removerFotoSessaoJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
				
				

				$query = $db->getQuery ( true );
				$query->select('s.token, f.token_imagem')
				->from ('#__angelgirls_sessao as s')
				->join('INNER','#__angelgirls_foto_sessao as f ON s.id = f.id_sessao')
				->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'f.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'f.id_usuario_criador' ) . " =  " . $user->id )
				->where ( $db->quoteName ( 's.id_usuario_criador' ) . " =  " . $user->id )
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $id );
				$db->setQuery ( $query );
				$result = $db->loadObject();
				
				if(isset($result)){
					$this->MoverImagemoParapastaLixo($result->token_imagem, PATH_IMAGEM_SESSOES . $result->token);
				}
				
				
				
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				$this->LogQuery($query);
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"Imagem n&atilde;o encontrada."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	
	/**
	 * Remover Endereco
	 */
	public function removerVideoSessaoJson(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
	
	
		$id  = JRequest::getString ( 'id', null, 'POST' );
		$jsonRetorno="";
	
		$mensagensErro = "";
	
		if(isset($id) && $id!=0){
			try {
	
		
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_video_sessao' ))
				->set(array (
						$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
						$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				$this->LogQuery($query);
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
			}
		}
		else{
			$jsonRetorno='{"ok":"nok", "menssagem":"V&iacute;deo n&atilde;o encontrado."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	public function removerSessao(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id  = JRequest::getString ( 'id', 0);
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
		->set(array (
				$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
				$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
				->where ($db->quoteName ( 'id_sessao' ) . ' = ' . $id)
				->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
		$db->setQuery( $query );
		$db->execute();
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_sessao' ))
		->set(array (
				$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
				$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
				$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
				->where ($db->quoteName ( 'id' ) . ' = ' . $id)
				->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
		$db->setQuery( $query );
		$db->execute();
		
		JFactory::getApplication()->enqueueMessage(JText::_('Sess&atilde;o removida com sucesso!'));
		$this->carregarMinhasSessoes();
	}
	
	
	/**
	 * 
	 */
	public function enviarVideoSessao(){
		$db = JFactory::getDbo();
	
		$user = JFactory::getUser();
		$idSessao =  JRequest::getInt('id_sessao',null,'POST');
		
		$idVideo =  JRequest::getInt('id',null,'POST');
		$titulo =  JRequest::getString('titulo',null,'POST');
		$descricao =  JRequest::getString('descricao',null,'POST');
		$metaDescricao =  JRequest::getString('meta_descricao',null,'POST');
		$tipo =  JRequest::getString('tipo',null,'POST');
		$video = $foto_perfil = $_FILES ['video'];
		$mensagem = '';
		

		if(strlen(trim($descricao))<5){
			$mensagem = $mensagem . "O campo \\\"Descri&ccedil;&atilde;o\\\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
		}
		if(strlen(trim($titulo))<5){
			$mensagem = $mensagem . "O campo \\\"Titulo\\\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
		}
		if(strlen(trim($metaDescricao))<5){
			$mensagem = $mensagem . "O campo \\\"Descri&ccedil;&atilde;o Breve\\\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
		}
		if(strlen(trim($tipo))==''){
			$mensagem = $mensagem . "O campo \\\"Tipo\\\" &eacute; um campo obrigat&oacute;rio!<br/>";
		}
		
		if((!isset($idSessao) || $idSessao == '' || $idSessao==0 ) && (!isset($video) || !JFile::exists($video ['tmp_name']))) {
			$mensagem = $mensagem . "O campo \\\"V&iacute;deo\\\" &eacute; um campo obrigat&oacute;rio!<br/><strong><b>Se exibir essa mensagem mesmo selecionado o arquivo deve ser porque o arquivo est&aacute; muito grande.</strong></b><br/>O v&iacute;deo deve conter no m&aacute;ximo 2 minutos e 60 megabytes, o formato deve ser MP4 compacta&ccedil;&atilde;o H.264 em HD (720p) ou Super HD (1080p). Recomendado em 24fps.";
		}
		
		
		
	
		$jsonRetorno = "";
	

				
		if(strlen(trim($mensagem))>0){
			$jsonRetorno= '{"ok":"nok","mensagem":"'.$mensagem.'"}';
		}
		else{	
				
			if(isset($idVideo) && $idVideo > 0){
				$query = $db->getQuery ( true );
				$query->update ( $db->quoteName ( '#__angelgirls_video_sessao' ) )->set ( array (
						$db->quoteName ( 'data_alterado' ) . ' = NOW() ',
						$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id,
						$db->quoteName ( 'titulo' ) . ' = ' . $db->quote($titulo),
						$db->quoteName ( 'descricao' ) . ' = ' . $db->quote($descricao),
						$db->quoteName ( 'meta_descricao' ) . ' = ' . $db->quote($metaDescricao),
						$db->quoteName ( 'tipo' ) . ' = ' . $db->quote($tipo),
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' .$db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id' ) . ' = ' . $idVideo)
				->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
				$db->setQuery ( $query );
				$db->execute ();
				$this->LogQuery($query);
				
				$jsonRetorno= '{"ok":"ok","mensagem":""}';
			}
			else{
	
				if (isset($video) && JFile::exists($video ['tmp_name'])) {
					$arquivoArray =  explode( '.', $video['name']);
					if(strtolower(trim($arquivoArray[sizeof($arquivoArray)-1]))=='mp4') {
						
						$query = $db->getQuery ( true );
						$query->select('CASE isnull(max(ordem)) WHEN 0 THEN max(ordem)+1 ELSE 1 END AS ORDEM ')
						->from (  '#__angelgirls_video_sessao')
						->where ('id_sessao  =  ' . $idSessao);
						$db->setQuery ( $query );
						$max = $db->loadObject();
						
						
						$query = $db->getQuery ( true );
						$query->select('token')
						->from ('#__angelgirls_sessao')
						->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
						->where ( $db->quoteName ( 'id_usuario_criador' ) . " =  " . $user->id )
						->where ( $db->quoteName ( 'id' ) . " =  " . $idSessao );
						$db->setQuery ( $query );
						$result = $db->loadObject();
				
						if(isset($result) && isset($result->token) && strlen(trim($result->token))>=1){
							$token = "";
							$contador=0;
							do{
								$token = $this->GerarToken($video['name'] , ($contador.$idSessao.intval(date('su')) ), true, false);
								$query = $db->getQuery ( true );
								$query->select('id')
								->from (  '#__angelgirls_video_sessao')
								->where ('token  =  ' . $db->quote($token));
								$db->setQuery ( $query );
								$results = $db->loadObjectList();
								++$contador;
							}while(isset($results) && isset($results->id) && $results->id > 0 );
				
				
				
							$query = $db->getQuery ( true );
							$query->insert( $db->quoteName ( '#__angelgirls_video_sessao' ) )
							->columns(array(
								$db->quoteName ( 'status_dado' ),
								$db->quoteName ( 'data_criado' ),
								$db->quoteName ( 'id_usuario_criador' ),
								$db->quoteName ( 'data_alterado' ),
								$db->quoteName ( 'id_usuario_alterador' ),
								$db->quoteName ( 'titulo' ),
								$db->quoteName ( 'meta_descricao' ),
								$db->quoteName ( 'descricao' ),
								$db->quoteName ( 'tipo' ),
								$db->quoteName ( 'token' ),
								$db->quoteName ( 'id_sessao' ),
								$db->quoteName ( 'ordem' ),
								$db->quoteName ( 'host_ip_criador' ),
								$db->quoteName ( 'host_ip_alterador' )))
							->values ( implode ( ',', array (
									'\'NOVO\'',
									'NOW()',
									$user->id,
									'NOW()',
									$user->id,
									$db->quote($titulo),
									$db->quote($metaDescricao),
									$db->quote($descricao),
									$db->quote($tipo),
									$db->quote($token),
									$idSessao,
									$max->ORDEM,
									$db->quote($this->getRemoteHostIp()),
									$db->quote($this->getRemoteHostIp())
							)));
							$db->setQuery( $query );
							$db->execute();
							$idVideo = $db->insertid();
							$this->LogQuery($query);
								
								
							$arquivo = $this->GerarNovoNomeArquivo($video['name'], $idVideo );
							
							
							
							$query = $db->getQuery ( true );
							$query->update ( $db->quoteName ( '#__angelgirls_video_sessao' ) )
								->set(array ($db->quoteName ( 'arquivo' ) . ' = ' . $db->quote($arquivo)))
							->where ($db->quoteName ( 'id' ) . ' = ' . $idVideo)
							->where ($db->quoteName ( 'id_usuario_criador' ) . ' = ' . $user->id);
							$db->setQuery ( $query );
							$db->execute ();
							$this->LogQuery($query);
							
							
							
								
							$this->SalvarUploadVideo($video, PATH_IMAGEM_SESSOES . $result->token . DS, $arquivo, "Sess&atilde;o  \"$titulo\" ID $idSessao ID-VIDEO $idVideo");
			
		
		//					echo($arquivo);exit();
			
			
							$jsonRetorno= '{"ok":"ok","mensagem":""}';
						}
						else{
							$jsonRetorno= '{"ok":"nok","mensagem":"Sess&atilde;o n&atilde;o localizada, ou n&atilde;o tem permiss&atilde;o para isso."}';
						}
					}
					else{
						$jsonRetorno= '{"ok":"nok","mensagem":"Falha ao enviar o arquivo, o arquivo n&atilde;o &eacute; no formato MP4.  Deve conter no m&aacute;ximo 2 minutos, e 60 megabytes, o formato deve ser MP4 compcta&ccedil;&atilde;o H2164 em HD (720p) ou Super HD (1080p)  recomendado em 24fps."}';
					}
				}
				else{
					$jsonRetorno= '{"ok":"nok","mensagem":"Falha ao enviar o arquivo, o arquivo que envio deve ser muito grande, tente novamente com um arquivo menor.<br/> Deve conter no m&aacute;ximo 2 minutos e 60 megabytes, o formato deve ser MP4 compacta&ccedil;&atilde;o H.264 em HD (720p) ou Super HD (1080p). Recomendado em 24fps."}';
				}
			}
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	/**
	 *
	 */
	public function enviarFotosSessao(){
		$db = JFactory::getDbo();
		
		$user = JFactory::getUser();
		$id =  JRequest::getVar('id',null,'POST');
		$imagem = $foto_perfil = $_FILES ['imagem']; 
		
		$jsonRetorno = "";

		if (isset($imagem) && JFile::exists($imagem ['tmp_name'])) {
			
			$query = $db->getQuery ( true );
			$query->select('CASE isnull(max(ordem)) WHEN 0 THEN max(ordem)+1 ELSE 1 END AS ORDEM ')
			->from (  '#__angelgirls_foto_sessao')
			->where ('id_sessao  =  ' . $id);
			$db->setQuery ( $query );
			$max = $db->loadObject();
			
			
			$query = $db->getQuery ( true );
			$query->select('token, nome_foto')
			->from ('#__angelgirls_sessao')
			->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::PUBLICADO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
			->where ( $db->quoteName ( 'id_usuario_criador' ) . " =  " . $user->id )
			->where ( $db->quoteName ( 'id' ) . " =  " . $id );
			$db->setQuery ( $query );
			$result = $db->loadObject();

			if(isset($result) && isset($result->token) && strlen(trim($result->token))>=1){
				$token = "";
				$contador=0;
				do{
					$token = $this->GerarToken($imagem['name'] , ($contador.$id.intval(date('su')) ), true, false);
					$query = $db->getQuery ( true );
					$query->select('id')
					->from (  '#__angelgirls_foto_sessao')
					->where ('token  =  ' . $db->quote($token));
					$db->setQuery ( $query );
					$results = $db->loadObjectList();
					++$contador;
				}while(isset($results) && isset($results->id) && $results->id > 0 );

				
				
				$NomeArquivoArray = explode ( '.', $imagem['name'] );
				
				
				
				$query = $db->getQuery ( true );
				$query->insert( $db->quoteName ( '#__angelgirls_foto_sessao' ) )
					->columns(array(
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'titulo' ),
					$db->quoteName ( 'meta_descricao' ),
					$db->quoteName ( 'token' ),
					$db->quoteName ( 'id_sessao' ),
					$db->quoteName ( 'ordem' ),
					$db->quoteName ( 'host_ip_criador' ),
					$db->quoteName ( 'host_ip_alterador' )))
					->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$user->id,
							'NOW()',
							$user->id,
							$db->quote($NomeArquivoArray[0]),
							$db->quote($NomeArquivoArray[0]),
							$db->quote($token),
							$id,
							$max->ORDEM,
							$db->quote($this->getRemoteHostIp()),
							$db->quote($this->getRemoteHostIp())
					)));
					$db->setQuery( $query );
					$db->execute();
					$idFoto = $db->insertid();
					$this->LogQuery($query);
					
					
				  $arquivo = $this->GerarNovoNomeArquivo($imagem['name'], $idFoto );
				  


				  

				  $query = $db->getQuery ( true );
				  $query->update($db->quoteName('#__angelgirls_foto_sessao' ))
				  ->set(array($db->quoteName ( 'token_imagem' ) . ' = ' . $db->quote($arquivo) .'  '))
				  ->where ($db->quoteName ( 'id' ) . ' = ' . $idFoto)
				  ->where ($db->quoteName ( 'id_sessao' ) . ' = ' . $id);
				  $db->setQuery ( $query );
				  $db->execute ();
				  
	
				  
							
				$this->SalvarUploadImagem($imagem,
						PATH_IMAGEM_SESSOES . $result->token .DS,
						$arquivo,
						null,null,$id,true,true);
				
				
				$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':foto-sensual-'.strtolower(str_replace(" ","-",$foto->titulo)));
				$urlIco = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$token.':ico');
				$urlcube = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$token.':cube');
				$urlthumb = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$token.':thumb');
				
				
				$jsonRetorno= '{"ok":"ok","mensagem":"","token":"'.$token.'","id":"'.$idFoto.'","token":"'.$token.'","titulo":"'.$NomeArquivoArray[0] . 
				 					'","meta_descricao":"'.$imagem['name'].'","descricao":"","url":"'.$url.'","ico":"'.$urlIco.'","cube":"'.$urlcube.'","thumb":"'.$urlthumb.'"}';
			}
			else{
				$jsonRetorno= '{"ok":"nok","mensagem":"Sess&atilde;o n&atilde;o localizada, ou n&atilde;o tem permiss&atilde;o para isso."}';
			}
		}
		else{
			$jsonRetorno= '{"ok":"nok","mensagem":"Falha ao enviar o arquivo."}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	private function getSessaoById($id){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();

		
		
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`tipo`,`s`.`nome_foto`,`s`.`token`,`s`.`executada`,`s`.`descricao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
			`s`.`comentario_equipe`,`s`.`meta_descricao`,`s`.`id_agenda`,`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
			`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
			`s`.`audiencia_gostou`,`s`.`audiencia_ngostou`,`s`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
			`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,`s`.`status_modelo_principal`,`s`.`status_modelo_secundaria`,`s`.`status_fotografo_principal`,`s`.`status_fotografo_secundario`,
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
			->where ('(((' . $db->quoteName ( 's.id_usuario_criador' ) . ' = ' . $user->id.' AND '. $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . '))
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_principal` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.')  AND `s`.`status_fotografo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_secundario` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.') AND `s`.`status_fotografo_secundario` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_principal` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_secundaria` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_secundaria` = 0 )
				) OR (' . $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::PUBLICADO) . ') AND s.publicar <= NOW() ))' )
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
			$var =explode(':',$id); 
			$id = $var[0];
		}



		
		$result = $this->getSessaoById($id);

		if(!isset($result)){
			$this->RegistroNaoEncontado();
			return;
		}
		
		if($result->status_dado == StatusDado::PUBLICADO){
			$query = $db->getQuery ( true );
			$query->update($db->quoteName('#__angelgirls_sessao' ))
			->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
			->where ($db->quoteName ( 'id' ) . ' = ' . $id);
			$db->setQuery ( $query );
			$db->execute ();
		}
		
		JRequest::setVar ( 'sessao', $result );


		JRequest::setVar ( 'fotos', $this->runFotoSessao($user, 0, $id, $this::LIMIT_DEFAULT) );
		
		JRequest::setVar ( 'perfil', $this::getPerfilLogado() );
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'sessao' );
		parent::display (true, false);
	}
	
	public function carregarFotosContinuaHtml(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		

		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
		
		
		$posicao = JRequest::getString( 'posicao');
		
		$results = $this->runFotoSessao($user, $posicao, $id, $this::LIMIT_DEFAULT );
		
		JRequest::setVar('fotos', $results);
		
		
		$sessao = $this->getSessaoById($id);
		

		JRequest::setVar('sessao', $sessao);
		
		
		
		require_once 'views/sessoes/tmpl/fotos.php';		


		exit();	
	}
	
	
	public function carregarVideosContinuaHtml(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
	
	
		$id = JRequest::getString('id',0);
		if(!(strpos($id,':')===false)){
			$var =explode(':',$id); 
			$id = $var[0];
		}
		$results = $this->runVideosSessao($user, $id );
		JRequest::setVar('videos', $results);
	
		require_once 'views/sessoes/tmpl/lista_videos.php';
	
		exit();
	}
	
	
	
	public function verVideo(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
	}
	
	
	private function runVideosSessao($user, $iSessao){
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select('`s`.`id`,`s`.`titulo`,`s`.`descricao`, `s`.`meta_descricao`, `s`.`id_sessao`,`s`.`url_youtube`,`s`.`id_youtube`,`s`.`id_vimeo`,
				`s`.`url_vimeo`,`s`.`arquivo`,`s`.`token`,`s`.`tipo`,
			CASE isnull(`vt_video`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`, `s`.`id_sessao` as `sessao`')
				->from ( $db->quoteName ( '#__angelgirls_video_sessao', 's' ) )
				->join ( 'LEFT', '(SELECT data_criado, id_video FROM #__angelgirls_vt_video_sessao WHERE id_usuario='.$user->id.') vt_video ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName('vt_video.id_video'))
				->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
				->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $iSessao);
		$query->order('`s`.`ordem`');
		$db->setQuery ( $query );
	
		$results = $db->loadObjectList();
		//JRequest::setVar ( 'fotos', $results );
		return $results;
	}

	
	private function runFotoSessao($user, $posicao, $iSessao, $limit = 0 ){
		$db = JFactory::getDbo ();
		
		$query = $db->getQuery ( true );
		$query->select('`s`.`possui_nudes`, `s`.`area_vip`, `s`.`id`,`s`.`titulo`,`s`.`descricao`,`s`.`meta_descricao`, `s`.`audiencia_gostou`,s.token_imagem, s.token,
			CASE isnull(`vt_sessao`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`, `s`.`id_sessao` as `sessao`')
			->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 's' ) )
			->join ( 'LEFT', '(SELECT data_criado, id_foto FROM #__angelgirls_vt_foto_sessao WHERE id_usuario='.$user->id.') vt_sessao ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName('vt_sessao.id_foto'))
			->where ( $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ') ' )
			->where ( $db->quoteName ( 's.id_sessao' ) . " =  " . $iSessao);
			if( !isset($user) || $user->id <= 0){
				$query->where ( $db->quoteName ( 's.possui_nudes' ) . " = 'N'");
			} 
			$query->order('`s`.`ordem` ');
		if($limit>0){
			$query->setLimit($limit, $posicao);
		}
		$db->setQuery ( $query );

		$results = $db->loadObjectList();
		//JRequest::setVar ( 'fotos', $results );
		return $results;
	}
	
	
	
	public function loadVideo(){
	
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id = JRequest::getString('id','');
		$tipo = "";
	
	
	
		if(!(strpos($id,':')===false)){
			$arr = explode(':',$id);
			$id = $arr[0];
			$tipo=$arr[1];
		}
		else{
			$tipo = JRequest::getString('descricao','');
		}
		$view = JRequest::getString( 'view','');
		$arquivo = "";
	
	
	
		$logado = ( isset($user) && $user->id > 0);
		$nomeArquivo = '';
	
		if($view=='sessoes'){
			$query = $db->getQuery ( true );
			$query->select('`v`.`arquivo`, `v`.`titulo`, `s`.`token`')
			->from ( $db->quoteName ( '#__angelgirls_sessao', 's' ) )
			->join ('INNER', $db->quoteName ( '#__angelgirls_video_sessao', 'v' ) . ' ON v.id_sessao = s.id' )
			->where ( $db->quoteName ( 'v.token' ) . " =  " . $db->quote($id) )
			->where (' s.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_SESSOES .  $result->token . DS . 'VIDEOS' . DS . $result->arquivo;
				$nomeArquivo = $result->titulo.'.mp4';
			}
			
		}


		$this->EnviarArquivo($arquivo, 'video/mp4',$nomeArquivo);

	}
	
	private function EnviarArquivo($arquivo, $mime, $nome=null){
		$fp = @fopen($arquivo, 'rb');
		$size   = filesize($arquivo); // File size
		$length = $size;           // Content length
		$start  = 0;               // Start byte
		$end    = $size - 1;       // End byte
		header('Content-type: '.$mime);
		header("Accept-Ranges: 0-$length");
		if(isset($nome)){
			header('Content-Disposition: inline; filename="'.$nome.'"');
		}
		if (isset($_SERVER['HTTP_RANGE'])) {
			$c_start = $start;
			$c_end   = $end;
			list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
			if (strpos($range, ',') !== false) {
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				exit;
			}
			if ($range == '-') {
				$c_start = $size - substr($range, 1);
			}else{
				$range  = explode('-', $range);
				$c_start = $range[0];
				$c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
			}
			$c_end = ($c_end > $end) ? $end : $c_end;
			if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				exit;
			}
			$start  = $c_start;
			$end    = $c_end;
			$length = $end - $start + 1;
			fseek($fp, $start);
			header('HTTP/1.1 206 Partial Content');
		}
		header("Content-Range: bytes $start-$end/$size");
		header("Content-Length: ".$length);
		$buffer = 1024 * 8;
		while(!feof($fp) && ($p = ftell($fp)) <= $end) {
			if ($p + $buffer > $end) {
				$buffer = $end - $p + 1;
			}
			set_time_limit(0);
			echo fread($fp, $buffer);
			flush();
		}
		fclose($fp);
		exit();
	}
	
	
	
	public function loadImage(){
		//Tamanho de imagens
		//    ICO   150x150 		ico		fixo
		//    Thumb 300x300			thumb
		//    Cube  300x300			cube	fixo
		//    FULL  2000x2000
		//    BACKUP				bk		

		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$id = JRequest::getString('id','');
		$tipo = "";

		
		
		if(!(strpos($id,':')===false)){
			$arr = explode(':',$id);
			$id = $arr[0];
			$tipo=$arr[1];
		}
		else{
			$tipo = JRequest::getString('descricao','');
		}
		$view = JRequest::getString( 'view','');
		$arquivo = "";
		$mime = 'image/jpeg';
		$ArquivoNaoEncontrato = COMPONENT_AG_PATH . 'no_image2.png';
		$NaoLogado = COMPONENT_AG_PATH . 'no_logado.png';
		$AreaVIP = COMPONENT_AG_PATH . 'no_logado.png';
		
		$nomeArquivo  = null;
		
		$logado = ( isset($user) && $user->id > 0); 
		
		
		if($view=='fotosessao'){
			
			$query = $db->getQuery ( true );
			$query->select('`f`.`token_imagem` AS foto_token, f.titulo, s.token AS sessao_token, f.area_vip, f.possui_nudes')
			->from ( $db->quoteName ( '#__angelgirls_foto_sessao', 'f' ) )
			->join ('INNER', $db->quoteName ( '#__angelgirls_sessao', 's' ) . ' ON f.id_sessao = s.id')
			->where ( $db->quoteName ( 'f.token' ) . ' = ' . $db->quote($id) )
			->where (' f.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
			->where (' s.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
			
			if(isset($result)){
				if(!$logado && $result->possui_nudes=='S'){
					$arquivo = $NaoLogado;
				}
				else{
					if ($tipo=='full'){
						$query = $db->getQuery ( true );
						$query->update($db->quoteName('#__angelgirls_foto_sessao' ))
								->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
								->where ($db->quoteName ( 'id' ) . ' = ' . $db->quote($id));
						$db->setQuery ( $query );
						$db->execute ();
					}
					$arquivo =  PATH_IMAGEM_SESSOES . $result->sessao_token . DS . (trim(strtolower($tipo)) != 'full'? trim(strtolower($tipo)) . '_':'')  . $result->foto_token;
					$nomeArquivo = $result->titulo;
				}

//				TODO CONTROLE IMAGEM DA &aacute;REA VIP
// 				if($logado && $result->area_vip='S'){
// 					$perfil = $this::getPerfilLogado();
// 					if($perfil->vip!='S' || intval(DateTime::createFromFormat('Y-m-d H:i:s', $perfil->vencimento_vip)->format('Ymd')) < intval( date('Ymd'))){
// 						$arquivo = $AreaVIP;
// 					}
// 				}
			}
		}
		else if($view=='sessoes'){
			$query = $db->getQuery ( true );
			$query->select('`s`.`nome_foto` AS `foto`, `s`.`token`, s.titulo')
			->from ( $db->quoteName ( '#__angelgirls_sessao', 's' ) )
			->where ( $db->quoteName ( 's.token' ) . " =  " . $db->quote($id) )
			->where (' s.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_SESSOES . $result->token . DS . (trim(strtolower($tipo)) != 'full'? trim(strtolower($tipo)) . '_':'') . $result->foto;
				$nomeArquivo = $result->titulo;
			}
			//echo($arquivo );exit();
		}
		else if($view=='fotoalbum'){
			$detalhe = explode ( ' ', $tipo );
			if ($detalhe[1]=='full'){
				$arquivo =  $path .  DS. 'albuns' .DS . $detalhe[0] . DS . $id  . '.jpg';
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_foto_album' ))
					->set(array($db->quoteName ( 'audiencia_view' ) . ' = (' . $db->quoteName ( 'audiencia_view' ) .' + 1) '))
					->where ($db->quoteName ( 'id' ) . ' = ' . $db->quote($id))
					->where (' f.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' )
					->where (' a.status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
				$db->setQuery ( $query );
				$db->execute ();
			}

			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_arquivo` AS `foto`, `f`.`id_album`, `f`.`token`, `f`.`token` AS foto_token, a.token AS album_token')
			->from ( $db->quoteName ( '#__angelgirls_foto_album', 'f' ) )
			->join('INNER', $db->quoteName ( '#__angelgirls_album', 'a' ) . ' ON f.id_album = a.id' )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $db->quote($id) )
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
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $db->quote($id) );
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
				$query->select('`f`.`foto_perfil` AS `foto`, `f`.`nome_artistico` as `nome` ');
			}
			else if ($detalhe[1]=='medium'){
				$query->select('`f`.`foto_inteira` AS `foto`, `f`.`nome_artistico` as `nome`');
			}
			else if ($detalhe[1]=='horizontal'){
				$query->select('`f`.`foto_inteira_horizontal` AS `foto`, `f`.`nome_artistico` as `nome`');
			}
			else {
				$query->select('`f`.`foto_perfil` AS `foto`, `f`.`nome_artistico` as `nome`');
			}
			$query->from ( $db->quoteName ( '#__angelgirls_modelo', 'f' ) )
			->where ( $db->quoteName ( 'f.id' ) . " =  " . $db->quote($id) )
			->where (' status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_MODELOS . $result->foto;
				$nomeArquivo = $result->nome;
			}
		}
		else if($view=='fotografo'){
			$query = $db->getQuery ( true );
			$query->select('`f`.`nome_foto` AS `foto`, `f`.`nome_artistico` as `nome`')
				->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
				->where ( $db->quoteName ( 'f.id' ) . " =  " . $db->quote($id) )
				->where (' status_dado NOT IN ( ' . $db->quote(StatusDado::REMOVIDO) . ')' );
			$db->setQuery ( $query );
			$result = $db->loadObject();
			if(isset($result)){
				$arquivo =  PATH_IMAGEM_FOTOGRAFOS . $result->foto;
				$nomeArquivo = $result->nome;
			}
		}
		
		//header("Cache-Control: public ");
		if(JFile::exists( $arquivo )){
			$imageInfo = getimagesize($arquivo);
			$extencao='';
			switch ($imageInfo[2]) {
				case IMAGETYPE_JPEG:
					$mime="image/jpg";
					$extencao='.jpeg';
					break;
				case IMAGETYPE_GIF:
					$mime="image/gif";
					$extencao='.gif';
					break;
				case IMAGETYPE_PNG:
					$mime="image/png";
					$extencao='.png';
					break;
				default:
					$mime="image/jpg";
					$extencao='.jpeg';
			}
			//header ("Content-Type: $mime");
			//header("Content-Length: " . filesize($arquivo));
			//readfile($arquivo );
			$this->EnviarArquivo($arquivo, $mime, $nomeArquivo.$extencao);
			//header("X-Sendfile: $arquivo");
		}
		else{
			header ('Content-Type: image/png');
			header("Content-Length: " . filesize($ArquivoNaoEncontrato));
			readfile($ArquivoNaoEncontrato);			
		}
		exit();
	}
	
	
	
	
	private function runQueryFilterSessoes($user, $nome, $posicao, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem, $minha = 'N',$ComLimite =true ){
		$db = JFactory::getDbo ();
		$user = JFactory::getUser();
		$query = $db->getQuery ( true );
		$query->select("`s`.`id` AS `id`,
					`s`.`titulo` AS `nome`,
					`s`.`token`,
				    `s`.`titulo` AS `alias`,
				    `s`.`data_alterado` AS `modified`,
				    `s`.`nome_foto` AS `foto`,
				    `s`.`executada` AS `realizada`, `s`.`status_fotografo_principal`, `s`.`status_modelo_principal`, `s`.`status_fotografo_secundario`, `s`.`status_modelo_secundaria`,
				    `s`.`audiencia_gostou` AS `gostou`
					,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
					`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`, s.status_dado,
				    CASE isnull(`v`.`data_criado` ) WHEN 1 THEN 'NAO' ELSE 'SIM' END AS `eu` ,
					`mod1`.`nome_artistico` AS `modelo1`,`mod1`.`foto_perfil` AS `foto_mod1`,`mod1`.`audiencia_gostou` AS `gostou_mo1`, `mod1`.`meta_descricao` AS `desc_mo1` ,
					`mod2`.`nome_artistico` AS `modelo2`,`mod2`.`foto_perfil` AS `foto_mod2`,`mod2`.`audiencia_gostou` AS `gostou_mo2`, `mod2`.`meta_descricao` AS `desc_mo2` ,
					`fot1`.`nome_artistico` AS `fotografo1`,`fot1`.`audiencia_gostou` AS `gostou_fot1`,`fot1`.`nome_foto` AS `foto_fot1`, `fot1`.`meta_descricao` AS `desc_fot1` ,
					`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`, `fot2`.`meta_descricao` AS `desc_fot2`")
		->from ($db->quoteName ('#__angelgirls_sessao', 's' ))
		->join ( 'INNER', '#__angelgirls_modelo AS mod1 ON (mod1.id = s.id_modelo_principal)' )
		->join ( 'INNER', '#__angelgirls_fotografo AS fot1 ON (fot1.id = s.id_fotografo_principal)' )
		->join ( 'LEFT', '#__angelgirls_modelo AS mod2 ON (mod2.id = s.id_modelo_secundaria)' )
		->join ( 'LEFT', '#__angelgirls_fotografo AS fot2 ON (fot2.id = s.id_fotografo_secundario)' )
		->join ( 'LEFT', '(SELECT `data_criado`, `id_sessao` FROM `#__angelgirls_vt_sessao` WHERE `id_usuario`='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  );
		if($minha=='T'){
			$query->where ('((' . $db->quoteName ( 's.id_usuario_criador' ) . ' = ' . $user->id.' AND '. $db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . '))
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_principal` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.')  AND `s`.`status_fotografo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_fotografo_secundario` IN (SELECT id FROM #__angelgirls_fotografo WHERE id_usuario = ' . $user->id.') AND `s`.`status_fotografo_secundario` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_principal` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_principal` = 0 )
				 OR ('. $db->quoteName ( 's.status_dado' ) . ' IN (' . $db->quote(StatusDado::ANALIZE) . ') AND  `s`.`id_modelo_secundaria` IN (SELECT id FROM #__angelgirls_modelo WHERE id_usuario = ' . $user->id.') AND `s`.`status_modelo_secundaria` = 0 )
				)');
		}
		elseif($minha=='S'){
			$query->where($db->quoteName ( 's.id_usuario_criador' ) . ' = ' . $user->id)
			->where($db->quoteName ( 's.status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::PUBLICADO) . ')')
			->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " );
		}
		else{
			$query->where ('s.status_dado  IN (' . $db->quote(StatusDado::PUBLICADO) . ') ')
			->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " );			
		}
		
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
				$query->order('`s`.`publicar` DESC, `s`.`data_criado` DESC ');
			}
			elseif($ordem == 2){
				$query->order('`s`.`publicar` ASC, `s`.`data_criado` ASC ');
			}
			elseif($ordem == 3){
				$query->order('`s`.`titulo` ASC, `s`.`data_criado` DESC ');
			}
			elseif($ordem == 4){
				$query->order('`s`.`titulo` DESC, `s`.`data_criado` DESC ');
			}
			else{
				$query->order('`s`.`publicar` DESC, `s`.`data_criado` DESC,  `s`.`status_dado` ');
			}
		}
		else{
			$query->order('`s`.`publicar` DESC, `s`.`data_criado` DESC,  `s`.`status_dado` ');
		}
		if($ComLimite){
			$query->setLimit($this::LIMIT_DEFAULT, $posicao);
		}
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
		$minha = JRequest::getInt( 'somente_minha', null);
		

		$results = $this->runQueryFilterSessoes($user, $nome, $posicao, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem, $minha );
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
		$minha = JRequest::getInt( 'somente_minha', null);
		
		$db = JFactory::getDbo ();
		
		JRequest::setVar ( 'sessoes', $this->runQueryFilterSessoes($user, $nome, 0, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem, $minha ));

		JRequest::setVar ( 'modelos', $this->getAllModelos() );

		JRequest::setVar ( 'fotografos', $this->getAllFotografos() );
		
		JRequest::setVar ( 'perfil', $this::getPerfilLogado() );
		
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display ();
	}
	
	
	public function carregarMinhasSessoes(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null);
	
		$posicao = JRequest::getInt( 'posicao', null);
	
		$idModelo = JRequest::getInt( 'id_modelo', null);
		$idFotografo = JRequest::getInt( 'id_fotografo', null);
		$dataInicio = JRequest::getString( 'data_inicio', null);
		$dataFim = JRequest::getString( 'data_fim', null);
		$ordem = JRequest::getInt( 'ordem', 3);
		$db = JFactory::getDbo ();
	
		JRequest::setVar ( 'sessoes', $this->runQueryFilterSessoes($user, $nome, 0, $idModelo, $idFotografo, $dataInicio, $dataFim, $ordem,'T',false));
	
		JRequest::setVar ( 'modelos', $this->getAllModelos() );
	
		JRequest::setVar ( 'fotografos', $this->getAllFotografos() );
	
		JRequest::setVar ( 'perfil', $this::getPerfilLogado() );
	
	
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'minha_sessoes' );
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
			$var =explode(':',$id); 
			$id = $var[0];
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
	
	public function inboxMensagens(){ 
		$caixa = JRequest::getString('caixa','INBOX');
		JRequest::setVar('mensagens', $this->getMessagesInbox($caixa));
		
		
		
		
		JRequest::setVar('view', 'inbox');
		JRequest::setVar('layout', 'default');
		parent::display();
	}
	
	public function inboxMensagensHTML(){
		$caixa = JRequest::getString('caixa','INBOX');
		JRequest::setVar('mensagens', $this->getMessagesInbox($caixa));


		
		require_once 'views/inbox/tmpl/caixa.php';
		exit();
	}
	
// ****************************************************************************************************************************************
// ************************************************           MENSAGENS          **********************************************************
// ****************************************************************************************************************************************

	public function getMessageToReadJson(){
		$caixa = JRequest::getString('caixa','INBOX');
		$token = JRequest::getString('token',null);
		$mensage = $this->getMessagesInbox($caixa, $token);
		$jsonRetorno = json_encode($mensage);
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
	private function getMessagesInbox($caixa = 'INBOX', $token = null){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$query = $db->getQuery ( true );
		$query->select('`remetente`.`name` as `nome_remetente`,
						`destinatario`.`name` as `nome_destinatario`,
			`m`.`id`,
			`m`.`id_resposta`,
			`m`.`titulo`,
			`m`.`id_usuario_destino`,
			`m`.`mensagem`,
			`m`.`token`,
			`m`.`tipo`,
			`m`.`status_dado`,
			`m`.`id_usuario_remetente`,
			`m`.`status_remetente`,
			`m`.`status_destinatario`,
			`m`.`lido_remetente`,
			`m`.`lido_destinatario`,
			`m`.`flag_remetente`,
			`m`.`flag_destinatario`,
	 		`m`.`data_criado`,
			`m`.`enviado`,
	 		`m`.`data_lida`,
			\''. $caixa . '\' AS `caixa`,
			CASE ISNULL(`respondido`.`id`) WHEN 1 THEN \'NAO\'  ELSE \'SIM\' END AS `respondido`,
			`m`.`host_ip_criador`,
			`m`.`host_ip_alterador`')
					->from($db->quoteName ( '#__angelgirls_mensagens','m'))
					->join('INNER', $db->quoteName ( '#__users', 'remetente' ) . ' ON ' . $db->quoteName ( 'remetente.id' ) . ' = ' . $db->quoteName ( 'm.id_usuario_remetente' ))
					->join('INNER', $db->quoteName ( '#__users', 'destinatario' ) . ' ON ' . $db->quoteName ( 'destinatario.id' ) . ' = ' . $db->quoteName ( 'm.id_usuario_destino' ))
					->join('LEFT', $db->quoteName ( '#__angelgirls_mensagens', 'respondido' ) . ' ON ' . $db->quoteName ( 'respondido.id_resposta' ) . ' = ' . $db->quoteName ( 'm.id' ));
		if($caixa == 'INBOX'){
			$query->where($db->quoteName ( 'm.id_usuario_destino' ) . ' = ' . $user->id)
			->where($db->quoteName ( 'm.status_destinatario' ) . ' = ' . $db->quote(StatusMensagem::NOVO))
			->where($db->quoteName ( 'm.status_remetente' ) . ' NOT IN (' . $db->quote(StatusMensagem::RASCUNHO) . ')')
			->where($db->quoteName ( 'm.enviado' ) . ' = 1 ');
		}
		elseif($caixa == 'SENT'){
			$query->where($db->quoteName ( 'm.id_usuario_remetente' ) . ' = ' . $user->id)
			->where($db->quoteName ( 'm.status_remetente' ) . ' = ' . $db->quote(StatusMensagem::NOVO) );
		}
		elseif($caixa == 'DRAF'){
			$query->where($db->quoteName ( 'm.id_usuario_remetente' ) . ' = ' . $user->id)
			->where($db->quoteName ( 'm.status_remetente' ) . ' = ' . $db->quote(StatusMensagem::RASCUNHO) );
		}
		elseif($caixa == 'TRASH'){
			$query->where('((' . $db->quoteName ( 'm.id_usuario_remetente' ) . ' = ' . $user->id . ' AND  ' . $db->quoteName ( 'm.status_remetente' ) . ' = ' . $db->quote(StatusMensagem::LIXEIRA) .
					') OR ( ' . $db->quoteName ( 'm.id_usuario_destino' ) . ' = ' . $user->id . ' AND  ' . $db->quoteName ( 'm.status_destinatario' ) . ' = ' . $db->quote(StatusMensagem::LIXEIRA) .' ))' );
		}
		$query->where($db->quoteName ( 'm.status_dado' ) . ' <> ' . $db->quote(StatusDado::REMOVIDO));
		if(isset($token)){
			$query->where($db->quoteName ( 'm.token' ) . ' = ' . $db->quote($token));
		}
		$query->order('m.data_criado DESC');
		$db->setQuery ( $query );
		
		if(isset($token)){
			$mensagem = $db->loadObject();
			if(isset($mensagem)){
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_mensagens'));
				if($mensagem->id_usuario_destino==$user->id){
					$query->set(array(
							$db->quoteName ( 'data_lida' ) . ' = NOW() ',
							$db->quoteName ( 'lido_destinatario') . ' = 1 ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
					));
				}
				elseif($mensagem->id_usuario_remetente==$user->id){
					$query->set(array(
							$db->quoteName ( 'data_lida' ) . ' = NOW() ',
							$db->quoteName ( 'lido_remetente' ) . ' = 1 ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
					));
				}
				$query->where ($db->quoteName ( 'id' ) . ' = ' . $mensagem->id);
				$db->setQuery ( $query );
				$db->execute ();
			}
			return $mensagem;
		}
		else{
			return $db->loadObjectList();
		}
	}
	
	
	
	public function sendMessage(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$id = JRequest::getString('id_mensagem',null);
		$destinario = JRequest::getString('para',0);
		$titulo = JRequest::getString('titulo','');
		$mensagem = JRequest::getString('mensagem','');
		
		$destinatarios = explode(',',$destinario);
		
		foreach($destinatarios as $para){
			$this->EnviarMensagemInbox($titulo, $para, $mensagem, TipoMensagens::MENSAGEM_SIMPLES, $id);
		}
		JFactory::getApplication()->enqueueMessage(JText::_('Mensagem enviada com sucesso.'));
		$this->inboxMensagens();
	}
	
	
	public function moverParaLixeiraMessage(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$token = JRequest::getString('token',null);
		
		
		
		
		$query = $db->getQuery ( true );
		$query->select('
			`m`.`id`,
			`m`.`id_usuario_destino`,
			`m`.`id_usuario_remetente`')
			->from($db->quoteName ( '#__angelgirls_mensagens','m'))

		->where('('.$db->quoteName ( 'm.id_usuario_destino' ) . ' = ' . $user->id . ' OR ' . $db->quoteName ( 'm.id_usuario_remetente' ) . ' = ' . $user->id.')')
		->where($db->quoteName ( 'm.status_dado' ) . ' <> ' . $db->quote(StatusDado::REMOVIDO))
		->where($db->quoteName ( 'm.token' ) . ' = ' . $db->quote($token));
		$db->setQuery ( $query );
		$mensagem = $db->loadObject();
		if(isset($mensagem)){
			if($mensagem->id_usuario_destino==$user->id){
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_mensagens'))
				->set(array(
							$db->quoteName ( 'status_destinatario' ) . ' = ' . $db->quote(StatusMensagem::LIXEIRA),
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id' ) . ' = ' . $mensagem->id)
				->where ($db->quoteName ( 'id_usuario_destino' ) . ' = ' . $user->id);
				$db->setQuery ( $query );
				if($db->execute ()){
					$jsonRetorno = '{"ok":"ok"}';
				}
				else{
					$jsonRetorno = '{"nok":"ok", "mensagem":"Mensagem n&atilde;o encontranda."}';					
				}
			}
			elseif($mensagem->id_usuario_remetente==$user->id){
				$query = $db->getQuery ( true );
				$query->update($db->quoteName('#__angelgirls_mensagens'))
				->set(array(
						$db->quoteName ( 'status_remetente' ) . ' = ' . $db->quote(StatusMensagem::LIXEIRA),
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id' ) . ' = ' . $mensagem->id)
				->where ($db->quoteName ( 'id_usuario_remetente' ) . ' = ' . $user->id);
				$db->setQuery ( $query );
				if($db->execute ()){
					$jsonRetorno = '{"ok":"ok"}';
				}
				else{
					$jsonRetorno = '{"nok":"ok", "mensagem":"Mensagem n&atilde;o encontranda."}';					
				}
			}
			else{
				$jsonRetorno = '{"nok":"ok", "mensagem":"Mensagem n&atilde;o encontranda."}';
			}
			$this->LogQuery($query);
		}
		else{
			$jsonRetorno = '{"ok":"nok", "mensagem":"Mensagem n&atilde;o encontranda."}';			
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($jsonRetorno));
		echo $jsonRetorno;
		exit();
	}
	
	
/***********************************************************************************************************************/
/************************************         ALBUM DE FOTOS     *******************************************************/
/***********************************************************************************************************************/


	/**
	 * Carrega Fotos por chamada Ajax
	 */
	public function carregarFotosAlbumContinuaHtml(){

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
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	
	
	
	
	
	private function salvarVisitante( $usuario){
		try{
			
			$id = JRequest::getString('id',0);
			if(!(strpos($id,':')===false)){
				$var =explode(':',$id); 
				$id = $var[0];
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
						$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade)),
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
				$db->setQuery ( $query );
				$db->execute ();
				$this->LogQuery($query);
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
						$db->quoteName ( 'id_cidade' ),
						$db->quoteName ( 'host_ip_criador' ),
						$db->quoteName ( 'host_ip_alterador' )))
					->values ( implode ( ',', array (
						'\'NOVO\'',
						'NOW()',
						$usuario->id,
						'NOW()',
						$usuario->id,
						$usuario->id,
						$db->quote(trim($nomeArtistico)),
						$db->quote(trim($descricao),
						$db->quote(trim($metaDescricao)),
						(!isset($profissao)? ' null ' : $db->quote(trim($profissao))),
						(!isset($nascionalidade)? ' null ' : $db->quote(trim($nascionalidade))),
						(!isset($idCidadeNasceu)? ' null ' : $db->quote($idCidadeNasceu)),
						$dataFormatadaBanco,
						(!isset($site)? ' null ' : $db->quote(trim($site))),
						(!isset($sexo)? ' null ' : $db->quote($sexo))),
						(!isset($cpf)? ' null ' : $db->quote(trim($cpf))),
						(!isset($banco)? ' null ' : $db->quote(trim($banco))),
						(!isset($agencia)? ' null ' : $db->quote(trim($agencia))),
						(!isset($conta)? ' null ' : $db->quote(trim($conta))),
						(!isset($custoMedioDiaria)? ' null ' : $db->quote(trim($custoMedioDiaria))),
						(!isset($qualificaoEquipe)? ' null ' : $db->quote(trim($qualificaoEquipe))),
						(!isset($idCidade)? ' null ' : $db->quote($idCidade)),
					$db->quote($this->getRemoteHostIp()),
					$db->quote($this->getRemoteHostIp())
					)));
					$db->setQuery( $query );
					$db->execute();
					$id = $db->insertid();
					$this->LogQuery($query);
					
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
							$db->quoteName ( 'ordem' ),
					$db->quoteName ( 'host_ip_criador' ),
					$db->quoteName ( 'host_ip_alterador' )))
						->values ( implode ( ',', array (
								'\'NOVO\'',
								'NOW()',
								$usuario->id,
								'NOW()',
								$usuario->id,
								$usuario->id,
								$db->quote('S'),
								$db->quote($email),
								'0',
								$db->quote($this->getRemoteHostIp()),
								$db->quote($this->getRemoteHostIp()))));
					$db->setQuery( $query );
					$db->execute();
					$this->LogQuery($query);
					
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
							$db->quoteName ( 'ordem' ),
					$db->quoteName ( 'host_ip_criador' ),
					$db->quoteName ( 'host_ip_alterador' )))
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
									'0',
									$db->quote($this->getRemoteHostIp()),
									$db->quote($this->getRemoteHostIp()))));
					$db->setQuery( $query );
					$db->execute();
					$this->LogQuery($query);
			}
			
			$query = $db->getQuery ( true );
			$query->select('nome_foto ')
			->from ('#__angelgirls_visitante')
			->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
			->where ( $db->quoteName ('id').' = ' . $id);
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
				
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$this->SalvarUploadImagem($foto_perfil,
						PATH_IMAGEM_VISITANTES,
						$this->GerarNovoNomeArquivo($foto_perfil['name'], $id ),
						'#__angelgirls_visitante','nome_foto',$id,true,false, $result->nome_foto);
			}
	
	
			return true;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return false;
	}
	
	
	
	public function buscarFotografoModal(){
		$nome = JRequest::getString('nome',null);
		$idCidade  = JRequest::getInt('id_cidade',null);
		$estado  = JRequest::getInt('estado',null);
	
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select('`f`.`id`, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`, `f`.`meta_descricao`, `f`.`descricao`, `f`.`data_nascimento`,
			`f`.`sexo`, `f`.`nascionalidade`, `f`.`site`, `f`.`profissao`, `f`.`id_cidade_nasceu`, `f`.`id_cidade`, `f`.`audiencia_view`, `u`.`name` as `nome_completo`,
			`cnasceu`.`uf` as `estado_nasceu`, `cnasceu`.`nome` as `cidade_nasceu`,
			`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`')
				->from ( $db->quoteName ( '#__angelgirls_fotografo', 'f' ) )
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
		->order('f.nome_artistico')
		->limit(100);
		$db->setQuery ( $query );

		$result = $db->loadObjectList();
		JRequest::setVar('fotografos',$result);
		JRequest::setVar('ufs',$this->getUFs());
	
	
		require_once 'views/fotografo/tmpl/selecionar_fotografo.php';
		exit();
	}
	
	
	public function buscarPerfilToken(){
		$nome = JRequest::getString('nome',null);
		$idCidade  = JRequest::getInt('id_cidade',null);
		$estado  = JRequest::getInt('estado',null);
		$user = JFactory::getUser();
		$campo  = JRequest::getString('campo',null);
		if(isset($nome) && strlen(trim($nome))>=3 
				|| isset($idCidade) || isset($estado)){
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->select('`p`.`id`,`p`.`tipo`,`p`.`usuario`,`p`.`nome_completo`,`p`.`email_principal`,`p`.`id_usuario`,`p`.`apelido`,`p`.`descricao`,`p`.`meta_descricao`,`p`.`foto_perfil`,
							`p`.`foto_adicional1`,`p`.`foto_adicional2`,`p`.`altura`,`p`.`peso`,`p`.`busto`,`p`.`calsa`,`p`.`calsado`,`p`.`olhos`,`p`.`pele`,`p`.`etinia`,`p`.`cabelo`,`p`.`token`,
							`p`.`tamanho_cabelo`,`p`.`cor_cabelo`,`p`.`outra_cor_cabelo`,`p`.`profissao`,`p`.`nascionalidade`,`p`.`id_cidade_nasceu`,`p`.`uf_nasceu`,`p`.`data_nascimento`,`p`.`site`,
							`p`.`sexo`,`p`.`cpf`,`p`.`banco`,`p`.`agencia`,	`p`.`conta`,`p`.`custo_medio_diaria`,`p`.`outro_status`,`p`.`qualificao_equipe`,`p`.`audiencia_gostou`,
							`p`.`audiencia_ngostou`,`p`.`audiencia_view`,`p`.`id_cidade`,`p`.`uf`,`p`.`status_dado`,`p`.`id_usuario_criador`,`p`.`id_usuario_alterador`,
							`data_criado`,`data_alterado`,
							`cnasceu`.`uf` as `estado_nasceu`, `cnasceu`.`nome` as `cidade_nasceu`,
							`cvive`.`uf` as `estado_mora`, `cvive`.`nome` as `cidade_mora`')
			->from ( $db->quoteName ( '#__angelgirls_perfil', 'p' ) )
			->join ( 'INNER', '#__cidade AS cnasceu ON ' . $db->quoteName ( 'p.id_cidade_nasceu' ) . ' = ' . $db->quoteName('cnasceu.id'))
			->join ( 'INNER', '#__cidade AS cvive ON ' . $db->quoteName ( 'p.id_cidade' ) . ' = ' . $db->quoteName('cvive.id'));
		
			$nomeFormatado = $db->quote(trim(strtoupper($nome)).'%');
			if(isset($idCidade) && $idCidade!="" && $idCidade>0){
				$query->where ( '( cvive.id =  ' . $idCidade . ' OR cnasceu.id =  ' . $idCidade . ' )');
			}
			if(isset($estado) && $estado!="" ){
				$query->where ( '( cvive.uf =  ' . $db->quote(trim($estado)) . ' OR  cnasceu.uf =  ' . $db->quote(trim($estado)) . ')');
			}
			$query->where('(upper(trim(p.apelido)) like ' . $nomeFormatado .' OR upper(trim(p.nome_completo)) like ' . $nomeFormatado .'
					OR upper(trim(p.email_principal)) like ' . $nomeFormatado .' OR upper(trim(p.usuario)) like ' . $nomeFormatado .')')
			
			->where ( ' p.id_usuario <> ' . $user->id)
			->where ( $db->quoteName ( 'p.status_dado' ) . ' IN (' . $db->quote(StatusDado::ATIVO) . ',' . $db->quote(StatusDado::NOVO) . ') ' )
			->order('p.apelido')
			->limit(100);
			$db->setQuery ( $query );
			$result = $db->loadObjectList();
			JRequest::setVar('perfils',$result);
		}
		else{
			JRequest::setVar('mensagens','Para realizar a busca deve digita pelo menos 3 letras do nome.');
			JRequest::setVar('perfils',array());
		}

	
		
		
		JRequest::setVar('ufs',$this->getUFs());
	
	
		require_once 'views/perfil/tmpl/selecionar_perfil_token.php';
		exit();
	}
	
	private function salvarFotografo($usuario){
		try{
			$id =  $usuario->id;
			if(!(strpos($id,':')===false)){
				$var =explode(':',$id); 
				$id = $var[0];
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
						$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade)),
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' .$db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
				$db->setQuery ( $query );
				$db->execute ();
				$this->LogQuery($query);
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
					$db->quoteName ( 'id_cidade' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
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
					($idCidade == null ? ' null ' : $db->quote($idCidade)),
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp())
				)));
				$db->setQuery( $query );
				$db->execute();
				$id = $db->insertid();
				$this->LogQuery($query);
				
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
						$db->quoteName ( 'ordem' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
					->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$usuario->id,
							'NOW()',
							$usuario->id,
							$usuario->id,
							$db->quote('S'),
							$db->quote($email),
							'0',
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp()))));
				$db->setQuery( $query );
				$db->execute();
				$this->LogQuery($query);
				
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
						$db->quoteName ( 'ordem' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
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
						'0',
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp()))));
				$db->setQuery( $query );
				$db->execute();
				$this->LogQuery($query);
			}
			
			
			
			$query = $db->getQuery ( true );
			$query->select('nome_foto ')
			->from ('#__angelgirls_fotografo')
			->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
			->where ( $db->quoteName ('id').' = ' . $id);
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
				
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$this->SalvarUploadImagem($foto_perfil,
						PATH_IMAGEM_FOTOGRAFOS,
						$this->GerarNovoNomeArquivo($foto_perfil['name'], $id ),
						'#__angelgirls_fotografo','nome_foto',$id,true,false, $result->nome_foto);
			}
	
	
			return true;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return false;
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
			$var =explode(':',$id); 
			$id = $var[0];
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
				JError::raiseWarning( 100, 'O usu&aacute;rio j&aacute; est&aacute; cadastrado.' );
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
		try{

			$sucesso=true;
			
			
			$erro = false;
			
			$id = JRequest::getString('id',0);
			if(!(strpos($id,':')===false)){
				$var =explode(':',$id); 
				$id = $var[0];
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
						$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade)),
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())
				))
				->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
				$db->setQuery ( $query );
				$db->execute ();
				$this->LogQuery($query);
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
					$db->quoteName ( 'id_cidade' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
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
					($idCidade == null ? ' null ' : $db->quote($idCidade)),
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp())
				)));
				$db->setQuery( $query );
				$db->execute();
				$id = $db->insertid();
				$this->LogQuery($query);
				
				
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
						$db->quoteName ( 'ordem' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
					->values ( implode ( ',', array (
							'\'NOVO\'',
							'NOW()',
							$usuario->id,
							'NOW()',
							$usuario->id,
							$usuario->id,
							$db->quote('S'),
							$db->quote($email),
							'0',
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp()))));
				$db->setQuery( $query );
				$db->execute();
				$this->LogQuery($query);
				
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
						$db->quoteName ( 'ordem' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
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
						'0',
				$db->quote($this->getRemoteHostIp()),
				$db->quote($this->getRemoteHostIp()))));
				$db->setQuery( $query );
				$db->execute();
				$this->LogQuery($query);
			}
			
	
			
			$query = $db->getQuery ( true );
			$query->select('foto_perfil, foto_inteira, foto_inteira_horizontal ')
			->from ('#__angelgirls_modelo')
			->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
			->where ( $db->quoteName ('id').' = ' . $id);
			$db->setQuery ( $query );
			$result = $db->loadObject();
			
				
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$this->SalvarUploadImagem($foto_perfil,
						PATH_IMAGEM_MODELOS,
						$this->GerarNovoNomeArquivo($foto_perfil['name'], $id ),
						'#__angelgirls_modelo','foto_perfil',$id,true,true, $result->foto_perfil);
			}
			if (isset ( $foto_inteira ) && JFile::exists ( $foto_inteira ['tmp_name'] )) {
				$this->SalvarUploadImagem($foto_inteira,
						PATH_IMAGEM_MODELOS,
						$this->GerarNovoNomeArquivo($foto_inteira['name'], $id ),
						'#__angelgirls_modelo','foto_inteira',$id,true,true, $result->foto_inteira);
			}
			if (isset ( $foto_inteira_horizontal ) && JFile::exists ( $foto_inteira_horizontal ['tmp_name'] )) {
				$this->SalvarUploadImagem($foto_inteira_horizontal,
						PATH_IMAGEM_MODELOS,
						$this->GerarNovoNomeArquivo($foto_inteira_horizontal['name'], $id ),
						'#__angelgirls_modelo','foto_inteira_horizontal',$id,true,true, $result->foto_inteira_horizontal);
			}
			
			
	
			return true;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return false;
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
				$this->LogQuery($query);
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_endereco' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp()) ))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				$this->LogQuery($query);
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
							$db->quoteName ( 'ordem' ),
							$db->quoteName ( 'host_ip_criador' ),
							$db->quoteName ( 'host_ip_alterador' )))
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
								$ordem,
					$db->quote($this->getRemoteHostIp()),
					$db->quote($this->getRemoteHostIp()))));
							$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
					
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
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
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' .  $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
						$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
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
				$this->LogQuery($query);
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_telefone' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  ',
					$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				$this->LogQuery($query);
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
							$db->quoteName ( 'ordem' ),
							$db->quoteName ( 'host_ip_criador' ),
							$db->quoteName ( 'host_ip_alterador' )))
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
									$ordem,
									$db->quote($this->getRemoteHostIp()),
									$db->quote($this->getRemoteHostIp()))));
	
							$db->setQuery( $query );
							if($db->execute()){
								$jsonRetorno='{"ok":"ok", "menssagem":""}';
							}
							else{
								$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
							}
							$this->LogQuery($query);
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
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
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
							$db->quoteName ( 'host_ip_alterador' )  . ' = ' . $db->quote($this->getRemoteHostIp()) ))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
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
				$this->LogQuery($query);
				
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_email' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
						$this->LogQuery($query);
						
						
						$query = $db->getQuery ( true );
						$query->update($db->quoteName('#__users' ))
						->set(array (
								$db->quoteName ( 'email' ) . ' = (SELECT email FROM #__angelgirls_email WHERE id = '.$id.' )'))
								->where ($db->quoteName ( 'id' ) . ' = ' . $user->id);
						$db->setQuery( $query );
						$db->execute();
						$this->LogQuery($query);
					}
					else{
						$this->LogQuery($query);
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}

				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
						$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
						$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
						->where ($db->quoteName ( 'id' ) . ' = ' . $id)
						->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
				$db->setQuery( $query );
				if($db->execute()){
					$jsonRetorno='{"ok":"ok", "menssagem":""}';
				}
				else{
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
				}
				$this->LogQuery($query);
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
							$db->quoteName ( 'ordem' ),
							$db->quoteName ( 'host_ip_criador' ),
							$db->quoteName ( 'host_ip_alterador' )))
							->values(implode(',', array(
									$db->quote($principal),
									(isset($email)?$db->quote($email):'null'),
									$user->id,
									$db->quote(StatusDado::NOVO),
									$user->id,
									$user->id, 'NOW()', 'NOW()',
									$ordem,
									$db->quote($this->getRemoteHostIp()),
									$db->quote($this->getRemoteHostIp()))));
	
							$db->setQuery( $query );
							if($db->execute()){
								$jsonRetorno='{"ok":"ok", "menssagem":""}';
							}
							else{
								$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
							}
							$this->LogQuery($query);
							
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
				}
			}
			else{
				try {
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_email' ))
					->set(array (
							$db->quoteName ( 'email' ) . ' = ' . (isset($email)?$db->quote($email):'null'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
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
				$this->LogQuery($query);
				if($jsonRetorno==""){
					$query = $db->getQuery ( true );
					$query->update($db->quoteName('#__angelgirls_redesocial' ))
					->set(array (
							$db->quoteName ( 'principal' ) . ' = ' . $db->quote('S'),
							$db->quoteName ( 'id_usuario_alterador') . ' = ' . $user->id,
							$db->quoteName ( 'data_alterado' ) . '=  NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}
			}catch(Exception $e) {
				$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
				JLog::add($e->getMessage(), JLog::WARNING);
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
		try{
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
							$db->quoteName ( 'data_alterado' ) . ' = NOW()  ',
							$db->quoteName ( 'host_ip_alterador' ) . ' = ' . $db->quote($this->getRemoteHostIp())))
							->where ($db->quoteName ( 'id' ) . ' = ' . $id)
							->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
					$db->setQuery( $query );
					if($db->execute()){
						$jsonRetorno='{"ok":"ok", "menssagem":""}';
					}
					else{
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
					}
					$this->LogQuery($query);
				}catch(Exception $e) {
					$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel remover a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
					JLog::add($e->getMessage(), JLog::WARNING);
				}
			}
			else{
				$jsonRetorno='{"ok":"nok", "menssagem":"Endere&ccedil;o n&atilde;o encontrado."}';
			}
			header('Content-Type: application/json; charset=utf8');
			header("Content-Length: " . strlen($jsonRetorno));
			echo $jsonRetorno;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
		exit();
	}
	
	
	/**
	 * Salvar o rede_social via JSON
	 */
	public function salvarRedeSocialJson(){
		try{
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
								$db->quoteName ( 'ordem' ),
								$db->quoteName ( 'host_ip_criador' ),
								$db->quoteName ( 'host_ip_alterador' )))
								->values(implode(',', array(
										$db->quote($principal),
										(isset($rede)?$db->quote($rede):'null'),
										(isset($contato)?$db->quote($contato):'null'),
										$user->id,
										$db->quote(StatusDado::NOVO),
										$user->id,
										$user->id, 'NOW()', 'NOW()',
										$ordem,
										$db->quote($this->getRemoteHostIp()),
										$db->quote($this->getRemoteHostIp()))));
		
								$db->setQuery( $query );
								if($db->execute()){
									$jsonRetorno='{"ok":"ok", "menssagem":""}';
								}
								else{
									$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o."}';
								}
								$this->LogQuery($query);
					}catch(Exception $e) {
						$jsonRetorno='{"ok":"nok", "menssagem":"N&atilde;o foi possivel salvar a informa&ccedil;&atilde;o ['.$e->getMessage().':'.$e->getCode().']."}';
						JLog::add($e->getMessage(), JLog::WARNING);
					}
				}
			}
			else{
				$jsonRetorno='{"ok":"nok", "menssagem":"'.$mensagensErro.'"}';
			}
			header('Content-Type: application/json; charset=utf8');
			header("Content-Length: " . strlen($jsonRetorno));
			echo $jsonRetorno;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
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
		try{
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->select ( $db->quoteName ( array ('a.ds_uf_sigla','a.ds_uf_nome'),array ('uf','nome') ) )
			->from ( $db->quoteName ( '#__uf', 'a' ) )
			->order ( 'a.ds_uf_sigla' );
			$db->setQuery ( $query );
			return $db->loadObjectList();
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	
	
	function cidadeJson(){
		try{
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
			$cidades = $db->loadObjectList();
			header('Content-Type: application/json; charset=utf8');
			echo json_encode($cidades);
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
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
		try{
			$db = JFactory::getDbo();
			
			$perfil = $this::getPerfilLogado();
			
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		JRequest::setVar ( 'view', 'home' );
		JRequest::setVar ( 'layout', 'logado' );
		parent::display ();
	}
	
	
	public static function getPerfilLogado(){
		try{
			$session = JFactory::getSession();
			$perfil  = $session->set('perfil', 'NO' );
			if($perfil==='NO'){
				$user = JFactory::getUser();
				$db = JFactory::getDbo ();
				$query = $db->getQuery ( true );
				$query->select('`id`,`tipo`,`usuario`,`nome_completo`,`email_principal`,`id_usuario`,`apelido`,`descricao`,`meta_descricao`,`foto_perfil`,
							`foto_adicional1`,`foto_adicional2`,`altura`,`peso`,`busto`,`calsa`,`calsado`,`olhos`,`pele`,`etinia`,`cabelo`,`token`,
							`tamanho_cabelo`,`cor_cabelo`,`outra_cor_cabelo`,`profissao`,`nascionalidade`,`id_cidade_nasceu`,`uf_nasceu`,`data_nascimento`,`site`,
							`sexo`,`cpf`,`banco`,`agencia`,	`conta`,`custo_medio_diaria`,`outro_status`,`qualificao_equipe`,`audiencia_gostou`,
							`audiencia_ngostou`,`audiencia_view`,`id_cidade`,`uf`,`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,
							`data_criado`,`data_alterado`')
									->from ('#__angelgirls_perfil')
									->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
									->setLimit(1);
				$db->setQuery ( $query );
				$perfil = $db->loadObject();
				
				
				if(isset($perfil->enderecos)){
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
					
					$perfil->enderecos = $db->loadObjectList();
					
					
					$query = $db->getQuery ( true );
					$query->select('`id`,`principal`,`email`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
										->from ('#__angelgirls_email')
										->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
										->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
										->order('ordem');
					$db->setQuery($query);
	 				$perfil->emails = $db->loadObjectList();
	 				
	 				
	 				$query = $db->getQuery ( true );
	 				$query->select('`id`,`principal`,`tipo`,`operadora`,`ddi`,`telefone`,`ddd`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
	 									->from ('#__angelgirls_telefone')
	 									->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
	 									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
	 									->order('ordem');
	 				$db->setQuery ( $query );
	 				$perfil->telefones = $db->loadObjectList();
	 				
	 				
	 				$query = $db->getQuery ( true );
	 				$query->select('`id`,`principal`,`publico`,`rede_social`,`url_usuario`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
	 									->from ('#__angelgirls_redesocial')
	 									->where ( $db->quoteName ('id_usuario').' = ' . $user->id )
	 									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
	 									->order('ordem');
	 				$db->setQuery ( $query );
	 				$perfil->redesSociaos = $db->loadObjectList();
					$session->set('perfil', $perfil);
				}
			}
			

			return $perfil;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	
	private function getPerfilById($idUsuario){
		try{
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->select('`id`,`tipo`,`usuario`,`nome_completo`,`email_principal`,`id_usuario`,`apelido`,`descricao`,`meta_descricao`,`foto_perfil`,
						`foto_adicional1`,`foto_adicional2`,`altura`,`peso`,`busto`,`calsa`,`calsado`,`olhos`,`pele`,`etinia`,`cabelo`,`token`,
						`tamanho_cabelo`,`cor_cabelo`,`outra_cor_cabelo`,`profissao`,`nascionalidade`,`id_cidade_nasceu`,`uf_nasceu`,`data_nascimento`,`site`,
						`sexo`,`cpf`,`banco`,`agencia`,	`conta`,`custo_medio_diaria`,`outro_status`,`qualificao_equipe`,`audiencia_gostou`,
						`audiencia_ngostou`,`audiencia_view`,`id_cidade`,`uf`,`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,
						`data_criado`,`data_alterado`')
							->from ('#__angelgirls_perfil')
							->where ( $db->quoteName ('id_usuario').' = ' .$idUsuario )
							->setLimit(1);
			$db->setQuery ( $query );
			$perfil = $db->loadObject();
			
			
			if(isset($perfil->enderecos)){
			
				
				$query = $db->getQuery ( true );
				$query->select('end.`id`,end.`tipo`,end.`principal`,end.`endereco`,end.`numero`,end.`bairro`,end.`complemento`,
						end.`cep`,end.`id_cidade`,end.`id_usuario`,end.`ordem`,end.`status_dado`,end.`id_usuario_criador`,
						end.`id_usuario_alterador`,end.`data_criado`,end.`data_alterado`,c.nome as cidade,c.uf,uf.ds_uf_nome as estado')
									->from ('#__angelgirls_endereco AS end')
									->join ( 'INNER', '#__cidade AS c ON ' . $db->quoteName ( 'end.id_cidade' ) . ' = ' . $db->quoteName('c.id'))
									->join ( 'INNER', '#__uf AS uf ON ' . $db->quoteName ( 'c.uf' ) . ' = ' . $db->quoteName('uf.ds_uf_sigla'))
									->where ( $db->quoteName ('id_usuario').' = ' . $idUsuario)
									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
									->order('ordem');
				$db->setQuery ( $query );
				
				$perfil->enderecos = $db->loadObjectList();
				
				
				$query = $db->getQuery ( true );
				$query->select('`id`,`principal`,`email`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
									->from ('#__angelgirls_email')
									->where ( $db->quoteName ('id_usuario').' = ' . $idUsuario)
									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
									->order('ordem');
				$db->setQuery($query);
				$perfil->emails = $db->loadObjectList();
					
					
				$query = $db->getQuery ( true );
				$query->select('`id`,`principal`,`tipo`,`operadora`,`ddi`,`telefone`,`ddd`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
									->from ('#__angelgirls_telefone')
									->where ( $db->quoteName ('id_usuario').' = ' . $idUsuario)
									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
									->order('ordem');
				$db->setQuery ( $query );
				$perfil->telefones = $db->loadObjectList();
					
					
				$query = $db->getQuery ( true );
				$query->select('`id`,`principal`,`publico`,`rede_social`,`url_usuario`,`id_usuario`,`ordem`,`status_dado`,`id_usuario_criador`,
						`id_usuario_alterador`,`data_criado`,`data_alterado`')
									->from ('#__angelgirls_redesocial')
									->where ( $db->quoteName ('id_usuario').' = ' . $idUsuario)
									->where ( $db->quoteName ('status_dado').' <> ' . $db->quote(StatusDado::REMOVIDO))
									->order('ordem');
				$db->setQuery ( $query );
				$perfil->redesSociaos = $db->loadObjectList();
				$session->set('perfil', $perfil);
				
			}
			
			return $perfil;
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	
	
	
	
	private function getEnderecosPefil(){
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	} 
	
	private function getTelefonesPefil(){
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	
	private function getRedesSociaisPefil(){
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}
	
	private function getEmailsPefil(){
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return null;
	}	
	
	
	

	
	public function carregarPerfil(){
		try{
			$user = JFactory::getUser();
			$this->carregarCadastro();
			
			if(!isset($user) || $user->id==0){
				JError::raiseWarning(100,JText::_('Usu&aacute;rio n&atilde;o est&aacute; logado.'));
				$this->nologado();
				return;
			}
			
	
			$perfil = $this::getPerfilLogado();
			
			if(!isset($perfil) || $perfil->id <= 0){
				$this->RegistroNaoEncontado();
				return;				
			}
			
			JRequest::setVar ( 'perfil',  $perfil);
			

			
			
			
			//Dados
			JRequest::setVar ( 'enderecos', $this->getEnderecosPefil());
			JRequest::setVar ( 'emails', $this->getEmailsPefil());
			JRequest::setVar ( 'redes', $this->getRedesSociaisPefil());
			JRequest::setVar ( 'telefones', $this->getTelefonesPefil());
			//Carregar Cadastro j&aacute; busca Ufs
			//JRequest::setVar ( 'ufs', $this->getUFs());
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		
		JRequest::setVar ( 'view', 'perfil' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display();
	}
	
	public function nologado(){
		//Nova modelo
		try{
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
			$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo','token'),
					array('id','nome','descricao','foto', 'alias','token')))
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
			$query->select($db->quoteName(array('id','titulo','meta_descricao','nome_foto','titulo','token'),
					array('id','nome','descricao','foto', 'alias','token')))
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
			$query->select(" `id` ,`titulo` as nome,`meta_descricao` as descricao,`id_sessao`, `id_sessao` + '/' + `id` + 'm.jpg' as foto, `titulo` as alias,token")
				->from ('#__angelgirls_foto_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . ' NOT IN (' . $db->quote(StatusDado::REMOVIDO) . ',' . $db->quote(StatusDado::REPROVADO) . ') ' )
				->where ( $db->quoteName ( 'id_sessao' ) . ' IN (select id FROM #__angelgirls_sessao WHERE status_dado IN (' . $db->quote(StatusDado::PUBLICADO) . ' ) AND  publicar<= NOW()) ')
				->where ( $db->quoteName ( 'possui_nudes' ) . " = 'N'")
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
		
		
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		
		
		JRequest::setVar ( 'view', 'home' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display (true, false);
	}

	
	public static function GetMenuLateral(){
		require_once 'menu/menu.php';
	}
	
	public function trocarSenha(){
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		
		try{
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
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return $user;
	}
	
	
	private function LogQuery($queryLog, $idUsuario = 0){
		try{
			$db = JFactory::getDbo();
			$user = JFactory::getUser();
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__query_logs' ) )
			->columns (array (
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'query' ),
					$db->quoteName ( 'host_ip' ),
					$db->quoteName ( 'data' )))
			->values(implode(',', array (
					(!isset($idUsuario) || $idUsuario==0? $user->id : $idUsuario), 
					$db->quote($queryLog), 
					$db->quote($db->quote($this->getRemoteHostIp())),
					'NOW()')));
			$db->setQuery( $query );
			$db->execute();
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
	}
	
	private function getRemoteHostIp(){
		$ip='';
		
		try{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}catch(Exception $e) {
			JLog::add($e->getMessage(), JLog::WARNING);
			JError::raiseWarning(100, $e->getMessage());
		}
		return $ip; 
	}
	
	

	
	/**
	 * Programa de pontos.
	 * 
	 * @param unknown $descricao
	 * @param unknown $KEY
	 * @param unknown $quantidade
	 */
	private function SomarPontos($descricao, $KEY, $quantidade){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->insert( $db->quoteName ( '#__angelgirls_extrato_pontos' ) )
		->columns (array (
				$db->quoteName ( 'pontos' ),
				$db->quoteName ( 'motivo' ),
				$db->quoteName ( 'chave' ),
				$db->quoteName ( 'id_usuario' ),
				$db->quoteName ( 'data' ),
				$db->quoteName ( 'host_ip' )))
				->values(implode(',', array ($quantidade, $db->quote($descricao),$db->quote($KEY),$user->id, 'NOW()',$db->quote($this->getRemoteHostIp()))));
		$db->setQuery( $query );
		$db->execute();
		$this->LogQuery($query);
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_fotografo' ))
		->set(array('pontos = (pontos + ' . $quantidade . ') '))
		->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
		$db->setQuery ( $query );
		$db->execute ();
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_visitante' ))
		->set(array('pontos = (pontos + ' . $quantidade . ') '))
		->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
		$db->setQuery ( $query );
		$db->execute ();
		
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_modelo' ))
		->set(array('pontos = (pontos + ' . $quantidade . ') '))
		->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $user->id);
		$db->setQuery ( $query );
		$db->execute ();

	}
	
	/**
	 * Carregado temporariamente os dados em JSon
	 */
	public function checarDados(){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$perfil = $this::getPerfilLogado();
		
		
		if(isset($perfil)){
			
			$query = $db->getQuery ( true );
			$query->select(" count(1) AS TOTAL")
			->from ('#__angelgirls_mensagens')
			->where ('id_usuario_destino = ' . $user->id)
			->where ('status_dado = \'NOVO\'')
			->where ('status_destinatario = \'NOVO\'')
			->where ('enviado = 1 ')
			->where ('lido_destinatario = 0');
			$db->setQuery( $query );
			$mensagens = $db->loadObject();
			
			$query = $db->getQuery ( true );
			$query->select(" count(1) AS TOTAL")
			->from ('#__angelgirls_sessao')
			->where ('status_dado = ' . $db->quote(StatusDado::ANALIZE) );
			if($perfil->tipo=='FOTOGRAFO'){
				$query->where (  '((' . $db->quoteName ('id_fotografo_principal') . ' = ' . $perfil->id . ' AND status_fotografo_principal = 0 ) OR (' . $db->quoteName ('id_fotografo_secundario') . ' = ' . $perfil->id . ' AND status_fotografo_secundario = 0))');
			}
			elseif($perfil->tipo=='MODELO'){
				$query->where ('(( ' . $db->quoteName ('id_modelo_principal') . ' = ' . $perfil->id . ' AND status_modelo_principal = 0) OR (' . $db->quoteName ('id_modelo_secundaria') . ' = ' . $perfil->id . ' AND  status_modelo_secundaria = 0 ))');
			}
			else{
				$query->where ('1=0');
			}
			$db->setQuery( $query );
			$sessoes = $db->loadObject();
			
			
			$json = '{"logado":"SIM", "mensagens":"'. $mensagens->TOTAL .'", "aprovar":"'.$sessoes->TOTAL.'"}';
		}
		else{
			$json = '{"logado":"NAO"}';
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
		
	}
	
	private function EnviarMensagemInbox($titulo, $destino, $mensagem, $tipo, $repostaMensagemId=null){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->insert( $db->quoteName ( '#__angelgirls_mensagens' ) )
		->columns (array (
				$db->quoteName ( 'titulo' ),
				$db->quoteName ( 'id_usuario_destino' ),
				$db->quoteName ( 'mensagem' ),
				$db->quoteName ( 'tipo' ),
				$db->quoteName ( 'token' ),
				$db->quoteName ( 'id_resposta' ),
				$db->quoteName ( 'status_dado' ),
				$db->quoteName ( 'status_destinatario' ),
				$db->quoteName ( 'status_remetente' ),
				$db->quoteName ( 'flag_remetente' ),
				$db->quoteName ( 'flag_destinatario' ),
				$db->quoteName ( 'lido_remetente' ),
				$db->quoteName ( 'lido_destinatario' ),
				$db->quoteName ( 'enviado' ),
				$db->quoteName ( 'id_usuario_remetente' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'host_ip_criador' )))
				->values(implode(',', array (
						$db->quote($titulo),
						$destino,
						$db->quote($mensagem),
						$tipo,
						'UUID()',
						(!isset($repostaMensagemId) || $repostaMensagemId ==0?' null ':$repostaMensagemId),
						$db->quote('NOVO'),$db->quote('NOVO'),$db->quote('NOVO'),'0','0','1','0','1', $user->id, 'NOW()',$db->quote($this->getRemoteHostIp()) 
				)));
		$db->setQuery( $query );
		$db->execute();
		$this->LogQuery($query);
	}
	
	private function EnviarMensagemEmail($email, $nome, $tipo, $titulo, $texto){
		$mailer = JFactory::getMailer();
		
		$config = JFactory::getConfig();
		$sender = array(
				$config->get( 'mailfrom' ),
				$config->get( 'fromname' )
		);
		$mailer->addRecipient($email);
		$mailer->setSender($sender);
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($texto);
		// Optionally add embedded image
		$mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/angelgirls.png', 'logo_id', 'angelgirls.png', 'base64', 'image/jpeg' );
		
		$send = $mailer->Send();
		if ( $send !== true ) {
			JError::raiseWarning( 100, $send->__toString() );
			JLog::add($send->__toString(), JLog::WARNING);
			return false;
		} 
		return true;
	}
	
	
/***********************************************************************************************************/
/*********************************          AMIZADE               ******************************************/ 
/***********************************************************************************************************/
	
	public function seguirUsuario(){
		$json = '{"ok":"ok"}';
		try{
			$user = JFactory::getUser();
			$db = JFactory::getDbo ();
			$perfil = $this::getPerfilLogado();
			$token = $db->quote(trim(JRequest::getString('id', '', 'POST' )));
			$tipo = $db->quote(trim(strtoupper(JRequest::getString('tipo', '', 'POST' ))));
				
				
			$queryUsuario = "(SELECT id_usuario FROM #__angelgirls_perfil WHERE token = '$token' AND tipo= '$tipo')";
				
				
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ('#__angelgirls_seguindo'))
			->columns (array (
					$db->quoteName ( 'id_usuario_seguidor' ),
					$db->quoteName ( 'id_usuario_seguido' ),
					$db->quoteName ( 'data' ),
					$db->quoteName ( 'host_ip' )))
					->values(implode(',', array ($user->id, $queryUsuario,'NOW()', $db->quote($this->getRemoteHostIp()))));
			$db->setQuery( $query );
			if(!$db->execute()){
				$json = '{"ok":"nok", "mensagem":"Falha no processo!"}';
			}
			$this->LogQuery($query);

		}
		catch(Exception $e){
			$json = '{"ok":"nok", "mensagem":"'.$e->message.'"}';
		}
	
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	public function solicitarAmizade(){
		$json = '{"ok":"ok"}';
		try{
			$user = JFactory::getUser();
			$db = JFactory::getDbo ();
			$perfil = $this::getPerfilLogado();
			$token = $db->quote(trim(JRequest::getString('id', '', 'POST' )));
			$tipo = $db->quote(trim(strtoupper(JRequest::getString('tipo', '', 'POST' ))));
			
			
			$queryUsuario = "(SELECT id_usuario FROM #__angelgirls_perfil WHERE token = '$token' AND tipo= '$tipo')";
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ('#__angelgirls_amizade'))
			->columns (array (
					$db->quoteName ( 'id_usuario_solicidante' ),
					$db->quoteName ( 'id_usuario_solicitado' ),
					$db->quoteName ( 'data_solicitada' ),
					$db->quoteName ( 'host_ip_solicitante' )))
			->values(implode(',', array ($user->id, $queryUsuario,'NOW()', $db->quote($this->getRemoteHostIp()))));
			$db->setQuery( $query );
			if(!$db->execute()){
				$json = '{"ok":"nok", "mensagem":"Falha ao enviar a solicita&ccedil;o!"}';
			}
			$this->LogQuery($query);

			
			$query = $db->getQuery ( true );
			$query->select("`id`")
			->from ('#__angelgirls_amizade_lista')
			->where ('`nome` = \'AMIGOS\'' )
			->where ('`sistema` = \'S\'' )
			->where ('`id_usuario_criador` =  '.$user->id )
			->setLimit(1);
			$db->setQuery ( $query );
			$listaID = $db->loadObject();
			if(!isset($listaID)){
				$listaID = $this->criarListaDefaultAmigos($user->id);
			}
			
			
			$this->EnviarMensagemInbox('Solicita&ccedil;&atilde;o de amizade', $queryUsuario, 'O usu&aacute;rio '.$perfil->nome.' enviou uma solicita&ccedil;&atilde;o de amizade para você.', TipoMensagens::SOLICITACAO_AMIZADE);
		}
		catch(Exception $e){
			$json = '{"ok":"nok", "mensagem":"'.$e->message.'"}';
		}
		
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	public function aceitarAmizade(){
		$json = '{"ok":"ok"}';
		try{
			$user = JFactory::getUser();
			$db = JFactory::getDbo ();
			$perfil = $this::getPerfilLogado();
			$idSolicitacao = JRequest::getInt('id', 0, 'POST' );
			
				
			
			$query = $db->getQuery ( true );
			$query->update($db->quoteName ('#__angelgirls_amizade'))
			->set (array(
					$db->quoteName ( 'host_ip_aceitou' ) . ' = ' . $db->quote($this->getRemoteHostIp()),
					$db->quoteName ( 'data_aceita' ) . ' = NOW()'))
				->where (array($db->quoteName ( 'id' ) . ' = ' . $idSolicitacao));
			$db->setQuery ( $query );
			$db->execute();
			$this->LogQuery($query);
			

			
			//Adicionar na lista do solicitante
			$query = $db->getQuery ( true );
			$query->select("`id`")
				->from ('#__angelgirls_amizade_lista')
				->where ('`nome` = \'AMIGOS\'' )
				->where ('`sistema` = \'S\'' )
				->where ('`id_usuario_criador` = (SELECT id_usuario_solicidante FROM #__angelgirls_amizade WHERE id = '.$idSolicitacao.') ' )
				->setLimit(1);
			$db->setQuery ( $query );
			$listaID = $db->loadObject()->id;
			if(!isset($listaID) || $listaID <= 0){
				$listaID = $this->criarListaDefaultAmigos('(SELECT id_usuario_solicidante FROM #__angelgirls_amizade WHERE id = '.$idSolicitacao.')');
			}
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ('#__angelgirls_amizade_lista_contato'))
			->columns (array (
					$db->quoteName ( 'id_lista' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'host_ip_criador' )))
					->values(implode(',', array ($listaID, $user->id, 'NOW()', $db->quote($this->getRemoteHostIp()))));
			$db->setQuery( $query );
			if(!$db->execute()){
				$json = '{"ok":"nok", "mensagem":"Falha ao enviar a solicita&ccedil;o!"}';
			}
			$this->LogQuery($query);
			
			
			
			
			
			$query = $db->getQuery ( true );
			$query->select("`id`")
			->from ('#__angelgirls_amizade_lista')
			->where ('`nome` = \'AMIGOS\'' )
			->where ('`sistema` = \'S\'' )
			->where ('`id_usuario_criador` = ' . $user->id)
			->setLimit(1);
			$db->setQuery ( $query );
			$listaID = $db->loadObject()->id;
			if(!isset($listaID) || $listaID <= 0){
				$listaID = $this->criarListaDefaultAmigos( $user->id);
			}
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ('#__angelgirls_amizade_lista_contato'))
			->columns (array (
					$db->quoteName ( 'id_lista' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'host_ip_criador' )))
					->values(implode(',', array ($listaID, '(SELECT id_usuario_solicidante FROM #__angelgirls_amizade WHERE id = '.$idSolicitacao.')', 'NOW()', $db->quote($this->getRemoteHostIp()))));
			$db->setQuery( $query );
			if(!$db->execute()){
				$json = '{"ok":"nok", "mensagem":"Falha ao enviar a solicita&ccedil;o!"}';
			}
			$this->LogQuery($query);
			
			
				
				
			$this->EnviarMensagemInbox('Solicita&ccedil;&atilde;o de amizade', $queryUsuario, 'O usu&aacute;rio '.$perfil->nome.' aceitou sua solicita&ccedil;&atilde;o de amizade.', TipoMensagens::ACEITOU_AMIZADE);
		}
		catch(Exception $e){
			$json = '{"ok":"nok", "mensagem":"'.$e->message.'"}';
		}
		
		
	
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	
	private function getContatos($name=null){
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select("`CONTATOS`.`ID` as `id`, `USER`.`name`")
		->from ('((SELECT contato.id_usuario  AS ID, LISTA.id_usuario_criador AS ID_USER FROM
		#__angelgirls_amizade_lista_contato AS contato INNER JOIN
		#__angelgirls_amizade_lista AS LISTA ON LISTA.id = contato.id_lista)
		UNION
		(SELECT id_usuario_solicidante AS ID, id_usuario_solicitado AS ID_USER FROM #__angelgirls_amizade)
		UNION
		(SELECT id_usuario_solicitado AS ID, id_usuario_solicidante AS ID_USER FROM #__angelgirls_amizade)
		UNION
		(SELECT id_usuario_seguido AS ID, id_usuario_seguidor AS ID_USER FROM #__angelgirls_seguindo)
		UNION
		(SELECT id_usuario_seguidor AS ID, id_usuario_seguido AS ID_USER FROM #__angelgirls_seguindo)) AS CONTATOS')
		->join('INNER', '#__users AS  USER ON USER.id = CONTATOS.ID')
		->join('INNER', '#__angelgirls_perfil AS perfil ON USER.id = perfil.id_usuario')
		->where ('`CONTATOS`.`ID_USER` = '. $user->id )
		->where ('`CONTATOS`.`ID` <> '. $user->id );
		if(isset($name)){
			$query->where ('(upper(trim(`USER`.`name`))  like '.  $db->quote(strtoupper(trim($name)) .'%' ).'
					 OR upper(trim(`USER`.`email`))  like '.  $db->quote(strtoupper(trim($name)) .'%' ).'
					 OR upper(trim(`perfil`.`apelido`))  like '.  $db->quote(strtoupper(trim($name)) .'%' ).')');
		}
		$query->group ('CONTATOS.ID, USER.name, CONTATOS.ID_USER' )
		->order('USER.name' )
		->limit(10);
		$db->setQuery ( $query );
		return $db->loadObjectList();
	}
	
	
	public function getContatosJson(){
		$name = JRequest::getString('q', null);
		
		$json = json_encode($this->getContatos($name));
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	private function criarListaDefaultAmigos($idNodoLista){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->insert( $db->quoteName ('#__angelgirls_amizade_lista'))
		->columns (array (
				$db->quoteName ( 'nome' ),
				$db->quoteName ( 'sistema' ),
				$db->quoteName ( 'status_dado' ),
				$db->quoteName ( 'data_criado' ),
				$db->quoteName ( 'data_alterado' ),
				$db->quoteName ( 'id_usuario_criador' ),
				$db->quoteName ( 'id_usuario_alterador' ),
				$db->quoteName ( 'host_ip_criador' ),
				$db->quoteName ( 'host_ip_alterador' )))
				->values(implode(',', array ('AMIGOS', 'S', $db->quote(StatusDado::NOVO), 'NOW()', 'NOW()', $idNodoLista, $idNodoLista,
						$db->quote($this->getRemoteHostIp()), $db->quote($this->getRemoteHostIp())
				)));
		$db->setQuery( $query );
		$db->execute();
		$id = $db->insertid();
		$this->LogQuery($query);
		return $id;
	}
		
/**************************************************************************************************************/
/************************************************      POST    ************************************************/
/**************************************************************************************************************/
	public function salvarPost(){
		$json= "";
		//json_encode($mensage);
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$perfil = $this::getPerfilLogado();
		$texto = JRequest::getInt('texto', '', 'POST' );
		$id = JRequest::getInt('id', null, 'POST' );
		
		if(!isset($id)){
			$query = $db->getQuery ( true );
			$query->insert( $db->quoteName ( '#__angelgirls_post' ) )
			->columns (array (
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'texto' ),
					$db->quoteName ( 'audiencia_gostou' ),
					$db->quoteName ( 'audiencia_ngostou' ),
					$db->quoteName ( 'audiencia_view' ),
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'host_ip_criador' ),
					$db->quoteName ( 'host_ip_alterador' ),
					))
					->values(implode(',', array(
							$user->id,
							$db->quote($texto),
							0,0,0,
							$db->quote(StatusDado::NOVO),
							$user->id,
							$user->id,
							'NOW()',
							'NOW()',
							$db->quote($this->getRemoteHostIp()),
							$db->quote($this->getRemoteHostIp())
							
					)));
			$db->setQuery( $query );
			if($db->execute()){
				$json='{"ok":"ok"}';
			}
			else{
				$json='{"ok":"nok"}';
			}
			$this->LogQuery($query);
		}
		else{
			$query = $db->getQuery ( true );
			$query->update($db->quoteName('#__angelgirls_post'))
			->set(array(
				$db->quoteName ( 'texto' ) . ' = ' . $db->quote($texto),
				$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' =  NOW() ',
				$db->quoteName ( 'host_ip_alterador' ) .' = ' . $db->quote($this->getRemoteHostIp())
			))
			->where(' id_usuario = ' . $user->id) 
			->where(' id = ' . $id);
			
			$db->setQuery( $query );
			if($db->execute()){
				$json='{"ok":"ok"}';
			}
			else{
				$json='{"ok":"nok"}';
			}
			$this->LogQuery($query);
		}
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	public function excluirPost(){
		//json_encode($mensage);
		$user = JFactory::getUser();
		$db = JFactory::getDbo ();
		$perfil = $this::getPerfilLogado();
		$texto = JRequest::getInt('texto', '', 'POST' );
		$id = JRequest::getInt('id', null, 'POST' );
		
		$json= "";
		$query = $db->getQuery ( true );
		$query->update($db->quoteName('#__angelgirls_post'))
		->set(array(
				$db->quoteName ( 'status_dado' ) . ' = ' . $db->quote(StatusDado::REMOVIDO),
				$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $user->id,
				$db->quoteName ( 'data_alterado' ) . ' =  NOW() ',
				$db->quoteName ( 'host_ip_alterador' ) .' = ' . $db->quote($this->getRemoteHostIp())
		))
		->where(' id_usuario = ' . $user->id)
		->where(' id = ' . $id);
			
		$db->setQuery( $query );
		if($db->execute()){
			$json='{"ok":"ok"}';
		}
		else{
			$json='{"ok":"nok"}';
		}
		$this->LogQuery($query);
		
		
		
		
		header('Content-Type: application/json; charset=utf8');
		header("Content-Length: " . strlen($json));
		echo $json;
		exit();
	}
	
	
}