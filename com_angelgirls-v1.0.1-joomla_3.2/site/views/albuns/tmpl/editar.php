<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );


if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarEditarAlbum&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css?v='.VERSAO_ANGELGIRLS);

JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js?v='.VERSAO_ANGELGIRLS);





JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/editar_sessao.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/editar_sessao.js?v='.VERSAO_ANGELGIRLS);



$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');

$conteudo = JRequest::getVar('album');
$fotos = JRequest::getVar('fotos');



$perfil = JRequest::getVar('perfil');



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

$meta_descricao = JRequest::getString('meta_descricao',$conteudo->meta_descricao);
$historia = JRequest::getInt('historia',$conteudo->historia);
$locacao  = JRequest::getInt('locacao',$conteudo->id_locacao);



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
		EditarSessao.ImagensSemNunes = '.$semNudes.';
		
		
		EditarSessao.BuscarModeloURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=buscarModeloModal',false) . '";
		EditarSessao.BuscarFotografoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=buscarFotografoModal',false) . '";
		EditarSessao.sendFileToServerURL = "'.JURI::base( true ) . '/index.php";
		EditarSessao.SessaoID = "'.$id.'";
		EditarSessao.TemaURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarCadastrarTema',false) .'";
		EditarSessao.LocacaoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarCadastrarLocacao',false) .'";
		EditarSessao.FigurinoURL = "' .JRoute::_('index.php?option=com_angelgirls&view=albuns&task=openSendMessageModal',false).'";
		EditarSessao.LoadImagensURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarFotosContinuaHtml&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false).'";
		EditarSessao.RemoverImagemURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=removerFotoSessaoJson',false).'";
		EditarSessao.EditarTextoImagemURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarEditarFoto',false).'";
		EditarSessao.PossuiNudesURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=alterarPossuiNudesFotoJSon',false).'";
		EditarSessao.RemoverSessaoURL = "' . JRoute::_('index.php?option=com_angelgirls&view=albuns&task=removerSessao&id='.$conteudo->id,false).'";
');



?>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
		<form
			action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=albuns&task=salvarAlbum')); ?>"
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
								Album</span></span>
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
		<?php endif;?>
					<button class="btn btn-success" type="submit">
		<?php if(!isset($this->item) || $id == 0) :?>
					<span class="hidden-phone">Prosseguir</span> <span
							class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		<?php else:?>
					<span class="hidden-phone">Salvar<span class="hidden-tablet">
								Album</span></span> <span class="glyphicon glyphicon-ok"
							aria-hidden="true"></span>
		<?php endif; ?>
					</button>
		
				</div>
			</div>
			<div class="page-header">
				<h1>Editar Album</h1>
			</div>
			<div id="Totais" class="well"><small>Total de <span class="totalFotos itemValor">0</span> fotos, sendo <span class="totalFotosSemNu itemValor">0</span> fotos sem nudes ou semi.</small></div>
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
							<button class="btn btn-danger btnRemoverSessao" title="Apagar Album"  type="button">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
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
					
					
					<small>Total de <span class="totalFotos itemValor">0</span> fotos, sendo <span class="totalFotosSemNu itemValor">0</span> fotos sem nudes ou semi.</small>
				</div>
			</div>
			
			
			<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist"
				style="margin-bottom: 0;">
				<li class="active" role="presentation"><a href="#general"
					data-toggle="tab" aria-controls="profile" role="tab">Detalhe
						album <span class="glyphicon glyphicon-edit"
						aria-hidden="true"></span>
				</a></li>
			<?php if(!isset($this->item) || $id == 0) :?>
				<li role="presentation" class="disabled"><a
					href='JavaScript: info("Album n&atilde;o foi salva. Salve a album antes publicar as imagens.<br/>Para isso preencha o formul&aacute;rio eclique em \"Processuir\".");'>Publicar
						fotos <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
				</a></li>
			<?php else: ?>
				<li role="presentation"><a href="#publicarFotos" data-toggle="tab"
					aria-controls="profile" role="tab">Publicar fotos <span
						class="glyphicon glyphicon-picture" aria-hidden="true"></span>
				</a></li>
			<?php endif;?>
			</ul>
		
			<div id="detalhesAlbum" class="tab-content" style="overflow: auto;">
				<div id="general" class="tab-pane fade in active"
					style="height: 210px;">
					<h2>Detalhe Album</h2>
					<div class="row">
				<?php if(!isset($this->item) || $id == 0) :?>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" for="termos"><?php echo JText::_('Ao clicar aqui declaro que aceito todas as condi&ccedil;&otilde;es e termos de publica&ccedil;&atilde;o de uma album neste site.'); ?></label>
							<input class="form-control" data-validation="required" required
								type="checkbox" name="termos" value="SIM" id="termos"
								title="Termos para publicar a album, ao clicar nesse item indica que est&aacute; de acordo."
								style="text-align: left; width: 30px" />
						</div>
				<?php endif;?>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" for="titulo"><?php echo JText::_('T&iacute;itulo'); ?> *</label>
							<input class="form-control" data-validation="required" required
								style="width: 90%;" type="text" name="titulo" id="titulo"
								maxlength="250" value="<?php echo $titulo;?>"
								title="<?php echo JText::_('Titulo do album'); ?>"
								placeholder="<?php echo JText::_('Titulo da album'); ?>" />
						</div>

						<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3">
							<label class="control-label" for="name"><?php echo JText::_('Realizada'); ?> *</label>
							<?php echo JHtml::calendar($dataRealizada, 'data_realizada', 'data_nascimento', '%d/%m/%Y', 'class="form-control"  data-validation="date required" required data-validation-format="dd/mm/yyyy" style="height: 28px; width: 80%; margin-bottom: 6px;"');?>
						</div>
						<div class="form-group col-xs-12 col-sm-5 col-md-2 col-lg-3 sr-only">
							<label class="control-label" for="agenda"><?php echo JText::_('Agenda'); ?> *</label>
							<input class="form-control" type="text" name="agenda" id="agenda" />
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
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?> <small>(restam
									<span id="maxlength">250</span> cadacteres)
							</small></label>
							<textarea class="form-control" data-validation="required" required
								style="width: 95%;" rows="5" type="text" name="meta_descricao"
								id="meta_descricao" size="32" maxlength="250"
								placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a album fotos. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"
								title="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a album fotos. Evite nomes completos prefira nomes artisticos ou apelidos e evite colocar contatos como telefone, e-mail ou outros. Com at&eacute; 250 caracteres.'); ?>"><?php echo $meta_descricao;?></textarea>
						</div>
		
		



					</div>

		
		
		
		
		
					
					
					
					
					
					
					
					<br />
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label class="control-label" for="descricao"><strong>Descri&ccedil;&atilde;o
								da album</strong></label>
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
			</div>
		</form>
		<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=albuns&task=enviarFotosAlbum')); ?>"
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
	</div>
</div>