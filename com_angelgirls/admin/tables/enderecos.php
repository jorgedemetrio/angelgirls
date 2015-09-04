<?php
/**
 * Enderecos Table Class
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
 * Enderecos Table Class
 *
 * @category  Table_Class
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @version   1.0.0
 */
class JTableEnderecos extends JTable
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
     * @var string Logradouro
     */
    var $logradouro = '';

    /**
     * @var string Endereco
     */
    var $endereco = '';

    /**
     * @var string Numero
     */
    var $numero = '';

    /**
     * @var string Complemento
     */
    var $complemento = '';

    /**
     * @var string Bairro
     */
    var $bairro = '';

    /**
     * @var string Cidade
     */
    var $cidade = '';

    /**
     * @var string Estado
     */
    var $estado = '';

    /**
     * @var string Pais
     */
    var $pais = '';

    /**
     * @var string Cep
     */
    var $cep = '';

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
        parent::__construct('#__angelgirls_enderecos', 'id', $db);
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
        $required_fields = array('user_id' => 'User Id', 'logradouro' => 'Logradouro', 'endereco' => 'Endereco', 'numero' => 'Numero', 'complemento' => 'Complemento', 'bairro' => 'Bairro', 'cidade' => 'Cidade', 'estado' => 'Estado', 'pais' => 'Pais', 'cep' => 'Cep', 'created_on' => 'Created On', 'edited_on' => 'Edited On', 'id_created_by' => 'Id Created By', 'id_edited_by' => 'Id Edited By');
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
