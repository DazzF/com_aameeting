<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			19th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		default_aameetingcardgrouplayoutthree.php
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

<!--[JCBGUI.template.template.5.$$$$]-->
<!--AA Meeting Card Group Layout 2 -->

<?php 
$cardgrouprequired = true;
$cardgroupcounter = 0;

	foreach ($this->items as $item): ?>
				<?php if ($currentDay <> $item->aameetingnight) {
					$currentDay = $item->aameetingnight;
					if (!$cardgrouprequired) {
						$cardgroupcounter = 0;
						$cardgrouprequired = true;?>
							</div>
						<?php } ?>
					
					<h2 class="p-5 clearfix"><?php echo selectionTranslation($item->aameetingnight);?></h2>
				<?php } ?>
				<p></p>
				<?php if ($cardgrouprequired) { $cardgrouprequired = false;?>
					<div class="card-deck">
					<?php } ?>
					<div class="card">
						<div class="card-header" Style="height:120px;">
						<img class="card-img-top float-left p-3" style="max-width: 70px;" src="<?php echo JURI::root(true) .'/components/com_aameetinglist/assets/images/aa-Logo-70x70-trans.png';?>" alt="Card image cap">
							<h6 class="p-4"><?php echo $item->aameetingname; ?></h6>
						</div>
						<div class="card-body">
						<p>Meeting Time      : <?php echo $item->aameetingtime; ?></p>	
						<p>Zoom Meeting ID   : <?php echo $item->aameetingcode; ?></p>	
						<p>Meeting Pass Code : <?php echo $item->aameetingpasscode; ?></p>	
						<?php if ($item->aameetingcontact != '') { ?>
							<p>Contact           : <?php echo $item->aameetingcontact; ?></p>	
						<?php } ?>
						<?php if ($item->aameetingcontactphone != '') { ?>
							<p>Contact Telephone : <?php echo $item->aameetingcontactphone; ?></p>	
						<?php } ?>
						<?php if ($item->aameetingecontactemail != '') { ?>
							<p>Contact Email     : <?php echo $item->aameetingecontactemail; ?></p>	
						<?php } ?>
						</div>
					</div>
					<?php $cardgroupcounter++;?>
					<?php if ($cardgroupcounter == 2) {
						$cardgroupcounter = 0;
						$cardgrouprequired = true;?>
						</div>
					<?php } ?>
	<?php endforeach; 
	if (!$cardgrouprequired) {?>
		</div>

	<?php }
?><!--[/JCBGUI$$$$]-->

