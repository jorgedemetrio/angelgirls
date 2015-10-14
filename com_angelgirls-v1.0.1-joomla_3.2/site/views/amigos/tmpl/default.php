<?php

/**
 * Agendas HTML Default Template
 *
 * PHP versions 5
 *
 * @category  Template
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');
//JHtml::_('dropdown.init');
//JHtml::_('behavior.keepalive');

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&view=perfil&task=amigos&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}



$amigos = JRequest::getVar('amigos');
$perfil = JRequest::getVar('perfil');
$perfil = JRequest::getVar('perfil');
$perfil = JRequest::getVar('perfil');

$this->item = $perfil; 

$ufs = JRequest::getVar('ufs');






JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/form.css');
JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css');


JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/amigos.js?v='.VERSAO_ANGELGIRLS);


//Mais informações da API em http://formvalidator.net/
JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js');
JFactory::getDocument()->addStyleDeclaration('
.validate-numeric{
	text-align: right;
}
.validate-inteiro{
	text-align: right;
}
');
JFactory::getDocument()->addScriptDeclaration('

var lidos = 0;
var carregando=false;
		
Amigos.AceitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=aceitarAmizade', false ) . '";
Amigos.RejeitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=rejeitarSolicitacaoAmizade', false ) . '";
Amigos.LoadAmigosURL = "' . JRoute::_('index.php?option=com_angelgirls&view=amigos&task=AmigosHTML',false).'";
');

 ?>
<script>

</script>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
			<div class="page-header">
				<h1><?php echo JText::_('Amigos'); ?></h1>
			</div>	
			<br/>
			<br/>
		    <div class="clr"></div>
			<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
				<li class="active" role="presentation">
					<a href="#amigos" data-toggle="tab" aria-controls="profile" role="tab">Meus Amigos
					<span class="glyphicon glyphicon-user" aria-hidden="true" title="Amigos"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#buscar" data-toggle="tab" aria-controls="profile" role="tab">Buscar
					<span class="glyphicon glyphicon-search" aria-hidden="true" title="Fotos"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#solicitacoes" aria-controls="profile"  data-toggle="tab">Solicita&ccedil;&otilde;es
					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#convidar" aria-controls="profile"  data-toggle="tab">Convidar
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					</a>
				</li>
			</ul>
			<div class="tab-content" style="overflow: auto;">
				<div id="amigos" class="tab-pane fade in active">
					<h3><?php echo JText::_('Meus amigos'); ?></h3>
					<div class="row" id="listaAmigos">
<?php require_once 'lista_amigos.php';?>
					</div>
					<div class="row" id="carregandoAmigos" style="display: none">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
							<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
						</div>
					</div>
				</div>
				<div id="buscar" class="tab-pane fade">
					<h3><?php echo JText::_('Buscar amigos'); ?></h3>
					<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=buscarPerfilHtml')); ?> " method="post" name="dadosForm" id="dadosForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
						<?php echo JHtml::_('form.token'); ?>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="busca"><?php echo JText::_('Procura por:'); ?></label>
							<input class="form-control" style="width: 90%;" type="text" readonly name="busca"  id="busca" size="32" maxlength="25" title="<?php echo JText::_('Nome de quem deseja localizar'); ?>" placeholder="<?php echo JText::_('Nome de quem deseja localizar'); ?>" />
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="tipo"><?php echo JText::_('Tipo Perfil:'); ?></label>
							<select class="form-control"  name="tipo" id="tipo">
								<option>Todos</option>
								<option value="FOTOGRAFO">Fotografo</option>
								<option value="MODELO">Modelo</option>
								<option value="VISITANTE">Outro</option>
							</select>	
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="estado"><?php echo JText::_('Estado Que Reside'); ?></label>
							<select name="estado" id="estado" class="form-control estado" data-validation="required" required data-carregar="id_cidade" style="width: 90%;" placeholder="<?php echo JText::_('Selecione o estado que reside'); ?>">
								<option></option>
								<?php
								foreach ($ufs as $f){ 
								?>
								<option value="<?php echo($f->uf) ?>"><?php echo($f->nome) ?></option>
								<?php 
								}
								?>
							</select>
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="id_cidade"><?php echo JText::_('Cidade Que Reside'); ?></label>
							<select name="id_cidade" id="id_cidade" data-value="<?php echo($this->item->id_cidade);?>" class="form-control" data-validation="required" required style="width: 90%;">
								<option></option>
							</select>
						</div>
						<div class="btn-toolbar pull-right" role="group">
							<div class="btn-group" role="group">
								<button  class="btn btn-default ajuda"  type="button">
									Dicas e Sujest&otilde;es <span class="glyphicon glyphicon-question-sign"></span>
								</button>
								<button  class="btn btn-default"  type="button">
									Termos e Condi&ccedil;&otilde;es <span class="glyphicon glyphicon-paperclip"></span>
								</button>
							</div>
						
							<div class="btn-group" role="group">
								<button  class="btn" type="button" onclick="JavaScript:window.history.back(-1);"><span class="hidden-phone"><?php echo JText::_('Cancelar'); ?></span>
								</button>
								<button  class="btn btn-success" type="submit"><span class="hidden-phone">Salvar<span class="hidden-tablet"> Cadastro</span></span>
									<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								</button>
							</div>
						</div>
					</form>
					<div class="row" id="listaResultado">

					</div>
				</div>
			    <div id="solicitacoes" class="tab-pane fade">
			    	<h3><?php echo JText::_('Solicita&ccedil;&otilde;es de amizade'); ?></h3>
<?php require_once 'lista_solicitacoes.php';?>
					</div>
					<div class="row" id="carregandoAmigos" style="display: none">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
							<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
						</div>
					</div>
			    </div>
			    <div id="convidar" class="tab-pane fade">
			    	<h3><?php echo JText::_('Convidar para entrar no Angel Girls'); ?></h3>
			    </div>
			</div>
	</div>
</div>


