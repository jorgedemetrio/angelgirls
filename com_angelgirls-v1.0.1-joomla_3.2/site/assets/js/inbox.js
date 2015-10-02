var INBOX = new Object();

INBOX.AtivarConteudo = function(tipo){
	$option = jQuery('#'+tipo+'-OPTION');
	jQuery('#corpoMensagem').fadeOut(500);
	console.log($option);
	if($option.length>0){
		jQuery('.tiposCaixas').removeClass('active');
		$option.addClass('active');	
		AngelGirls.Processando().show();
		jQuery.post(INBOX.AtivarConteudoURL, {caixa: tipo},function(dado){
			AngelGirls.Processando().hide();
			jQuery('#caixas').html(dado);
			
		    jQuery("#tabelaInbox").DataTable({
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"language": {
		            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
		            "zeroRecords": "Vazio",
		            "info": "Exibir pag. _PAGE_ de _PAGES_",
		            "infoEmpty": "Sem registros",
		            "infoFiltered": "(filtrado de _MAX_ total)",
					"search": "Busca"
		        },
				"aoColumns": [
		            {"orderSequence":null},
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] }
		        ]
			});
			
		},"html");
	}
	
	
}

jQuery(document).ready(function() {

	
	

		    jQuery("#tabelaInbox").DataTable({
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"language": {
		            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
		            "zeroRecords": "N&atilde;o encontrado - sorry",
		            "info": "Exibir pag. _PAGE_ de _PAGES_",
		            "infoEmpty": "Sem registros",
		            "infoFiltered": "(filtrado de _MAX_ total)",
					"search": "Busca"
		        },
				"aoColumns": [
		            null,
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] }
		        ]
			});
		    //jQuery("#para").tokenInput("http://shell.loopj.com/tokeninput/tvshows.php");
		    
//			jQuery('#para').tokenfield({
//				  autocomplete: {
//				    source: ['red','blue','green','yellow','violet','brown','purple','black','white'],
//				    delay: 100
//				  },
//				  showAutocompleteOnFocus: true
//				});
		
		
});