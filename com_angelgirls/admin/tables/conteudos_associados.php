<?php
/**
 * Conteudos_associados Table Class
 *
 * PHP versions 5
 *
 * @category  Table_Class
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die('Restricted access');

/**
 * Conteudos_associados Table Class
 *
 * @category  Table_Class
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 */
class JTableConteudos_associados extends JTable
{
    /**
     * @var int Primary key
     */
    var $id = null;
    
    /**
     * @var string Titulo
     */
    var $titulo = '';

    /**
     * @var string Origem Tipo
     */
    var $origem_tipo = '';

    /**
     * @var int Origem Id
     */
    var $origem_id = 0;

    /**
     * @var string Origem Url
     */
    var $origem_url = '';

    /**
     * @var string Destino Tipo
     */
    var $destino_tipo = '';

    /**
     * @var int Destino Id
     */
    var $destino_id = 0;

    /**
     * @var string Destino Url
     */
    var $destino_url = '';

    /**
     * @var bool Published
     */
    var $published = 0;

    /**
     * @var datetime Created On
     */
    var $created_on = null;

    /**
     * @var datetime Edited On
     */
    var $edited_on = null;

    /**
     * @var int Id Created By
     */
    var $id_created_by = 0;

    /**
     * @var int Id Edited By
     */
    var $id_edited_by = 0;

    /**
     * Constructor
     *
     * @param object &$db A database connector object
     *
     * @return void
     * @access public
     * @since  1.0
     */
    public function __construct(&$db)
    {
        parent::__construct('#__angelgirls_conteudos_associados', 'id', $db);
    }

    /**
     * Overloaded check function
     *
     * @return boolean
     * @access public
     * @since  1.0
     * @see    JTable::check
     */
    public function check()
    {
        // check required fields
        $required_fields = array('titulo' => 'Titulo', 'created_on' => 'Created On', 'edited_on' => 'Edited On', 'id_created_by' => 'Id Created By', 'id_edited_by' => 'Id Edited By');
        foreach($required_fields as $field => $description) {
            if(!$this->get($field)) {
                $this->setError(JText::_($description.' is required.'));
                return false;
            }
        }

        return true;
    }
}
?>
