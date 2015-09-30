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
				<th>Publica&ccedil;&atilde;o</th>
				<th>Status</th>
				
			</tr>
		</thead>
			<tbody>
<?php 	foreach($sessoes as $conteudo): ?>
	<?php
	$url = '';
	$urlVer = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->alias)));;
	$urlEditar = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarEditarSessao&id='.$conteudo->id);
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->token.':ico');
	if($conteudo->status_dado==StatusDado::ANALIZE || $conteudo->status_dado==StatusDado::ATIVO  || $conteudo->status_dado==StatusDado::PUBLICADO):
		$url = $urlVer;
	else:
		$url = $urlEditar;
	endif; 
	
	$urlImgModelo = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id_modelo_principal.':ico');
	$urlImgFotografo = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id_fotografo_principal.':ico');
	?>
			<tr class="editavel">
<td class="editavel" style="vertical-align: middle; text-align: center; width: 65px;">
<?php switch ($conteudo->status_dado) :?>
<?php case StatusDado::ANALIZE : ?>
		<a href="<?php echo($url);?>"  title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
<?php
		break; 
	case $conteudo->status_dado==StatusDado::ATIVO : ?>
		<a href="<?php echo($url);?>"  title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
<?php
		break; 
	case  $conteudo->status_dado==StatusDado::PUBLICADO : ?>
		<a href="<?php echo($url);?>"  title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
<?php
		break; 
	case  $conteudo->status_dado==StatusDado::NOVO : ?>
		<a href="<?php echo($urlVer);?>"  title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
		<a href="<?php echo($url);?>" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
		<a href="<?php  echo('index.php?option=com_angelgirls&view=sessoes&task=removerSessao&id='.$conteudo->id);?>"  title="Remover">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</a>
		
<?php
		break; 
	default:  ?>
				<a href="<?php echo($url);?>"   title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
<?php endswitch;?>




				</td>
				<td style="width: 30px"><img alt="<?php echo($conteudo->nome); ?>" src="<?php echo($urlImg);?>" class="img-responsive" style="width: 30px; height: 30px;"/></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo($conteudo->nome); ?></td>
				<td style="width: 30px" style="vertical-align: middle;"><img alt="<?php echo($conteudo->modelo1); ?>" src="<?php echo($urlImgModelo);?>" class="img-responsive" style="width: 30px; height: 30px;"/></td>
				<td class="editavel"><?php echo($conteudo->modelo1); ?></td>
				<td style="width: 30px" style="vertical-align: middle;"><img alt="<?php echo($conteudo->fotografo1); ?>" src="<?php echo($urlImgFotografo);?>" class="img-responsive" style="width: 30px; height: 30px;"/></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo($conteudo->fotografo1); ?></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo(JDate::getInstance($conteudo->executada)->format('d/m/Y')); ?></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo(isset($conteudo->publicar) && strlen(trim($conteudo->publicar))>5 ?JDate::getInstance($conteudo->publicar)->format('d/m/Y'):'N/D'); ?></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo($conteudo->status_dado); ?></td>
			</tr>
		
<?php
	endforeach;?>
		</tbody>
	</table>
</div>	
<?php 
endif;
?>