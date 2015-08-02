<?php
/**
 * @version     1.0.0
 * @package     com_events
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra <yogendra.singh@daffodilsw.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/event.php';
/**
 * Events list controller class.
 */
class EventControllerEventdetail extends EventController
{  
    function __construct() {
        $this->view_list = 'events';
        parent::__construct();
    }
		/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Eventdetail', $prefix = 'EventModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    /*
    * function for detail a Event
    * @params, id
    */
   	public function eventdetail()
	{   
		$app   = JFactory::getApplication();
		$model = $this->getModel(); 
		$cid   = $app->input->getInt('id');
		$currentuser = JFactory::getUser();
		$record = $model->getItem($cid); 
		$this->input->set('layout', 'default');
        $urlVar = '&id'; 
        $app->setUserState('event.detail.data', $record); 
		$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=eventdetail'
					. $this->getRedirectToItemAppend($cid, $urlVar), false
				)
			);

			return true;
	}
}