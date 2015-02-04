<?php
/**
 * Agendas Controller of the AngelGirls Component
 *
 * PHP versions 5
 *
 * @category  Controller
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * AngelGirls Component Agendas Controller
 *
 * @category Controller
 * @package  AngelGirls
 * @author   Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @license  GNU General Public License
 * @link     http://www.alldreams.com.br
 * @since    1.0
 */
class AngelGirlsControllerAgendas extends AngelGirlsController
{
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
        JRequest::setVar('view', 'Agendas');
        JRequest::setVar('hidemainmenu', 1);
        parent::display($cachable = false, $urlparams = array());
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
