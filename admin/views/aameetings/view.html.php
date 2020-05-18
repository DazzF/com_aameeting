<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			18th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		view.html.php
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
 * Aameetinglist View class for the Aameetings
 */
class AameetinglistViewAameetings extends JViewLegacy
{
	/**
	 * Aameetings view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			AameetinglistHelper::addSubmenu('aameetings');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = AameetinglistHelper::getActions('aameeting');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// load the batch html
			if ($this->canCreate && $this->canEdit && $this->canState)
			{
				$this->batchDisplay = JHtmlBatch_::render();
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_AAMEETINGLIST_AAMEETINGS'), 'joomla');
		JHtmlSidebar::setAction('index.php?option=com_aameetinglist&view=aameetings');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('aameeting.add');
		}

		// Only load if there are items
		if (AameetinglistHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('aameeting.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('aameetings.publish');
				JToolBarHelper::unpublishList('aameetings.unpublish');
				JToolBarHelper::archiveList('aameetings.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('aameetings.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = JToolBar::getInstance('toolbar');
				// set the batch button name
				$title = JText::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new JLayoutFile('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'aameetings.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('aameetings.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('aameeting.export'))
			{
				JToolBarHelper::custom('aameetings.exportData', 'download', '', 'COM_AAMEETINGLIST_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('aameeting.import'))
		{
			JToolBarHelper::custom('aameetings.importData', 'upload', '', 'COM_AAMEETINGLIST_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = AameetinglistHelper::getHelpUrl('aameetings');
		if (AameetinglistHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_AAMEETINGLIST_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_aameetinglist');
		}

		if ($this->canState)
		{
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
			// only load if batch allowed
			if ($this->canBatch)
			{
				JHtmlBatch_::addListSelection(
					JText::_('COM_AAMEETINGLIST_KEEP_ORIGINAL_STATE'),
					'batch[published]',
					JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
				);
			}
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_AAMEETINGLIST_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Aameetingnight Selection
		$this->aameetingnightOptions = $this->getTheAameetingnightSelections();
		// We do some sanitation for Aameetingnight filter
		if (AameetinglistHelper::checkArray($this->aameetingnightOptions) &&
			isset($this->aameetingnightOptions[0]->value) &&
			!AameetinglistHelper::checkString($this->aameetingnightOptions[0]->value))
		{
			unset($this->aameetingnightOptions[0]);
		}
		// Only load Aameetingnight filter if it has values
		if (AameetinglistHelper::checkArray($this->aameetingnightOptions))
		{
			// Aameetingnight Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGNIGHT_LABEL').' -',
				'filter_aameetingnight',
				JHtml::_('select.options', $this->aameetingnightOptions, 'value', 'text', $this->state->get('filter.aameetingnight'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Aameetingnight Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGNIGHT_LABEL').' -',
					'batch[aameetingnight]',
					JHtml::_('select.options', $this->aameetingnightOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_AAMEETINGLIST_AAMEETINGS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_aameetinglist/assets/css/aameetings.css", (AameetinglistHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
			// use the helper htmlEscape method instead and shorten the string
			return AameetinglistHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return AameetinglistHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'a.sorting' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.aameetingname' => JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGNAME_LABEL'),
			'a.aameetingnight' => JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGNIGHT_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheAameetingnightSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('aameetingnight'));
		$query->from($db->quoteName('#__aameetinglist_aameeting'));
		$query->order($db->quoteName('aameetingnight') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $aameetingnight)
			{
				// Translate the aameetingnight selection
				$text = $model->selectionTranslation($aameetingnight,'aameetingnight');
				// Now add the aameetingnight and its text to the options array
				$_filter[] = JHtml::_('select.option', $aameetingnight, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
