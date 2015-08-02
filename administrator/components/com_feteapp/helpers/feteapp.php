<?php
/**
 * @version     1.0.0
 * @package     com_feteapp
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra9891 <yogendra.singh@daffodilsw.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Feteapp helper.
 */
class FeteappHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_FETEAPP_TITLE_EVENTTYPES'),
			'index.php?option=com_feteapp&view=eventtypes',
			$vName == 'eventtypes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FETEAPP_TITLE_MUSICTYPES'),
			'index.php?option=com_feteapp&view=musictypes',
			$vName == 'musictypes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FETEAPP_TITLE_DRESSCODES'),
			'index.php?option=com_feteapp&view=dresscodes',
			$vName == 'dresscodes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FETEAPP_TITLE_EVENTFEE'),
			'index.php?option=com_feteapp&view=eventfees',
			$vName == 'eventfees'
		);
		
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_feteapp';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
