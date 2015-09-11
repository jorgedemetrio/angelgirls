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
//JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.formvalidator');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.keepalive');


$editor = JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');

$this->item = JRequest::getVar('fotografo');

$cidades = JRequest::getVar('cidades');
$ufs = JRequest::getVar('ufs');




$scriptCidades =' var cidades = new Array(); ';
$indexId = 0;
if(isset($cidades)){
	foreach ($cidades as $cidade){
		$scriptCidades = $scriptCidades . 'cidades['.($indexId).'] = new Object();';
		$scriptCidades = $scriptCidades . 'cidades['.($indexId).'].nome = "'.$cidade->nome.'";';
		$scriptCidades = $scriptCidades . 'cidades['.($indexId).'].uf = "'.$cidade->uf.'";';
		$scriptCidades = $scriptCidades . 'cidades['.($indexId).'].id = "'.$cidade->id.'";';
		$indexId++;
	}
}

$imagemRosto = ( isset($this->item->foto_perfil) && $this->item->foto_perfil!=null && $this->item->foto_perfil!=""  ? JURI::base( true ) . '/../images/fotografos/'. $this->item->foto_perfil : JURI::base( true ).'/components/com_angelgirls/no_image.png');

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
		}


		#ifoto_perfil:hover {
		    cursor: pointer;
		}
');

JFactory::getDocument()->addScriptDeclaration(
	$scriptCidades.'
	jQuery(document).ready(function(){
		document.formvalidator.setHandler("telefone", function(value) {
	      regex=/^\(\d{2}\)\s\d{5}\-\d{3,4}$/;
		  //RODAR AJAX PARA VER SE � UNICO
	      return regex.test(value);
		});
		
		document.formvalidator.setHandler("cep", function(value) {
		      regex=/^\d{5}-\d{3}$/;
		      return regex.test(value);
			});
				
		
		document.formvalidator.setHandler("cpf", function(value) {
	      regex=/^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
		  //RODAR AJAX PARA VER SE � UNICO
	      return regex.test(value) && TestaCPF(value.replace(".","").replace(".","").replace("-",""));
		});
			
		document.formvalidator.setHandler("data", function(value) {
	      regex=/^\d{2}\/\d{2}\/\d{4}$/;
	      return regex.test(value);
		});
			
		document.formvalidator.setHandler("inteiro", function(value) {
	      regex=/^\d*$/;
	      return regex.test(value);
		});
			
		document.formvalidator.setHandler("usuariounico", function(value) {
		  //RODAR AJAX PARA VER SE � UNICO
	      return true;
		});
		
	    document.formvalidator.setHandler("passverify", function (value) {
	        return ($("password").val() == value); 
	    });
	    document.formvalidator.setHandler("emailverify", function (value) {
	        return ($("email").val() == value); 
	    });							
		jQuery("#ifoto_perfil").click(function(){
			jQuery("#foto_perfil").click();
		});
		jQuery("#foto_perfil").change(function(){
			var valor = jQuery("#foto_perfil").val();
			var valorAntigo = "'.$imagemRosto.'"
			//jQuery("#ifoto_perfil").attr("src",valor!="" ? valor :valorAntigo );
		});
	});
					
	function TestaCPF(strCPF) { var Soma; var Resto; Soma = 0; if (strCPF == "00000000000") return false; for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(9, 10)) ) return false; Soma = 0; for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false; return true; }'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
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
	<h1><?php if( isset($this->item) && isset($this->item->id)) : ?>
		<?php echo JText::_('Seus dados'); ?>
	<?php else : ?>
		<?php echo JText::_('Formul&aacute;rio de cadastro para fotografos'); ?>
	<?php endif ?></h1>


	<br/>
	<br/>
    <div class="clr"></div>
	<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
		<li class="active" role="presentation">
			<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Dados B&aacute;sico
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a>
		</li>
		<?php if( isset($this->item) && isset($this->item->id)) : ?>
			<li role="presentation">
				<a href="#redesSociais" data-toggle="tab">Redes Sociais
				<span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
			</li>
			<li role="presentation">
				<a href="#enderecos" data-toggle="tab">Endere&ccedil;os
				<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
			</li>
			<li role="presentation">
				<a href="#contatos" data-toggle="tab">Contatos
				<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
			</li>

		<?php endif; ?>
	</ul>
	<div class="tab-content" style="overflow: auto;">
		<div id="general" class="tab-pane fade in active">
			<h2><?php echo JText::_('Fotografo'); ?></h2>
			<?php if( $this->item ==null || $this->item->id == null || $this->item->id == 0 || $this->item->id =='' ) :?>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label class="control-label"  for="termos"><?php echo JText::_('Declaro que li e concordo com todos os termos e condi&ccedil;&otilde;es para realizar o cadastro.'); ?><a href="#"><small>Clique aqui para ler os termos e condi&ccedil;&otilde;es.</small></a></label>
				<input type="checkbox" value="S" name="termos" id="termos" class="form-control required"/>
				<small>OBS: Ter o cadastro enviado n&atilde;o o torna fotografo oficial da Angel Girls. <br/>A Angel Girls n&atilde;o autoriza a divulga&ccedil;&atilde;o como um fotografo oficial ou como represente da Angel Girls apenas tendo o cadastro aprovado, leia os termos para entender como funciona.</small>
			</div>
			 <?php endif?>
			<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-2"><label class="control-label"  for="foto_perfil"> <?php echo JText::_('Foto perfil'); ?></label></div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-2">
					<img src="<?php echo($imagemRosto);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_perfil" name="ifoto_perfil" class="img-thumbnail" style="width:200px;"/>
					<input style="width: 250px;" type="file"  class="form-control required" name="foto_perfil" id="foto_perfil" accept="image/*"/><br/></div>
				<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-10">
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label class="control-label"  for="name"><?php echo JText::_('Nome Completo'); ?></label>
						<input class="required form-control" style="width: 90%;" type="text" name="name"  id="name" size="32" maxlength="250" value="<?php echo $this->item->name;?>"  placeholder="<?php echo JText::_('Nome Completo'); ?>"/>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label class="control-label"  for="nome_artistico"> <?php echo JText::_('Apelido/Nome Artistico'); ?></label>
						<input class="required form-control" style="width: 90%;" type="text" name="nome_artistico"  id="nome_artistico" size="32" maxlength="150" value="<?php echo $this->item->nome_artistico;?>" placeholder="<?php echo JText::_('Apelido/Nome Artistico'); ?>"/>
					</div>
				</div>
			</div>
			<div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="meta_descricao"><?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?></label>
					<textarea class="required form-control" style="width: 90%;" rows="8" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o r&aacute;pida sobre voc&ecirc;. Evite muitos caractes especiais e enteres, com at&eacute; 250 caracteres.'); ?>"><?php echo $this->item->meta_descricao;?></textarea>
				</div>
				<?php if( $this->item ==null || $this->item->id == null || $this->item->id == 0 || $this->item->id =='' ) :?>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="telefone"><?php echo JText::_('Telefone'); ?></label>
					<input class="form-control required validate-telefone" style="width: 90%;" type="text" name="telefone"  id="telefone" size="32" maxlength="25" placeholder="<?php echo JText::_('(11) 99000-0000'); ?>"/>
				</div>
				<?php endif ?>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="username"><?php echo JText::_('Usu&aacute;rio'); ?></label>
					<input class="form-control required validate-username validate-usuariounico" style="width: 90%;" type="text" name="username"  id="username" size="32" maxlength="25" value="<?php echo $this->item->username;?>" 
					<?php if($this->item->id !=null && $this->item->id != 0 && $this->item->id !='' ) :?>
					 	readonly="readonly"
					<?php else : ?>
						placeholder="<?php echo JText::_('Usu&aacute;rio'); ?>"
					<?php endif ?>/>
				</div>
				<?php if( $this->item ==null || $this->item->id == null || $this->item->id == 0 || $this->item->id =='' ) :?>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password"><?php echo JText::_('Senha'); ?></label>
					<input class="form-control required validate-password" style="width: 90%;" type="password" name="password"  id="password" size="32" maxlength="25" placeholder="<?php echo JText::_('Senha'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="password1"><?php echo JText::_('Confirmar Senha'); ?></label>
					<input class="form-control required validate-password validate-passverify" style="width: 90%;" type="password" name="password1"  id="password1" size="32" maxlength="25" placeholder="<?php echo JText::_('Confirma&ccedil;&atilde;o de Senha'); ?>"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="email"> <?php echo JText::_('E-mail Principal'); ?></label>
					<input class="form-control required validate-email" style="width: 90%;" type="email" name="email"  id="email" size="32" maxlength="250" value="<?php echo $this->item->email;?>" placeholder="Email"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="control-label"  for="email1"> <?php echo JText::_('Confirmacao e-mail'); ?></label>
					<input class="form-control required validate-email  validate-emailverify" style="width: 90%;" type="email" name="email1"  id="email1" size="32" maxlength="250" placeholder="Email"/>
				</div>
				<?php endif ?>
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
						<input class="form-control" style="width: 90%;" type="text" name="site"  id="site" size="32" maxlength="250" value="<?php echo $this->item->site;?>" placeholder="<?php echo JText::_('www.meu-site-pessoa.com.br'); ?>"/>
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
					<label class="control-label"  for="cpf"> <?php echo JText::_('CPF'); ?></label>
					<input class="form-control required validate-cpf" style="width: 90%;" type="text" name="cpf"  id="cpf" size="32" maxlength="14" value="<?php echo $this->item->cpf;?>" placeholder="<?php echo JText::_('Digite um CPF v&aacute;lido'); ?>"/>
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
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="control-label"  for="descricao"> <?php echo JText::_('Fale um pouco sobre voc&ecirc;'); ?></label>
					<?php echo $editor->display('descricao', $this->item->descricao, '200', '200', '20', '20', false, $params); ?>
				</div>
			
				<?php
				if($this->item != null && $this->item->id != null){ 
				?>
				<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<label class="label control-label" ><?php echo JText::_('Criado por'); ?></label></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><label class="control-label" ><?php echo JText::_('Editado por'); ?></label></div>                
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><label class="control-label" ><?php echo JText::_('Criado'); ?></label></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><label class="control-label" ><?php echo JText::_('Editado'); ?></label></div>					
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><?php echo $this->item->criador;?></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><?php echo $this->item->editor;?></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><?php echo(JFactory::getDate($this->item->data_criado)->format('d/m/Y'));?></div>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"><?php echo(JFactory::getDate($this->item->data_alterado)->format('d/m/Y'));?></div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><label class="control-label"  for="id_edited_by"><?php echo JText::_('Gostaram'); ?></label></div>                
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><label class="control-label"  for="id_created_by"><?php echo JText::_('N&atilde;o Gostaram'); ?></label></div>
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><label class="control-label"  for="created_on"> <?php echo JText::_('Vizualizaram'); ?></label></div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php echo $this->item->audiencia_gostou;?></div>
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php echo $this->item->audiencia_ngostou;?></div>
					<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php echo($this->item->audiencia_view);?></div>
				</div>
				<?php 
				}?>
			</div>
		</div>
		<?php if( isset($this->item) && isset($this->item->id)){ ?>
		<div id="redesSociais" class="tab-pane fade">
			<h2><?php echo JText::_('Contatos Sociais'); ?></h2>
			<input type="hidden" name="id_rede_social" id="id_rede_social" value=""/>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<label class="control-label"  for="rede"> <?php echo JText::_('Rede'); ?></label>
				<select name="rede" id="rede" style="width: 90%;" class="form-control">
					<option></option>
					<option value="FACEBOOK" class="text-transform: capitalize;">FACEBOOK</option>
					<option value="VK" class="text-transform: capitalize;">VK</option>
					<option value="GOOGLE+" class="text-transform: capitalize;">GOOGLE+</option>
					<option value="YOUTUBE" class="text-transform: capitalize;">YOUTUBE</option>
					<option value="TUMBLR" class="text-transform: capitalize;">TUMBLR</option>
					<option value="INSTAGRAM" class="text-transform: capitalize;">INSTAGRAM</option>
					<option value="FLICKR" class="text-transform: capitalize;">FLICKR</option>
					<option value="VIMEO" class="text-transform: capitalize;">VIMEO</option>
					<option value="SG" class="text-transform: capitalize;">SG</option>
					<option value="OUTRA" class="text-transform: capitalize;">OUTRA</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<label class="control-label"  for="contato"> <?php echo JText::_('Contato'); ?></label>
				<input style="width: 90%;" class="form-control" type="text" name="contato" id="contato" size="32" maxlength="250" />
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<label class="control-label"  for="principal"> <?php echo JText::_('Principal'); ?></label>
				<input type="checkbox" class="form-control" name="principal" id="principal" value="S"/>
			</div>
			<div id="tableRedeSociais">
				<?php require_once 'tableRedeSociais.php';?>
			</div>
	    </div>
	    <div id="enderecos" class="tab-pane fade">
			<h2><?php echo JText::_('Endere&ccedil;os'); ?></h2>
		</div>
	    <div id="contatos" class="tab-pane fade">
			<h2><?php echo JText::_('Contatos'); ?></h2>
		</div>
		<?php 
		}?>
	</div>

    
    
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
    <input type="hidden" name="id_usuario" value="<?php echo $this->item->id_usuario; ?>" />
    <input type="hidden" name="task" value="salvarFotografo" />
</form>
<script>
	jQuery(document).ready(function(){
		//Redes Sociais
		jQuery('#adicionarRedeSocial').click(function(){
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&task=saveRedeSocial'));?>',{'id_usuario' : jQuery('#id_usuario').val(),
			rede_social: jQuery('#rede').val(),
			url_usuario: jQuery('#contato').val(),
			principal: jQuery('#principal:checked').length<=0?"N":"S"},function(dado){
				if(dado.ok='true'){
					jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&task=listaRedeSocialHTML'));?>', {'id_usuario' : jQuery('#id_usuario').val()},
							function(html){
								jQuery('#tableRedeSociais').html(html);
							}
							,'html');
				}
				else{
					alert('Erro ao salvar.');
				}
			},'json');
		});

		//Endereco
		jQuery('#adicionarRedeSocial').click(function(){
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&task=saveRedeSocial'));?>',{'id_usuario' : jQuery('#id_usuario').val(),
			rede_social: jQuery('#rede').val(),
			url_usuario: jQuery('#contato').val(),
			principal: jQuery('#principal:checked').length<=0?"N":"S"},function(dado){
				if(dado.ok='true'){
					jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&task=listaRedeSocialHTML'));?>', {'id_usuario' : jQuery('#id_usuario').val()},
							function(html){
								jQuery('#tableRedeSociais').html(html);
							}
							,'html');
				}
				else{
					alert('Erro ao salvar.');
				}
			},'json');
		});
	});
</script>