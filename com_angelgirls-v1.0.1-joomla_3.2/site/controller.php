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
		/*'<?xml version="1.0" encoding="UTF-8"?>\n';*/
		$xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_(ContentHelperRoute::getArticleRoute($result->slug, $result->catid, $result->language));
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-dTH:i:sP')  . "</lastmod>\n";
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
		//TODO
	
		exit();
	}

	/**
	 * Sitemap das JTags
	 */
	function sitemapTags(){
		//TODO
	
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
				->where ( $db->quoteName ( 'status_modelo' ) . ' = \'ATIVA\' ' )
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'foto_perfil' ) . " <> '' " )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		/*'<?xml version="1.0" encoding="UTF-8"?>\n';*/
		$xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$result->id.':modelo-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-dTH:i:sP')  . "</lastmod>\n";
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
	
	function sitemapFotografos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_fotografo')
				->where ( $db->quoteName ( 'status_dado' ) . ' <> \'REMOVED\' ' )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		/*'<?xml version="1.0" encoding="UTF-8"?>\n';*/
		$xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$result->id.':modelo-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-dTH:i:sP')  . "</lastmod>\n";
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
	

	
	function sitemapSessaos(){
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','titulo','data_alterado'),
				array('id','alias','modified')))
				->from ('#__angelgirls_sessao')
				->where ( $db->quoteName ( 'status_dado' ) . " = 'PUBLICADO' " )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " )
				->order('data_criado DESC ')
				->setLimit(50000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		/*'<?xml version="1.0" encoding="UTF-8"?>\n';*/
		$xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach ( $results as $result){
			$url = $_SERVER['HTTP_HOST'] . JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$result->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$result->alias)),false);
			$xml = $xml . "\t<url>\n";
			$xml = $xml . "\t\t<lastmod>" . JFactory::getDate($result->modified)->format('Y-m-dTH:i:sP')  . "</lastmod>\n";
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
		//TODO
	
		exit();
	}
	
	function sitemapCategorias(){
		//TODO

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
	
	/**
	 * 
	 */
	public function carregarSessao(){
		$id = JRequest::getString( 'id',0,'GET');
		

		
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('s.id','s.titulo','s.nome_foto','s.executada','s.descricao','s.historia','s.comentario_fotografo','s.comentario_modelos',
									's.comentario_equipe','s.meta_descricao','s.id_agenda','s.id_tema','s.id_modelo_principal','s.id_modelo_secubdaria',
									's.id_locacao','s.id_fotografo_principal','s.id_fotografo_secubdario','s.id_producao_principal',
									's.id_producao_secubdario','s.id_figurino_principal','s.id_figurino_secubdario','s.audiencia_gostou',
									's.audiencia_ngostou','s.audiencia_view','s.publicar','s.status_dado','s.id_usuario_criador',
									's.id_usuario_alterador','s.data_criado','s.data_alterado','tema.nome','tema.descricao'),
									array('id','titulo','nome_foto','executada','descricao','historia','comentario_fotografo','comentario_modelos',
									'comentario_equipe','meta_descricao','id_agenda','id_tema','id_modelo_principal','id_modelo_secubdaria',
									'id_locacao','id_fotografo_principal','id_fotografo_secubdario','id_producao_principal',
									'id_producao_secubdario','id_figurino_principal','id_figurino_secubdario','audiencia_gostou',
									'audiencia_ngostou','audiencia_view','publicar','status_dado','id_usuario_criador',
									'id_usuario_alterador','data_criado','data_alterado','nome','descricao_tema')))
				->from ( $db->quoteName ( '#__angelgirls_sessao', 's' ) )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_tema', 'tema' ) . ' ON (' . $db->quoteName ( 'tema.id' ) . ' = ' . $db->quoteName ( 's.id_tema' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_fotografo', 'fot1' ) . ' ON (' . $db->quoteName ( 'fot1.id' ) . ' = ' . $db->quoteName ( 's.id_fotografo_principal' ) . ')' )
				->join ( 'LEFT', $db->quoteName ( '#__angelgirls_fotografo', 'fot2' ) . ' ON (' . $db->quoteName ( 'fot2.id' ) . ' = ' . $db->quoteName ( 's.id_fotografo_secubdario' ) . ')' )
				->where ( $db->quoteName ( 's.status_dado' ) . " = 'PUBLICADO' " )
				->where ( $db->quoteName ( 's.publicar' ) . " <= NOW() " )
				->where ( $db->quoteName ( 's.id' ) . " =  " . $id );
		
		$query->setLimit(1);
		$db->setQuery ( $query );
		$result = $db->loadObject();
		JRequest::setVar ( 'sessao', $result );
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'sessao' );
		parent::display (true, false);
	}
	
	public function carregarSessoes(){
		$user = JFactory::getUser();
		$nome = JRequest::getString( 'nome', null, 'POST' );
		$idModelo = JRequest::getInt( 'id_modelo', null, 'POST' );
		$idFotografo = JRequest::getInt( 'id_fotografo', null, 'POST' );
		$dataInicio = JRequest::getString( 'data_inicio', null, 'POST' );
		$dataFim = JRequest::getString( 'data_fim', null, 'POST' );
		
		$ordem = JRequest::getInt( 'ordem', null, 'POST' );
		
		$db = JFactory::getDbo ();
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
				->join ( 'LEFT', '(SELECT data_criado, id_sessao FROM #__angelgirls_vt_sessao WHERE id_usuario='.$user->id.') v ON ' . $db->quoteName ( 's.id' ) . ' = ' . $db->quoteName ( 'v.id_sessao' )  )
				->where ( $db->quoteName ( 'status_dado' ) . " = 'PUBLICADO' " )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " );
		
		if(isset($nome) && trim($nome) != ""){
			$query->where (  " ( upper(titulo) like " . $db->quote(strtoupper(trim($nome)).'%') . " OR 
					SOUNDEX(upper(titulo)) like SOUNDEX(" . $db->quote(strtoupper(trim($nome)).'%') . ")");
		}
		if(isset($dataInicio) && trim($dataInicio) != ""){
			//$dataFormatadaBanco = substr($dataInicio,6,10) . '-' . substr($dataInicio,4,5) . '-' . substr($dataInicio,0,2);
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataInicio)->format('Y-m-d');
			$query->where (  " publicar >= " . $db->quote($dataFormatadaBanco));
		}
		if(isset($dataFim) && trim($dataFim) != ""){
			$dataFormatadaBanco = DateTime::createFromFormat('d/m/Y', $dataFim)->format('Y-m-d');
			$query->where (  " publicar <= " . $db->quote($dataFormatadaBanco));
		}
		if(isset($idModelo) && $idModelo != 0 ){
			$query->where (  ' ( ' . $db->quoteName ('id_modelo_principal') . ' = ' . $idModelo . ' OR ' . $db->quoteName ('id_modelo_secubdaria') . ' = ' . $idModelo . ')');
		}
		if(isset($idFotografo) && $idFotografo != 0 ){
			$query->where (  ' ( ' . $db->quoteName ('id_fotografo_principal') . ' = ' . $idFotografo . ' OR ' . $db->quoteName ('id_fotografo_secubdario') . ' = ' . $idFotografo . ')');
		}
		
		
		if(isset($ordem) && $ordem != 0 ){
			if($ordem == 1){
				$query->order('publicar DESC ');
			}
			elseif($ordem == 2){
				$query->order('publicar ASC ');
			}
			elseif($ordem == 3){
				$query->order('titulo DESC ');
			}
			elseif($ordem == 4){
				$query->order('titulo ASC ');
			}
			else{
				$query->order('publicar DESC ');
			}
		}
		else{
			$query->order('publicar DESC ');
		}
		$query->setLimit(30);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'sessoes', $results );
		
		
		

		$query = $db->getQuery ( true );
		$query->select($db->quoteName(array('id','nome_artistico','nome_artistico','foto_perfil'),
				array('id','nome','alias','foto')))
				->from ('#__angelgirls_modelo')
				->where ( $db->quoteName ( 'status_modelo' ) . ' = \'ATIVA\' ' )
				->where ( $db->quoteName ( 'status_dado' ) . ' = \'ATIVA\' ' )
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
				->where ( $db->quoteName ( 'status_dado' ) . ' = \'ATIVA\' ' )
				->where ( $db->quoteName ( 'nome_foto' ) . ' IS NOT NULL ' )
				->where ( $db->quoteName ( 'nome_foto' ) . " <> '' " )
				->order('nome_artistico')
				->setLimit(5000);
		$db->setQuery ( $query );
		$results = $db->loadObjectList();
		JRequest::setVar ( 'fotografos', $results );
		
		
		JRequest::setVar ( 'view', 'sessoes' );
		JRequest::setVar ( 'layout', 'default' );
		parent::display ();
	}
	
	
	/**
	 * 
	 * @return usuario salvo
	 */
	public function salvarUsuario(){ 
		$user = JFactory::getUser(0);
		$usersParams = JComponentHelper::getParams( 'com_users' );
		$userdata = array();
		$userdata['username'] = JRequest::getString( 'username', null, 'POST' );
		$userdata['email'] = JRequest::getString( 'email', null, 'POST' );
		$userdata['email1'] = JRequest::getString( 'email1', null, 'POST' );
		$userdata['name'] = JRequest::getString( 'name', null, 'POST' );
		$userdata['password'] = JRequest::getString( 'password', null, 'POST' );
		$userdata['password2'] = JRequest::getString( 'password1', null, 'POST' );
		$defaultUserGroup = $usersParams->get('new_usertype', 2);
		$userdata['groups']=array($defaultUserGroup);
		$userdata['block'] = 0;
		if (!$user->bind($userdata)) {
			echo(JText::_( $user->getError()));
		}
		if (!$user->save()) { // now check if the new user is saved
			echo(JText::_( $user->getError())); // something went wrong!!
		}
		return $user;
	}
	
	
	
	
	
	
	public function salvarVisitante(){
		if(!JSession::checkToken('post')) die ('Restricted access');

		$sucesso=true;
		
		$uploadPath = JPATH_SITE . DS . 'images' . DS . 'modelos' . DS;
		$erro = false;
		
		$id = JRequest::getInt ( 'id', 0, 'POST' );
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
		$statusModelo = JRequest::getString ( 'status_modelo', null, 'POST' );
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$dataFormatadaBanco = 'null';
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(DateTime::createFromFormat('d/m/Y', $dataNascimento)->format('Y-m-d'));
		}
		
		
		$foto_perfil = $_FILES ['foto_perfil'];

		
		$db = JFactory::getDbo ();
		
		
		if ($id != null && $id != 0) { // UPDATE
			$usuario = JFactory::getUser();
			$query = $db->getQuery ( true );
			$query->update ( $db->quoteName ( '#__angelgirls_visitante' ) )->set ( array (
					$db->quoteName ( 'data_alterado' ) . ' = NOW() ',
					$db->quoteName ( 'id_usuario_alterador' ) . ' = ' . $usuario->id,
					$db->quoteName ( 'nome_artistico' ) . ' = ' . $db->quote($nomeArtistico),
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
					$db->quoteName ( 'status_modelo' ) . ' = ' . ($statusModelo == null ? ' null ' : $db->quote($statusModelo)),
					$db->quoteName ( 'qualificao_equipe' ) . ' = ' . ($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
					$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade))
			))
			->where ($db->quoteName ( 'id' ) . ' = ' . $id)
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );
			$db->execute ();
		} else {
			$usuario = $this->salvarUsuario();
			$sucesso = ($usuario != null && $usuario->id != null && $usuario->id != 0);
			if($sucesso){
				$query = $db->getQuery ( true );
				$query->insert( $db->quoteName ( '#__angelgirls_visitante' ) )->columns ( array (
					$db->quoteName ( 'status_dado' ),
					$db->quoteName ( 'data_criado' ),
					$db->quoteName ( 'id_usuario_criador' ),
					$db->quoteName ( 'data_alterado' ),
					$db->quoteName ( 'id_usuario_alterador' ),
					$db->quoteName ( 'id_usuario' ),
					$db->quoteName ( 'nome_artistico' ),
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
		}
		
		if($id != 0){
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$fileName = $foto_perfil ['name'];
				$uploadedFileNameParts = explode ( '.', $fileName );
				$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
					
				$fileTemp = $foto_perfil ['tmp_name'];
				$newfile = $uploadPath . $id . '_perfil.' . $uploadedFileExtension;
				if (JFolder::exists ( $newfile )) {
					JFile::delete ( $newfile );
				}
				if (! JFile::upload ( $fileTemp, $newfile )) {
					JError::raiseWarning ( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
				} else {
					$query = $db->getQuery ( true );
					$query->update ( $db->quoteName ( '#__angelgirls_visitante' ) )->set ( array (
							$db->quoteName ( 'nome_foto' ) . ' = ' . $db->quote ( $id . '.' . $uploadedFileExtension )
					) )->where ( array (
							$db->quoteName ( 'id' ) . ' = ' . $id
					) );
					$db->setQuery ( $query );
					$db->execute ();
				}
			}
			

			
				
			
			JRequest::setVar ( 'id', $id );
			JRequest::setVar ( 'view', 'cadastro' );
			JRequest::setVar ( 'layout', 'sucesso' );
			parent::display (true, false);
		}
	}
	
	
	public function salvarFotografo(){
		if(!JSession::checkToken('post')) die ('Restricted access');

		$sucesso=true;
		
		$uploadPath = JPATH_SITE . DS . 'images' . DS . 'modelos' . DS;
		$erro = false;
		
		$id = JRequest::getInt ( 'id', 0, 'POST' );
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
		$statusModelo = JRequest::getString ( 'status_modelo', null, 'POST' );
		$qualificaoEquipe = JRequest::getString ( 'qualificao_equipe', null, 'POST' );
		$idCidade = JRequest::getInt ( 'id_cidade', null, 'POST' );
		$dataFormatadaBanco = 'null';
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(DateTime::createFromFormat('d/m/Y', $dataNascimento)->format('Y-m-d'));
		}
		$foto_perfil = $_FILES ['foto_perfil'];

		
		$db = JFactory::getDbo ();
		
		
		if ($id != null && $id != 0) { // UPDATE
			$usuario = JFactory::getUser();
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
					$db->quoteName ( 'status_modelo' ) . ' = ' . ($statusModelo == null ? ' null ' : $db->quote($statusModelo)),
					$db->quoteName ( 'qualificao_equipe' ) . ' = ' . ($qualificaoEquipe == null ? ' null ' : $db->quote($qualificaoEquipe)),
					$db->quoteName ( 'id_cidade' ) . ' = ' . ($idCidade == null ? ' null ' : $db->quote($idCidade))
			))
			->where ($db->quoteName ( 'id' ) . ' = ' . $id)
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );
			$db->execute ();
		} else {
			$usuario = $this->salvarUsuario();
			$sucesso = ($usuario != null && $usuario->id != null && $usuario->id != 0);
			if($sucesso){
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
		}
		
		if($id != 0){
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$fileName = $foto_perfil ['name'];
				$uploadedFileNameParts = explode ( '.', $fileName );
				$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
					
				$fileTemp = $foto_perfil ['tmp_name'];
				$newfile = $uploadPath . $id . '_perfil.' . $uploadedFileExtension;
				if (JFolder::exists ( $newfile )) {
					JFile::delete ( $newfile );
				}
				if (! JFile::upload ( $fileTemp, $newfile )) {
					JError::raiseWarning ( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
				} else {
					$query = $db->getQuery ( true );
					$query->update ( $db->quoteName ( '#__angelgirls_fotografo' ) )->set ( array (
							$db->quoteName ( 'nome_foto' ) . ' = ' . $db->quote ( $id . '.' . $uploadedFileExtension )
					) )->where ( array (
							$db->quoteName ( 'id' ) . ' = ' . $id
					) );
					$db->setQuery ( $query );
					$db->execute ();
				}
			}
			JRequest::setVar ( 'id', $id );
			JRequest::setVar ( 'view', 'cadastro' );
			JRequest::setVar ( 'layout', 'sucesso' );
			parent::display (true, false);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function salvarModelo(){
		if(!JSession::checkToken('post')) die ('Restricted access');

		$sucesso=true;
		
		$uploadPath = JPATH_SITE . DS . 'images' . DS . 'modelos' . DS;
		$erro = false;
		
		$id = JRequest::getInt ( 'id', 0, 'POST' );
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
		if($dataNascimento != null && strlen($dataNascimento) > 8){
			$dataFormatadaBanco= $db->quote(DateTime::createFromFormat('d/m/Y', $dataNascimento)->format('Y-m-d'));
		}
		
		
		$foto_perfil = $_FILES ['foto_perfil'];
		$foto_inteira = $_FILES ['foto_inteira'];
		$foto_inteira_horizontal = $_FILES ['foto_inteira_horizontal'];
		
		$db = JFactory::getDbo ();
		
		
		if ($id != null && $id != 0) { // UPDATE
			$usuario = JFactory::getUser();
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
			->where ($db->quoteName ( 'id' ) . ' = ' . $id)
			->where ($db->quoteName ( 'id_usuario' ) . ' = ' . $usuario->id);
			$db->setQuery ( $query );
			$db->execute ();
		} else {
			$usuario = $this->salvarUsuario();
			$sucesso = ($usuario != null && $usuario->id != null && $usuario->id != 0);
			if($sucesso){
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
		}
		
		if($id != 0){
			if (isset ( $foto_perfil ) && JFile::exists ( $foto_perfil ['tmp_name'] )) {
				$fileName = $foto_perfil ['name'];
				$uploadedFileNameParts = explode ( '.', $fileName );
				$uploadedFileExtension = array_pop ( $uploadedFileNameParts );
					
				$fileTemp = $foto_perfil ['tmp_name'];
				$newfile = $uploadPath . $id . '_perfil.' . $uploadedFileExtension;
				if (JFolder::exists ( $newfile )) {
					JFile::delete ( $newfile );
				}
				if (! JFile::upload ( $fileTemp, $newfile )) {
					JError::raiseWarning ( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
				} else {
					$query = $db->getQuery ( true );
					$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
							$db->quoteName ( 'foto_perfil' ) . ' = ' . $db->quote ( $id . '.' . $uploadedFileExtension )
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
				$newfile = $uploadPath . $id . '_inteira.' . $uploadedFileExtension;
			
				if (JFolder::exists ( $newfile )) {
					JFile::delete ( $newfile );
				}
			
				if (! JFile::upload ( $fileTemp, $newfile )) {
					JError::raiseWarning ( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
				} else {
					$query = $db->getQuery ( true );
					$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
							$db->quoteName ( 'foto_inteira' ) . ' = ' . $db->quote ( $id . '.' . $uploadedFileExtension )
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
				$newfile = $uploadPath . $id . '_inteira_h.' . $uploadedFileExtension;
					
				if (JFolder::exists ( $newfile )) {
					JFile::delete ( $newfile );
				}
					
				if (! JFile::upload ( $fileTemp, $newfile )) {
					JError::raiseWarning ( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
				} else {
					$query = $db->getQuery ( true );
					$query->update ( $db->quoteName ( '#__angelgirls_modelo' ) )->set ( array (
							$db->quoteName ( 'foto_inteira_horizontal' ) . ' = ' . $db->quote ( $id . '.' . $uploadedFileExtension )
					) )->where ( array (
							$db->quoteName ( 'id' ) . ' = ' . $id
					) );
					$db->setQuery ( $query );
					$db->execute ();
				}
			}
			
			
			JRequest::setVar ( 'id', $id );
			JRequest::setVar ( 'view', 'cadastro' );
			JRequest::setVar ( 'layout', 'sucesso' );
			parent::display (true, false);
		}
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
				->where ( $db->quoteName ( 'status_dado' ) . " = 'PUBLICADO' " )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " )
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
				->where ( $db->quoteName ( 'status_dado' ) . " = 'PUBLICADO' " )
				->where ( $db->quoteName ( 'publicar' ) . " <= NOW() " )
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

