<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );


if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarEditarSessao&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css');
JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js');
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/editar_sessao.js?v='.VERSAO_ANGELGIRLS);

$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');

$conteudo = JRequest::getVar('sessao');
$fotos = JRequest::getVar('fotos');
$id = JRequest::getInt('id');

$perfil = JRequest::getVar('perfil');

$temas = JRequest::getVar('temas');
$figurinos =  JRequest::getVar('figurinos');
$locacoes =  JRequest::getVar('locacoes');

$this->item = $conteudo;



?>
<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarSessao')); ?> " method="post" name="dadosForm" id="dadosForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<div class="btn-group pull-right" role="group">
		<div class="btn-group" role="group">
			<button  class="btn" type="button" onclick="JavaScript:window.history.back(-1);">
				<span class="hidden-phone"><?php echo JText::_('Cancelar'); ?></span>
			</button>
<?php if(isset($this->item) && $this->item->id != 0) :?>
			<button  class="btn btn-danger" type="button" ><span class="hidden-phone"><?php echo JText::_('Remover'); ?></span>
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
<?php endif;?>
			<button  class="btn btn-success" type="submit">
<?php if(!isset($this->item) || $this->item->id == 0) :?>
			<span class="hidden-phone">Prosseguir</span>
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
<?php else:?>
			<span class="hidden-phone">Salvar<span class="hidden-tablet"> Sess&atilde;o</span></span>
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
<?php endif; ?>
			</button>
		</div>
	</div>
	<div class="page-header">
		<h1>Editar Sess&atilde;o</h1>
	</div>
	<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
		<li class="active" role="presentation">
			<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Detalhe sess&atilde;o
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a>
		</li>
	<?php if(!isset($this->item) || $this->item->id == 0) :?>
		<li role="presentation" class="disabled">
			<a href='JavaScript: info("Sess&atilde;o n&atilde;o foi salva. Salve a sess&atilde;o antes publicar as imagens.<br/> Para isso preencha o form&aacute;rio e clique em \"Processuir\".");'>Publicar fotos
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span></a>
		</li>
	<?php else: ?>
		<li role="presentation" class="disabled">
			<a href="#publicarFotos" data-toggle="tab" aria-controls="profile" role="tab">Publicar fotos
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
			</a>
		</li>
	<?php endif;?>
	</ul>
	
	<div id="detalhesSessao" class="tab-content" style="overflow: auto;">
		<div id="general" class="tab-pane fade in active" style="height: 210px;">
			<h2>Detalhe sess&atilde;o</h2>
	<?php if(!isset($this->item) || $this->item->id == 0) :?>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label" for="termos"><?php echo JText::_('Ao clicar aqui declaro que aceito todas as condi&ccedil;&otilde;es e termos de publica&ccedil;&atilde;o de uma sess&atilde;o neste site.'); ?></label>
				<input class="form-control"  data-validation="required" type="checkbox" name="termos"  id="termos" title="Termos para publicar a sess&atilde;o, ao clicar nesse item indica que est&aacute; de acordo." style="text-align: left; width: 30px"/>
			</div>
	<?php endif;?>			
			<div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<label class="control-label"  for="titulo"><?php echo JText::_('T&iacute;itulo'); ?> *</label>
				<input class="form-control" data-validation="required alphanumeric" style="width: 90%;" type="text" name="titulo"  id="titulo" maxlength="250" value="<?php echo $this->item->titulo;?>" title="<?php echo JText::_('Titulo da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Titulo da sess&atilde;o'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label class="control-label"  for="name"><?php echo JText::_('Sess&atilde;o Realizada'); ?> *</label>
				<?php echo JHtml::calendar($this->item->data_nascimento, 'data_nascimento', 'data_nascimento', '%d/%m/%Y', 'class="form-control"  data-validation="date required" data-validation-format="dd/mm/yyyy" style="height: 28px; width: 80%; margin-bottom: 6px;"');?>
			</div>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label"  for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?> <small>(restam <span id="maxlength">250</span> cadacteres)</small></label>
				<textarea class="form-control" data-validation="required" style="width: 95%;" rows="5" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a sess&atilde;o fotos. Evite caractes especiais e colocar contatos como telefone, e-mail ou outros, com at&eacute; 250 caracteres.'); ?>"  title="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre a sess&atilde;o fotos. Evite caractes especiais e colocar contatos como telefone, e-mail ou outros, com at&eacute; 250 caracteres.'); ?>"><?php echo $this->item->meta_descricao;?></textarea>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<label class="control-label"  for="tema"><?php echo JText::_('Tema'); ?></label>
				<select class="form-control"  name="tema" id="tema" data-validation="required" style="width: 90%;" >
					<option value=""></option>
					<option value="NOVO">NOVO</option>
					<optgroup label="Itens existentes">Itens existentes</optgroup>
<?php foreach ($temas as $tema) : ?>
					<option value="<?php echo($tema->id);?>" data-descricao="<?php echo($tema->descricao);?>"  data-ft="<?php echo($tema->foto);?>" style="text-transform: capitalize;"><?php echo(strtolower( $tema->nome))?></option>
<?php endforeach;?>
				</select>			
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<label class="control-label"  for="locacao"><?php echo JText::_('Loca&ccedil;&atilde;o'); ?></label>
				<select class="form-control"  name="locacao" id="locacao" data-validation="required" style="width: 90%;" >
					<option value=""></option>
					<option value="NOVO">NOVO</option>
					<optgroup label="Itens existentes">Itens existentes</optgroup>
<?php foreach ($locacoes as $locacao) : ?>
					<option value="<?php echo($locacao->id);?>" data-descricao="<?php echo($locacao->descricao);?>"  data-ft="<?php echo($locacao->foto);?>" style="text-transform: capitalize;"><?php echo(strtolower( $locacao->nome))?></option>
<?php endforeach;?>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<label class="control-label"  for="id_figurino_principal"><?php echo JText::_('Figurino Principal'); ?></label>
				<select class="form-control figurino"  name="id_figurino_principal" id="id_figurino_principal" data-validation="required" style="width: 90%;" >
					<option value=""></option>
					<option value="NOVO">NOVO</option>
					<optgroup label="Itens existentes">Itens existentes</optgroup>
<?php foreach ($figurinos as $figurino) : ?>
					<option value="<?php echo($figurino->id);?>" data-descricao="<?php echo($figurino->descricao);?>"  data-ft="<?php echo($figurino->foto);?>" style="text-transform: capitalize;"><?php echo(strtolower( $figurino->nome))?></option>
<?php endforeach;?>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<label class="control-label"  for="id_figurino_secundario"><?php echo JText::_('Figurino Secund&aacute;rios'); ?></label>
				<select class="form-control figurino"  name="id_figurino_secundario" id="id_figurino_secundario" style="width: 90%;" >
					<option value=""></option>
					<option value="NOVO">NOVO</option>
					<optgroup label="Itens existentes">Itens existentes</optgroup>
<?php foreach ($figurinos as $figurino) : ?>
					<option value="<?php echo($figurino->id);?>" data-descricao="<?php echo($figurino->descricao);?>"  data-ft="<?php echo($figurino->foto);?>" style="text-transform: capitalize;"><?php echo(strtolower( $figurino->nome))?></option>
<?php endforeach;?>
				</select>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Modelo Principal</h5>		
<?php if((!isset($this->item->id_modelo_principal) || $this->item->id_modelo_principal==0) && $perfil->tipo=="MODELO"):
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$perfil->id.':ico');
?>		
					<input type="hidden" name="id_modelo_principal" id="id_modelo_principal"  value="<?php echo $perfil->id;?>"/>
					<div id="dadosModeloPricipal" class="row" style="text-align: center">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloPrincipal">
						<img src="<?php echo($urlImg);?>" title="Modelo <?php echo($perfil->apelido);?>" alt="Modelo <?php echo($perfil->apelido);?>" class="img-circle" style="height: 100px"/>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="nomeModeloPrincipal"><?php echo($perfil->apelido);?></div>
					</div>
<?php else:
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$this->item->id_modelo_principal.':ico');?>
					<input type="hidden" name="id_modelo_principal" id="id_modelo_principal"  value="<?php echo $this->item->id_modelo_principal;?>"/>
					<a href="JavaScript: BuscarModelo('id_modelo_principal','nomeModeloPrincipal','fotoModeloPrincipal');" class="btn">Selecionar Modelo
					 <span class="glyphicon glyphicon-user"></span></a>
					<div id="dadosModeloPricipal" class="row" style="text-align: center">
<?php if(isset($this->item->id_modelo_principal) && $this->item->id_modelo_principal!=0):?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloPrincipal"><img src="<?php echo($urlImg);?>" title="Modelo <?php echo($this->item->modelo1);?>" alt="Modelo <?php echo($this->item->modelo1);?>" class="img-circle" style="height: 100px"/></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloPrincipal"><?php echo($this->item->modelo1);?></div>
<?php else:?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloPrincipal"></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloPrincipal"></div>
<?php endif;?>	
					</div>
<?php endif;
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$this->item->id_modelo_secundaria.':ico');?>
				</div>
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Segunda Modelo</h5>				
					<input type="hidden" name="id_modelo_secundaria" id="id_modelo_secundaria"  value="<?php echo $this->item->id_modelo_secundaria;?>"/>
					<a href="JavaScript: BuscarModelo('id_modelo_secundaria','nomeModeloSecundaria','fotoModeloSecundaria');" class="btn">Selecionar Modelo
					 <span class="glyphicon glyphicon-user"></span></a>
					<div id="dadosModeloPricipal" class="row" style="text-align: center">
<?php if(isset($this->item->id_modelo_secundaria) && $this->item->id_modelo_secundaria!=0):?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloSecundaria"><img src="<?php echo($urlImg);?>" title="Modelo <?php echo($this->item->modelo2);?>" alt="Modelo <?php echo($this->item->modelo12);?>" class="img-circle" style="height: 100px"/></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloSecundaria"><?php echo($this->item->modelo2);?></div>
<?php else:?>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoModeloSecundaria"></div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeModeloSecundaria"></div>
<?php endif;?>
					</div>
				</div>
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Fotografo Principal</h5>				
<?php if((!isset($this->item->id_fotografo_principal) || $this->item->id_fotografo_principal==0) && $perfil->tipo=="FOTOGRAFO"):
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$perfil->id.':ico');
?>		
					<input type="hidden" name="id_fotografo_principal" id="id_fotografo_principal"  value="<?php echo $perfil->id;?>"/>
					<div id="dadosFotografoPricipal" class="row" style="text-align: center">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoPrincipal">
						<img src="<?php echo($urlImg);?>" title="Fotografo <?php echo($perfil->apelido);?>" alt="Fotografo <?php echo($perfil->apelido);?>" class="img-circle"  style="height: 100px"/>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="nomeFotografoPrincipal"><?php echo($perfil->apelido);?></div>
					</div>
<?php else:?>
					<input type="hidden" name="id_fotografo_principal" id="id_fotografo_principal"  value="<?php echo $this->item->id_fotografo_principal;?>"/>
					<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarTema',false));?>" class="btn">Selecionar Fotografo
					 <span class="glyphicon glyphicon-user"></span></a>
					<div id="dadosFotografoPricipal" class="row" style="text-align: center">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoPrincipal"></div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeFotografoPrincipal"></div>
					</div>
<?php endif;?>
				</div>
				<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3" style="text-align: center">
					<h5 calss="text-center">Segundo Fotografo/Assistente</h5>				
					<input type="hidden" name="id_fotografo_secundario" id="id_fotografo_secundario"  value="<?php echo $this->item->id_fotografo_secundario;?>"/>
					<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarTema',false));?>" class="btn">Selecionar Fotografo/Assistente 
					 <span class="glyphicon glyphicon-user"></span></a>
					<div id="dadosFotografoPricipal" class="row">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="fotoFotografoSecundaria"></div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="nomeFotografoSecundaria"></div>
					</div>
				</div>
				
			</div>
			<br/>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label"  for="descricao"><strong>Descri&ccedil;&atilde;o da sess&atilde;o</strong></label>
		    	<?php echo $editor->display('descricao', $this->item->descricao, '200', '200', '20', '20', false, $params); ?>
			</div>   
			 
		</div>
		<div id="publicarFotos" class="tab-pane fade in" style="height: 210px;">
			<h2>Publicar fotos</h2>
			
	    </div>
	</div>
</form>
<?php if(isset($this->item) && $this->item->id != 0) :?>
<h2>Fotos</h2>
<div class="row"  id="linha">
	<?php
	$count = 0;
	foreach($fotos as $foto): 
		$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':foto-sensual-'.strtolower(str_replace(" ","-",$foto->titulo))); 
		$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->id.':'.$conteudo->id.'-thumbnail'); ?>
		<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
    		<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" /></a>
    	</div>
	<?php
	endforeach; 
	?>
</div>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>
<?php endif;?>
<script>
var lidos = <?php echo(sizeof($fotos));?>;
var carregando = false;
var temMais=false;


function BuscarModelo(idCampo, idDivNome, idDivImagem){
	var url = "<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=buscarModeloModal',false));?>";
	url = url + (url.indexOf('?')>0?'&':'?') + 'campo='+idCampo+'&divNome='+idDivNome+'&divImagem='+idDivImagem;
	AngelGirls.FrameModal("Selecionar modelo",url , "<?php echo JText::_('Buscar'); ?> <span class='glyphicon glyphicon-search' aria-hidden='true'></span>", 
			"JavaScript: $('#iFrameModal').contents().find('#dadosFormBuscarModelo').submit();",350);
}

jQuery(document).ready(function() {


	
	jQuery('#tema').change(function(){
		if(jQuery('#tema option:selected').val()=='NOVO'){
			jQuery('#tema').val('');
			AngelGirls.FrameModal("Cadastrar Novo Temas", "<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarTema',false));?>", "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormTema').submit();",270);
		}
	});

	jQuery('#locacao').change(function(){
		if(jQuery('#locacao option:selected').val()=='NOVO'){
			jQuery('#locacao').val('');
			AngelGirls.FrameModal("Cadastrar Nova Loca&ccedil;&atilde;o", "<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarLocacao',false));?>", "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormLocacao').submit();",350);
		}
	});

	jQuery('#id_figurino_principal').change(function(){
		if(jQuery('#id_figurino_principal option:selected').val()=='NOVO'){
			jQuery('#id_figurino_principal').val('');
			var url = "<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarFigurino',false));?>";
			url = url +  (url.indexOf('?')>0?'&campo=id_figurino_principal':'?campo=id_figurino_principal');
			AngelGirls.FrameModal("Cadastrar Novo Figurino", url, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormFigurino').submit();",270);
		}
	});
	jQuery('#id_figurino_secundario').change(function(){
		if(jQuery('#id_figurino_secundario option:selected').val()=='NOVO'){
			jQuery('#id_figurino_secundario').val('');
			var url = "<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarCadastrarFigurino',false));?>";
			url = url +  (url.indexOf('?')>0?'&campo=id_figurino_secundario':'?campo=id_figurino_secundario');
			AngelGirls.FrameModal("Cadastrar Novo Figurino", url, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormFigurino').submit();",270);
		}
	});

	
	if(lidos>=24){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}


	


	
	
	jQuery(document).scroll(function(){
		 if( (jQuery(window).height()+jQuery(this).scrollTop()+300) >= jQuery(document).height() && !carregando && temMais) {
			carregando = true;
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFotosContinuaHtml&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false)); ?>',
					{posicao: lidos}, function(dado){
				jQuery("#carregando").css("display","none");
				if(dado.length<=0){
					jQuery("#carregando").css("display","none");
					temMais=false;
				}
				else{
					//lidos = lidos+24;
					jQuery('#carregando').css('display','');
					jQuery('#linha').append(dado);
				}		
				carregando=false;					
			},'html');
		 }
	});
});
</script>
