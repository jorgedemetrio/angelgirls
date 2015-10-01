<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );


if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarEditarSessao&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css?v='.VERSAO_ANGELGIRLS);

JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js?v='.VERSAO_ANGELGIRLS);





JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/editar_sessao.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/editar_sessao.js?v='.VERSAO_ANGELGIRLS);



$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');

$conteudo = JRequest::getVar('sessao');
$fotos = JRequest::getVar('fotos');
$videos = JRequest::getVar('videos');


$perfil = JRequest::getVar('perfil');

$temas = JRequest::getVar('temas');
$figurinos =  JRequest::getVar('figurinos');
$locacoes =  JRequest::getVar('locacoes');
$semNudes =  JRequest::getVar('sem_nudes',0);
$totalFotos =  JRequest::getVar('total_fotos',0);

$this->item = $conteudo;



$id  = JRequest::getInt('id',$conteudo->id);
$termos = JRequest::getString('termos','');
$titulo = JRequest::getString('titulo',$conteudo->titulo);
$imagem = JRequest::getString('imagem',null);
$data_realizada = JRequest::getString('data_realizada',null);
$dataRealizada="";
if(isset($data_realizada) && strlen(trim($data_realizada))>8){
	$dataRealizada = DateTime::createFromFormat('d/m/Y H:i:s', $data_realizada.' 00:00:00')->format('Y-m-d');
}
else{
	$dataRealizada = $conteudo->executada;
}

$agenda  = JRequest::getInt('agenda',$conteudo->id_agenda);
$meta_descricao = JRequest::getString('meta_descricao',$conteudo->meta_descricao);
$comentario = JRequest::getString('comentario',($perfil->tipo=='MODELO'? $conteudo->comentario_modelos:$conteudo->comentario_fotografo));
$historia = JRequest::getInt('historia',$conteudo->historia);
$tipo  = JRequest::getString('tipo_sessao',$conteudo->tipo);
$tema  = JRequest::getInt('tema',$conteudo->id_tema);
$locacao  = JRequest::getInt('locacao',$conteudo->id_locacao);
$id_figurino_principal  = JRequest::getInt('id_figurino_principal',$conteudo->id_figurino_principal);
$id_figurino_secundario  = JRequest::getInt('id_figurino_secundario',$conteudo->id_figurino_secundario);
$id_modelo_principal  = JRequest::getInt('id_modelo_principal',$conteudo->id_modelo_principal);
$id_modelo_secundaria  = JRequest::getInt('id_modelo_secundaria',$conteudo->id_modelo_secundaria);
$id_fotografo_principal  = JRequest::getInt('id_fotografo_principal',$conteudo->id_fotografo_principal);



$id_fotografo_secundario  = JRequest::getInt('id_fotografo_secundario',$conteudo->id_fotografo_secundario);


$descricao = JRequest::getString('descricao',$conteudo->descricao);

JFactory::getDocument()->addScriptDeclaration('
		if(!EditarSessao){
			var EditarSessao = new Object();
		}
		var lidos = 0;
		var carregando = false;
		var temMais=false;
		EditarSessao.ImagensPublicadas = '.$totalFotos.';
		EditarSessao.VideosPublicados = '.sizeof($videos).';
		EditarSessao.ImagensSemNunes = '.$semNudes.';
		
		
		EditarSessao.BuscarModeloURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=buscarModeloModal',false) . '";
		EditarSessao.BuscarFotografoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=buscarFotografoModal',false) . '";
		EditarSessao.sendFileToServerURL = "'.JURI::base( true ) . '/index.php";
		EditarSessao.SessaoID = "'.$id.'";
		EditarSessao.TemaURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarTema',false) .'";
		EditarSessao.LocacaoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarLocacao',false) .'";
		EditarSessao.FigurinoURL = "' .JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarFigurino',false).'";
		EditarSessao.LoadImagensURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFotosContinuaHtml&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false).'";
		EditarSessao.RemoverImagemURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=removerFotoSessaoJson',false).'";
		EditarSessao.EditarTextoImagemURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarEditarFoto',false).'";
		EditarSessao.PossuiNudesURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=alterarPossuiNudesFotoJSon',false).'";
		EditarSessao.RemoverVideoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=removerVideoSessaoJson',false).'";
		EditarSessao.SalvarVideoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=enviarVideoSessao',false).'";
		EditarSessao.CarregarVideoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarVideosContinuaHtml',false).'";
		EditarSessao.VerVideoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=verVideo',false).'";
		EditarSessao.RemoverSessaoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=removerSessao&id='.$conteudo->id,false).'";
');



?>
<form
	action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=salvarSessao')); ?>"
	method="post" name="dadosForm" id="dadosForm" class="form-validate"
	role="form" data-toggle="validator" enctype="multipart/form-data">
	<input type="hidden" name="id"
		value="<?php echo JRequest::getInt('id'); ?>" />
	
	<input type="hidden" name="publicar" id="publicar" value="N" />
	
	<?php echo JHtml::_('form.token'); ?>
	
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group" role="group">
			<button class="btn btn-info ajuda" type="button">
				Dicas e Sujest&otilde;es <span
					class="glyphicon glyphicon-question-sign"></span>
			</button>
			<button class="btn btn-info informacoes" type="button">
				Termos e condi&ccedil;&otilde;es <span
					class="glyphicon glyphicon-paperclip"></span>
			</button>
		</div>
		<div class="btn-group" role="group">
<?php if(isset($id) && $id != 0) :?>
			<button class="btn btn-danger btnRemoverSessao" type="button">
				<span class="hidden-phone"><?php echo JText::_('Apagar'); ?><span class="hidden-tablet">
						Sess&atilde;o</span></span>
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
			<button class="btn btn-primary btnPublicar  disabled" type="button" disable="disabled">
				<span class="hidden-phone"><?php echo JText::_('Publicar'); ?><span class="hidden-tablet">
						Sess&atilde;o</span></span>
				<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
			</button>
<?php endif;?>
			<button class="btn btn-success" type="submit">
<?php if(!isset($this->item) || $id == 0) :?>
			<span class="hidden-phone">Prosseguir</span> <span
					class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
<?php else:?>
			<span class="hidden-phone">Salvar<span class="hidden-tablet">
						Sess&atilde;o</span></span> <span class="glyphicon glyphicon-ok"
					aria-hidden="true"></span>
<?php endif; ?>
			</button>

		</div>
	</div>
	<div class="page-header">
		<h1>Editar Sess&atilde;o</h1>
	</div>
	<div id="Totais" class="well"><small>Total de <span class="totalFotos itemValor">0</span> fotos e <span class="totalVideos itemValor">0</span> v&iacute;deos enviados. Sendo <span class="totalFotosSemNu itemValor">0</span> fotos sem nudes ou semi.</small></div>
	<div class="hidden-phone">
		<div id="TotaisHide" class="fade well" style="display:none; position: absolute; left: 0px; z-index: 500; background-color: rgba(245,245,245,0.6); 
																								   background-image: -webkit-linear-gradient(top, rgba(232, 232, 232,0.5) 0%, rgba(245, 245, 245,0.5) 70%); 
																								   background-image: -o-linear-gradient(top, rgba(232, 232, 232,0.5) 0%, rgba(245, 245, 245,0.5) 100%); 
																								   background-image: linear-gradient(to bottom, rgba(232, 232, 232,0.5) 0%, rgba(245, 245, 245,0.5) 100%); ">
		
			<div class="btn-toolbar pull-right" pull-right" role="toolbar" style=" padding: 0px; margin: 0px; ">
				<div class="btn-group" role="group">
					<button class="btn btn-info ajuda" type="button" title="Dicas e Sujest&otilde;es ">
						<span class="glyphicon glyphicon-question-sign"></span>
					</button>
					<button class="btn btn-info informacoes" type="button" title="Termos e condi&ccedil;&otilde;es">
						 <span class="glyphicon glyphicon-paperclip"></span>
					</button>
				</div>
				
				<div class="btn-group" role="group">
		<?php if(isset($id) && $id != 0) :?>
					<button class="btn btn-danger btnRemoverSessao" title="Apagar Sess&atilde;o"  type="button">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
					<button class="btn btn-primary btnPublicar  disabled" type="button" title="Publicar  Sess&atilde;o"  disable="disabled">
						<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
					</button>
		<?php endif;?>
					<button class="btn btn-success" type="submit"  title="Prosseguir/Salvar">
		<?php if(!isset($this->item) || $id == 0) :?>
					<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		<?php else:?>
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		<?php endif; ?>
					</button>
				</div>
			</div>
			
			
			<small>Total de <span class="totalFotos itemValor">0</span> fotos e <span class="totalVideos itemValor">0</span> v&iacute;deos enviados. Sendo <span class="totalFotosSemNu itemValor">0</span> fotos sem nudes ou semi.</small>
		</div>
	</div>
	
	
	<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist"
		style="margin-bottom: 0;">
		<li class="active" role="presentation"><a href="#general"
			data-toggle="tab" aria-controls="profile" role="tab">Detalhe
				sess&atilde;o <span class="glyphicon glyphicon-edit"
				aria-hidden="true"></span>
		</a></li>
	<?php if(!isset($this->item) || $id == 0) :?>
		<li role="presentation" class="disabled"><a
			href='JavaScript: info("Sess&atilde;o n&atilde;o foi salva. Salve a sess&atilde;o antes publicar as imagens.<br/>Para isso preencha o formul&aacute;rio eclique em \"Processuir\".");'>Publicar
				fotos <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
		</a></li>
		<li role="presentation" class="disabled"><a
			href='JavaScript: info("Sess&atilde;o n&atilde;o foi salva. Salve a sess&atilde;o antes publicar as imagens.<br/>Para isso preencha o formul&aacute;rio eclique em \"Processuir\".");'>V&iacute;deo/MakingOf
				<span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>
		</a></li>
	<?php else: ?>
		<li role="presentation"><a href="#publicarFotos" data-toggle="tab"
			aria-controls="profile" role="tab">Publicar fotos <span
				class="glyphicon glyphicon-picture" aria-hidden="true"></span>
		</a></li>
		<li role="presentation"><a href='#videos' data-toggle="tab"
			aria-controls="profile" role="tab">V&iacute;deo/MakingOf <span
				class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span></a>
		</li>
	<?php endif;?>
	</ul>

	<div id="detalhesSessao" class="tab-content" style="overflow: auto;">
		<div id="general" class="tab-pane fade in active"
			style="height: 210px;">
			<h2>Detalhe sess&atilde;o</h2>
			<div class="row">
		<?php if(!isset($this->item) || $id == 0) :?>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label" for="termos"><?php echo JText::_('Ao clicar aqui declaro que aceito todas as condi&ccedil;&otilde;es e termos de publica&ccedil;&atilde;o de uma sess&atilde;o neste site.'); ?></label>
					<input class="form-control" data-validation="required" required
						type="checkbox" name="termos" value="SIM" id="termos"
						title="Termos para publicar a sess&atilde;o, ao clicar nesse item indica que est&aacute; de acordo."
						style="text-align: left; width: 30px" />
				</div>


				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label" for="titulo"><?php echo JText::_('T&iacute;itulo'); ?> *</label>
					<input class="form-control" data-validation="required" required
						style="width: 90%;" type="text" name="titulo" id="titulo"
						maxlength="250" value="<?php echo $titulo;?>"
						title="<?php echo JText::_('Titulo da sess&atilde;o'); ?>"
						placeholder="<?php echo JText::_('Titulo da sess&atilde;o'); ?>" />
				</div>
		<?php else: ?>
				<div class="form-group col-sm-2 col-md-2 col-lg-2 hidden-phone">
					<a class="btn btn-default zoominImagem"
						href="JavaScript: EditarSessao.OpenImagem('<?php echo( JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->token.':thumb'));?>')"
						title="Clique aqui para ver a imagem anterior"><img alt=""
						src="<?php echo( JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->token.':ico'));?>" /></a>
				</div>
				<div class="form-group col-xs-12 col-sm-10 col-md-10 col-lg-10">
					<label class="control-label" for="titulo"><?php echo JText::_('T&iacute;itulo'); ?> *</label>
					<input class="form-control" data-validation="required" required
						style="width: 90%;" type="text" name="titulo" id="titulo"
						maxlength="250" value="<?php echo $titulo;?>"
						title="<?php echo JText::_('Titulo da sess&atilde;o'); ?>"
						placeholder="<?php echo JText::_('Titulo da sess&atilde;o'); ?>" />
				</div>
		<?php endif;?>
		
				<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3">
					<label class="control-label" for="imagem"><?php echo JText::_('Imagem de Capa'); ?> *
					</label> <input class="form-control" style="width: 90%;"
		<?php if(!isset($this->item) || $id == 0) :?>
						data-validation="required size mime dimension"  required
		<?php else:?>
						data-validation="size mime dimension"
		<?php endif;?>
						type="file"
						name="imagem" id="imagem"
						title="<?php echo JText::_('Imagem que representa o a loca&ccedil&atilde;o da sess&atilde;o'); ?>"
						accept="image/*" data-validation-dimension="min300x500"
						data-validation="size" data-validation-max-size="5M"
						data-validation-allowing="jpg, png, gif, JPG, PNG, GIF" />
				</div>
				<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3">
					<label class="control-label" for="name"><?php echo JText::_('Sess&atilde;o Realizada'); ?> *</label>
					<?php echo JHtml::calendar($dataRealizada, 'data_realizada', 'data_nascimento', '%d/%m/%Y', 'class="form-control"  data-validation="date required" required data-validation-format="dd/mm/yyyy" style="height: 28px; width: 80%; margin-bottom: 6px;"');?>
				</div>
				<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3">
					<label class="control-label" for="tipo_sessao"><?php echo JText::_('Tipo de Sess&atilde;o'); ?> *</label>
					<select name="tipo_sessao" id="tipo_sessao" class="form-control"
						data-validation="required" required>
						<option></option>
						<option value="VENDA"
							<?php echo($tipo=='VENDA'?' selected':''); ?>>Venda</option>
						<option value="PONTOS"
							<?php echo($tipo=='PONTOS'?' selected':''); ?>>Pontos</option>
						<option value="PATROCINIO"
							<?php echo($tipo=='PATROCINIO'?' selected':''); ?>>Patrocinio</option>
						<option value="LEILAO"
							<?php echo($tipo=='LEILAO'?' selected':''); ?>>Leil&atilde;o</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3 sr-only">
					<label class="control-label" for="agenda"><?php echo JText::_('Agenda'); ?> *</label>
					<input class="form-control" type="text" name="agenda" id="agenda" />
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label" for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?> <small>(restam
							<span id="maxlength">250</span> cadacteres)
					</small></label>
					<textarea class="form-control" data-validation="required" required
						style="width: 95%;" rows="5" type="text" name="meta_descricao"
						id="meta_descricao" size="32" maxlength="250"
						placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a sess&atilde;o fotos. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"
						title="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a sess&atilde;o fotos. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"><?php echo $meta_descricao;?></textarea>
				</div>


				<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<label class="control-label" for="tema"><?php echo JText::_('Tema'); ?></label>
					<select class="form-control" name="tema" id="tema"
						data-validation="required" style="width: 90%;" required>
						<option value=""></option>
						<option value="NOVO">NOVO</option>
						<optgroup label="Itens existentes">Itens existentes
						</optgroup>
	<?php foreach ($temas as $tm) : ?>
						<option value="<?php echo($tm->id);?>"
							<?php echo($tema==$tm->id?' selected':'')?>
							data-descricao="<?php echo($tm->descricao);?>"
							data-ft="<?php echo($tm->foto);?>"
							style="text-transform: capitalize;"><?php echo(strtolower( $tm->nome))?></option>
	<?php endforeach;?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<label class="control-label" for="locacao"><?php echo JText::_('Loca&ccedil;&atilde;o'); ?></label>
					<select class="form-control" name="locacao" id="locacao"
						data-validation="required" style="width: 90%;" required>
						<option value=""></option>
						<option value="NOVO">NOVO</option>
						<optgroup label="Itens existentes">Itens existentes
						</optgroup>
	<?php foreach ($locacoes as $loc) : ?>
						<option value="<?php echo($loc->id);?>"
							<?php echo($locacao==$loc->id?' selected':'')?>
							data-descricao="<?php echo($loc->descricao);?>"
							data-ft="<?php echo($loc->foto);?>"
							style="text-transform: capitalize;"><?php echo(strtolower( $loc->nome))?></option>
	<?php endforeach;?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<label class="control-label" for="id_figurino_principal"><?php echo JText::_('Figurino Principal'); ?></label>
					<select class="form-control figurino" name="id_figurino_principal"
						id="id_figurino_principal" data-validation="required" required
						style="width: 90%;">
						<option value=""></option>
						<option value="NOVO">NOVO</option>
						<optgroup label="Itens existentes">Itens existentes
						</optgroup>
	<?php foreach ($figurinos as $figurino) : ?>
						<option value="<?php echo($figurino->id);?>"
							<?php echo($id_figurino_principal==$figurino->id?' selected':'')?>
							data-descricao="<?php echo($figurino->descricao);?>"
							data-ft="<?php echo($figurino->foto);?>"
							style="text-transform: capitalize;"><?php echo(strtolower( $figurino->nome))?></option>
	<?php endforeach;?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
					<label class="control-label" for="id_figurino_secundario"><?php echo JText::_('Figurino Secund&aacute;rios'); ?></label>
					<select class="form-control figurino" name="id_figurino_secundario"
						id="id_figurino_secundario" style="width: 90%;">
						<option value=""></option>
						<option value="NOVO">NOVO</option>
						<optgroup label="Itens existentes">Itens existentes
						</optgroup>
	<?php foreach ($figurinos as $figurino) : ?>
						<option value="<?php echo($figurino->id);?>"
							<?php echo($id_figurino_secundario==$figurino->id?' selected':'')?>
							data-descricao="<?php echo($figurino->descricao);?>"
							data-ft="<?php echo($figurino->foto);?>"
							style="text-transform: capitalize;"><?php echo(strtolower( $figurino->nome))?></option>
	<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<label class="control-label" for="comentario">Coment&aacute;rio do(a) <?php echo(strtolower( $perfil->tipo));?> <small>(restam
						<span id="maxlengthComentario">250</span> cadacteres)
				</small></label>
				<textarea class="form-control" data-validation="required" required
					style="width: 95%;" rows="3" type="text" name="comentario"
					id="comentario" maxlength="250"
					placeholder="<?php echo JText::_('Coment&aacute;rio com seu ponto de vista sobre a sess&atilde;o. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"
					title="<?php echo JText::_('Coment&aacute;rio com seu ponto de vista sobre a sess&atilde;o. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"><?php echo $comentario; ?></textarea>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<label class="control-label" for="historia">Hist&oacute;ria do
					SET/Sess&atilde;o</label>
				<textarea class="form-control" style="width: 95%;" rows="3"
					type="text" name="historia" id="historia"
					placeholder="<?php echo JText::_('Hist&oacute;ria do SET, dos personagens, o que tenta contar com o sess&atilde;o ou como chegou at&eacute; a ideia, pode citar nomes de personagens. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros.'); ?>"
					title="<?php echo JText::_('Hist&oacute;ria do SET, o que tenta contar com o sess&atilde;o ou como chegou at&eacute; a ideia, pode citar nomes de personagens. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"><?php echo $historia; ?></textarea>
			</div>





			<div class="row">
			
			
			
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Modelo Principal</h5>		
<?php if((!isset($id_modelo_principal) || $id_modelo_principal==0) && $perfil->tipo=="MODELO"):
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$perfil->id.':ico');
?>		
					<input type="hidden" name="id_modelo_principal"	id="id_modelo_principal" value="<?php echo $perfil->id;?>" />
					<div id="dadosModeloPricipal" class="row" style="text-align: center; margin-top: 50px;">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloPrincipal">
							<img src="<?php echo($urlImg);?>" title="Modelo <?php echo($perfil->apelido);?>"
								alt="Modelo <?php echo($perfil->apelido);?>" class="img-circle" style="height: 100px" />
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="nomeModeloPrincipal"><?php echo($perfil->apelido);?></div>
					</div>
<?php else:
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$id_modelo_principal.':ico');?>
					<input type="hidden" name="id_modelo_principal"	id="id_modelo_principal" value="<?php echo $id_modelo_principal;?>" /> 
						<a href="JavaScript: EditarSessao.BuscarModelo('id_modelo_principal','nomeModeloPrincipal','fotoModeloPrincipal');"
						class="btn">
							Selecionar <span class="glyphicon glyphicon-user"></span>
						</a>
					<div id="dadosModeloPricipal" class="row" style="text-align: center; margin-top: 10px;">
<?php if(isset($id_modelo_principal) && $id_modelo_principal!=0):?>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"
							id="fotoModeloPrincipal">
							<img src="<?php echo($urlImg);?>"
								title="Modelo <?php echo($this->item->modelo1);?>"
								alt="Modelo <?php echo($this->item->modelo1);?>"
								class="img-circle" style="height: 100px" />
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloPrincipal"><?php echo($this->item->modelo1);?></div>
<?php else:?>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloPrincipal"></div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloPrincipal"></div>
<?php endif;?>	
					</div>
<?php endif;
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$id_modelo_secundaria.':ico');?>
				</div>

				
				
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Segunda Modelo</h5>
					<input type="hidden" name="id_modelo_secundaria"
						id="id_modelo_secundaria"
						value="<?php echo $id_modelo_secundaria;?>" /> <a
						href="JavaScript: EditarSessao.BuscarModelo('id_modelo_secundaria','nomeModeloSecundaria','fotoModeloSecundaria');"
						class="btn">Selecionar <span
						class="glyphicon glyphicon-user"></span></a>
					<div id="dadosModeloPricipal" class="row" style="text-align: center; margin-top: 10px;">
<?php if(isset($id_modelo_secundaria) && $id_modelo_secundaria!=0):?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloSecundaria">
						<img src="<?php echo($urlImg);?>" title="Modelo <?php echo($this->item->modelo2);?>"
							alt="Modelo <?php echo($this->item->modelo12);?>" class="img-circle" style="height: 100px" />
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloSecundaria"><?php echo($this->item->modelo2);?></div>
<?php else:?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloSecundaria"></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloSecundaria"></div>
<?php endif;?>
					</div>
				</div>



				
				
				
				
				
				
				


				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Fotografo Principal</h5>				
<?php 
	if((!isset($id_fotografo_principal) || $id_fotografo_principal==0) && $perfil->tipo=="FOTOGRAFO"):
		$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$perfil->id.':ico'); ?>		
					<input type="hidden" name="id_fotografo_principal"
						id="id_fotografo_principal" value="<?php echo $perfil->id;?>" />
					<div id="dadosFotografoPricipal" class="row"
						style="text-align: center; margin-top: 50px;">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoPrincipal">
							<img src="<?php echo($urlImg);?>" title="Fotografo <?php echo($perfil->apelido);?>"
								alt="Fotografo <?php echo($perfil->apelido);?>"	class="img-circle" style="height: 100px" />
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="nomeFotografoPrincipal"><?php echo($perfil->apelido);?></div>
					</div>
<?php 
	else:
		$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$id_fotografo_principal.':ico');?>
					<input type="hidden" name="id_fotografo_principal" id="id_fotografo_principal" value="<?php echo $id_fotografo_principal;?>" />
						<a href="JavaScript: EditarSessao.BuscarFotografo('id_fotografo_principal','nomeFotografoPrincipal','fotoFotografoPrincipal');" class="btn">
							Selecionar <span class="glyphicon glyphicon-user"></span>
						</a>
				<div id="dadosModeloPricipal" class="row" style="text-align: center; margin-top: 10px;">
<?php	if(isset($id_fotografo_principal) && $id_fotografo_principal!=0) :?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoPrincipal">
						<img src="<?php echo($urlImg);?>" title="Fotografo <?php echo($this->item->fotografo1);?>"
								alt="Fotografo <?php echo($this->item->fotografo1);?>" class="img-circle" style="height: 100px" />
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeFotografoPrincipal"><?php echo($this->item->fotografo1);?></div>
<?php 	else:?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoPrincipal"></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeFotografoPrincipal"></div>
<?php 	endif; ?>
				</div>
<?php endif;?>
			</div>			
				
				
				
			
				
				
<?php 
$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$id_fotografo_secundario.':ico');?>
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3"
					style="text-align: center;">
					<h5 calss="text-center">Segundo Fotografo/Equipe</h5>
					<input type="hidden" name="id_fotografo_secundario"
						id="id_fotografo_secundario"
						value="<?php echo $id_fotografo_secundario;?>" /> <a
						href="JavaScript: EditarSessao.BuscarFotografo('id_fotografo_secundario','nomeFotografoSecundaria','fotoFotografoSecundaria');"
						class="btn">Selecionar <span
						class="glyphicon glyphicon-user"></span></a>
					<div id="dadosFotografoPricipal" class="row"
						style="text-align: center; margin-top: 10px;">
<?php if(isset($id_fotografo_secundario) && $id_fotografo_secundario!=0):?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"
							id="fotoFotografoPrincipal">
							<img src="<?php echo($urlImg);?>"
								title="Fotografo <?php echo($this->item->fotografo1);?>"
								alt="Fotografo <?php echo($this->item->fotografo2);?>"
								class="img-circle" style="height: 100px" />
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeFotografoPrincipal"><?php echo($this->item->fotografo2);?></div>
<?php else:?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"
							id="fotoFotografoSecundaria"></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"
							id="nomeFotografoSecundaria"></div>
<?php endif;?>

					</div>
				</div>

			</div>
			
			
			
			
			
			
			
			<br />
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label" for="descricao"><strong>Descri&ccedil;&atilde;o
						da sess&atilde;o</strong></label>
		    	<?php echo $editor->display('descricao', $this->item->descricao, '50', '50', '10', '5', false, $params); ?>
			</div>

		</div>
		<div id="publicarFotos" class="tab-pane fade"
			style="height: 210px;">
			<h2>Publicar fotos</h2>
			<div class="row">
				<div id="dragandrophandler"
					class="col col-xs-11 col-sm-10 col-md-8 col-lg-8 text-center uploadarea">
					<br />Para fazer upload arraste seus arquivos JPGs sobre essa
					imagem.<img
						src="<?php echo(JURI::base( true ).'/components/com_angelgirls/fotos.png');?>"
						title="Arraste sua imagem aqui" />
				</div>
				<div id="dragandrophandlerArquivos"
					class="col col-xs-1 col-sm-2 col-md-4 col-lg-4 text-center hidden-phone"
					style="height: 350px; overflow: scroll;">
					<h5 id="tituloArquivosRecebidos">
						Lista de imagens <span class="glyphicon glyphicon-picture"></span>
					</h5>
				</div>
			</div>
		</div>
		<div id="videos" class="tab-pane fade" style="height: 300px;">
						<div class="btn-group pull-right" role="group">
							<div class="btn-group" role="group">
								<button  class="btn btn-danger fade" type="button" id="btnCancelarSalvarVideo" name="btnCancelarSalvarVideo" title="Cancelar altera&ccedil;&atilde;o de  video"><span class="hidden-phone"><?php echo JText::_('Cancelar'); ?></span>
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
								<button class="btn btn-success fade" type="button" id="btnSalvarVideo" name="btnSalvarVideo" title="Salvar altera&ccedil;&atilde;o de video"><span class="hidden-phone">Salvar<span class="hidden-tablet"> v&iacute;deo</span></span>
									<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
								</button>
								<button class="btn btn-success fade in" type="button" id="btnAdicionarVideo" name="btnAdicionarVideo" title="Adicionar video novo"><span class="hidden-phone"><span class="hidden-tablet">Enviar</span> v&iacute;deo</span>
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							</div>
						</div>
			<h2>V&iacute;deo e Making Ofs</h2>
			<!-- 			https://developers.google.com/youtube/player_parameters?hl=pt-br -->
			<!-- 			https://developers.google.com/youtube/v3/code_samples/?hl=pt-br -->
			<!-- https://developer.vimeo.com/ -->
			<input type="hidden" name="id_video" id="id_video"/>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
					<label class="control-label" for="titulo_video"><?php echo JText::_('Titulo'); ?> *</label>
					<input class="form-control" type="text" name="titulo_video"  id="titulo_video" maxlength="250"
						style=" width:  90%" />
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<label class="control-label" for="video" title="V&iacute;deos com no m&aacute;ximo 2 minutos e 60 megabytes, o formato deve ser MP4 compacta&ccedil;&atilde;o H264 em HD (720p) ou Super HD (1080p). Recomendado em 24fps."><?php echo JText::_('V&iacute;deo'); ?> * <small>(Apenas MP4 em HD ou SHD, m&aacute;ximo 5 mins e 60Mb)</small> </label>
					<input class="form-control"  type="file" name="video"  id="video" style=" width:  90%" accept="video/mp4" title="V&iacute;deos com no m&aacute;ximo 2 minutos e 60 megabytes, o formato deve ser MP4 compacta&ccedil;&atilde;o H264 em HD (720p) ou Super HD (1080p). Recomendado em 24fps."/>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<label class="control-label" for="tipoVideo"><?php echo JText::_('Tipo'); ?> *</label>
					<select id="tipo_video" name="tipo_video">
						<option></option>
						<option value='MAKINGOF'>MakingOf</option>
						<option value='AUTORIZACAOMODELO'>Modelo autorizando a sess&atilde;o</option>
						<option value='OUTRO'>Outro</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-7">
					<label class="control-label" for="descricao_video"><?php echo JText::_('Descri&ccedil;&atilde;o'); ?></label>
					<textarea rows="2" name="descricao_video" id="descricao_video" style=" width:  90%"></textarea>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-5">
					<label class="control-label" for="descricao_video"><?php echo JText::_('Descri&ccedil;&atilde;o breve'); ?> <small>(restam
							<span id="maxlengthvideo">250</span> cadacteres)</small></label>
					<textarea rows="2" name="meta_descricao_video" id="meta_descricao_video" style=" width:  90%"></textarea>
				</div>
				
				<div class="row">				
					<div  class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="listaVideos">
<?php 		require_once 'lista_videos.php';	?>
					</div>
				</div>
		</div>
	</div>
</form>
<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=enviarFotosSessao')); ?>"
	id="enviar" method="post" enctype="multipart/form-data"></form>


<?php if(isset($this->item) && $this->item->id != 0) :?>
<h2>Fotos</h2>
<div class="row" id="linha">
<?php require_once 'fotos.php'; ?>
</div>
<?php endif;?>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>