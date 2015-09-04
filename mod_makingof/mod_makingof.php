<?php
/**
 * @version     1.0
 * @package     mod_makingof
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @author      Jorge Demetrio
 */
//No Direct Access
defined('_JEXEC') or die;


// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$quantidade = 	htmlspecialchars($params->get('quantidade'));
$db = JFactory::getDbo();
$query = $db->getQuery(true);

$query
    ->select(array('c.id', 'c.title', 'c.alias', 'c.introtext', 'c.images', 'ca.alias as aliascat', 'ca.title as titlecat'))
    ->from($db->quoteName('#__content', 'c'))
    ->join('INNER', $db->quoteName('#__categories', 'ca') . ' ON (' . $db->quoteName('c.catid') . ' = ' . $db->quoteName('ca.id') . ')')
    ->where($db->quoteName('c.catid') . '  = 10 ')
    ->order($db->quoteName('c.modified') . ' DESC');

//$sql = printf(" SELECT * FROM (SELECT c.id, c.title, c.alias, c.introtext, c.images, ca.alias as aliascat, ca.title as titlecat FROM #__content AS c JOIN #__categories ca ON c.catid = ca.id WHERE c.catid = 10 ORDER BY modified DESC, ordering) AS T LIMIT %d ", $quantidade);




require JModuleHelper::getLayoutPath('mod_makingof', $params->get('layout', 'default'));
?>