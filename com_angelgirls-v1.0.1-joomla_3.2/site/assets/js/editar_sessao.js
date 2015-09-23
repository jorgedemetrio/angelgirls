jQuery(document).ready(function(){
	jQuery('#meta_descricao').restrictLength($('#maxlength'));
	jQuery('#comentario').restrictLength($('#maxlengthComentario'));
	
	jQuery.validate({
	    modules : 'security, date, file, html5',
	    language : ptBRValidation,
	    decimalSeparator : ','
	});
	
});