<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			18th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		default_head.php
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

?>
<tr>
	<?php if ($this->canEdit&& $this->canState): ?>
		<th width="1%" class="nowrap center hidden-phone">
			<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
		</th>
		<th width="20" class="nowrap center">
			<?php echo JHtml::_('grid.checkall'); ?>
		</th>
	<?php else: ?>
		<th width="20" class="nowrap center hidden-phone">
			&#9662;
		</th>
		<th width="20" class="nowrap center">
			&#9632;
		</th>
	<?php endif; ?>
	<th class="nowrap" >
			<?php echo JHtml::_('grid.sort', 'COM_AAMEETINGLIST_AAMEETING_AAMEETINGNAME_LABEL', 'aameetingname', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGTIME_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_AAMEETINGLIST_AAMEETING_AAMEETINGNIGHT_LABEL', 'aameetingnight', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGCODE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGPASSCODE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGCONTACT_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_AAMEETINGECONTACTEMAIL_LABEL'); ?>
	</th>
	<?php if ($this->canState): ?>
		<th width="10" class="nowrap center" >
			<?php echo JHtml::_('grid.sort', 'COM_AAMEETINGLIST_AAMEETING_STATUS', 'published', $this->listDirn, $this->listOrder); ?>
		</th>
	<?php else: ?>
		<th width="10" class="nowrap center" >
			<?php echo JText::_('COM_AAMEETINGLIST_AAMEETING_STATUS'); ?>
		</th>
	<?php endif; ?>
	<th width="5" class="nowrap center hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_AAMEETINGLIST_AAMEETING_ID', 'id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>