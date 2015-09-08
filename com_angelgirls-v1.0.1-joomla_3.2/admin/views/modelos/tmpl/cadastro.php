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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
//JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.formvalidator');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.keepalive');


$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');

$this->item =& JRequest::getVar('modelo');

$cidades =& JRequest::getVar('cidades');
$ufs =& JRequest::getVar('ufs');


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

$imagemCorpo = ( isset($this->item->foto_inteira) && $this->item->foto_inteira!=null && $this->item->foto_inteira!=""  ? JURI::base( true ) . '/../images/modelos/'. $this->item->foto_inteira : JURI::base( true ).'/components/com_angelgirls/no_image.png');
$imagemRosto = ( isset($this->item->foto_perfil) && $this->item->foto_perfil!=null && $this->item->foto_perfil!=""  ? JURI::base( true ) . '/../images/modelos/'. $this->item->foto_perfil : JURI::base( true ).'/components/com_angelgirls/no_image.png');

JFactory::getDocument()->addStyleDeclaration('
		.validate-numeric{
			text-align: right;
		}
		.validate-inteiro{
			text-align: right;
		}
		label {
		    display: block;
		
		    margin-bottom: 5px;
		    color: darkblue;
		    font-weight: bold;
		}
		#foto_perfil { 	
			opacity: 0;
			-moz-opacity: 0;
			filter: alpha(opacity = 0);
			position: absolute;
			z-index: -1; } 
		#foto_inteira { 	
			opacity: 0;
			-moz-opacity: 0;
			filter: alpha(opacity = 0);
			position: absolute;
			z-index: -1; } 
		#ifoto_inteira:hover {
		    cursor: pointer;
		}
		#ifoto_perfil:hover {
		    cursor: pointer;
		}
');

JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/jquery.mask.min.js');
JFactory::getDocument()->addScriptDeclaration(
	$scriptCidades.'
	Joomla.submitbutton = function(task)
	{
		if (task == "listModelo" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
	jQuery(document).ready(function(){
	   
		document.formvalidator.setHandler("cep", function(value) {
	      regex=/^\d{5}-\d{3}$/;
	      return regex.test(value);
		});
			
		jQuery(".validate-numeric").mask("#.##0,00", {reverse: true});
		jQuery(".validate-inteiro").mask("9999999999999");
		jQuery(".validate-cep").mask("99999-999");
		jQuery(".validate-cpf").mask("999.999.999-99");
			
		jQuery(".validate-data").mask("99/99/9999", {placeholder: "__/__/____"});
		
		document.formvalidator.setHandler("cpf", function(value) {
	      regex=/^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
		  //RODAR AJAX PARA VER SE É UNICO
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
		  //RODAR AJAX PARA VER SE É UNICO
	      return true;
		});
		
	    document.formvalidator.setHandler("passverify", function (value) {
	        return ($("password").val() == value); 
	    });
	    document.formvalidator.setHandler("emailverify", function (value) {
	        return ($("email").val() == value); 
	    });		
			
			
			
		jQuery(".estado").change(function(){
			$objeto = jQuery(this);
			$ObjetoCidade = jQuery("#"+$objeto.attr("data-carregar"));
			$ObjetoCidade.empty();
			for(var i=0; i<cidades.length;i++){
				if(cidades[i].uf==$objeto.val()){
					$ObjetoCidade.append(new Option(  cidades[i].nome, cidades[i].id));
				}
			}
		});	
		
		jQuery("#ifoto_inteira").click(function(){
			jQuery("#foto_inteira").click();
		});
		jQuery("#foto_inteira").change(function(){
			var valor = jQuery("#foto_inteira").val();
			var valorAntigo = "'.$imagemCorpo.'"
			jQuery("#ifoto_inteira").attr("src",valor!="" ? valor :valorAntigo );
		});
					
		jQuery("#ifoto_perfil").click(function(){
			jQuery("#foto_perfil").click();
		});
		jQuery("#foto_perfil").change(function(){
			var valor = jQuery("#foto_perfil").val();
			var valorAntigo = "'.$imagemRosto.'"
			jQuery("#ifoto_perfil").attr("src",valor!="" ? valor :valorAntigo );
		});
	});
					
	function TestaCPF(strCPF) { var Soma; var Resto; Soma = 0; if (strCPF == "00000000000") return false; for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(9, 10)) ) return false; Soma = 0; for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false; return true; }


'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
	<?php echo JHtml::_('form.token'); ?>
	<?php 
	//echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general','Dados B&aacute;sico'); ?>
		<legend><?php echo JText::_('Modelo'); ?></legend>
		<div class="row-fluid">
			<div class="row">
			    
					<table class="admintable" align="center">
						<tr>
							<th colspan="2" align="center" class="key"><label for="nome"> <?php echo JText::_('Nome Completo'); ?></label></th>
							<th colspan="2" align="center" class="key"><label for="nome_artistico"> <?php echo JText::_('Apelido/Nome Artistico'); ?></label></th>
						</tr>
						<tr>
							<td colspan="2" align="center"><input class="text_area required" style="width: 540px;" type="text" name="nome"  id="nome" size="32" maxlength="250" value="<?php echo $this->item->name;?>" /></td>
							<td colspan="2" align="center"><input class="text_area required" style="width: 540px;" type="text" name="nome_artistico"  id="nome_artistico" size="32" maxlength="150" value="<?php echo $this->item->nome_artistico;?>" /></td>
						</tr>
						<tr>
							<th colspan="2" align="center" class="key"><label for="meta_descricao"> <?php echo JText::_('Descri&ccedil;&atilde;o R&aacute;pida'); ?></label></th>
							<th colspan="2" align="center" class="key"><label for="site"> <?php echo JText::_('Site'); ?></label></th>
						</tr>
						<tr>
							<td colspan="2" align="center"><input class="text_area required" style="width: 540px;" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" value="<?php echo $this->item->meta_descricao;?>" /></td>
							<td colspan="2" align="center"><input class="text_area required" style="width: 540px;" type="text" name="site"  id="site" size="32" maxlength="250" value="<?php echo $this->item->site;?>" /></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="usuario"> <?php echo JText::_('Usu&aacute;rio'); ?></label></th>
							<th align="center" class="key"><label for="password"> <?php echo JText::_('Senha'); ?></label></th>
							<th align="center" class="key"><label for="password1"> <?php echo JText::_('Confirmar Senha'); ?></label></th>
							<th align="center" class="key"><label for="email"> <?php echo JText::_('E-mail Principal'); ?></label></th>
						</tr>
						<tr>
							<td align="center"><input class="text_area required validate-username validate-usuariounico" style="width: 270px;" type="text" name="usuario"  id="usuario" size="32" maxlength="25" value="<?php echo $this->item->username;?>" /></td>
							<td align="center"><input class="text_area required validate-password" style="width: 270px;" type="password" name="password"  id="password" size="32" maxlength="25" /></td>
							<td align="center"><input class="text_area required validate-password validate-passverify" style="width: 270px;" type="password" name="password1"  id="password1" size="32" maxlength="25" /></td>
							<td align="center"><input class="text_area required validate-email" style="width: 270px;" type="text" name="email"  id="email" size="32" maxlength="250" value="<?php echo $this->item->email;?>"/></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="email1"> <?php echo JText::_('Confirmacao e-mail'); ?></label></th>
							<th align="center" class="key"><label for="data_nascimento"> <?php echo JText::_('Data de Nascimento'); ?></label></th>
							<th align="center" class="key"><label for="nascionalidade"> <?php echo JText::_('Nascionalidade'); ?></label></th>
							<th align="center" class="key"><label for="profissao"> <?php echo JText::_('Profiss&atilde;o'); ?></label></th>

						</tr>
						<tr>
							<td align="center"><input class="text_area required validate-email  validate-emailverify" style="width: 270px;" type="text" name="email1"  id="email1" size="32" maxlength="250" /></td>
							<td align="center"><?php echo JHtml::calendar($this->item->data_nascimento, 'data_nascimento', 'data_nascimento', '%d/%m/%Y', 'class="required validate-data"');?></td>
							<td align="center"><input class="text_area required" style="width: 270px;" type="text" name="nascionalidade"  id="nascionalidade" size="32" maxlength="25" value="<?php echo $this->item->nascionalidade;?>" /></td>
							<td align="center"><input class="text_area " style="width: 270px;" type="text" name="profissao"  id="profissao" size="32" maxlength="150" value="<?php echo $this->item->profissao;?>" /></td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="sexo"> <?php echo JText::_('Sexo'); ?></label></th>
							<th align="center" class="key"><label for="estado_nasceu"> <?php echo JText::_('Estado Que Nasceu'); ?></label></th>
							<th align="center" class="key"><label for="id_cidade_nasceu"> <?php echo JText::_('Cidade Que Nasceu'); ?></label></th>
							<th align="center" class="key"><label for="cpf"> <?php echo JText::_('CPF'); ?></label></th>
						</tr>
						<tr>
							<td align="center">
								<select name="sexo" id="sexo" class="required" style="width: 270px;">
									<option></option>
									<option value="M"<?php echo($this->item->sexo=="M"?" selected":"");?>>Masculino</option>
									<option value="F"<?php echo($this->item->sexo=="F"?" selected":"");?>>Feminino</option>
								</select>
							</td>
							<td align="center">
								<select name="estado_nasceu" id="estado_nasceu" class="required estado" data-carregar="id_cidade_nasceu" style="width: 270px;">
									<option></option>
									<?php
									foreach ($ufs as $f){ 
									?>
									<option value="<?php echo($f->uf) ?>"><?php echo($f->uf) ?></option>
									<?php 
									}
									?>
								</select>
							</td>
							<td align="center">
								<select name="id_cidade_nasceu" id="id_cidade_nasceu" class="required" style="width: 270px;">
									<option></option>
								</select>
							</td>
							<td align="center"><input class="text_area required validate-cpf" style="width: 270px;" type="text" name="cpf"  id="cpf" size="32" maxlength="14" value="<?php echo $this->item->cpf;?>" /></td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="estado_reside"> <?php echo JText::_('Estado Que Reside'); ?></label></th>
							<th align="center" class="key"><label for="id_cidade"> <?php echo JText::_('Cidade Que Reside'); ?></label></th>
						</tr>
						<tr>
							<td align="center">
								<select name="estado_reside" id="estado_reside" class="required estado" data-carregar="id_cidade" style="width: 270px;">
									<option></option>
									<?php
									foreach ($ufs as $f){ 
									?>
									<option value="<?php echo($f->uf) ?>"><?php echo($f->uf) ?></option>
									<?php 
									}
									?>
								</select>
							</td>
							<td align="center">
								<select name="id_cidade" id="id_cidade" class="required" style="width: 270px;">
									<option></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4" align="center" class="key"><label for="descricao"> <?php echo JText::_('Fale um pouco de voc&ecirc;.'); ?></label></td>
						</tr>
						<tr>
							<td colspan="4" ><?php echo $editor->display('descricao', $this->item->descricao, '200', '200', '20', '20', false, $params); ?></td>
						</tr>
						<?php
						if($this->item != null && $this->item->id != null){ 
						?>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<th  align="center" class="key"><label><?php echo JText::_('Criado por'); ?></label></th>
							<th  align="center" class="key"><label><?php echo JText::_('Editado por'); ?></label></th>                
							<th  align="center" class="key"><label><?php echo JText::_('Criado'); ?></label></th>
							<th  align="center" class="key"><label><?php echo JText::_('Editado'); ?></label></th>					
						</tr>
						<tr>
							<td align="center"><?php echo $this->item->criador;?></td>
							<td align="center"><?php echo $this->item->editor;?></td>
							<td align="center"><?php echo(JFactory::getDate($this->item->data_criado)->format('d/m/Y'));?></td>
							<td align="center"><?php echo(JFactory::getDate($this->item->data_alterado)->format('d/m/Y'));?></td>
						</tr>
						<tr>
							<th  align="center" class="key"><label for="id_edited_by"><?php echo JText::_('Gostaram'); ?></label></th>                
							<th  align="center" class="key"><label for="id_created_by"><?php echo JText::_('N&atilde;o Gostaram'); ?></label></th>
							<th  align="center" class="key"><label for="created_on"> <?php echo JText::_('Vizualizaram'); ?></label></th>
						
						</tr>
						<tr>
							<td align="center"><?php echo $this->item->audiencia_gostou;?></td>
							<td align="center"><?php echo $this->item->audiencia_ngostou;?></td>
							<td align="center"><?php echo($this->item->audiencia_view);?></td>
						</tr>
						<?php 
						}?>
					</table>
			    </div>
				<div class="span3">
					<?php 
					//echo JLayoutHelper::render('joomla.edit.global', $this); ?>

		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'fotos','Fotos'); ?>
		<legend><?php echo JText::_('Fotos de perfil da Modelo'); ?></legend>
		<div class="row-fluid">

					<table class="admintable" align="center">
						<tr>
							<th align="center" class="key"><label for="foto_perfil"> <?php echo JText::_('Foto rosto'); ?></label></th>
							<td>&nbsp;</td>
							<th align="center" class="key"><label for="foto_inteira"> <?php echo JText::_('Foto corpo'); ?></label></th>
						</tr>
						<tr>
							<td align="center" valign="middle">
								<img src="<?php echo($imagemRosto);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_perfil" name="ifoto_perfil" style="width: 150px; "/>
								<input class="text_area" style="width: 250px;" type="file" name="foto_perfil" id="foto_perfil" accept="image/*"/></td>
							<td>&nbsp;</td>
							<td align="center" valign="middle">
								<img src="<?php echo($imagemCorpo);?>" alt="Clique para mudar a imagem" title="Clique para mudar a imagem" id="ifoto_inteira" name="ifoto_inteira" style="width: 150px; "/>
								<input class="text_area" style="width: 250px;" type="file" name="foto_inteira" id="foto_inteira" accept="image/*"/></td>
						</tr>
					</table>

		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'caracteristicas','Caracteristicas F&iacute;sicas'); ?>
		<legend><?php echo JText::_('Caracteristicas F&iacute;sicas da Modelo'); ?></legend>
		<div class="row-fluid">

					<table class="admintable" align="center">
						<tr>
							<th align="center" class="key"><label for="altura"> <?php echo JText::_('Altura'); ?></label></th>
							<th align="center" class="key"><label for="peso"> <?php echo JText::_('Peso'); ?></label></th>
							<th align="center" class="key"><label for="busto"> <?php echo JText::_('Busto'); ?></label></th>
							<th align="center" class="key"><label for="calsa"> <?php echo JText::_('Calsa'); ?></label></th>
						</tr>
						<tr>
							<td><input class="validate-numeric required" style="width: 270px;" type="text" name="altura" id="altura" size="32" maxlength="6" value="<?php echo $this->item->altura;?>" /></td>
							<td><input class="validate-numeric required" style="width: 270px;" type="text" name="peso" id="peso" size="32" maxlength="6" value="<?php echo $this->item->peso;?>" /></td>
							<td><input class="validate-inteiro required" style="width: 270px;" type="text" name="busto" id="busto" size="32" maxlength="6" value="<?php echo $this->item->busto;?>" /></td>
							<td><input class="validate-inteiro required" style="width: 270px;" type="text" name="calsa" id="calsa" size="32" maxlength="6" value="<?php echo $this->item->calsa;?>" /></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="calsado"> <?php echo JText::_('Tamanho dos Calsados'); ?></label></th>
							<th align="center" class="key"><label for="olhos"> <?php echo JText::_('Olhos'); ?></label></th>
							<th align="center" class="key"><label for="pele"> <?php echo JText::_('Pele'); ?></label></th>
							<th align="center" class="key"><label for="etinia"> <?php echo JText::_('Etinia'); ?></label></th>

						</tr>
						<tr>
							<td><input class="validate-inteiro required" style="width: 270px;" type="text" name="calsado" id="calsado" size="32" maxlength="6" value="<?php echo $this->item->calsado;?>" /></td>
							<td>
								<select name="olhos" id="olhos" class="required" style="width: 270px;">
									<option></option>
									<option value="NEGROS"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">NEGROS</option>
									<option value="AZUIS"<?php echo($this->item->olhos=="AZUIS"?" selected":"");?> class="text-transform: capitalize;">AZUIS</option>
									<option value="VERDES"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">VERDES</option>
									<option value="CASTANHOS"<?php echo($this->item->olhos=="CASTANHOS"?" selected":"");?> class="text-transform: capitalize;">CASTANHOS</option>
									<option value="MEL"<?php echo($this->item->olhos=="MEL"?" selected":"");?> class="text-transform: capitalize;">MEL</option>
									<option value="OUTRO"<?php echo($this->item->olhos=="NEGROS"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
								</select>
							</td>
							<td>
								<select name="pele" id="pele" class="required" style="width: 270px;">
									<option></option>
									<option value="CALCASIANA"<?php echo($this->item->pele=="CALCASIANA"?" selected":"");?> class="text-transform: capitalize;">CALCASIANA</option>
									<option value="BRANCA"<?php echo($this->item->pele=="BRANCA"?" selected":"");?> class="text-transform: capitalize;">BRANCA</option>
									<option value="PARDA"<?php echo($this->item->pele=="PARDA"?" selected":"");?> class="text-transform: capitalize;">PARDA</option>
									<option value="MORENA"<?php echo($this->item->pele=="CALCASIANA"?" selected":"");?> class="text-transform: capitalize;">MORENA</option>
									<option value="NEGRA"<?php echo($this->item->pele=="NEGRA"?" selected":"");?> class="text-transform: capitalize;">NEGRA</option>
									<option value="AMARELA"<?php echo($this->item->pele=="AMARELA"?" selected":"");?> class="text-transform: capitalize;">AMARELA</option>
									<option value="OUTRO"<?php echo($this->item->pele=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
								</select>
							</td>
							<td>
								<select name="etinia" id="etinia" class="required" style="width: 270px;">
									<option></option>
									<option value="AZIATICA"<?php echo($this->item->etinia=="AZIATICA"?" selected":"");?> class="text-transform: capitalize;">AZIATICA</option>
									<option value="AFRO"<?php echo($this->item->etinia=="AFRO"?" selected":"");?> class="text-transform: capitalize;">AFRO</option>
									<option value="EURPEIA"<?php echo($this->item->etinia=="EURPEIA"?" selected":"");?> class="text-transform: capitalize;">EURPEIA</option>
									<option value="ORIENTAL"<?php echo($this->item->etinia=="ORIENTAL"?" selected":"");?> class="text-transform: capitalize;">ORIENTAL</option>
									<option value="LATINA"<?php echo($this->item->etinia=="LATINA"?" selected":"");?> class="text-transform: capitalize;">LATINA</option>
									<option value="OUTRO"<?php echo($this->item->etinia=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<th align="center" class="key"><label for="cabelo"> <?php echo JText::_('Tipo de Cabelo'); ?></label></th>
							<th align="center" class="key"><label for="tamanho_cabelo"> <?php echo JText::_('Tamanho do Cabelo'); ?></label></th>
							<th align="center" class="key"><label for="cor_cabelo"> <?php echo JText::_('Cor do Cabelo'); ?></label></th>
							<th align="center" class="key"><label for="profissao"> <?php echo JText::_('Se "Outra Cor" ou "Colorido", especifique a cor.'); ?></label></th>
						</tr>
						<tr>
							<td>
								<select name="cabelo" id="cabelo" class="required" style="width: 270px;">
									<option></option>
									<option value="LIZO"<?php echo($this->item->cabelo=="LIZO"?" selected":"");?> class="text-transform: capitalize;">LIZO</option>
									<option value="ENCARACOLADO"<?php echo($this->item->cabelo=="ENCARACOLADO"?" selected":"");?> class="text-transform: capitalize;">ENCARACOLADO</option>
									<option value="CACHIADO"<?php echo($this->item->cabelo=="CACHIADO"?" selected":"");?> class="text-transform: capitalize;">CACHIADO</option>
									<option value="ONDULADOS"<?php echo($this->item->cabelo=="ONDULADOS"?" selected":"");?> class="text-transform: capitalize;">ONDULADOS</option>
									<option value="CRESPO"<?php echo($this->item->cabelo=="CRESPO"?" selected":"");?> class="text-transform: capitalize;">CRESPO</option>
									<option value="OUTRO"<?php echo($this->item->cabelo=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
									<option value="SEM"<?php echo($this->item->cabelo=="SEM"?" selected":"");?> class="text-transform: capitalize;">SEM</option>
								</select>
							</td>
							<td>
								<select name="tamanho_cabelo" id="tamanho_cabelo" class="required" style="width: 270px;">
									<option></option>
									<option value="MUITO CURTO"<?php echo($this->item->tamanho_cabelo=="MUITO CURTO"?" selected":"");?> class="text-transform: capitalize;">MUITO CURTO</option>
									<option value="CURTO"<?php echo($this->item->tamanho_cabelo=="CURTO"?" selected":"");?> class="text-transform: capitalize;">CURTO</option>
									<option value="MEDIO"<?php echo($this->item->tamanho_cabelo=="MEDIO"?" selected":"");?> class="text-transform: capitalize;">MEDIO</option>
									<option value="LONGO"<?php echo($this->item->tamanho_cabelo=="LONGO"?" selected":"");?> class="text-transform: capitalize;">LONGO</option>
									<option value="MUITO LONGO"<?php echo($this->item->tamanho_cabelo=="MUITO LONGO"?" selected":"");?> class="text-transform: capitalize;">MUITO LONGO</option>
									<option value="OUTRO"<?php echo($this->item->tamanho_cabelo=="OUTRO"?" selected":"");?> class="text-transform: capitalize;">OUTRO</option>
									<option value="SEM"<?php echo($this->item->tamanho_cabelo=="SEM"?" selected":"");?> class="text-transform: capitalize;">SEM</option>
								</select>
							</td>
							<td>
								<select name="cor_cabelo" id="cor_cabelo" class="required" style="width: 270px;">
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
							</td>
							<td><input class="" style="width: 270px;" type="text" name="outra_cor_cabelo" id="outra_cor_cabelo" size="32" maxlength="25" value="<?php echo $this->item->outra_cor_cabelo;?>" /></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

					</table>
			    </div>
				<div class="span3">
					<?php 
					//echo JLayoutHelper::render('joomla.edit.global', $this); ?>

		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php if( isset($this->item) && isset($this->item->id)){ ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'redesSociais','Redes Sociais'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'enderecos','Endere&ccedil;os'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'contatos','Contatos'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php 
		}?>
	</div>
    <div class="clr"></div>

    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
    <input type="hidden" name="view" value="" />
    <input type="hidden" name="controller" value="" />
    <input type="hidden" name="task" value="saveAngenda" />
</form>
