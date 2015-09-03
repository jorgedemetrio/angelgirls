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
	
	public function addAgenda(){
		
		JRequest::setVar('view', 'agendas');
		JRequest::setVar('layout', 'cadastro');
		parent::display();
	}
	
	public function carregar(){

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select($db->quoteName(array('a.id','a.titulo','a.tipo','a.descricao','a.meta_descricao','a.audiencia_gostou','a.audiencia_ngostou','a.audiencia_view','a.id_tema',
					'a.id_modelo','a.id_locacao','a.id_fotografo','a.publicar','a.status_dado','a.id_usuario_criador','a.id_usuario_alterador','a.data_criado','a.data_alterado',
					'b.name','c.name'),
					array('id','titulo','tipo','descricao','meta_descricao','audiencia_gostou','audiencia_ngostou','audiencia_view','id_tema',
					'id_modelo','id_locacao','id_fotografo','publicar','status_dado','id_usuario_criador','id_usuario_alterador','data_criado','data_alterado',
					'criador','editor')))
		->from($db->quoteName('#__angelgirls_agenda','a'))
		->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.id_usuario_criador') . ' = ' . $db->quoteName('b.id') . ')')
		->join('INNER', $db->quoteName('#__users', 'c') . ' ON (' . $db->quoteName('a.id_usuario_alterador') . ' = ' . $db->quoteName('c.id') . ')')
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