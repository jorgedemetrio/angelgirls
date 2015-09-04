<?php
/**
 * Sessoes Controller of the AngelGirls Component
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
 * AngelGirls Component Sessoes Controller
 *
 * @category Controller
 * @package  AngelGirls
 * @author   Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @license  GNU General Public License
 * @link     http://www.alldreams.com.br
 * @since    1.0
 */
class AngelGirlsControllerSessoes extends AngelGirlsController
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
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('Sessoes');
        if ($model->save()) {
            $msg = JText::_('Object created successfully!');
            $url = 'index.php?option=com_angelgirls&view=Sessoes&layout=list';
        } else {
            $msg = JText::_('Error while created object: '.$model->getError());
            $url = 'index.php?option=com_angelgirls&view=Sessoes&layout=new';
        }
        $this->setRedirect(JRoute::_($url), $msg);
    }
}
