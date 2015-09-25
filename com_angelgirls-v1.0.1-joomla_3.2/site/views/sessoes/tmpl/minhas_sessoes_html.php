<?php
$sessoes = JRequest::getVar('sessoes');
if(isset($sessoes) && sizeof($sessoes)>0):?>
<div class="table-responsive">
	<table class="table table-hover display" id='tabelaComSessoes' cellspacing="0" width="100%">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th>Titulo</th>
				<th></th>
				<th>Modelo Principal</th>
				<th></th>
				<th>Fotografo Principal</th>
				<th>Data</th>
				
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
			<tr class="editavel" onclick="JavaScript: window.location='<?php echo($url);?>';">
				<td class="editavel"><a href="<?php echo($url);?>">
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
<?php endswitch;?></a>
				</td>
				<td style="width: 30px"><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->nome); ?>" src="<?php echo($urlImg);?>" class="img-responsive" style="width: 30px; height: 30px;"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->nome); ?></a></td>
				<td style="width: 30px"><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->modelo1); ?>" src="<?php echo($urlImgModelo);?>" class="img-responsive" style="width: 30px; height: 30px;"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->modelo1); ?></a></td>
				<td style="width: 30px"><a href="<?php echo($url);?>"><img alt="<?php echo($conteudo->fotografo1); ?>" src="<?php echo($urlImgFotografo);?>" class="img-responsive" style="width: 30px; height: 30px;"/></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo($conteudo->fotografo1); ?></a></td>
				<td class="editavel"><a href="<?php echo($url);?>"><?php echo(JDate::getInstance($conteudo->executada)->format('d/m/Y')); ?></a></td>

			</tr>
		
<?php
	endforeach;?>
		</tbody>
	</table>
</div>	
<?php 
endif;
?>