<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$date = JRequest::getVar('dateselected'); 
$Itemid = JRequest::getVar('Itemid');
?>
<form action="<?php echo JRoute::_('index.php?option=com_event&view=calendarevents&Itemid='.$Itemid);?>" name="eventcalendarform" id="eventcalendarform" method="post">
<div id="opencalendar"></div>
<input type="hidden" name="dateselected" id="hiddenFieldID" value="<?php echo $date;?>">
<input type="hidden" name="task" value="calendarevents.calendarevents">
<?php echo JHtml::_('form.token'); ?>
</form>
<script>
//script for making a open calendar .. and already selected date....
$(function() {
$("#opencalendar").datepicker({
    inline : true,
    altField : '#hiddenFieldID',
    dateFormat: 'yy-mm-dd',
    defaultDate: $('#hiddenFieldID').val(),
    onSelect: function(dateText, inst) {
		 $('#eventcalendarform').submit();
		}
});
});
</script>