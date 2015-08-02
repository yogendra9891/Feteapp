<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load( 'plg_user_profile', JPATH_ADMINISTRATOR );
$doc = JFactory::getDocument();

?>
<style type="text/css">

.test ul li{
	padding-top:10px !important;
}
.test ul li label{
	width: 150px;
	float: left;
}
</style>
<div class="profile-edit<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

<form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
<div class="test">
			<ul class="adminformlist" style="list-style: none outside !important; padding-top: 10px !important;">

				<li><?php echo $this->form->getLabel('fname'); ?>
				<?php echo $this->form->getInput('fname','',$this->feteappdata[0]->fname); ?></li>

				<li><?php echo $this->form->getLabel('lname'); ?>
				<?php echo $this->form->getInput('lname','',$this->feteappdata[0]->lname); ?></li>

				<li><?php echo $this->form->getLabel('email1'); ?>
				<?php echo $this->form->getInput('email1','',$this->data->email1); ?></li>
				
				<li><?php echo $this->form->getLabel('email2'); ?>
				<?php echo $this->form->getInput('email2','',$this->data->email2); ?></li>

                <?php if(($this->feteappdata[0]->promotorname != '') && ($this->feteappdata[0]->usertype == 1)){?>
				<li><?php //echo $this->form->getLabel('promotorname'); ?>
				<?php //echo $this->form->getInput('promotorname','',$this->feteappdata[0]->promotorname); ?>
				<label title="" class="hasTip required" for="jform_promotorname" id="jform_promotorname-lbl">Promotor Name:<span class="star">&nbsp;*</span></label>
				<input type="text" aria-required="true" required="required" size="30" class="required" value="<?php echo $this->feteappdata[0]->promotorname;?>" id="jform_promotorname" name="jform[promotorname]">
				</li>
				<?php }?>

				<li><?php echo $this->form->getLabel('feteappuserid'); ?>
				<?php echo $this->form->getInput('feteappuserid','',$this->feteappdata[0]->id); ?></li>

</ul>
</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
			<a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="profile.save" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>
