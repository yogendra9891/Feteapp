<?php
/**
 * Event Featured! Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules yogendra singh
 * @link http://dev.joomla.org/component/option,com_event/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_featured is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$featuredEvents = modEventfeaturedHelper::getFeaturedevents();
require( JModuleHelper::getLayoutPath('mod_eventfeatured') );
?>
