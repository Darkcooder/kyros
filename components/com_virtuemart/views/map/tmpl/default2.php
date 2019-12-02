<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
/**
*
* Order detail view
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk, Valerie Isaksen
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: details.php 8832 2015-04-15 16:05:49Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
//JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/');

$structureIsEmpty=true;

?>
<div id="notices" class="horisontalList"></div>
<div id="map" class="bigMap"></div>
<script type="text/javascript" language="javaScript">
    var ajax_url='<?php echo $this->ajaxWay?>';
    WXAddCorrDiv($("#top-navigation-bar"));
    WXAddCorrDiv($("#notices"));
     //var map=igView("GMap", $("#map"), []);
     var map={__proto__:igMap,
     frameClass: "bigMap",
     makeBlock: function(i, data, main){
       return ListItem(this.list, Location(main, data), data);
     }};
     map.update();
     //ExMapList($("#notices"), "notices");
     //$.timer(function(){ExMapList($("#notices"), "notices");}).set({time:5000, autostart:true});
     //$.timer(map.update.bind(map)).set({time: 10000, autostart: true});

</script>