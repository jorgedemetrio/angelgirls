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
									<label class="control-label"><?php echo JText::_('Olhos'); ?></label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosNegros" value="NEGROS"/> <label for="olhosNegros">Negros</label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosAzuis" value="AZUIS"/> <label for="olhosAzuis">Azuis</label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosVerdes" value="VERDES"/> <label for="olhosVerdes">Verdes</label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosCastanhos" value="CASTANHOS"/> <label for="olhosCastanhos">CASTANHOS</label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosMel" value="MEL"/> <label for="olhosMel">Mel/Castanho Claros</label>
									<input type="checkbox" class="form-control" name="olhos[]" id="olhosOutros" value="OUTRO"/> <label for="olhosOutros">Outros</label>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Pele'); ?></label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleCalcasiana" value="CALCASIANA"/> <label for="peleCalcasiana">Calcasiana</label> 
									<input type="checkbox" class="form-control" name="pele[]" id="peleBranca" value="BRANCA"/> <label for="peleBranca">Branca</label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleParda" value="PARDA"/> <label for="peleParda">Parda</label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleMorena" value="MORENA"/> <label for="peleMorena">Morena</label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleNegra" value="NEGRA"/> <label for="peleNegra">Negra</label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleAmarela" value="AMARELA"/> <label for="peleAmarela">Amarela</label>
									<input type="checkbox" class="form-control" name="pele[]" id="peleOutro" value="OUTRO"/> <label for="peleOutro">Outro</label>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Etinia'); ?></label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaAziatica" value="AZIATICA"/> <label for="etiniaAziatica">Calcasiana</label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaAfro" value="AFRO"/> <label for="etiniaAfro">Afro</label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaEuropeia" value="EURPEIA"/> <label for="etiniaEuropeia">Europeia</label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaOriental" value="ORIENTAL"/> <label for="etiniaOriental">Oriental</label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaLatina" value="LATINA" /> <label for="etiniaLatina">Latina</label>
									<input type="checkbox" class="form-control" name="etinia[]" id="etiniaOutro" value="OUTRO"/> <label for="etiniaOutro">Outra</label>
								</div>
					
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Tipo de Cabelo'); ?></label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloLizo" value="LIZO"/> <label for="cabeloLizo">Lizo</label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloEncaracolado" value="ENCARACOLADO"/> <label for="cabeloEncaracolado">Encaracolado</label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloCachiado" value="CACHIADO"/> <label for="cabeloCachiado">Cachiado</label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloOndulado" value="ONDULADOS"/> <label for="cabeloOndulado">Ondulado</label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloCrespo" value="CRESPO"/> <label for="cabeloCrespo">Crespo</label>
									<input type="checkbox" class="form-control" name="cabelo[]" id="cabeloOutro" value="OUTRO"/> <label for="cabeloOutro">Outro Tipo</label>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label"> <?php echo JText::_('Tamanho do Cabelo'); ?></label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoCabeloMuitoCurto" value="MUITO CURTO"/> <label for="tamanhoCabeloMuitoCurto">Muito Curto</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoCurto" value="CURTO"/> <label for="tamanhoCurto">Curto</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoMedio" value="MEDIO"/> <label for="tamanhoMedio">Medio</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoLongo" value="LONGO"/> <label for="tamanhoLongo">Longo</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoMuitoLongo" value="MUITO LONGO"/> <label for="tamanhoMuitoLongo">Muito Longo</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoOutro" value="OUTRO"/> <label for="tamanhoOutro">Outro</label>
									<input type="checkbox" class="form-control" name="tamanho_cabelo[]" id="tamanhoSem" value="SEM"/> <label for="tamanhoSem">Sem cabelo</label>
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
									<label class="control-label" for="cor_cabelo"> <?php echo JText::_('Cor do Cabelo'); ?></label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloBranco" value="BRANCO"/> <label for="corCabeloBranco">Branco</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloLoiroClaro" value="LOIRA CLARA"/> <label for="corCabeloLoiroClaro">Loiro Claro</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloLoira" value="LOIRA"/> <label for="corCabeloLoira">Loiro</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corcabeloLoiroEscuro" value="LOIRO ESCURO"/> <label for="corcabeloLoiroEscuro">Loiro Escuro</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloColorido" value="COLORIDO"/> <label for="corCabeloColorido">Colorido</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloRuivo" value="RUIVA"/> <label for="corCabeloRuivo">Ruivo</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloCastanho" value="CASTANHO"/> <label for="corCabeloCastanho">Castanho</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloNegro" value="NEGRO"/> <label for="corCabeloNegro">Negro</label>
									<input type="checkbox" class="form-control" name="cor_cabelo[]" id="corCabeloOutro" value="OUTRO"/> <label for="corCabeloOutro">Outros</label>
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


