<?php
/**
 * @version     1.0.0
 * @package     com_feteapp
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra9891 <yogendra.singh@daffodilsw.com> - http://
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_feteapp/assets/css/feteapp.css');
?>
<script type="text/javascript">
    
    
	Joomla.submitbutton = function(task)
	{
        if(task == 'eventtype.cancel'){  
            Joomla.submitform(task, document.getElementById('eventfee-form'));
            return true;
        }
        
		if (document.formvalidator.isValid(document.id('eventfee-form'))) {
			Joomla.submitform(task, document.getElementById('eventfee-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_feteapp&view=eventfee&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="eventfee-form" class="form-validate form-horizontal">
	<div class="row-fluid">
		<!-- Begin contact -->
		<div class="span10 form-horizontal">
		<fieldset>

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('type'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('type'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('cost'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('cost'); ?></div>
				</div>

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
				</div>

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
				</div>

		</fieldset>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<!-- End content -->
	<!-- Begin Sidebar -->
		<?php //echo JLayoutHelper::render('joomla.edit.details', $this); ?>
	<!-- End Sidebar -->
</form>


