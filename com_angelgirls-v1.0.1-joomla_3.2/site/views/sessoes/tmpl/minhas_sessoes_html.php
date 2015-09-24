<?php
$sessoes = JRequest::getVar('sessoes');
if(isset($sessoes) && sizeof($sessoes)>0):?>
<div class="table-responsive">
	<table class="table table-hover" >
		<thead>
			<tr>
				<th colspan="2">Tiulo</th>
				<th colspan="2">Modelo Principal</th>
				<th colspan="2">Fotografo Principal</th>
				<th>Data</th>
				<th>status</th>
			</tr>
		</thead>
			<tbody>
<?php 	foreach($sessoes as $conteudo): ?>
	<?php
	$url = '';
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->token.':ico');
	if($conteudo->status_dado==StatusDado::ANALIZE || $conteudo->status_dado==StatusDado::ATIVO  || $conteudo->status_dado==StatusDado::PUBLICADO):
		$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->alias)));
	else:
		$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarEditarSessao&id='.$conteudo->id);
	endif; 
	
	$urlImgModelo = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id_modelo_principal.':ico');
	$urlImgFotografo = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id_fotografo_principal.':ico');
	?>
			<tr>
				<td><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->nome); ?>" src="<?php echo($urlImg);?>" class="img-responsive" style="width: 50px"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->nome); ?></a></td>
				<td><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->modelo1); ?>" src="<?php echo($urlImgModelo);?>" class="img-responsive" style="width: 50px"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->modelo1); ?></a></td>
				<td><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->fotografo1); ?>" src="<?php echo($urlImgFotografo);?>" class="img-responsive" style="width: 50px"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->fotografo1); ?></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo(JDate::getInstance($conteudo->executada)->format('d/m/Y')); ?></a></td>
				<td class="editavel">
<?php switch ($conteudo->status_dado) :?>
<?php case StatusDado::ANALIZE : ?>
	<span class="glyphicon glyphicon-eye-open"></span>
<?php
		break; 
	case $conteudo->status_dado==StatusDado::ATIVO : ?>
	<span class="glyphicon glyphicon-eye-open"></span>
<?php
		break; 
	case  $conteudo->status_dado==StatusDado::PUBLICADO : ?>
	<span class="glyphicon glyphicon-eye-open"></span>
<?php
		break; 
	default:  ?>
	<span class="glyphicon glyphicon-pencil"></span>
<?php endswitch;?>
				</td>
			</tr>
		
<?php
	endforeach;?>
		</tbody>
	</table>
</div>	
<?php 
endif;
?>