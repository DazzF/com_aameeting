<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				West Kent Intergroup 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			18th May, 2020
	@created		15th May, 2020
	@package		AA-MeetingList
	@subpackage		aameetinglist.php
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
 * Aameetinglist Model
 */
class AameetinglistModelAameetinglist extends JModelList
{
	public function getIcons()
	{
		// load user for access menus
		$user = JFactory::getUser();
		// reset icon array
		$icons  = array();
		// view groups array
		$viewGroups = array(
			'main' => array('png.aameeting.add', 'png.aameetings')
		);
		// view access array
		$viewAccess = array(
			'aameetings.access' => 'aameeting.access',
			'aameeting.access' => 'aameeting.access',
			'aameetings.submenu' => 'aameeting.submenu',
			'aameetings.dashboard_list' => 'aameeting.dashboard_list',
			'aameeting.dashboard_add' => 'aameeting.dashboard_add');
		// loop over the $views
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (AameetinglistHelper::checkArray($views))
			{
				foreach($views as $view)
				{
					$add = false;
					// external views (links)
					if (strpos($view,'||') !== false)
					{
						$dwd = explode('||', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $url) = $dwd;
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= $url;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_AAMEETINGLIST_DASHBOARD_'.AameetinglistHelper::safeString($name,'U');
						}
					}
					// internal views
					elseif (strpos($view,'.') !== false)
					{
						$dwd = explode('.', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $action) = $dwd;
						}
						elseif (count($dwd) == 2)
						{
							list($type, $name) = $dwd;
							$action = false;
						}
						if ($action)
						{
							$viewName = $name;
							switch($action)
							{
								case 'add':
									$url 	= 'index.php?option=com_aameetinglist&view='.$name.'&layout=edit';
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_AAMEETINGLIST_DASHBOARD_'.AameetinglistHelper::safeString($name,'U').'_ADD';
									$add	= true;
								break;
								default:
									$url 	= 'index.php?option=com_categories&view=categories&extension=com_aameetinglist.'.$name;
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_AAMEETINGLIST_DASHBOARD_'.AameetinglistHelper::safeString($name,'U').'_'.AameetinglistHelper::safeString($action,'U');
								break;
							}
						}
						else
						{
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= 'index.php?option=com_aameetinglist&view='.$name;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_AAMEETINGLIST_DASHBOARD_'.AameetinglistHelper::safeString($name,'U');
							$hover		= false;
						}
					}
					else
					{
						$viewName 	= $view;
						$alt 		= $view;
						$url 		= 'index.php?option=com_aameetinglist&view='.$view;
						$image 		= $view.'.png';
						$name 		= ucwords($view).'<br /><br />';
						$hover		= false;
					}
					// first make sure the view access is set
					if (AameetinglistHelper::checkArray($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// acces checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? AameetinglistHelper::checkString($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? AameetinglistHelper::checkString($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? AameetinglistHelper::checkString($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? AameetinglistHelper::checkString($viewAccess[$viewName.'.dashboard_list']):false;
						// check for adding access
						if ($add && $accessCreate)
						{
							$accessAdd = $viewAccess[$viewName.'.create'];
						}
						elseif ($add)
						{
							$accessAdd = 'core.create';
						}
						// check if acces to view is set
						if ($accessAccess)
						{
							$accessTo = $viewAccess[$viewName.'.access'];
						}
						// set main access controllers
						if ($accessDashboard_add)
						{
							$dashboard_add	= $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_aameetinglist');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_aameetinglist');
						}
						if (AameetinglistHelper::checkString($accessAdd) && AameetinglistHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_aameetinglist') && $user->authorise($accessTo, 'com_aameetinglist') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (AameetinglistHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_aameetinglist') && $dashboard_list)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (AameetinglistHelper::checkString($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_aameetinglist') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						else
						{
							$icons[$group][$i]			= new StdClass;
							$icons[$group][$i]->url 	= $url;
							$icons[$group][$i]->name 	= $name;
							$icons[$group][$i]->image 	= $image;
							$icons[$group][$i]->alt 	= $alt;
						}
					}
					else
					{
						$icons[$group][$i]			= new StdClass;
						$icons[$group][$i]->url 	= $url;
						$icons[$group][$i]->name 	= $name;
						$icons[$group][$i]->image 	= $image;
						$icons[$group][$i]->alt 	= $alt;
					}
					$i++;
				}
			}
			else
			{
					$icons[$group][$i] = false;
			}
		}
		return $icons;
	}
}
