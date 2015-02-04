<?php
/**
 * Enderecos HTML Details Template
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
    <th><?php echo JText::_('Logradouro'); ?></th>
    <td><?php echo $this->item->logradouro; ?></td></tr>
<tr>
    <th><?php echo JText::_('Endereco'); ?></th>
    <td><?php echo $this->item->endereco; ?></td></tr>
<tr>
    <th><?php echo JText::_('Numero'); ?></th>
    <td><?php echo $this->item->numero; ?></td></tr>
<tr>
    <th><?php echo JText::_('Complemento'); ?></th>
    <td><?php echo $this->item->complemento; ?></td></tr>
<tr>
    <th><?php echo JText::_('Bairro'); ?></th>
    <td><?php echo $this->item->bairro; ?></td></tr>
<tr>
    <th><?php echo JText::_('Cidade'); ?></th>
    <td><?php echo $this->item->cidade; ?></td></tr>
<tr>
    <th><?php echo JText::_('Estado'); ?></th>
    <td><?php echo $this->item->estado; ?></td></tr>
<tr>
    <th><?php echo JText::_('Pais'); ?></th>
    <td><?php echo $this->item->pais; ?></td></tr>
<tr>
    <th><?php echo JText::_('Cep'); ?></th>
    <td><?php echo $this->item->cep; ?></td></tr>
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
    <p><?php echo JText::_('Enderecos not found'); ?>.</p>
<?php endif; ?>