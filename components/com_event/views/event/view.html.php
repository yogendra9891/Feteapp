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
class EventViewEvent extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{  
		$this->item = JFactory::getApplication()->getUserState('event.owner.data'); //print_r($this->item); exit;
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
  * function for making the html for music type selection
  * @params musictypeids.
  */   
    public function musictypeselection($musictypeids=''){
    	$musictype = explode(',',  $musictypeids);
		// Initialize variables.
		$options = array();
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.id, a.name');
		$query->from('#__musictypes AS a');
		$query->order('a.name');
		// Get the options.
		$db->setQuery($query);
		$options = $db->loadObjectList();
    	$html ='';
    	$i =1;
    	foreach($options as $option){
    		$checked = '';
    		if(in_array($option->id, $musictype, true)){
    			$checked = 'checked=checked';
    		}
    		
    		$html.='<input type="checkbox" name="jform[musictype][]" id="jform_musictype_'.$i.'" value="'.$option->id.'"'.$checked.'>&nbsp;&nbsp;'.$option->name.'&nbsp;';
    	    $i++;
    	}
    	return $html;
    }
    
}
