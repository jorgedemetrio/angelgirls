<?php
defined('_JEXEC') or die('Restricted access'); 
$videos = JRequest::getVar('videos');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th><span class="hidden-tablet hidden-phone">Ver</span></th>
			<th>Titulo</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($videos as $video):?>
	<tr>

		<tr>
			<td title="Remover v&iacute;deo."  style="text-align: center;"><a href="JavaScript: EditarSessao.removerVideo(
										<?php echo( $video->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
										
			<td title="Ver v&iacute;deo."  style="text-align: center;"><a href="JavaScript: EditarSessao.removerVideo(
										<?php echo( $video->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>										
										
			<td class="editavel" onclick="JavaScript: EditarSessao.editarVideo(
										<?php echo( $video->id);?>,
										'<?php echo( $video->titulo);?>','<?php echo( $video->tipo);?>','<?php echo( $video->meta_descricao);?>');"><?php echo( strtolower($email->titulo));?></td>


			<td class="editavel" onclick="JavaScript: EditarSessao.editarVideo(
										<?php echo( $video->id);?>,
										'<?php echo( $video->titulo);?>','<?php echo( $video->tipo);?>','<?php echo( $video->meta_descricao);?>');"><?php echo( strtolower($email->tipo));?></td>										
										
										
										
										
										
										
										
										
										
										
										
										
										


	</tr>
	<?php endforeach;?>
	</tbody>
</table>