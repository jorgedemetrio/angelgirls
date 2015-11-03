<?php
$sessoes = JRequest::getVar('albuns');
foreach($sessoes as $conteudo){ ?>
<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
	<div class="thumbnail">
	<?php  
	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->alias))); 
	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->id.':ico');
	?>
						<h5 class="list-group-item-heading"
			style="width: 100%; text-align: center; background-color: grey; color: white; padding: 10px;">
			<a href="<?php echo($url);?>" style="color: white;"><?php echo($conteudo->nome);?></a>
				<div class="gostar" data-gostei='<?php echo($conteudo->eu);?>' data-id='<?php echo($conteudo->id);?>' data-area='sessao' data-gostaram='<?php echo($conteudo->gostou);?>'></div></h5>
	<?php 			if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
						<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" 	title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>" /></a>
					<?php 
					}?>
					<div class="caption">

			<p class="text-center"><?php echo($conteudo->descricao);?></p>
			<p class="text-center">
				<a href="<?php echo($url);?>" class="btn btn-primary" role="button"
					style="text-overflow: ellipsis; max-width: 150px; overflow: hidden; direction: ltr;"><?php echo($conteudo->nome);?>
	
					</a>
			</p>
		</div>
	</div>
</div>
<?php
}
$contador = sizeof($sessoes);
echo("<script>lidos+=$contador;\n");
if($contador<AngelgirlsController::LIMIT_DEFAULT):
	echo('jQuery("#carregando").css("display","none");temMais=false;');	
endif;
echo("</script>");