<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div id="hWrapperAuto">
    <div id="carouselhAuto">
         
         <?php foreach($featuredEvents as $events):?>
         <div>
             <img alt="" src="<?php echo IMG_UPLOAD_DIR_PATH.$events->frontfly;?>" /><br />
             <?php $detaillink = JRoute::_('index.php?option=com_event&task=eventdetail.eventdetail&id='.$events->eventid); ?>
             <span class="thumbnail-text"><a href="<?php echo $detaillink;?>"><?php echo substr($events->title, 0, 15);?></a></span>
             </div>
         <?php endforeach;?>
     </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
       $('#carouselhAuto').jsCarousel();

       $('#carouselhAuto').mouseover(function(){
       $('.jscarousal-horizontal-forward').css('display','block');
        });
       $('#carouselhAuto').mouseover(function(){
       $('.jscarousal-horizontal-back').css('display','block');
        });
       $('#carouselhAuto').mouseleave(function(){
       $('.jscarousal-horizontal-forward').css('display','none');
        });
       $('#carouselhAuto').mouseleave(function(){
       $('.jscarousal-horizontal-back').css('display','none');
        });
 });       
</script>