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
JHtml::_('dropdown.init');
//JHtml::_('behavior.keepalive');

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarPerfil&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$editor = JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');

$perfil = JRequest::getVar('perfil');

$this->item = $perfil; 

$ufs = JRequest::getVar('ufs');



//JFactory::getDocument()->addScript(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=scriptCidadeEstado&id=script.js'));

$imagemCorpo =  JURI::base( true ).'/components/com_angelgirls/no_image.png';
$imagemCorpo_horizontal =   JURI::base( true ).'/components/com_angelgirls/no_image.png';
$imagemRosto =  JURI::base( true ).'/components/com_angelgirls/no_image.png';

$imagemPerfil = JURI::base( true ).'/components/com_angelgirls/perfil.png';


JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/form.css');
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/cadastro_modelo.js');
JFactory::getDocument()->addStyleDeclaration('
.validate-numeric{
	text-align: right;
}
.validate-inteiro{
	text-align: right;
}
input[type=\'file\']{ 	
	opacity: 0;
	-moz-opacity: 0;
	filter: alpha(opacity = 0);
	position: absolute;
	z-index: -1; 
}');


 ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<?php echo JHtml::_('form.token'); ?>
	<?php 
	//echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	
	<div class="btn-group pull-right" role="group">
		<div class="btn-group" role="group">
			<button  class="btn btn-danger" type="button" onclick="JavaScript:window.history.back(-1);"><?php echo JText::_('Cancelar'); ?>
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
			<button  class="btn btn-success" type="submit"><?php echo JText::_('Salvar Cadastro'); ?>
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			</button>
		</div>
	</div>
	<h1><?php echo JText::_('Formul&aacute;rio de cadastro para novas modelos'); ?></h1>
			


	<br/>
	<br/>
    <div class="clr"></div>
	<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
		<li class="active" role="presentation">
			<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Dados B&aacute;sico
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a>
		</li>
<?php	if($this->item>tipo=='MODELO') : ?>
		<li role="presentation">
			<a href="#fotos" data-toggle="tab" aria-controls="profile" role="tab">Fotos
			<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
			</a>
		</li>
		<li role="presentation">
			<a href="#caracteristicas" data-toggle="tab">Caracteristicas F&iacute;sicas
			<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			</a>
		</li>
<?php 	endif;?>
		<li role="presentation">
			<a href="#caracteristicas" data-toggle="tab">Endere&ccedil;o
			<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
			</a>
		</li>
		<li role="presentation">
			<a href="#caracteristicas" data-toggle="tab">Telefones & E-mails
			<span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
			</a>
		</li>
		<li role="presentation">
			<a href="#caracteristicas" data-toggle="tab">Redes Sociais
			<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
			</a>
		</li>
	</ul>
	<div class="tab-content" style="overflow: auto;">
		<div id="general" class="tab-pane fade in active">
			<h2><?php echo JText::_('Dados da Modelo'); ?></h2>
			<div>
				<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6"">
					<label class="control-label"  for="name"><?php echo JText::_('Nome Completo'); ?></label>
					<input class="required form-control" style="width: 90%;" type="text" name="name"  id="name" size="32" maxlength="250" value="<?php echo $this->item->nome_completo;?>" title="<?php echo JText::_('Nome Completo'); ?>" placeholder="<?php echo JText::_('Nome Completo'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6"">
					<label class="control-label"  for="nome_artistico"><?php echo JText::_('Apelido/Nome Artistico'); ?></label>
					<input class="required form-control" style="width: 90%;" type="text" name="nome_artistico"  id="nome_artistico" size="32" maxlength="150" value="<?php echo $this->item->apelido;?>" title="<?php echo JText::_('Apelido/Nome Artistico'); ?>" placeholder="<?php echo JText::_('Apelido/Nome Artistico'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?></label>
					<textarea class="required form-control" style="width: 90%;" rows="8" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre voc&ecirc;. Evite muitos caractes especiais e enteres, com at&eacute; 250 caracteres.'); ?>"  title="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre voc&ecirc;. Evite muitos caractes especiais e enteres, com at&eacute; 250 caracteres.'); ?>"><?php echo $this->item->meta_descricao;?></textarea>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="username"><?php echo JText::_('Usu&aacute;rio'); ?></label>
					<input class="form-control required validate-username" style="width: 90%;" type="text" readonly name="username"  id="username" size="32" maxlength="25" value="<?php echo $this->item->usuario;?>" title="<?php echo JText::_('Usu&aacute;rio'); ?>" placeholder="<?php echo JText::_('Usu&aacute;rio'); ?>" />
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password"><?php echo JText::_('Trocar Senha'); ?></label>
					<input class="form-control required validate-password" style="width: 90%;" type="password" name="password"  id="password" size="32" maxlength="25" placeholder="<?php echo JText::_('Senha'); ?>" title="<?php echo JText::_('Senha'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password1"><?php echo JText::_('Confirmar Senha'); ?></label>
					<input class="form-control required validate-password validate-passverify" style="width: 90%;" type="password" name="password1"  id="password1" size="32" maxlength="25" placeholder="<?php echo JText::_('Confirma&ccedil;&atilde;o de Senha'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="data_nascimento"><?php echo JText::_('Data de Nascimento'); ?></label>
					<?php echo JHtml::calendar($this->item->data_nascimento, 'data_nascimento', 'data_nascimento', '%d/%m/%Y', 'class="form-control required validate-data"');?>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="nascionalidade"><?php echo JText::_('Nascionalidade'); ?></label>
					<input class="form-control required" style="width: 90%;" type="text" name="nascionalidade"  id="nascionalidade" size="32" maxlength="25" value="<?php echo $this->item->nascionalidade;?>" placeholder="<?php echo JText::_('Nascionalidade'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="site"><?php echo JText::_('Site'); ?></label>
					<div class="input-group">
      					<div class="input-group-addon">http://</div>
						<input class="form-control" style="width: 90%;" type="url" name="site"  id="site" size="32" maxlength="250" value="<?php echo $this->item->site;?>" placeholder="<?php echo JText::_('www.meu-site-pessoa.com.br'); ?>"/>
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="profissao"><?php echo JText::_('Profiss&atilde;o'); ?></label>
					<input class="form-control" style="width: 90%;" type="text" name="profissao"  id="profissao" size="32" maxlength="150" value="<?php echo $this->item->profissao;?>" placeholder="<?php echo JText::_('Profiss&atilde;o'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="sexo"><?php echo JText::_('Sexo'); ?></label>
					<select name="sexo" id="sexo" class="form-control required" style="width: 90%;" placeholder="<?php echo JText::_('Selecione um sexo'); ?>">
						<option></option>
						<option value="M"<?php echo($this->item->sexo=="M"?" selected":"");?>>Masculino</option>
						<option value="F"<?php echo($this->item->sexo=="F"?" selected":"");?>>Feminino</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="estado_reside"><?php echo JText::_('Estado Que Reside'); ?></label>
					<select name="estado_reside" id="estado_reside" class="form-control required estado" data-carregar="id_cidade" style="width: 90%;" placeholder="<?php echo JText::_('Selecione o estado que reside'); ?>">
						<option></option>
						<?php
						foreach ($ufs as $f){ 
						?>
						<option value="<?php echo($f->uf) ?>"><?php echo($f->uf) ?></option>
						<?php 
						}
						?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="id_cidade"><?php echo JText::_('Cidade Que Reside'); ?></label>
					<select name="id_cidade" id="id_cidade" class="form-control required" style="width: 90%;">
						<option></option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="estado_nasceu"><?php echo JText::_('Estado Que Nasceu'); ?></label>
					<select name="estado_nasceu" id="estado_nasceu" class="form-control required estado" data-carregar="id_cidade_nasceu" style="width: 90%;" placeholder="<?php echo JText::_('Selecione o estado que nasceu'); ?>">
						<option></option>
						<?php
						foreach ($ufs as $f){ 
						?>
						<option value="<?php echo($f->uf) ?>"><?php echo($f->uf) ?></option>
						<?php 
						}
						?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="id_cidade_nasceu"> <?php echo JText::_('Cidade Que Nasceu'); ?></label>
					<select name="id_cidade_nasceu" id="id_cidade_nasceu" class="form-control required" style="width: 90%;">
						<option></option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="cpf"> <?php echo JText::_('CPF'); ?></label>
					<input class="form-control required validate-cpf" style="width: 90%;" type="text" name="cpf"  id="cpf" size="32" maxlength="14" value="<?php echo $this->item->cpf;?>" placeholder="<?php echo JText::_('Digite um CPF v&aacute;lido'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="descricao"> <?php echo JText::_('Fale um pouco sobre voc&ecirc;'); ?></label>
					<?php echo $editor->display('descricao', $this->item->descricao, '200', '200', '20', '20', false, $params); ?>
				</div>
			</div>
		</div>
		<div id="fotos" class="tab-pane fade">
			<h2><?php echo JText::_('Fotos de perfil da Modelo'); ?></h2>
			<div class="row">
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center"><label class="control-label"  for="foto_perfil"> <?php echo JText::_('Foto rosto'); ?></label></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center"><label class="control-label"  for="foto_inteira"> <?php echo JText::_('Foto corpo'); ?></label></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center"><label class="control-label"  for="foto_inteira"> <?php echo JText::_('Foto corpo horizontal'); ?></label></div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center">
					<img src="<?php echo($imagemRosto);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_perfil" name="ifoto_perfil" class="img-thumbnail"/>
					<input style="width: 250px;" type="file" class="form-control required" name="foto_perfil" id="foto_perfil" accept="image/*"/></div>

				<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center">
					<img src="<?php echo($imagemCorpo);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_inteira" name="ifoto_inteira" class="img-thumbnail"/>
					<input style="width: 250px;" type="file" name="foto_inteira" id="foto_inteira" accept="image/*"/></div>					
					
				<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center">
					<img src="<?php echo($imagemCorpo);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_inteira_horizontal" name="ifoto_inteira_horizontal" class="img-thumbnail" />
					<input style="width: 250px;" type="file" name="foto_inteira_horizontal" id="foto_inteira_horizontal" accept="image/*"/></div>
			</div>
		</div>
		<div id="caracteristicas" class="tab-pane fade">
			<h2><?php echo JText::_('Caracteristicas F&iacute;sicas da Modelo'); ?></h2>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="altura"><?php echo JText::_('Altura'); ?></label>
				<input class="validate-numeric form-control required" style="width: 90%;" type="text" name="altura" id="altura" size="32" maxlength="6" value="<?php echo $this->item->altura;?>" placeholder="<?php echo JText::_('Sua altura em Metros com ","'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="peso"><?php echo JText::_('Peso'); ?></label>
				<input class="validate-inteiro form-control required" style="width: 90%;" type="text" name="peso" id="peso" size="32" maxlength="6" value="<?php echo $this->item->peso;?>"  placeholder="<?php echo JText::_('Seu peso em Kg com ","'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="busto"><?php echo JText::_('Busto'); ?></label>
				<input class="validate-inteiro form-control required" style="width: 90%;" type="text" name="busto" id="busto" size="32" maxlength="6" value="<?php echo $this->item->busto;?>" placeholder="<?php echo JText::_('O tamanho do seu busto ou numero da camisa'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="calsa"><?php echo JText::_('Calsa'); ?></label>
				<input class="validate-inteiro form-control required" style="width: 90%;" type="text" name="calsa" id="calsa" size="32" maxlength="6" value="<?php echo $this->item->calsa;?>" placeholder="<?php echo JText::_('O numero da calsa que usa'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="calsado"> <?php echo JText::_('Tamanho dos Calsados'); ?></label>
				<input class="validate-inteiro required" style="width: 90%;" type="text" name="calsado" id="calsado" size="32" maxlength="6" value="<?php echo $this->item->calsado;?>" placeholder="<?php echo JText::_('Tamanho do calsado (Tenis/Sapato).'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="olhos"> <?php echo JText::_('Olhos'); ?></label>
				<select name="olhos" id="olhos" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="NEGROS"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">NEGROS</option>
					<option value="AZUIS"<?php echo($this->item->olhos=="AZUIS"?" selected":"");?> class="text-transform: capitalize;">AZUIS</option>
					<option value="VERDES"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">VERDES</option>
					<option value="CASTANHOS"<?php echo($this->item->olhos=="CASTANHOS"?" selected":"");?> class="text-transform: capitalize;">CASTANHOS</option>
					<option value="MEL"<?php echo($this->item->olhos=="MEL"?" selected":"");?> class="text-transform: capitalize;">MEL</option>
					<option value="OUTRO"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="pele"> <?php echo JText::_('Pele'); ?></label>
				<select name="pele" id="pele" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="CALCASIANA"<?php echo($this->item->pele=="CALCASIANA"?" selected":"");?> class="text-transform: capitalize;">CALCASIANA</option>
					<option value="BRANCA"<?php echo($this->item->pele=="BRANCA"?" selected":"");?> class="text-transform: capitalize;">BRANCA</option>
					<option value="PARDA"<?php echo($this->item->pele=="PARDA"?" selected":"");?> class="text-transform: capitalize;">PARDA</option>
					<option value="MORENA"<?php echo($this->item->pele=="CALCASIANA"?" selected":"");?> class="text-transform: capitalize;">MORENA</option>
					<option value="NEGRA"<?php echo($this->item->pele=="NEGRA"?" selected":"");?> class="text-transform: capitalize;">NEGRA</option>
					<option value="AMARELA"<?php echo($this->item->pele=="AMARELA"?" selected":"");?> class="text-transform: capitalize;">AMARELA</option>
					<option value="OUTRO"<?php echo($this->item->pele=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="etinia"> <?php echo JText::_('Etinia'); ?></label>
				<select name="etinia" id="etinia" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="AZIATICA"<?php echo($this->item->etinia=="AZIATICA"?" selected":"");?> class="text-transform: capitalize;">AZIATICA</option>
					<option value="AFRO"<?php echo($this->item->etinia=="AFRO"?" selected":"");?> class="text-transform: capitalize;">AFRO</option>
					<option value="EURPEIA"<?php echo($this->item->etinia=="EURPEIA"?" selected":"");?> class="text-transform: capitalize;">EURPEIA</option>
					<option value="ORIENTAL"<?php echo($this->item->etinia=="ORIENTAL"?" selected":"");?> class="text-transform: capitalize;">ORIENTAL</option>
					<option value="LATINA"<?php echo($this->item->etinia=="LATINA"?" selected":"");?> class="text-transform: capitalize;">LATINA</option>
					<option value="OUTRO"<?php echo($this->item->etinia=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="cabelo"> <?php echo JText::_('Tipo de Cabelo'); ?></label>
				<select name="cabelo" id="cabelo" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="LIZO"<?php echo($this->item->cabelo=="LIZO"?" selected":"");?> class="text-transform: capitalize;">LIZO</option>
					<option value="ENCARACOLADO"<?php echo($this->item->cabelo=="ENCARACOLADO"?" selected":"");?> class="text-transform: capitalize;">ENCARACOLADO</option>
					<option value="CACHIADO"<?php echo($this->item->cabelo=="CACHIADO"?" selected":"");?> class="text-transform: capitalize;">CACHIADO</option>
					<option value="ONDULADOS"<?php echo($this->item->cabelo=="ONDULADOS"?" selected":"");?> class="text-transform: capitalize;">ONDULADOS</option>
					<option value="CRESPO"<?php echo($this->item->cabelo=="CRESPO"?" selected":"");?> class="text-transform: capitalize;">CRESPO</option>
					<option value="OUTRO"<?php echo($this->item->cabelo=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
					<option value="SEM"<?php echo($this->item->cabelo=="SEM"?" selected":"");?> class="text-transform: capitalize;">SEM</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="tamanho_cabelo"> <?php echo JText::_('Tamanho do Cabelo'); ?></label>
				<select name="tamanho_cabelo" id="tamanho_cabelo" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="MUITO CURTO"<?php echo($this->item->tamanho_cabelo=="MUITO CURTO"?" selected":"");?> class="text-transform: capitalize;">MUITO CURTO</option>
					<option value="CURTO"<?php echo($this->item->tamanho_cabelo=="CURTO"?" selected":"");?> class="text-transform: capitalize;">CURTO</option>
					<option value="MEDIO"<?php echo($this->item->tamanho_cabelo=="MEDIO"?" selected":"");?> class="text-transform: capitalize;">MEDIO</option>
					<option value="LONGO"<?php echo($this->item->tamanho_cabelo=="LONGO"?" selected":"");?> class="text-transform: capitalize;">LONGO</option>
					<option value="MUITO LONGO"<?php echo($this->item->tamanho_cabelo=="MUITO LONGO"?" selected":"");?> class="text-transform: capitalize;">MUITO LONGO</option>
					<option value="OUTRO"<?php echo($this->item->tamanho_cabelo=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
					<option value="SEM"<?php echo($this->item->tamanho_cabelo=="SEM"?" selected":"");?> class="text-transform: capitalize;">SEM</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label" for="cor_cabelo"> <?php echo JText::_('Cor do Cabelo'); ?></label>
				<select name="cor_cabelo" id="cor_cabelo" class="form-control required" style="width: 90%;">
					<option></option>
					<option value="BRANCO"<?php echo($this->item->cor_cabelo=="BRANCO"?" selected":"");?> class="text-transform: capitalize;">BRANCO</option>
					<option value="LOIRA CLARA"<?php echo($this->item->cor_cabelo=="LOIRA CLARA"?" selected":"");?> class="text-transform: capitalize;">LOIRA CLARA</option>
					<option value="LOIRA"<?php echo($this->item->cor_cabelo=="LOIRA"?" selected":"");?> class="text-transform: capitalize;">LOIRA</option>
					<option value="LOIRO ESCURO"<?php echo($this->item->cor_cabelo=="LOIRO ESCURO"?" selected":"");?> class="text-transform: capitalize;">LOIRO ESCURO</option>
					<option value="COLORIDO"<?php echo($this->item->cor_cabelo=="COLORIDO"?" selected":"");?> class="text-transform: capitalize;">COLORIDO</option>
					<option value="RUIVA"<?php echo($this->item->cor_cabelo=="RUIVA"?" selected":"");?> class="text-transform: capitalize;">RUIVA</option>
					<option value="CASTANHO"<?php echo($this->item->cor_cabelo=="CASTANHO"?" selected":"");?> class="text-transform: capitalize;">CASTANHO</option>
					<option value="NEGRO"<?php echo($this->item->cor_cabelo=="NEGRO"?" selected":"");?> class="text-transform: capitalize;">NEGRO</option>
					<option value="OUTRO"<?php echo($this->item->cor_cabelo=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label" for="profissao"> <?php echo JText::_('Se "Outra Cor" ou "Colorido", especifique a cor.'); ?></label>
				<input class="form-control " style="width: 90%;" type="text" name="outra_cor_cabelo" id="outra_cor_cabelo" size="32" maxlength="25" value="<?php echo $this->item->outra_cor_cabelo;?>" />
			</div>
	    </div>
	</div>
    <input type="hidden" name="option" value="com_angelgirls" />
    <?php	if($this->item>tipo=='MODELO') : ?>
    <input type="hidden" name="task" value="salvarModelo" />
    <?php	elseif($this->item>tipo=='FOTOGRAFO') : ?>
    <input type="hidden" name="task" value="salvarFotografo" />
    <?php	else : ?>
    <input type="hidden" name="task" value="salvarVisitante" />
    <?php endif; ?>
</form>
