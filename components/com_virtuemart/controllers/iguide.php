<?php
/**
 *
 * Controller for the front end Orderviews
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: orders.php 7821 2014-04-08 11:07:57Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtueMartControllerIguide extends JControllerLegacy
{

	/**
	 * Todo do we need that anylonger? that way.
	 * @see JController::display()
	 */
	public function display($cachable = false, $urlparams = false)  {

		$viewName= vRequest::getCmd('view','metodics');
        $format = vRequest::getCmd('format','html');
		VmConfig::loadJLang('com_iguide_metodic',TRUE);
		VmConfig::loadJLang('com_iguide_intent',TRUE);
		$view = $this->getView($viewName, $format);

		// Display it all
		$view->display();
	}

    public function getLinkString($params){
        $linkBase="/?option=com_virtuemart&controller=iguide";
        foreach ($params as $key=>$value){
            $linkBase=$linkBase."&".$key."=".$value;
        }
        return $linkBase;
    }

}

// No closing tag
