<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
JHTML::_('behavior.calendar');
JHtml::_('behavior.multiselect');
//JHtml::_('formbehavior.chosen', 'select');
// load tooltip behavior

$user		= JFactory::getUser();
$userId		= $user->get('id');
$promotorname = EventHelper::promotorname();
$date = date('Y-m-d');

?>
<script>
(function($) {
	$(document).ready(function(){
	DrawCaptcha();
	});
})(jQuery);
function DrawCaptcha()
{ 
var text = "";
var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

for( var i=0; i < 5; i++ )
    text += possible.charAt(Math.floor(Math.random() * possible.length))+ ' ';
   
   $("#txtCaptcha").val(text);
}

</script>
<form action="<?php echo JRoute::_('index.php?option=com_event&view=events'); ?>" method="post" name="adminForm" id="event-editform" enctype="multipart/form-data">
<div class="Event-wrapper">
	<div class="eventedit">
		<h2>
		<?php echo JText::_('COM_EVENT_EVENT_ADD');?></h2>
	</div>
	 <div class="eventtitle">
		 <label><?php echo JText::_('COM_EVENT_EVENT_TITLE');?><span>*</span></label>
		 <input type="text" size="30" id="jform_title" name="jform[title]" />
	 </div>
	 <div class="eventpromotorname">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PROMOTOR_NAME');?><span>*</span></label>
		 <input type="text" size="30" id="jform_promotorname" name="jform[promotorname]" value="<?php echo $promotorname->promotorname;?>" readonly="true"/>
	 </div>
	 <div class="eventtype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EVENTTYPE');?><span>*</span></label>
		  <select name="jform[eventtype]" id="jform_eventtype" >
				<?php echo JHtml::_('select.options',  EventHelper::getEventtypeOptions(), 'value', 'text', '', true);?>
		</select>
	 </div>
	 <div class="eventfeatured">
		 <label><?php echo JText::_('COM_EVENT_EVENT_FEATURED');?></label>
		 <input type="checkbox" id="jform_featured" name="jform[featured]" />
	 </div>

	 <div class="eventstartdate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_SATRTDATE');?><span>*</span></label>
		 <input type="text" id="jform_startdate" name="jform[startdate]" readonly value="<?php //echo JFactory::getDate();?>" />
	 </div>
	 <div class="eventenddate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?><span>*</span></label>
		  <input type="text" id="jform_enddate" name="jform[enddate]" readonly value="<?php //echo JFactory::getDate();?>" />
	 </div>
	 <div class="starttime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STARTTIME');?><span>*</span></label>
			<input type="text" name="jform[starttime]" id="jform_starttime" readonly value=""/>
	 </div>
	 <div class="endtime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?><span>*</span></label>
				<input type="text" name="jform[endtime]" id="jform_endtime" readonly value=""/>
	 </div>
	 <div class="eventcancelled">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED');?></label>
		 <input type="checkbox" id="jform_cancelled" name="jform[cancelled]" value="1"/>
	 </div>
	 <div class="eventcancelledreason">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED_REASON');?></label>
		  <textarea id="jform_cancelledreason" name="jform[cancelledreason]" > </textarea>
	 </div>
	 <div class="eventmusictype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_MUSICTYPE');?><span>*</span></label>
		  <?php echo $this->musictypeselection();?>
	 </div>
	 <div class="eventdresscode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DRESSCODE');?><span>*</span></label>
		  <select name="jform[dresscode]" id="jform_dresscode" >
				<?php echo JHtml::_('select.options',  EventHelper::getDresscodeOptions(), 'value', 'text', '', true);?>
		</select>
	 </div>
	 <div class="eventagegroup">
		 <label><?php echo JText::_('COM_EVENT_EVENT_AGEGROUP');?><span>*</span></label>
		  <input type="text" size="30" id="jform_agegroup" name="jform[agegroup]" />
	 </div>
	 <div class="eventdjs">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DJS');?></label>
		  <textarea id="jform_djs" name="jform[djs]" > </textarea>
	 </div>
	 <div class="eventartist">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ARTIST');?></label>
		  <textarea id="jform_artist" name="jform[artist]" ></textarea>
	 </div>
	 <div class="eventfrontfly">
	 <label><?php echo JText::_('COM_EVENT_EVENT_FRONTFLY');?></label><input type='file' id="jform_frontfly" onchange="readFrontURL(this);" name="jform[frontfly]"/>
		<img id="frontfly" src="#" style="display:none;"/>
	</div>	
	 <div class="eventbackfly">
	 <label><?php echo JText::_('COM_EVENT_EVENT_BACKFLY');?></label><input type='file' id="jform_backfly" onchange="readBackURL(this);" name="jform[backfly]"/>
		<img id="backfly" src="#" style="display:none;"/>
	</div>	

	 	<div class="eventotherinfo">
		<h3>
		<?php echo JText::_('COM_EVENT_EVENT_OTHERINFO');?></h3>
	</div>
	 <div class="eventvenue">
		 <label><?php echo JText::_('COM_EVENT_EVENT_VENUE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_venue" name="jform[venue]" />
	 </div>
	 <div class="eventaddress1">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS1');?><span>*</span></label>
		  <input type="text" size="30" id="jform_address1" name="jform[address1]" />
	 </div>
	 <div class="eventaddress2">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS2');?><span>*</span></label>
		  <input type="text" size="30" id="jform_address2" name="jform[address2]" />
	 </div>
	 <div class="eventcity">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CITY');?><span>*</span></label>
		  <input type="text" size="30" id="jform_city" name="jform[city]" />
	 </div>
	 <div class="eventstate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STATE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_state" name="jform[state]" />
	 </div>
	 <div class="eventpostcode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_POSTCODE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_postcode" name="jform[postcode]" />
	 </div>
	 <div class="eventcountry">
		 <label><?php echo JText::_('COM_EVENT_EVENT_COUNTRY');?><span>*</span></label>
		  <select name="jform[country]" id="jform_country">
				<?php echo JHtml::_('select.options',  EventHelper::getCountryOptions(), 'value', 'text', 0, true);?>
		</select>
	 </div>
	 <div class="eventphone">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PHONE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_phone" name="jform[phone]" />
	 </div>
	 <div class="eventemail">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EMAIL');?><span>*</span></label>
		  <input type="text" size="30" id="jform_email" name="jform[email]" />
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_WEBSITE');?><span>*</span></label>
		  <input type="text" size="30" id="jform_website" name="jform[website]" />
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDITIONALINFO');?></label>
         <textarea id="jform_additionalinfo" name="jform[additionalinfo]" > </textarea>
	 </div>
	 <div class="captchaarea">
	 	<input type="text" id="txtCaptcha" style="background-image:url(images/1.JPG); text-align:center; border:none; font-size:15px; font-weight:bold; font-family:Modern" readonly />
        <img src="images/refresh.jpg" onclick="DrawCaptcha();" />
	 </div>
	 <div class="inputverify">
	 <label><?php echo JText::_('COM_EVENT_EVENT_CAPTCHA_CONTENT');?><span>*</span></label>
	 <input type="text" name="captchaverify" id="captchverify">
	 </div>
			<button class="btn btn-primary validate" type="submit"><span>Submit</span></button>
			<a title="Cancel" href="<?php echo JRoute::_('index.php?option=com_event&view=events'); ?>" class="btn">Cancel</a>
 </div>
<input type="hidden" name="jform[eventid]" id="jform_eventid"  value="0"/>
<input type="hidden" name="jform[eventinfoid]" id="jform_eventinfoid" value="0"/>
<input type="hidden" name="task" value="event.saveOrder">
<?php echo JHtml::_('form.token'); ?>
</form>
