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

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&view=perfil&task=amigos&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$amigos = JRequest::getVar('amigos');
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
Amigos.URLBuscaPerfil = "'.JRoute::_('index.php?option=com_angelgirls&view=perfil&task=buscarPerfilHtml',false).'";');?>
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
							<input class="form-control required" required="required" minlength="3"  data-validation="required length" data-validation-length="min3" style="width: 90%;" type="text" name="busca"  id="busca" size="32" maxlength="250" title="<?php echo JText::_('Nome de quem deseja localizar'); ?>" placeholder="<?php echo JText::_('Nome de quem deseja localizar'); ?>" />
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
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<label class="control-label"  for="altura_inicial"><?php echo JText::_('Altura'); ?></label>
									<input class="validate-numeric form-control" style="width: 45%;" type="text" name="altura_inicial" id="altura_inicial" maxlength="4" placeholder="<?php echo JText::_('0,0'); ?>"/>
									<input class="validate-numeric form-control" style="width: 45%;" type="text" name="altura_final" id="altura_final"  maxlength="4" placeholder="<?php echo JText::_('M&aacute;xima'); ?>"/>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<label class="control-label"  for="peso_inicial"><?php echo JText::_('Peso'); ?></label>
									<input class="validate-inteiro form-control" style="width: 45%;" type="number" name="peso_inicial" id="peso_inicial" size="32" maxlength="3"  placeholder="<?php echo JText::_('0,0'); ?>"/>
									<input class="validate-inteiro form-control" style="width: 45%;" type="number" name="peso_final" id="peso_final" size="32" maxlength="3"  placeholder="<?php echo JText::_('M&aacute;ximo');?>"/>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
									<label class="control-label"  for="calsado"> <?php echo JText::_('Tamanho dos Calsados'); ?></label>
									<input class="validate-inteiro" style="width: 45%;" type="number" name="calsado_inicial" id="calsado_inicial" size="32" maxlength="2" placeholder="<?php echo JText::_('0'); ?>"/>
									<input class="validate-inteiro" style="width: 45%;" type="number" name="calsado_final" id="calsado_final" size="32" maxlength="2" placeholder="<?php echo JText::_('M&aacute;ximo'); ?>"/>
								</div>
								<div style="width: 99%; border-bottom: 1px solid #000; margin: 10px">&nbsp;<!-- SEPARADOR --></div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"><?php echo JText::_('Olhos'); ?></label>
									<div class="checkbox">
										<label for="olhosNegros"><input type="checkbox" name="olhos" id="olhosNegros" value="NEGROS"/> Negros</label>
										<label for="olhosAzuis"><input type="checkbox" name="olhos" id="olhosAzuis" value="AZUIS"/> Azuis</label>
										<label for="olhosVerdes"><input type="checkbox" name="olhos" id="olhosVerdes" value="VERDES"/> Verdes</label>
										<label for="olhosCastanhos"><input type="checkbox" name="olhos" id="olhosCastanhos" value="CASTANHOS"/> Castanhos</label>
										<label for="olhosMel"><input type="checkbox" name="olhos" id="olhosMel" value="MEL"/> Mel/Castanho Claros</label>
										<label for="olhosOutros"><input type="checkbox" name="olhos" id="olhosOutros" value="OUTRO"/> Outros</label>
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Pele'); ?></label>
									<div class="checkbox">
										<label for="peleCalcasiana"><input type="checkbox" name="pele" id="peleCalcasiana" value="CALCASIANA"/> Calcasiana</label> 
										<label for="peleBranca"><input type="checkbox" name="pele" id="peleBranca" value="BRANCA"/> Branca</label>
										<label for="peleParda"><input type="checkbox" name="pele" id="peleParda" value="PARDA"/> Parda</label>
										<label for="peleMorena"><input type="checkbox" name="pele" id="peleMorena" value="MORENA"/> Morena</label>
										<label for="peleNegra"><input type="checkbox" name="pele" id="peleNegra" value="NEGRA"/> Negra</label>
										<label for="peleAmarela"><input type="checkbox" name="pele" id="peleAmarela" value="AMARELA"/> Amarela</label>
										<label for="peleOutro"><input type="checkbox" name="pele" id="peleOutro" value="OUTRO"/> Outro</label>
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Etinia'); ?></label>
									<div class="checkbox">
										<label for="etiniaAziatica"><input type="checkbox" name="etinia" id="etiniaAziatica" value="AZIATICA"/> Calcasiana</label>
										<label for="etiniaAfro"><input type="checkbox" name="etinia" id="etiniaAfro" value="AFRO"/> Afro</label>
										<label for="etiniaEuropeia"><input type="checkbox" name="etinia" id="etiniaEuropeia" value="EURPEIA"/> Europeia</label>
										<label for="etiniaOriental"><input type="checkbox" name="etinia" id="etiniaOriental" value="ORIENTAL"/> Oriental</label>
										<label for="etiniaLatina"><input type="checkbox" name="etinia" id="etiniaLatina" value="LATINA" /> Latina</label>
										<label for="etiniaOutro"><input type="checkbox" name="etinia" id="etiniaOutro" value="OUTRO"/> Outra</label>
									</div>
								</div>
					
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Tipo de Cabelo'); ?></label>
									<div class="checkbox">
										<label for="cabeloLizo"><input type="checkbox" name="cabelo" id="cabeloLizo" value="LIZO"/> Lizo</label>
										<label for="cabeloEncaracolado"><input type="checkbox" name="cabelo" id="cabeloEncaracolado" value="ENCARACOLADO"/> Encaracolado</label>
										<label for="cabeloCachiado"><input type="checkbox" name="cabelo" id="cabeloCachiado" value="CACHIADO"/> Cachiado</label>
										<label for="cabeloOndulado"><input type="checkbox" name="cabelo" id="cabeloOndulado" value="ONDULADOS"/> Ondulado</label>
										<label for="cabeloCrespo"><input type="checkbox" name="cabelo" id="cabeloCrespo" value="CRESPO"/> Crespo</label>
										<label for="cabeloOutro"><input type="checkbox" name="cabelo" id="cabeloOutro" value="OUTRO"/> Outro Tipo</label>
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Tamanho do Cabelo'); ?></label>
									<div class="checkbox">
										<label for="tamanhoCabeloMuitoCurto"><input type="checkbox" name="tamanho_cabelo" id="tamanhoCabeloMuitoCurto" value="MUITO CURTO"/> Muito Curto</label>
										<label for="tamanhoCurto"><input type="checkbox" name="tamanho_cabelo" id="tamanhoCurto" value="CURTO"/> Curto</label>
										<label for="tamanhoMedio"><input type="checkbox" name="tamanho_cabelo" id="tamanhoMedio" value="MEDIO"/> Medio</label>
										<label for="tamanhoLongo"><input type="checkbox" name="tamanho_cabelo" id="tamanhoLongo" value="LONGO"/> Longo</label>
										<label for="tamanhoMuitoLongo"><input type="checkbox" name="tamanho_cabelo" id="tamanhoMuitoLongo" value="MUITO LONGO"/> Muito Longo</label>
										<label for="tamanhoOutro"><input type="checkbox" name="tamanho_cabelo" id="tamanhoOutro" value="OUTRO"/> Outro</label>
										<label for="tamanhoSem"><input type="checkbox" name="tamanho_cabelo" id="tamanhoSem" value="SEM"/> Sem cabelo</label>
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label" for="cor_cabelo"> <?php echo JText::_('Cor do Cabelo'); ?></label>
									<div class="checkbox">
										<label for="corCabeloBranco"><input type="checkbox" name="cor_cabelo" id="corCabeloBranco" value="BRANCO"/> Branco</label>
										<label for="corCabeloLoiroClaro"><input type="checkbox" name="cor_cabelo" id="corCabeloLoiroClaro" value="LOIRA CLARA"/> Loiro Claro</label>
										<label for="corCabeloLoira"><input type="checkbox" name="cor_cabelo" id="corCabeloLoira" value="LOIRA"/> Loiro</label>
										<label for="corcabeloLoiroEscuro"><input type="checkbox" name="cor_cabelo" id="corcabeloLoiroEscuro" value="LOIRO ESCURO"/> Loiro Escuro</label>
										<label for="corCabeloColorido"><input type="checkbox" name="cor_cabelo" id="corCabeloColorido" value="COLORIDO"/> Colorido</label>
										<label for="corCabeloRuivo"><input type="checkbox" name="cor_cabelo" id="corCabeloRuivo" value="RUIVA"/> Ruivo</label>
										<label for="corCabeloCastanho"><input type="checkbox" name="cor_cabelo" id="corCabeloCastanho" value="CASTANHO"/> Castanho</label>
										<label for="corCabeloNegro"><input type="checkbox" name="cor_cabelo" id="corCabeloNegro" value="NEGRO"/> Negro</label>
										<label for="corCabeloOutro"><input type="checkbox" name="cor_cabelo" id="corCabeloOutro" value="OUTRO"/> Outros</label>
									</div>
								</div>
							</div>
						</div>
						<div class="btn-toolbar pull-right" role="group">
							<div class="btn-group" role="group">
								<button  class="btn btn-success" type="submit" id="BuscarAmigos"><span class="hidden-phone">Buscar</span>
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


