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
class EventControllerEvent extends EventController
{  
    function __construct() {
        $this->view_list = 'events';
        parent::__construct();
    }
		/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Event', $prefix = 'EventModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    /*
    * function for editing a Event Type
    * @params, id
    */
   	public function edit()
	{   
		$app   = JFactory::getApplication();
		$model = $this->getModel(); 
		$cid   = $app->input->getInt('id');
		$ownerid   = $app->input->getInt('ownerid'); 
		$currentuser = JFactory::getUser();
		// Access check.
		if (!($currentuser->id == $ownerid))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}
		$record = $model->getItem($cid); 
        $urlVar = 'ownerid='.$ownerid.'&id'; 
        $app->setUserState('event.owner.data', $record); 
		$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($cid, $urlVar), false
				)
			);

			return true;
	}
	/*
	 * function for saving the events..
	 */
   	public function save()
	{   
		$app   = JFactory::getApplication();
		$model = $this->getModel(); 
		$requestData = $this->input->post->get('jform', array(), 'array'); 
		$currentuser = JFactory::getUser();
		// Access check.
		if (!$currentuser)
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);
			return false;
		}
	     jimport('joomla.filesystem.file');
     	 $jinput = JFactory::getApplication()->input;
         $image_data = $jinput->files->get('jform'); 
         //uploading the event images...
         if($image_data[frontfly][name]){
         	$requestData['frontfly'] = EventHelper::ImageUpload($image_data[frontfly]);
         } 
         if($image_data[backfly][name]){
         	$requestData['backfly'] = EventHelper::ImageUpload($image_data[backfly]);
         }
		
		if(array_key_exists('featured', $requestData)){
			$featuredcost = $model->findcostfeatured();
			$requestData['featured'] = 0;
			$recordid = $model->save($requestData);
	         if($recordid)
	         {  
	         	$eventinfotableid = $requestData['eventinfoid'];
	         	$url = $this->setEditEventPaypalUrl($recordid, $eventinfotableid, $featuredcost); 
	         	if($url!==false){ 
	         	   // $this->setRedirect($url);
	         	   header('Location:'.$url);
	         	   exit;
	         	}else{
			        $this->setMessage(JText::_('COM_EVENT_PAYPAL_REDIRECTION_ERROR'), $type = 'error');
					$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         		}
	         }else{
			   $this->setMessage(JText::_('COM_EVENT_EDIT_ERROR'), $type = 'error');
			   $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         }
		}else{
			$record = $model->save($requestData); 
	        $urlVar = 'ownerid='.$ownerid.'&id'; 
	        $app->setUserState('event.owner.data', $record); 
	        $this->setMessage(JText::_('COM_EVENT_SAVED_SUCCESSFULLY'), $type = 'message');
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return true;
		}
	}
	/*
	 * function for adding a new event by promotor
	 */
	public function add(){
		$app   = JFactory::getApplication();
		$currentuser = JFactory::getUser();
		// Access check.
		if (!$currentuser)
		{
			$this->setError(JText::_('COM_EVENT_ADD_NOT_PERMITED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);
			return false;
		}
		// function calling is cheking the usertype(Promotor/Regular member) for security except Promotor can't add new event.
		$chkusertype = EventHelper::chkusertype();
		if (!($chkusertype->usertype == '1'))
		{
			$this->setError(JText::_('COM_EVENT_ADD_NOT_PERMITED_REGULAR_MEMBER'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);
			return false;
		} 
		$urlVar = $app->input->getVar('task');
		$this->setRedirect(
			JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($cid, $urlVar), false
				)
			);
		return true;
	}
	/*
	 * function for saving a new event created by a Promotor.
	 */
	
	public function saveOrder()
	{ 
		//check for user must logged in
		if (JFactory::getUser()->id == 0){
				$errormessage = JText::_('LOGIN_FIRST');
				$app =& JFactory::getApplication();
				$app->redirect('index.php?option=com_users&view=login', $errormessage,'message');
				}
		// Get the user data.
	     jimport('joomla.filesystem.file');
	     $requestData = $this->input->post->get('jform', array(), 'array'); 
		 $jinput = JFactory::getApplication()->input;
         $image_data = $jinput->files->get('jform'); 
         //uploading the event images...
         if($image_data[frontfly][name]){
         	$requestData['frontfly'] = EventHelper::ImageUpload($image_data[frontfly]);
         } 
         if($image_data[backfly][name]){
         	$requestData['backfly'] = EventHelper::ImageUpload($image_data[backfly]);
         }
	     $app   = JFactory::getApplication();
		 $model = $this->getModel(); 
		 $featuredcost = 0;
		 //finding the cost of the event(featured/per event) added from backend by admin...
		 if(array_key_exists('featured', $requestData))
		 $featuredcost = $model->findcostfeatured();
		 //check the perevent cost is published then find the cost..
		 $ispublish = $model->chkPublishPerEventCost();
		 if($ispublish->published){ $pereventcost = $ispublish->cost;}
		 //check the user is subscribed or has a free featured events offer..
		 $subscribedStatus = $model->checksubscribeduser($requestData); 
		 //if block for subscribed user..
		 if(!$subscribedStatus){
			 $orderid = $this->subscribedUserData($requestData); 
	         if($orderid)
	         {
	         	$url = $this->setPaypalUrl($orderid, $featuredcost); 
	         	if($url!==false){ 
	         	   // $this->setRedirect($url);
	         	   header('Location:'.$url);
	         	   exit;
	         	}else{
			        $this->setMessage(JText::_('COM_EVENT_PAYPAL_REDIRECTION_ERROR'), $type = 'error');
					$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         		}
	         }else{
			   $this->setMessage(JText::_('COM_EVENT_ADD_ERROR'), $type = 'error');
			   $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         }
		 }else{ //else part for unsubscribed user. futher cases is handled in checkEventNo function
     	 	$this->checkEventNo($requestData, $featuredcost);
		 }

	}
	/*
	 * function if a user is a subscribed user..if event mark featured then make payment,
	 * if admin give offer for featured event without pay then can do in if block..
	 */
	private function subscribedUserData($requestData){
	 $app = JFactory::getApplication();
	 $currentuser = JFactory::getUser();
	 $model = $this->getModel();
	 if(array_key_exists('featured', $requestData)){
		 		//@TODO check the user is selected by admin for adding free featured events in if case, else user have to pay for featured event.
		 		if(0){//if featured event is free for subscribed user..
				  	$requestData['userid'] = $currentuser->id;
				  	$requestData['featured'] = 1;
					$record = $model->save($requestData); 
			        $app->enqueueMessage(JText::_('COM_EVENT_SAVED_SUCCESSFULLY'));
					$app->redirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend())); 
		 		}else{// if featured event is not free for subscribed user.. 
		 			$requestData['featured'] = 1;
			 		$model->setState('orderdata', $requestData);
	                $return = $model->saveOrder($requestData); 
	                return $return;
		 		}
	  }else{
	  	$requestData['userid'] = $currentuser->id;
		$record = $model->save($requestData); 
        $app->enqueueMessage(JText::_('COM_EVENT_SAVED_SUCCESSFULLY'));
		$app->redirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend())); 
	  }
	}

    /* function to set paypal setting in paypalurl
	 * @accept basic setting from backend component preferences
	 * @accept order id
	 * return paypal url to redirect
	 * */
	private function setPaypalUrl($orderid, $totalcost)
	{
		$url='';
		$itemId = JRequest::getVar('Itemid');
		$model = $this->getModel();
		$returnurl = 'index.php?option=com_event&task=event.updateorderstatus&Itemid='.$itemId;
		$cancelurl = 'index.php?option=com_event&task=event.cancelOrder&Itemid='.$itemId;
		//get order data for paypal
		$orderdata = $model->getOrder($orderid);
		if(($orderdata->orderid > 0)&&( $orderdata->orderid != '')){
			$params = &JComponentHelper::getParams( 'com_feteapp' );
			if($params->get('paypal')=="sandbox")
			{
				$url='https://www.sandbox.paypal.com/cgi-bin/webscr';
			}else{
				$url='https://www.paypal.com/cgi-bin/webscr';
			}   
			    $url.='?cmd=_xclick';
				$url.='&business='.$params->get('paypalaccount');
				$url.='&return='.urlencode(JRoute::_(JURI::base().$returnurl));
				$url.='&notify_url='.urlencode(JRoute::_(JURI::base().$returnurl));
				$url.='&cancel_return='.urlencode(JRoute::_(JURI::base().$cancelurl.'&order='.$orderdata->orderid));
				$url.='&item_name='.$orderdata->title;
				$url.='&item_number=1';
				$url.='&custom='.$orderdata->orderid;
				$url.='&currency_code=USD';
				$url.='&amount='.$totalcost; 
			return $url;
		}else{
			return false;
		}
		 
	}
	 /*function remove order from order table
	  * order is cancelled by subscriber or no successfully paid
	  */
	 public function cancelOrder()
	 {
	 	$app =& JFactory::getApplication();
	 	//check for user must logged in
		if (JFactory::getUser()->id == 0){
				$errormessage = JText::_('LOGIN_FIRST');
				$app->redirect('index.php?option=com_users&view=login', $errormessage,'message');
				}
	 	$oid = $app->input->getInt('order');  
		if($oid!='' && $oid>0)
		{
			$model = $this->getModel();
			$odata = $model->cancelOrder($oid);
		}
		$url = "index.php?option=com_event&view=events";
		$this->setMessage(JText::_('COM_EVENT_ADD_CANCELED'), $type = 'message');
		$this->setRedirect(JRoute::_($url, false));
	 }
	/*Method to update order status after successful payment
	 * @param orderid
	 * @return true 
	 */
	 
	public function updateOrderStatus()
	{   
		$oid = $_POST['custom'];
		$txn_id = $_POST['txn_id'];
		if($oid!='' && $txn_id != '')
		{
			$model = $this->getModel();
			//getting the data which is saved temporarly in orders table..
			$orderobj = $model->getOrder($oid);
			$model->addNewEvent($orderobj);
            $msg = JText::_('COM_EVENT_ADDED_SUCCESSFULLY');
            $messagetype = 'message'; 
		}else{
            $msg = JText::_('COM_EVENT_ADDED_FAILED');
            $messagetype = 'error'; 
		}
		 $url="index.php?option=com_event&view=events";
		 $this->setMessage($msg, $type = $messagetype);
		 $this->setRedirect(JRoute::_($url, false));
	
	}
 /*
  * function for checking the event no.
  * @params no. of free events set by set by admin in backend in com_feteapp options
  * 
  */	
	private function checkEventNo($requestData, $featuredcost){ 
	    $app = JFactory::getApplication();
	    $currentuser = JFactory::getUser();
		$model = $this->getModel();
		$params = &JComponentHelper::getParams( 'com_feteapp' );
		$maxeventno = $params->get('maxevent'); 
		if(!is_numeric($maxeventno) || $maxeventno == '') $maxeventno = 5;
		//find the total events added by a user..
		$eventadded = $model->findEventNo(); 
		if($eventadded < ($maxeventno+1)){ 	// if caluse if no. of events is less then defined free events criteria..
			$orderid = $this->subscribedUserData($requestData);
	         if($orderid)
	         {
	         	$url = $this->setPaypalUrl($orderid, $featuredcost); 
	         	if($url!==false){ 
	         	   // $this->setRedirect($url);
	         	   header('Location:'.$url);
	         	   exit;
	         	}else{
			        $this->setMessage(JText::_('COM_EVENT_PAYPAL_REDIRECTION_ERROR'), $type = 'error');
					$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         		}
	         }else{
			   $this->setMessage(JText::_('COM_EVENT_ADD_ERROR'), $type = 'error');
			   $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
	         }
		}
		else{ //else caluse if no. of events is greater then defined free events criteria..
			 //check the perevent cost is published then find the cost..
			 $ispublish = $model->chkPublishPerEventCost();
			 if($ispublish->published){ //check the perevent cost is published then make payment o/w save the event data.
				 $pereventcost = $ispublish->cost;
				 $orderarray = $this->unSubscribedPublishPerEvent($requestData, $pereventcost, $featuredcost);
		         if($orderarray['orderid'])
		         {
		         	$url = $this->setPaypalUrl($orderarray['orderid'], $orderarray['totalcost']); 
		         	if($url!==false){ 
		         	   // $this->setRedirect($url);
		         	   header('Location:'.$url);
		         	   exit;
		         	}else{
				        $this->setMessage(JText::_('COM_EVENT_PAYPAL_REDIRECTION_ERROR'), $type = 'error');
						$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
		         		}
		         }else{
				   $this->setMessage(JText::_('COM_EVENT_ADD_ERROR'), $type = 'error');
				   $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
		         }
			 }elseif(array_key_exists('featured', $requestData)){ // if a event is featured set by user and per event cost not published..
				 $orderid = $this->subscribedUserData($requestData); 
		         if($orderid)
		         {
		         	$url = $this->setPaypalUrl($orderid, $featuredcost); 
		         	if($url!==false){ 
		         	   // $this->setRedirect($url);
		         	   header('Location:'.$url);
		         	   exit;
		         	}else{
				        $this->setMessage(JText::_('COM_EVENT_PAYPAL_REDIRECTION_ERROR'), $type = 'error');
						$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
		         		}
		         }else{
				   $this->setMessage(JText::_('COM_EVENT_ADD_ERROR'), $type = 'error');
				   $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend(), false));
		         }
			 }
			 else{ //if event is neither publish nor featured.... 
			  	$requestData['userid'] = $currentuser->id;
				$record = $model->save($requestData); 
		        $app->enqueueMessage(JText::_('COM_EVENT_SAVED_SUCCESSFULLY'));
				$app->redirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list. $this->getRedirectToListAppend())); 
			 }
		}
	}
	/*
	 * function if a user is a unsubscribed user..if per event cost is published then make payment,
	 * if admin give offer for featured event without pay then can do in if block..
	 */
	private function unSubscribedPublishPerEvent($requestData, $pereventcost, $featuredcost){
	 $app = JFactory::getApplication();
	 $currentuser = JFactory::getUser();
	 $model = $this->getModel();
	 if(array_key_exists('featured', $requestData)){ //if event is featured
		 		//@TODO check the user is selected by admin for adding free featured events in if case, else user have to pay for featured event+per event.
		 		if(0){//if featured event is free for unsubscribed user..
				  	$requestData['userid'] = $currentuser->id;
		 			$requestData['featured'] = 1;
			 		$model->setState('orderdata', $requestData);
	                $return = $model->saveOrder($requestData); 
	                $returnarray['orderid'] = $return;
	                $returnarray['totalcost'] = $pereventcost;
	                return $returnarray;
				  }else{// if featured event is not free for unsubscribed user.. 
				  	$requestData['userid'] = $currentuser->id;
		 			$requestData['featured'] = 1;
			 		$model->setState('orderdata', $requestData);
	                $return = $model->saveOrder($requestData); 
	                $returnarray1['orderid'] = $return;
	                $returnarray1['totalcost'] = $pereventcost + $featuredcost;
	                return $returnarray1;
				  	}
	  }else{ // if event is not featured user will pay for per event cost.. 
			$requestData['userid'] = $currentuser->id;
			$model->setState('orderdata', $requestData);
	        $return = $model->saveOrder($requestData); 
	        $returnarray['orderid'] = $return;
	        $returnarray['totalcost'] = $pereventcost;
	        return $returnarray;
	  	 }
	}
    /* function to set paypal setting in paypalurl
	 * @accept basic setting from backend component preferences
	 * @accept order id
	 * return paypal url to redirect
	 * */
	private function setEditEventPaypalUrl($eventid, $eventinfotableid, $totalcost)
	{
		$url='';
		$itemId = JRequest::getVar('Itemid');
		$model = $this->getModel();
		$returnurl = 'index.php?option=com_event&task=event.updateEventEdit&Itemid='.$itemId;
		$cancelurl = 'index.php?option=com_event&task=event.cancelEventEdit&Itemid='.$itemId;
		//get order data for paypal
		$eventdata = $model->getEvent($eventid);
		if(($eventdata->id > 0)&&( $eventdata->id != '')){
			$params = &JComponentHelper::getParams( 'com_feteapp' );
			if($params->get('paypal')=="sandbox")
			{
				$url='https://www.sandbox.paypal.com/cgi-bin/webscr';
			}else{
				$url='https://www.paypal.com/cgi-bin/webscr';
			}   
			    $url.='?cmd=_xclick';
				$url.='&business='.$params->get('paypalaccount');
				$url.='&return='.urlencode(JRoute::_(JURI::base().$returnurl));
				$url.='&notify_url='.urlencode(JRoute::_(JURI::base().$returnurl));
				$url.='&cancel_return='.urlencode(JRoute::_(JURI::base().$cancelurl.'&order='.$eventdata->id));
				$url.='&item_name='.$eventdata->title;
				$url.='&item_number=1';
				$url.='&custom='.$eventdata->id;
				$url.='&currency_code=USD';
				$url.='&amount='.$totalcost; 
			return $url;
		}else{
			return false;
		}
		 
	}
  /*
   * function for update the event if payment is successful for featured event
   */	
	public function updateEventEdit(){
		$eventid = $_POST['custom'];
		$txn_id = $_POST['txn_id'];
		$eventdata = array();
		if($eventid!='' && $txn_id != '')
		{
			$model = $this->getModel();
			$eventdata['featured'] = 1;
			$eventdata['eventid'] = $eventid;
			$model->featuredEvent($eventdata);
            $msg = JText::_('COM_EVENT_EDIT_SUCCESSFULLY');
            $messagetype = 'message'; 
		}else{
            $msg = JText::_('COM_EVENT_EDIT_FAILED');
            $messagetype = 'error'; 
		}
		 $url="index.php?option=com_event&view=events";
		 $this->setMessage($msg, $type = $messagetype);
		 $this->setRedirect(JRoute::_($url, false));
	}
	/*
	 * function for cancel the featured event making at edit time..
	 */
	public function cancelEventEdit(){
		$app = JFactory::getApplication();
		$msg = JText::_('COM_EVENT_EDIT_CANCELLED');
        $messagetype = 'notice'; 
		$url="index.php?option=com_event&view=events";
//		$app->enqueueMessage(JText::_('COM_EVENT_SAVED_SUCCESSFULLY'));
		$app->redirect(JRoute::_($url), $msg, $messagetype); 
	}
}