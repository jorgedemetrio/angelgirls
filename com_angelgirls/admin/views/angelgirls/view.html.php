<?php
/**
 * Default HTML View Class
 *
 * PHP versions 5
 *
 * @category  View
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the AngelGirls component
 *
 * @category View
 * @package  AngelGirls
 * @author   Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @license  GNU General Public License
 * @link     http://www.alldreams.com.br
 * @since    1.0
 */
class AngelGirlsViewAngelGirls extends JViewLegacy
{
    /**
     * Display the view
     *
     * @param string $tpl Template
     *
     * @return void
     * @access public
     * @since  1.0
     */
    function display($tpl = null)
    {
        // Set toolbar items
        JToolBarHelper::title(JText::_('AngelGirls'), 'generic.png');

        parent::display($tpl);
    }
}
