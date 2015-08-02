<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
// load tooltip behavior
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

$user		= JFactory::getUser();
$userId		= $user->get('id');
define('IMG_UPLOAD_DIR_PATH', 'media/com_event/event/original/');
define('IMG_THUMB_UPLOAD_DIR_PATH', 'media/com_event/event/thumb/');

?>


<div class="Event-wrapper">
	<div class="eventedit">
		<h2>
		<?php echo JText::_('COM_EVENT_EVENT_DETAIL');?></h2>
	</div>
	 <div class="eventtitle">
		 <label><?php echo JText::_('COM_EVENT_EVENT_TITLE');?></label>
		<p> <?php echo $this->item->title;?> </p>
	 </div>
	 <div class="eventpromotorname">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PROMOTOR_NAME');?></label>
		 <p> <?php echo $this->item->promotorname;?></p>
	 </div>
	 <div class="eventtype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EVENTTYPE');?></label>
		  <p> <?php echo $this->eventype($this->item->eventtype);?></p>
	 </div>
	 <div class="eventstartdate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_SATRTDATE');?></label>
		 <p> <?php echo date('d F Y', strtotime($this->item->startdate));?></p>
	 </div>
	 <div class="eventenddate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?></label>
		 <p> <?php echo date('d F Y', strtotime($this->item->enddate));?></p>
	 </div>
	 <div class="starttime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STARTTIME');?></label>
		 <p> <?php echo $this->item->starttime;?></p>
     </div>
	 <div class="endtime">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ENDDATE');?></label>
		  <p> <?php echo $this->item->endtime;?></p>
	 </div>
	 	 <?php if($this->item->cancelled):?>
	 <div class="eventcancelled">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED');?></label>
         <p> <?php echo $this->item->cancelled;?></p>
	 </div>

	 <div class="eventcancelledreason">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CANCELLED_REASON');?></label>
		 <p> <?php echo $this->item->cancelledreason;?></p>
	 </div>
	 <?php endif;?>
	 <div class="eventmusictype">
		 <label><?php echo JText::_('COM_EVENT_EVENT_MUSICTYPE'); $musictypearray = explode(',', $this->item->musictype)?></label>
		  <?php foreach($musictypearray as $muictype): ?>
		  <li><?php echo $this->musictypename($muictype);?></li><?php endforeach;?>
	 </div>
	 <div class="eventdresscode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DRESSCODE');?></label>
		  <p> <?php echo $this->getDresscodeOptions($this->item->dresscode);?></p>
	 </div>
	 <div class="eventagegroup">
		 <label><?php echo JText::_('COM_EVENT_EVENT_AGEGROUP');?></label>
		  <p> <?php echo $this->item->agegroup;?></p>
	 </div>
	 <div class="eventdjs">
		 <label><?php echo JText::_('COM_EVENT_EVENT_DJS');?></label>
		 <p> <?php echo $this->item->djs;?></p>
	 </div>
	 <div class="eventartist">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ARTIST');?></label>
		  <p> <?php echo $this->item->artist;?></p>
	 </div>
	 <div class="eventfrontfly">
			<ul class="gallery clearfix">
				<li><a href="<?php echo IMG_UPLOAD_DIR_PATH.$this->item->frontfly;?>" rel="prettyPhoto[gallery1]"><img src="<?php echo IMG_THUMB_UPLOAD_DIR_PATH.$this->item->frontfly;?>" width="150" height="150" alt="Front Fly" /></a></li>
				<li><a href="<?php echo IMG_UPLOAD_DIR_PATH.$this->item->backfly;?>" rel="prettyPhoto[gallery1]"><img src="<?php echo IMG_THUMB_UPLOAD_DIR_PATH.$this->item->backfly;?>" width="150" height="150" alt="Back Fly" /></a></li>
			</ul>
     </div>
	<div class="eventotherinfo">
		<h3>
		<?php echo JText::_('COM_EVENT_EVENT_OTHERINFO');?></h3>
	</div>
	 <div class="eventvenue">
		 <label><?php echo JText::_('COM_EVENT_EVENT_VENUE');?></label>
		  <p><?php echo $this->item->venue;?></p>
	 </div>
	 <div class="eventaddress1">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS1');?></label>
		  <p><?php echo $this->item->address1;?></p>
	 </div>
	 <div class="eventaddress2">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDRESS2');?></label>
		 <p><?php echo $this->item->address2;?></p>
	 </div>
	 <div class="eventcity">
		 <label><?php echo JText::_('COM_EVENT_EVENT_CITY');?></label>
		  <p><?php echo $this->item->city;?></p>
	 </div>
	 <div class="eventstate">
		 <label><?php echo JText::_('COM_EVENT_EVENT_STATE');?></label>
		 <p><?php echo $this->item->state;?></p>
	 </div>
	 <div class="eventpostcode">
		 <label><?php echo JText::_('COM_EVENT_EVENT_POSTCODE');?></label>
		 <p><?php echo $this->item->postcode;?></p>
	 </div>
	 <div class="eventcountry">
		 <label><?php echo JText::_('COM_EVENT_EVENT_COUNTRY');?></label>
		 <p><?php echo $this->countryname($this->item->country);?></p>
	 </div>
	 <div class="eventphone">
		 <label><?php echo JText::_('COM_EVENT_EVENT_PHONE');?></label>
		 <p><?php echo $this->item->phone;?></p>
	 </div>
	 <div class="eventemail">
		 <label><?php echo JText::_('COM_EVENT_EVENT_EMAIL');?></label>
		 <p><a href="mailto:<?php echo $this->item->email;?>"><?php echo $this->item->email;?></a></p>
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_WEBSITE');?></label>
		 <p><a href="<?php echo $this->item->website;?>" target="_blank"><?php echo $this->item->website;?></a></p>
	 </div>
	 <div class="eventwebsite">
		 <label><?php echo JText::_('COM_EVENT_EVENT_ADDITIONALINFO');?></label>
		 <p><?php echo $this->item->additionalinfo;?></p>
	 </div>
 </div>
 <!-- script for photo gallery preview. -->
 <script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:5000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:20000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
</script>
