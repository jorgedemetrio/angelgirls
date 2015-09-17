	var cpfModeloValido = true;
	
	var imagemPerfil = 'perfil.png'; 
	var imagemCorpo =  'no_image.png';
	var imagemCorpo_horizontal =  'no_image.png';
	var imagemRosto =  'no_image.png';

	
	
jQuery(document).ready(function(){
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