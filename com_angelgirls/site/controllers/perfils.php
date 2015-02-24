<?php
/**
 * Perfils Controller of the AngelGirls Component
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
 * AngelGirls Component Perfils Controller
 *
 * @category Controller
 * @package  AngelGirls
 * @author   Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @license  GNU General Public License
 * @link     http://www.alldreams.com.br
 * @since    1.0
 */
class AngelGirlsControllerPerfils extends AngelGirlsController
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
        JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_users/models/');
        $model = $this->getModel('Perfils');
        $modelEmail = $this->getModel('Emails');
        $modelUser = $this->getModel('Users');
        
        /**
            INT
			INTEGER
			FLOAT
			DOUBLE
			BOOL
			BOOLEAN
			WORD
			ALNUM
			CMD
			BASE64
			STRING
			ARRAY
			PATH
			USERNAME
         */
        // Campo Obrigatório para quem participa de concurso
        $cpf = JRequest::getVar('cpf', '', 'post','string');
        
        
        
        if ($model->save() && $modelEmail->save()) {
            $msg = JText::_('Object created successfully!');
            $url = 'index.php?option=com_angelgirls&view=Emails&layout=list';
            
            
            //$user = JFactory::getUser();
            /* mysql_escape_string(
            printf
            $db = JFactory::getDbo();
 			$query = $db->getQuery(true);
            $query->select($db->quoteName(array('user_id', 'profile_key', 'profile_value', 'ordering')));
            $query->from($db->quoteName('#__user_profiles'));
            $query->where($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'custom.%\''));
            $query->order('ordering ASC');
            $db->setQuery($query);
            $results = $db->loadObjectList();
            
            
            $db->nameQuote('field_name')
            $query="SELECT username FROM users WHERE name='me'"; 
 			$db->setQuery($query); 
 			$row = $db->loadRow();
 			$result = $db->loadResult(); 
 			$row = $db->loadObject(); 
 			$rows = $db->loadObjectList(); 
 			
            */
            
        } else {
            $msg = JText::_('Error while created object: '.$model->getError());
            $url = 'index.php?option=com_angelgirls&view=Perfils&layout=new';
        }
        $this->setRedirect(JRoute::_($url), $msg);
    }
    
    public function validarExite(){
    	$db = JFactory::getDbo();
    	$user = JFactory::getUser();
    	$documento = JRequest::getVar('documento', null, 'post','string');
    	$email = JRequest::getVar('email', null, 'post','string');
    	
    	if(null!=$user){
	    	$db->setQuery(printf("SELECT * FROM `#__angelgirls_perfils` WHERE `published` = 1 AND `documento` = '%s'  AND  user_id = %d ", $documento, $user->id));
		   	$retorno = $db->loadObjectList();
		   	if(isset($retorno) && sizeof($retorno)>0){
		   		JResponse::setBody("false");
		   		return;
		   	}
		   	
		   	$db->setQuery(printf("SELECT * FROM `#__angelgirls_emails` WHERE `published` = 1 AND `emails` = '%s' AND  user_id = %d ", $email, $user->id));
		   	$retorno = $db->loadObjectList();
		   	if(isset($retorno) && sizeof($retorno)>0){
		   		JResponse::setBody("false");
		   		return;
		   	}
    	}
    	else{
    		$db->setQuery(printf("SELECT * FROM `#__angelgirls_perfils` WHERE `published` = 1 AND `documento` = '%s' ", $documento));
    		$retorno = $db->loadObjectList();
    		if(isset($retorno) && sizeof($retorno)>0){
    			JResponse::setBody("false");
    			return;
    		}
    		
    		$db->setQuery(printf("SELECT * FROM `#__angelgirls_emails` WHERE `published` = 1 AND `emails` = '%s' ", $email));
    		$retorno = $db->loadObjectList();
    		if(isset($retorno) && sizeof($retorno)>0){
    			JResponse::setBody("false");
    			return;
    		}
    		
    	}
	   	
	   	JResponse::setBody("true");
        return;
    }
    
    
    
    
    function pricipalEmail(){
    	$db = JFactory::getDbo();
    	$user = JFactory::getUser();
		$idEmail = JRequest::get('id',null,'GET','int');
    		
    	$db->setQuery(printf("SELECT `emails` FROM `#__angelgirls_emails` WHERE `published` = 1 AND `id` = %d ", $idEmail));
    	$retorno = $db->loadObject();
    	if(isset($retorno)){
	    	$db->setQuery(printf("UPDATE `#__users` SET `email` = '%s' WHERE id = %d ", $retorno->emails, $user->id));
	    	$db->update();
    	}
    	
    }
    
    function saveEmail(){
    
    }
    
    function saveEndereco(){
    
    }
    
    function removerEndereco(){
    
    }
    
    function saveTelefone(){
    
    }
    
    function removerEmail(){
    
    }

    
    private function _validaCPF($cpf = null) {
    
    	// Verifica se um número foi informado
    	if(empty($cpf)) {
    		return false;
    	}
    
    	// Elimina possivel mascara
    	$cpf = ereg_replace('[^0-9]', '', $cpf);
    	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
    	 
    	// Verifica se o numero de digitos informados é igual a 11
    	if (strlen($cpf) != 11) {
    		return false;
    	}
    	// Verifica se nenhuma das sequências invalidas abaixo
    	// foi digitada. Caso afirmativo, retorna falso
    	else if ($cpf == '00000000000' ||
    			$cpf == '11111111111' ||
    			$cpf == '22222222222' ||
    			$cpf == '33333333333' ||
    			$cpf == '44444444444' ||
    			$cpf == '55555555555' ||
    			$cpf == '66666666666' ||
    			$cpf == '77777777777' ||
    			$cpf == '88888888888' ||
    			$cpf == '99999999999') {
    				return false;
    				// Calcula os digitos verificadores para verificar se o
    				// CPF é válido
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
    		return true;
    	}
    }
    
}
