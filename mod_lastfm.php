<?php
/**
 * LastFM Recent Tracks Module
 *
 * @version 0.1.5
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

require_once('helper.php');

// Module stuffs
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$lastfm_apikey   = $params->get('lastfm_apikey', '');
$lastfm_username = $params->get('lastfm_username', '');

// LastFM API stuffs
$lastfm   = new modLastFMHelper($lastfm_apikey, $lastfm_username);
$extended = $lastfm->getExtended();
$recent   = $lastfm->getTracks();
$user     = $lastfm->getUser();

require(ModuleHelper::getLayoutPath('mod_lastfm', $params->get('layout', 'default')));
