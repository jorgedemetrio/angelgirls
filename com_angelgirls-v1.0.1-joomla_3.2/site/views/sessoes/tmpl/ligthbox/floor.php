
		</div>
	</body>
</html>
<script>
jQuery(document).ready(function(){
	jQuery('#descricao').restrictLength($('#maxlength'));
	
	jQuery.validate({
	    modules : 'security, date, file, html5',
	    language : ptBRValidation,
	    decimalSeparator : ','
	}); 
}); 		
</script>

