<?php 
$results = JRequest::getVar( 'fotos');
$conteudo = JRequest::getVar('sessao');
$user = JFactory::getUser();

foreach($results as $foto){
	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo)));
	$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->token.':cube');?>
<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade" onmouseout="JavaScript: if(jQuery('#ft<?php echo($foto->id);?>').hasClass('in')){jQuery('#ft<?php echo($foto->id);?>').removeClass('in');}">
	<a href="<?php echo($url);?>" onmouseover="JavaScript: if(!jQuery('#ft<?php echo($foto->id);?>').hasClass('in')){jQuery('#ft<?php echo($foto->id);?>').addClass('in');}"
								 ><img src="<?php echo($urlFoto);?>" /></a>
<?php if($user->id == $conteudo->id_usuario_criador && ( $conteudo->status_dado != StatusDado::ANALIZE && $conteudo->status_dado != StatusDado::PUBLICADO )): ?>
<div class="fade" id="ft<?php echo($foto->id);?>" 
onmouseover="JavaScript: if(!jQuery('#ft<?php echo($foto->id);?>').hasClass('in')){jQuery('#ft<?php echo($foto->id);?>').addClass('in');}"
onmouseout="JavaScript: if(jQuery('#ft<?php echo($foto->id);?>').hasClass('in')){jQuery('#ft<?php echo($foto->id);?>').removeClass('in');}" 
style="position: absolute; background: rgba(0,0,0,0.5); height: 40px; width: 100%; bottom: 0px;">

<a href="" class="btn" 
	style="height: 30px; width: 30px; margin: 5px; vertical-align: middle; text-align: center; padding: 5px 0px 0px 5px;" title="Editar titulo e descri&ccedil;&atilde;o">
		<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>
<a href="" 
	class="btn" style="height: 30px; width: 30px; margin: 5px; vertical-align: middle; text-align: center; padding: 5px 0px 0px 5px;" title="Apagar foto">
		<span class="glyphicon glyphicon-remove"></span>&nbsp;</a>
<span style="text-transform: capitalize; color: #fff; width: 100px; overflow: inherit;"><?php echo(str_replace(" ","-",$foto->titulo));?></span>
</div>
<?php endif;?>
</div>
<?php
}
$contador = sizeof($results);
if($contador>0):
	echo("<script>lidos+=$contador;\n</script>");
endif;