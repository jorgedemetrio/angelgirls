<?php
$sessoes = JRequest::getVar('sessoes');
$perfil = JRequest::getVar('perfil');

if(isset($sessoes) && sizeof($sessoes)>0):
?>
<div class="table-responsive">
	<table class="table table-hover display" id='tabelaComSessoes' data-order='[[ 6, "desc" ]]' cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>Titulo</th>
				<th>Modelo Principal</th>
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
		<a href="<?php echo($url);?>"  title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
<?php 





	if(($perfil->id == $conteudo->id_fotografo_principal && $perfil->tipo == 'FOTOGRAFO' && $conteudo->status_fotografo_principal == 0)
		|| ($perfil->id == $conteudo->id_fotografo_secundario && $perfil->tipo =='FOTOGRAFO' && $conteudo->status_fotografo_secundario == 0)
		|| ($perfil->id == $conteudo->id_modelo_principal && $perfil->tipo =='MODELO' && $conteudo->status_modelo_principal == 0)
		|| ($perfil->id == $conteudo->id_modelo_secundaria && $perfil->tipo =='MODELO' && $conteudo->status_modelo_secundaria == 0)) :
?>
			<span class="glyphicon glyphicon-thumbs-down btnReprovar" data-id="<?php echo($conteudo->id);?>" aria-hidden="true"  title="Reprovar"></span>&nbsp;
			<span class="glyphicon glyphicon-thumbs-up btnAprovar" data-id="<?php echo($conteudo->id);?>" aria-hidden="true" title="Aprovar"></span>
<?php 	endif;?>
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
				<td class="editavel" style="vertical-align: middle;" data-order="<?php echo($conteudo->modelo1); ?>" data-search="<?php echo($conteudo->modelo1); ?>"><?php echo($conteudo->modelo1); ?> <img alt="<?php echo($conteudo->modelo1); ?>" src="<?php echo($urlImgModelo);?>" class="img-responsive" style="width: 30px; height: 30px; float: left; margin: 2px;"/></td>
				<td class="editavel" style="vertical-align: middle;" data-order="<?php echo($conteudo->fotografo1); ?>" data-search="<?php echo($conteudo->fotografo1); ?>"><?php echo($conteudo->fotografo1); ?> <img alt="<?php echo($conteudo->fotografo1); ?>" src="<?php echo($urlImgFotografo);?>" class="img-responsive" style="width: 30px; height: 30px; float: left; margin: 2px;"/></td>
				<td class="editavel" style="vertical-align: middle;" data-order="<?php echo(JDate::getInstance($conteudo->executada)->format('Ymd')); ?>" data-search="<?php echo(JDate::getInstance($conteudo->executada)->format('Ymd')); ?>"><?php echo(JDate::getInstance($conteudo->executada)->format('d/m/Y')); ?></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo(isset($conteudo->publicar) && strlen(trim($conteudo->publicar))>5 ?JDate::getInstance($conteudo->publicar)->format('d/m/Y'):'N/D'); ?></td>
				<td class="editavel" style="vertical-align: middle;"><?php echo(strtolower( $conteudo->status_dado)); ?></td>
			</tr>
<?php
	endforeach;?>
		</tbody>
	</table>
</div>	
<?php 
endif;
?>