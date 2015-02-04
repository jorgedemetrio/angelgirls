<?php
/**
 * Enderecos HTML List Template
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
jimport('joomla.filter.filteroutput');
?>

<table class="adminform"><tr><td>
<div id="enderecos">
    <form action="index.php" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
        <thead>
            <tr>
                <th width="5"><?php echo JText::_('ID'); ?></th>
                <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
                  <th><?php echo JText::_('User Id'); ?></th>
                  <th><?php echo JText::_('Logradouro'); ?></th>
                  <th><?php echo JText::_('Endereco'); ?></th>
                  <th><?php echo JText::_('Numero'); ?></th>
                  <th><?php echo JText::_('Complemento'); ?></th>
                  <th><?php echo JText::_('Bairro'); ?></th>
                  <th><?php echo JText::_('Cidade'); ?></th>
                  <th><?php echo JText::_('Estado'); ?></th>
                  <th><?php echo JText::_('Pais'); ?></th>
                  <th><?php echo JText::_('Cep'); ?></th>
                  <th><?php echo JText::_('Created On'); ?></th>
                  <th><?php echo JText::_('Edited On'); ?></th>
                  <th><?php echo JText::_('Id Created By'); ?></th>
                  <th><?php echo JText::_('Id Edited By'); ?></th>

            </tr>
        </thead>
        <?php
            $k = 0;
            $i = 0;
            foreach($this->items as $row)
            {
                JFilterOutput::objectHTMLSafe($row);
                $checked = JHTML::_('grid.id', $i, $row->id);
                $link = JRoute::_('index.php?option=com_angelgirls&view=enderecos&task=edit&cid[]='. $row->id);
        ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $checked; ?></td>
                       <td><?php echo "<a href='$link'>".$row->user_id."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->logradouro."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->endereco."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->numero."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->complemento."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->bairro."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->cidade."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->estado."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->pais."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->cep."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->created_on."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->edited_on."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->id_created_by."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->id_edited_by."</a>"; ?></td>

                </tr>
        <?php
                $k = 1 - $k;
                $i = $i + 1;
            }
        ?>
        </table>
    </div>
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="view" value="enderecos" />
    <input type="hidden" name="controller" value="enderecos" />
</form>
</div>
</td></tr></table>
