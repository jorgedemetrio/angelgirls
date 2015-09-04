<?php
/*------------------------------------------------------------------------
# agendas.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.angelgirls.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Agendas Controller
 */
class AngelgirlsControlleragendas extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'agenda', $prefix = 'AngelgirlsModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}
	
	
	
	   /**
     * Constructor
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function __construct()
    {
        parent::__construct();
        $this->registerTask('add', 'edit');
		
        $this->registerTask('unpublish', 'publish');
    }

    /**
     * Method to edit an object
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function edit()
    {
        JRequest::setVar('view', 'agendas');
        JRequest::setVar('hidemainmenu', 1);
        parent::display($cachable = false, $urlparams = array());
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

    /**
     * Method to save an object
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function save()
    {
        $model = $this->getModel('Agendas');
        if ($model->save()) {
            $msg = JText::_('Object saved successfully!');
        } else {
            $msg = JText::_('Error: '.$model->getError());
        }
        $this->setRedirect(JRoute::_('index.php?option=com_angelgirls&view=Agendas&layout=list', false), $msg);
    }

    /**
     * Method to remove an object
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function remove()
    {
        $model = $this->getModel('Agendas');
        if(!$model->delete()) {
            $msg = JText::_('Error: couldn\'t delete one or more objects');
        } else {
            $msg = JText::_('Successfully deleted objects!');
        }
        $this->setRedirect(JRoute::_('index.php?option=com_angelgirls&view=Agendas&layout=list', false), $msg);
    }

    /**
     * Method to cancel an operation
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function cancel()
    {
        $msg = JText::_('Operation Aborted');
        $this->setRedirect(JRoute::_('index.php?option=com_angelgirls&view=Agendas&layout=list', false), $msg);
    }

    /**
     * Method to publish / unpublish an object
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function publish()
    {
        $publish = ($this->getTask() == 'publish' ? 1 : 0);
        $cid = JRequest::getVar('cid', array(0), 'post', 'array');
        JArrayHelper::toInteger($cid, array(0));
        if (count($cid) > 0) {
            $table =& $this->getModel('Agendas')->getTable('Agendas', 'JTable');
            $table->publish($cid, $publish);
        }
        $this->setRedirect('index.php?option=com_angelgirls&view=Agendas&layout=list');
    }
}
?>