<?php
/**
 * @version     1.0.0
 * @package     com_event
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      abhishek <yogendra.singh@daffodilsw.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
require_once JPATH_COMPONENT.'/helpers/event.php';
/**
 * View class for a list of Events.
 */
class EventViewEventdetail extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{  
		$this->item = JFactory::getApplication()->getUserState('event.detail.data');  //print_r($this->item); exit;
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
  /*
  * function for finding the music type name..
  * @params musictypeids.
  */   
    public function musictypename($musictypeid){
		// Initialize variables.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.name');
		$query->from('#__musictypes AS a');
		$query->where('a.id='.$musictypeid);
		// Get the options.
		$db->setQuery($query);
		$musicname = $db->loadResult();
     	return $musicname;
    }
	/**
	 * gets a name of options for Dresscode.
	 *
	 * @return	option array
	 */

	public static function getDresscodeOptions($dresscodeid){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.name');
		$query->from('#__dresscodes AS a');
		$query->where('a.id='.$dresscodeid);
		$db->setQuery($query);
		$dresscodename = $db->loadResult(); 
		return $dresscodename;
		}
    
}
