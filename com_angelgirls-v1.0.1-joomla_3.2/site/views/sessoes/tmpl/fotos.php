<?php 
$results = JRequest::getVar( 'fotos');
$conteudo = JRequest::getVar('sessao');
$user = JFactory::getUser();

foreach($results as $foto){
	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo)));
	$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->token.':cube');?>
<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade" id="foto<?php echo($foto->id);?>"
					onmouseout="JavaScript: if(jQuery('#ftTools<?php echo($foto->id);?>').hasClass('in')){jQuery('#ftTools<?php echo($foto->id);?>').removeClass('in');}">
	<a href="<?php echo($url);?>" onmouseover="JavaScript: if(!jQuery('#ftTools<?php echo($foto->id);?>').hasClass('in')){jQuery('#ftTools<?php echo($foto->id);?>').addClass('in');}"
								 ><img src="<?php echo($urlFoto);?>" /></a>
<?php if($user->id == $conteudo->id_usuario_criador && ( $conteudo->status_dado != StatusDado::ANALIZE && $conteudo->status_dado != StatusDado::PUBLICADO )): ?>
<div class="fade" id="ftTools<?php echo($foto->id);?>" 
onmouseover="JavaScript: if(!jQuery('#ftTools<?php echo($foto->id);?>').hasClass('in')){jQuery('#ftTools<?php echo($foto->id);?>').addClass('in');}"
onmouseout="JavaScript: if(jQuery('#ftTools<?php echo($foto->id);?>').hasClass('in')){jQuery('#ftTools<?php echo($foto->id);?>').removeClass('in');}" 
style="position: absolute; background: rgba(0,0,0,0.5); height: 30px; width: 100%; bottom: 0px;">

<span style=" float: right;text-transform: capitalize; color: #fff; width: 100px; overflow: inherit;" id="labelFoto<?php echo($foto->id);?>"><?php echo(str_replace(" ","-",$foto->titulo));?></span>


	<div class="btn-toolbar" pull-right" role="toolbar" style=" width: 100px;display: inline-block;margin-top: 0px;">
		<div class="btn-group" role="group">

<a href="JavaScript: EditarSessao.EditarDadosFoto echo($foto->id);?>);" class="btn btn-foto" style="padding: 5px 0px 0px 5px;" title="Editar titulo e descri&ccedil;&atilde;o">
		<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>
<a href="JavaScript: EditarSessao.RemoverFoto(<?php echo($foto->id);?>);" class="btn  btn-foto" style="padding: 5px 0px 0px 5px;"  title="Apagar foto">
		<span class="glyphicon glyphicon-remove"></span>&nbsp;</a>
<a href="JavaScript: EditarSessao.PossuiNudes(<?php echo($foto->id);?>,this);" class="btn  btn-foto" style="padding: 5px 0px 0px 5px;" id="PossuiNudes<?php echo($foto->id);?>" data-valor="<?php echo($foto->possui_nudes);?>">
<?php if($foto->possui_nudes=='S') :?>
		<span class="glyphicon glyphicon-heart" title="Possui nudes."></span>&nbsp;
<?php else: ?>
		<span class="glyphicon glyphicon-heart-empty" title="N&atilde;o possui nudes."></span>&nbsp;
<?php endif;?>
	</a>
</div></div>		

</div>
<?php endif;?>
</div>
<?php
}
$contador = sizeof($results);
if($contador>0):
	echo("<script>lidos+=$contador;\n</script>");
endif;