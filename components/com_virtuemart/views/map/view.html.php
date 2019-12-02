<?php
//ini_set('display_errors', 1);
/**
 *
 * Handle the orders view
 *
 * @package	VirtueMart
 * @subpackage Orders
 * @author Oscar van Eijk, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 9075 2015-12-02 13:56:15Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(VMPATH_SITE.DS.'helpers'.DS.'vmview.php');


/**
 * Handle the orders view
 */
class VirtuemartViewMap extends VmView {
	var $currentUser;
	var $ajaxWay;

	public function display($tpl = null)
	{

		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();
		$task = vRequest::getCmd('task', 'list');

// ???????? ?????????: ??? layout ? ????????????? ????

		$layoutName = vRequest::getCmd('layout', 'list');
        $intentId = vRequest::getCmd('intent_id', '0');

		//$this->setLayout($layoutName);

		$this->currentUser = JFactory::getUser();
		$document = JFactory::getDocument();
		$document->addScript("/js/jquery.js");
		//$document->addScript("http://code.jquery.com/jquery-1.8.3.js");
		$document->addScript("/js/jquery.timer.js");

        $document->addStyleSheet("/js/ui/jquery-ui.structure.css");
        $document->addStyleSheet("/js/ui/jquery-ui.theme.css");
		$document->addScript("/js/ui/jquery-ui.js");


		$document->addScript("/js/wxdata.js");
		$document->addScript("/js/wxdiv.js");
		$document->addScript("/js/wxform.js");
		$document->addScript("/js/wxmenu.js");
		$document->addScript("/js/wxsettings.js");
		$document->addScript("/js/wxnoticebar.js");
        $document->addScript("/js/views/forms.js");
        $document->addScript("/js/elements/icons.js");
        $document->addScript("/js/elements/igtable.js");
        $document->addScript("/js/elements/iglist.js");
        $document->addScript("/js/views/datatable.js");
        $document->addScript("/js/views/igframe.js?k=09");
        $document->addScript("/js/views/stateform.js");
        $document->addScript("/js/views/gmap.js?k=3");
        $document->addScript("/js/igview.js");
        $document->addScript("/js/lng/ru/map.js");
        $document->addScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBPYR4tRGxM5FAGnmlqJTpO7DbhmPU4W8c");
        //$document->addScript("http://maps.google.com/maps/api/js?sensor=false");
		$this->ajaxWay='/ajax/';

		if(!empty($tpl)){
			$format = $tpl;
		} else {
			$format = vRequest::getCmd('format', 'html');
		}
		$this->assignRef('format', $format);


// ????????? ?????? ??????

		$this->metodicModel=VmModel::getModel('metodic');
        $this->intentModel = VmModel::getModel('intent');

        $this->setLayout("default");
		parent::display($tpl);
	}

	function prepareVendor(){

		$vendorModel = VmModel::getModel('vendor');
		$vendor =  $vendorModel->getVendor();
		$this->assignRef('vendor', $vendor);
		$vendorModel->addImages($this->vendor,1);

	}

}
?>