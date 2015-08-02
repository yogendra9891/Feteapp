<?php
/**
 * @version     1.0.0
 * @package     com_event
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra9891 <yogendra.singh@daffodilsw.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
require_once('components/com_event/tables/events.php');
require_once('components/com_event/tables/eventsinfo.php');
require_once('components/com_event/tables/order.php');
/**
 * EVENT model.
 */
class EventModelEventdetail extends JModelList {
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_EVENT';

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk)
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->populateState();
		// Select the required fields from the table.
		$query->select( 'a.*, a.id as eventid');
		$query->select(' b.*');
        $query->from('`#__events` AS a');
		$query->join('INNER', $db->quoteName('#__eventsinfo').' AS b ON a.id = b.eventid');
		$query->where('a.id = '.$pk); 
		$db->setQuery($query);
		$db->query();
		$item = $db->loadObject();
		return $item;
	}

}