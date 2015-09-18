<?php
defined('_JEXEC') or die('Restricted access'); 
$redes = JRequest::getVar('redes');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th><span class="hidden-tablet hidden-phone">Principal</span></th>
			<th><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th>Rede</th>
			<th>Contato</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($redes as $rede):?>
	<tr>
	<?php 	if($rede->principal=='S'):?>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-check"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-ban-circle"></span></td>
			<td class="padrao" style="text-transform: lowercase;" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($rede->rede_social));?></td>
			<td class="padrao" style="text-transform: lowercase;" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($rede->url_usuario));?></td>
	<?php 	else :?>
		<tr>
			<td title="Definir como rede social principal."  style="text-align: center;"><a href="JavaScript: FormRedeSocialActions.padrao(
										<?php echo( $rede->id);?>);"><span class="glyphicon glyphicon-unchecked"></span></a></td>
			<td title="Remover rede social."  style="text-align: center;"><a href="JavaScript: FormRedeSocialActions.remover(
										<?php echo( $rede->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
			<td><?php echo( strtolower($rede->rede_social));?></td>
			<td><?php echo( strtolower($rede->url_usuario));?></td>

	<?php 	endif;?>
	</tr>
	<?php endforeach;?>
							</tbody>
</table>