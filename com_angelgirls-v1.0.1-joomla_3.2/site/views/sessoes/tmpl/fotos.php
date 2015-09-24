<?php 
$results = JRequest::getVar( 'fotos');

foreach($results as $foto){
	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo)));
	$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->token.':thumb');?>
<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
	<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" /></a>
</div>
<?php
}
$contador = sizeof($results);
if($contador>0):
	echo("<script>lidos+=$contador\n</script>");
endif;
