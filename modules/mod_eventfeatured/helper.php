<?php
/**
 * Helper class for Featured Events! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules yogendra singh
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_featured is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
define('IMG_UPLOAD_DIR_PATH', 'media/com_event/event/original/');
define('IMG_THUMB_UPLOAD_DIR_PATH', 'media/com_event/event/thumb/');

class modEventfeaturedHelper
{
    /**
     * Retrieves the featured events from events
     *
     * @access public
     */    
    public function getFeaturedevents()
    {
		// Create a new query object.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select('a.*, a.id as eventid');
		$query->select(' b.*');
        $query->from('`#__events` AS a');
		$query->join('INNER', $db->quoteName('#__eventsinfo').' AS b ON a.id = b.eventid');
		$query->where('a.published = '.'1');
		$query->where('DATE_ADD(ADDTIME(a.enddate, a.endtime) , INTERVAL 7 DAY)>= NOW()'); // check the events is enddate is 7 days greater than today date..
		$query->where('a.featured = "1"');  // checking featured events....featured is enum type so its a string comparison..
        $db->setQuery($query);
        $db->query(); 
        $result = $db->loadObjectList(); 
        return $result;
    }
}
?>
