<?php
/**
 * Conteudos_associados HTML Details Template
 *
 * PHP versions 5
 *
 * @category  Template
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<?php if($this->item->id > 0) : ?>
<table border="0" cellspacing="1" cellpadding="1">
<tr>
    <th><?php echo JText::_('Titulo'); ?></th>
    <td><?php echo $this->item->titulo; ?></td></tr>
<tr>
    <th><?php echo JText::_('Origem Tipo'); ?></th>
    <td><?php echo $this->item->origem_tipo; ?></td></tr>
<tr>
    <th><?php echo JText::_('Origem Id'); ?></th>
    <td><?php echo $this->item->origem_id; ?></td></tr>
<tr>
    <th><?php echo JText::_('Origem Url'); ?></th>
    <td><?php echo $this->item->origem_url; ?></td></tr>
<tr>
    <th><?php echo JText::_('Destino Tipo'); ?></th>
    <td><?php echo $this->item->destino_tipo; ?></td></tr>
<tr>
    <th><?php echo JText::_('Destino Id'); ?></th>
    <td><?php echo $this->item->destino_id; ?></td></tr>
<tr>
    <th><?php echo JText::_('Destino Url'); ?></th>
    <td><?php echo $this->item->destino_url; ?></td></tr>
<tr>
    <th><?php echo JText::_('Published'); ?></th>
    <td><?php echo $this->item->published; ?></td></tr>
<tr>
    <th><?php echo JText::_('Created On'); ?></th>
    <td><?php echo $this->item->created_on; ?></td></tr>
<tr>
    <th><?php echo JText::_('Edited On'); ?></th>
    <td><?php echo $this->item->edited_on; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Created By'); ?></th>
    <td><?php echo $this->item->id_created_by; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Edited By'); ?></th>
    <td><?php echo $this->item->id_edited_by; ?></td></tr>

</table>
<?php else : ?>
    <p><?php echo JText::_('Conteudos Associados not found'); ?>.</p>
<?php endif; ?>