<?php
/**
 * Perfils HTML Default Template
 *
 * PHP versions 5
 *
 * @category  Template
 * @package   AngelGirls
 * @author	Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @link	  http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.keepalive');
JHTML::_('behavior.calendar');

$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');
?>
<script>
var qtdaTelefones="<?php echo(count($this->telefones));?>";
var qtdaEnderecos="<?php echo(count($this->enderecos));?>";

document.showForm = function (formView){
	jQuery(".formulario").fadeOut(1000);
	jQuery("form").reset();
	jQuery(formView).fadeIn(1000);
}

document.editarEmails = function editarEmails(id, email){
	jQuery('#idEmail').val(id);
	jQuery('#emails').val(email);
	document.showForm('#formEmail');
}

document.editarTelefone = function (id, ddd, telefone){
	jQuery('#idTelefone').val(id);
	jQuery('#ddd').val(ddd);
	jQuery('#telefone').val(telefone);
	
	document.showForm('##formTelefone');
};


document.editarEndereco = function (id, logradouro, endereco, numero, complemento, bairro, cidade, pais, cep){
	jQuery('#idEndereco').val(id);
	jQuery('#logradouro').val(logradouro);
	jQuery('#endereco').val(endereco);
	jQuery('#numero').val(numero);
	jQuery('#bairro').val(bairro);
	jQuery('#cidade').val(cidade);
	jQuery('#estado').val(estado);
	jQuery('#pais').val(pais);
	jQuery('#cep').val(cep);
	
	
	document.showForm('##formTelefone');
};


document.redirectRemover = function(url){ 
	var v = confirm('<?php echo JText::_('Certeza'); ?>');
	if(v){
		window.location = url;
	}
};

document.proseguir = function (){
	if(qtdaEnderecos<=0){
		alert("<?php echo JText::_('Endereco Obrigatorio'); ?>");
	}
	else{
		window.location="<?php echo(JRoute::_('index.php?option=com_angelgirls&amp;controller=perfils&amp;task=pricipalEmail&amp;flago='. JRequest::get('flago').'&amp;id='.$item->id)); ?>"
	}
};

$(document).ready(function(){
	$("#telefone").mask("99999-9999");
	$('#new_emails').validate({
		rules: {
			emails: {
				required: true,
				email:true,
				minlength: 2,
				remote: {
					url: "<?php echo(JRoot::_('index2.php?controller=perfils&task=validarExite')); ?>",
					type: "post",
					data: {
						email: $( "#email" ).val(),
						documento: $( "#documento" ).val()						
					}
				}
			}
		}
		messages{
			email: {
				required: "<?php echo JText::_('perfil.cadastro.email.requirido'); ?>",
				email: "<?php echo JText::_('perfil.cadastro.email.valido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.email.minimo'); ?>",
				remote: "<?php echo JText::_('perfil.cadastro.email.remote'); ?>"
			}
		}
	});
	$('#new_telefones').validate({
		rules: {
			ddd: {
				required: true
			},
			telefone: {
				required: true
			}
		}
		messages{
			ddd: {
				required: "<?php echo JText::_('perfil.cadastro.ddd.requirido'); ?>"
			},
			telefone: {
				required: "<?php echo JText::_('perfil.cadastro.telefone.requirido'); ?>"
			}
		}
	});	
});

</script>


<h2>Detalhes</h2>
<div id="formBotoes" class="formulario">
	<div class="divLabelCampo"><?php echo JText::_('Nome'); ?>:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('nome')) ?></div>
	<div class="divLabelCampo"><?php echo JText::_('Apelido'); ?>:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('Apelido')) ?></div>
	<div class="divLabelCampo"><?php echo JText::_('Email'); ?>:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('email')) ?></div>
	
	<div class="bts">
		<div>
			<a href="JavaScript:document.showForm('#formEmail');">Cadastrar novo e-mail</a>
		</div>
		<div>
			<a href="JavaScript:document.showForm('#formEndereco');">Cadastrar novo endereço</a>
		</div>
		<div>
			<a href="JavaScript:document.showForm('#formTelefone');">Cadastrar novo telefone</a>
		</div>
	</div>
</div>
<div id="formEmail" class="formulario">
	<h3><?php echo JText::_('Add Emails'); ?></h3>
	<form id="new_emails" name="new_emails" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			<div class="divLabelCampo"><label for="emails"> <?php echo JText::_('Email'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="emails" id="emails" size="32" maxlength="250" value="<?php echo $this->item->emails;?>" /></div>
		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="emails" />
		    <input type="hidden" name="controller" value="perfils" />
		    <input type="hidden" name="id" value="" id="idEmail"/>
		    <input type="hidden" name="flago" value="<?php echo JRequest::get('flago'); ?>" />
	    </fieldset>
	</form>
</div>
<div id="formEndereco" class="formulario">
	<h3><?php echo JText::_('Add Enderecos'); ?></h3>
	<form id="new_enderecos" name="new_enderecos" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			<div class="divLabelCampo"><label for="cep"> <?php echo JText::_('Cep'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="cep" id="cep" size="32" maxlength="250"  /></div>
			
			<div class="divLabelCampo"><label for="logradouro"> <?php echo JText::_('Logradouro'); ?>:</label></div>
			<div class="divValorCampo">

			
			<select name="logradouro" id="logradouro" class="requerid">
				<option value="1">RUA</option>
				<option value="2">AVENIDA</option>
				<option value="3">ENCRUZILHADA</option>
				<option value="4">ESTRADA</option>
				<option value="5">MARGINAL</option>
				<option value="6">OUTROS</option>
			</select>
			</div>
			
			<div class="divLabelCampo"><label for="endereco"> <?php echo JText::_('Endereco'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="endereco" id="endereco" size="32" maxlength="250"  /></div>
			
			<div class="divLabelCampo"><label for="numero"> <?php echo JText::_('Numero'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="numero" id="numero" size="32" maxlength="250"  /></div>
			
			<div class="divLabelCampo"><label for="complemento"> <?php echo JText::_('Complemento'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="complemento" id="complemento" size="32" maxlength="250"  /></div>
			
			<div class="divLabelCampo"><label for="municipio"> <?php echo JText::_('Municipio'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="municipio" id="municipio" size="32" maxlength="250" /></div>
			
			<div class="divLabelCampo"><label for="uf"> <?php echo JText::_('UF'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="uf" id="uf" size="32" maxlength="3" /></div>
			
			<div class="divLabelCampo"><label for="pais"> <?php echo JText::_('Pais'); ?>:</label></div>
			<div class="divValorCampo">
			<select name="pais" id="pais" class="requerid">
				<option value="BRL">Brasil</option>
				<option value="EUA">Estados Unidos</option>
				<option value="UNK">Inglaterra</option>
				<option value="FRA">França</option>
				<option value="ESP">Espanha</option>
				<option value="GER">Alemanhã</option>
				<option value="ARG">Argentina</option>
				<option value="CHI">Chile</option>
				<option value="URU">Uruguai</option>
			</select></div>
			

		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="enderecos" />
		    <input type="hidden" name="controller" value="perfils" />
		    <input type="hidden" name="id" value="" id="idEndereco"/>
		    <input type="hidden" name="flago" value="<?php echo JRequest::get('flago'); ?>" />
	    </fieldset>
	</form>
</div>
<div id="formTelefone" class="formulario">
	<h3><?php echo JText::_('Add Telefones'); ?></h3>
	<form id="new_telefones" name="new_telefones" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			
			
			<div class="divLabelCampo"><label for="telefone"> <?php echo JText::_('Telefone'); ?>:</label></div>
			<div class="divValorCampo">
				(<input class="text_area" type="text" name="ddd" id="ddd" size="5" maxlength="3" />)
				<input class="text_area" type="text" name="telefone" id="telefone" size="32" maxlength="15"  />
			</div>
		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="telefones" />
		    <input type="hidden" name="controller" value="perfils" />
		    <input type="hidden" name="id" value="" id="idTelefone"/>
		    <input type="hidden" name="flago" value="<?php echo JRequest::get('flago'); ?>" />
	    </fieldset>
	</form>
</div>
<div id="listaEmails" class="lista">
	<h2><?php echo JText::_('Emails'); ?></h2>
	<?php if(count($this->emails) > 0) : ?>
		<div id="emails_list">
		<p><?php echo JText::_('Below is a list of all current Emails'); ?>.</p>
		<table border="1" cellspacing="1" cellpadding="1" 
		    	summary="<?php echo JText::_('Below is a list of all current Emails'); ?>" 
		    	title="<?php echo JText::_('Below is a list of all current Emails'); ?>"
		    	class="tabelaDados">
			    <thead>
			        <tr>
			      		<th></th>
			      		<th></th>
			            <th><?php echo JText::_('Emails'); ?></th>
			            <th><?php echo JText::_('Edited On'); ?></th>
			        </tr>
			    </thead>
			    <tbody>
			    <?php foreach ($this->emails as $item) : ?>
			    <?php $link = "JavaScript: document.editarEmails(" . $item->id .", '" . $item->emails . "')"; 
			    	  $remover=JRoute::_('index.php?option=com_angelgirls&amp;controller=perfils&amp;task=removerEmail&amp;flago='. JRequest::get('flago').'&amp;id='.$item->id);
			    	  $pricipal=JRoute::_('index.php?option=com_angelgirls&amp;controller=perfils&amp;task=pricipalEmail&amp;flago='. JRequest::get('flago').'&amp;id='.$item->id);
			    	  
			    	?>
			        <tr>
			        	<?php if($item->principal): ?>
			        	<td><a href="JavaScript: document.redirectRemover('<?php echo($pricipal);?>');">P</a></td>
			        	<td><a href="JavaScript: document.redirectRemover('<?php echo($remover);?>');">R</a></td>
			        	<?php else:?>
			        	<td colspan="2" align="center">PRINCIPAL</td>
			        	<?php endif;?>
			            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->emails."</a>"; ?></td>
			            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->edited_on."</a>"; ?></td>
			        </tr>
			    <?php endforeach; ?>
			    </tbody>
		    </table>
		<?php else: ?>
		    <p><?php echo JText::_('No Emails found'); ?>.</p>
		<?php endif; ?>
	</div>
</div>
<div id="listaEnderecos" class="lista">
	<h2><?php echo JText::_('Enderecos'); ?></h2>
	<?php if(count($this->enderecos) > 0) : ?>
	<div id="enderecos_list">
	    <p><?php echo JText::_('Below is a list of all current Enderecos'); ?>.</p>
	    <table border="1" cellspacing="1" cellpadding="1"
	    	summary="<?php echo JText::_('Below is a list of all current Enderecos'); ?>"
	    	title="<?php echo JText::_('Below is a list of all current Enderecos'); ?>"
	    	class="tabelaDados">
	    <thead>
	        <tr>
	        	<th></th>
	            <th><?php echo JText::_('Telefone'); ?></th>
	            <th><?php echo JText::_('Ddd'); ?></th>
	            <th><?php echo JText::_('Edited On'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($this->enderecos as $item) : ?>
	    <?php //$link = JRoute::_('index.php?option=com_angelgirls&amp;view=enderecos&amp;layout=details&amp;id='.$item->id);
			$link = "JavaScript: document.editarEndereco(" . $item->id. ", '" . $item->logradouro. "', '" . $item->endereco. "', '" . $item->numero. "', '" . $item->complemento. "', '" . $item->bairro. "', '" . $item->cidade. "', '" . $item->pais. "', '" . $item->cep."')";
			$remover=JRoute::_('index.php?option=com_angelgirls&amp;controller=perfils&amp;task=removerEndereco&amp;flago='. JRequest::get('flago').'&amp;id='.$item->id);?>
	        <tr>
				<td><a href="JavaScript: document.redirectRemover('<?php echo($remover);?>');">R</a></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->endereco."</a>"; ?></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->numero."</a>"; ?></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->cep."</a>"; ?></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->edited_on."</a>"; ?></td>
	        </tr>
	    <?php endforeach; ?>
	    </tbody>
	    </table>
	<?php else: ?>
	    <p><?php echo JText::_('No Enderecos found'); ?>.</p>
	<?php endif; ?>
	</div>
</div>
<div id="listaTelefones" class="lista">
	<h2><?php echo JText::_('Telefones'); ?></h2>
	<?php if(count($this->telefones) > 0) : ?>
	<div id="telefones_list">
	    <p><?php echo JText::_('Below is a list of all current Telefones'); ?>.</p>
	    <table border="1" cellspacing="1" cellpadding="1"
	    	summary="<?php echo JText::_('Below is a list of all current Telefones'); ?>"
	    	title="<?php echo JText::_('Below is a list of all current Telefones'); ?>"
	    	class="tabelaDados">
	    <thead>
	        <tr>
	        	<th></th>
	            <th><?php echo JText::_('Ddd'); ?></th>
	            <th><?php echo JText::_('Telefone'); ?></th>
	            <th><?php echo JText::_('Edited On'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($this->telefones as $item) : ?>
	    <?php //$link = JRoute::_('index.php?option=com_angelgirls&amp;view=telefones&amp;layout=details&amp;id='.$item->id);
			$link = "JavaScript: document.editarTelefone(".$item->id . ", '" . $item->ddd . "', '" . $item->telefone . "')";
	    	$remover=JRoute::_('index.php?option=com_angelgirls&amp;controller=perfils&amp;task=removerEmail&amp;flago='. JRequest::get('flago').'&amp;id='.$item->id);?>
	        <tr>
				<td><a href="JavaScript: document.redirectRemover('<?php echo($remover);?>');">R</a></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->ddd."</a>"; ?></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->telefone."</a>"; ?></td>
	            <td><?php echo "<a href='$link' title='" . JText::_('Edit') . "'>".$item->edited_on."</a>"; ?></td>
	        </tr>
	    <?php endforeach; ?>
	    </tbody>
	    </table>
	<?php else: ?>
	    <p><?php echo JText::_('No Telefones found'); ?>.</p>
	<?php endif; ?>
	</div>
</div>