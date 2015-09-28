<?php require_once 'ligthbox/header.php' ;

$foto = JRequest::getVar('foto', null);
		
$id = JRequest::getVar('id');
$titulo = JRequest::getVar('titulo', $foto->titulo, 'POST');
$metaDescricao = JRequest::getVar('meta_descricao', $foto->meta_descricao, 'POST');
$descricao = JRequest::getVar('descricao', $foto->descricao, 'POST');
$aplicarTodos = JRequest::getVar('aplicar_todos', 'N', 'POST');
$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->token.':ico');
?>
<h2>Edi&ccedil;&atilde;o de dados da foto.</h2>
<div class="row">
	<div class="well col col-xs-12  col-sm-12 col-md-12 col-lg-12">Quanto mais detalhado melhor, tente colocar na descri&ccedil;&atilde;o a maior quantidade de informa&ccedil;&otilde;es, isso ajudar&aacute; as suas fotos a serem localizadas. E lembrando que &eacute; interessante que cada foto tenha suas partiularidades nas descri&ccedil;&otilde;es para ajudar os mecanismos de buscas a entender que s&atilde;o imagens diferentes. </div>
</div>
<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarAlteracaoFoto')); ?>" onsubmit="JavaScript: return confirmarEditarTodosOsDados(this);" method="post" name="dadosFormEditarFoto" id="dadosFormEditarFoto" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<input type="hidden" name="id"  id="id" value="<?php echo($id)?>"/>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="titulo"><?php echo JText::_('Titulo'); ?> *<small>Obrigat&oacute;io e minimo de 5 caracteres</small></label>
		<input class="form-control" data-validation="required alphanumeric" required style="width: 90%;" type="text" name="titulo" value="<?php echo($titulo); ?>"  id="titulo" maxlength="250" title="<?php echo JText::_('Nome da foto'); ?>" placeholder="<?php echo JText::_('Nome da foto'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o breve'); ?> * <small>(restam <span id="maxlength">250</span> cadacteres)</small></label>
		<textarea class="form-control" data-validation="required alphanumeric"  required style="width: 90%;" type="text" name="meta_descricao"  id="meta_descricao" maxlength="250" title="<?php echo JText::_('Descri&ccedil;&atilde;o da foto'); ?>" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o da foto'); ?>"><?php echo($metaDescricao ); ?></textarea>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="descricao"><?php echo JText::_('Descri&ccedil;&atilde;o completa'); ?> * </label>
		<textarea class="form-control" data-validation="required alphanumeric"  required style="width: 90%;" type="text" name="descricao"  id="descricao" maxlength="250" title="<?php echo JText::_('Descri&ccedil;&atilde;o da foto'); ?>" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o detalhada da foto'); ?>"><?php echo($descricao); ?></textarea>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="aplicar_todos">Aplicar a altera&ccedil;&atilde;o em todas as fotos desta sess&atilde;o?</label>
		<input class="form-control" type="checkbox" name="aplicar_todos" value="S"  id="aplicar_todos" title="<?php echo JText::_('Aplicar a altera&ccedil;&atilde;o em todas as fotos?'); ?>" placeholder="<?php echo JText::_('Aplicar a altera&ccedil;&atilde;o em todas as fotos?'); ?>"/>
	</div>
</form>
<div class="row">
	<div class="col col col-xs-12  col-sm-12 col-md-12 col-lg-12"><img alt="Foto <?php echo($titulo); ?>" src="<?php echo($urlFoto);?>" class="img-reponsive"/></div>
</div>
<?php require_once 'ligthbox/floor.php' ;?>
<script>
function confirmarEditarTodosOsDados(){
	if(jQuery('#aplicar_todos:checked').val()=='S'){
		return confirm('Deseja mesmo aplica as altera\u00e7\u00f5es em todas as fotos?\nLembrando que s\u00e3o dados muito importante para ajudar as fotos a serem localizadas, logo quando mais deatalhado melhor.');
	}
	return true;
}

</script>