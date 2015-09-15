	var imagemPerfil = 'perfil.png'; 
	var imagemRosto =  'no_image.png';
	
	jQuery(document).ready(function(){
		document.formvalidator.setHandler("telefone", function(value) {
	      regex=/^\(\d{2}\)\s\d{5}\-\d{3,4}$/;
	      return regex.test(value);
		});
		
		document.formvalidator.setHandler("cep", function(value) {
		      regex=/^\d{5}-\d{3}$/;
		      return regex.test(value);
			});
				
		
		document.formvalidator.setHandler("cpf", function(value) {
	      regex=/^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
			jQuery.post("index.php?option=com_angelgirls&view=cadastro&task=validarCPFJson", {cpf:value.replace(".","").replace(".","").replace("-","")},function(dado){
				if(dado.fotografo=="SIM"){
					jQuery("label[for=\'cpf\']").addClass("invalid");
					jQuery("#cpf").addClass("invalid");
					jQuery("#system-message-container").html("<div class=\"alert alert-error\"><p>Existe um fotografo cadastrado com esse CPF, se esse for seu cadadastro entre em contato com contato@angelgirls.com.br .</p></div>");
					jQuery("#cpf").focus();
					return false;
				}
			},"json");
		
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
			
		document.formvalidator.setHandler("username", function(value) {
			jQuery.post("index.php?option=com_angelgirls&view=cadastro&task=validarUsuarioExisteJson", {usuario:value},function(dado){
				if(dado.existe=="SIM"){
					jQuery("label[for=\'username\']").addClass("invalid");
					jQuery("#username").addClass("invalid");
					jQuery("#system-message-container").html("<div class=\"alert alert-error\"><p>Usu&aacute;rio j&aacute; existe, tente outro.</p></div>");
					jQuery("#username").focus();
					return false;
				}
			},"json");
		  if(value.trim().length<5){
			jQuery("#system-message-container").html("<div class=\"alert alert-error\"><p>Usu&aacute;rio deve conter no minimo 5 caracteres.</p></div>");
			return false;			  
		  }
	      return true;
		});
		
		document.formvalidator.setHandler("password", function (value) {
			if(value.trim().length<8){
				jQuery("#system-message-container").html("<div class=\"alert alert-error\"><p>Senha deve conter no minimo 8 caracteres.</p></div>");
				return false;			  
			}
	        return true; 
	    });
		
	    document.formvalidator.setHandler("passverify", function (value) {
	        return (jQuery("password").val() == value); 
	    });
	    
	    document.formvalidator.setHandler("emailverify", function (value) {
	        return (jQuery("email").val() == value); 
	    });							
		jQuery("#ifoto_perfil").click(function(){
			jQuery("#foto_perfil").click();
		});
		jQuery("#foto_perfil").change(function(){
			var valor = jQuery("#foto_perfil").val();
			var valorAntigo = document.PathBaseComponent+imagemRosto;
			jQuery("#ifoto_perfil").attr("src",document.PathBaseComponent+imagemPerfil);
		});
	});