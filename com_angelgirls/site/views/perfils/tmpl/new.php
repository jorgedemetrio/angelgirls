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

//TODO Verificar como integrar com facebook e G+.

?>

<h1><?php echo JText::_('Add Perfils'); ?></h1>
<form id="new_perfils" name="new_perfils" method="post" enctype="multipart/form-data"> <!--  onsubmit="return document.formvalidator.isValid(this)"  -->
	<fieldset>
	
		<div class="divLabelCampo"><label for="nome"> <?php echo JText::_('Nome'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area  required" type="text" name="nome" id="nome" size="32" maxlength="250" value="<?php echo $this->item->nome;?>" /><?php echo JText::_('Obrigatorio'); ?></div>
	
		<div class="divLabelCampo"><label for="apelido"> <?php echo JText::_('Apelido'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area  required" type="text" name="apelido" id="apelido" size="32" maxlength="250" value="<?php echo $this->item->apelido;?>" /><?php echo JText::_('Obrigatorio'); ?></div>
		
		<div class="divLabelCampo"><label for="foto_perfil"> <?php echo JText::_('Foto Perfil'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area  required" type="file" name="foto_perfil" id="foto_perfil" size="32" maxlength="250" value="<?php echo $this->item->foto_perfil;?>" /></div>

		<div class="divLabelCampo"><label for="documento"> <?php echo JText::_('Documento'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area " type="text" name="documento" id="documento" size="32" maxlength="15" value="<?php echo $this->item->documento;?>" /><?php echo JText::_('Obrigatorio'); ?></div>

		<div class="divLabelCampo"><label for="senha"> <?php echo JText::_('Senha'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area  required" type="password" name="senha" id="senha" size="32" maxlength="15" value="<?php echo $this->item->documento;?>" /><?php echo JText::_('Obrigatorio'); ?></div>

		<div class="divLabelCampo"><label for="confsenha"> <?php echo JText::_('Conf. Senha'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area  required" type="password" name="confsenha" id="confsenha" size="32" maxlength="15" value="<?php echo $this->item->documento;?>" /><?php echo JText::_('Obrigatorio'); ?></div>

		<div class="divLabelCampo"><label for="email"> <?php echo JText::_('Email'); ?>:</label></div>
		<div class="divValorCampo"><input class="text_area email required" type="text" name="email" id="email" size="32" maxlength="250" value="<?php echo $this->item->email;?>" /></div>
		<br/>
		<br/>
		<div class="divLabelCampo"><label for="receber_email"> <?php echo JText::_('receber_email'); ?>:</label></div>
		<div class="divValorCampo"><input class="required tootip" type="checkbox" name="receber_email" id="receber_email" title="<?php echo JText::_('perfil.cadastro.receber_email.requirido'); ?>"/></div>

		<div class="divLabelCampo"><label for="termos"> <?php echo JText::_('Termos'); ?>:</label></div>
		<div class="divValorCampo"><input class="required tootip" type="checkbox" name="termos" id="termos" title="<?php echo JText::_('perfil.cadastro.termos.requirido'); ?>"/></div>

			
			

		<?php echo JHTML::_('form.token'); ?>
		<input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		<input type="hidden" name="option" value="com_angelgirls" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="view" value="perfils" />
		<input type="hidden" name="controller" value="perfils" />
		<input type="hidden" name="flago" value="<?php echo JRequest::get('flago'); ?>" />
	</fieldset>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$("#documento").mask("999.999.999-99");
	$('#new_perfils').validate({
		rules: {
			apelido: {
				required: true,
				minlength: 3
			},
			documento: {
				required: true,
				minlength: 14
			},
			senha: {
				required: true,
				minlength: 5
			},
			confsenha: {
				required: true,
				minlength: 5
				equalTo: $('#senha').val()
			},
			receber_email{
				required: true
			},
			termos{
				required: true
			},
			email: {
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
			apelido:{
				required: "<?php echo JText::_('perfil.cadastro.apelido.requirido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.apelido.minimo'); ?>"
			}
			documento: {
				required: "<?php echo JText::_('perfil.cadastro.documento.requirido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.documento.minimo'); ?>"
			},
			senha: {
				required: "<?php echo JText::_('perfil.cadastro.senha.requirido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.senha.minimo'); ?>"
			},
			confsenha: {
				required: "<?php echo JText::_('perfil.cadastro.confsenha.requirido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.confsenha.minimo'); ?>",
				equalTo: "<?php echo JText::_('perfil.cadastro.confsenha.igual'); ?>",
			},
			email: {
				required: "<?php echo JText::_('perfil.cadastro.email.requirido'); ?>",
				email: "<?php echo JText::_('perfil.cadastro.email.valido'); ?>",
				minlength: "<?php echo JText::_('perfil.cadastro.email.minimo'); ?>",
				remote: "<?php echo JText::_('perfil.cadastro.email.remote'); ?>"
			},
			receber_email: {
				required: "<?php echo JText::_('perfil.cadastro.receber_email.requirido'); ?>"
			},
			termos: {
				required: "<?php echo JText::_('perfil.cadastro.termos.requirido'); ?>"
			}
		}
	});
});

</script>