<?php
/**
 * Fotos HTML List Template
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
<div id="fotos">
    <form action="index.php" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
        <thead>
            <tr>
                <th width="5"><?php echo JText::_('ID'); ?></th>
                <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
                  <th><?php echo JText::_('Title'); ?></th>
                  <th><?php echo JText::_('Descricao'); ?></th>
                  <th><?php echo JText::_('Descricao Google'); ?></th>
                  <th><?php echo JText::_('Apelido'); ?></th>
                  <th><?php echo JText::_('Autor'); ?></th>
                  <th><?php echo JText::_('Modelos'); ?></th>
                  <th><?php echo JText::_('Data Foto'); ?></th>
                  <th><?php echo JText::_('Views'); ?></th>
                  <th><?php echo JText::_('Total Gostei'); ?></th>
                  <th><?php echo JText::_('Total Ngostei'); ?></th>
                  <th><?php echo JText::_('Autor'); ?></th>
                  <th><?php echo JText::_('Created On'); ?></th>
                  <th><?php echo JText::_('Published'); ?></th>
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
                $link = JRoute::_('index.php?option=com_angelgirls&view=fotos&task=edit&cid[]='. $row->id);
        ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $checked; ?></td>
                       <td><?php echo "<a href='$link'>".$row->title."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->descricao."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->descricao_google."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->apelido."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->autor."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->modelos."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->data_foto."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->views."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->total_gostei."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->total_ngostei."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->autor_name."</a>"; ?></td>
                       <td><?php echo "<a href='$link'>".$row->created_on."</a>"; ?></td>
                       <td><?php echo JHTML::_('grid.published', $row, $i); ?></td>
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
    <input type="hidden" name="view" value="fotos" />
    <input type="hidden" name="controller" value="fotos" />
</form>
</div>
</td></tr></table>
