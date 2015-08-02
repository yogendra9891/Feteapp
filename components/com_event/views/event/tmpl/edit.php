<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
JHTML::_('behavior.calendar');
JHtml::_('behavior.multiselect');
//JHtml::_('formbehavior.chosen', 'select');
// load tooltip behavior

$user		= JFactory::getUser();
$userId		= $user->get('id'); 
define('IMG_THUMB_UPLOAD_DIR_PATH', 'media/com_event/event/thumb/');
?>
<form action="<?php echo JRoute::_('index.php?option=com_event&view=events'); ?>" method="post" name="adminForm" id="event-editform" enctype="multipart/form-data">
<div class="Event-wrapper">
	<div class="eventedit">
		<h2>
		<?php echo JText::_('COM_EVENT_EVENT_EDIT');?></h2>
	</div>
	 <div class="eventtitle">
		 <label><?php echo JText::_('COM_EVENT_EVENT_TITLE');?><span>*</span></label>
		 <input type="text" size="30" id="jform_title" name="jform[title]" value="<?php echo $this->item->title;?>"/>
	 </div>
	 <div class="eventpromotorname">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PROMOTOR_NAME');?><span>*</span></label>
		 <input type="text" size="30" id="jform_promotorname" name="jform[promotorname]" value="<?php echo $this->item->promotorname;?>" readonly="true"/>
	 </div>
	 <div class="eventtype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EVENTTYPE');?><span>*</span></label>
		  <select name="jform[eventtype]" id="jform_eventtype" >
				<?php echo JHtml::_('select.options',  EventHelper::getEventtypeOptions(), 'value', 'text', $this->item->eventtype, true);?>
		</select>
	 </div>
	 <?php if(!($this->item->featured)){?>
	 <div class="eventfeatured">
		 <label><?php echo JText::_('COM_EVENT_EVENT_FEATURED');?></label>
		 <input type="checkbox" id="jform_featured" name="jform[featured]" />
	 </div>
	<?php }?>
	 <div class="eventstartdate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_SATRTDATE');?><span>*</span></label>
		 <input type="text" id="jform_startdate" name="jform[startdate]" readonly value="<?php echo $this->item->startdate;?>" />
	 </div>
	 <div class="eventenddate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?><span>*</span></label>
		  <input type="text" id="jform_enddate" name="jform[enddate]" readonly value="<?php echo $this->item->enddate;?>" />
	 </div>
	 <div class="starttime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STARTTIME');?><span>*</span></label>
		 <input type="text" name="jform[starttime]" id="jform_starttime" readonly value="<?php  echo $this->item->starttime;?>" />
	 </div>
	 <div class="endtime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?><span>*</span></label>
		<input type="text" name="jform[endtime]" id="jform_endtime" readonly value="<?php  echo $this->item->endtime;?>" />
	 </div>
	 <div class="eventcancelled">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED');?></label>
		 <?php if($this->item->cancelled)$checked =  'checked="checked"';?>
		 <input type="checkbox" id="jform_cancelled" name="jform[cancelled]" <?php echo $checked;?>/>
	 </div>
	 <div class="eventcancelledreason">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED_REASON');?></label>
		  <textarea id="jform_cancelledreason" name="jform[cancelledreason]"><?php echo $this->item->cancelledreason;?></textarea>
	 </div>
	 <div class="eventmusictype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_MUSICTYPE');?><span>*</span></label>
		  <?php echo $this->musictypeselection($this->item->musictype);?>
	 </div>
	 <div class="eventdresscode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DRESSCODE');?><span>*</span></label>
		  <select name="jform[dresscode]" id="jform_dresscode" >
				<?php echo JHtml::_('select.options',  EventHelper::getDresscodeOptions(), 'value', 'text', $this->item->dresscode, true);?>
		</select>
	 </div>
	 <div class="eventagegroup">
		 <label><?php echo JText::_('COM_EVENT_EVENT_AGEGROUP');?><span>*</span></label>
		  <input type="text" size="30" id="jform_agegroup" name="jform[agegroup]" value="<?php echo $this->item->agegroup;?>" />
	 </div>
	 <div class="eventdjs">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DJS');?></label>
		  <textarea id="jform_djs" name="jform[djs]"><?php echo $this->item->djs;?></textarea>
	 </div>
	 <div class="eventartist">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ARTIST');?></label>
		  <textarea id="jform_artist" name="jform[artist]"><?php echo $this->item->artist;?></textarea>
	 </div>
	 <div class="eventfrontfly">
	 <label><?php echo JText::_('COM_EVENT_EVENT_CHANGE_FRONTFLY');?></label><input type='file' id="jform_frontfly" onchange="readFrontURL(this);" name="jform[frontfly]"/>
		<img id="frontfly" src="<?php echo IMG_THUMB_UPLOAD_DIR_PATH.$this->item->frontfly;?>" />
	</div>	
	 <div class="eventbackfly">
	 <label><?php echo JText::_('COM_EVENT_EVENT_CHNAGE_BACKFLY');?></label><input type='file' id="jform_backfly" onchange="readBackURL(this);" name="jform[backfly]"/>
		<img id="backfly" src="<?php echo IMG_THUMB_UPLOAD_DIR_PATH.$this->item->backfly;?>" />
	</div>	

	 	<div class="eventotherinfo">
		<h3>
		<?php echo JText::_('COM_EVENT_EVENT_OTHERINFO');?></h3>
	</div>
	 <div class="eventvenue">
		 <label><?php echo JText::_('COM_EVENT_EVENT_VENUE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_venue" name="jform[venue]" value="<?php echo $this->item->venue;?>" />
	 </div>
	 <div class="eventaddress1">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS1');?><span>*</span></label>
		  <input type="text" size="30" id="jform_address1" name="jform[address1]" value="<?php echo $this->item->address1;?>" />
	 </div>
	 <div class="eventaddress2">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS2');?><span>*</span></label>
		  <input type="text" size="30" id="jform_address2" name="jform[address2]" value="<?php echo $this->item->address2;?>" />
	 </div>
	 <div class="eventcity">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CITY');?><span>*</span></label>
		  <input type="text" size="30" id="jform_city" name="jform[city]" value="<?php echo $this->item->city;?>" />
	 </div>
	 <div class="eventstate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STATE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_state" name="jform[state]" value="<?php echo $this->item->state;?>" />
	 </div>
	 <div class="eventpostcode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_POSTCODE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_postcode" name="jform[postcode]" value="<?php echo $this->item->postcode;?>" />
	 </div>
	 <div class="eventcountry">
		 <label><?php echo JText::_('COM_EVENT_EVENT_COUNTRY');?><span>*</span></label>
		  <select name="jform[country]" id="jform_country">
				<?php echo JHtml::_('select.options',  EventHelper::getCountryOptions(), 'value', 'text', $this->item->country, true);?>
		</select>
	 </div>
	 <div class="eventphone">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PHONE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_phone" name="jform[phone]" value="<?php echo $this->item->phone;?>" />
	 </div>
	 <div class="eventemail">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EMAIL');?><span>*</span></label>
		 <input type="text" size="30" id="jform_email" name="jform[email]" value="<?php echo $this->item->email;?>" />
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_WEBSITE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_website" name="jform[website]" value="<?php echo $this->item->website;?>" />
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDITIONALINFO');?></label>
         <textarea id="jform_additionalinfo" name="jform[additionalinfo]"><?php echo $this->item->additionalinfo;?></textarea>
	 </div>
			<button class="btn btn-primary validate" type="submit"><span>Submit</span></button>
			<a title="Cancel" href="<?php echo JRoute::_('index.php?option=com_event&view=events'); ?>" class="btn">Cancel</a>
 </div>
<input type="hidden" name="jform[eventid]" id="jform_eventid" value="<?php echo $this->item->eventid;?>" />
<input type="hidden" name="jform[eventinfoid]" id="jform_eventinfoid" value="<?php echo $this->item->id;?>" />
<input type="hidden" name="task" value="event.save">
<?php echo JHtml::_('form.token'); ?>
</form>