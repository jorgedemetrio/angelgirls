<?php
/**
 * Perfils Table Class
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
 * Perfils Table Class
 *
 * @category  Table_Class
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 */
class JTablePerfils extends JTable
{
    /**
     * @var int Primary key
     */
    var $id = null;
    
    /**
     * @var int User Id
     */
    var $user_id = 0;

    /**
     * @var rich_text Descricao
     */
    var $descricao = '';

    /**
     * @var string Documento
     */
    var $documento = '';

    /**
     * @var string Foto Perfil
     */
    var $foto_perfil = '';

    /**
     * @var string Apelido
     */
    var $apelido = '';

    /**
     * @var string Tipo Perfil
     */
    var $tipo_perfil = '';

    /**
     * @var bool Published
     */
    var $published = 0;

    /**
     * @var string Status
     */
    var $status = '';

    /**
     * @var datetime Created On
     */
    var $created_on = null;

    /**
     * @var datetime Edited On
     */
    var $edited_on = null;

    /**
     * @var datetime Publicar
     */
    var $publicar = null;

    /**
     * @var datetime Despublicar
     */
    var $despublicar = null;

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
        parent::__construct('#__angelgirls_perfils', 'id', $db);
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
        $required_fields = array('user_id' => 'User Id', 'foto_perfil' => 'Foto Perfil', 'tipo_perfil' => 'Tipo Perfil', 'status' => 'Status', 'created_on' => 'Created On', 'edited_on' => 'Edited On', 'publicar' => 'Publicar', 'despublicar' => 'Despublicar', 'id_created_by' => 'Id Created By', 'id_edited_by' => 'Id Edited By');
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
