<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			18th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		aameetings.php
	@author			Darren Frewin <http://www.west-kent-alcoholics-anonymous.org.uk>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Aameetings Controller
 */
class AameetinglistControllerAameetings extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_AAMEETINGLIST_AAMEETINGS';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Aameeting', $prefix = 'AameetinglistModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('aameeting.export', 'com_aameetinglist') && $user->authorise('core.export', 'com_aameetinglist'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Aameetings');
			// get the data to export
			$data = $model->getExportData($pks);
			if (AameetinglistHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				AameetinglistHelper::xls($data,'Aameetings_'.$date->format('jS_F_Y'),'Aameetings exported ('.$date->format('jS F, Y').')','aameetings');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_AAMEETINGLIST_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_aameetinglist&view=aameetings', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('aameeting.import', 'com_aameetinglist') && $user->authorise('core.import', 'com_aameetinglist'))
		{
			// Get the import model
			$model = $this->getModel('Aameetings');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (AameetinglistHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('aameeting_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'aameetings');
				$session->set('dataType_VDM_IMPORTINTO', 'aameeting');
				// Redirect to import view.
				$message = JText::_('COM_AAMEETINGLIST_IMPORT_SELECT_FILE_FOR_AAMEETINGS');
				$this->setRedirect(JRoute::_('index.php?option=com_aameetinglist&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_AAMEETINGLIST_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_aameetinglist&view=aameetings', false), $message, 'error');
		return;
	}
}
