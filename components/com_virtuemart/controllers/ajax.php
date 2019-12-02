<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
//ini_set('display_errors', 1);
//ini_set('error_reporting', E_ALL);

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtuemartControllerAjax extends JControllerLegacy
{

    /**
     * Todo do we need that anylonger? that way.
     * @see JController::display()
     */
    public function display($cachable = false, $urlparams = false)  {


        $format = "json";
        $viewName='ajax';
        $view = $this->getView($viewName, $format);

        // Display it all
        $view->display();
    }

}
?>