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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Agendas Model
 */
class AngelgirlsModelagendas extends JModelList{
	
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
		$row =& $this->getTable('Agendas', 'JTable');
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
		$row =& $this->getTable('Agendas', 'JTable');
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
		$row =& $this->getTable('Agendas', 'JTable');
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
		$this->_items = $this->_getList('SELECT * FROM `#__angelgirls_agendas`');
		return is_null($this->_items) ? false : true;
	}
}?>