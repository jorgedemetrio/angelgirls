<?php
/**
 * Perfils HTML List Template
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
<div id="perfils">
    <form action="index.php" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
        <thead>
            <tr>
                <th width="5"><?php echo JText::_('ID'); ?></th>
                <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
                  <th><?php echo JText::_('User Id'); ?></th>
                  <th><?php echo JText::_('Descricao'); ?></th>
                  <th><?php echo JText::_('Documento'); ?></th>
                  <th><?php echo JText::_('Foto Perfil'); ?></th>
                  <th><?php echo JText::_('Apelido'); ?></th>
                  <th><?php echo JText::_('Tipo Perfil'); ?></th>
                  <th><?php echo JText::_('Published'); ?></th>
                  <th><?php echo JText::_('Status'); ?></th>
                  <th><?php echo JText::_('Created On'); ?></th>
                  <th><?php echo JText::_('Edited On'); ?></th>
                  <th><?php echo JText::_('Publicar'); ?></th>
                  <th><?php echo JText::_('Despublicar'); ?></th>
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
                $link = JRoute::_('index.php?option=com_angelgirls&view=perfils&task=edit&cid[]='. $row->id);
        ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $checked; ?></td>
                       <td><?php echo "<a href='$link'>".$row->user_id."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->descricao."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->documento."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->foto_perfil."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->apelido."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->tipo_perfil."</a>"; ?></td>
                       <td><?php echo JHTML::_('grid.published', $row, $i); ?></td>
                       <td><?php echo "<a href='$link'>".$row->status."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->created_on."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->edited_on."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->publicar."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->despublicar."</a>"; ?></td>
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
    <input type="hidden" name="view" value="perfils" />
    <input type="hidden" name="controller" value="perfils" />
</form>
</div>
</td></tr></table>
