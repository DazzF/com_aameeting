<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			19th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		batch_.php
	@author			Darren Frewin <http://www.west-kent-alcoholics-anonymous.org.uk>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('JPATH_PLATFORM') or die;

/**
 * Utility class to render a list view batch selection options
 *
 * @since  3.0
 */
abstract class JHtmlBatch_
{
	/**
	 * ListSelection
	 *
	 * @var    array
	 * @since  3.0
	 */
	protected static $ListSelection = array();

	/**
	 * Render the batch selection options.
	 *
	 * @return  string  The necessary HTML to display the batch selection options
	 *
	 * @since   3.0
	 */
	public static function render()
	{
		// Collect display data
		$data                 = new stdClass;
		$data->ListSelection  = static::getListSelection();

		// Create a layout object and ask it to render the batch selection options
		$layout    = new JLayoutFile('batchselection');
		$batchHtml = $layout->render($data);

		return $batchHtml;
	}

	/**
	 * Method to add a list selection to the batch modal
	 *
	 * @param   string  $label      Label for the menu item.
	 * @param   string  $name       Name for the filter. Also used as id.
	 * @param   string  $options    Options for the select field.
	 * @param   bool    $noDefault  Don't the label as the empty option
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function addListSelection($label, $name, $options, $noDefault = false)
	{
		array_push(static::$ListSelection, array('label' => $label, 'name' => $name, 'options' => $options, 'noDefault' => $noDefault));
	}

	/**
	 * Returns an array of all ListSelection
	 *
	 * @return  array
	 *
	 * @since   3.0
	 */
	public static function getListSelection()
	{
		return static::$ListSelection;
	}
}
