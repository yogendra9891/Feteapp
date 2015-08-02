<?php

/**
 * @version     1.0.0
 * @package     com_event
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra <yogendra.singh@daffodilsw.com> - http://
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of events records.
 */
class EventModelEvents extends JModelList {

	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 * @see        JController
	 * @since    1.6
	 */
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
                'startdate', 'a.startdate',
                'enddate', 'a.enddate',
                'promotorname', 'a.promotorname',
                'country', 'b.country'
            );
        }
		
		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {

		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
		$this->setState('list.start', $limitstart);
        //set the state for sorting the column..
        $ordering =  $this->setState('list.ordering', JFactory::getApplication()->input->getVar('filter_order')); 
        $direction =  $this->setState('list.direction', JFactory::getApplication()->input->getVar('filter_order_Dir'));
		$searchfltr = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '', 'string'); 
		$countryfltr = $app->getUserStateFromRequest($this->context.'.filter.country', 'filter_country', '', 'string'); 
		$this->setState('filter.search', $searchfltr);
		$this->setState('filter.country', $countryfltr);
      // List state information.
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		return parent::getStoreId($id);
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery() { 
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->populateState();
		// Select the required fields from the table.
		$query->select(
		$this->getState(
                        'list.select', 'a.*, a.id as eventid'
                        )
                        );
		$query->select(' b.*');
        $query->from('`#__events` AS a');
		$query->join('INNER', $db->quoteName('#__eventsinfo').' AS b ON a.id = b.eventid');
		$query->where('a.published = '.'1');
		$query->where('DATE_ADD(ADDTIME(a.enddate, a.endtime) , INTERVAL 7 DAY)>= NOW()'); // check the events is enddate is 7 days greater than today date.. 
         // Filter by search in title
         $search = $this->getState('filter.search'); 
         if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
               $query->where('a.id = '.(int) substr($search, 3));
               } else {
                  $search = $db->Quote('%'.$db->escape($search, true).'%');
                      }
          $query->where('a.title LIKE '.$search);              
            } 
           $country = $this->getState('filter.country'); 
          if (!empty($country)) {
			$query->where('b.country = '.'"'.$country.'"');     
          }
		// Add the list ordering clause.
		$orderCol = $this->getState('list.ordering', 'a.title');
		$orderDirn = $this->getState('list.direction', 'asc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn)); 
        return $query;
	}
}
