<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			19th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		default.php
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
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.26.$$$$]-->
<?php

function selectionTranslation($value)
{

	$aameetingnightArray = array(
			1 => 'MONDAY',
			2 => 'TUESDAY',
			3 => 'WEDNESDAY',
			4 => 'THURSDAY',
			5 => 'FRIDAY',
			6 => 'SATURDAY',
			7 => 'SUNDAY'
	);
	// Now check if value is found in this array
	if (isset($aameetingnightArray[$value]) && AameetinglistHelper::checkString($aameetingnightArray[$value])) {
		return $aameetingnightArray[$value];
	}
	return $value;
}

?>

<h1 style="text-align: center;"><?php echo $this->params->get('aameetingfrontendviewheading');?></h1>
<p style="text-align: center;"><?php echo $this->params->get('aameetingfrontendviewmessage');?></p>

<?php

	$aameetingviewlist = $this->params->get('aameetingviewlist');

	switch ($aameetingviewlist) {
		case 1:
			echo $this->loadTemplate('aameetingcardsimple'); 
	  		break;
		case 2:
			echo $this->loadTemplate('aameetingcardgrouplayoutone'); 
	  		break;
		case 3:
			echo $this->loadTemplate('aameetingcardgrouplayoutthree'); 
	  		break;
		default:
		echo $this->loadTemplate('aameetingtable');
  }
?><!--[/JCBGUI$$$$]-->

