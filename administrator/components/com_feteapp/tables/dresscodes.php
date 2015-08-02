<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_feteapp
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_feteapp
 */
class FeteappTableDresscodes extends JTable
{
	/**
	 * Helper object for storing and deleting tag information.
	 *
	 * @var    JHelperTags
	 * @since  3.1
	 */
	protected $tagsHelper = null;

	/**
	 * Constructor
	 *
	 * @param  JDatabase  Database connector object
	 *
	 * @since 1.0
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__dresscodes', 'id', $db);
	}

}
