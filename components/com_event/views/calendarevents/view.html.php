<?php
/**
 * @version     1.0.0
 * @package     com_event
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      abhishek <abhishek.gupta@daffodilsw.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
require_once JPATH_COMPONENT.'/helpers/event.php';

/**
 * View class for a list of Events.
 */
class EventViewCalendarevents extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{  
		$this->items		= $this->get('Items');  
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		// Check for errors.
        parent::display($tpl);
	}

    /*
     * finding the eventtype by ids
     * @params eventypeid
     */    
    public function eventype($eventtypeid){
		// Create a new query object.
		$db = JFactory::getdbo();
		$query = $db->getQuery(true);
		$query->select('a.name');
		$query->from('#__eventtypes as a');
		$query->where('a.id = '.$eventtypeid);
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
    }
    /*
     * finding the country name from country code
     * @params countrycode
     */
      public function countryname($ccode){
		// Create a new query object.
		$db = JFactory::getdbo();
		$query = $db->getQuery(true);
		$query->select('a.country');
		$query->from('#__countries as a');
		$query->where('a.ccode = '.'"'.$ccode.'"');
		$db->setQuery($query); 
		$result = $db->loadResult();
		return $result;
    }
}
