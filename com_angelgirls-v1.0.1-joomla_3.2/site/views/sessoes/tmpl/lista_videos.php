<?php
defined('_JEXEC') or die('Restricted access'); 
$videos = JRequest::getVar('videos');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th style="width: 18px;"><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th style="width: 18px;"><span class="hidden-tablet hidden-phone">Ver</span></th>
			<th>Titulo</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($videos as $video):?>
	<tr>

		<tr>
			<td title="Remover v&iacute;deo."  style="width: 18px;text-align: center; vertical-align: middle;"><a href="JavaScript: EditarSessao.RemoverVideo(
										<?php echo( $video->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
										
		
			<td><video width="200" height="100" controls><source src="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadVideo&id='.$video->token)); ?>" type="video/mp4"></video></td>								
										
			<td class="editavel" onclick="JavaScript: EditarSessao.EditarVideo(
										<?php echo( $video->id);?>,
										'<?php echo( $video->titulo);?>',
										'<?php echo( $video->tipo);?>',
										'<?php echo( $video->meta_descricao);?>',
										'<?php echo( $video->descricao);?>');"><?php echo( strtolower($video->titulo));?></td>


			<td class="editavel" onclick="JavaScript: EditarSessao.EditarVideo(
										<?php echo( $video->id);?>,
										'<?php echo( $video->titulo);?>',
										'<?php echo( $video->tipo);?>',
										'<?php echo( $video->meta_descricao);?>',
										'<?php echo( $video->descricao);?>');"><?php echo( strtolower($video->tipo));?></td>	

	</tr>
	<?php endforeach;?>
	</tbody>
</table>
<script>EditarSessao.VideosPublicados = <?php echo(sizeof($videos)); ?>;</script>