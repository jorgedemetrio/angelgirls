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
 * General Controller of Angelgirls component
 */
class AngelgirlsController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Angelgirls'));

		// call parent behavior
		parent::display($cachable);

		// set view
		$view = strtolower(JRequest::getVar('view'));

		// Set the submenu
		AngelgirlsHelper::addSubmenu($view);
	}
	

	
	/******************** MODELO ******************************************/
	
	
	public function deleteModelo(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
	
		$id = JRequest::getInt('id', 0);
	
		if($id!=0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
	
			$query->update($db->quoteName('#__angelgirls_modelo'))
			->set(array(
					$db->quoteName('status_dado') . ' = \'REMOVED\'' ,
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id))
					->where(array($db->quoteName('id') . ' = '.$id));
	
			$db->setQuery($query);
	
			$db->execute();
		}
	
		$this->listModelo();
	}
	
	public function editModelo(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		$id = JRequest::getInt('id', 0);
	
		//Carregar cidade e estado

		
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
	
		$query->select($db->quoteName(array('a.id',	'a.id_usuario',	'a.nome_artistico',	'a.descricao', 'a.meta_descricao','a.foto_perfil',
											'a.foto_inteira','a.altura',	'a.peso','a.busto',	'a.calsa','a.calsado','a.olhos','a.pele',
											'a.etinia','a.cabelo','a.tamanho_cabelo','a.cor_cabelo','a.outra_cor_cabelo','a.profissao',
											'a.nascionaldiade',	'a.id_cidade_nasceu','a.data_nascimento','a.site','a.sexo',	'a.cpf',
											'a.banco','a.agencia','a.conta','a.custo_medio_diaria','a.status_modelo','a.qualificao_equipe',
											'a.audiencia_gostou','a.audiencia_ngostou',	'a.audiencia_view',	'a.id_cidade','a.status_dado',
											'a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado','b.name','c.name',
											'd.name','d.username','d.email'),
				array('id','id_usuario','nome_artistico','descricao','meta_descricao','foto_perfil','foto_inteira','altura',
						'peso',	'busto','calsa','calsado','olhos','pele','etinia','cabelo','tamanho_cabelo','cor_cabelo','outra_cor_cabelo',
						'profissao','nascionaldiade','id_cidade_nasceu','data_nascimento','site','sexo','cpf','banco','agencia',
						'conta','custo_medio_diaria','status_modelo','qualificao_equipe','audiencia_gostou','audiencia_ngostou',
						'audiencia_view','id_cidade','status_dado',	'id_usuario_criador','id_usuario_alterador','data_criado',
						'data_alterado', 'criador','editor','nome','usuario','email')))
						->from($db->quoteName('#__angelgirls_modelo','a'))
						->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
						->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
						->join('INNER', $db->quoteName('#__users', 'd') . ' ON (' . $db->quoteName('a.id_usuario') . ' = ' . $db->quoteName('c.id') . ')')
						->where($db->quoteName('a.id') . ' = '. $id)
						->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ');
	
	
	
		$db->setQuery($query);
	
		$result = $db->loadObject();
		JRequest::setVar('modelo', $result);
	
	
	
	
	
		$this->addModelo();
	}
	
	/**
	 * Só carrrega a tela de adição.
	 */
	public function addModelo(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		
		$query->select($db->quoteName(array('a.id',	'a.nome','a.uf')))
				->from($db->quoteName('#__cidade','a'))
				->order('a.nome, a.uf');
				
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('cidades', $result);
		
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.uf')))
		->from($db->quoteName('#__cidade','a'))
		->group($db->quoteName(array('a.uf')))
		->order('a.uf');
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('ufs', $result);
	
	
	
	
		JRequest::setVar('view', 'modelos');
		JRequest::setVar('layout', 'cadastro');
		parent::display();
	}
	
	public function applayModelo(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$this->saveModeloDB();
		$this->editModelo();
	}
	
	/**
	 * Apenas salva no banco o dado.
	 */
	public function saveModeloDB(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
		$uploadPath = JPATH_SITE.DS.'images'.DS.'modelos'.DS;
		$erro = false;
	
		$id = JRequest::getInt('id', 0, 'POST');
		$nome = JRequest::getString('nome', '', 'POST');
		$descricao = JRequest::getString('descricao', '', 'POST');
		$metaDescricao = JRequest::getString('meta_descricao', '', 'POST');
	
	
		$foto = $_FILES['foto'];
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
	
	
		if($id!=null && $id!=0){//UPDATE
	
	
			$query->update($db->quoteName('#__angelgirls_modelo'))
			->set(array(
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id,
					$db->quoteName('nome') . ' = ' . ($nome == null ? 'null' : $db->quote($nome)),
					$db->quoteName('descricao') . ' = ' . ($descricao == null ? 'null' : $db->quote($descricao)),
					$db->quoteName('meta_descricao') . ' = ' . ($metaDescricao == null ? 'null' : $db->quote($metaDescricao))))
					->where(array($db->quoteName('id') . ' = '.$id));
	
			$db->setQuery($query);
	
			$db->execute();
		}
		else{
			$query->insert($db->quoteName('#__angelgirls_modelo'))
			->columns(array(
					$db->quoteName('status_dado'),
					$db->quoteName('data_criado'),
					$db->quoteName('id_usuario_criador'),
					$db->quoteName('data_alterado'),
					$db->quoteName('id_usuario_alterador'),
					$db->quoteName('nome'),
					$db->quoteName('descricao'),
					$db->quoteName('meta_descricao')))
					->values(implode(',',array(
							'\'NOVO\'',
							'NOW()',
							$user->id,
							'NOW()',
							$user->id,
							($nome == null ? 'null' : $db->quote($nome)),
							($descricao == null ? 'null' : $db->quote($descricao)),
							($metaDescricao == null ? 'null' : $db->quote($metaDescricao)))));
	
					$db->setQuery($query);
	
					$db->execute();
	
					$id=$db->insertid();
						
					JRequest::setVar('id',$id);
		}
	
	
		if(isset($foto) && JFolder::exists($foto['tmp_name'])){
			$fileName = $foto['name'];
			$uploadedFileNameParts = explode('.',$fileName);
			$uploadedFileExtension = array_pop($uploadedFileNameParts);
				
			$fileTemp = $foto['tmp_name'];
			$newfile = $uploadPath . $id . '.' . $uploadedFileExtension;
				
			if(JFolder::exists($newfile)){
				JFile::delete($newfile);
			}
				
			if(!JFile::upload($fileTemp, $newfile)){
				JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
				$erro = true;
			}
			else{
				$query->update($db->quoteName('#__angelgirls_modelo'))
				->set(array($db->quoteName('nome_foto') . ' = ' . $db->quote($id.'.'.$uploadedFileExtension)))
				->where(array($db->quoteName('id') . ' = '.$id));
				$db->setQuery($query);
				$db->execute();
			}
		}
		if(!$erro){
			JFactory::getApplication()->enqueueMessage('Modelo salvo com sucesso');
		}
	}
	
	
	public function saveModelo(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$this->saveModeloDB();
		$this->listModelo();
	}
	
	
	public function listModelo(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		$query->select($db->quoteName(array('a.id',	'a.id_usuario',	'a.nome_artistico',	'a.descricao', 'a.meta_descricao','a.foto_perfil',
											'a.foto_inteira','a.altura',	'a.peso','a.busto',	'a.calsa','a.calsado','a.olhos','a.pele',
											'a.etinia','a.cabelo','a.tamanho_cabelo','a.cor_cabelo','a.outra_cor_cabelo','a.profissao',
											'a.nascionaldiade',	'a.id_cidade_nasceu','a.data_nascimento','a.site','a.sexo',	'a.cpf',
											'a.banco','a.agencia','a.conta','a.custo_medio_diaria','a.status_modelo','a.qualificao_equipe',
											'a.audiencia_gostou','a.audiencia_ngostou',	'a.audiencia_view',	'a.id_cidade','a.status_dado',
											'a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado','b.name','c.name',
											'd.name','d.username','d.email'),
				array('id','id_usuario','nome_artistico','descricao','meta_descricao','foto_perfil','foto_inteira','altura',
						'peso',	'busto','calsa','calsado','olhos','pele','etinia','cabelo','tamanho_cabelo','cor_cabelo','outra_cor_cabelo',
						'profissao','nascionaldiade','id_cidade_nasceu','data_nascimento','site','sexo','cpf','banco','agencia',
						'conta','custo_medio_diaria','status_modelo','qualificao_equipe','audiencia_gostou','audiencia_ngostou',
						'audiencia_view','id_cidade','status_dado',	'id_usuario_criador','id_usuario_alterador','data_criado',
						'data_alterado', 'criador','editor','nome','usuario','email')))
						->from($db->quoteName('#__angelgirls_modelo','a'))
						->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
						->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
						->join('INNER', $db->quoteName('#__users', 'd') . ' ON (' . $db->quoteName('a.id_usuario') . ' = ' . $db->quoteName('c.id') . ')')
						->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ')
						->order('data_alterado ASC');
	
		$db->setQuery($query);
	
		$results = $db->loadObjectList();
	
	
	
		JRequest::setVar('lista', $results);
		JRequest::setVar('view', 'modelos');
		JRequest::setVar('layout', 'default');
		parent::display();
	}	
	
	
	
	/******************** TEMA ******************************************/
	
	
	public function deleteTema(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
	
		$id = JRequest::getInt('id', 0);
	
		if($id!=0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
				
			$query->update($db->quoteName('#__angelgirls_tema'))
			->set(array(
					$db->quoteName('status_dado') . ' = \'REMOVED\'' ,
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id))
					->where(array($db->quoteName('id') . ' = '.$id));
				
			$db->setQuery($query);
				
			$db->execute();
		}
	
		$this->listTema();
	}
	
	public function editTema(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		$id = JRequest::getInt('id', 0);
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
	
		$query->select($db->quoteName(array('a.id','a.nome','a.nome_foto','a.descricao','a.meta_descricao','a.audiencia_gostou','a.audiencia_ngostou','a.audiencia_view',
				'a.status_dado','a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado',
				'b.name','c.name'),
				array('id','nome','nome_foto','descricao','meta_descricao','audiencia_gostou','audiencia_ngostou','audiencia_view',
						'status_dado','id_usuario_criador','id_usuario_alterador','data_criado','data_alterado', 'criador','editor')))
				->from($db->quoteName('#__angelgirls_tema','a'))
				->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
				->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
				->where($db->quoteName('a.id') . ' = '. $id)
				->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ');
	
	
	
		$db->setQuery($query);
	
		$result = $db->loadObject();
		JRequest::setVar('tema', $result);
	
	
	
	
	
		$this->addTema();
	}
	
	/**
	 * Só carrrega a tela de adição.
	 */
	public function addTema(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	

	
	
		JRequest::setVar('view', 'temas');
		JRequest::setVar('layout', 'cadastro');
		parent::display();
	}
	
	public function applayTema(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$this->saveTemaDB();
		$this->editTema();
	}
	
	/**
	 * Apenas salva no banco o dado.
	 */
	public function saveTemaDB(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
		$uploadPath = JPATH_SITE.DS.'images'.DS.'temas'.DS;
		$erro = false;
	
		$id = JRequest::getInt('id', 0, 'POST');
		$nome = JRequest::getString('nome', '', 'POST');
		$descricao = JRequest::getString('descricao', '', 'POST');
		$metaDescricao = JRequest::getString('meta_descricao', '', 'POST');
	

		$foto = $_FILES['foto'];
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		

	
		if($id!=null && $id!=0){//UPDATE
	
	
			$query->update($db->quoteName('#__angelgirls_tema'))
			->set(array(
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id,
					$db->quoteName('nome') . ' = ' . ($nome == null ? 'null' : $db->quote($nome)),
					$db->quoteName('descricao') . ' = ' . ($descricao == null ? 'null' : $db->quote($descricao)),
					$db->quoteName('meta_descricao') . ' = ' . ($metaDescricao == null ? 'null' : $db->quote($metaDescricao))))
					->where(array($db->quoteName('id') . ' = '.$id));
	
			$db->setQuery($query);
	
			$db->execute();
		}
		else{
			$query->insert($db->quoteName('#__angelgirls_tema'))
			->columns(array(
					$db->quoteName('status_dado'),
					$db->quoteName('data_criado'),
					$db->quoteName('id_usuario_criador'),
					$db->quoteName('data_alterado'),
					$db->quoteName('id_usuario_alterador'),
					$db->quoteName('nome'),
					$db->quoteName('descricao'),
					$db->quoteName('meta_descricao')))
			->values(implode(',',array(
					'\'NOVO\'',
					'NOW()',
					$user->id,
					'NOW()',
					$user->id,
					($nome == null ? 'null' : $db->quote($nome)),
					($descricao == null ? 'null' : $db->quote($descricao)),
					($metaDescricao == null ? 'null' : $db->quote($metaDescricao)))));
				
			$db->setQuery($query);
				
			$db->execute();
				
			$id=$db->insertid();
			
			JRequest::setVar('id',$id);
		}
	
		
		if(isset($foto) && JFolder::exists($foto['tmp_name'])){
			$fileName = $foto['name'];
			$uploadedFileNameParts = explode('.',$fileName);
			$uploadedFileExtension = array_pop($uploadedFileNameParts);
			
			$fileTemp = $foto['tmp_name'];
			$newfile = $uploadPath . $id . '.' . $uploadedFileExtension;
			
			if(JFolder::exists($newfile)){
				JFile::delete($newfile);
			}
			
			if(!JFile::upload($fileTemp, $newfile)){
					JError::raiseWarning( 100, 'Falha ao salvar o arquivo.' );
					$erro = true;
			}
			else{
				$query->update($db->quoteName('#__angelgirls_tema'))
					->set(array($db->quoteName('nome_foto') . ' = ' . $db->quote($id.'.'.$uploadedFileExtension)))
					->where(array($db->quoteName('id') . ' = '.$id));
				$db->setQuery($query);
				$db->execute();
			}
		}
		if(!$erro){
			JFactory::getApplication()->enqueueMessage('Tema salvo com sucesso');
		}
	}
	
	
	public function saveTema(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$this->saveTemaDB();
		$this->listTema();
	}
	
	
	public function listTema(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		$query->select($db->quoteName(array('a.id','a.nome','a.descricao','a.nome_foto','a.meta_descricao','a.audiencia_gostou','a.audiencia_ngostou','a.audiencia_view',
				'a.status_dado','a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado',
				'b.name','c.name'),
				array('id','nome','descricao','nome_foto','meta_descricao','audiencia_gostou','audiencia_ngostou','audiencia_view',
						'status_dado','id_usuario_criador','id_usuario_alterador','data_criado','data_alterado', 'criador','editor')))
			->from($db->quoteName('#__angelgirls_tema','a'))
			->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
			->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
			->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ')
			->order('data_alterado ASC');
	
		$db->setQuery($query);
	
		$results = $db->loadObjectList();
	
	
	
		JRequest::setVar('lista', $results);
		JRequest::setVar('view', 'temas');
		JRequest::setVar('layout', 'default');
		parent::display();
	}
	
	
	/******************** AGENDA ******************************************/
	
	
	public function deleteAgenda(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
		
		$id = JRequest::getInt('id', 0);
		
		if($id!=0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$query->update($db->quoteName('#__angelgirls_agenda'))
			->set(array(
					$db->quoteName('status_dado') . ' = \'REMOVED\'' ,
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id))
			->where(array($db->quoteName('id') . ' = '.$id));
			
			$db->setQuery($query);
			
			$db->execute();
		}
		
		$this->listAgenda();
	}
	
	public function editAgenda(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		$id = JRequest::getInt('id', 0);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		
		$query->select($db->quoteName(array('a.id','a.data','a.titulo','a.tipo','a.descricao','a.meta_descricao','a.audiencia_gostou','a.audiencia_ngostou','a.audiencia_view','a.id_tema',
				'a.id_modelo','a.id_locacao','a.id_fotografo','a.publicar','a.status_dado','a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado',
				'b.name','c.name'),
				array('id','data','titulo','tipo','descricao','meta_descricao','audiencia_gostou','audiencia_ngostou','audiencia_view','id_tema',
						'id_modelo','id_locacao','id_fotografo','publicar','status_dado','id_usuario_criador','id_usuario_alterador','data_criado','data_alterado',
						'criador','editor')))
						->from($db->quoteName('#__angelgirls_agenda','a'))
						->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
						->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
						->where($db->quoteName('a.id') . ' = '. $id)
						->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ');
		
		
		
		$db->setQuery($query);
		
		$result = $db->loadObject();
		JRequest::setVar('agenda', $result);
		
		
		
		
		
		$this->addAgenda();
	}
	
	/**
	 * Só carrrega a tela de adição.
	 */
	public function addAgenda(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		//fotografo
		//modelo
		//locacao
		//tema
		
		$query->select($db->quoteName(array('a.id','a.id_usuario','a.nome_artistico'),
				array('id','id_usuario','nome')))
			->from($db->quoteName('#__angelgirls_modelo','a'))
			->where( $db->quoteName('status_dado') . ' <> \'REMOVED\' ')
			->order($db->quoteName('a.nome_artistico') . ' DESC');
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('modelos', $result);
		
		
		
		$query->select($db->quoteName(array('a.id','a.id_usuario','a.nome_artistico'),
										array('id','id_usuario','nome')))
			->from($db->quoteName('#__angelgirls_fotografo','a'))
			->where( $db->quoteName('status_dado') . ' <> \'REMOVED\' ')
			->order($db->quoteName('a.nome_artistico') . ' DESC');
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('fotografos', $result);
		
		
		$query->select($db->quoteName(array('a.id','a.nome')))
		->from($db->quoteName('#__angelgirls_tema','a'))
		->where( $db->quoteName('status_dado') . ' <> \'REMOVED\' ')
		->order($db->quoteName('a.nome') . ' DESC');
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('temas', $result);
		
		
		$query->select($db->quoteName(array('a.id','a.nome')))
		->from($db->quoteName('#__angelgirls_locacao','a'))
		->where( $db->quoteName('status_dado') . ' <> \'REMOVED\' ')
		->order($db->quoteName('a.nome') . ' DESC');
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		JRequest::setVar('locacoes', $result);
		
		
		JRequest::setVar('view', 'agendas');
		JRequest::setVar('layout', 'cadastro');
		parent::display();		
	}
	
	public function applayAgenda(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		
		$this->saveAgendaDB();
		$this->editAgenda();
	}
	
	/**
	 * Apenas salva no banco o dado.
	 */
	public function saveAgendaDB(){
		$user =& JFactory::getUser();
		if(!isset($user) || !JSession::checkToken('post'))	die('Restricted access');
		

		//JError::raiseNotice( 100, 'Notice' );
		//JError::raiseWarning( 100, 'Warning' );
		//JError::raiseError( 4711, 'A severe error occurred' );
		
		$id = JRequest::getInt('id', 0, 'POST');
		$titulo = JRequest::getString('titulo', '', 'POST');
		$tipo = JRequest::getString('tipo', '', 'POST');
		$descricao = JRequest::getString('descricao', '', 'POST');
		$metaDescricao = JRequest::getString('meta_descricao', '', 'POST');

		$idTema = JRequest::getInt('id_tema', null, 'POST');
		$idModelo = JRequest::getInt('id_modelo',  null, 'POST');
		$idLocacao = JRequest::getInt('id_locacao', null, 'POST');
		$idFotografo = JRequest::getInt('id_fotografo', null, 'POST');
		$publicar = JRequest::getString('publicar', 'N', 'POST');
		$data = JRequest::getString('data', null, 'POST');
		
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		
		
		if($id!=null && $id!=0){//UPDATE

				
			$query->update($db->quoteName('#__angelgirls_agenda'))
				->set(array(
					$db->quoteName('data_alterado') . ' = NOW() ' ,
					$db->quoteName('id_usuario_alterador') . ' = ' . $user->id,
					$db->quoteName('titulo') . ' = ' . ($titulo == null ? 'null' : $db->quote($titulo)),
					$db->quoteName('tipo') . ' = ' . ($tipo == null ? 'null' : $db->quote($tipo)),
					$db->quoteName('descricao') . ' = ' . ($descricao == null ? 'null' : $db->quote($descricao)),
					$db->quoteName('meta_descricao') . ' = ' . ($metaDescricao == null ? 'null' : $db->quote($metaDescricao)),
					$db->quoteName('id_tema') . ' = ' . ($idTema == null ? 'null': $idTema),
					$db->quoteName('id_modelo') . ' = ' . ($idModelo == null ? 'null' : $idModelo),
					$db->quoteName('id_locacao'). ' = ' . ($idLocacao == null ? 'null' : $idLocacao),
					$db->quoteName('id_fotografo') . ' = ' . ($idFotografo == null ? 'null' : $idFotografo),
					$db->quoteName('id_fotografo') . ' = ' . ($idFotografo == null ? 'null' : $idFotografo),
					$db->quoteName('data') . ' = ' . ($data == null ? 'null' : $db->quote($data))))
				->where(array($db->quoteName('id') . ' = '.$id));
				
			$db->setQuery($query);
				
			$db->execute();
		}
		else{
			$query->insert($db->quoteName('#__angelgirls_agenda'))
			->columns(array(
					$db->quoteName('status_dado'),
					$db->quoteName('data_criado'),
					$db->quoteName('id_usuario_criador'),
					$db->quoteName('data_alterado'),
					$db->quoteName('id_usuario_alterador'),
					$db->quoteName('titulo'),
					$db->quoteName('tipo'),
					$db->quoteName('descricao'),
					$db->quoteName('meta_descricao'),
					$db->quoteName('id_tema'),
					$db->quoteName('id_modelo'),
					$db->quoteName('id_locacao'),
					$db->quoteName('id_fotografo'),
					$db->quoteName('publicar'),
					$db->quoteName('data')))
			->values(implode(',', array(
					'\'NOVO\'', 
					'NOW()',
					$user->id,
					'NOW()',
					$user->id,
					($titulo == null ? 'null' : $db->quote($titulo)),
					($tipo == null ? 'null' : $db->quote($tipo)),
					($descricao == null ? 'null' : $db->quote($descricao)),
					($metaDescricao == null ? 'null' : $db->quote($metaDescricao)),
					($idTema == null ? 'null': $idTema),
					($idModelo == null ? 'null' : $idModelo),
					($idLocacao == null ? 'null' : $idLocacao),
					($idFotografo == null ? 'null' : $idFotografo),
					($publicar == null ? 'null' : $db->quote($publicar)),
					($data == null ? 'null' : $db->quote($data))
			)));
			
			$db->setQuery($query);
			
			$db->execute();
			
			JRequest::setVar('id',$db->insertid());
		}
		
		JFactory::getApplication()->enqueueMessage('Agenda salva com sucesso');
	}
	
	
	public function saveAngenda(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');
		
		$this->saveAgendaDB();
		$this->listAgenda();
	}

	
	public function listAgenda(){
		$user =& JFactory::getUser();
		if(!isset($user))	die('Restricted access');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select($db->quoteName(array('a.id','a.data','a.titulo','a.tipo','a.descricao','a.meta_descricao','a.audiencia_gostou','a.audiencia_ngostou','a.audiencia_view','a.id_tema',
					'a.id_modelo','a.id_locacao','a.id_fotografo','a.publicar','a.status_dado','a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado',
					'b.name','c.name'),
					array('id','data','titulo','tipo','descricao','meta_descricao','audiencia_gostou','audiencia_ngostou','audiencia_view','id_tema',
					'id_modelo','id_locacao','id_fotografo','publicar','status_dado','id_usuario_criador','id_usuario_alterador','data_criado','data_alterado',
					'criador','editor')))
		->from($db->quoteName('#__angelgirls_agenda','a'))
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
		->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
		->where($db->quoteName('status_dado') . ' <> \'REMOVED\' ')
		->order('data_alterado ASC');
		
		
		
		$db->setQuery($query);
 
		$results = $db->loadObjectList();
		

		
		JRequest::setVar('lista', $results);
		JRequest::setVar('view', 'agendas');
		JRequest::setVar('layout', 'default');
		parent::display();
	}
}
?>