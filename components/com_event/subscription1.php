<?php
 
// No direct access.
defined('_JEXEC') or die;
 
// import Joomla controller library
jimport('joomla.application.component.controller');
// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');
 
class ChristianconnectControllerSubscription extends JControllerForm
{

	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

	}

	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Subscription', $prefix = 'ChristianconnectModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	/* Function to save order
	 * @param	post form array
	 * 
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
         $requestData = JRequest::getVar('jform', array(), 'post', 'array');
         $requestData['price'] = JRequest::getVar('price');
         $model=$this->getModel();
         $model->setState('orderdata',$requestData);
         $return=$model->saveOrder($requestData);
         if($return)
         {
         	$orderid=$model->getState('orderid'); 
         	$url=$this->setPaypalUrl($orderid);
         	if($url!==false){
         	$this->setRedirect($url);
         	}else{
         		$url="index.php?option=com_christianconnect&view=mychurch";
				$msg=JText::_('Could not redirect to paypal: Some error occur');
				$this->setRedirect($url,$msg);
         	}
         }
         return $return;
	}
	
	 /*function remove order from order table
	  * order is cancelled by subscriber or no successfully paid
	  */
	 function cancelOrder()
	 {
	 	//check for user must logged in
		if (JFactory::getUser()->id == 0){
				$errormessage = JText::_('LOGIN_FIRST');
				$app =& JFactory::getApplication();
				$app->redirect('index.php?option=com_users&view=login', $errormessage,'message');
				}
	 	$oid=JRequest::getVar('order');  
		if($oid!='')
		{
		$model=$this->getModel();
		$model->setState('oid',$oid);
		$odata=$model->cancelOrder();
		}
		$url="index.php?option=com_christianconnect&view=mychurch";
		$msg=JText::_('Order cancel');
		$this->setRedirect($url,$msg);
	}
	 
/* function to set paypal setting in paypalurl
	 * @accept basic setting from backend coponent preferences
	 * @accept order id
	 * return paypal url to redirect
	 * */
	function setPaypalUrl($orderid)
	{
		$url='';
		$model=$this->getModel();
		$model->setState('orderid',$orderid);
		//get order data for paypal
		$orderdata=$model->getOrder();
		if($orderdata!==false){
			$params = &JComponentHelper::getParams( 'com_christianconnect' );
			if($params->get('paypal')=="sandbox")
			{
				$url='https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions';
			}else{
				$url='https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions';
			}
				$url.='&business='.$params->get('paypalaccount');
				$url.='&return='.urlencode(JURI::base().$params->get('returnurl'));
				$url.='&notiy_url='.urlencode(JURI::base().$params->get('returnurl'));
				$url.='&cancel_return='.urlencode(JURI::base().$params->get('cancelurl').'&order='.$orderdata->id);
				$url.='&item_name='.$orderdata->cname;
				$url.='&item_number='.$orderdata->churchid;
				$url.='&custom='.$orderdata->id;
				$url.='&no_shipping=1';
				$url.='&src=1';
				$url.='&srt=50';
				$url.='&sra=1';
				$url.='&rm=2';
				$url.='&a3='.$orderdata->price;
				$url.='&t3=y';//for year
				$url.='&p3='.$params->get('subscription_validity');
			return $url;
		}else{
			return false;
		}
		 
	}
	
	function trim_value(&$value) 
{ 
    $value = trim($value); 
}
	
	/*Method to update order status after successful payment
	 * @param orderid
	 * @return true 
	 */
	 
	function updateOrderStatus()
	{
		if($_POST['txn_type']=='subscr_eot')
		{
			$order_number=$_POST['custom'];
			$model=$this->getModel();
			$model->setState('orderid',$order_number);
			//check for ordered church exist in churchtable
			$orderobj=$model->getOrder();
			$model->setState('churchid',$orderobj->churchid);
			$model->setState('userid',$orderobj->userid);
			$model->setState('subscription_status',0);
			$model->updateChurchStatus();
			$model->deleteUserAccess();
		}elseif($_POST['txn_type']=='subscr_signup' || $_POST['txn_type']=='subscr_payment'){
			
		$oid=$_POST['custom'];
		if($oid!='')
		{
		$model=$this->getModel();
		$model->setState('orderid',$oid);
		//check for ordered church exist in churchtable
		$orderobj=$model->getOrder();
		$model->updateOrderStatus();
		if($orderobj!==false){
			$model->setState('churchid',$orderobj->churchid);
			$model->setState('userid',$orderobj->userid);
			$model->setState('subscription_status',1);
			$model->updateChurchStatus();
			$model->updateUserAccess();
			}else{
		$url="index.php?option=com_christianconnect&view=mychurch";
		$msg=JText::_('Not update church data: Some error occur');
		$this->setRedirect($url,$msg);
			}
		}
		$url="index.php?option=com_christianconnect&view=mychurch";
		$msg=JText::_('You have subscribed successful');
		$this->setRedirect($url,$msg);
		}
		
	}
	
	
	/*function to check paypal recurring payment notification
	 */

		public function write($filepath,$the_string )
		{
		$date=date('m/d/Y h:i:s');
		if( $fh = fopen($filepath, 'a+' ) )
		{
		fputs( $fh, chr(10).$date.chr(10).$the_string);
		fclose( $fh );
		return( true );
		}
		else
		{
		return( false );
		}
		}
		 
 }
?>
