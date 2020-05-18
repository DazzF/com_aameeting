<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			18th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		default_aameetingtable.php
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

<!--[JCBGUI.template.template.1.$$$$]-->
<!--AA Meeting Table-->
<div class="table-responsive">
	<table class="table table-borderless mx-auto w-auto">
		<tbody>
			<?php foreach ($this->items as $item): ?>
				<tr><td> </td><td> </td></tr> <!--Blank Line-->
				<?php if ($currentDay <> $item->aameetingnight) {
					$currentDay = $item->aameetingnight; ?>
					<tr><td><h2><?php echo 	selectionTranslation($item->aameetingnight);?></h2></td><td> </td></tr>
					<tr><td> </td><td> </td></tr> <!--Blank Line-->
				<?php } ?>
				<tr>
					<td id="border-grey">Meeting Name</td>
					<td id="border-grey"><h6 class="p-1"><?php echo $item->aameetingname; ?></h6></td>
				</tr>
				<tr>
					<td id="border-grey">Meeting Time</td>
					<td id="border-grey"> <?php echo $item->aameetingtime; ?></td>
				</tr>
				<tr>
					<td id="border-grey">Zoom Meeting ID</td>
					<td id="border-grey"><?php echo $item->aameetingcode; ?></td>
				</tr>
				<tr>
					<td id="border-grey">Meeting Pass Code</td>
					<td id="border-grey"><?php echo $item->aameetingpasscode; ?></td>
				</tr>
				<?php if ($item->aameetingcontact != '') { ?>
					<tr>
						<td id="border-grey">Contact</td>
						<td id="border-grey"><?php echo $item->aameetingcontact; ?></td>
					</tr>
				<?php } ?>
				<?php if ($item->aameetingcontactphone != '') { ?>
					<tr>
						<td id="border-grey">Contact Telephone</td>
						<td id="border-grey"><?php echo $item->aameetingcontactphone; ?></td>
					</tr>
				<?php } ?>
				<?php if ($item->aameetingecontactemail != '') { ?>
					<tr>
						<td id="border-grey">Contact Email</td>
					<td id="border-grey"><?php echo $item->aameetingecontactemail; ?></td>
				</tr>
				<?php } ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div><!--[/JCBGUI$$$$]-->

