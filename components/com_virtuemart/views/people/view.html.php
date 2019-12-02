<?php
/**
 *
 * Handle the people view
 *
 * @package	IntentGuide
 * @subpackage People
 * @author Vladimir Bugorkov
 * @link http://www.virtuemart.net
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(VMPATH_SITE.DS.'helpers'.DS.'vmview.php');


/**
 * Handle the people view
 */
class VirtueMartViewPeople extends VmView {

	public function display($tpl = null)
	{
        $layoutName = vRequest::getCmd('layout', 'info');
        $intentId = vRequest::getCmd('people_id', '0');
        $document = JFactory::getDocument();
        $this->setLayout($layoutName);

        $this->currentUser = JFactory::getUser();
		$document = JFactory::getDocument();
		$document->addScript("/js/jquery-3.0.0.js");
		$document->addScript("/js/wxdata.js");
        $document->addScript("/js/views/forms.js");
        $document->addScript("/js/elements/icons.js");
        $document->addScript("/js/elements/igtable.js");
        $document->addScript("/js/views/datatable.js");
        $document->addScript("/js/views/igframe.js");
        $document->addScript("/js/views/stateform.js");
        $document->addScript("/js/elements/iglist.js");
        $document->addScript("/js/igview.js");
        $document->addScript("/js/lng/ru/peoples.js");
        //$document->addScript("http://maps.google.com/maps/api/js?sensor=false");
		$this->ajaxWay='index.php?option=com_virtuemart&view=map&format=json';


        switch ($layoutName){

            case "info":
            $document->setTitle( vmText::_('COM_IGUIDE_PEOPLE_INFO_TITLE') );
            break;

        }

        parent::display($tpl);
    }

}?>