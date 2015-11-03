	var cpfModeloValido = true;
	
	var imagemPerfil = 'perfil.png'; 
	var imagemCorpo =  'no_image.png';
	var imagemCorpo_horizontal =  'no_image.png';
	var imagemRosto =  'no_image.png';

	
	
jQuery(document).ready(function(){
	jQuery('#meta_descricao').restrictLength($('#maxlength'));
	
	jQuery.validate({
	    modules : 'security, date, file, html5',
	    language : ptBRValidation,
	    onSuccess : function(){
	        if(jQuery('#cpf').attr('data-exite') == 'NAO' && jQuery('#cpf').attr('data-valido') == 'SIM'){
	    		AngelGirls.Processando().show(); return true;
	        }
	        else{
	            alert('CPF inv&aacute;lido! ');
				jQuery("label[for=\'"+$this.attr('id')+"\']").addClass("invalid");
				jQuery('#cpf').addClass("invalid");
				jQuery('#cpf').addClass("error");
				jQuery('#cpf').removeClass("valid");
	            return false;
	        }     	
	    },
	    decimalSeparator : ','
	}); 
	
	
	/*setTimeout(function(){
		jQuery('#estado_reside').change();
	},1500);
	setTimeout(function(){
		jQuery('#estado_nasceu').change();
	},1000);

	setTimeout(function(){
		jQuery('#estado_endereco').change();
	},1900);*/

	
	jQuery('#btnCancelarSalvarEndereco').click(function(){
		FormEnderecoActions.limpar();
	});
	jQuery('#btnAdicionarEndereco').click(function(){
		FormEnderecoActions.enviar();
	});

	jQuery('#btnSalvarEndereco').click(function(){
		FormEnderecoActions.enviar();
	});
	
	
	jQuery('#btnCancelarSalvarTelefone').click(function(){
		FormTelefoneActions.limpar();
	});
	jQuery('#btnAdicionarTelefone').click(function(){
		FormTelefoneActions.enviar();
	});
	jQuery('#btnSalvarTelefone').click(function(){
		FormTelefoneActions.enviar();
	});
	
	jQuery('#btnCancelarSalvarEmail').click(function(){
		FormEmailActions.limpar();
	});
	jQuery('#btnAdicionarEmail').click(function(){
		FormEmailActions.enviar();
	});
	jQuery('#btnSalvarEmail').click(function(){
		FormEmailActions.enviar();
	});
	
	jQuery('#btnAdicionarRedeSocial').click(function(){
		FormRedeSocialActions.enviar();
	});	
	
	
	
	
	jQuery('.validate-cpf').blur(function(){
		regex=/^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
		var value = this.value;
		var valueLimpo = value.replace(".","").replace(".","").replace("-","");
		$this = jQuery(this);
		
		var valudo = regex.test(value) && TestaCPF(valueLimpo);
		$this.attr('data-valido',valudo?"SIM":"NAO");
		if(!valudo){
			jQuery("label[for=\'"+$this.attr('id')+"\']").addClass("invalid");
			$this.addClass("invalid");
			$this.addClass("error");
			$this.removeClass("valid");
		}
		else{
			AngelGirls.Processando().show();
			jQuery.post("index.php?option=com_angelgirls&view=cadastro&task=validarCPFJson", {cpf:valueLimpo},function(dado){
				AngelGirls.Processando().hide();
				$this.attr('data-exite',"NAO");
				if((jQuery('#tipo').val()=='MODELO' && dado.modelo=="SIM") ||
				   (jQuery('#tipo').val()=='FOTOGRAFO' && dado.fotografo=="SIM") ||
				   (dado.visitante=="SIM")){
					jQuery("label[for=\'"+$this.attr('id')+"\']").addClass("invalid");
					jQuery('#cpf').addClass("invalid");
					jQuery('#cpf').addClass("error");
					jQuery('#cpf').removeClass("valid");
					jQuery('#cpf').attr('data-exite',"SIM");
				    alert("Existe uma modelo cadastrada com esse CPF, se esse for seu cadadastro entre em contato com contato@angelgirls.com.br.");
				}
			},"json");
		}
	});
});



var FormEnderecoActions = new Object(); 
FormEnderecoActions.editar = function (id,tipo,rua,numero,complemento,bairro,cep,cidade,estado){
	FormEnderecoActions.limpar();
	jQuery('#btnAdicionarEndereco').removeClass('in');
	jQuery('#btnCancelarSalvarEndereco').addClass('in');
	jQuery('#btnSalvarEndereco').addClass('in');
	jQuery('#idEndereco').val(id);
	jQuery('#tipoEndereco').val(tipo);
	jQuery('#cep').val(cep);
	jQuery('#rua').val(rua);
	jQuery('#numero').val(numero);
	jQuery('#complemento').val(complemento);
	jQuery('#bairro').val(bairro);
	jQuery('#id_cidade_endereco').attr('data-value',cidade);
	jQuery('#estado_endereco').val(estado);
	jQuery('#estado_endereco').change();

};

FormEnderecoActions.urlPadrao = "";

	
FormEnderecoActions.padrao = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEnderecoActions.urlPadrao), {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormEnderecoActions.RecarregarLista();
				FormEnderecoActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormEnderecoActions.urlRemover =  "";

FormEnderecoActions.remover = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEnderecoActions.urlRemover) , {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormEnderecoActions.RecarregarLista();
				FormEnderecoActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormEnderecoActions.urlLista =  "";

FormEnderecoActions.RecarregarLista = function(){
	jQuery.get(AngelGirls.URLNoCache(FormEnderecoActions.urlLista), {},function(dado){
		jQuery('#tabelaEnderecos').html(dado);
	},"html");
};

FormEnderecoActions.estadoPadrao = "";
FormEnderecoActions.limpar = function(){
	jQuery('#btnCancelarSalvarEndereco').removeClass('in');
	jQuery('#btnSalvarEndereco').removeClass('in');
	jQuery('#btnAdicionarEndereco').removeClass('in');	
	
	jQuery('#idEndereco').val('');
	jQuery('#tipoEndereco').val('RESIDENCIAL');
	jQuery('#cep').val('');
	jQuery('#rua').val('');
	jQuery('#numero').val('');
	jQuery('#complemento').val('');
	jQuery('#bairro').val('');
	jQuery('#id_cidade_endereco').val('');
	jQuery('#estado_endereco').change(FormEnderecoActions.estadoPadrao);
	jQuery('#btnAdicionarEndereco').addClass('in');

};

FormEnderecoActions.urlEnviar = "";

FormEnderecoActions.enviar = function (){

	var erro= false;
	if(jQuery('#cep').val()=="" || jQuery('#cep').val().length<9){
		jQuery('#cep').removeClass('valid');
		jQuery('#cep').addClass('error');
		jQuery('#cep').addClass('invalid');
		jQuery("label[for='cep']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#cep').addClass('valid');
		jQuery('#cep').removeClass('invalid');
		jQuery('#cep').removeClass('error');
		jQuery("label[for='cep']").removeClass('invalid');
		
	}
	if(jQuery('#rua').val()==""){
		jQuery('#rua').removeClass('valid');
		jQuery('#rua').addClass('error');
		jQuery('#rua').addClass('invalid');
		jQuery("label[for='rua']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#rua').addClass('valid');
		jQuery('#rua').removeClass('invalid');
		jQuery('#rua').removeClass('error');
		jQuery("label[for='rua']").removeClass('invalid');
	}
	if(jQuery('#numero').val()==""){
		jQuery('#numero').removeClass('valid');
		jQuery('#numero').addClass('error');
		jQuery('#numero').addClass('invalid');
		jQuery("label[for='numero']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#numero').addClass('valid');
		jQuery('#numero').removeClass('invalid');
		jQuery('#numero').removeClass('error');
		jQuery("label[for='numero']").removeClass('invalid');
		
	}
	if(jQuery('#id_cidade_endereco').val()==""){
		jQuery('#id_cidade_endereco').removeClass('valid');
		jQuery('#id_cidade_endereco').addClass('error');
		jQuery('#id_cidade_endereco').addClass('invalid');
		jQuery("label[for='id_cidade_endereco']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#id_cidade_endereco').addClass('valid');
		jQuery('#id_cidade_endereco').removeClass('invalid');
		jQuery('#id_cidade_endereco').removeClass('error');
		jQuery("label[for='id_cidade_endereco']").removeClass('invalid');
		
	}
	if(jQuery('#estado_endereco').val()!=""){
		jQuery('#estado_endereco').addClass('valid');
		jQuery('#estado_endereco').removeClass('invalid');
		jQuery('#estado_endereco').removeClass('error');
		jQuery("label[for='estado_endereco']").removeClass('invalid');
		
	}
	if(erro){
		alert('Dados inv&aacute;ldos.');
		return;
	}
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEnderecoActions.urlEnviar), {
		id: jQuery('#idEndereco').val(),
		tipo: jQuery('#tipoEndereco').val(),
		principal:'N',
		cep:jQuery('#cep').val(),
		rua : jQuery('#rua').val(),
		numero:jQuery('#numero').val(),
		complemento:jQuery('#complemento').val(),
		bairro:jQuery('#bairro').val(),
		estado:jQuery('#estado_endereco').val(),
		cidade:jQuery('#id_cidade_endereco').val()
	},function(dado){
		if(dado.ok=='ok'){
			FormEnderecoActions.RecarregarLista();
			AngelGirls.Processando().hide();
//			info('Endere&ccedil;o salvo com sucesso!');
			FormEnderecoActions.limpar();
		}
		else{
			AngelGirls.Processando().hide();
			alert(dado.menssagem);
		}
	},"json");
};

/*************** TELEFONES *******************/

var FormTelefoneActions = new Object(); 
FormTelefoneActions.editar = function (id,tipo,ddd,telefone,operadora){
	FormTelefoneActions.limpar();
	jQuery('#btnAdicionarTelefone').removeClass('in');
	jQuery('#btnCancelarSalvarTelefone').addClass('in');
	jQuery('#btnSalvarTelefone').addClass('in');
	jQuery('#idTelefone').val(id);
	jQuery('#tipoTelefone').val(tipo);
	jQuery('#ddd').val(ddd);
	jQuery('#telefone').val(telefone);
	jQuery('#operadora').val(operadora);
};

FormTelefoneActions.urlPadrao = "";

	
FormTelefoneActions.padrao = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormTelefoneActions.urlPadrao), {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormTelefoneActions.RecarregarLista();
				FormTelefoneActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormTelefoneActions.urlRemover =  "";

FormTelefoneActions.remover = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormTelefoneActions.urlRemover) , {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormTelefoneActions.RecarregarLista();
				FormTelefoneActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormTelefoneActions.urlLista =  "";

FormTelefoneActions.RecarregarLista = function(){
	jQuery.get(AngelGirls.URLNoCache(FormTelefoneActions.urlLista), {},function(dado){
		jQuery('#tabelaTelefones').html(dado);
	},"html");
};

FormTelefoneActions.estadoPadrao = "";
FormTelefoneActions.limpar = function(){
	jQuery('#btnCancelarSalvarTelefone').removeClass('in');
	jQuery('#btnSalvarTelefone').removeClass('in');
	jQuery('#btnAdicionarTelefone').removeClass('in');	


	jQuery('#idTelefone').val('');
	jQuery('#tipoTelefone').val('RESIDENCIAL');
	jQuery('#ddd').val('');
	jQuery('#telefone').val('');
	jQuery('#operadora').val('');
	jQuery('#btnAdicionarTelefone').addClass('in');

};

FormTelefoneActions.urlEnviar = "";

FormTelefoneActions.enviar = function (){

	var erro= false;
	if(jQuery('#ddd').val()=="" || jQuery('#ddd').val().length<2){
		jQuery('#ddd').removeClass('valid');
		jQuery('#ddd').addClass('error');
		jQuery('#ddd').addClass('invalid');
		jQuery("label[for='ddd']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#ddd').addClass('valid');
		jQuery('#ddd').removeClass('invalid');
		jQuery('#ddd').removeClass('error');
		jQuery("label[for='ddd']").removeClass('invalid');
	}
	if(jQuery('#telefone').val()=="" || jQuery('#telefone').val().length<9){
		jQuery('#telefone').removeClass('valid');
		jQuery('#telefone').addClass('error');
		jQuery('#telefone').addClass('invalid');
		jQuery("label[for='telefone']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#telefone').addClass('valid');
		jQuery('#telefone').removeClass('invalid');
		jQuery('#telefone').removeClass('error');
		jQuery("label[for='telefone']").removeClass('invalid');
	}
	if(jQuery('#operadora').val()=="" ){
		jQuery('#operadora').removeClass('valid');
		jQuery('#operadora').addClass('error');
		jQuery('#operadora').addClass('invalid');
		jQuery("label[for='operadora']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#operadora').addClass('valid');
		jQuery('#operadora').removeClass('invalid');
		jQuery('#operadora').removeClass('error');
		jQuery("label[for='operadora']").removeClass('invalid');
	}

	if(erro){
		alert('Dados inv&aacute;ldos.');
		return;
	}
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormTelefoneActions.urlEnviar), {
		id: jQuery('#idTelefone').val(),
		tipo: jQuery('#tipoTelefone').val(),
		ddd:jQuery('#ddd').val(),
		telefone : jQuery('#telefone').val(),
		operadora:jQuery('#operadora').val(),
	},function(dado){
		if(dado.ok=='ok'){
			FormTelefoneActions.RecarregarLista();
			AngelGirls.Processando().hide();
			FormTelefoneActions.limpar();
		}
		else{
			AngelGirls.Processando().hide();
			alert(dado.menssagem);
		}
	},"json");
};
				
/**************************** EMAILS ****************************************/

var FormEmailActions = new Object(); 
FormEmailActions.editar = function (id,email){
	FormEmailActions.limpar();
	jQuery('#btnAdicionarEmail').removeClass('in');
	jQuery('#btnCancelarSalvarEmail').addClass('in');
	jQuery('#btnSalvarEmail').addClass('in');
	jQuery('#idEmail').val(id);
	jQuery('#email').val(email);
};

FormEmailActions.urlPadrao = "";

	
FormEmailActions.padrao = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEmailActions.urlPadrao), {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormEmailActions.RecarregarLista();
				FormEmailActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormEmailActions.urlRemover =  "";

FormEmailActions.remover = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEmailActions.urlRemover) , {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormEmailActions.RecarregarLista();
				FormEmailActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormEmailActions.urlLista =  "";

FormEmailActions.RecarregarLista = function(){
	jQuery.get(AngelGirls.URLNoCache(FormEmailActions.urlLista), {},function(dado){
		jQuery('#tabelaEmails').html(dado);
	},"html");
};

FormEmailActions.estadoPadrao = "";
FormEmailActions.limpar = function(){
	jQuery('#btnCancelarSalvarEmail').removeClass('in');
	jQuery('#btnSalvarEmail').removeClass('in');
	jQuery('#btnAdicionarEmail').removeClass('in');	


	jQuery('#idEmail').val('');
	jQuery('#email').val('');
	jQuery('#btnAdicionarEmail').addClass('in');

};

FormEmailActions.urlEnviar = "";

FormEmailActions.enviar = function (){

	var erro= false;
	if(jQuery('#email').val()=="" || jQuery('#email').val().length<5){
		jQuery('#email').removeClass('valid');
		jQuery('#email').addClass('error');
		jQuery('#email').addClass('invalid');
		jQuery("label[for='email']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#email').addClass('valid');
		jQuery('#email').removeClass('invalid');
		jQuery('#email').removeClass('error');
		jQuery("label[for='email']").removeClass('invalid');
	}


	if(erro){
		alert('Dados inv&aacute;ldos.');
		return;
	}
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormEmailActions.urlEnviar), {
		id: jQuery('#idEmail').val(),
		email:jQuery('#email').val()
	},function(dado){
		if(dado.ok=='ok'){
			FormEmailActions.RecarregarLista();
			AngelGirls.Processando().hide();
			FormEmailActions.limpar();
		}
		else{
			AngelGirls.Processando().hide();
			alert(dado.menssagem);
		}
	},"json");
};



/**************************************** REDE SOCIAL ***********************************/



var FormRedeSocialActions = new Object(); 

FormRedeSocialActions.urlPadrao = "";

	
FormRedeSocialActions.padrao = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormRedeSocialActions.urlPadrao), {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormRedeSocialActions.RecarregarLista();
				FormRedeSocialActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormRedeSocialActions.urlRemover =  "";

FormRedeSocialActions.remover = function (idParam){
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormRedeSocialActions.urlRemover) , {
		id: idParam
		},function(dado){
			if(dado.ok=='ok'){
				FormRedeSocialActions.RecarregarLista();
				FormRedeSocialActions.limpar();
				AngelGirls.Processando().hide();
			}
			else{
				AngelGirls.Processando().hide();
				alert(dado.menssagem);
			}
	},"json");
};

FormRedeSocialActions.urlLista =  "";

FormRedeSocialActions.RecarregarLista = function(){
	jQuery.get(AngelGirls.URLNoCache(FormRedeSocialActions.urlLista), {},function(dado){
		jQuery('#tabelaRedesSociais').html(dado);
	},"html");
};

FormRedeSocialActions.estadoPadrao = "";
FormRedeSocialActions.limpar = function(){
	jQuery('#btnCancelarSalvarRedeSocial').removeClass('in');
	jQuery('#btnSalvarRedeSocial').removeClass('in');
	jQuery('#btnAdicionarRedeSocial').removeClass('in');	
	jQuery('#rede').val('');
	jQuery('#dropdownMenuRedeSocial').html('Redes Sociais');
	jQuery('#contato').val('');
	jQuery('#btnAdicionarRedeSocial').addClass('in');

};

FormRedeSocialActions.urlEnviar = "";

FormRedeSocialActions.enviar = function (){

	var erro= false;
	if(jQuery('#rede').val()==""){
		jQuery('#rede').removeClass('valid');
		jQuery('#rede').addClass('error');
		jQuery('#rede').addClass('invalid');
		jQuery("label[for='rede']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#rede').addClass('valid');
		jQuery('#rede').removeClass('invalid');
		jQuery('#rede').removeClass('error');
		jQuery("label[for='rede']").removeClass('invalid');
	}

	if(jQuery('#contato').val()=="" || jQuery('#contato').val().length<5){
		jQuery('#contato').removeClass('valid');
		jQuery('#contato').addClass('error');
		jQuery('#contato').addClass('invalid');
		jQuery("label[for='contato']").addClass('invalid');
		erro= true;
	}
	else{
		jQuery('#contato').addClass('valid');
		jQuery('#contato').removeClass('invalid');
		jQuery('#contato').removeClass('error');
		jQuery("label[for='contato']").removeClass('invalid');
	}

	if(erro){
		alert('Dados inv&aacute;ldos.');
		return;
	}
	AngelGirls.Processando().show();
	jQuery.post(AngelGirls.URLNoCache(FormRedeSocialActions.urlEnviar), {
		rede :jQuery('#rede').val(),
		contato: jQuery('#contato').val(),
	},function(dado){
		if(dado.ok=='ok'){
			FormRedeSocialActions.RecarregarLista();
			AngelGirls.Processando().hide();
			FormRedeSocialActions.limpar();
		}
		else{
			AngelGirls.Processando().hide();
			alert(dado.menssagem);
		}
	},"json");
};
							
FormRedeSocialActions.selecionarRede = function(rede, obj){
	var option = jQuery('#'+obj);
	var hidden = jQuery('#rede')
	hidden.val(rede);
	jQuery('#dropdownMenuRedeSocial').html(option.html());
}

