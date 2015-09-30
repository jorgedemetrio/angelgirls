jQuery(document).ready(function(){
	
	jQuery('.btnReprovar').click(function(){
		var url = 'index.php?option=com_angelgirls&view=sessoes&task=repovarFrom&id='+jQuery(this).attr('data-id');
		AngelGirls.FrameModal("Cadastrar Novo Figurino", url, "Rejeitar a sess&atilde;o", "JavaScript: $('#iFrameModal').contents().find('#reprovarForm').submit();",270);
	});
	
	jQuery('.btnAprovar').click(function(){
		window.location = document.PathBase + 'index.php?option=com_angelgirls&view=sessoes&task=aprovarSessao&id='+jQuery(this).attr('data-id');
	});
});