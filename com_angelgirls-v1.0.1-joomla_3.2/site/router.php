<?php
/*------------------------------------------------------------------------
# router.php - Angel Girls Component
# ------------------------------------------------------------------------
# author    Jorge Demetrio
# copyright Copyright (C) 2015. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.angelgirls.com.br
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

function AngelgirlsBuildRoute(&$query)
{
	$segments = array();

	if(isset($query['view'])){
		$segments[] = $query['view'];
		unset($query['view']);
	};

	if(isset($query['id'])){
		$segments[] = $query['id'];
		unset($query['id']);
	};

	return $segments;
}

function AngelgirlsParseRoute($segments)
{
	$vars = array();
	// Count segments
	$count = count($segments);
	//Handle View and Identifier
	switch($segments[0])
	{
		case 'angelgirls':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'angelgirls';
			break;

		case 'angelgirl':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'angelgirl';
			break;
		case 'galerias':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'galerias';
			break;

		case 'galeria':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'galeria';
			break;
		case 'fotos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'fotos';
			break;

		case 'foto':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'foto';
			break;
		case 'agendas':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'agendas';
			break;

		case 'agenda':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'agenda';
			break;
		case 'modelos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'modelos';
			break;

		case 'modelo':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'modelo';
			break;
		case 'fotografos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'fotografos';
			break;

		case 'fotografo':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'fotografo';
			break;
		case 'equipes':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'equipes';
			break;

		case 'equipe':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'equipe';
			break;
		case 'locacoes':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'locacoes';
			break;

		case 'locacao':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'locacao';
			break;
		case 'produtos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'produtos';
			break;

		case 'produto':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'produto';
			break;
		case 'enderecos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'enderecos';
			break;

		case 'endereco':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'endereco';
			break;
		case 'telefones':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'telefones';
			break;

		case 'telefone':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'telefone';
			break;
		case 'emails':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'emails';
			break;

		case 'email':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'email';
			break;
		case 'dadoscomplementares':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'dadoscomplementares';
			break;

		case 'dadocomplementar':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'dadocomplementar';
			break;
		case 'temas':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'temas';
			break;

		case 'tema':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'tema';
			break;
		case 'concursos':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'concursos';
			break;

		case 'concurso':
			$id = explode(':', $segments[$count-1]);
			$vars['id'] = (int) $id[0];
			$vars['view'] = 'concurso';
			break;
	}

	return $vars;
}
?>