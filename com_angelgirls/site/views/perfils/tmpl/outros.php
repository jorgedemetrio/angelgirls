<h1>Detalhes</h1>
<div id="formBotoes" class="formulario">
	<div class="divLabelCampo">Nome:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('nome')) ?></div>

	<div class="divLabelCampo">Apelido:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('nome')) ?></div>
	
	<div class="divLabelCampo">e-mail prinicpal:</div>
	<div class="divValorCampo"><?php echo(JRequest::get('nome')) ?></div>
</div>

<div id="formEmail" class="formulario">
	<h2><?php echo JText::_('Add Emails'); ?></h2>
	<form id="new_emails" name="new_emails" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			<div class="divLabelCampo"><label for="emails"> <?php echo JText::_('Email'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="emails" id="emails" size="32" maxlength="250" value="<?php echo $this->item->emails;?>" /></div>
		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="emails" />
		    <input type="hidden" name="controller" value="emails" />
	    </fieldset>
	</form>
</div>
<div id="formEndereco" class="formulario">
	<h2><?php echo JText::_('Add Enderecos'); ?></h2>
	<form id="new_enderecos" name="new_enderecos" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			<div class="divLabelCampo"><label for="cep"> <?php echo JText::_('Cep'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="cep" id="cep" size="32" maxlength="250" value="<?php echo $this->item->cep;?>" /></div>
		
			<div class="divLabelCampo"><label for="logradouro"> <?php echo JText::_('Logradouro'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="logradouro" id="logradouro" size="32" maxlength="250" value="<?php echo $this->item->logradouro;?>" /></div>
			
			<div class="divLabelCampo"><label for="endereco"> <?php echo JText::_('Endereco'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="endereco" id="endereco" size="32" maxlength="250" value="<?php echo $this->item->endereco;?>" /></div>
			
			<div class="divLabelCampo"><label for="numero"> <?php echo JText::_('Numero'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="numero" id="numero" size="32" maxlength="250" value="<?php echo $this->item->numero;?>" /></div>
			
			<div class="divLabelCampo"><label for="complemento"> <?php echo JText::_('Complemento'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="complemento" id="complemento" size="32" maxlength="250" value="<?php echo $this->item->complemento;?>" /></div>
			
			<div class="divLabelCampo"><label for="municipio"> <?php echo JText::_('Municipio'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="municipio" id="municipio" size="32" maxlength="250" value="<?php echo $this->item->municipio;?>" /></div>

			<div class="divLabelCampo"><label for="uf"> <?php echo JText::_('UF'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="uf" id="uf" size="32" maxlength="250" value="<?php echo $this->item->uf;?>" /></div>
			
			<div class="divLabelCampo"><label for="pais"> <?php echo JText::_('Pais'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="pais" id="pais" size="32" maxlength="250" value="<?php echo $this->item->pais;?>" /></div>
			

		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="enderecos" />
		    <input type="hidden" name="controller" value="enderecos" />
	    </fieldset>
	</form>
</div>
<div id="formTelefones" class="formulario">
	<h2><?php echo JText::_('Add Telefones'); ?></h2>
	<form id="new_telefones" name="new_telefones" method="post" onsubmit="return document.formvalidator.isValid(this)">
		<fieldset>
			<div class="divLabelCampo"><label for="ddd"> <?php echo JText::_('Ddd'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="ddd" id="ddd" size="32" maxlength="15" value="<?php echo $this->item->ddd;?>" /></div>
			
			
			<div class="divLabelCampo"><label for="telefone"> <?php echo JText::_('Telefone'); ?>:</label></div>
			<div class="divValorCampo"><input class="text_area" type="text" name="telefone" id="telefone" size="32" maxlength="3" value="<?php echo $this->item->telefone;?>" /></div>


		    <?php echo JHTML::_('form.token'); ?>
		    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
		    <input type="hidden" name="option" value="com_angelgirls" />
		    <input type="hidden" name="task" value="save" />
		    <input type="hidden" name="view" value="telefones" />
		    <input type="hidden" name="controller" value="telefones" />
	    </fieldset>
	</form>
</div>

<div id="listaEmails" class="lista">
</div>
<div id="listaEnderecos" class="lista">
</div>
<div id="listaTelefones" class="lista">
</div>