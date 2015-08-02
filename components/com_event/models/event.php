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
class EventModelEvent extends JModelList {
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_EVENT';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'events', $prefix = 'EventTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_event.event', 'event', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_event.edit.event.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

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

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM event');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}
	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   2.5
	 */
	public function save($data)
	{  
		$dispatcher = JEventDispatcher::getInstance();
		$table = $this->getTable();
		if(array_key_exists('musictype', $data)){
		$musictype = $this->musictype($data);
		$data['musictype'] = $musictype; }
		//@TODOchecking for the per event cost is published..
		$table->load($data['eventid']);
		if (!$table->save($data)) { 
			$this->setError(JText::sprintf('COM_EVENT_UPDATE_FAILED', $table->getError()));
			return false;
		}
		else{
	     $eventsinfo = &JTable::getInstance('Eventsinfo', 'EventTable');
	     $data['eventid'] =	$table->id;	
	     $eventsinfo->load($data['eventinfoid']);
			if (!$eventsinfo->save($data)) { 
				$this->setError(JText::sprintf('COM_EVENT_UPDATE_FAILED', $eventsinfo->getError()));
				return false;
			}
		}
		return $table->id;
	}
	/*
	 * startime make..
	 */
	private function musictype($data){ 
		$musictype = '';
		if(array_key_exists('musictype', $data))
		$musictype = implode(',', @$data['musictype']);
		return $musictype;
	}
  /*
   * check per event cost is published..
   */	
	public function chkPublishPerEventCost(){
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select( 'a.published, a.cost');
        $query->from('`#__eventfees` AS a');
		$query->where('a.id = '.(int)'2'); 
		$db->setQuery($query);
		$db->query();
		$item = $db->loadObject();
		return $item;
	}
	/*
	 * function for checking the user is subsribed and the event adding date is less then the subscription date.
	 */
	public function checksubscribeduser(){
		return 1;
	}
		/*function to save order
         * @params Mixed data from form post
         * @return set orderid in state 
         */
   public function saveOrder($requestData)
   {
   	    $userid = JFactory::getUser()->id;
        $orderdata = $this->getState('orderdata');
		$musictype = $this->musictype($orderdata);
		$orderdata['musictype'] = $musictype; 
		$orderdata['userid'] = $userid;
//		$date1 = &JFactory::getDate();
//   		$orderdata['date'] = $date1->toFormat();
        $orderdata['orderid']=0;
        // Initialise variables.
		$row = $this->getTable('order','EventTable');
		// save the event temperory after complete image validation    
		if($row->save($orderdata))
		{    
			return $row->id;	
		}else{
			$this->setError($row->getError());
			return 0;
		}
   }
	/*function remove order from order table
	  * Event add order is cancelled by user or no successfully paid
	  */
	 function cancelOrder($oid)
	 {
	 	// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query = 'DELETE FROM #__orders WHERE orderid =' .$oid;
		$db->setQuery($query);
		$db->query();
		return true;
	 }
   /*
   * 
   * finding the cost of the featured event.
   */	
     public function findcostfeatured(){
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select( 'a.cost');
        $query->from('`#__eventfees` AS a');
		$query->where('a.id = '.(int)'3'); 
		$db->setQuery($query);
		$db->query();
		$featuredcost = $db->loadResult();
		return $featuredcost;
     }
  /*
   * getting the order which is saved temporarly..
   */	
	public function getOrder($orderid){
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select( 'a.*' );
        $query->from('`#__orders` AS a');
		$query->where('a.orderid = '.$orderid); 
		$db->setQuery($query);
		$db->query(); 
		$orderdata = $db->loadObject();
		return $orderdata;
	}
   /*
    * adding a new event when order successfull payment maked
    */ 
	public function addNewEvent($orderobj){
		$dispatcher = JEventDispatcher::getInstance();
		$table = &JTable::getInstance('Events', 'EventTable'); 
		if (!$table->save($orderobj)) { 
			$this->setError(JText::sprintf('COM_EVENT_ADD_FAILED', $table->getError()));
			return false;
		}
		else{
	     $eventsinfo = &JTable::getInstance('Eventsinfo', 'EventTable');		
		 $orderobj->eventid = $table->id;
			if (!$eventsinfo->save($orderobj)) { 
				$this->setError(JText::sprintf('COM_EVENT_UPDATE_FAILED', $eventsinfo->getError()));
				return false;
			}
		} 
		return true;
	} 
	/*
	 * function for finding the no. of events currently added by logged in user
	 */
	public function findEventNo(){
		$userid = JFactory::getUser()->id;
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select( 'count(a.id)' );
        $query->from('`#__events` AS a');
		$query->join('INNER', $db->quoteName('#__eventsinfo').' AS b ON a.id = b.eventid');        
		$query->where('a.userid = '.$userid); 
		$db->setQuery($query);
		$db->query(); 
		$totalevent = $db->loadResult();
		return $totalevent;
	}
	/*
	 * function for getting the event data..
	 */
	public function getEvent($eventid){
		$userid = JFactory::getUser()->id;
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select( 'a.*' );
        $query->from('`#__events` AS a');
		$query->where('a.id = '.$eventid); 
		$db->setQuery($query);
		$db->query(); 
		$eventdata = $db->loadObject();
		return $eventdata;
	}
	/*
	 * function for update the event when it make featured at edit time..
	 */
	public function featuredEvent($eventdata){
		$dispatcher = JEventDispatcher::getInstance();
		$table = &JTable::getInstance('Events', 'EventTable'); 
		$table->load($eventdata['eventid']);
		if (!$table->save($eventdata)) { 
			$this->setError(JText::sprintf('COM_EVENT_EDIT_FAILED', $table->getError()));
			return false;
		}
		return true;
	}
}