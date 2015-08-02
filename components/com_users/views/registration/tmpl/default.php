<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$doc = JFactory::getDocument();
?>
<script type="text/javascript">
 (function($) {
	$(document).ready(function(){
		$('#member-registration').submit(function() {
         if ($("#jform_promotors").prop("checked")){
             if($("#jform_promotorname").val() == ''){
                 alert('you select a promotor option so please enter a promotor name');
                 $("#jform_promotorname").focus();
                 return false;
             }
         }
		});
	});
	})(jQuery);
</script>
<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
	<?php $fields = $this->form->getFieldset($fieldset->name);?>
	<?php if (count($fields)):?>
		<fieldset>
		<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
		?>
			<legend><?php echo JText::_($fieldset->label);?></legend>
		<?php endif;?>
		<?php foreach ($fields as $field) :// Iterate through the fields in the set and display them.?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<div class="control-group">
					<div class="control-label">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
<!--						<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>-->
					<?php endif; ?>
					</div>
					<div class="controls">
						<?php echo $field->input;?>
					</div>
				</div>
			<?php endif;?>
		<?php endforeach;?>
		</fieldset>
	<?php endif;?>
<?php endforeach;?>
<!-- finding the newsletter lists from acymailing component.. -->
<?php $newsletterlist = $this->newsLetterList(); $i= 0;?>
<div class="control-group">
					<div class="control-label">
					<label title="" class="hasTip" for="jform_newsletter" id="jform_newsletter-lbl">NewsLetter</label>	
										</div>
					<div class="controls">
						<fieldset class="checkboxes" id="jform_newsletter">
						<ul>
						<?php foreach($newsletterlist as $newsletter):?>
							<li>
								<input type="checkbox" value="<?php echo $newsletter->listid;?>" name="jform[newsletter][]" id="jform_newsletter<?php echo $i;?>">
								<label for="jform_newsletter<?php echo $i;?>"><?php echo $newsletter->name;?></label>
							</li>
						<?php $i++; endforeach;?>
						</ul>
						</fieldset>	
						
                     </div>
				</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER');?></button>
			<a class="btn" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</div>
	</form>
</div>
