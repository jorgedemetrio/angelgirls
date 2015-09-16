<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}


$conteudo = JRequest::getVar('usuario');
$ultimas = JRequest::getVar('ultimas');
$vistas = JRequest::getVar('vistas');
$gostaram = JRequest::getVar('gostaram');


$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id.':full');


?>
<div class="page-header">
	<h1><small>Fotograf<?php 
				if($conteudo->sexo=='F'){
					echo('a');
				}
				else{
					echo('o');
				}
				?></small> <?php echo($conteudo->nome);?>
	<div class="gostar" data-gostei='<?php echo($conteudo->gostei);?>' data-id='<?php echo($conteudo->id);?>' data-area='fotografo' data-gostaram='<?php echo($conteudo->audiencia_gostou);?>'></div>
</h1>
<div clas="well hidden-phone"><?php echo($conteudo->descricao);?></div>
<h3>Dados do fotograf<?php 
				if($conteudo->sexo=='F'){
					echo('a');
				}
				else{
					echo('o');
				}
				?></h3>
<div class="row">
	<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">	
		<img src="<?php echo($urlFoto );?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>"/>
	</div>
<!-- 	
		$query->select('f.id, `f`.`nome_artistico` AS `nome`,`f`.`audiencia_gostou`,`f`.`nome_foto` AS `foto`, `f`.`meta_descricao`, f.descricao, f.data_nascimento,
						f.sexo, f.nascionalidade, f.site, f.profissao, f.id_cidade_nasceu, f.id_cidade, f.audiencia_view, u.name as nome_completo,
						cnasceu.uf as estado_nasceu, cnasceu.nome as cidade_nasceu,
						cvive.uf as estado_mora, cvive.nome as cidade_mora,
						CASE isnull(`vt_f`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei`')
 -->	
	<div class="col col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<div class="row">
			<div class="label col col-xs-12 col-sm-6 col-md-3 col-lg-3">
				Nome completo
			</div>
			<div class="label col col-xs-12 col-sm-6 col-md-2 col-lg-2">
				Data de nascimento
			</div>	
			<div class="label col col-xs-12 col-sm-6 col-md-2 col-lg-2">
				Sexo
			</div>	
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<?php echo($conteudo->nome_completo);?>
			</div>
			<div class="col col-xs-12 col-sm-6 col-md-2 col-lg-2 text-center">
				<?php 
				if(isset($conteudo->data_nascimento)){
					echo(JFactory::getDate($conteudo->data_nascimento)->format('d/m/Y'));
				}?>
			</div>	
			<div class="col col-xs-12 col-sm-6 col-md-2 col-lg-2 text-center">
				<?php 
				if($conteudo->sexo=='M'){
					echo('Masculino');
				}
				else{
					echo('Feminino');
				}
				?>
			</div>		
		</div>		
	</div>
</div>
<h3>Ultimas sess&otilde;es</h3>
<h3>Sess&otilde;es mais agradaram</h3>
<h3>Sess&otilde;es mais acessadas</h3>

<h3>Coment&aacute;rios</h3>
<div class="fb-comments" data-href="http://<?php echo($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); ?>" data-width="100%" style="margin: 0 auto;"></div>


