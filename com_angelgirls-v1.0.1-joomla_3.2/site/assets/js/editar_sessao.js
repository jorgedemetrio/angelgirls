jQuery(document).ready(function(){
	jQuery('#meta_descricao').restrictLength($('#maxlength'));
	jQuery('#comentario').restrictLength($('#maxlengthComentario'));
	
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
	
});