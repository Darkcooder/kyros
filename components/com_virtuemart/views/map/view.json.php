<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(VMPATH_SITE.DS.'helpers'.DS.'vmview.php');

class VirtuemartViewMap extends VmView {

var $jsonInput;
var $jsonOutput;
var $intentModel;
var $currentUser;
var $intentId;

    public function display($tpl = null) {

    $this->setLayout('json');
    $this->intentModel = VmModel::getModel('sources');
    $this->currentUser = JFactory::getUser();
    $this->jsonInput=json_decode(vRequest::getCmd("data", ""));

    $layout=vRequest::getCmd("layout", "");
    $action=vRequest::getCmd("action", "");
    $this->jsonOutput=new stdClass();


    if(is_callable(array($this->intentModel, $action))) $this->jsonOutput=$this->intentModel->$action();
    //echo "hi";


 return parent::display($tpl); // TODO: Change the autogenerated stub
}

}
?>