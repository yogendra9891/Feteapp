<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
// load tooltip behavior
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
//JHtml::_('formbehavior.chosen', 'select');

$user		= JFactory::getUser();
$userId		= $user->get('id');

$listOrder   = $this->state->get('list.ordering'); 
$listDirn   = $this->state->get('list.direction');
if($userId > 0){ // function calling is cheking the usertype(Promotor/Regular member)
 $usertype = EventHelper::chkusertype(); 
}

?>
<form action="<?php echo JRoute::_('index.php?option=com_event&view=events'); ?>" method="post" name="adminForm" id="adminForm">
		<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CHRISTIANCONNECT_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('Country'); ?></label>
			<select name="filter_country" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options',  EventHelper::getCountryOptions(), 'value', 'text', $this->state->get('filter.country'), true);?>
			</select>
		</div>
		<?php if($usertype->usertype == '1' && $usertype->userid == $userId){?>
		<div class="filter-select fltrt">
			<a title="Cancel" href="<?php echo JRoute::_('index.php?option=com_event&task=event.add&layout=add'); ?>" class="btn"><?php echo JText::_('COM_EVENT_ADD_EVENT');?></a>
		</div>
		<?php } ?>
	</fieldset>
	<div class="clr"> </div>
	<table class="adminlist">
			<thead>
				<tr>
<!--					<th width="1%" class="hidden-phone">-->
<!--						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />-->
<!--					</th>-->
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'EventType', 'a.eventtype', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'StartDate', 'a.startdate', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'EndDate', 'a.enddate', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'Promotor Name', 'a.promotorname', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'Country', 'b.country', $listDirn, $listOrder); ?>
					</th>

				</tr>
			</thead>
		<tbody>
			<?php foreach($this->items as $item){ 
			$detaillink = JRoute::_('index.php?option=com_event&task=eventdetail.eventdetail&id='.$item->eventid); 
			$editlink = JRoute::_('index.php?option=com_event&task=event.edit&id='.$item->eventid.'&ownerid='.$item->userid); ?>
			<tr>
<!--			<td>-->
<!--			<input type="checkbox" name="cid[]" value="<?php echo $item->id;?>">-->
<!--			</td>-->
			<td class="nowrap has-context">
			  <?php echo $item->title; ?>
			  		<div class="pull-left">
							<?php
								// Create dropdown items
								if($item->userid == $userId && $userId >0){
								JHtml::_('dropdown.addCustomItem', 'Edit', $editlink);
								}?>
								
								<?php 
								// render dropdown list
								JHtml::_('dropdown.divider');
								JHtml::_('dropdown.addCustomItem', 'Detail', $detaillink);
								echo JHtml::_('dropdown.render');
							?>
						</div>
			</td>
			<td>
			  <?php echo $this->eventype($item->eventtype); ?>
			</td>
			<td>
			  <?php echo date('d F Y', strtotime($item->startdate)); ?>
			</td>
			<td>
			  <?php echo date('d F Y', strtotime($item->enddate)); ?>
			</td>
			<td>
			  <?php echo $item->promotorname; ?>
			</td>
			<td>
			  <?php echo $this->countryname($item->country); ?>
			</td>
			
			</tr>
			<?php }?>

		</tbody>
			<tfoot>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
	<div>
		<input type="hidden" name="task" value="0" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		

		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>