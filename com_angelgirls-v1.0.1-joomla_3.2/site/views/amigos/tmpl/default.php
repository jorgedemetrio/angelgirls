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
jQuery(document).ready(function(){

	jQuery('#nivel').change(function(){
		jQuery('#nivelVal').html(
				jQuery('#nivel').val()==0?'Todos':jQuery('#nivel').val()); 
	});

	jQuery('#tipo').change(function(){
		if(jQuery('#tipo').val()=='MODELO'){
			jQuery('#extraModeloFiltros').css('display','none');
			jQuery('#iconeFiltroModelo').addClass('glyphicon-plus');
			jQuery('#iconeFiltroModelo').removeClass('glyphicon glyphicon-minus');
			jQuery('#extraModelo').fadeIn(500);
		}
	});
});

Amigos.ExibirModeloDetalhes = function (){	
	if(jQuery('#iconeFiltroModelo').hasClass('glyphicon-plus')){
		jQuery('#extraModeloFiltros').fadeIn(500);
		
		jQuery('#iconeFiltroModelo').removeClass('glyphicon-plus');
		jQuery('#iconeFiltroModelo').addClass('glyphicon glyphicon-minus');
	}
	else{
		jQuery('#extraModeloFiltros').fadeOut(500);
		jQuery('#iconeFiltroModelo').addClass('glyphicon-plus');
		jQuery('#iconeFiltroModelo').removeClass('glyphicon glyphicon-minus');
	}
};
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
					<a href="#buscar" data-toggle="tab" aria-controls="profile" role="tab">Procurar
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
					<h3><?php echo JText::_('Buscar'); ?></h3>
					<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=buscarPerfilHtml')); ?> " method="post" name="dadosForm" id="dadosForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
						<?php echo JHtml::_('form.token'); ?>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="busca"><?php echo JText::_('Procura por:'); ?></label>
							<input class="form-control" style="width: 90%;" type="text" name="busca"  id="busca" size="32" maxlength="25" title="<?php echo JText::_('Nome de quem deseja localizar'); ?>" placeholder="<?php echo JText::_('Nome de quem deseja localizar'); ?>" />
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
							<label class="control-label"  for="estado"><?php echo JText::_('Estado'); ?></label>
							<select name="estado" id="estado" class="form-control estado" data-carregar="id_cidade" style="width: 99%;">
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
							<label class="control-label"  for="id_cidade"><?php echo JText::_('Cidade'); ?></label>
							<select name="id_cidade" id="id_cidade" class="form-control" style="width: 99%;">
								<option></option>
							</select>
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="nivel"><?php echo JText::_('N&iacute;vel de experi&ecirc;ncia:'); ?> <span id="nivelVal">Todos</span> </label>
							<input class="form-control" style="width: 99%;" type="range" name="nivel"  id="nivel" value="0" min="0" max="10" title="<?php echo JText::_('N&iacute;vel do usu&aacute;rio'); ?>" placeholder="<?php echo JText::_('N&iacute;vel do usu&aacute;rio'); ?>" />
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="idade_init"><?php echo JText::_('Idade:'); ?> </label>
							<input class="form-control" style="width: 49%;" type="number" name="idade_init" value="18" id="idade_init" min="18" max="100" title="<?php echo JText::_('Idade inicial'); ?>" placeholder="<?php echo JText::_('18'); ?>" />
							<input class="form-control" style="width: 49%;" type="number" name="idade_fim"  id="idade_fim" min="18" max="100" title="<?php echo JText::_('Idade final'); ?>" placeholder="<?php echo JText::_('M&aacute;xima'); ?>" />
						</div>
						
						
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="pontos_init"><?php echo JText::_('Pontos:'); ?> </label>
							<input class="form-control" style="width: 49%;" type="number" name="pontos_init" id="pontos_init" title="<?php echo JText::_('Pontos'); ?>" placeholder="<?php echo JText::_('0'); ?>" />
							<input class="form-control" style="width: 49%;" type="number" name="pontos_fim"  id="pontos_fim" title="<?php echo JText::_('Pontos'); ?>" placeholder="<?php echo JText::_('M&aacute;ximo'); ?>" />
						</div>
						<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
							<label class="control-label"  for="sexo"><?php echo JText::_('Sexo'); ?></label>
							<select name="sexo" id="sexo" class="form-control" style="width: 90%;">
								<option></option>
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>
							</select>
						</div>
						
						
						<div id="extraModelo" style="display:none">
						<h4><a href="JavaScript: Amigos.ExibirModeloDetalhes(); "><?php echo JText::_('Filtros avan&ccedil;ado para modelo'); ?> <span class="glyphicon glyphicon-plus" id="iconeFiltroModelo"></span></a></h4>
							<div id="extraModeloFiltros" style="display:none">
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="altura_inicial"><?php echo JText::_('Altura'); ?></label>
									<input class="validate-numeric form-control" style="width: 45%;" type="text" name="altura_inicial" id="altura_inicial" maxlength="4" placeholder="<?php echo JText::_('0,0'); ?>"/>
									<input class="validate-numeric form-control" style="width: 45%;" type="text" name="altura_final" id="altura_final"  maxlength="4" placeholder="<?php echo JText::_('M&aacute;xima'); ?>"/>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="peso_inicial"><?php echo JText::_('Peso'); ?></label>
									<input class="validate-inteiro form-control" style="width: 45%;" type="number" name="peso_inicial" id="peso_inicial" size="32" maxlength="3"  placeholder="<?php echo JText::_('0,0'); ?>"/>
									<input class="validate-inteiro form-control" style="width: 45%;" type="number" name="peso_final" id="peso_final" size="32" maxlength="3"  placeholder="<?php echo JText::_('M&aacute;ximo');?>"/>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="calsado"> <?php echo JText::_('Tamanho dos Calsados'); ?></label>
									<input class="validate-inteiro" style="width: 45%;" type="number" name="calsado_inicial" id="calsado_inicial" size="32" maxlength="2" placeholder="<?php echo JText::_('0'); ?>"/>
									<input class="validate-inteiro" style="width: 45%;" type="number" name="calsado_final" id="calsado_final" size="32" maxlength="2" placeholder="<?php echo JText::_('M&aacute;ximo'); ?>"/>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="olhos"> <?php echo JText::_('Olhos'); ?></label>
									<select name="olhos" id="olhos" class="form-control" style="width: 90%;">
										<option></option>
										<option value="NEGROS" class="text-transform: capitalize;">NEGROS</option>
										<option value="AZUIS" class="text-transform: capitalize;">AZUIS</option>
										<option value="VERDES" class="text-transform: capitalize;">VERDES</option>
										<option value="CASTANHOS" class="text-transform: capitalize;">CASTANHOS</option>
										<option value="MEL" class="text-transform: capitalize;">MEL</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="pele"> <?php echo JText::_('Pele'); ?></label>
									<select name="pele" id="pele" class="form-control" style="width: 90%;">
										<option></option>
										<option value="CALCASIANA" class="text-transform: capitalize;">CALCASIANA</option>
										<option value="BRANCA" class="text-transform: capitalize;">BRANCA</option>
										<option value="PARDA" class="text-transform: capitalize;">PARDA</option>
										<option value="MORENA" class="text-transform: capitalize;">MORENA</option>
										<option value="NEGRA" class="text-transform: capitalize;">NEGRA</option>
										<option value="AMARELA" class="text-transform: capitalize;">AMARELA</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="etinia"> <?php echo JText::_('Etinia'); ?></label>
									<select name="etinia" id="etinia" class="form-control" style="width: 90%;">
										<option></option>
										<option value="AZIATICA" class="text-transform: capitalize;">AZIATICA</option>
										<option value="AFRO" class="text-transform: capitalize;">AFRO</option>
										<option value="EURPEIA" class="text-transform: capitalize;">EURPEIA</option>
										<option value="ORIENTAL" class="text-transform: capitalize;">ORIENTAL</option>
										<option value="LATINA" class="text-transform: capitalize;">LATINA</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
									</select>
								</div>
					
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="cabelo"> <?php echo JText::_('Tipo de Cabelo'); ?></label>
									<select name="cabelo" id="cabelo" class="form-control" style="width: 90%;">
										<option></option>
										<option value="LIZO" class="text-transform: capitalize;">LIZO</option>
										<option value="ENCARACOLADO" class="text-transform: capitalize;">ENCARACOLADO</option>
										<option value="CACHIADO" class="text-transform: capitalize;">CACHIADO</option>
										<option value="ONDULADOS" class="text-transform: capitalize;">ONDULADOS</option>
										<option value="CRESPO" class="text-transform: capitalize;">CRESPO</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
										<option value="SEM" class="text-transform: capitalize;">SEM</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"  for="tamanho_cabelo"> <?php echo JText::_('Tamanho do Cabelo'); ?></label>
									<select name="tamanho_cabelo" id="tamanho_cabelo" class="form-control" style="width: 90%;">
										<option></option>
										<option value="MUITO CURTO" class="text-transform: capitalize;">MUITO CURTO</option>
										<option value="CURTO" class="text-transform: capitalize;">CURTO</option>
										<option value="MEDIO" class="text-transform: capitalize;">MEDIO</option>
										<option value="LONGO"< class="text-transform: capitalize;">LONGO</option>
										<option value="MUITO LONGO" class="text-transform: capitalize;">MUITO LONGO</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
										<option value="SEM" class="text-transform: capitalize;">SEM</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label" for="cor_cabelo"> <?php echo JText::_('Cor do Cabelo'); ?></label>
									<select name="cor_cabelo" id="cor_cabelo" class="form-control" style="width: 90%;">
										<option></option>
										<option value="BRANCO" class="text-transform: capitalize;">BRANCO</option>
										<option value="LOIRA CLARA" class="text-transform: capitalize;">LOIRA CLARA</option>
										<option value="LOIRA" class="text-transform: capitalize;">LOIRA</option>
										<option value="LOIRO ESCURO" class="text-transform: capitalize;">LOIRO ESCURO</option>
										<option value="COLORIDO" class="text-transform: capitalize;">COLORIDO</option>
										<option value="RUIVA" class="text-transform: capitalize;">RUIVA</option>
										<option value="CASTANHO" class="text-transform: capitalize;">CASTANHO</option>
										<option value="NEGRO" class="text-transform: capitalize;">NEGRO</option>
										<option value="OUTRO" class="text-transform: capitalize;">OUTRO</option>
									</select>
								</div>
							</div>
						</div>
						<div class="btn-toolbar pull-right" role="group">
							<div class="btn-group" role="group">
								<button  class="btn btn-success" type="submit"><span class="hidden-phone">Buscar</span>
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
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


