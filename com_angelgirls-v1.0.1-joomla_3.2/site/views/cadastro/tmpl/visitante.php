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


$editor = JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');

$this->item = JRequest::getVar('visitante');

$cidades = JRequest::getVar('cidades');
$ufs = JRequest::getVar('ufs');




//JFactory::getDocument()->addScript(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=scriptCidadeEstado&id=script.js'));

$imagemRosto = JURI::base( true ).'/components/com_angelgirls/no_image.png';
$imagemPerfil = JURI::base( true ).'/components/com_angelgirls/perfil.png';

JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/form.css');
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
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/cadastro_visitante.js');

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
	<h1><?php echo JText::_('Formul&aacute;rio de cadastro para usu&aacute;rio VIP'); ?></h1>


	<br/>
	<br/>
    <div class="clr"></div>
	<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
		<li class="active" role="presentation">
			<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Dados B&aacute;sico
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a>
		</li>
	</ul>
	<div class="tab-content" style="overflow: auto;">
		<div id="general" class="tab-pane fade in active">
			<h2><?php echo JText::_('Dados do usu&aacute;rio'); ?></h2>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label"  for="termos"><?php echo JText::_('Declaro que li e concordo com todos os termos e condi&ccedil;&otilde;es para realizar o cadastro.'); ?><a href="#"><small>Clique aqui para ler os termos e condi&ccedil;&otilde;es.</small></a></label>
				<input type="checkbox" value="S" name="termos" id="termos" class="form-control required" required/>
			</div>
			<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-2"><label class="control-label"  for="foto_perfil"> <?php echo JText::_('Foto perfil'); ?></label></div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-2">
					<img src="<?php echo($imagemRosto);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_perfil" name="ifoto_perfil" class="img-thumbnail" style="width:200px;"/>
					<input style="width: 250px;" type="file"  class="form-control required" name="foto_perfil" id="foto_perfil" accept="image/*" required/><br/></div>
				<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-10">
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label class="control-label"  for="name"><?php echo JText::_('Nome Completo'); ?></label>
						<input class="required form-control" style="width: 90%;" type="text" name="name"  id="name" size="32" maxlength="250" value="<?php echo JRequest::getVar('name');?>"  placeholder="<?php echo JText::_('Nome Completo'); ?>"  required/>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label class="control-label"  for="nome_artistico"> <?php echo JText::_('Apelido/Nome Artistico'); ?></label>
						<input class="required form-control" style="width: 90%;" type="text" name="nome_artistico"  id="nome_artistico" size="32" maxlength="150" value="<?php echo JRequest::getVar('nome_artistico');?>" placeholder="<?php echo JText::_('Apelido/Nome Artistico'); ?>" required/>
					</div>
				</div>
			</div>
			<div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?></label>
					<textarea class="required form-control" style="width: 90%;" rows="8" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre voc&ecirc;. Evite muitos caractes especiais e enteres, com at&eacute; 250 caracteres.'); ?>" required><?php echo JRequest::getVar('meta_descricao');?></textarea>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="telefone"><?php echo JText::_('Telefone'); ?></label>
					<input class="form-control required validate-telefone" style="width: 90%;" type="text" name="telefone"   value="<?php echo JRequest::getVar('telefone');?>" id="telefone" size="32" maxlength="25" placeholder="<?php echo JText::_('(11) 99000-0000'); ?>" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="username"><?php echo JText::_('Usu&aacute;rio'); ?></label>
					<input class="form-control required validate-username" style="width: 90%;" type="text" name="username"  id="username" size="32" maxlength="25" value="<?php echo JRequest::getVar('username');?>" 
						placeholder="<?php echo JText::_('Usu&aacute;rio'); ?>" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password"><?php echo JText::_('Senha'); ?></label>
					<input class="form-control required validate-password" style="width: 90%;" type="password" name="password"  id="password" size="32" maxlength="25" placeholder="<?php echo JText::_('Senha'); ?>" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password1"><?php echo JText::_('Confirmar Senha'); ?></label>
					<input class="form-control required validate-password validate-passverify" style="width: 90%;" type="password" name="password1"  id="password1" size="32" maxlength="25" placeholder="<?php echo JText::_('Confirma&ccedil;&atilde;o de Senha'); ?>" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="email"> <?php echo JText::_('E-mail Principal'); ?></label>
					<input class="form-control required validate-email" style="width: 90%;" type="email" name="email"  id="email" size="32" maxlength="250" value="<?php echo JRequest::getVar('email');?>" placeholder="Email" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="email1"> <?php echo JText::_('Confirmacao e-mail'); ?></label>
					<input class="form-control required validate-email  validate-emailverify" style="width: 90%;" type="email" name="email1"  id="email1" value="<?php echo JRequest::getVar('email1');?>" size="32" maxlength="250" placeholder="Email" required/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="data_nascimento"><?php echo JText::_('Data de Nascimento'); ?></label>
					<?php echo JHtml::calendar(JRequest::getVar('dataAniversarioConvertida',null)!=null? JRequest::getVar('dataAniversarioConvertida')->format('Y-m-d'):'', 'data_nascimento', 'data_nascimento', '%d/%m/%Y', 'class="form-control required validate-data" required="required"');?>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="nascionalidade"><?php echo JText::_('Nascionalidade'); ?></label>
					<input class="form-control required" required style="width: 90%;" type="text" name="nascionalidade"  id="nascionalidade" size="32" maxlength="25" value="<?php echo JRequest::getVar('nascionalidade');?>" placeholder="<?php echo JText::_('Nascionalidade'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="site"><?php echo JText::_('Site'); ?></label>
					<div class="input-group">
      					<div class="input-group-addon">http://</div>
						<input class="form-control" style="width: 90%;" type="url" name="site"  id="site" size="32" maxlength="250" value="<?php echo JRequest::getVar('site');?>" placeholder="<?php echo JText::_('www.meu-site-pessoa.com.br'); ?>"/>
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="profissao"><?php echo JText::_('Profiss&atilde;o'); ?></label>
					<input class="form-control" style="width: 90%;" type="text" name="profissao"  id="profissao" size="32" maxlength="150" value="<?php echo JRequest::getVar('profissao');?>" placeholder="<?php echo JText::_('Profiss&atilde;o'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="sexo"><?php echo JText::_('Sexo'); ?></label>
					<select name="sexo" id="sexo" class="form-control required" required style="width: 90%;" placeholder="<?php echo JText::_('Selecione um sexo'); ?>">
						<option></option>
						<option value="M"<?php echo(JRequest::getVar('sexo')=="M"?" selected":"");?>>Masculino</option>
						<option value="F"<?php echo(JRequest::getVar('sexo')=="F"?" selected":"");?>>Feminino</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="cpf"> <?php echo JText::_('CPF'); ?></label>
					<input class="form-control required validate-cpf" required style="width: 90%;" type="text" name="cpf"  id="cpf" size="32" maxlength="14" value="<?php echo JRequest::getVar('cpf');?>" placeholder="<?php echo JText::_('Digite um CPF v&aacute;lido'); ?>"/>
				</div>

				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="estado_reside"><?php echo JText::_('Estado Que Reside'); ?></label>
					<select name="estado_reside" id="estado_reside" class="form-control required estado" required data-carregar="id_cidade" style="width: 90%;" placeholder="<?php echo JText::_('Selecione o estado que reside'); ?>">
						<option></option>
						<?php
						foreach ($ufs as $f){ 
						?>
						<option value="<?php echo($f->uf) ?>"<?php echo(JRequest::getVar('estado_reside')==$f->uf?" selected":"");?>><?php echo($f->nome) ?></option>
						<?php 
						}
						?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="id_cidade"><?php echo JText::_('Cidade Que Reside'); ?></label>
					<select name="id_cidade" id="id_cidade" class="form-control required" required style="width: 90%;">
						<option>Selecione um estado</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="estado_nasceu"><?php echo JText::_('Estado Que Nasceu'); ?></label>
					<select name="estado_nasceu" id="estado_nasceu" class="form-control required estado" required data-carregar="id_cidade_nasceu" style="width: 90%;" placeholder="<?php echo JText::_('Selecione o estado que nasceu'); ?>">
						<option></option>
						<?php
						foreach ($ufs as $f){ 
						?>
						<option value="<?php echo($f->uf) ?>"<?php echo(JRequest::getVar('estado_nasceu')==$f->uf?" selected":"");?>><?php echo($f->nome) ?></option>
						<?php 
						}
						?>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="id_cidade_nasceu"> <?php echo JText::_('Cidade Que Nasceu'); ?></label>
					<select name="id_cidade_nasceu" id="id_cidade_nasceu" class="form-control required" required style="width: 90%;">
						<option>Selecione um estado</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="descricao"> <?php echo JText::_('Fale um pouco sobre voc&ecirc;'); ?></label>
					<?php echo $editor->display('descricao', JRequest::getVar('descricao'), '200', '200', '20', '20', false, $params); ?>
				</div>
			</div>
		</div>
	</div>
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="salvarPerfil" />
	<input type="hidden" name="tipo" value="VISITANTE" />
</form>
