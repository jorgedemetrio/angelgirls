<?php
/**
 * Fotos Model of the AngelGirls Component
 *
 * PHP versions 5
 *
 * @category  Model
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * AngelGirls Component Fotos Model
 *
 * @category Model
 * @package  AngelGirls
 * @author   Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @license  GNU General Public License
 * @link     http://www.alldreams.com.br
 * @since    1.0
 */
class AngelGirlsModelFotos extends JModelLegacy
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
     * Method to get data
     *
     * @return object Items data
     * @access public
     * @since  1.0
     */
    public function getItems()
    {
        if (empty($this->_items)) {
            // Load the items
            $this->_loadItems();
        }
        return $this->_items;
    }

    /**
     * Method to load data from a specific item
     *
     * @return object Item data
     * @access public
     * @since  1.0
     */
    public function getItem()
    {
        $cid = JRequest::getVar('cid');
        $id = (int)$cid[0];
        $row =& $this->getTable('Fotos', 'JTable');
        $row->load($id);
        return $row;
    }

    /**
     * Method to save an object
     *
     * @return bool
     * @access public
     * @since  1.0
     */
    public function save()
    {
        $row =& $this->getTable('Fotos', 'JTable');
        $data = JRequest::get('post');
		$data['descricao'] = JRequest::getVar('descricao', '', 'post', 'string', JREQUEST_ALLOWRAW);

        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check()) {
            $this->setError($row->getError());
            return false;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;
    }

    /**
     * Method to delete an object
     *
     * @return bool
     * @access public
     * @since  1.0
     */
    public function delete()
    {
        $row =& $this->getTable('Fotos', 'JTable');
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');

        foreach($cids as $cid) {
            if (!$row->delete($cid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
        }
        return true;
    }

    /**
     * Method to load data
     *
     * @return boolean
     * @access private
     * @since  1.0
     */
    private function _loadItems()
    {
        $this->_items = $this->_getList('SELECT * FROM `#__angelgirls_fotos`');
        return is_null($this->_items) ? false : true;
    }
}
